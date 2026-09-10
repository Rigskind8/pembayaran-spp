<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'number',
        'letter_date',
        'sender',
        'recipient',
        'subject',
        'description',
        'status',
        'attachment',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'letter_date' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dispositions(): HasMany
    {
        return $this->hasMany(SuratDisposition::class)->latest();
    }

    /**
     * Generate the next sequential number for an outgoing letter.
     * Format: 001/KODE/BULAN_ROMAWI/TAHUN
     */
    public static function generateNextNumber(): string
    {
        $currentYear = date('Y');
        $currentMonthRoman = self::toRoman(date('n'));
        $schoolCode = Setting::get('kode_surat', 'SMK-TP'); // Ambil dari settings, fallback ke 'SMK-TP'

        // Cari nomor urut terakhir di tahun ini
        $lastLetter = self::where('type', 'keluar')
            ->whereYear('letter_date', $currentYear)
            ->select('number', DB::raw('CAST(SUBSTRING_INDEX(number, "/", 1) AS UNSIGNED) as sequence'))
            ->orderByDesc('sequence')
            ->first();

        $nextSequence = 1;
        if ($lastLetter) {
            $lastSequence = (int) explode('/', (string) $lastLetter->number)[0];
            $nextSequence = $lastSequence + 1;
        }

        $paddedSequence = str_pad((string) $nextSequence, 3, '0', STR_PAD_LEFT);

        return "{$paddedSequence}/{$schoolCode}/{$currentMonthRoman}/{$currentYear}";
    }

    /**
     * Convert an integer to its Roman numeral representation.
     */
    private static function toRoman(int $number): string
    {
        $map = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'masuk' ? 'Surat Masuk' : 'Surat Keluar';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'arsip' => 'Arsip',
            default => 'Baru',
        };
    }
}
