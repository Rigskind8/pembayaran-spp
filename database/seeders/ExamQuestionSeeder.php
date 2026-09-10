<?php

namespace Database\Seeders;

use App\Models\ExamQuestion;
use App\Models\Subject;
use Database\Seeders\QuestionBanks\GeneralQuestionBank;
use Database\Seeders\QuestionBanks\TkrQuestionBank;
use Database\Seeders\QuestionBanks\TkjQuestionBank;
use Illuminate\Database\Seeder;

class ExamQuestionSeeder extends Seeder
{
    private const QUESTION_COUNT_PER_TYPE = 5;

    public function run(): void
    {
        $subjects = Subject::active()->get();

        foreach ($subjects as $subject) {
            $this->syncQuestionsForType($subject->id, $subject->name, 'uts');
            $this->syncQuestionsForType($subject->id, $subject->name, 'uas');
        }

        ExamQuestion::where('is_active', true)
            ->whereIn('type', ['uts', 'uas'])
            ->update(['points' => 20]);
    }

    private function syncQuestionsForType(int $subjectId, string $subjectName, string $type): void
    {
        $templates = $this->questionTemplates($subjectName, $type);
        $activeIds = [];

        for ($order = 1; $order <= self::QUESTION_COUNT_PER_TYPE; $order++) {
            $template = $this->balanceQuestion($templates[$order - 1], $order, $subjectId, $type);

            $question = ExamQuestion::updateOrCreate(
                [
                    'subject_id' => $subjectId,
                    'type' => $type,
                    'sort_order' => $order,
                ],
                [
                    'question'       => $template['question'],
                    'options'        => $template['options'],
                    'correct_answer' => $template['correct_answer'],
                    'points'         => 20,
                    'is_active'      => true,
                ]
            );

            $activeIds[] = $question->id;
        }

        ExamQuestion::where('subject_id', $subjectId)
            ->where('type', $type)
            ->whereNotIn('id', $activeIds)
            ->update(['is_active' => false]);
    }

    private function balanceQuestion(array $q, int $order, int $subjectId, string $type): array
    {
        $patterns = [
            ['b', 'c', 'a', 'd', 'b'],
            ['c', 'a', 'd', 'b', 'c'],
            ['a', 'd', 'b', 'c', 'a'],
            ['d', 'b', 'c', 'a', 'd'],
            ['b', 'a', 'd', 'c', 'b'],
            ['c', 'd', 'a', 'b', 'c'],
        ];

        $patternIndex = ($subjectId + ($type === 'uts' ? 0 : 3)) % count($patterns);
        $targetKey = $patterns[$patternIndex][($order - 1) % 5];
        $currentKey = $q['correct_answer'] ?? 'a';

        if ($targetKey === $currentKey) {
            return $q;
        }

        $options = $q['options'];
        if (isset($options[$targetKey], $options[$currentKey])) {
            $temp = $options[$targetKey];
            $options[$targetKey] = $options[$currentKey];
            $options[$currentKey] = $temp;

            $q['options'] = $options;
            $q['correct_answer'] = $targetKey;
        }

        return $q;
    }

    private function questionTemplates(string $subjectName, string $type): array
    {
        $baseName = trim(preg_replace('/\s*\([^)]*\)$/', '', $subjectName));

        $questions = GeneralQuestionBank::getQuestions($baseName, $type)
            ?? TkrQuestionBank::getQuestions($baseName, $type)
            ?? TkjQuestionBank::getQuestions($baseName, $type);

        if ($questions && count($questions) >= self::QUESTION_COUNT_PER_TYPE) {
            return array_slice($questions, 0, self::QUESTION_COUNT_PER_TYPE);
        }

        return $type === 'uts'
            ? $this->fallbackKurikulumUts($subjectName)
            : $this->fallbackKurikulumUas($subjectName);
    }

