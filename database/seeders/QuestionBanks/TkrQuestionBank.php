<?php

namespace Database\Seeders\QuestionBanks;

class TkrQuestionBank
{
    public static function getQuestions(string $subjectBase, string $type): ?array
    {
        $map = [
            'Pengantar Otomotif' => 'dasarOtomotif',
            'Dasar Teknik Otomotif' => 'dasarOtomotif',
            'Sistem Kelistrikan' => 'kelistrikanOtomotif',
            'Elektronika Otomotif' => 'kelistrikanOtomotif',
            'Praktikum Bengkel' => 'k3Bengkel',
            'K3 Otomotif' => 'k3Bengkel',
            'Gambar Teknik Otomotif' => 'gambarTeknik',
            'Simulasi Kendaraan & CAD' => 'gambarTeknik',
            'Mesin Bensin' => 'mesinBensin',
            'Mesin Diesel' => 'mesinDiesel',
            'Sistem Bahan Bakar' => 'bahanBakarEfi',
            'Sistem Injeksi & EFI' => 'bahanBakarEfi',
            'Transmisi & Kopling' => 'transmisiKopling',
            'Suspensi & Kemudi' => 'suspensiKemudi',
            'Teknik Suspensi Lanjutan' => 'suspensiKemudi',
            'Perawatan Berkala' => 'perawatanDiagnostik',
            'Diagnostik Kendaraan' => 'perawatanDiagnostik',
            'Diagnostik Komputer Mobil' => 'perawatanDiagnostik',
            'Body Repair' => 'bodyRepairLas',
            'Teknik Pengelasan Otomotif' => 'bodyRepairLas',
            'Teknik Pendingin & AC' => 'pendinginAc',
            'Sistem Emisi Kendaraan' => 'emisiKendaraan',
            'Elektronika Kontrol Mesin' => 'kontrolEcu',
            'Sistem Hybrid & EV' => 'hybridEv',
            'Manajemen Bengkel' => 'manajemenBengkel',
            'Pengelolaan Suku Cadang' => 'manajemenBengkel',
            'Entrepreneurship Otomotif' => 'manajemenBengkel',
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

    // ================= DASAR TEKNIK OTOMOTIF =================
    private static function dasarOtomotifUts(): array
    {
        return [
            [
                'question' => 'Alat ukur mekanik presisi yang tepat digunakan untuk mengukur diameter luar batang klep (katup) dengan ketelitian hingga 0,01 mm adalah ...',
                'options' => [
                    'a' => 'Mistar baja',
                    'b' => 'Mikrometer luar (outside micrometer)',
                    'c' => 'Dial bore gauge',
                    'd' => 'Feeler gauge',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Pada jangka sorong (vernier caliper) dengan ketelitian 0,05 mm, fungsi rahang atas adalah untuk ...',
                'options' => [
                    'a' => 'Mengukur diameter dalam suatu benda silindris',
                    'b' => 'Mengukur diameter luar poros mesin',
                    'c' => 'Mengukur kedalaman lubang silinder',
                    'd' => 'Mengukur kekencangan torsi baut silinder',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kunci yang dirancang khusus untuk mengencangkan baut kepala silinder dengan nilai momen kekencangan terukur adalah ...',
                'options' => [
                    'a' => 'Kunci pas ring',
                    'b' => 'Kunci inggris',
                    'c' => 'Kunci momen (torque wrench)',
                    'd' => 'Kunci socket impact',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Pengertian siklus kerja motor bakar 4 langkah (4-tak) adalah ...',
                'options' => [
                    'a' => 'Satu siklus kerja diselesaikan dalam 1 putaran poros engkol',
                    'b' => 'Satu siklus kerja membutuhkan 4 kali putaran poros nok',
                    'c' => 'Dua siklus kerja diselesaikan dalam 1 langkah piston',
                    'd' => 'Satu siklus kerja diselesaikan dalam 4 langkah piston atau 2 putaran poros engkol',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Fungsi utama dari celah katup (valve clearance) pada mekanisme katup mesin adalah ...',
                'options' => [
                    'a' => 'Memberi ruang pemuaian batang katup saat mesin mencapai suhu kerja agar katup tetap menutup rapat',
                    'b' => 'Mempercepat aliran oli ke ruang pembakaran',
                    'c' => 'Membuat suara mesin menjadi lebih nyaring',
                    'd' => 'Menurunkan kompresi ruang bakar secara konstan',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function dasarOtomotifUas(): array
    {
        return [
            [
                'question' => 'Klasifikasi oli mesin yang menunjukkan tingkat kekentalan oli pada suhu rendah dan tinggi (misal SAE 10W-40) distandardisasi oleh ...',
                'options' => [
                    'a' => 'API (American Petroleum Institute)',
                    'b' => 'SAE (Society of Automotive Engineers)',
                    'c' => 'ISO (International Organization for Standardization)',
                    'd' => 'JASO (Japanese Automotive Standards Organization)',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Alat penopang mekanis yang wajib dipasang di bawah sasis kendaraan setelah mobil diangkat menggunakan dongkrak hidrolik adalah ...',
                'options' => [
                    'a' => 'Jack stand (safety stand)',
                    'b' => 'Pipa besi darurat',
                    'c' => 'Balok kayu bekas',
                    'd' => 'Batu bata penahan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pengukuran ketebalan celah (gap) elektroda busi dilakukan menggunakan alat ukur ...',
                'options' => [
                    'a' => 'Dial indicator',
                    'b' => 'Mistar sorong',
                    'c' => 'Feeler gauge (thickness gauge)',
                    'd' => 'Torsi meter',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Perbedaan mendasar antara mesin bensin (siklus Otto) dan mesin diesel (siklus Diesel) adalah ...',
                'options' => [
                    'a' => 'Mesin diesel menggunakan busi pemantik, mesin bensin tanpa busi',
                    'b' => 'Mesin bensin menyalakan campuran bahan bakar dengan percikan busi, mesin diesel dengan panas kompresi udara tinggi',
                    'c' => 'Mesin bensin tidak memerlukan oli pelumas',
                    'd' => 'Mesin diesel tidak memiliki piston dan klep',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Fungsi dari gasket kepala silinder (cylinder head gasket) adalah ...',
                'options' => [
                    'a' => 'Mencegah kebocoran kompresi ruang bakar, saluran oli pelumas, dan saluran air pendingin antar blok dan kepala silinder',
                    'b' => 'Menambah tenaga putaran poros engkol',
                    'c' => 'Mengatur pembukaan katup hisap',
                    'd' => 'Mendinginkan piston secara langsung',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= MESIN BENSIN =================
    private static function mesinBensinUts(): array
    {
        return [
            [
                'question' => 'Urutan langkah kerja mesin bensin 4 langkah yang benar adalah ...',
                'options' => [
                    'a' => 'Langkah buang -> Langkah usaha -> Langkah kompresi -> Langkah hisap',
                    'b' => 'Langkah hisap -> Langkah kompresi -> Langkah usaha (pembakaran) -> Langkah buang',
                    'c' => 'Langkah kompresi -> Langkah hisap -> Langkah buang -> Langkah usaha',
                    'd' => 'Langkah hisap -> Langkah usaha -> Langkah kompresi -> Langkah buang',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Pada saat langkah kompresi pada mesin bensin 4-tak, posisi kedua katup adalah ...',
                'options' => [
                    'a' => 'Katup hisap terbuka, katup buang tertutup',
                    'b' => 'Katup hisap tertutup, katup buang terbuka',
                    'c' => 'Kedua katup (hisap dan buang) sama-sama tertutup rapat',
                    'd' => 'Kedua katup sama-sama terbuka penuh',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Fungsi utama ring piston (ring kompresi dan ring oli) yang terpasang pada alur piston adalah ...',
                'options' => [
                    'a' => 'Mencegah kebocoran gas kompresi dan menyapu kelebihan oli pelumas pada dinding silinder',
                    'b' => 'Menyambungkan piston langsung ke poros roda',
                    'c' => 'Mengatur debit bensin dari tangki ke karburator',
                    'd' => 'Menggerakkan katup hisap dan buang',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Gejala knocking (detonasi) atau "ngelitik" pada mesin bensin umumnya disebabkan oleh ...',
                'options' => [
                    'a' => 'Nilai oktan bensin terlalu rendah atau saat pengapian terlalu maju (terlalu awal)',
                    'b' => 'Oli mesin terlalu kental',
                    'c' => 'Filter udara terlalu bersih',
                    'd' => 'Knalpot mengalami kebocoran udara',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen sistem pendingin mesin yang berfungsi menahan sirkulasi air pendingin ke radiator hingga mesin mencapai suhu kerja ideal (sekitar 82-90°C) adalah ...',
                'options' => [
                    'a' => 'Water pump (pompa air)',
                    'b' => 'Reservoir tank',
                    'c' => 'Thermostat',
                    'd' => 'Kipas radiator',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    private static function mesinBensinUas(): array
    {
        return [
            [
                'question' => 'Alat ukur yang digunakan untuk mengetahui besarnya tekanan kompresi pada masing-masing silinder mesin bensin adalah ...',
                'options' => [
                    'a' => 'Vacuum tester',
                    'b' => 'Compression tester',
                    'c' => 'Timing light',
                    'd' => 'Tachometer',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Komponen yang berfungsi mengubah gerak translasi (naik turun) piston menjadi gerak putar pada mesin adalah ...',
                'options' => [
                    'a' => 'Poros engkol (crankshaft)',
                    'b' => 'Poros nok (camshaft)',
                    'c' => 'Batang penekan (push rod)',
                    'd' => 'Roda gila (flywheel)',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi utama tutup radiator (radiator cap) yang dilengkapi relief valve dan vacuum valve adalah ...',
                'options' => [
                    'a' => 'Mengunci radiator agar tidak dicuri',
                    'b' => 'Menyaring kotoran debu dari udara luar',
                    'c' => 'Mempertahankan tekanan sistem pendingin agar titik didih air meningkat dan mengalirkan kelebihan cairan ke tangki cadangan',
                    'd' => 'Mendinginkan oli transmisi secara langsung',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Akibat jika celah katup (valve clearance) disetel terlalu rapat atau tidak ada celah sama sekali adalah ...',
                'options' => [
                    'a' => 'Suara mesin menjadi sangat berisik',
                    'b' => 'Katup tidak dapat menutup rapat saat panas sehingga terjadi kebocoran kompresi dan kehilangan tenaga',
                    'c' => 'Busi cepat mati karena terendam oli',
                    'd' => 'Putaran idle mesin menjadi terlalu tinggi',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Komponen mesin yang berfungsi menyimpan energi kinetik putaran selama langkah usaha untuk memutar poros engkol pada langkah lainnya adalah ...',
                'options' => [
                    'a' => 'Piston pin',
                    'b' => 'Timing chain',
                    'c' => 'Oil pump',
                    'd' => 'Flywheel (roda penerus / roda gila)',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }

    // ================= MESIN DIESEL =================
    private static function mesinDieselUts(): array
    {
        return [
            [
                'question' => 'Prinsip kerja penyalaan bahan bakar pada mesin diesel adalah ...',
                'options' => [
                    'a' => 'Penyalaan sendiri akibat panas udara yang dikompresi sangat tinggi di ruang bakar',
                    'b' => 'Penyalaan oleh percikan bunga api busi tegangan tinggi',
                    'c' => 'Penyalaan oleh radiasi inframerah dari sensor mesin',
                    'd' => 'Penyalaan akibat pemanasan awal baterai aki',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen pemanas awal yang berfungsi memanaskan ruang bakar mesin diesel saat start dingin adalah ...',
                'options' => [
                    'a' => 'Busi pemantik biasa',
                    'b' => 'Busi pijar (glow plug)',
                    'c' => 'Injektor solenoid',
                    'd' => 'Heater core kabin',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Komponen pada sistem bahan bakar diesel konvensional yang berfungsi memisahkan kandungan air dari bahan bakar solar adalah ...',
                'options' => [
                    'a' => 'Water sedimenter',
                    'b' => 'Priming pump',
                    'c' => 'Fuel rail',
                    'd' => 'Delivery valve',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perbandingan kompresi (compression ratio) pada mesin diesel umumnya berkisar antara ...',
                'options' => [
                    'a' => '8 : 1 sampai 10 : 1',
                    'b' => '9 : 1 sampai 11 : 1',
                    'c' => '16 : 1 sampai 23 : 1',
                    'd' => '25 : 1 sampai 35 : 1',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Penyebab utama timbulnya asap hitam pekat dari knalpot mesin diesel adalah ...',
                'options' => [
                    'a' => 'Campuran bahan bakar terlalu kaya (kelebihan solar) atau pasokan udara masuk kurang sempurna',
                    'b' => 'Oli mesin ikut terbakar di ruang bakar',
                    'c' => 'Cairan pendingin mesin bocor ke silinder',
                    'd' => 'Busi pijar menyala terus menerus saat mesin hidup',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function mesinDieselUas(): array
    {
        return [
            [
                'question' => 'Kelebihan utama teknologi Common Rail Direct Injection (CRDi) pada mesin diesel modern dibanding sistem konvensional adalah ...',
                'options' => [
                    'a' => 'Tidak lagi memerlukan saringan bahan bakar solar',
                    'b' => 'Tekanan injeksi bahan bakar sangat tinggi dan dikontrol secara presisi oleh ECU pada berbagai putaran mesin',
                    'c' => 'Mesin tidak memerlukan pendinginan cairan radiator',
                    'd' => 'Dapat beroperasi menggunakan bahan bakar bensin pertalite',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tindakan membuang udara palsu yang terperangkap di dalam saluran sistem bahan bakar diesel disebut ...',
                'options' => [
                    'a' => 'Flushing radiator',
                    'b' => 'Balancing roda',
                    'c' => 'Bleeding sistem bahan bakar',
                    'd' => 'Tuning ECU',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Komponen induksi paksa (turbocharger) pada mesin diesel digerakkan oleh ...',
                'options' => [
                    'a' => 'Aliran gas buang (exhaust gas) dari ruang bakar',
                    'b' => 'Sabuk v-belt yang terhubung ke poros engkol',
                    'c' => 'Motor listrik 12 volt aki',
                    'd' => 'Tekanan pompa bahan bakar solar',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen pendingin udara yang bertugas menurunkan suhu udara bertekanan dari turbocharger sebelum masuk ke intake manifold adalah ...',
                'options' => [
                    'a' => 'Radiator mesin',
                    'b' => 'Intercooler',
                    'c' => 'Oil cooler',
                    'd' => 'Kondensor AC',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Alat yang digunakan di bengkel untuk menguji tekanan pembukaan injektor dan bentuk pengabutan nosel diesel adalah ...',
                'options' => [
                    'a' => 'Manifold gauge',
                    'b' => 'Timing light tester',
                    'c' => 'Diesel injector tester (nozzle tester)',
                    'd' => 'Multimeter digital',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    // ================= KELISTRIKAN & ELEKTRONIKA OTOMOTIF =================
    private static function kelistrikanOtomotifUts(): array
    {
        return [
            [
                'question' => 'Berat jenis (BJ) cairan elektrolit baterai (aki) mobil dalam kondisi terisi penuh (fully charged) pada suhu 20°C adalah sekitar ...',
                'options' => [
                    'a' => '1,00 - 1,05',
                    'b' => '1,10 - 1,15',
                    'c' => '1,26 - 1,28',
                    'd' => '1,35 - 1,40',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Komponen pengaman rangkaian kelistrikan yang dirancang untuk memutus arus ketika terjadi beban berlebih atau hubungan pendek (konsleting) adalah ...',
                'options' => [
                    'a' => 'Sekring (fuse)',
                    'b' => 'Relay',
                    'c' => 'Alternator',
                    'd' => 'Kondensator',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen sakelar elektromagnetik yang berfungsi mengalirkan arus listrik besar ke beban dengan sinyal kontrol arus kecil adalah ...',
                'options' => [
                    'a' => 'Fuse link',
                    'b' => 'Relay',
                    'c' => 'Sakelar manual switch',
                    'd' => 'Resistor variabel',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Komponen sistem pengisian (charging system) yang bertugas membangkitkan arus listrik bolak-balik (AC) dan mengubahnya menjadi arus searah (DC) untuk menyuplai kelistrikan mobil dan mengisi aki adalah ...',
                'options' => [
                    'a' => 'Motor starter',
                    'b' => 'Koil pengapian',
                    'c' => 'Distributor pengapian',
                    'd' => 'Alternator',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Komponen sistem starter mobil yang berfungsi meneruskan putaran motor starter ke ring gear roda gila dan mencegah motor starter berputar berlebih saat mesin hidup adalah ...',
                'options' => [
                    'a' => 'Overrunning clutch (starter clutch)',
                    'b' => 'Field coil',
                    'c' => 'Armature brake',
                    'd' => 'Solenoid switch',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function kelistrikanOtomotifUas(): array
    {
        return [
            [
                'question' => 'Komponen pada rangkaian lampu tanda belok (sein) yang berfungsi membuat lampu berkedip secara periodik adalah ...',
                'options' => [
                    'a' => 'Relay 4-kaki',
                    'b' => 'Flasher unit',
                    'c' => 'Fuse 10A',
                    'd' => 'Dioda Zener',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Koil pengapian (ignition coil) pada mesin bensin berfungsi untuk ...',
                'options' => [
                    'a' => 'Menaikkan tegangan baterai 12V menjadi tegangan tinggi sekitar 15.000 - 30.000V untuk memercikkan api pada busi',
                    'b' => 'Menurunkan tegangan aki menjadi 5V untuk sensor',
                    'c' => 'Mengubah arus AC dari alternator menjadi arus DC',
                    'd' => 'Mengukur jumlah arus yang mengalir ke baterai',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pengukuran hambatan (resistansi) kumparan koil pengapian menggunakan multimeter digital dilakukan pada posisi selektor ...',
                'options' => [
                    'a' => 'DC Volt (V)',
                    'b' => 'AC Volt (~V)',
                    'c' => 'Ohm (Ω)',
                    'd' => 'Ampere (A)',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Sistem transmisi data antarmodul kontrol elektronik pada kendaraan modern menggunakan jaringan dua kabel berpilin yang dinamakan ...',
                'options' => [
                    'a' => 'Kabel koaksial TV',
                    'b' => 'Kabel UTP Cat 6',
                    'c' => 'Serat optik TOSLINK',
                    'd' => 'CAN-Bus (Controller Area Network)',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Lampu indikator baterai (aki) pada panel instrumen menyala terus saat mesin mobil sedang berputar normal menandakan bahwa ...',
                'options' => [
                    'a' => 'Sistem pengisian (alternator) tidak berfungsi mengisi aki dengan baik',
                    'b' => 'Kapasitas baterai sedang penuh 100%',
                    'c' => 'Busi mengalami korsleting',
                    'd' => 'Lampu kepala depan putus filamennya',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= SISTEM BAHAN BAKAR & EFI =================
    private static function bahanBakarEfiUts(): array
    {
        return [
            [
                'question' => 'Perbandingan campuran udara dan bahan bakar secara stoikiometri yang paling ideal untuk pembakaran sempurna pada mesin bensin adalah ...',
                'options' => [
                    'a' => '10 : 1',
                    'b' => '12 : 1',
                    'c' => '14,7 : 1',
                    'd' => '18 : 1',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Sensor pada sistem EFI yang bertugas mendeteksi sudut pembukaan katup gas throttle adalah ...',
                'options' => [
                    'a' => 'Throttle Position Sensor (TPS)',
                    'b' => 'Intake Air Temperature (IAT) sensor',
                    'c' => 'Engine Coolant Temperature (ECT) sensor',
                    'd' => 'Oxygen (O2) sensor',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen yang berfungsi mengatur kestabilan tekanan bahan bakar pada pipa pembagi (fuel delivery pipe) sistem EFI adalah ...',
                'options' => [
                    'a' => 'Fuel pulsation damper',
                    'b' => 'Pressure regulator',
                    'c' => 'Fuel filter',
                    'd' => 'Fuel pump check valve',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Sensor Manifold Absolute Pressure (MAP) pada sistem EFI tipe D-Jetronic berfungsi untuk ...',
                'options' => [
                    'a' => 'Mengukur jumlah massa aliran udara masuk secara langsung',
                    'b' => 'Mengukur kadar gas buang di knalpot',
                    'c' => 'Mengukur kelembaban udara ruang mesin',
                    'd' => 'Mendeteksi tingkat kevakuman (tekanan mutlak) di dalam intake manifold',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Aktuator pada sistem injeksi bahan bakar yang bertugas menyemprotkan bensin dalam bentuk kabut halus ke saluran masuk adalah ...',
                'options' => [
                    'a' => 'Injektor (Fuel Injector)',
                    'b' => 'Spark plug',
                    'c' => 'Idle Air Control valve',
                    'd' => 'VVT-i solenoid',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function bahanBakarEfiUas(): array
    {
        return [
            [
                'question' => 'Sensor yang berfungsi mendeteksi kadar oksigen sisa pembakaran pada gas buang untuk memberikan umpan balik (closed loop feedback) ke ECU adalah ...',
                'options' => [
                    'a' => 'Crankshaft Position (CKP) sensor',
                    'b' => 'Oxygen (O2) sensor',
                    'c' => 'Knock sensor',
                    'd' => 'Camshaft Position (CMP) sensor',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Aktuator Idle Air Control (IAC / ISC) pada sistem EFI bertugas untuk ...',
                'options' => [
                    'a' => 'Mengatur jumlah suplai udara bypass saat pedal gas tidak diinjak guna mempertahankan putaran stasioner (idle)',
                    'b' => 'Mengatur volume oli mesin yang masuk ke filter',
                    'c' => 'Mematikan mesin secara darurat jika overheat',
                    'd' => 'Mengubah timing pengapian secara mekanis',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Apabila lampu Check Engine (Malfunction Indicator Lamp / MIL) menyala di dasbor, langkah diagnostik awal teknisi adalah ...',
                'options' => [
                    'a' => 'Langsung membongkar kepala silinder mesin',
                    'b' => 'Menghubungkan scanner diagnostik OBD-II pada port DLC untuk membaca kode kerusakan (DTC)',
                    'c' => 'Menguras oli mesin dan air radiator',
                    'd' => 'Mengganti seluruh kabel kelistrikan mobil',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Kondisi kerja mesin saat sistem EFI menggunakan koreksi durasi injeksi berdasarkan sinyal sensor oksigen disebut mode ...',
                'options' => [
                    'a' => 'Open loop',
                    'b' => 'Limp home mode',
                    'c' => 'Closed loop',
                    'd' => 'Cold start mode',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Pembersihan endapan karbon pada injektor bahan bakar di bengkel modern dilakukan menggunakan alat ...',
                'options' => [
                    'a' => 'Gerinda putar kecepatan tinggi',
                    'b' => 'Ultrasonic cleaner and injector tester',
                    'c' => 'Kuas kawat baja',
                    'd' => 'Semburan air bertekanan tinggi',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    // ================= TRANSMISI & KOPLING =================
    private static function transmisiKoplingUts(): array
    {
        return [
            [
                'question' => 'Fungsi utama sistem kopling (clutch) pada kendaraan bermotor transmisi manual adalah ...',
                'options' => [
                    'a' => 'Menghubungkan dan memutuskan putaran mesin ke sistem transmisi secara bertahap dan halus',
                    'b' => 'Meningkatkan kecepatan putaran mesin secara otomatis',
                    'c' => 'Mengerem roda belakang saat kondisi darurat',
                    'd' => 'Menyetel sudut kelurusan roda depan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen kopling manual yang berfungsi menekan pelat kopling (clutch disc) ke permukaan roda gila (flywheel) adalah ...',
                'options' => [
                    'a' => 'Release bearing',
                    'b' => 'Pelat penekan (pressure plate) pada cover clutch',
                    'c' => 'Garpu pembebas (release fork)',
                    'd' => 'Master silinder kopling',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Gejala kopling selip (clutch slip) saat mobil sedang melaju dan pedal gas diinjak ditandai dengan ...',
                'options' => [
                    'a' => 'Pedal rem bergetar keras',
                    'b' => 'Mesin mati mendadak saat masuk gigi',
                    'c' => 'Putaran mesin (RPM) naik tinggi tetapi laju kecepatan mobil tidak bertambah sebanding',
                    'd' => 'Setir terasa menarik ke salah satu arah',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Komponen transmisi manual yang berfungsi menyamakan putaran antara gigi transmisi dan poros output sebelum terjadi keterikatan gigi adalah ...',
                'options' => [
                    'a' => 'Input shaft gear',
                    'b' => 'Counter gear',
                    'c' => 'Reverse idler gear',
                    'd' => 'Synchronizer ring (sinkromes)',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Perbandingan gigi (gear ratio) pada posisi gigi 1 transmisi manual memiliki karakteristik ...',
                'options' => [
                    'a' => 'Momen puntir (torsi) besar untuk awalan jalan dengan kecepatan putar output rendah',
                    'b' => 'Kecepatan tinggi dengan torsi sangat kecil',
                    'c' => 'Putaran poros output sama persis dengan poros input (1 : 1)',
                    'd' => 'Putaran output lebih cepat daripada putaran input (overdrive)',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function transmisiKoplingUas(): array
    {
        return [
            [
                'question' => 'Komponen penggerak pada transmisi otomatis tipe Continuously Variable Transmission (CVT) yang bertugas mentransfer tenaga dengan rasio tak terhingga adalah ...',
                'options' => [
                    'a' => 'Dua pasang puli variabel (driver & driven pulley) yang dihubungkan sabuk baja (steel belt)',
                    'b' => 'Roda gigi sinkromes kuningan',
                    'c' => 'Poros gardan kaku',
                    'd' => 'Rantai baja bergigi ganda',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen hidrolik pada transmisi otomatis konvensional (AT) yang berfungsi menggantikan peran kopling mekanis untuk memindahkan tenaga secara fluida adalah ...',
                'options' => [
                    'a' => 'Synchronizer hub',
                    'b' => 'Torque converter',
                    'c' => 'Manual shift fork',
                    'd' => 'Clutch release cylinder',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Komponen gardan (differential) pada mobil penggerak roda belakang (FR) berfungsi untuk ...',
                'options' => [
                    'a' => 'Membedakan kecepatan putaran roda kiri dan roda kanan saat kendaraan berbelok',
                    'b' => 'Menggantikan oli transmisi saat melaju kencang',
                    'c' => 'Mencegah mobil melaju melebihi batas kecepatan',
                    'd' => 'Menyaring kotoran dari tromol rem belakang',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen pada poros propeler (propeller shaft) yang berfungsi memungkinkan terjadinya perubahan sudut pergerakan poros saat mobil melewati jalan tidak rata adalah ...',
                'options' => [
                    'a' => 'Slip joint',
                    'b' => 'Universal joint (cross joint)',
                    'c' => 'Center bearing',
                    'd' => 'Drive pinion',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Kondisi transmisi di mana putaran poros output berputar lebih cepat dibanding putaran poros input mesin dinamakan ...',
                'options' => [
                    'a' => 'Underdrive',
                    'b' => 'Direct drive (1 : 1)',
                    'c' => 'Overdrive',
                    'd' => 'Reverse gear',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    // ================= SUSPENSI & KEMUDI =================
    private static function suspensiKemudiUts(): array
    {
        return [
            [
                'question' => 'Fungsi utama peredam kejut (shock absorber) pada sistem suspensi kendaraan adalah ...',
                'options' => [
                    'a' => 'Menahan seluruh bobot sasis kendaraan secara kaku',
                    'b' => 'Meredam osilasi (ayunan berulang) pegas suspensi agar mobil stabil dan nyaman',
                    'c' => 'Menyetel sudut belok roda kemudi secara otomatis',
                    'd' => 'Mencegah ban mengalami keausan permukaan',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tipe suspensi independen depan yang sangat umum diaplikasikan pada mobil sedan dan MPV modern karena konstruksinya kompak dan sederhana adalah ...',
                'options' => [
                    'a' => 'Suspensi MacPherson Strut',
                    'b' => 'Suspensi pegas daun kaku (rigid leaf spring)',
                    'c' => 'Suspensi batang torsi statis',
                    'd' => 'Suspensi balok ayun ganda',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen kemudi yang berfungsi mengubah gerak putar roda kemudi (steering wheel) menjadi gerak mendatar untuk menggeser tie rod pada sistem kemudi modern adalah ...',
                'options' => [
                    'a' => 'Steering column',
                    'b' => 'Steering rack and pinion',
                    'c' => 'Pitman arm',
                    'd' => 'Idler arm',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Sistem kemudi Electric Power Steering (EPS) bekerja meringankan putaran setir pengemudi dengan memanfaatkan tenaga dari ...',
                'options' => [
                    'a' => 'Pompa oli hidrolik yang diputar sabuk mesin',
                    'b' => 'Tekanan kevakuman intake manifold',
                    'c' => 'Motor listrik (DC motor) yang dikontrol oleh modul komputer EPS',
                    'd' => 'Peredam gas nitrogen bertekanan',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Komponen suspensi yang berfungsi sebagai engsel tumpuan putaran vertikal dan belok pada knuckle arm suspensi roda adalah ...',
                'options' => [
                    'a' => 'Stabilizer bar bushing',
                    'b' => 'Coil spring',
                    'c' => 'Strut bar',
                    'd' => 'Ball joint',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }

    private static function suspensiKemudiUas(): array
    {
        return [
            [
                'question' => 'Sudut kemiringan roda depan terhadap garis vertikal jika dilihat dari arah depan kendaraan disebut sudut ...',
                'options' => [
                    'a' => 'Camber',
                    'b' => 'Caster',
                    'c' => 'Toe-in',
                    'd' => 'Kingpin inclination',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi sudut Caster positif pada penyetelan geometri roda (wheel alignment / spooring) adalah ...',
                'options' => [
                    'a' => 'Membuat setir mudah belok saat diam saja',
                    'b' => 'Memberikan kestabilan laju lurus ke depan dan efek kembali lurus otomatis pada roda kemudi setelah berbelok',
                    'c' => 'Mengurangi pemakaian bahan bakar secara ekstrem',
                    'd' => 'Menghilangkan fungsi shock absorber',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Kondisi selisih jarak antara roda depan bagian muka lebih kecil daripada roda depan bagian belakang disebut sudut ...',
                'options' => [
                    'a' => 'Toe-out',
                    'b' => 'Camber negatif',
                    'c' => 'Toe-in',
                    'd' => 'Caster mundur',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Komponen suspensi yang berfungsi mengurangi kemiringan bodi mobil (body roll) saat bermanuver menikung tajam adalah ...',
                'options' => [
                    'a' => 'Stabilizer bar (sway bar)',
                    'b' => 'Tie rod end',
                    'c' => 'Lower arm ball joint',
                    'd' => 'Bumper jounce stop',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Penyebab setir mobil bergetar hebat saat mobil melaju pada kecepatan tinggi (sekitar 80-100 km/jam) umumnya karena ...',
                'options' => [
                    'a' => 'Minyak rem berkurang',
                    'b' => 'Roda dan ban depan tidak seimbang (butuh proses wheel balancing)',
                    'c' => 'Cairan wiper habis',
                    'd' => 'Sekring klakson putus',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    // ================= PERAWATAN & DIAGNOSTIK =================
    private static function perawatanDiagnostikUts(): array
    {
        return [
            [
                'question' => 'Pada pemeriksaan rutin level oli mesin menggunakan dipstick oli, ketinggian oli yang ideal harus berada pada posisi ...',
                'options' => [
                    'a' => 'Di bawah batas garis Low (L)',
                    'b' => 'Di antara tanda batas Low (L) dan Full (F)',
                    'c' => 'Jauh di atas batas Full (F) hingga meluap',
                    'd' => 'Menempel pada leher tabung pengisian oli',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Servis berkala kendaraan ringan di bengkel resmi umumnya dianjurkan dilakukan setiap interval kelipatan ...',
                'options' => [
                    'a' => '1.000 km atau 1 bulan',
                    'b' => '10.000 km atau 6 bulan (mana yang tercapai lebih dulu)',
                    'c' => '50.000 km atau 3 tahun',
                    'd' => '100.000 km tanpa batas waktu',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tekanan angin ban mobil standar pabrik untuk kendaraan penumpang keluarga pada umumnya berkisar antara ...',
                'options' => [
                    'a' => '10 - 15 psi',
                    'b' => '30 - 35 psi',
                    'c' => '60 - 70 psi',
                    'd' => '90 - 100 psi',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tanda fisik visual yang menunjukkan bahwa cairan rem (brake fluid) sudah terkontaminasi air dan kotor sehingga wajib diganti adalah ...',
                'options' => [
                    'a' => 'Warnanya berubah menjadi cokelat tua keruh atau kehitaman',
                    'b' => 'Warnanya bening jernih kekuningan',
                    'c' => 'Baunya harum seperti sabun',
                    'd' => 'Teksturnya mengkristal menjadi es',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Port konektor diagnostik standar 16-pin pada mobil modern untuk menghubungkan scanner komputer OBD-II dinamakan ...',
                'options' => [
                    'a' => 'Port USB Type-C',
                    'b' => 'Konektor RJ-45',
                    'c' => 'DLC (Data Link Connector)',
                    'd' => 'Socket Lighter 12V',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    private static function perawatanDiagnostikUas(): array
    {
        return [
            [
                'question' => 'Pada scanner otomotif, singkatan DTC yang berisi kode rekam kerusakan dari sistem ECU adalah kepanjangan dari ...',
                'options' => [
                    'a' => 'Digital Transmission Control',
                    'b' => 'Data Technical Center',
                    'c' => 'Dynamic Torque Calibration',
                    'd' => 'Diagnostic Trouble Code',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Fitur pada scan tool yang menampilkan data bacaan sensor secara langsung (real-time) saat mesin sedang hidup disebut fitur ...',
                'options' => [
                    'a' => 'Clear DTC',
                    'b' => 'Live Data Stream / Data List',
                    'c' => 'ECU Version Info',
                    'd' => 'Freeze Frame History',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Langkah penanganan yang benar setelah melakukan perbaikan fisik pada sensor yang rusak adalah ...',
                'options' => [
                    'a' => 'Menghapus (clear) riwayat kode kesalahan DTC menggunakan scanner lalu melakukan uji jalan (test drive)',
                    'b' => 'Memutus kabel aki selamanya',
                    'c' => 'Mencopot lampu check engine dari speedometer',
                    'd' => 'Membiarkan kode error tersimpan permanen',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Alat uji gas buang otomotif (gas analyzer) digunakan untuk mengukur konsentrasi gas emisi berikut, kecuali ...',
                'options' => [
                    'a' => 'Karbon Monoksida (CO)',
                    'b' => 'Hidrokarbon (HC)',
                    'c' => 'Klorofluorokarbon (CFC)',
                    'd' => 'Karbon Dioksida (CO2) dan Oksigen (O2)',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Alat ukur digital yang digunakan teknisi untuk memeriksa bentuk grafik gelombang frekuensi sinyal sensor CKP dan CMP adalah ...',
                'options' => [
                    'a' => 'Osiloskop otomotif (oscilloscope)',
                    'b' => 'Test lamp DC',
                    'c' => 'Manifold gauge',
                    'd' => 'Tachometer laser',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= BODY REPAIR & PENGELASAN =================
    private static function bodyRepairLasUts(): array
    {
        return [
            [
                'question' => 'Gas pelindung yang umum digunakan pada proses pengelasan bodi mobil tipe MIG/GMAW untuk pelat baja tipis adalah ...',
                'options' => [
                    'a' => 'Gas Oksigen murni',
                    'b' => 'Gas Asetilin',
                    'c' => 'Campuran Gas Argon dan Karbon Dioksida (Ar + CO2)',
                    'd' => 'Gas Freon pendingin',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Alat pelindung diri (APD) utama yang wajib dikenakan untuk melindungi mata dan wajah dari sinar ultraviolet dan percikan api saat mengelas adalah ...',
                'options' => [
                    'a' => 'Topeng las / helm las (welding helmet)',
                    'b' => 'Kacamata hitam gaya',
                    'c' => 'Topi kain biasa',
                    'd' => 'Masker debu kertas',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Material pengisi berbahan dasar resin polyester yang dicampur bahan pengeras (hardener) untuk meratakan lekukan bodi mobil sebelum dicat adalah ...',
                'options' => [
                    'a' => 'Dempul bodi (body filler / putty)',
                    'b' => 'Semen putih',
                    'c' => 'Lem silikon perekat',
                    'd' => 'Plastisin mainan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Peralatan mekanik tangan khusus yang digunakan untuk meratakan panel pelat bodi mobil yang penyok dari dua sisi adalah ...',
                'options' => [
                    'a' => 'Gunting baja dan paku keling',
                    'b' => 'Palu bodi (body hammer) dan dolly',
                    'c' => 'Obeng ketok dan tang jepit',
                    'd' => 'Kunci inggris dan dongkrak',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tingkat kekasaran amplas ditentukan oleh nomor grit. Amplas yang menghasilkan permukaan paling halus di bawah ini adalah nomor ...',
                'options' => [
                    'a' => 'Grit 80',
                    'b' => 'Grit 120',
                    'c' => 'Grit 400',
                    'd' => 'Grit 2000',
                ],
                'correct_answer' => 'd',
            ],
        ];
    }

    private static function bodyRepairLasUas(): array
    {
        return [
            [
                'question' => 'Urutan lapisan pengecatan bodi kendaraan yang benar dari dasar pelat logam hingga lapisan akhir adalah ...',
                'options' => [
                    'a' => 'Clear coat -> Cat warna -> Dempul -> Primer anti karat',
                    'b' => 'Primer anti karat (epoxy) -> Dempul -> Surfacer -> Cat warna (base coat) -> Clear coat (pernis)',
                    'c' => 'Cat warna -> Surfacer -> Primer -> Clear coat',
                    'd' => 'Dempul -> Clear coat -> Cat warna -> Anti karat',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Cacat hasil pengecatan bodi yang ditandai dengan munculnya lubang-lubang kecil mirip kawah akibat kontaminasi minyak atau silikon pada permukaan dinamakan ...',
                'options' => [
                    'a' => 'Fish eye (mata ikan)',
                    'b' => 'Orange peel (kulit jeruk)',
                    'c' => 'Runs (cat meleleh)',
                    'd' => 'Blistering',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Alat las tarik otomatis yang digunakan untuk menarik cekungan bodi mobil dari bagian luar tanpa harus membongkar doortrim interior adalah ...',
                'options' => [
                    'a' => 'Las karbit asetilin',
                    'b' => 'Spot welder dent puller',
                    'c' => 'Solder listrik timah',
                    'd' => 'Heat gun pengering',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Ruangan khusus di bengkel body repair yang dilengkapi sistem penyaring udara, ventilasi hisap, dan pemanas oven pengering cat dinamakan ...',
                'options' => [
                    'a' => 'Spray booth / paint booth',
                    'b' => 'Gudang suku cadang',
                    'c' => 'Pit service',
                    'd' => 'Car wash area',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi lapisan clear coat (pernis) pada proses finishing pengecatan bodi kendaraan adalah ...',
                'options' => [
                    'a' => 'Memberikan kilau permukaan serta melindungi lapisan cat warna dari paparan sinar UV dan goresan ringan',
                    'b' => 'Menggantikan primer anti karat',
                    'c' => 'Mengubah warna dasar menjadi lebih gelap',
                    'd' => 'Merekatkan pelat bodi yang retak',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= TEKNIK PENDINGIN & AC =================
    private static function pendinginAcUts(): array
    {
        return [
            [
                'question' => 'Siklus sirkulasi refrigeran (freon) pada sistem AC mobil yang benar secara berurutan adalah ...',
                'options' => [
                    'a' => 'Kompresor -> Kondensor -> Receiver Dryer -> Katup Ekspansi -> Evaporator -> Kompresor',
                    'b' => 'Evaporator -> Kondensor -> Kompresor -> Katup Ekspansi -> Receiver Dryer',
                    'c' => 'Kondensor -> Evaporator -> Katup Ekspansi -> Kompresor -> Receiver Dryer',
                    'd' => 'Kompresor -> Evaporator -> Receiver Dryer -> Kondensor -> Katup Ekspansi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Jenis refrigeran (zat pendingin) ramah lingkungan yang paling umum digunakan pada sistem AC mobil konvensional saat ini adalah ...',
                'options' => [
                    'a' => 'R11',
                    'b' => 'R12',
                    'c' => 'R134a',
                    'd' => 'R22',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Komponen AC mobil yang berfungsi menyerap panas dari udara di dalam kabin penumpang sehingga udara yang dihembuskan blower menjadi dingin adalah ...',
                'options' => [
                    'a' => 'Kondensor',
                    'b' => 'Evaporator',
                    'c' => 'Receiver dryer',
                    'd' => 'Kompresor',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Komponen yang berfungsi menghubungkan dan memutuskan putaran mesin ke poros kompresor AC menggunakan gaya elektromagnetik adalah ...',
                'options' => [
                    'a' => 'Magnetic clutch (kopling magnet)',
                    'b' => 'Katup ekspansi',
                    'c' => 'Relay starter',
                    'd' => 'Blower resistor',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi dari katup ekspansi (expansion valve) pada sistem pendingin AC adalah ...',
                'options' => [
                    'a' => 'Menurunkan tekanan dan suhu refrigeran cair bertekanan tinggi menjadi kabut cair bertekanan rendah yang dingin',
                    'b' => 'Menghilangkan uap air di dalam kabin mobil',
                    'c' => 'Menyaring kotoran debu pada jok mobil',
                    'd' => 'Memanaskan refrigeran gas menuju kompresor',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function pendinginAcUas(): array
    {
        return [
            [
                'question' => 'Alat ukur yang dilengkapi selang biru (tekanan rendah) dan selang merah (tekanan tinggi) untuk memeriksa tekanan kerja AC adalah ...',
                'options' => [
                    'a' => 'Manifold gauge (alat ukur manifold)',
                    'b' => 'Tire pressure gauge',
                    'c' => 'Compression tester',
                    'd' => 'Vacuum pump manual',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Tindakan membuang seluruh udara dan uap air dari dalam instalasi pipa AC sebelum pengisian refrigeran baru disebut proses ...',
                'options' => [
                    'a' => 'Purging kabin',
                    'b' => 'Vakum sistem (evakuasi) menggunakan vacuum pump',
                    'c' => 'Charging freon cepat',
                    'd' => 'Flushing oli mesin',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Salah satu penyebab umum AC mobil hanya mengeluarkan angin panas saat mobil berhenti di lampu merah namun dingin saat mobil melaju kencang adalah ...',
                'options' => [
                    'a' => 'Extra fan (kipas pendingin kondensor) mati atau putarannya melemah',
                    'b' => 'Filter bensin kotor',
                    'c' => 'Tekanan angin ban kurang',
                    'd' => 'Knalpot mengalami kebocoran',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen sistem AC yang berfungsi menyerap uap air dan menyaring kotoran halus pada refrigeran cair adalah ...',
                'options' => [
                    'a' => 'Evaporator',
                    'b' => 'Kondensor',
                    'c' => 'Receiver dryer / desiccant filter',
                    'd' => 'Expansion tube',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Sensor suhu yang terpasang pada sirip-sirip evaporator untuk mencegah terjadinya pembekuan bunga es (freezing) adalah ...',
                'options' => [
                    'a' => 'Thermistor evaporator',
                    'b' => 'Sensor knock',
                    'c' => 'Sensor TPS',
                    'd' => 'Sensor MAP',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= K3 & PRAKTIKUM BENGKEL =================
    private static function k3BengkelUts(): array
    {
        return [
            [
                'question' => 'Alat Pelindung Diri (APD) standar yang wajib dikenakan siswa saat melaksanakan praktikum perbaikan di bawah mobil (under-chassis) adalah ...',
                'options' => [
                    'a' => 'Pakaian kerja (wearpack), kacamata pelindung (safety goggles), dan sepatu keselamatan (safety shoes)',
                    'b' => 'Kaos oblong, celana pendek, dan sandal jepit',
                    'c' => 'Jas hujan plastik dan helm motor',
                    'd' => 'Sarung tangan kain tipis tanpa alas kaki',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Klasifikasi kebakaran yang disebabkan oleh bahan cair mudah terbakar seperti bensin, solar, minyak, dan oli pelumas tergolong kebakaran ...',
                'options' => [
                    'a' => 'Kelas A',
                    'b' => 'Kelas B',
                    'c' => 'Kelas C',
                    'd' => 'Kelas D',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tindakan yang paling tepat dan aman saat terjadi tumpahan oli pelumas di lantai bengkel adalah ...',
                'options' => [
                    'a' => 'Membiarkannya hingga mengering dengan sendirinya',
                    'b' => 'Menaburkan serbuk kayu atau pasir kering pada tumpahan, membersihkannya, lalu mengepel dengan cairan pembersih lantai',
                    'c' => 'Menyiram tumpahan oli dengan bensin agar cepat larut',
                    'd' => 'Menutup tumpahan dengan selembar kardus bekas',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Warna rambu keselamatan kerja pada workshop bengkel yang menunjukkan tanda bahaya (larangan atau pemadam kebakaran) adalah warna ...',
                'options' => [
                    'a' => 'Hijau',
                    'b' => 'Biru',
                    'c' => 'Kuning',
                    'd' => 'Merah',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Bahaya utama menyalakan mesin kendaraan bermotor dalam waktu lama di dalam ruangan bengkel tertutup tanpa ventilasi pembuangan adalah ...',
                'options' => [
                    'a' => 'Keracunan gas Karbon Monoksida (CO) yang tidak berbau dan sangat mematikan bagi teknisi',
                    'b' => 'Knalpot mobil akan cepat berkarat',
                    'c' => 'Lantai bengkel menjadi terlalu dingin',
                    'd' => 'Aki mobil akan meledak seketika',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function k3BengkelUas(): array
    {
        return [
            [
                'question' => 'Pengelolaan limbah B3 (Bahan Berbahaya dan Beracun) seperti oli bekas, aki bekas, dan minyak rem di bengkel otomotif harus ...',
                'options' => [
                    'a' => 'Dibuang langsung ke selokan drainase umum desa',
                    'b' => 'Ditampung dalam drum khusus berlabel limbah B3 dan diserahkan kepada pihak pengolah berizin resmi',
                    'c' => 'Dibakar bersama tumpukan sampah plastik bengkel',
                    'd' => 'Dituangkan ke tanah lapang belakang sekolah',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Prosedur keselamatan kerja saat mengangkat mobil menggunakan Two-Post Car Lift adalah ...',
                'options' => [
                    'a' => 'Langsung mengangkat mobil setinggi mungkin tanpa mengecek titik tumpu sasis',
                    'b' => 'Menempatkan bantalan lift tepat pada titik angkat sasis pabrikan, angkat sedikit, goyang perlahan untuk tes kestabilan, lalu aktifkan kunci mekanis (safety lock)',
                    'c' => 'Membiarkan siswa berada di dalam mobil saat mobil terangkat',
                    'd' => 'Menahan mobil dengan tangan kosong saat lift sedang naik',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Prinsip penataan tempat kerja 5S/5R yang diadopsi dari industri otomotif Jepang meliputi ...',
                'options' => [
                    'a' => 'Ringkas, Rapi, Resik, Rawat, dan Rajin',
                    'b' => 'Rame, Rukun, Rileks, Rapi, dan Rejeki',
                    'c' => 'Respon, Rencana, Risiko, Rekap, dan Rapat',
                    'd' => 'Rancang, Rakit, Rinci, Rombak, dan Rilis',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Alat Pemadam Api Ringan (APAR) jenis Dry Chemical Powder (serbuk kimia kering) sangat efektif karena ...',
                'options' => [
                    'a' => 'Dapat memadamkan kebakaran kelas A, B, dan C (multipurpose)',
                    'b' => 'Dapat diminum saat teknisi kehausan',
                    'c' => 'Tidak meninggalkan residu debu sama sekali',
                    'd' => 'Hanya berfungsi memadamkan api kayu saja',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sebelum melakukan perbaikan kelistrikan bodi atau pencopotan alternator mobil, tindakan keselamatan awal teknisi adalah ...',
                'options' => [
                    'a' => 'Mengosongkan tangki bahan bakar',
                    'b' => 'Melepas kabel terminal negatif (-) baterai aki untuk mencegah korsleting',
                    'c' => 'Menghidupkan lampu hazard',
                    'd' => 'Mengisi air radiator sampai penuh',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    // ================= GAMBAR TEKNIK & CAD =================
    private static function gambarTeknikUts(): array
    {
        return [
            [
                'question' => 'Garis gambar teknik yang digambarkan dengan garis strip-titik tipis (titik-garis-titik) berfungsi untuk menunjukkan ...',
                'options' => [
                    'a' => 'Garis batas benda yang terlihat jelas',
                    'b' => 'Garis sumbu simetri atau lintasan pergerakan benda',
                    'c' => 'Garis bagian benda yang tersembunyi',
                    'd' => 'Garis arsir potongan bidang',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Ukuran standar kertas gambar teknik format A3 menurut standar ISO adalah ...',
                'options' => [
                    'a' => '210 x 297 mm',
                    'b' => '297 x 420 mm',
                    'c' => '420 x 594 mm',
                    'd' => '594 x 841 mm',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Perbedaan letak pandangan proyeksi ortogonal sistem Eropa (Kuadran I) dan sistem Amerika (Kuadran III) adalah ...',
                'options' => [
                    'a' => 'Pada proyeksi Eropa letak pandangan terbalik berlawanan arah dengan arah pandang, sedangkan Amerika letak pandangan searah pandangan',
                    'b' => 'Proyeksi Eropa hanya boleh digambar dengan tinta emas',
                    'c' => 'Proyeksi Amerika tidak menggunakan skala ukuran',
                    'd' => 'Proyeksi Eropa tidak memiliki pandangan atas',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kepala gambar (etiket gambar teknik) yang memuat informasi judul gambar, skala, nama perancang, dan tanggal umumnya diletakkan di sudut ...',
                'options' => [
                    'a' => 'Kiri atas kertas gambar',
                    'b' => 'Kanan bawah kertas gambar',
                    'c' => 'Kanan atas kertas gambar',
                    'd' => 'Tengah-tengah bidang gambar',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Skala gambar 1 : 5 pada gambar teknik komponen otomotif berarti ...',
                'options' => [
                    'a' => 'Ukuran pada gambar 5 kali lebih besar daripada benda sebenarnya',
                    'b' => 'Ukuran pada gambar sama persis dengan benda sebenarnya',
                    'c' => 'Ukuran pada gambar diperkecil menjadi seperlima (1/5) dari ukuran benda sebenarnya',
                    'd' => 'Benda dibuat sebanyak 5 unit prototipe',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    private static function gambarTeknikUas(): array
    {
        return [
            [
                'question' => 'Sudut kemiringan standar garis arsir untuk menunjukkan bidang potongan suatu komponen mesin pada gambar teknik adalah ...',
                'options' => [
                    'a' => '30 derajat',
                    'b' => '45 derajat',
                    'c' => '60 derajat',
                    'd' => '90 derajat',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Perintah dasar pada software perancangan 3D CAD (seperti Autodesk Inventor / SolidWorks) yang digunakan untuk memberi ketebalan 3D dari sketsa profil 2D adalah ...',
                'options' => [
                    'a' => 'Extrude',
                    'b' => 'Revolve',
                    'c' => 'Fillet',
                    'd' => 'Chamfer',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah CAD 3D yang berfungsi membuat benda pejal simetris putar (seperti poros piston atau roda puli) dengan memutar sketsa 2D mengelilingi satu sumbu adalah ...',
                'options' => [
                    'a' => 'Loft',
                    'b' => 'Sweep',
                    'c' => 'Revolve',
                    'd' => 'Shell',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Simulasi pada software CAD/CAE untuk menganalisis titik konsentrasi tegangan (stress) dan deformasi pada komponen sasis otomotif disebut ...',
                'options' => [
                    'a' => 'Finite Element Analysis (FEA)',
                    'b' => 'Computational Fluid Rendering',
                    'c' => 'Raster Vector Conversion',
                    'd' => 'Pixel Shader Processing',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah CAD yang berfungsi membulatkan sudut siku tajam suatu komponen mesin menjadi radius lengkung adalah ...',
                'options' => [
                    'a' => 'Chamfer',
                    'b' => 'Trim',
                    'c' => 'Fillet',
                    'd' => 'Offset',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    // ================= SISTEM EMISI KENDARAAN =================
    private static function emisiKendaraanUts(): array
    {
        return [
            [
                'question' => 'Komponen pada saluran knalpot mobil yang berfungsi mengubah gas beracun (CO, HC, dan NOx) menjadi gas yang lebih ramah lingkungan (CO2, H2O, dan N2) adalah ...',
                'options' => [
                    'a' => 'Resonator',
                    'b' => 'Muffler peredam suara',
                    'c' => 'Catalytic Converter (Katalis)',
                    'd' => 'Exhaust manifold',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Sistem Exhaust Gas Recirculation (EGR) pada mesin modern bertujuan untuk ...',
                'options' => [
                    'a' => 'Mengalirkan sebagian kecil gas buang kembali ke ruang bakar guna menurunkan suhu pembakaran puncak dan menekan emisi gas Nitrogen Oksida (NOx)',
                    'b' => 'Menaikkan tenaga mesin secara drastis saat balap',
                    'c' => 'Menghilangkan suara bising knalpot',
                    'd' => 'Mendinginkan oli mesin secara instan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen sistem kontrol emisi penguapan bahan bakar (EVAP) yang bertugas menyerap uap bensin dari tangki agar tidak mencemari udara bebas adalah ...',
                'options' => [
                    'a' => 'Charcoal canister (tabung arang aktif)',
                    'b' => 'Fuel filter',
                    'c' => 'PCV valve',
                    'd' => 'Air cleaner element',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi dari Positive Crankcase Ventilation (PCV) valve pada mesin mobil adalah ...',
                'options' => [
                    'a' => 'Mengalirkan gas blow-by (kebocoran gas bakar di ruang karter) kembali ke intake manifold untuk dibakar ulang di silinder',
                    'b' => 'Menambah pasokan oli ke klep mesin',
                    'c' => 'Mengurangi tekanan ban belakang',
                    'd' => 'Mengatur debit air radiator',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Standar regulasi emisi gas buang kendaraan bermotor yang diterapkan di Indonesia saat ini mengacu pada standar ...',
                'options' => [
                    'a' => 'Standar Euro 4 dan Euro 5',
                    'b' => 'Standar Euro 1 tahun 1992',
                    'c' => 'Standar bebas emisi tanpa batas',
                    'd' => 'Standar emisi kapal laut IMO',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function emisiKendaraanUas(): array
    {
        return [
            [
                'question' => 'Gas buang kendaraan bermotor yang tidak berwarna, tidak berbau, namun sangat beracun karena mengikat hemoglobin darah manusia adalah ...',
                'options' => [
                    'a' => 'Oksigen (O2)',
                    'b' => 'Karbon Monoksida (CO)',
                    'c' => 'Nitrogen (N2)',
                    'd' => 'Uap air (H2O)',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Tingkat kepekatan (opasitas) asap gas buang pada mesin diesel diuji di bengkel uji emisi menggunakan alat ukur ...',
                'options' => [
                    'a' => 'Smoke tester (Opacimeter)',
                    'b' => 'Gas analyzer bensin',
                    'c' => 'Barometer udara',
                    'd' => 'Tachometer laser',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Filter khusus pada sistem pembuangan mesin diesel modern yang berfungsi menangkap partikel jelaga padat (soot / PM) dinamakan ...',
                'options' => [
                    'a' => 'Diesel Particulate Filter (DPF)',
                    'b' => 'Water sedimenter',
                    'c' => 'Oil catch can',
                    'd' => 'Turbo wastegate',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kondisi campuran bahan bakar yang terlalu kaya (rich mixture) pada mesin bensin akan menyebabkan kenaikan kadar emisi gas ...',
                'options' => [
                    'a' => 'Karbon Monoksida (CO) dan Hidrokarbon (HC) yang belum terbakar',
                    'b' => 'Oksigen bebas (O2)',
                    'c' => 'Kalsium karbonat',
                    'd' => 'Nitrogen murni',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Cairan berbasis urea yang disemprotkan ke gas buang mesin diesel modern (Selective Catalytic Reduction / SCR) untuk mengubah gas NOx menjadi nitrogen dan air dinamakan ...',
                'options' => [
                    'a' => 'Diesel Exhaust Fluid (DEF / AdBlue)',
                    'b' => 'Minyak rem DOT 4',
                    'c' => 'Coolant radiator merah',
                    'd' => 'Oli transmisi ATF',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= ELEKTRONIKA KONTROL MESIN =================
    private static function kontrolEcuUts(): array
    {
        return [
            [
                'question' => 'Unit pemroses komputer utama yang mengatur injeksi bahan bakar dan pengapian pada mesin injeksi modern adalah ...',
                'options' => [
                    'a' => 'ECU / ECM (Engine Control Unit / Engine Control Module)',
                    'b' => 'BCM (Body Control Module)',
                    'c' => 'TCM (Transmission Control Module)',
                    'd' => 'ABS Modulator',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sensor yang memberikan sinyal utama mengenai posisi sudut poros engkol dan kecepatan putaran mesin (RPM) ke ECU adalah ...',
                'options' => [
                    'a' => 'Crankshaft Position Sensor (CKP)',
                    'b' => 'Vehicle Speed Sensor (VSS)',
                    'c' => 'Fuel Level Sensor',
                    'd' => 'Knock Sensor',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metode sinyal listrik digital dengan memvariasikan lebar pulsa aktif untuk mengatur pembukaan katup aktuator dinamakan ...',
                'options' => [
                    'a' => 'Pulse Width Modulation (PWM)',
                    'b' => 'Amplitude Modulation (AM)',
                    'c' => 'Frequency Division',
                    'd' => 'Phase Shift Keying',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi sensor knocking (knock sensor) yang menggunakan elemen piezoelektrik pada blok silinder adalah ...',
                'options' => [
                    'a' => 'Mendeteksi getaran frekuensi tinggi akibat detonasi agar ECU memundurkan (retard) saat pengapian',
                    'b' => 'Mengukur suhu oli transmisi',
                    'c' => 'Mematikan alarm mobil saat pintu diketok',
                    'd' => 'Mengukur tekanan bahan bakar di tangki',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mode keselamatan darurat pada sistem ECU yang membuat kendaraan tetap dapat berjalan pelan saat salah satu sensor penting rusak dinamakan ...',
                'options' => [
                    'a' => 'Limp home mode (fail-safe mode)',
                    'b' => 'Sport mode',
                    'c' => 'Cruise control mode',
                    'd' => 'Drift mode',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function kontrolEcuUas(): array
    {
        return [
            [
                'question' => 'Tegangan referensi standar yang disuplai oleh ECU ke sebagian besar sensor analog mesin (seperti TPS dan MAP) adalah sebesar ...',
                'options' => [
                    'a' => '1,5 Volt',
                    'b' => '5,0 Volt (5V Vref)',
                    'c' => '12,0 Volt',
                    'd' => '24,0 Volt',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Sensor suhu air pendingin (Engine Coolant Temperature / ECT) menggunakan karakteristik resistor termal tipe NTC, artinya ...',
                'options' => [
                    'a' => 'Semakin tinggi suhu air pendingin, nilai tahanan (resistansi) sensor semakin menurun',
                    'b' => 'Semakin tinggi suhu, nilai resistansi semakin membesar',
                    'c' => 'Nilai tahanan sensor selalu tetap tidak berubah',
                    'd' => 'Sensor hanya menghasilkan tegangan saat mesin mati',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sistem bukaan katup pintar (seperti VVT-i pada Toyota atau VTEC pada Honda) dikontrol oleh ECU melalui aktuator ...',
                'options' => [
                    'a' => 'Oil Control Valve (OCV) solenoid',
                    'b' => 'Stepper motor karburator',
                    'c' => 'Koil pemantik sekunder',
                    'd' => 'Blower switch kabin',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen transistor berdaya tinggi (power transistor) di dalam ECU atau igniter yang bertugas memutus dan menyambung arus primer koil pengapian dinamakan ...',
                'options' => [
                    'a' => 'Driver transistor / IGBT (Insulated Gate Bipolar Transistor)',
                    'b' => 'Kapasitor elektrolit',
                    'c' => 'Resistor keramik',
                    'd' => 'Transformator step-down',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Proses memperbarui atau memprogram ulang perangkat lunak firmware di dalam memori internal ECU dinamakan ...',
                'options' => [
                    'a' => 'ECU Reflashing / Remapping',
                    'b' => 'Overhaul mekanik',
                    'c' => 'Ganti aki mobil',
                    'd' => 'Wheel balancing',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= SISTEM HYBRID & EV =================
    private static function hybridEvUts(): array
    {
        return [
            [
                'question' => 'Perbedaan utama antara mobil Battery Electric Vehicle (BEV) dan Hybrid Electric Vehicle (HEV) adalah ...',
                'options' => [
                    'a' => 'BEV hanya mengandalkan motor listrik dan baterai tanpa mesin bensin, sedangkan HEV mengkombinasikan mesin pembakaran dalam dan motor listrik',
                    'b' => 'BEV tetap memerlukan bahan bakar solar di tangki',
                    'c' => 'HEV tidak menggunakan baterai listrik',
                    'd' => 'BEV tidak memerlukan pedal rem sama sekali',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sistem yang memanfaatkan gaya pengereman untuk memutar motor listrik sebagai generator sehingga menghasilkan energi listrik pengisi baterai dinamakan ...',
                'options' => [
                    'a' => 'Regenerative Braking (Pengereman Regeneratif)',
                    'b' => 'Engine brake konvensional',
                    'c' => 'ABS hydraulic pulsing',
                    'd' => 'Traction control disable',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Warna standar internasional untuk selubung isolasi kabel tegangan tinggi (High Voltage Cable) pada kendaraan listrik untuk alasan keselamatan adalah warna ...',
                'options' => [
                    'a' => 'Hitam',
                    'b' => 'Oranye cerah',
                    'c' => 'Hijau strip kuning',
                    'd' => 'Biru muda',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Komponen elektronika daya yang berfungsi mengubah arus searah (DC) dari baterai traksi tegangan tinggi menjadi arus bolak-balik (AC) 3-fasa untuk memutar motor traksi adalah ...',
                'options' => [
                    'a' => 'Inverter',
                    'b' => 'Konverter DC-DC 12V',
                    'c' => 'Alternator mekanis',
                    'd' => 'Koil pengapian',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sistem komputer khusus yang memantau suhu, tegangan sel, arus, dan status State of Charge (SoC) baterai lithium kendaraan listrik adalah ...',
                'options' => [
                    'a' => 'BMS (Battery Management System)',
                    'b' => 'ABS Modulator',
                    'c' => 'TPMS (Tire Pressure Monitoring System)',
                    'd' => 'Airbag Module',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function hybridEvUas(): array
    {
        return [
            [
                'question' => 'Tindakan keselamatan paling utama yang wajib dilakukan teknisi sebelum melakukan pembongkaran sistem kelistrikan tegangan tinggi mobil EV adalah ...',
                'options' => [
                    'a' => 'Mematikan kunci kontak, mencabut Service Disconnect Plug (Safety Plug), dan menunggu hingga tegangan kapasitor residu hilang',
                    'b' => 'Menyiram baterai traksi dengan air dingin',
                    'c' => 'Menghidupkan mode pengisian daya cepat',
                    'd' => 'Mengempiskan keempat ban kendaraan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen yang berfungsi mengubah tegangan tinggi dari baterai traksi (misal 300-400V DC) menjadi tegangan rendah 12V DC untuk kelistrikan bodi mobil EV adalah ...',
                'options' => [
                    'a' => 'DC-DC Converter',
                    'b' => 'On-Board Charger (OBC)',
                    'c' => 'Inverter traksi',
                    'd' => 'Relay starter',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Alat Pelindung Diri (APD) khusus teknisi mobil listrik saat menangani baterai tegangan tinggi adalah ...',
                'options' => [
                    'a' => 'Sarung tangan isolasi karet bersertifikasi tegangan 1000V (Class 0) dan pelindung mata',
                    'b' => 'Sarung tangan kain katun tipis',
                    'c' => 'Jas hujan plastik biasa',
                    'd' => 'Kacamata renang',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen pada mobil listrik yang berfungsi mengubah arus bolak-balik (AC) dari colokan listrik rumah/SPKLU AC menjadi arus DC untuk mengisi baterai traksi adalah ...',
                'options' => [
                    'a' => 'On-Board Charger (OBC)',
                    'b' => 'Inverter motor',
                    'c' => 'Sistem EGR',
                    'd' => 'Transmisi manual',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Keunggulan karakteristik torsi dari motor listrik traksi dibanding mesin motor bakar konvensional adalah ...',
                'options' => [
                    'a' => 'Torsi maksimal dapat dicapai secara instan sejak putaran awal (0 RPM)',
                    'b' => 'Torsi baru muncul setelah putaran tinggi di atas 5000 RPM',
                    'c' => 'Motor listrik tidak menghasilkan torsi sama sekali',
                    'd' => 'Torsi sangat bergantung pada kualitas oktan bahan bakar',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= MANAJEMEN BENGKEL & SPAREPART =================
    private static function manajemenBengkelUts(): array
    {
        return [
            [
                'question' => 'Petugas bengkel resmi yang bertugas menyambut pelanggan, mendengarkan keluhan kerusakan mobil, dan menerbitkan Perintah Kerja Bengkel (PKB) adalah ...',
                'options' => [
                    'a' => 'Service Advisor (SA)',
                    'b' => 'Toolman',
                    'c' => 'Kasir suku cadang',
                    'd' => 'Petugas keamanan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metode pengelolaan persediaan suku cadang di gudang di mana barang yang pertama kali masuk harus pertama kali dikeluarkan untuk mencegah kerusakan penyimpanan dinamakan metode ...',
                'options' => [
                    'a' => 'FIFO (First In, First Out)',
                    'b' => 'LIFO (Last In, First Out)',
                    'c' => 'Random Storage',
                    'd' => 'JIT Tanpa Stok',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kategori suku cadang yang paling sering diganti dalam perawatan berkala rutin kendaraan (seperti filter oli, busi, kanvas rem) tergolong barang ...',
                'options' => [
                    'a' => 'Fast Moving Parts',
                    'b' => 'Slow Moving Parts',
                    'c' => 'Dead Stock',
                    'd' => 'Overhaul Parts',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Surat dokumen resmi yang menjadi instruksi kerja bagi mekanik untuk melakukan perbaikan kendaraan sesuai keluhan pelanggan dinamakan ...',
                'options' => [
                    'a' => 'PKB (Perintah Kerja Bengkel)',
                    'b' => 'Faktur pajak kendaraan',
                    'c' => 'Surat izin mengemudi',
                    'd' => 'Kwitansi kasir',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pemeriksaan akhir (final inspection) oleh Quality Control (Foreman) setelah pengerjaan servis selesai bertujuan untuk ...',
                'options' => [
                    'a' => 'Memastikan seluruh pengerjaan sesuai standar SOP kualitas dan kendaraan bersih sebelum diserahkan ke pelanggan',
                    'b' => 'Menghapus catatan servis pelanggan',
                    'c' => 'Mengurangi pembayaran tagihan',
                    'd' => 'Menaikkan tarif jasa tanpa izin',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function manajemenBengkelUas(): array
    {
        return [
            [
                'question' => 'Standar waktu pengerjaan suatu jenis perbaikan kendaraan yang ditetapkan oleh pabrikan sebagai dasar perhitungan biaya ongkos jasa mekanik disebut ...',
                'options' => [
                    'a' => 'Flat Rate Time (FRT)',
                    'b' => 'Overtime Allowance',
                    'c' => 'Idle Machine Time',
                    'd' => 'Warranty Claim Hour',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kegiatan penghitungan fisik seluruh persediaan barang suku cadang di gudang secara periodik untuk mencocokkan stok fisik dengan data kartu stok komputer dinamakan ...',
                'options' => [
                    'a' => 'Stock Opname (Audit Persediaan)',
                    'b' => 'Procurement barang',
                    'c' => 'Retur penjualan',
                    'd' => 'Cash on delivery',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Indikator kepuasan pelanggan bengkel yang diukur dari kecepatan, ketepatan perbaikan, dan keramahan pelayanan dinamakan ...',
                'options' => [
                    'a' => 'Customer Satisfaction Index (CSI)',
                    'b' => 'Gross Profit Margin',
                    'c' => 'Return of Assets',
                    'd' => 'Debt to Equity Ratio',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Langkah penataan gudang suku cadang agar mekanik cepat menemukan barang yang dibutuhkan adalah ...',
                'options' => [
                    'a' => 'Menyimpan barang berdasarkan nomor part unik (Part Number), lokasi rak berlabel (Bin Location), dan kartu stok rapi',
                    'b' => 'Menumpuk semua komponen dalam satu kotak kardus besar di lantai',
                    'c' => 'Menghapus kode barang dari bungkus pabrikan',
                    'd' => 'Menyembunyikan suku cadang yang mahal',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Dalam perhitungan biaya usaha bengkel mandiri, modal awal pembelian peralatan car lift, kompresor angin, dan perkakas kunci digolongkan sebagai ...',
                'options' => [
                    'a' => 'Biaya Investasi Aset Tetap (Capital Expenditure / Capex)',
                    'b' => 'Bahan habis pakai harian',
                    'c' => 'Biaya variabel musiman',
                    'd' => 'Pajak penjualan bulanan',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }
}

