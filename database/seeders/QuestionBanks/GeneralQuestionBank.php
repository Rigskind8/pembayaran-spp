<?php

namespace Database\Seeders\QuestionBanks;

class GeneralQuestionBank
{
    public static function getQuestions(string $subjectBase, string $type): ?array
    {
        $map = [
            'Bahasa Indonesia' => 'bahasaIndonesia',
            'Bahasa Inggris' => 'bahasaInggris',
            'Matematika Teknik' => 'matematikaTeknik',
            'Pendidikan Agama' => 'pendidikanAgama',
            'Pendidikan Pancasila & Kewarganegaraan' => 'ppkn',
            'Sejarah Indonesia' => 'sejarahIndonesia',
            'Seni Budaya' => 'seniBudaya',
            'Pendidikan Jasmani, Olahraga & Kesehatan' => 'pjok',
            'Prakarya & Kewirausahaan' => 'pkwu',
            'Teknologi Informasi & Komunikasi' => 'tik',
            'Bimbingan Konseling' => 'bimbinganKonseling',
            'Muatan Lokal' => 'muatanLokal',
        ];

        if (!isset($map[$subjectBase])) {
            return null;
        }

        $method = $map[$subjectBase] . ucfirst(strtolower($type));
        if (method_exists(self::class, $method)) {
            return self::$method();
        }

        return null;
    }

