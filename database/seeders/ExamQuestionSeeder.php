<?php

namespace Database\Seeders;

use App\Models\ExamQuestion;
use App\Models\Subject;
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
            $template = $templates[$order - 1];

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

    private function questionTemplates(string $subjectName, string $type): array
    {
        $category = $this->detectSubjectCategory($subjectName);

        if ($category === 'matematika') {
            return $type === 'uts'
                ? $this->matematikaUts($subjectName)
                : $this->matematikaUas($subjectName);
        }

        if ($category === 'bahasa_indonesia') {
            return $type === 'uts'
                ? $this->bahasaIndonesiaUts($subjectName)
                : $this->bahasaIndonesiaUas($subjectName);
        }

        if ($category === 'bahasa_inggris') {
            return $type === 'uts'
                ? $this->bahasaInggrisUts($subjectName)
                : $this->bahasaInggrisUas($subjectName);
        }

        if ($category === 'pkwu') {
            return $type === 'uts'
                ? $this->pkwuUts($subjectName)
                : $this->pkwuUas($subjectName);
        }

        if ($category === 'produktif_tkj') {
            return $type === 'uts'
                ? $this->produktifTkjUts($subjectName)
                : $this->produktifTkjUas($subjectName);
        }

        if ($category === 'ppkn') {
            return $type === 'uts'
                ? $this->ppknUts($subjectName)
                : $this->ppknUas($subjectName);
        }

        if ($type === 'uts') {
            return [
                [
                    'question' => "Pada mapel {$subjectName}, konsep yang paling tepat adalah ...",
                    'options' => [
                        'a' => 'Memahami konsep inti lalu menerapkannya pada contoh',
                        'b' => 'Menghafal istilah tanpa latihan',
                        'c' => 'Menebak jawaban tanpa membaca soal',
                        'd' => 'Mengabaikan langkah kerja yang benar',
                    ],
                    'correct_answer' => 'a',
                ],
                [
                    'question' => "Tujuan UTS pada mapel {$subjectName} adalah ...",
                    'options' => [
                        'a' => 'Menilai capaian belajar di pertengahan semester',
                        'b' => 'Menghapus kewajiban tugas proyek',
                        'c' => 'Menentukan kelulusan akhir langsung',
                        'd' => 'Menggantikan seluruh nilai semester',
                    ],
                    'correct_answer' => 'a',
                ],
                [
                    'question' => "Saat menemukan soal sulit {$subjectName}, langkah paling tepat adalah ...",
                    'options' => [
                        'a' => 'Lewati sementara lalu kembali setelah soal lain selesai',
                        'b' => 'Menghentikan ujian sebelum waktunya',
                        'c' => 'Menjawab acak semua nomor tersisa',
                        'd' => 'Mengikuti jawaban teman tanpa analisis',
                    ],
                    'correct_answer' => 'a',
                ],
                [
                    'question' => "Pernyataan yang benar tentang pembelajaran {$subjectName} adalah ...",
                    'options' => [
                        'a' => 'Latihan bertahap membuat penguasaan materi lebih kuat',
                        'b' => 'Belajar cukup saat malam sebelum ujian',
                        'c' => 'Materi tidak perlu dipahami, cukup dihafal',
                        'd' => 'Diskusi kelas tidak memberi manfaat',
                    ],
                    'correct_answer' => 'a',
                ],
                [
                    'question' => "Sikap yang tepat saat ujian {$subjectName} berlangsung adalah ...",
                    'options' => [
                        'a' => 'Jujur, tenang, dan fokus pada jawaban sendiri',
                        'b' => 'Mencari bocoran jawaban dari gawai',
                        'c' => 'Berbicara dengan teman saat ujian',
                        'd' => 'Menyalin jawaban peserta lain',
                    ],
                    'correct_answer' => 'a',
                ],
            ];
        }

        return [
            [
                'question' => "Pada UAS {$subjectName}, cakupan materi yang diujikan umumnya adalah ...",
                'options' => [
                    'a' => 'Keseluruhan materi satu semester',
                    'b' => 'Materi awal semester saja',
                    'c' => 'Hanya tugas tanpa materi inti',
                    'd' => 'Topik di luar semester berjalan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Strategi belajar paling efektif menghadapi UAS {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Membuat ringkasan dan latihan soal',
                    'b' => 'Belajar mendadak tanpa jadwal',
                    'c' => 'Menghindari latihan soal',
                    'd' => 'Menghafal jawaban orang lain',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Manfaat memahami konsep {$subjectName} saat UAS adalah ...",
                'options' => [
                    'a' => 'Lebih mudah menyelesaikan variasi soal',
                    'b' => 'Tidak perlu memahami pertanyaan',
                    'c' => 'Selalu benar walau menebak',
                    'd' => 'Tidak perlu penguatan materi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Hal yang sebaiknya dihindari saat persiapan UAS {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Menunda belajar sampai hari terakhir',
                    'b' => 'Membuat jadwal latihan mingguan',
                    'c' => 'Bertanya saat ada materi belum paham',
                    'd' => 'Mengerjakan latihan sesuai kisi-kisi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Setelah UAS {$subjectName}, langkah perbaikan yang tepat adalah ...",
                'options' => [
                    'a' => 'Evaluasi kesalahan dan belajar dari hasil',
                    'b' => 'Melewati pembahasan hasil ujian',
                    'c' => 'Langsung melupakan materi',
                    'd' => 'Menolak masukan dari guru',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function detectSubjectCategory(string $subjectName): string
    {
        $name = strtolower($subjectName);

        if (str_contains($name, 'matematika')) {
            return 'matematika';
        }

        if (str_contains($name, 'bahasa indonesia')) {
            return 'bahasa_indonesia';
        }

        if (str_contains($name, 'bahasa inggris') || str_contains($name, 'english')) {
            return 'bahasa_inggris';
        }

        if (str_contains($name, 'pkwu') || str_contains($name, 'kewirausahaan') || str_contains($name, 'prakarya')) {
            return 'pkwu';
        }

        if (
            str_contains($name, 'tkj')
            || str_contains($name, 'jaringan')
            || str_contains($name, 'komputer')
            || str_contains($name, 'informatika')
            || str_contains($name, 'pemrograman')
        ) {
            return 'produktif_tkj';
        }

        if (str_contains($name, 'ppkn') || str_contains($name, 'pkn') || str_contains($name, 'pancasila')) {
            return 'ppkn';
        }

        return 'umum';
    }

    private function matematikaUts(string $subjectName): array
    {
        return [
            [
                'question' => "Dalam {$subjectName}, jika 3x + 5 = 20 maka nilai x adalah ...",
                'options' => ['a' => '5', 'b' => '4', 'c' => '6', 'd' => '7'],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Hasil dari 25% x 200 pada {$subjectName} adalah ...",
                'options' => ['a' => '40', 'b' => '45', 'c' => '50', 'd' => '60'],
                'correct_answer' => 'c',
            ],
            [
                'question' => "Rata-rata dari data 6, 8, 10, 12 pada {$subjectName} adalah ...",
                'options' => ['a' => '8', 'b' => '9', 'c' => '10', 'd' => '11'],
                'correct_answer' => 'b',
            ],
            [
                'question' => "Luas persegi dengan sisi 9 cm adalah ...",
                'options' => ['a' => '18 cm2', 'b' => '27 cm2', 'c' => '72 cm2', 'd' => '81 cm2'],
                'correct_answer' => 'd',
            ],
            [
                'question' => "Nilai dari 2^3 + 2^2 pada {$subjectName} adalah ...",
                'options' => ['a' => '10', 'b' => '12', 'c' => '14', 'd' => '16'],
                'correct_answer' => 'b',
            ],
        ];
    }

    private function matematikaUas(string $subjectName): array
    {
        return [
            [
                'question' => "Dalam {$subjectName}, penyelesaian 2x - 7 = 13 adalah ...",
                'options' => ['a' => '8', 'b' => '9', 'c' => '10', 'd' => '11'],
                'correct_answer' => 'c',
            ],
            [
                'question' => "Hasil dari (15 x 4) - 18 adalah ...",
                'options' => ['a' => '38', 'b' => '40', 'c' => '42', 'd' => '44'],
                'correct_answer' => 'c',
            ],
            [
                'question' => "Keliling persegi panjang dengan p=12 cm dan l=5 cm adalah ...",
                'options' => ['a' => '30 cm', 'b' => '34 cm', 'c' => '36 cm', 'd' => '40 cm'],
                'correct_answer' => 'b',
            ],
            [
                'question' => "Modus dari data 4, 5, 5, 6, 7 adalah ...",
                'options' => ['a' => '4', 'b' => '5', 'c' => '6', 'd' => '7'],
                'correct_answer' => 'b',
            ],
            [
                'question' => "Nilai akar kuadrat dari 144 pada {$subjectName} adalah ...",
                'options' => ['a' => '10', 'b' => '11', 'c' => '12', 'd' => '13'],
                'correct_answer' => 'c',
            ],
        ];
    }

    private function bahasaIndonesiaUts(string $subjectName): array
    {
        return [
            [
                'question' => "Dalam {$subjectName}, kalimat efektif ditandai dengan ...",
                'options' => [
                    'a' => 'Hemat kata dan jelas maknanya',
                    'b' => 'Banyak pengulangan kata',
                    'c' => 'Susunan kata berbelit-belit',
                    'd' => 'Makna kalimat ambigu',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Ide pokok paragraf biasanya terletak pada ...",
                'options' => [
                    'a' => 'Kalimat utama',
                    'b' => 'Kalimat penjelas terakhir',
                    'c' => 'Kata sambung',
                    'd' => 'Tanda baca',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Tujuan teks prosedur dalam {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Memberi langkah melakukan sesuatu',
                    'b' => 'Menghibur pembaca dengan cerita fiksi',
                    'c' => 'Menjelaskan riwayat hidup tokoh',
                    'd' => 'Menyampaikan opini tanpa data',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Kata baku yang tepat adalah ...",
                'options' => [
                    'a' => 'Aktivitas',
                    'b' => 'Aktifitas',
                    'c' => 'Resiko',
                    'd' => 'Kreatip',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Simpulan teks sebaiknya dibuat berdasarkan ...",
                'options' => [
                    'a' => 'Gagasan utama dan fakta pada teks',
                    'b' => 'Perasaan pembaca semata',
                    'c' => 'Judul tanpa membaca isi',
                    'd' => 'Kalimat pertama saja',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function bahasaIndonesiaUas(string $subjectName): array
    {
        return [
            [
                'question' => "Ciri teks eksplanasi pada {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Menjelaskan proses terjadinya suatu fenomena',
                    'b' => 'Berisi langkah kerja praktikum',
                    'c' => 'Berisi dialog drama',
                    'd' => 'Berisi daftar angka statistik saja',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Konjungsi kausalitas yang tepat adalah ...",
                'options' => [
                    'a' => 'Karena',
                    'b' => 'Dan',
                    'c' => 'Atau',
                    'd' => 'Lalu',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Dalam teks argumentasi, kalimat yang penting disertakan adalah ...",
                'options' => [
                    'a' => 'Pendapat yang didukung data atau fakta',
                    'b' => 'Pendapat tanpa alasan',
                    'c' => 'Kutipan tanpa sumber',
                    'd' => 'Pernyataan emosional berulang',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Ejaan yang tepat sesuai PUEBI adalah ...",
                'options' => [
                    'a' => 'izin',
                    'b' => 'ijin',
                    'c' => 'analisa',
                    'd' => 'tehnik',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Tujuan utama membuat resensi adalah ...",
                'options' => [
                    'a' => 'Memberi penilaian objektif terhadap karya',
                    'b' => 'Menyalin isi buku seluruhnya',
                    'c' => 'Membuat ringkasan tanpa opini',
                    'd' => 'Menceritakan pengalaman pribadi saja',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function bahasaInggrisUts(string $subjectName): array
    {
        return [
            [
                'question' => "In {$subjectName}, the correct simple present form is ...",
                'options' => [
                    'a' => 'She studies every night.',
                    'b' => 'She study every night.',
                    'c' => 'She studying every night.',
                    'd' => 'She studied every night.',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "The synonym of 'important' is ...",
                'options' => [
                    'a' => 'Significant',
                    'b' => 'Tiny',
                    'c' => 'Weak',
                    'd' => 'Late',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Choose the correct sentence in present continuous tense.",
                'options' => [
                    'a' => 'They are reading in the library.',
                    'b' => 'They reading in the library.',
                    'c' => 'They is reading in the library.',
                    'd' => 'They read in the library now.',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "The antonym of 'easy' is ...",
                'options' => [
                    'a' => 'Difficult',
                    'b' => 'Simple',
                    'c' => 'Clear',
                    'd' => 'Light',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "The correct expression to ask for help is ...",
                'options' => [
                    'a' => 'Could you help me, please?',
                    'b' => 'You must help me now.',
                    'c' => 'I no need your help.',
                    'd' => 'Help me and no question.',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function bahasaInggrisUas(string $subjectName): array
    {
        return [
            [
                'question' => "Choose the correct past tense sentence.",
                'options' => [
                    'a' => 'We visited the museum last week.',
                    'b' => 'We visit the museum last week.',
                    'c' => 'We are visiting the museum last week.',
                    'd' => 'We visits the museum last week.',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "The purpose of a descriptive text is to ...",
                'options' => [
                    'a' => 'Describe a person, place, or thing clearly',
                    'b' => 'Tell steps to do something',
                    'c' => 'Report only numbers',
                    'd' => 'Give commands only',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "The correct comparative form is ...",
                'options' => [
                    'a' => 'This task is easier than that one.',
                    'b' => 'This task is easy than that one.',
                    'c' => 'This task is easiest than that one.',
                    'd' => 'This task easier than that one.',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Which one is a polite closing in an email?",
                'options' => [
                    'a' => 'Best regards,',
                    'b' => 'Do it now,',
                    'c' => 'No reply needed,',
                    'd' => 'Whatever,',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Choose the correct passive voice sentence.",
                'options' => [
                    'a' => 'The report was completed by the team.',
                    'b' => 'The team was complete the report.',
                    'c' => 'The report completed by the team.',
                    'd' => 'The report was complete by the team do.',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function pkwuUts(string $subjectName): array
    {
        return [
            [
                'question' => "Dalam {$subjectName}, arti peluang usaha adalah ...",
                'options' => [
                    'a' => 'Kesempatan yang dapat dimanfaatkan untuk memperoleh keuntungan',
                    'b' => 'Risiko yang harus dihindari sepenuhnya',
                    'c' => 'Kegiatan membeli barang tanpa rencana',
                    'd' => 'Aktivitas produksi tanpa target pasar',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Salah satu tujuan analisis SWOT pada {$subjectName} adalah ...",
                'options' => [
                    'a' => 'Menilai kekuatan, kelemahan, peluang, dan ancaman usaha',
                    'b' => 'Menentukan harga tanpa survei pasar',
                    'c' => 'Mengganti laporan keuangan',
                    'd' => 'Menghapus evaluasi produk',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Contoh biaya tetap dalam usaha adalah ...",
                'options' => [
                    'a' => 'Sewa tempat usaha',
                    'b' => 'Bahan baku harian',
                    'c' => 'Biaya kemasan per produk',
                    'd' => 'Komisi penjualan per item',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Promosi digital yang efektif untuk produk siswa adalah ...",
                'options' => [
                    'a' => 'Konten produk yang jelas di media sosial',
                    'b' => 'Tidak mencantumkan harga',
                    'c' => 'Mengunggah foto buram',
                    'd' => 'Mengabaikan respon pelanggan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Sikap wirausaha yang penting dimiliki siswa adalah ...",
                'options' => [
                    'a' => 'Kreatif dan pantang menyerah',
                    'b' => 'Takut mencoba ide baru',
                    'c' => 'Menunda semua keputusan',
                    'd' => 'Tidak mau evaluasi',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function pkwuUas(string $subjectName): array
    {
        return [
            [
                'question' => "Dalam {$subjectName}, langkah awal membuat business plan adalah ...",
                'options' => [
                    'a' => 'Menentukan ide usaha dan target pasar',
                    'b' => 'Membuat laporan laba rugi akhir tahun',
                    'c' => 'Menaikkan harga tanpa riset',
                    'd' => 'Membeli alat tanpa perhitungan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Tujuan pencatatan keuangan usaha adalah ...",
                'options' => [
                    'a' => 'Mengetahui arus kas dan keuntungan usaha',
                    'b' => 'Memperbanyak biaya tak terkontrol',
                    'c' => 'Menghindari evaluasi usaha',
                    'd' => 'Menghapus data transaksi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Contoh strategi pemasaran 4P yang tepat adalah ...",
                'options' => [
                    'a' => 'Menyesuaikan produk, harga, promosi, dan tempat jual',
                    'b' => 'Fokus pada promosi saja',
                    'c' => 'Mengabaikan kualitas produk',
                    'd' => 'Tidak menentukan segmen pasar',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Dalam evaluasi usaha, indikator yang perlu dilihat adalah ...",
                'options' => [
                    'a' => 'Penjualan, biaya, dan kepuasan pelanggan',
                    'b' => 'Jumlah posting tanpa interaksi',
                    'c' => 'Jumlah ide tanpa implementasi',
                    'd' => 'Banyaknya hutang tanpa catatan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Langkah perbaikan usaha setelah evaluasi adalah ...",
                'options' => [
                    'a' => 'Menyusun tindakan berdasarkan data hasil evaluasi',
                    'b' => 'Mengulang kesalahan yang sama',
                    'c' => 'Mengabaikan keluhan pelanggan',
                    'd' => 'Menutup usaha tanpa analisis',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function produktifTkjUts(string $subjectName): array
    {
        return [
            [
                'question' => "Dalam {$subjectName}, fungsi utama router adalah ...",
                'options' => [
                    'a' => 'Menghubungkan dan mengarahkan paket antar jaringan',
                    'b' => 'Menyimpan file pengguna',
                    'c' => 'Mengganti kabel secara otomatis',
                    'd' => 'Membuat desain poster',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Alamat IP versi 4 terdiri dari ...",
                'options' => [
                    'a' => '4 oktet angka',
                    'b' => '2 oktet angka',
                    'c' => '8 oktet huruf',
                    'd' => '16 oktet angka',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Perangkat yang bekerja pada layer data link dan menghubungkan host dalam LAN adalah ...",
                'options' => [
                    'a' => 'Switch',
                    'b' => 'Modem',
                    'c' => 'Printer',
                    'd' => 'Scanner',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Tujuan subnetting pada jaringan adalah ...",
                'options' => [
                    'a' => 'Membagi jaringan agar lebih efisien dan terstruktur',
                    'b' => 'Memperlambat trafik jaringan',
                    'c' => 'Menghapus kebutuhan IP address',
                    'd' => 'Menghilangkan keamanan jaringan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Perintah untuk menguji koneksi antar perangkat jaringan adalah ...",
                'options' => [
                    'a' => 'ping',
                    'b' => 'format',
                    'c' => 'delete',
                    'd' => 'rename',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function produktifTkjUas(string $subjectName): array
    {
        return [
            [
                'question' => "Pada {$subjectName}, fungsi DNS server adalah ...",
                'options' => [
                    'a' => 'Menerjemahkan nama domain menjadi alamat IP',
                    'b' => 'Menyimpan semua file user',
                    'c' => 'Mendistribusikan listrik perangkat',
                    'd' => 'Mencetak laporan jaringan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Topologi jaringan yang menggunakan pusat kendali tunggal adalah ...",
                'options' => [
                    'a' => 'Star',
                    'b' => 'Bus',
                    'c' => 'Ring',
                    'd' => 'Mesh',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Perangkat lunak firewall berfungsi untuk ...",
                'options' => [
                    'a' => 'Menyaring lalu lintas jaringan berdasarkan aturan keamanan',
                    'b' => 'Meningkatkan ukuran monitor',
                    'c' => 'Mematikan server otomatis',
                    'd' => 'Mengganti alamat MAC semua perangkat',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Subnet mask 255.255.255.0 setara dengan prefix ...",
                'options' => [
                    'a' => '/24',
                    'b' => '/16',
                    'c' => '/8',
                    'd' => '/32',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Langkah troubleshooting jaringan yang tepat adalah ...",
                'options' => [
                    'a' => 'Identifikasi masalah, uji, lalu verifikasi solusi',
                    'b' => 'Langsung ganti semua perangkat',
                    'c' => 'Abaikan gejala error',
                    'd' => 'Memutus semua kabel tanpa cek',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function ppknUts(string $subjectName): array
    {
        return [
            [
                'question' => "Dalam {$subjectName}, dasar negara Indonesia adalah ...",
                'options' => ['a' => 'Pancasila', 'b' => 'UUDS', 'c' => 'Trisila', 'd' => 'Dekrit'],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Sikap yang mencerminkan persatuan sesuai nilai PPKn adalah ...",
                'options' => [
                    'a' => 'Menghargai perbedaan suku, agama, dan budaya',
                    'b' => 'Memaksakan pendapat pribadi',
                    'c' => 'Membatasi pergaulan antar kelompok',
                    'd' => 'Mengutamakan kepentingan golongan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Lembaga yang berwenang membuat undang-undang bersama presiden adalah ...",
                'options' => ['a' => 'DPR', 'b' => 'MA', 'c' => 'MK', 'd' => 'BPK'],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Contoh pelaksanaan musyawarah di sekolah adalah ...",
                'options' => [
                    'a' => 'Menentukan keputusan kelas melalui diskusi bersama',
                    'b' => 'Memilih ketua kelas tanpa rapat',
                    'c' => 'Memaksakan keputusan mayoritas tanpa dengar pendapat',
                    'd' => 'Menolak usulan anggota lain',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Hak dan kewajiban warga negara seharusnya ...",
                'options' => [
                    'a' => 'Dilaksanakan secara seimbang',
                    'b' => 'Hak didahulukan tanpa kewajiban',
                    'c' => 'Kewajiban saja tanpa hak',
                    'd' => 'Diserahkan pada pemerintah sepenuhnya',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private function ppknUas(string $subjectName): array
    {
        return [
            [
                'question' => "Pada {$subjectName}, tujuan dibentuknya NKRI adalah ...",
                'options' => [
                    'a' => 'Mewujudkan persatuan dan kesejahteraan bangsa',
                    'b' => 'Membatasi peran rakyat',
                    'c' => 'Memecah daerah menjadi negara kecil',
                    'd' => 'Menghapus hukum nasional',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Peraturan perundang-undangan tertinggi di Indonesia adalah ...",
                'options' => ['a' => 'UUD 1945', 'b' => 'Perpres', 'c' => 'Perda', 'd' => 'PP'],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Contoh bela negara di lingkungan sekolah adalah ...",
                'options' => [
                    'a' => 'Disiplin, taat aturan, dan menjaga nama baik sekolah',
                    'b' => 'Membolos saat upacara',
                    'c' => 'Merusak fasilitas umum',
                    'd' => 'Menyebar hoaks di media sosial',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Makna demokrasi Pancasila adalah ...",
                'options' => [
                    'a' => 'Kedaulatan rakyat yang dilandasi nilai Pancasila',
                    'b' => 'Kekuasaan mutlak satu kelompok',
                    'c' => 'Kebebasan tanpa aturan',
                    'd' => 'Pengambilan keputusan oleh pihak luar',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => "Sikap terhadap keberagaman yang sesuai konstitusi adalah ...",
                'options' => [
                    'a' => 'Toleransi dan saling menghormati',
                    'b' => 'Diskriminasi terhadap kelompok lain',
                    'c' => 'Menolak dialog antar kelompok',
                    'd' => 'Menyebarkan ujaran kebencian',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }
}