    private function fallbackKurikulumUts(string $subjectName): array
    {
        return [
            [
                'question' => "Dalam menganalisis studi kasus pemecahan masalah pada materi {$subjectName}, langkah awal yang paling sistematis adalah ...",
                'options' => [
                    'a' => 'Menentukan kesimpulan akhir tanpa analisis',
                    'b' => 'Mengidentifikasi akar permasalahan dan mengumpulkan data fakta yang relevan',
                    'c' => 'Mengabaikan petunjuk kerja yang ada',
                    'd' => 'Menyalin jawaban dari kelompok lain',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => "Tindakan yang mencerminkan penerapan etika profesional dan integritas kerja pada {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Memalsukan laporan demi hasil cepat',
                    'b' => 'Menghindari tanggung jawab tugas individu',
                    'c' => 'Bekerja secara jujur, bertanggung jawab, dan mematuhi Prosedur Operasional Standar (SOP)',
                    'd' => 'Mengabaikan keselamatan rekan satu tim',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => "Penerapan keselamatan dan kesehatan kerja (K3) yang tepat saat beraktivitas pada mapel {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Menaruh peralatan kerja secara berserakan di lorong jalan',
                    'b' => 'Bercanda berlebihan saat mengoperasikan perangkat kerja',
                    'c' => 'Mengabaikan rambu peringatan bahaya di ruangan',
                    'd' => 'Mengenakan Alat Pelindung Diri (APD) lengkap dan memeriksa kelayakan alat sebelum digunakan',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => "Saat menginterpretasikan data grafik atau tabel teknis pada {$subjectName}, hal penting yang harus diperhatikan adalah ...",
                'options' => [
                    'a' => 'Membaca label sumbu, satuan pengukuran, dan tren perubahan data secara teliti',
                    'b' => 'Menebak angka tanpa melihat legenda grafik',
                    'c' => 'Hanya melihat warna grafik tanpa memperhatikan data',
                    'd' => 'Mengubah data agar sesuai dengan asumsi awal pribadi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Strategi manajemen waktu yang efektif dalam menyelesaikan proyek kelompok {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Menunda seluruh pekerjaan hingga satu hari sebelum tenggat waktu',
                    'b' => 'Mengerjakan proyek tanpa pembagian tugas yang jelas',
                    'c' => 'Membuat garis waktu (timeline) kerja dan membagi peran tugas anggota secara berkeadilan',
                    'd' => 'Menyerahkan seluruh beban pekerjaan hanya kepada ketua kelompok',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    private function fallbackKurikulumUas(string $subjectName): array
    {
        return [
            [
                'question' => "Pada evaluasi akhir proyek {$subjectName}, indikator kendali mutu (Quality Control) yang harus dipenuhi adalah ...",
                'options' => [
                    'a' => 'Produk atau hasil kerja memenuhi standar spesifikasi teknis dan berfungsi optimal dengan aman',
                    'b' => 'Biaya pembuatan melebihi anggaran yang direncanakan tanpa laporan',
                    'c' => 'Hasil pekerjaan tidak perlu diuji kelayakannya',
                    'd' => 'Tampilan luar mewah meskipun fungsi utamanya gagal',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Format penyusunan laporan pertanggungjawaban teknis pada mata pelajaran {$subjectName} yang baku memuat ...",
                'options' => [
                    'a' => 'Hanya foto dokumentasi tanpa analisis data',
                    'b' => 'Pendahuluan, dasar teori, metodologi pelaksanaan, hasil pengujian, dan simpulan saran',
                    'c' => 'Daftar keluhan pribadi anggota tim',
                    'd' => 'Salinan artikel blog internet tanpa sitasi sumber',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => "Sikap kepemimpinan dan kerja sama tim yang ideal dalam menyelesaikan asesmen akhir {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Memaksakan kehendak sepihak kepada seluruh anggota tim',
                    'b' => 'Tidak hadir dalam diskusi kelompok',
                    'c' => 'Komunikasi terbuka secara asertif, saling menghargai gagasan, dan fokus pada target bersama',
                    'd' => 'Menyalahkan rekan saat terjadi kendala teknis',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => "Prinsip efisiensi sumber daya dan keberlanjutan (sustainability) dalam praktik kerja {$subjectName} diwujudkan dengan ...",
                'options' => [
                    'a' => 'Membuang sisa material kerja tanpa pemilahan',
                    'b' => 'Membiarkan peralatan listrik menyala terus menerus saat tidak digunakan',
                    'c' => 'Mengoptimalkan pemakaian material, meminimalkan limbah, dan mendaur ulang bahan sisa layak pakai',
                    'd' => 'Membeli alat baru sekali pakai untuk setiap tugas',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => "Setelah menyelesaikan evaluasi sumatif akhir semester pada mapel {$subjectName}, langkah perbaikan diri yang tepat adalah ...",
                'options' => [
                    'a' => 'Mengabaikan hasil umpan balik dan catatan dari penguji',
                    'b' => 'Menolak mempelajari kembali materi yang belum dikuasai',
                    'c' => 'Menghubungi teman hanya untuk membandingkan nilai tanpa belajar',
                    'd' => 'Melakukan refleksi atas kelemahan diri dan merancang rencana peningkatan kompetensi lanjutan',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }
}