    // ================= BAHASA INDONESIA =================
    private static function bahasaIndonesiaUts(): array
    {
        return [
            [
                'question' => 'Struktur teks laporan hasil observasi (LHO) yang benar secara berurutan adalah ...',
                'options' => [
                    'a' => 'Pernyataan umum (klasifikasi), deskripsi bagian, dan deskripsi manfaat',
                    'b' => 'Orientasi, komplikasi, evaluasi, dan resolusi',
                    'c' => 'Tesis, rangkaian argumen, dan penegasan ulang pendapat',
                    'd' => 'Abstraksi, orientasi, krisis, reaksi, dan koda',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Bacalah kutipan berikut: "Pohon kelapa (Cocos nucifera) adalah tumbuhan palem berbatang tinggi yang hampir seluruh bagian pohonnya dapat dimanfaatkan manusia." Kalimat tersebut termasuk jenis kalimat ...',
                'options' => [
                    'a' => 'Kalimat deskripsi',
                    'b' => 'Kalimat definisi',
                    'c' => 'Kalimat imperatif',
                    'd' => 'Kalimat retoris',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Konjungsi yang menyatakan hubungan sebab-akibat (kausalitas) dalam teks eksplanasi adalah ...',
                'options' => [
                    'a' => 'Meskipun, walaupun, dan kendati',
                    'b' => 'Lalu, kemudian, dan setelah itu',
                    'c' => 'Oleh karena itu, sehingga, dan sebab',
                    'd' => 'Atau, melainkan, dan sedangkan',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Penulisan huruf kapital yang sesuai dengan pedoman EYD V terdapat pada kalimat ...',
                'options' => [
                    'a' => 'Siswa SMK itu sedang belajar Bahasa inggris di laboratorium.',
                    'b' => 'Gubernur Jawa Barat meresmikan gedung baru Sekolah tersebut.',
                    'c' => 'Ayah pergi ke kota Semarang menggunakan Kereta Api.',
                    'd' => 'Presiden Joko Widodo memimpin rapat kabinet di Istana Merdeka.',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Ciri utama paragraf deduktif adalah ...',
                'options' => [
                    'a' => 'Gagasan utama terletak di awal paragraf lalu diikuti penjelas',
                    'b' => 'Gagasan utama berada di akhir paragraf sebagai simpulan',
                    'c' => 'Gagasan utama menyebar merata di seluruh bagian kalimat',
                    'd' => 'Paragraf tidak memiliki gagasan pokok yang eksplisit',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function bahasaIndonesiaUas(): array
    {
        return [
            [
                'question' => 'Kalimat pembuka surat lamaran pekerjaan yang tepat berdasarkan inisiatif sendiri adalah ...',
                'options' => [
                    'a' => 'Setelah membaca iklan lowongan di internet, saya ingin mendaftar kerja.',
                    'b' => 'Yang bertanda tangan di bawah ini saya, segera mengajukan lamaran kerja.',
                    'c' => 'Melalui surat ini, saya bermaksud mengajukan diri untuk mengisi lowongan pekerjaan yang tersedia di perusahaan Bapak/Ibu.',
                    'd' => 'Sehubungan dengan panggilan kerja, saya datang membawa berkas lamaran.',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Berikut ini yang merupakan kalimat efektif dan baku adalah ...',
                'options' => [
                    'a' => 'Bagi semua peserta ujian dimohon untuk masuk ke dalam ruangan.',
                    'b' => 'Seluruh peserta ujian dipersilakan memasuki ruangan.',
                    'c' => 'Para siswa-siswa sekalian sedang mengerjakan ujian akhir.',
                    'd' => 'Di dalam laboratorium itu banyak terdapat alat-alat komputer.',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tahapan dalam teks negosiasi yang berisi tawar-menawar antara kedua belah pihak untuk mencapai kesepakatan disebut ...',
                'options' => [
                    'a' => 'Orientasi',
                    'b' => 'Persetujuan',
                    'c' => 'Penutup',
                    'd' => 'Pengajuan dan Penawaran',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Penggunaan tanda baca titik dua (:) yang tepat menurut EYD V terdapat pada kalimat ...',
                'options' => [
                    'a' => 'Ibu membeli: gula, kopi, dan teh di warung.',
                    'b' => 'Kami memerlukan perlengkapan bengkel: kunci pas, obeng, dan tang.',
                    'c' => 'Siswa yang hadir: Ahmad, Budi, dan Doni.',
                    'd' => 'Ruang ujian: bersih, sejuk, dan sangat tertib.',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Makna kata konotatif dalam karya sastra adalah ...',
                'options' => [
                    'a' => 'Makna kiasan atau makna tambahan yang tidak sebenarnya',
                    'b' => 'Makna harfiah sesuai yang tertera dalam kamus besar',
                    'c' => 'Makna ilmiah yang digunakan dalam laporan teknis',
                    'd' => 'Makna umum yang dipahami secara denotatif',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= BAHASA INGGRIS =================
    private static function bahasaInggrisUts(): array
    {
        return [
            [
                'question' => 'Complete the sentence: "Rian ... the network cable yesterday morning to test the connection."',
                'options' => [
                    'a' => 'repairs',
                    'b' => 'repaired',
                    'c' => 'repairing',
                    'd' => 'has repair',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Student A: "What do you think about the new workshop safety rules?" Student B: "..." Which expression shows giving an opinion?',
                'options' => [
                    'a' => 'I don\'t agree with you at all.',
                    'b' => 'Can you repeat the question please?',
                    'c' => 'In my opinion, they make the workshop much safer and better organized.',
                    'd' => 'I must go to the workshop right now.',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Choose the correct passive voice sentence for: "The IT technician fixed the database server."',
                'options' => [
                    'a' => 'The database server was fixed by the IT technician.',
                    'b' => 'The database server is fixed by the IT technician.',
                    'c' => 'The database server was fixing by the IT technician.',
                    'd' => 'The IT technician was fixed the database server.',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'The main purpose of a procedure text (e.g., How to Crimp an RJ-45 Cable) is to ...',
                'options' => [
                    'a' => 'Describe an object in detail with adjectives',
                    'b' => 'Entertain the reader with an imaginative story',
                    'c' => 'Persuade the reader to buy a commercial product',
                    'd' => 'Explain how something is made or done through a sequence of steps',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Which of the following is the antonym (opposite meaning) of "reliable"?',
                'options' => [
                    'a' => 'Trustworthy',
                    'b' => 'Undependable',
                    'c' => 'Accurate',
                    'd' => 'Consistent',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    private static function bahasaInggrisUas(): array
    {
        return [
            [
                'question' => 'Complete the conditional sentence: "If the server temperature rises above 80°C, the cooling fan ... automatically."',
                'options' => [
                    'a' => 'would start',
                    'b' => 'started',
                    'c' => 'will start',
                    'd' => 'would have started',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'In a job interview, which statement best expresses professional work experience?',
                'options' => [
                    'a' => 'I have completed a three-month industrial internship as a junior network technician.',
                    'b' => 'I do not like working under tight project deadlines.',
                    'c' => 'Give me this job because I really need the money today.',
                    'd' => 'My friends told me that your company is very big.',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Choose the most appropriate formal sign-off for a business email or application letter:',
                'options' => [
                    'a' => 'See you later,',
                    'b' => 'Yours faithfully,',
                    'c' => 'Cheers mate,',
                    'd' => 'Bye for now,',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Complete the sentence with the correct modal: "Technicians ... wear safety goggles whenever they are operating grinding machines."',
                'options' => [
                    'a' => 'might',
                    'b' => 'could',
                    'c' => 'must',
                    'd' => 'would',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'In a technical report text, the section that provides factual findings and data analysis is called ...',
                'options' => [
                    'a' => 'Complication',
                    'b' => 'Orientation',
                    'c' => 'Resolution',
                    'd' => 'Findings and Discussion',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }

    // ================= MATEMATIKA TEKNIK =================
    private static function matematikaTeknikUts(): array
    {
        return [
            [
                'question' => 'Jika 4x - 7 = 2x + 9, maka nilai x yang memenuhi adalah ...',
                'options' => [
                    'a' => '6',
                    'b' => '7',
                    'c' => '8',
                    'd' => '9',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Pada segitiga siku-siku dengan panjang sisi tegak 6 cm dan 8 cm, panjang sisi miring (hipotenusa) adalah ...',
                'options' => [
                    'a' => '10 cm',
                    'b' => '12 cm',
                    'c' => '14 cm',
                    'd' => '15 cm',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Nilai dari sin 30° + cos 60° adalah ...',
                'options' => [
                    'a' => '0,5',
                    'b' => '1,0',
                    'c' => '1,5',
                    'd' => '2,0',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Akar-akar dari persamaan kuadrat x² - 5x + 6 = 0 adalah ...',
                'options' => [
                    'a' => 'x = 1 atau x = 6',
                    'b' => 'x = -2 atau x = -3',
                    'c' => 'x = -1 atau x = 6',
                    'd' => 'x = 2 atau x = 3',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Gradien garis yang melalui titik A(2, 3) dan B(6, 11) adalah ...',
                'options' => [
                    'a' => '2',
                    'b' => '3',
                    'c' => '4',
                    'd' => '5',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function matematikaTeknikUas(): array
    {
        return [
            [
                'question' => 'Diketahui matriks A = [3, 2; 1, 4]. Nilai determinan matriks A adalah ...',
                'options' => [
                    'a' => '8',
                    'b' => '10',
                    'c' => '12',
                    'd' => '14',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Suku ke-10 dari barisan aritmetika 3, 7, 11, 15, ... adalah ...',
                'options' => [
                    'a' => '35',
                    'b' => '37',
                    'c' => '39',
                    'd' => '41',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Rata-rata (mean) dari data nilai: 70, 80, 75, 85, 90 adalah ...',
                'options' => [
                    'a' => '80',
                    'b' => '82',
                    'c' => '84',
                    'd' => '85',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sebuah dadu bersisi enam dilempar sekali. Peluang munculnya mata dadu bilangan prima (2, 3, 5) adalah ...',
                'options' => [
                    'a' => '1/6',
                    'b' => '1/3',
                    'c' => '1/2',
                    'd' => '2/3',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Turunan pertama dari f(x) = 3x² + 5x - 8 adalah ...',
                'options' => [
                    'a' => '3x + 5',
                    'b' => '6x - 8',
                    'c' => '6x² + 5',
                    'd' => '6x + 5',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }

    // ================= PENDIDIKAN AGAMA =================
    private static function pendidikanAgamaUts(): array
    {
        return [
            [
                'question' => 'Sikap jujur dalam perkataan dan perbuatan sesuai ajaran agama disebut ...',
                'options' => [
                    'a' => 'Siddiq',
                    'b' => 'Amanah',
                    'c' => 'Tabligh',
                    'd' => 'Fathanah',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sikap saling menghormati dan menghargai perbedaan keyakinan dalam kehidupan bermasyarakat disebut ...',
                'options' => [
                    'a' => 'Ta\'awun',
                    'b' => 'Tasamuh (toleransi)',
                    'c' => 'Tawadhu',
                    'd' => 'Qana\'ah',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Contoh perilaku berbakti kepada kedua orang tua (birrul walidain) yang masih hidup adalah ...',
                'options' => [
                    'a' => 'Mendoakan mereka dan mematuhi nasihat baiknya',
                    'b' => 'Menuntut uang saku di luar kemampuan orang tua',
                    'c' => 'Membantah ketika dinasihati hal kebaikan',
                    'd' => 'Mengabaikan perintah orang tua saat bermain gawai',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Etika bermedia sosial yang sesuai dengan tuntunan akhlak terpuji adalah ...',
                'options' => [
                    'a' => 'Menyebarkan kabar burung tanpa klarifikasi (tabayyun)',
                    'b' => 'Menuliskan komentar kebencian secara anonim',
                    'c' => 'Meneliti kebenaran berita dan menjaga lisan dari fitnah',
                    'd' => 'Membagikan aib teman ke ruang publik',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Menjaga titipan pekerjaan atau tanggung jawab dengan sebaik-baiknya merupakan wujud sifat ...',
                'options' => [
                    'a' => 'Riya',
                    'b' => 'Ghurur',
                    'c' => 'Sum\'ah',
                    'd' => 'Amanah',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }

    private static function pendidikanAgamaUas(): array
    {
        return [
            [
                'question' => 'Prinsip utama dalam transaksi muamalah (jual beli) menurut syariat adalah ...',
                'options' => [
                    'a' => 'Suka sama suka (taradhin) tanpa adanya unsur penipuan atau riba',
                    'b' => 'Meraih keuntungan setinggi-tingginya dengan segala cara',
                    'c' => 'Menyembunyikan cacat barang agar cepat laku',
                    'd' => 'Memaksa pembeli mengambil barang yang tidak diinginkan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kewajiban mengeluarkan sebagian harta tertentu yang telah mencapai nishab dan haul untuk dibagikan kepada yang berhak disebut ...',
                'options' => [
                    'a' => 'Infaq',
                    'b' => 'Zakat',
                    'c' => 'Wakaf',
                    'd' => 'Kifarat',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Sikap rela menerima apa adanya ketentuan Allah setelah berusaha secara maksimal disebut ...',
                'options' => [
                    'a' => 'Tawakkal dan Qana\'ah',
                    'b' => 'Pasrah tanpa usaha',
                    'c' => 'Pesimis dan putus asa',
                    'd' => 'Takabur',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Membicarakan keburukan orang lain di belakangnya yang apabila ia mengetahuinya merasa tidak suka disebut perbuatan ...',
                'options' => [
                    'a' => 'Namimah',
                    'b' => 'Ghibah',
                    'c' => 'Hasad',
                    'd' => 'Riya',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Pernikahan yang sah menurut undang-undang dan agama di Indonesia harus memenuhi ...',
                'options' => [
                    'a' => 'Surat perjanjian notaris saja',
                    'b' => 'Pesta perayaan yang mewah',
                    'c' => 'Rukun dan syarat pernikahan serta dicatat di KUA/Catatan Sipil',
                    'd' => 'Rekomendasi dari teman sebaya',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    // ================= PPKN =================
    private static function ppknUts(): array
    {
        return [
            [
                'question' => 'Hierarki peraturan perundang-undangan tertinggi di Negara Kesatuan Republik Indonesia adalah ...',
                'options' => [
                    'a' => 'Undang-Undang / Perppu',
                    'b' => 'Peraturan Pemerintah',
                    'c' => 'Ketetapan MPR',
                    'd' => 'UUD NRI Tahun 1945',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Sila dalam Pancasila yang menjadi landasan utama semangat persatuan dan kesatuan bangsa tanpa memandang sekat suku dan ras adalah ...',
                'options' => [
                    'a' => 'Sila pertama',
                    'b' => 'Sila kedua',
                    'c' => 'Sila ketiga',
                    'd' => 'Sila kelima',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Lembaga negara yang berwenang menguji undang-undang terhadap Undang-Undang Dasar (Judicial Review) adalah ...',
                'options' => [
                    'a' => 'Mahkamah Agung',
                    'b' => 'Mahkamah Konstitusi',
                    'c' => 'Komisi Yudisial',
                    'd' => 'Dewan Perwakilan Rakyat',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Perwujudan hak asasi manusia dalam bidang pendidikan diatur secara tegas dalam UUD 1945 pada pasal ...',
                'options' => [
                    'a' => 'Pasal 31',
                    'b' => 'Pasal 27',
                    'c' => 'Pasal 29',
                    'd' => 'Pasal 33',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sikap seorang siswa yang mencerminkan partisipasi aktif dalam bela negara di lingkungan sekolah adalah ...',
                'options' => [
                    'a' => 'Mengikuti tawuran antarsekolah demi membela geng',
                    'b' => 'Disiplin mentaati tata tertib sekolah dan giat belajar',
                    'c' => 'Menyebarkan isu suku dan agama di media sosial sekolah',
                    'd' => 'Membolos saat upacara bendera hari Senin',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    private static function ppknUas(): array
    {
        return [
            [
                'question' => 'Asas pemilihan umum (Pemilu) di Indonesia yang disingkat LUBER dan JURDIL memiliki kepanjangan ...',
                'options' => [
                    'a' => 'Langsung, Umum, Bebas, Rahasia, Jujur, dan Adil',
                    'b' => 'Lengkap, Unggul, Bersama, Rapi, Jelas, dan Aman',
                    'c' => 'Lancar, Utuh, Berani, Rukun, Jiwa, dan Damai',
                    'd' => 'Legal, Universal, Baku, Resmi, Jaminan, dan Aktif',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Konsep Wawasan Nusantara memandang kesatuan wilayah Indonesia mencakup kesatuan ...',
                'options' => [
                    'a' => 'Ekonomi dan militer semata',
                    'b' => 'Politik, ekonomi, sosial budaya, dan pertahanan keamanan',
                    'c' => 'Hanya pulau-pulau besar tanpa wilayah perairan',
                    'd' => 'Antara pemerintah pusat dengan negara tetangga',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Lembaga independen yang bertugas melakukan pencegahan dan pemberantasan tindak pidana korupsi di Indonesia adalah ...',
                'options' => [
                    'a' => 'Komnas HAM',
                    'b' => 'Ombudsman RI',
                    'c' => 'Komisi Pemberantasan Korupsi (KPK)',
                    'd' => 'Badan Pemeriksa Keuangan (BPK)',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Kewajiban warga negara yang ditegaskan dalam UUD 1945 Pasal 27 Ayat 3 adalah ...',
                'options' => [
                    'a' => 'Membayar pajak bumi dan bangunan',
                    'b' => 'Memeluk agama dan beribadah sesuai keyakinan',
                    'c' => 'Mengembangkan kebudayaan nasional',
                    'd' => 'Ikut serta dalam upaya pembelaan negara',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Sikap menghargai kebinekaan dalam kehidupan sehari-hari diwujudkan dengan cara ...',
                'options' => [
                    'a' => 'Berteman tanpa membeda-bedakan latar belakang suku, agama, dan budaya',
                    'b' => 'Menghindari interaksi dengan warga yang berbeda bahasa',
                    'c' => 'Memaksakan adat istiadat sendiri kepada tetangga',
                    'd' => 'Menganggap kebudayaan sukunya sendiri paling superior',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= SEJARAH INDONESIA =================
    private static function sejarahIndonesiaUts(): array
    {
        return [
            [
                'question' => 'Organisasi pergerakan nasional pertama di Indonesia yang didirikan pada tanggal 20 Mei 1908 adalah ...',
                'options' => [
                    'a' => 'Sarekat Islam',
                    'b' => 'Indische Partij',
                    'c' => 'Budi Utomo',
                    'd' => 'Perhimpunan Indonesia',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Kongres Pemuda II pada 28 Oktober 1928 melahirkan ikrar bersejarah yang dikenal sebagai ...',
                'options' => [
                    'a' => 'Dekrit Presiden',
                    'b' => 'Sumpah Pemuda',
                    'c' => 'Piagam Jakarta',
                    'd' => 'Manifesto Politik',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Kerajaan maritim Hindu-Buddha terbesar di nusantara yang berpusat di Jawa Timur dan mencapai masa kejayaan di bawah Hayam Wuruk adalah ...',
                'options' => [
                    'a' => 'Majapahit',
                    'b' => 'Sriwijaya',
                    'c' => 'Mataram Kuno',
                    'd' => 'Singasari',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sistem tanam paksa (Cultuurstelsel) yang sangat menyengsarakan rakyat pribumi diterapkan oleh gubernur jenderal Belanda bernama ...',
                'options' => [
                    'a' => 'Herman Willem Daendels',
                    'b' => 'Thomas Stamford Raffles',
                    'c' => 'Cornelis de Houtman',
                    'd' => 'Johannes van den Bosch',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Tiga tokoh pendiri Indische Partij yang dikenal sebagai "Tiga Serangkai" adalah ...',
                'options' => [
                    'a' => 'Douwes Dekker, dr. Cipto Mangunkusumo, dan Suwardi Suryaningrat',
                    'b' => 'Soekarno, Mohammad Hatta, dan Sutan Sjahrir',
                    'c' => 'H.O.S. Cokroaminoto, Agus Salim, dan Musso',
                    'd' => 'Wahidin Sudirohusodo, Soetomo, dan Gunawan Mangunkusumo',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function sejarahIndonesiaUas(): array
    {
        return [
            [
                'question' => 'Peristiwa penculikan Soekarno dan Hatta oleh para pemuda ke Karawang untuk mempercepat proklamasi dikenal sebagai peristiwa ...',
                'options' => [
                    'a' => 'Peristiwa Ambarawa',
                    'b' => 'Peristiwa Rengasdengklok',
                    'c' => 'Peristiwa Bandung Lautan Api',
                    'd' => 'Peristiwa Cikini',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Teks Proklamasi Kemerdekaan Indonesia pada tanggal 17 Agustus 1945 diketik oleh ...',
                'options' => [
                    'a' => 'Sayuti Melik',
                    'b' => 'B.M. Diah',
                    'c' => 'Chaerul Saleh',
                    'd' => 'Sukarni',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perjanjian antara Indonesia dan Belanda pada tahun 1949 yang menghasilkan pengakuan kedaulatan Republik Indonesia Serikat adalah ...',
                'options' => [
                    'a' => 'Perjanjian Linggarjati',
                    'b' => 'Perjanjian Renville',
                    'c' => 'Konferensi Meja Bundar (KMB)',
                    'd' => 'Perjanjian Roem-Royen',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Konferensi Asia-Afrika (KAA) yang diselenggarakan pada tahun 1955 berlangsung di kota ...',
                'options' => [
                    'a' => 'Jakarta',
                    'b' => 'Yogyakarta',
                    'c' => 'Surabaya',
                    'd' => 'Bandung',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Gerakan Reformasi di Indonesia pada Mei 1998 dipicu oleh krisis ekonomi dan menuntut ...',
                'options' => [
                    'a' => 'Turunnya Presiden Soeharto dan pembaharuan kehidupan politik yang demokratis',
                    'b' => 'Pembubaran partai politik oposisi',
                    'c' => 'Kembalinya sistem monarki di Indonesia',
                    'd' => 'Pemisahan seluruh provinsi menjadi negara merdeka',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= SENI BUDAYA =================
    private static function seniBudayaUts(): array
    {
        return [
            [
                'question' => 'Unsur fisik mendasar dalam seni rupa yang terbentuk dari pergerakan sebuah titik adalah ...',
                'options' => [
                    'a' => 'Bidang',
                    'b' => 'Garis',
                    'c' => 'Tekstur',
                    'd' => 'Warna',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tiga warna pokok (primer) yang tidak dapat dihasilkan dari campuran warna lain adalah ...',
                'options' => [
                    'a' => 'Merah, Kuning, dan Biru',
                    'b' => 'Merah, Hijau, dan Ungu',
                    'c' => 'Oranye, Hijau, dan Cokelat',
                    'd' => 'Hitam, Putih, dan Abu-abu',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Karya seni rupa yang memiliki ukuran panjang, lebar, dan volume serta dapat dilihat dari berbagai arah disebut seni rupa ...',
                'options' => [
                    'a' => 'Satu dimensi',
                    'b' => 'Dua dimensi',
                    'c' => 'Tiga dimensi',
                    'd' => 'Empat dimensi',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Karya seni rupa yang diciptakan dengan mengutamakan fungsi kegunaan praktis dalam kehidupan sehari-hari disebut ...',
                'options' => [
                    'a' => 'Seni rupa murni (fine art)',
                    'b' => 'Seni rupa terapan (applied art)',
                    'c' => 'Seni grafis murni',
                    'd' => 'Seni instalasi abstrak',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Kain tradisional Indonesia yang diakui UNESCO sebagai warisan budaya takbenda dan dibuat menggunakan malam serta canting adalah ...',
                'options' => [
                    'a' => 'Kain Songket',
                    'b' => 'Kain Ulos',
                    'c' => 'Kain Tenun Ikat',
                    'd' => 'Batik',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }

    private static function seniBudayaUas(): array
    {
        return [
            [
                'question' => 'Tangga nada pentatonis yang banyak digunakan dalam musik gamelan tradisional Jawa dan Sunda terdiri dari ...',
                'options' => [
                    'a' => '5 nada pokok',
                    'b' => '7 nada pokok',
                    'c' => '8 nada pokok',
                    'd' => '12 nada pokok',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Alat musik tradisional tiup dari bambu yang berasal dari Minangkabau, Sumatera Barat adalah ...',
                'options' => [
                    'a' => 'Angklung',
                    'b' => 'Saluang',
                    'c' => 'Sasando',
                    'd' => 'Kolintang',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tari Saman yang berasal dari Provinsi Aceh memiliki keunikan utama yaitu ...',
                'options' => [
                    'a' => 'Menggunakan properti piring porselen',
                    'b' => 'Ditarikan berpasangan dengan gerakan lambat',
                    'c' => 'Gerakan serentak bertepuk dada dan tangan dalam posisi duduk berjejer',
                    'd' => 'Penari mengenakan topeng kayu berkarakter lucu',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Kegiatan memamerkan karya seni rupa kepada publik untuk mendapatkan evaluasi dan apresiasi disebut ...',
                'options' => [
                    'a' => 'Pameran seni rupa',
                    'b' => 'Pentas drama',
                    'c' => 'Resital musik',
                    'd' => 'Lelang komersial',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Unsur tata rias dan busana dalam pementasan seni tari daerah berfungsi untuk ...',
                'options' => [
                    'a' => 'Membuat penari terlihat mewah semata',
                    'b' => 'Memperjelas karakter tokoh dan memperkuat tema tarian',
                    'c' => 'Menutupi kesalahan gerakan penari',
                    'd' => 'Menggantikan iringan musik tari',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    // ================= PJOK =================
    private static function pjokUts(): array
    {
        return [
            [
                'question' => 'Indikator kebugaran jasmani yang menunjukkan kemampuan jantung dan paru-paru bekerja optimal dalam durasi lama disebut ...',
                'options' => [
                    'a' => 'Daya tahan kardiorespirasi (aerobik)',
                    'b' => 'Kelentukan otot (fleksibilitas)',
                    'c' => 'Kecepatan reaksi',
                    'd' => 'Kekuatan maksimal',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Dalam permainan sepak bola, seorang pemain penyerang dinyatakan berada dalam posisi offside apabila ...',
                'options' => [
                    'a' => 'Menyentuh bola dengan tangan di area gawang lawan',
                    'b' => 'Berada lebih dekat ke garis gawang lawan daripada bola dan pemain bertahan lawan saat bola diumpan',
                    'c' => 'Melakukan sliding tackle dari arah belakang lawan',
                    'd' => 'Menerima bola langsung dari lemparan ke dalam',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Teknik mengoper bola setinggi dada dengan kedua tangan dalam permainan bola basket dinamakan ...',
                'options' => [
                    'a' => 'Bounce pass',
                    'b' => 'Overhead pass',
                    'c' => 'Chest pass',
                    'd' => 'Baseball pass',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Teknik dasar dalam bola voli untuk menerima servis atau serangan lawan dengan kedua lengan dirapatkan ke depan bawah disebut ...',
                'options' => [
                    'a' => 'Passing atas',
                    'b' => 'Smash / Spike',
                    'c' => 'Blocking',
                    'd' => 'Passing bawah',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Pemanasan (warming up) sebelum melakukan aktivitas olahraga inti bermanfaat untuk ...',
                'options' => [
                    'a' => 'Meningkatkan suhu tubuh dan elastisitas otot guna mencegah cedera',
                    'b' => 'Menghabiskan tenaga agar tidak terlalu lelah di akhir',
                    'c' => 'Mengurangi detak jantung agar tetap santai',
                    'd' => 'Menghilangkan kebutuhan minum selama latihan',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function pjokUas(): array
    {
        return [
            [
                'question' => 'Prosedur pertolongan pertama pada cedera terkilir (sprain) akut yang disingkat R.I.C.E adalah ...',
                'options' => [
                    'a' => 'Run, Ice, Care, Emergency',
                    'b' => 'Rest, Ice, Compression, Elevation',
                    'c' => 'Relax, Inhale, Calm, Exercise',
                    'd' => 'Rub, Immobilize, Clean, Evacuate',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Dampak negatif paling berbahaya dari penyalahgunaan NAPZA bagi kesehatan susunan saraf pusat adalah ...',
                'options' => [
                    'a' => 'Ketergantungan psikis dan fisik serta kerusakan permanen sel otak',
                    'b' => 'Meningkatnya nafsu makan berlebihan',
                    'c' => 'Otot menjadi lebih kekar dan kuat',
                    'd' => 'Kemampuan konsentrasi belajar menjadi sangat tinggi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Teknik pergantian tongkat estafet tanpa melihat pemberi tongkat (non-visual) sangat efektif digunakan pada nomor lari ...',
                'options' => [
                    'a' => '4 x 400 meter',
                    'b' => 'Maraton 42 km',
                    'c' => '4 x 100 meter',
                    'd' => 'Lari halang rintang 3000 meter',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Pola hidup sehat bergizi seimbang (gizi seimbang) menurut Kementerian Kesehatan menekankan pada ...',
                'options' => [
                    'a' => 'Makan makanan cepat saji berkalori tinggi setiap hari',
                    'b' => 'Konsumsi karbohidrat murni tanpa sayur dan buah',
                    'c' => 'Menghindari minum air putih berlebih',
                    'd' => 'Porsi makanan seimbang antara makanan pokok, lauk pauk, sayuran, dan buah-buahan serta cukup cairan',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Aktivitas pendinginan (cooling down) setelah olahraga bertujuan untuk ...',
                'options' => [
                    'a' => 'Menormalkan kembali denyut nadi dan membantu pembuangan asam laktat otot',
                    'b' => 'Menaikkan tekanan darah secara cepat',
                    'c' => 'Menghentikan sirkulasi darah ke otak',
                    'd' => 'Membuat otot berkontraksi lebih kencang',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= PKWU =================
    private static function pkwuUts(): array
    {
        return [
            [
                'question' => 'Analisis SWOT dalam perencanaan usaha terdiri dari empat elemen, yaitu ...',
                'options' => [
                    'a' => 'Sales, Wages, Operations, and Taxes',
                    'b' => 'Strengths, Weaknesses, Opportunities, and Threats',
                    'c' => 'Strategy, Wealth, Objectives, and Teamwork',
                    'd' => 'Service, Warranty, Output, and Target',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Biaya yang jumlahnya tetap sama berapapun kuantitas produk yang dihasilkan (misal biaya sewa tempat usaha) disebut ...',
                'options' => [
                    'a' => 'Fixed Cost (Biaya Tetap)',
                    'b' => 'Variable Cost (Biaya Variabel)',
                    'c' => 'Marginal Cost',
                    'd' => 'Opportunity Cost',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Harga Pokok Produksi (HPP) per unit barang dihitung dengan rumus ...',
                'options' => [
                    'a' => 'Total Penjualan dibagi Jumlah Karyawan',
                    'b' => 'Total Keuntungan dikurangi Pajak Usaha',
                    'c' => 'Total Biaya Produksi dibagi Jumlah Unit yang Dihasilkan',
                    'd' => 'Harga Jual dikalikan Persentase Diskon',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Sikap wirausahawan yang mampu melihat kegagalan sebagai bahan evaluasi dan berani mencoba kembali disebut ...',
                'options' => [
                    'a' => 'Pesimistis',
                    'b' => 'Oportunis sempit',
                    'c' => 'Konservatif',
                    'd' => 'Pantang menyerah dan resilien',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Nomor legalitas identitas berusaha tunggal yang diterbitkan oleh sistem OSS (Online Single Submission) di Indonesia adalah ...',
                'options' => [
                    'a' => 'NIB (Nomor Induk Berusaha)',
                    'b' => 'NPWP Pribadi',
                    'c' => 'AMDAL',
                    'd' => 'SKCK Perusahaan',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function pkwuUas(): array
    {
        return [
            [
                'question' => 'Titik impas di mana total pendapatan usaha sama persis dengan total modal/biaya yang dikeluarkan dinamakan ...',
                'options' => [
                    'a' => 'Return of Investment (ROI)',
                    'b' => 'Break Even Point (BEP)',
                    'c' => 'Net Present Value (NPV)',
                    'd' => 'Cash Flow Surplus',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Empat bauran pemasaran (Marketing Mix 4P) yang menjadi pilar strategi promosi produk adalah ...',
                'options' => [
                    'a' => 'Product, Price, Place, and Promotion',
                    'b' => 'People, Process, Profit, and Policy',
                    'c' => 'Power, Planning, Performance, and Position',
                    'd' => 'Package, Payment, Publicity, and Pitch',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kemasan produk pangan yang aman bersentuhan langsung dengan makanan dan minuman diberi label ...',
                'options' => [
                    'a' => 'Flammable',
                    'b' => 'Hazardous Waste',
                    'c' => 'Food Grade',
                    'd' => 'Industrial Use Only',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Alat manajemen strategis berupa diagram sembilan blok untuk memetakan model bisnis secara visual disebut ...',
                'options' => [
                    'a' => 'Fishbone Diagram',
                    'b' => 'Flowchart Algoritma',
                    'c' => 'Gantt Chart',
                    'd' => 'Business Model Canvas (BMC)',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Dalam laporan keuangan sederhana, rumus untuk menghitung laba bersih usaha adalah ...',
                'options' => [
                    'a' => 'Total Pendapatan dikurangi Total Seluruh Beban/Biaya dan Pajak',
                    'b' => 'Total Penjualan ditambah Modal Awal',
                    'c' => 'Total Aset dikalikan Margin Keuntungan',
                    'd' => 'Total Piutang dikurangi Utang Dagang',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= TIK =================
    private static function tikUts(): array
    {
        return [
            [
                'question' => 'Fitur pada aplikasi pengolah kata yang berfungsi membuat surat massal ke banyak penerima secara otomatis adalah ...',
                'options' => [
                    'a' => 'Track Changes',
                    'b' => 'Mail Merge',
                    'c' => 'Macro Recorder',
                    'd' => 'Footnote and Endnote',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Pada aplikasi spreadsheet (Microsoft Excel / Google Sheets), fungsi yang digunakan untuk mencari data vertikal pada tabel referensi adalah ...',
                'options' => [
                    'a' => 'HLOOKUP',
                    'b' => 'COUNTIF',
                    'c' => 'VLOOKUP',
                    'd' => 'CONCATENATE',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Perangkat keras komputer yang bertindak sebagai "otak utama" pemroses seluruh instruksi komputasi adalah ...',
                'options' => [
                    'a' => 'CPU (Central Processing Unit)',
                    'b' => 'RAM (Random Access Memory)',
                    'c' => 'Power Supply Unit',
                    'd' => 'Hard Disk Drive',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kombinasi tombol keyboard (shortcut) universal untuk membatalkan perintah tindakan terakhir (Undo) adalah ...',
                'options' => [
                    'a' => 'Ctrl + C',
                    'b' => 'Ctrl + V',
                    'c' => 'Ctrl + S',
                    'd' => 'Ctrl + Z',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Perangkat lunak yang mengontrol alokasi memori, proses CPU, dan sistem berkas pada komputer disebut ...',
                'options' => [
                    'a' => 'Sistem Operasi (Operating System)',
                    'b' => 'Aplikasi Spreadsheet',
                    'c' => 'Antivirus Utility',
                    'd' => 'Web Browser',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function tikUas(): array
    {
        return [
            [
                'question' => 'Format file gambar berbasis vektor yang dapat diperbesar tanpa kehilangan kualitas atau pecah adalah ...',
                'options' => [
                    'a' => 'JPEG',
                    'b' => 'SVG',
                    'c' => 'BMP',
                    'd' => 'GIF',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Upaya penipuan online dengan mengirim tautan web tiruan untuk mencuri kata sandi atau data perbankan korban disebut ...',
                'options' => [
                    'a' => 'Phishing',
                    'b' => 'DDoS Attack',
                    'c' => 'Defragmentasi',
                    'd' => 'Tethering',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Protokol transfer web yang terenkripsi aman menggunakan sertifikat digital ditandai dengan awalan URL ...',
                'options' => [
                    'a' => 'http://',
                    'b' => 'ftp://',
                    'c' => 'https://',
                    'd' => 'smtp://',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Penyimpanan cadangan file di server internet yang dapat diakses dari mana saja menggunakan akun pengguna disebut ...',
                'options' => [
                    'a' => 'Flashdisk lokal',
                    'b' => 'Disket magnetik',
                    'c' => 'ROM BIOS',
                    'd' => 'Cloud Storage (Penyimpanan Awan)',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Etika sopan santun dan tata tertib dalam berkomunikasi di dunia digital / internet dikenal dengan istilah ...',
                'options' => [
                    'a' => 'Netiket (Netiquette)',
                    'b' => 'Cyberbullying',
                    'c' => 'Spamming',
                    'd' => 'Copyright infringement',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= BIMBINGAN KONSELING =================
    private static function bimbinganKonselingUts(): array
    {
        return [
            [
                'question' => 'Kemampuan seseorang untuk memahami kekuatan, kelemahan, minat, dan potensi diri sendiri disebut ...',
                'options' => [
                    'a' => 'Self-awareness (Kesadaran diri)',
                    'b' => 'Egosentrisme',
                    'c' => 'Introvert ekstrem',
                    'd' => 'Konformitas sosial',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Gaya komunikasi yang mampu menyampaikan pendapat dan perasaan secara tegas, jujur, namun tetap menghargai orang lain disebut komunikasi ...',
                'options' => [
                    'a' => 'Pasif',
                    'b' => 'Asertif',
                    'c' => 'Agresif',
                    'd' => 'Manipulatif',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Metode manajemen waktu dengan membagi pekerjaan penting dan mendesak dipopulerkan dalam konsep ...',
                'options' => [
                    'a' => 'Diagram Pareto',
                    'b' => 'Analisis Fishbone',
                    'c' => 'Matriks Eisenhower',
                    'd' => 'Skala Likert',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Tindakan intimidasi berulang kali baik secara verbal, fisik, maupun digital yang merugikan orang lain dinamakan ...',
                'options' => [
                    'a' => 'Debat akademis',
                    'b' => 'Kompromi sosial',
                    'c' => 'Musyawarah mufakat',
                    'd' => 'Bullying (Perundungan)',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Langkah penanganan stres akademik yang paling sehat dan efektif bagi pelajar adalah ...',
                'options' => [
                    'a' => 'Mengatur jadwal istirahat, berolahraga ringan, dan bercerita kepada guru BK atau keluarga',
                    'b' => 'Mengurung diri di kamar dan membolos dari sekolah',
                    'c' => 'Menumpahkan kemarahan di media sosial secara membabi buta',
                    'd' => 'Mengonsumsi minuman berenergi tanpa batas waktu',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function bimbinganKonselingUas(): array
    {
        return [
            [
                'question' => 'Pilihan arah karier bagi lulusan Sekolah Menengah Kejuruan (SMK) sering disingkat BMW, yaitu ...',
                'options' => [
                    'a' => 'Belajar, Magang, dan Waspada',
                    'b' => 'Bekerja, Melanjutkan studi, dan Wirausaha',
                    'c' => 'Berbakti, Mengabdi, dan Wawasan',
                    'd' => 'Bakat, Minat, dan Waktu',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Keterampilan non-teknis seperti kemampuan kerja sama tim, komunikasi efektif, dan kepemimpinan dinamakan ...',
                'options' => [
                    'a' => 'Soft Skills',
                    'b' => 'Hard Skills',
                    'c' => 'Mechanical Skills',
                    'd' => 'Coding Skills',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sikap yang harus ditunjukkan saat menghadapi sesi wawancara kerja (interview) adalah ...',
                'options' => [
                    'a' => 'Datang terlambat dan mengenakan pakaian santai',
                    'b' => 'Menjawab pertanyaan dengan berbisik tanpa kontak mata',
                    'c' => 'Hadir tepat waktu, berpakaian rapi profesional, dan menjawab dengan lugas serta percaya diri',
                    'd' => 'Menceritakan kejelekan sekolah atau tempat magang terdahulu',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Kemampuan seseorang untuk bangkit kembali setelah mengalami kegagalan dan menghadapi tekanan dinamakan ...',
                'options' => [
                    'a' => 'Pesimisme',
                    'b' => 'Apati',
                    'c' => 'Dependensi',
                    'd' => 'Resiliensi',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Tujuan utama konseling perorangan bersama guru Bimbingan Konseling di sekolah adalah ...',
                'options' => [
                    'a' => 'Membantu siswa menemukan solusi mandiri atas hambatan pribadi, sosial, belajar, maupun karier',
                    'b' => 'Memberikan hukuman fisik kepada siswa bermasalah',
                    'c' => 'Mengumumkan kekurangan siswa di depan kelas',
                    'd' => 'Menentukan secara mutlak jurusan kuliah tanpa pertimbangan siswa',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= MUATAN LOKAL =================
    private static function muatanLokalUts(): array
    {
        return [
            [
                'question' => 'Penggunaan tingkatan bahasa (unggah-ungguh basa) dalam percakapan kepada orang yang lebih tua bertujuan untuk ...',
                'options' => [
                    'a' => 'Menunjukkan rasa hormat, sopan santun, dan tata krama pergaulan',
                    'b' => 'Mempersulit komunikasi antargenerasi',
                    'c' => 'Menghilangkan keakraban dalam keluarga',
                    'd' => 'Menghafal kosakata kuno tanpa makna',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Cerita rakyat nusantara yang menceritakan tentang asal-usul terjadinya Danau Toba berasal dari daerah ...',
                'options' => [
                    'a' => 'Sumatera Barat',
                    'b' => 'Sumatera Utara',
                    'c' => 'Jawa Timur',
                    'd' => 'Kalimantan Barat',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Rumah adat tradisional masyarakat Jawa yang memiliki atap khas berbentuk limas dan tiang utama saka guru dinamakan ...',
                'options' => [
                    'a' => 'Rumah Gadang',
                    'b' => 'Rumah Tongkonan',
                    'c' => 'Rumah Joglo',
                    'd' => 'Rumah Honai',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Upacara adat syukuran panen padi yang diadakan masyarakat Sunda di Banten dan Jawa Barat dinamakan ...',
                'options' => [
                    'a' => 'Ngaben',
                    'b' => 'Kasada',
                    'c' => 'Tiwah',
                    'd' => 'Seren Taun',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Salah satu bentuk kearifan lokal dalam menjaga kelestarian sumber daya hutan dan air adalah ...',
                'options' => [
                    'a' => 'Aturan larangan menebang pohon di hutan larangan/hutan lindung adat',
                    'b' => 'Menebang seluruh pohon untuk membangun kawasan industri',
                    'c' => 'Membuang limbah rumah tangga ke aliran sungai desa',
                    'd' => 'Menjual tanah ulayat kepada pihak asing',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function muatanLokalUas(): array
    {
        return [
            [
                'question' => 'Kerajinan tangan khas Jawa Tengah dan Yogyakarta yang memanfaatkan tanah liat yang dibakar dinamakan ...',
                'options' => [
                    'a' => 'Ukir kayu jepara',
                    'b' => 'Gerabah Kasongan',
                    'c' => 'Anyaman bambu tasik',
                    'd' => 'Kain tenun troso',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Makanan tradisional khas Yogyakarta yang berbahan baku nangka muda yang dimasak dengan santan dan rempah dalam waktu lama adalah ...',
                'options' => [
                    'a' => 'Gudeg',
                    'b' => 'Rawon',
                    'c' => 'Rendang',
                    'd' => 'Soto Betawi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pertunjukan seni teater rakyat tradisional khas Betawi yang kental dengan unsur humor dan kritik sosial adalah ...',
                'options' => [
                    'a' => 'Ketoprak',
                    'b' => 'Ludruk',
                    'c' => 'Lenong',
                    'd' => 'Wayang Golek',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Strategi paling efektif bagi generasi muda untuk melestarikan kebudayaan lokal di era digital adalah ...',
                'options' => [
                    'a' => 'Membuat konten kreatif edukatif mengenai seni, kuliner, dan kearifan lokal di media sosial',
                    'b' => 'Menolak mempelajari budaya daerah karena dianggap kuno',
                    'c' => 'Hanya mengonsumsi produk budaya asing secara eksklusif',
                    'd' => 'Melarang orang lain mengenal kebudayaan lokal daerahnya',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Senjata tradisional khas suku Jawa yang sarat dengan filosofi spiritual, estetika pamor, dan diakui UNESCO adalah ...',
                'options' => [
                    'a' => 'Rencong',
                    'b' => 'Mandau',
                    'c' => 'Kujang',
                    'd' => 'Keris',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }
}

