Artisan::command('cek:ujian-subject-miss', function () {
    $ujians = Ujian::where('status', 'verified')
        ->whereNull('subject_id')
        ->get();
    $subjects = Subject::active()->pluck('name')->map(fn($n) => strtoupper(trim($n)))->toArray();
    $this->info("Daftar Ujian Verified yang subject_id-nya masih kosong dan gagal match:");
    foreach ($ujians as $ujian) {
        $mpNorm = strtoupper(trim($ujian->mata_pelajaran));
        $found = false;
        foreach ($subjects as $sNorm) {
            if ($sNorm !== '' && (str_contains($mpNorm, $sNorm) || str_contains($sNorm, $mpNorm))) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->line("ID: $ujian->id | User: $ujian->user_id | Mapel: $ujian->mata_pelajaran");
        }
    }
    $this->info("Selesai.");
})->describe('Cek data ujian verified yang gagal match subject_id');
<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\Ujian;
use App\Models\Subject;

Artisan::command('fix:ujian-subject', function () {
    $count = 0;
    $ujians = Ujian::where('status', 'verified')
        ->whereNull('subject_id')
        ->get();

    foreach ($ujians as $ujian) {
        if (!$ujian->mata_pelajaran) continue;
        $mpNorm = Str::upper(trim($ujian->mata_pelajaran));
        $found = Subject::active()->get()->first(function ($subject) use ($mpNorm) {
            $sNorm = Str::upper(trim($subject->name));
            return $sNorm !== '' && (Str::contains($mpNorm, $sNorm) || Str::contains($sNorm, $mpNorm));
        });
        if ($found) {
            Ujian::where('id', $ujian->id)->update(['subject_id' => $found->id]);
            $count++;
            $this->info("Ujian #{$ujian->id} updated: subject_id => {$found->id}");
        }
    }
    $this->info("Done. Updated $count ujian records.");
})->describe('Update subject_id for verified ujian with missing subject_id');
