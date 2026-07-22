<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        // Mark existing subjects inactive so we can seed new active SMK subjects
        try {
            Subject::query()->update(['is_active' => false]);
        } catch (\Throwable $e) {
            // ignore if column missing or other DB constraint
        }

        $majors = ['TKR', 'TKJ'];
        $grades = ['X', 'XI', 'XII'];

        $tkrSubjects = [
            ['name' => 'Pengantar Otomotif', 'code' => 'POT', 'hours_per_week' => 6, 'teacher' => 'Pak Budi'],
            ['name' => 'Dasar Teknik Otomotif', 'code' => 'DTO', 'hours_per_week' => 6, 'teacher' => 'Pak Ahmad'],
            ['name' => 'Sistem Kelistrikan', 'code' => 'SKL', 'hours_per_week' => 4, 'teacher' => 'Bu Sari'],
            ['name' => 'Praktikum Bengkel', 'code' => 'PBK', 'hours_per_week' => 6, 'teacher' => 'Pak Eko'],
            ['name' => 'Gambar Teknik Otomotif', 'code' => 'GTO', 'hours_per_week' => 3, 'teacher' => 'Bu Ratna'],
            ['name' => 'Matematika Teknik', 'code' => 'MTK', 'hours_per_week' => 4, 'teacher' => 'Pak Rudi'],
            ['name' => 'Mesin Bensin', 'code' => 'MBN', 'hours_per_week' => 5, 'teacher' => 'Pak Yusuf'],
            ['name' => 'Mesin Diesel', 'code' => 'MDL', 'hours_per_week' => 5, 'teacher' => 'Pak Sigit'],
            ['name' => 'Sistem Bahan Bakar', 'code' => 'SBB', 'hours_per_week' => 4, 'teacher' => 'Bu Lilis'],
            ['name' => 'Transmisi & Kopling', 'code' => 'TRK', 'hours_per_week' => 4, 'teacher' => 'Pak Doni'],
            ['name' => 'Suspensi & Kemudi', 'code' => 'SPK', 'hours_per_week' => 4, 'teacher' => 'Bu Maya'],
            ['name' => 'Perawatan Berkala', 'code' => 'PRB', 'hours_per_week' => 3, 'teacher' => 'Pak Agung'],
            ['name' => 'Diagnostik Kendaraan', 'code' => 'DGK', 'hours_per_week' => 5, 'teacher' => 'Pak Hendra'],
            ['name' => 'Body Repair', 'code' => 'BDR', 'hours_per_week' => 4, 'teacher' => 'Bu Novi'],
            ['name' => 'Teknik Pendingin & AC', 'code' => 'TPA', 'hours_per_week' => 3, 'teacher' => 'Pak Bambang'],
            ['name' => 'K3 Otomotif', 'code' => 'K3O', 'hours_per_week' => 2, 'teacher' => 'Bu Rina'],
            ['name' => 'Elektronika Otomotif', 'code' => 'ELO', 'hours_per_week' => 3, 'teacher' => 'Pak Riko'],
            ['name' => 'Teknik Pengelasan Otomotif', 'code' => 'TPO', 'hours_per_week' => 3, 'teacher' => 'Bu Siska'],
            // Additional TKR specializations
            ['name' => 'Sistem Emisi Kendaraan', 'code' => 'SEM', 'hours_per_week' => 3, 'teacher' => 'Pak Ilham'],
            ['name' => 'Elektronika Kontrol Mesin', 'code' => 'EKM', 'hours_per_week' => 4, 'teacher' => 'Bu Wulan'],
            ['name' => 'Sistem Injeksi & EFI', 'code' => 'SBI', 'hours_per_week' => 4, 'teacher' => 'Pak Rahmat'],
            ['name' => 'Manajemen Bengkel', 'code' => 'MNB', 'hours_per_week' => 2, 'teacher' => 'Bu Yuni'],
            ['name' => 'Pengelolaan Suku Cadang', 'code' => 'PSC', 'hours_per_week' => 2, 'teacher' => 'Pak Dedi'],
            ['name' => 'Diagnostik Komputer Mobil', 'code' => 'DKM', 'hours_per_week' => 4, 'teacher' => 'Pak Aris'],
            ['name' => 'Sistem Hybrid & EV', 'code' => 'HEV', 'hours_per_week' => 4, 'teacher' => 'Bu Tika'],
            ['name' => 'Teknik Suspensi Lanjutan', 'code' => 'TSL', 'hours_per_week' => 3, 'teacher' => 'Pak Endra'],
            ['name' => 'Simulasi Kendaraan & CAD', 'code' => 'SIM', 'hours_per_week' => 3, 'teacher' => 'Bu Indri'],
            ['name' => 'Entrepreneurship Otomotif', 'code' => 'ENO', 'hours_per_week' => 2, 'teacher' => 'Pak Nizar'],
        ];

        $tkjSubjects = [
            ['name' => 'Pengantar Jaringan', 'code' => 'PJG', 'hours_per_week' => 6, 'teacher' => 'Pak Joko'],
            ['name' => 'Pemrograman Dasar', 'code' => 'PMD', 'hours_per_week' => 5, 'teacher' => 'Bu Dina'],
            ['name' => 'Sistem Operasi Jaringan', 'code' => 'SON', 'hours_per_week' => 4, 'teacher' => 'Pak Agus'],
            ['name' => 'Administrasi Server', 'code' => 'ADS', 'hours_per_week' => 4, 'teacher' => 'Bu Hani'],
            ['name' => 'Keamanan Jaringan', 'code' => 'KJ', 'hours_per_week' => 3, 'teacher' => 'Pak Rian'],
            ['name' => 'Pemrograman Web', 'code' => 'PW', 'hours_per_week' => 4, 'teacher' => 'Bu Indah'],
            ['name' => 'Basis Data', 'code' => 'BDT', 'hours_per_week' => 4, 'teacher' => 'Pak Arman'],
            ['name' => 'Jaringan Nirkabel', 'code' => 'JNW', 'hours_per_week' => 3, 'teacher' => 'Bu Fitri'],
            ['name' => 'Pemrograman Mobile', 'code' => 'PMB', 'hours_per_week' => 4, 'teacher' => 'Pak Roni'],
            ['name' => 'Internet of Things', 'code' => 'IOT', 'hours_per_week' => 3, 'teacher' => 'Bu Sinta'],
            ['name' => 'Virtualisasi & Cloud', 'code' => 'VCL', 'hours_per_week' => 3, 'teacher' => 'Pak Dedi'],
            ['name' => 'Troubleshooting Jaringan', 'code' => 'TRB', 'hours_per_week' => 4, 'teacher' => 'Bu Ria'],
            ['name' => 'Routing & Switching', 'code' => 'RSW', 'hours_per_week' => 4, 'teacher' => 'Pak Edi'],
            ['name' => 'Ethical Hacking Dasar', 'code' => 'EHD', 'hours_per_week' => 2, 'teacher' => 'Bu Nia'],
            ['name' => 'Manajemen Proyek IT', 'code' => 'MPI', 'hours_per_week' => 2, 'teacher' => 'Pak Tono'],
            ['name' => 'Multimedia & Desain', 'code' => 'MMD', 'hours_per_week' => 3, 'teacher' => 'Bu Vina'],
            ['name' => 'Sistem Tertanam', 'code' => 'STM', 'hours_per_week' => 3, 'teacher' => 'Pak Yudha'],
            ['name' => 'DevOps Dasar', 'code' => 'DVS', 'hours_per_week' => 3, 'teacher' => 'Bu Laily'],
            // Additional TKJ topics
            ['name' => 'Frameworks Web (Laravel)', 'code' => 'LRV', 'hours_per_week' => 3, 'teacher' => 'Pak Fajar'],
            ['name' => 'Node.js & Backend', 'code' => 'NDJ', 'hours_per_week' => 3, 'teacher' => 'Bu Reni'],
            ['name' => 'Python untuk Jaringan', 'code' => 'PYJ', 'hours_per_week' => 3, 'teacher' => 'Pak Dimas'],
            ['name' => 'Data Analytics Dasar', 'code' => 'DAT', 'hours_per_week' => 3, 'teacher' => 'Bu Ayu'],
            ['name' => 'Machine Learning Dasar', 'code' => 'MLD', 'hours_per_week' => 3, 'teacher' => 'Pak Hadi'],
            ['name' => 'AI untuk IT', 'code' => 'AIT', 'hours_per_week' => 2, 'teacher' => 'Bu Sari'],
            ['name' => 'Game Development', 'code' => 'GMD', 'hours_per_week' => 3, 'teacher' => 'Pak Riko'],
            ['name' => 'UI/UX Desain', 'code' => 'UXD', 'hours_per_week' => 2, 'teacher' => 'Bu Nita'],
            ['name' => 'Cloud Security', 'code' => 'CYS', 'hours_per_week' => 3, 'teacher' => 'Pak Seno'],
            ['name' => 'Blockchain Basics', 'code' => 'BCB', 'hours_per_week' => 2, 'teacher' => 'Bu Widi'],
            ['name' => 'Automation Scripting', 'code' => 'ASR', 'hours_per_week' => 3, 'teacher' => 'Pak Bram'],
            ['name' => 'Mobile App Advanced', 'code' => 'MAD', 'hours_per_week' => 3, 'teacher' => 'Bu Lilis'],
            ['name' => 'Pengelolaan Infrastruktur IT', 'code' => 'PIT', 'hours_per_week' => 3, 'teacher' => 'Pak Galih'],
        ];

        // Common / general subjects that should exist for every major/class
        $commonSubjects = [
            // Consolidated agama subject to avoid exposing multiple religions per siswa
            ['name' => 'Pendidikan Agama', 'code' => 'AGM', 'hours_per_week' => 2, 'teacher' => 'Guru Agama'],
            ['name' => 'Pendidikan Pancasila & Kewarganegaraan', 'code' => 'PPK', 'hours_per_week' => 2, 'teacher' => 'Pak Slamet'],
            ['name' => 'Bahasa Indonesia', 'code' => 'BID', 'hours_per_week' => 4, 'teacher' => 'Bu Wati'],
            ['name' => 'Bahasa Inggris', 'code' => 'BIG', 'hours_per_week' => 3, 'teacher' => 'Pak Daniel'],
            ['name' => 'Sejarah Indonesia', 'code' => 'SEI', 'hours_per_week' => 2, 'teacher' => 'Bu Reni'],
            ['name' => 'Seni Budaya', 'code' => 'SBD', 'hours_per_week' => 2, 'teacher' => 'Bu Ayu'],
            ['name' => 'Pendidikan Jasmani, Olahraga & Kesehatan', 'code' => 'PJOK', 'hours_per_week' => 2, 'teacher' => 'Pak Tono'],
            ['name' => 'Prakarya & Kewirausahaan', 'code' => 'PRK', 'hours_per_week' => 2, 'teacher' => 'Bu Mira'],
            ['name' => 'Teknologi Informasi & Komunikasi', 'code' => 'TIK', 'hours_per_week' => 3, 'teacher' => 'Pak Bima'],
            ['name' => 'Bimbingan Konseling', 'code' => 'BK', 'hours_per_week' => 1, 'teacher' => 'Bu Lita'],
            ['name' => 'Muatan Lokal', 'code' => 'MUL', 'hours_per_week' => 2, 'teacher' => 'Guru Muatan Lokal'],
        ];

        $subjects = [];

        foreach ($majors as $major) {
            foreach ($grades as $grade) {
                $classId = $grade . ' - ' . $major;
                $classCode = strtoupper(preg_replace('/[^A-Z0-9]+/i', '', $classId));

                $base = $major === 'TKR' ? $tkrSubjects : $tkjSubjects;
                $combined = array_merge($base, $commonSubjects);

                foreach ($combined as $s) {
                    $subjects[] = [
                        'name' => $s['name'] . ' (' . $classId . ')',
                        'code' => $classCode . '-' . strtoupper($s['code']),
                        'class_id' => $classId,
                        'hours_per_week' => $s['hours_per_week'],
                        'teacher' => $s['teacher'],
                        'is_active' => true,
                    ];
                }
            }
        }

        foreach ($subjects as $subject) {
            Subject::updateOrCreate(['code' => $subject['code']], $subject);
        }
    }
}