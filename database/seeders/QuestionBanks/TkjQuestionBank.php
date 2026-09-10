<?php

namespace Database\Seeders\QuestionBanks;

class TkjQuestionBank
{
    public static function getQuestions(string $subjectBase, string $type): ?array
    {
        $map = [
            'Pengantar Jaringan' => 'pengantarJaringan',
            'Pemrograman Dasar' => 'pemrogramanDasar',
            'Sistem Operasi Jaringan' => 'sistemOperasiJaringan',
            'Administrasi Server' => 'administrasiServer',
            'Keamanan Jaringan' => 'keamananJaringan',
            'Cloud Security' => 'keamananJaringan',
            'Pemrograman Web' => 'pemrogramanWeb',
            'Frameworks Web (Laravel)' => 'laravelWeb',
            'Basis Data' => 'basisData',
            'Jaringan Nirkabel' => 'jaringanNirkabel',
            'Pemrograman Mobile' => 'pemrogramanMobile',
            'Mobile App Advanced' => 'pemrogramanMobile',
            'Internet of Things' => 'iotSistemTertanam',
            'Sistem Tertanam' => 'iotSistemTertanam',
            'Virtualisasi & Cloud' => 'virtualisasiCloud',
            'Troubleshooting Jaringan' => 'troubleshootingJaringan',
            'Routing & Switching' => 'routingSwitching',
            'Ethical Hacking Dasar' => 'ethicalHacking',
            'Manajemen Proyek IT' => 'manajemenProyekIt',
            'Multimedia & Desain' => 'multimediaUiUx',
            'UI/UX Desain' => 'multimediaUiUx',
            'DevOps Dasar' => 'devOps',
            'Node.js & Backend' => 'nodeJsBackend',
            'Python untuk Jaringan' => 'pythonAutomation',
            'Automation Scripting' => 'pythonAutomation',
            'Data Analytics Dasar' => 'dataAiMl',
            'Machine Learning Dasar' => 'dataAiMl',
            'AI untuk IT' => 'dataAiMl',
            'Game Development' => 'gameDev',
            'Blockchain Basics' => 'blockchain',
            'Pengelolaan Infrastruktur IT' => 'infrastrukturIt',
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

    // ================= PENGANTAR JARINGAN =================
    private static function pengantarJaringanUts(): array
    {
        return [
            [
                'question' => 'Lapisan (layer) pada model 7 OSI Layer yang bertugas menangani pengalamatan logis (IP Address) dan routing paket data adalah ...',
                'options' => [
                    'a' => 'Physical Layer',
                    'b' => 'Data Link Layer',
                    'c' => 'Network Layer',
                    'd' => 'Transport Layer',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Urutan susunan warna kabel UTP standar internasional T568B dari pin 1 sampai pin 8 adalah ...',
                'options' => [
                    'a' => 'Putih Orange, Orange, Putih Hijau, Biru, Putih Biru, Hijau, Putih Cokelat, Cokelat',
                    'b' => 'Putih Hijau, Hijau, Putih Orange, Biru, Putih Biru, Orange, Putih Cokelat, Cokelat',
                    'c' => 'Orange, Putih Orange, Hijau, Biru, Putih Biru, Putih Hijau, Cokelat, Putih Cokelat',
                    'd' => 'Putih Biru, Biru, Putih Orange, Orange, Putih Hijau, Hijau, Putih Cokelat, Cokelat',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Jenis kabel UTP dengan susunan straight-through digunakan untuk menghubungkan ...',
                'options' => [
                    'a' => 'Komputer ke Switch / Hub',
                    'b' => 'Komputer langsung ke Komputer tanpa perantara',
                    'c' => 'Switch ke Switch pada port biasa',
                    'd' => 'Router langsung ke Router via port FastEthernet',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Konektor standar yang digunakan untuk mengakhiri kabel twisted-pair (UTP/STP) pada jaringan Ethernet LAN adalah ...',
                'options' => [
                    'a' => 'RJ-11',
                    'b' => 'BNC Connector',
                    'c' => 'RJ-45',
                    'd' => 'SC Connector',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Alamat IP versi 4 (IPv4) memiliki panjang total bit sebesar ...',
                'options' => [
                    'a' => '16 bit',
                    'b' => '32 bit',
                    'c' => '64 bit',
                    'd' => '128 bit',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    private static function pengantarJaringanUas(): array
    {
        return [
            [
                'question' => 'Topologi jaringan fisik di mana setiap komputer terhubung ke satu perangkat sentral (Switch/Hub) dinamakan ...',
                'options' => [
                    'a' => 'Topologi Bus',
                    'b' => 'Topologi Ring',
                    'c' => 'Topologi Star',
                    'd' => 'Topologi Mesh',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Alamat fisik permanen (hardware address) berukuran 48-bit yang tersemat pada Network Interface Card (NIC) dinamakan ...',
                'options' => [
                    'a' => 'MAC Address',
                    'b' => 'IP Address',
                    'c' => 'Subnet Mask',
                    'd' => 'Port Number',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perbedaan mendasar antara perangkat Hub dan Switch dalam meneruskan lalu lintas data pada LAN adalah ...',
                'options' => [
                    'a' => 'Hub menyaring frame berdasarkan MAC Address, sedangkan Switch mengirim broadcast ke semua port',
                    'b' => 'Switch membaca MAC Address dan mengirimkan frame hanya ke port tujuan spesifik, sedangkan Hub membroadcast data ke seluruh port',
                    'c' => 'Hub menggunakan IP Address, Switch tidak mengenal data',
                    'd' => 'Switch tidak memerlukan sumber listrik AC',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Jumlah maksimal host address yang dapat digunakan pada subnet jaringan dengan prefix /24 (Netmask 255.255.255.0) adalah ...',
                'options' => [
                    'a' => '254 host',
                    'b' => '256 host',
                    'c' => '128 host',
                    'd' => '64 host',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah command line untuk menguji konektivitas jaringan end-to-end dengan mengirimkan paket ICMP Echo Request adalah ...',
                'options' => [
                    'a' => 'ipconfig',
                    'b' => 'netstat',
                    'c' => 'ping',
                    'd' => 'tracert',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    // ================= PEMROGRAMAN DASAR =================
    private static function pemrogramanDasarUts(): array
    {
        return [
            [
                'question' => 'Langkah-langkah terstruktur dan logis yang disusun secara sistematis untuk menyelesaikan suatu masalah komputasi disebut ...',
                'options' => [
                    'a' => 'Pseudocode',
                    'b' => 'Algoritma',
                    'c' => 'Flowchart',
                    'd' => 'Program',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Simbol bangun belah ketupat (diamond) pada diagram alir (flowchart) standar berfungsi untuk ...',
                'options' => [
                    'a' => 'Memulai atau mengakhiri program (terminator)',
                    'b' => 'Proses perhitungan komputasi biasa',
                    'c' => 'Input atau output data',
                    'd' => 'Pengambilan keputusan kondisi percabangan (decision)',
                ],
                'correct_answer' => 'd',
            ],
            [
                'question' => 'Tipe data primitif yang hanya dapat bernilai benar (true) atau salah (false) adalah ...',
                'options' => [
                    'a' => 'Integer',
                    'b' => 'Float',
                    'c' => 'Boolean',
                    'd' => 'String',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Operator logika yang menghasilkan nilai TRUE hanya jika kedua operan bernilai TRUE adalah operator ...',
                'options' => [
                    'a' => 'AND (&&)',
                    'b' => 'OR (||)',
                    'c' => 'NOT (!)',
                    'd' => 'XOR (^)',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Struktur perulangan yang memeriksa kondisi di akhir blok kode sehingga badan perulangan pasti dijalankan minimal satu kali adalah ...',
                'options' => [
                    'a' => 'for loop',
                    'b' => 'while loop',
                    'c' => 'do-while loop',
                    'd' => 'foreach loop',
                ],
                'correct_answer' => 'c',
            ],
        ];
    }

    private static function pemrogramanDasarUas(): array
    {
        return [
            [
                'question' => 'Struktur data yang mampu menyimpan sekumpulan elemen data bertipe sama dalam satu nama variabel dengan indeks numerik disebut ...',
                'options' => [
                    'a' => 'Array (Larik)',
                    'b' => 'Konstanta',
                    'c' => 'Pointer',
                    'd' => 'Fungsi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Indeks pertama pada struktur data array dalam sebagian besar bahasa pemrograman modern (seperti C, Java, PHP, JavaScript, Python) dimulai dari angka ...',
                'options' => [
                    'a' => '0',
                    'b' => '1',
                    'c' => '-1',
                    'd' => '10',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Blok kode program mandiri yang dapat dipanggil berulang kali dan mengembalikan suatu nilai hasil komputasi disebut ...',
                'options' => [
                    'a' => 'Prosedur tanpa return',
                    'b' => 'Fungsi (Function)',
                    'c' => 'Variabel global',
                    'd' => 'Tipe data enum',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Kesalahan penulisan kode program akibat pelanggaran aturan tata bahasa sintaks pemrograman dinamakan ...',
                'options' => [
                    'a' => 'Syntax Error',
                    'b' => 'Logical Error',
                    'c' => 'Runtime Error',
                    'd' => 'Zero Division Error',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pernyataan (statement) yang digunakan untuk menghentikan seketika eksekusi blok perulangan dan melompat keluar dari perulangan adalah ...',
                'options' => [
                    'a' => 'continue',
                    'b' => 'break',
                    'c' => 'return null',
                    'd' => 'goto',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    // ================= SISTEM OPERASI JARINGAN =================
    private static function sistemOperasiJaringanUts(): array
    {
        return [
            [
                'question' => 'Sistem operasi jaringan berbasis open-source yang sangat populer digunakan untuk server infrastruktur dunia adalah ...',
                'options' => [
                    'a' => 'Linux (Debian / Ubuntu Server)',
                    'b' => 'Windows 10 Home Edition',
                    'c' => 'Android Go',
                    'd' => 'macOS iOS',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Direktori utama pada sistem berkas Linux yang berisi seluruh berkas konfigurasi sistem dan layanan jaringan adalah ...',
                'options' => [
                    'a' => '/var',
                    'b' => '/home',
                    'c' => '/etc',
                    'd' => '/bin',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Perintah CLI pada Linux yang digunakan untuk mengubah hak akses perizinan (permission) pada sebuah berkas atau direktori adalah ...',
                'options' => [
                    'a' => 'chown',
                    'b' => 'chmod',
                    'c' => 'passwd',
                    'd' => 'touch',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Arti dari nilai hak akses oktal 755 (rwxr-xr-x) pada suatu file di Linux adalah ...',
                'options' => [
                    'a' => 'Owner memiliki hak penuh (Read, Write, Execute), Group dan Other hanya hak Read dan Execute',
                    'b' => 'Semua user memiliki hak akses penuh',
                    'c' => 'File hanya bisa dibaca saja oleh siapa pun',
                    'd' => 'File terkunci dan tidak bisa dijalankan',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah untuk melihat konfigurasi antarmuka jaringan dan alamat IP yang aktif pada Linux modern adalah ...',
                'options' => [
                    'a' => 'ip a (atau ip addr show)',
                    'b' => 'ping localhost',
                    'c' => 'hostnamectl',
                    'd' => 'ls -la',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function sistemOperasiJaringanUas(): array
    {
        return [
            [
                'question' => 'Manajer paket perangkat lunak standar yang digunakan pada sistem operasi distro Debian dan Ubuntu untuk menginstal aplikasi adalah ...',
                'options' => [
                    'a' => 'yum / dnf',
                    'b' => 'apt (Advanced Package Tool)',
                    'c' => 'pacman',
                    'd' => 'brew',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Perintah systemd yang digunakan untuk menjalankan sekaligus mendaftarkan layanan (service) agar otomatis hidup saat server reboot adalah ...',
                'options' => [
                    'a' => 'systemctl enable --now [nama_service]',
                    'b' => 'service restart [nama_service]',
                    'c' => 'kill -9 [nama_service]',
                    'd' => 'init 0 [nama_service]',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah interaktif CLI untuk memantau penggunaan prosesor (CPU), memori RAM, dan daftar proses yang sedang berjalan di Linux adalah ...',
                'options' => [
                    'a' => 'top atau htop',
                    'b' => 'df -h',
                    'c' => 'uname -r',
                    'd' => 'fdisk -l',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Direktori tempat penyimpanan file-file log aktivitas sistem dan layanan aplikasi di Linux berada di ...',
                'options' => [
                    'a' => '/var/log',
                    'b' => '/tmp',
                    'c' => '/boot',
                    'd' => '/lib',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah untuk mengganti kepemilikan user dan grup dari sebuah file atau folder di Linux adalah ...',
                'options' => [
                    'a' => 'chmod',
                    'b' => 'chown',
                    'c' => 'usermod',
                    'd' => 'groupadd',
                ],
                'correct_answer' => 'b',
            ],
        ];
    }

    // ================= ADMINISTRASI SERVER =================
    private static function administrasiServerUts(): array
    {
        return [
            [
                'question' => 'Layanan server yang berfungsi menerjemahkan nama domain (Fully Qualified Domain Name / FQDN) menjadi alamat IP adalah ...',
                'options' => [
                    'a' => 'DHCP Server',
                    'b' => 'DNS Server (Domain Name System)',
                    'c' => 'FTP Server',
                    'd' => 'NTP Server',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Paket perangkat lunak server yang paling populer digunakan untuk mengonfigurasi DNS Server di sistem operasi Linux adalah ...',
                'options' => [
                    'a' => 'BIND9',
                    'b' => 'Apache2',
                    'c' => 'vsftpd',
                    'd' => 'OpenSSH',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi utama dari Dynamic Host Configuration Protocol (DHCP) Server adalah ...',
                'options' => [
                    'a' => 'Menyimpan berkas database website',
                    'b' => 'Mendistribusikan konfigurasi alamat IP, subnet mask, dan gateway ke komputer klien secara otomatis',
                    'c' => 'Mengirim email antarpengguna jaringan',
                    'd' => 'Mengamankan server dari virus lokal',
                ],
                'correct_answer' => 'b',
            ],
            [
                'question' => 'Protokol remote access terenkripsi yang aman untuk mengontrol server dari jarak jauh melalui antarmuka baris perintah menggunakan port default 22 adalah ...',
                'options' => [
                    'a' => 'Telnet',
                    'b' => 'FTP',
                    'c' => 'SSH (Secure Shell)',
                    'd' => 'RDP',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Dua web server open-source yang paling banyak digunakan di dunia saat ini adalah ...',
                'options' => [
                    'a' => 'Apache HTTP Server dan Nginx',
                    'b' => 'MySQL dan PostgreSQL',
                    'c' => 'BIND9 dan Postfix',
                    'd' => 'Samba dan Squid',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function administrasiServerUas(): array
    {
        return [
            [
                'question' => 'Fitur pada web server Apache/Nginx yang memungkinkan satu mesin server fisik meng-host banyak domain atau website berbeda dinamakan ...',
                'options' => [
                    'a' => 'Virtual Host (Server Block)',
                    'b' => 'Load Balancer',
                    'c' => 'Reverse Proxy Cache',
                    'd' => 'Port Forwarding',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Port standar yang digunakan untuk melayani lalu lintas protokol web terenkripsi (HTTPS) adalah port ...',
                'options' => [
                    'a' => 'Port 80',
                    'b' => 'Port 21',
                    'c' => 'Port 443',
                    'd' => 'Port 3306',
                ],
                'correct_answer' => 'c',
            ],
            [
                'question' => 'Layanan server yang berfungsi membagikan file dan printer secara terpadu antara server Linux dan klien Windows menggunakan protokol SMB adalah ...',
                'options' => [
                    'a' => 'Samba Server',
                    'b' => 'FTP Server',
                    'c' => 'NFS Server',
                    'd' => 'Nginx Server',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah keamanan awal setelah menginstal RDBMS MySQL atau MariaDB di Linux untuk menghapus user anonim dan membatasi akses root adalah ...',
                'options' => [
                    'a' => 'mysql_secure_installation',
                    'b' => 'mysql -u root -p',
                    'c' => 'systemctl stop mysql',
                    'd' => 'apt purge mariadb',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Tool sertifikat SSL gratis berbasis otomatisasi yang banyak digunakan untuk mengamankan situs web server adalah ...',
                'options' => [
                    'a' => 'Certbot (Let\'s Encrypt)',
                    'b' => 'OpenVPN',
                    'c' => 'Wireshark',
                    'd' => 'Putty Key Generator',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= KEAMANAN JARINGAN & CLOUD SECURITY =================
    private static function keamananJaringanUts(): array
    {
        return [
            [
                'question' => 'Tiga pilar utama dalam keamanan informasi yang dikenal sebagai CIA Triad adalah ...',
                'options' => [
                    'a' => 'Confidentiality, Integrity, dan Availability',
                    'b' => 'Communication, Internet, dan Authentication',
                    'c' => 'Control, Inspection, dan Authorization',
                    'd' => 'Cyber, Intelligence, dan Algorithm',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Serangan siber yang bertujuan melumpuhkan layanan server dengan membanjirinya menggunakan lalu lintas data palsu dari banyak komputer bot dinamakan ...',
                'options' => [
                    'a' => 'DDoS (Distributed Denial of Service)',
                    'b' => 'Cross-Site Scripting (XSS)',
                    'c' => 'SQL Injection',
                    'd' => 'Man-in-the-Middle',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perangkat lunak atau perangkat keras yang bertugas memeriksa dan menyaring paket data masuk atau keluar berdasarkan aturan keamanan jaringan dinamakan ...',
                'options' => [
                    'a' => 'Firewall',
                    'b' => 'Repeater',
                    'c' => 'Modem',
                    'd' => 'Access Point',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metode rekayasa sosial (social engineering) di mana penyerang mengirimkan pesan atau email palsu menyerupai institusi resmi untuk memancing kredensial korban adalah ...',
                'options' => [
                    'a' => 'Phishing',
                    'b' => 'Brute Force',
                    'c' => 'Port Scanning',
                    'd' => 'Zero-day Exploit',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Enkripsi yang menggunakan pasangan kunci berbeda (Public Key untuk enkripsi dan Private Key untuk dekripsi) dinamakan enkripsi ...',
                'options' => [
                    'a' => 'Asimetris (Asymmetric Encryption)',
                    'b' => 'Simetris tunggal',
                    'c' => 'Caesar Cipher',
                    'd' => 'Hash satu arah',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function keamananJaringanUas(): array
    {
        return [
            [
                'question' => 'Langkah pengerasan keamanan (security hardening) pada server Linux untuk layanan SSH yang paling direkomendasikan adalah ...',
                'options' => [
                    'a' => 'Menonaktifkan login root langsung (PermitRootLogin no) dan menggunakan autentikasi Public Key',
                    'b' => 'Menggunakan kata sandi "123456" agar mudah diingat',
                    'c' => 'Membuka seluruh port firewall tanpa filter',
                    'd' => 'Mematikan fitur firewall UFW',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Tool otomatis pada Linux yang berfungsi memblokir sementara IP penyerang yang melakukan percobaan login SSH gagal berulang kali (Brute Force) adalah ...',
                'options' => [
                    'a' => 'Fail2ban',
                    'b' => 'Nmap',
                    'c' => 'Wireshark',
                    'd' => 'Telnet',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Prinsip keamanan pada manajemen hak akses cloud (IAM) yang hanya memberikan izin seminimal mungkin sesuai tugas operasional user dinamakan ...',
                'options' => [
                    'a' => 'Principle of Least Privilege',
                    'b' => 'All Access Permission',
                    'c' => 'Public Read Write',
                    'd' => 'Root Bypass Policy',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Penerapan lapisan keamanan ganda saat login selain kata sandi dengan meminta kode OTP atau aplikasi autentikator dinamakan ...',
                'options' => [
                    'a' => 'Two-Factor Authentication (2FA / MFA)',
                    'b' => 'Single Sign-On bebas kunci',
                    'c' => 'Password Reminder',
                    'd' => 'Auto Fill Browser',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Jenis malware berbahaya yang mengenkripsi seluruh file korban dan meminta tebusan uang untuk membuka kuncinya dinamakan ...',
                'options' => [
                    'a' => 'Ransomware',
                    'b' => 'Adware iklan',
                    'c' => 'Spyware pelacak',
                    'd' => 'Worm internet',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= PEMROGRAMAN WEB =================
    private static function pemrogramanWebUts(): array
    {
        return [
            [
                'question' => 'Elemen semantic pada HTML5 yang tepat digunakan untuk membungkus navigasi menu tautan halaman adalah ...',
                'options' => [
                    'a' => '<nav>',
                    'b' => '<menu-bar>',
                    'c' => '<links>',
                    'd' => '<header-nav>',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Properti CSS Flexbox yang digunakan untuk mengatur perataan elemen anak secara horizontal sepanjang sumbu utama (main axis) adalah ...',
                'options' => [
                    'a' => 'justify-content',
                    'b' => 'align-items',
                    'c' => 'flex-direction',
                    'd' => 'flex-wrap',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metode pengiriman formulir HTML (form method) yang mengirimkan data tersembunyi di dalam badan pesan HTTP (request body) sehingga cocok untuk kata sandi adalah ...',
                'options' => [
                    'a' => 'POST',
                    'b' => 'GET',
                    'c' => 'PUT',
                    'd' => 'DELETE',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah JavaScript modern untuk memilih elemen DOM berdasarkan ID uniknya adalah ...',
                'options' => [
                    'a' => 'document.getElementById("namaId")',
                    'b' => 'document.selectId("namaId")',
                    'c' => 'window.find("#namaId")',
                    'd' => 'document.createId("namaId")',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pola arsitektur perangkat lunak yang memisahkan logika data, antarmuka tampilan pengguna, dan pengendali alur aplikasi dinamakan ...',
                'options' => [
                    'a' => 'MVC (Model-View-Controller)',
                    'b' => 'Monolithic Spagheti',
                    'c' => 'Client-Server Peer',
                    'd' => 'Master-Slave Layout',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function pemrogramanWebUas(): array
    {
        return [
            [
                'question' => 'Media query pada CSS3 digunakan oleh web developer untuk ...',
                'options' => [
                    'a' => 'Membuat tampilan web responsif yang beradaptasi dengan berbagai ukuran layar perangkat (mobile, tablet, desktop)',
                    'b' => 'Menghubungkan website langsung ke database',
                    'c' => 'Menjalankan animasi audio video secara offline',
                    'd' => 'Mengompresi gambar JPEG otomatis',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Format pertukaran data berbasis teks standar yang ringan dan mudah dibaca oleh manusia maupun mesin dalam komunikasi API web adalah ...',
                'options' => [
                    'a' => 'JSON (JavaScript Object Notation)',
                    'b' => 'CSV spreadsheet',
                    'c' => 'Binary Octet',
                    'd' => 'INI Config',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mekanisme keamanan web yang mengatur apakah suatu sumber daya di server boleh diminta oleh domain lain di peramban dinamakan ...',
                'options' => [
                    'a' => 'CORS (Cross-Origin Resource Sharing)',
                    'b' => 'DOM Tree Parser',
                    'c' => 'CSS Preprocessor',
                    'd' => 'DNS Lookup',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Dalam arsitektur RESTful API, metode HTTP yang tepat digunakan untuk memperbarui seluruh data suatu sumber daya adalah ...',
                'options' => [
                    'a' => 'PUT',
                    'b' => 'GET',
                    'c' => 'POST',
                    'd' => 'DELETE',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kode status respon HTTP (HTTP Status Code) yang menandakan bahwa permintaan berhasil diproses adalah ...',
                'options' => [
                    'a' => '200 OK',
                    'b' => '400 Bad Request',
                    'c' => '404 Not Found',
                    'd' => '500 Internal Server Error',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= FRAMEWORKS WEB (LARAVEL) =================
    private static function laravelWebUts(): array
    {
        return [
            [
                'question' => 'Perintah baris perintah (CLI) bawaan framework Laravel yang digunakan untuk menjalankan berbagai tugas otomasi dinamakan ...',
                'options' => [
                    'a' => 'Artisan CLI (php artisan)',
                    'b' => 'Composer runner',
                    'c' => 'NPM dev',
                    'd' => 'Webpack bundle',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mesin pembuat template (template engine) bawaan resmi dari Laravel yang memiliki sintaks sederhana dan fitur pewarisan layout adalah ...',
                'options' => [
                    'a' => 'Blade Templating Engine',
                    'b' => 'Twig Engine',
                    'c' => 'Smarty Engine',
                    'd' => 'Handlebars',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Berkas konfigurasi di root proyek Laravel tempat menyimpan informasi sensitif lingkungan lokal (seperti koneksi database dan kredensial mail) adalah ...',
                'options' => [
                    'a' => '.env',
                    'b' => 'composer.json',
                    'c' => 'package.json',
                    'd' => 'config/app.php',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fitur Object-Relational Mapping (ORM) andalan di Laravel yang mempermudah interaksi database menggunakan model objek dinamakan ...',
                'options' => [
                    'a' => 'Eloquent ORM',
                    'b' => 'Doctrine',
                    'c' => 'Hibernate',
                    'd' => 'ActiveRecord Ruby',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Direktif Blade yang wajib disertakan pada formulir form HTML method POST di Laravel untuk mencegah serangan pemalsuan permintaan lintas situs adalah ...',
                'options' => [
                    'a' => '@csrf',
                    'b' => '@auth',
                    'c' => '@method',
                    'd' => '@section',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function laravelWebUas(): array
    {
        return [
            [
                'question' => 'Fitur di Laravel yang bertindak sebagai sistem pengontrol versi (version control) untuk skema struktur tabel database dinamakan ...',
                'options' => [
                    'a' => 'Database Migrations',
                    'b' => 'Database Seeder',
                    'c' => 'Factory Model',
                    'd' => 'Query Builder',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Lapisan perantara di Laravel yang bertugas memeriksa dan menyaring permintaan HTTP sebelum masuk ke Controller (misal cek login user) dinamakan ...',
                'options' => [
                    'a' => 'Middleware',
                    'b' => 'Service Provider',
                    'c' => 'Routing Group',
                    'd' => 'Event Listener',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah Artisan yang digunakan untuk menjalankan seluruh file migrasi skema tabel yang belum dieksekusi adalah ...',
                'options' => [
                    'a' => 'php artisan migrate',
                    'b' => 'php artisan db:seed',
                    'c' => 'php artisan serve',
                    'd' => 'php artisan make:model',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Relasi Eloquent yang menyatakan bahwa satu entitas model memiliki banyak data anak (misal: satu User memiliki banyak Postingan) didefinisikan menggunakan method ...',
                'options' => [
                    'a' => 'hasMany()',
                    'b' => 'belongsTo()',
                    'c' => 'hasOne()',
                    'd' => 'belongsToMany()',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Berkas tempat mendaftarkan seluruh rute antarmuka berbasis browser web pada Laravel 11/12 berada di direktori ...',
                'options' => [
                    'a' => 'routes/web.php',
                    'b' => 'routes/api.php',
                    'c' => 'app/Http/Kernel.php',
                    'd' => 'bootstrap/app.php',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= BASIS DATA =================
    private static function basisDataUts(): array
    {
        return [
            [
                'question' => 'Kelompok perintah SQL yang digunakan untuk mendefinisikan, mengubah, atau menghapus struktur objek database (seperti CREATE, ALTER, DROP) tergolong ...',
                'options' => [
                    'a' => 'DDL (Data Definition Language)',
                    'b' => 'DML (Data Manipulation Language)',
                    'c' => 'DCL (Data Control Language)',
                    'd' => 'TCL (Transaction Control Language)',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kolom atau atribut dalam suatu tabel database yang nilainya bersifat unik dan berfungsi sebagai identitas pembeda setiap baris rekaman dinamakan ...',
                'options' => [
                    'a' => 'Primary Key',
                    'b' => 'Foreign Key',
                    'c' => 'Candidate Key biasa',
                    'd' => 'Composite Index',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kolom pada suatu tabel yang merujuk pada Primary Key tabel lain untuk membentuk keterkaitan relasi data antartabel dinamakan ...',
                'options' => [
                    'a' => 'Foreign Key (Kunci Tamu)',
                    'b' => 'Super Key',
                    'c' => 'Index Key',
                    'd' => 'Default Value',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah SQL DML yang digunakan untuk mengambil dan menampilkan data baris rekaman dari satu atau lebih tabel adalah ...',
                'options' => [
                    'a' => 'SELECT',
                    'b' => 'INSERT',
                    'c' => 'UPDATE',
                    'd' => 'DELETE',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Tipe data SQL yang paling efisien digunakan untuk menyimpan teks dengan panjang karakter variabel hingga batas tertentu (misal nama siswa) adalah ...',
                'options' => [
                    'a' => 'VARCHAR',
                    'b' => 'CHAR tetap',
                    'c' => 'BLOB',
                    'd' => 'BOOLEAN',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function basisDataUas(): array
    {
        return [
            [
                'question' => 'Proses pengorganisasian data dalam database relasional untuk menghilangkan redundansi (duplikasi) data dan anomali pembaruan dinamakan ...',
                'options' => [
                    'a' => 'Normalisasi Database',
                    'b' => 'Denormalisasi Ekstrem',
                    'c' => 'Indexing Tabel',
                    'd' => 'Partitioning Partisi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Klausa SQL yang digunakan untuk menggabungkan dua tabel dan hanya menampilkan baris data yang memiliki kecocokan nilai kunci di kedua tabel adalah ...',
                'options' => [
                    'a' => 'INNER JOIN',
                    'b' => 'LEFT JOIN',
                    'c' => 'RIGHT JOIN',
                    'd' => 'FULL OUTER JOIN',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi agregasi SQL yang digunakan untuk menghitung jumlah total baris rekaman data dalam suatu tabel adalah fungsi ...',
                'options' => [
                    'a' => 'COUNT()',
                    'b' => 'SUM()',
                    'c' => 'AVG()',
                    'd' => 'MAX()',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Klausa SQL yang digunakan bersama fungsi agregasi untuk mengelompokkan baris data berdasarkan satu atau beberapa kolom identik adalah ...',
                'options' => [
                    'a' => 'GROUP BY',
                    'b' => 'ORDER BY',
                    'c' => 'HAVING',
                    'd' => 'DISTINCT',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Karakteristik integritas referensial yang secara otomatis menghapus baris data di tabel anak apabila baris induk di tabel utama dihapus adalah opsi ...',
                'options' => [
                    'a' => 'ON DELETE CASCADE',
                    'b' => 'ON DELETE RESTRICT',
                    'c' => 'ON DELETE SET NULL',
                    'd' => 'ON DELETE NO ACTION',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= JARINGAN NIRKABEL =================
    private static function jaringanNirkabelUts(): array
    {
        return [
            [
                'question' => 'Dua frekuensi gelombang radio yang menjadi standar internasional untuk operasional jaringan WiFi (WLAN) adalah ...',
                'options' => [
                    'a' => '2,4 GHz dan 5 GHz',
                    'b' => '900 MHz dan 1800 MHz',
                    'c' => '10 GHz dan 20 GHz',
                    'd' => '50 Hz dan 60 Hz',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Karakteristik sinyal frekuensi WiFi 2,4 GHz dibandingkan dengan frekuensi 5 GHz adalah ...',
                'options' => [
                    'a' => 'Jangkauan sinyal lebih jauh dan lebih baik menembus rintangan dinding, namun kecepatan transfer lebih rendah dan rentan interferensi',
                    'b' => 'Kecepatan data jauh lebih cepat tanpa latensi',
                    'c' => 'Hanya memiliki 1 kanal frekuensi saja',
                    'd' => 'Tidak dapat digunakan oleh smartphone Android',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Nama pengenal unik jaringan nirkabel yang dipancarkan oleh Access Point agar dapat dikenali dan dihubungkan oleh perangkat klien dinamakan ...',
                'options' => [
                    'a' => 'SSID (Service Set Identifier)',
                    'b' => 'BSSID MAC',
                    'c' => 'WPA Passphrase',
                    'd' => 'Subnet ID',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Protokol enkripsi keamanan jaringan nirkabel modern yang paling aman dan direkomendasikan saat ini untuk menggantikan WEP dan WPA adalah ...',
                'options' => [
                    'a' => 'WPA2 / WPA3 Personal (AES)',
                    'b' => 'WEP 64-bit Shared Key',
                    'c' => 'Open System tanpa sandi',
                    'd' => 'WPS PIN Default',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Jenis antena nirkabel yang memancarkan dan menerima sinyal radio ke segala arah (360 derajat) secara merata dinamakan antena ...',
                'options' => [
                    'a' => 'Antena Omnidirectional',
                    'b' => 'Antena Grid Parabolik',
                    'c' => 'Antena Yagi Pengarah',
                    'd' => 'Antena Sektoral Fokus',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function jaringanNirkabelUas(): array
    {
        return [
            [
                'question' => 'Tiga kanal (channel) WiFi pada pita frekuensi 2,4 GHz yang tidak saling tumpang tindih (non-overlapping channels) adalah kanal ...',
                'options' => [
                    'a' => 'Kanal 1, 6, dan 11',
                    'b' => 'Kanal 1, 2, dan 3',
                    'c' => 'Kanal 5, 6, dan 7',
                    'd' => 'Kanal 10, 11, dan 12',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mode kerja Access Point yang berfungsi menerima sinyal nirkabel dari pemancar utama lalu memancarkannya kembali untuk memperluas jangkauan sinyal dinamakan mode ...',
                'options' => [
                    'a' => 'Repeater / Range Extender',
                    'b' => 'Bridge Point-to-Point murni',
                    'c' => 'AP Client Only',
                    'd' => 'Router Gateway',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Standar jaringan WiFi modern generasi ke-6 yang menawarkan efisiensi tinggi pada lingkungan padat perangkat dinamakan standar ...',
                'options' => [
                    'a' => 'IEEE 802.11ax (WiFi 6)',
                    'b' => 'IEEE 802.11b kuno',
                    'c' => 'IEEE 802.3 Ethernet',
                    'd' => 'Bluetooth 4.0',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Teknologi antena nirkabel modern yang memanfaatkan banyak pemancar dan penerima untuk mengirimkan beberapa aliran data secara simultan dinamakan ...',
                'options' => [
                    'a' => 'MIMO (Multiple Input, Multiple Output)',
                    'b' => 'SISO (Single Input, Single Output)',
                    'c' => 'TDMA Time Slot',
                    'd' => 'FDMA Analogue',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Survei lokasi lapangan untuk mengukur jangkauan sinyal, interferensi gelombang radio, dan menentukan titik penempatan Access Point dinamakan ...',
                'options' => [
                    'a' => 'Wireless Site Survey',
                    'b' => 'Cable Crimping Test',
                    'c' => 'Bandwidth Throttling',
                    'd' => 'Speedtest ISP',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= PEMROGRAMAN MOBILE =================
    private static function pemrogramanMobileUts(): array
    {
        return [
            [
                'question' => 'Metode siklus hidup (lifecycle callback) pada Activity Android yang pertama kali dipanggil saat aktivitas aplikasi dibuat adalah ...',
                'options' => [
                    'a' => 'onCreate()',
                    'b' => 'onStart()',
                    'c' => 'onResume()',
                    'd' => 'onDestroy()',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Framework open-source besutan Google yang memungkinkan pembuatan aplikasi mobile multiplatform (Android & iOS) menggunakan bahasa pemrograman Dart adalah ...',
                'options' => [
                    'a' => 'Flutter',
                    'b' => 'Laravel',
                    'c' => 'Django',
                    'd' => 'ASP.NET',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Format file paket aplikasi siap pasang untuk sistem operasi Android yang dapat diinstal langsung oleh pengguna adalah file berekstensi ...',
                'options' => [
                    'a' => '.apk',
                    'b' => '.exe',
                    'c' => '.dmg',
                    'd' => '.ipa',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Berkas konfigurasi utama pada proyek Android yang mendefinisikan izin hak akses aplikasi (permissions), nama package, dan daftar Activity adalah ...',
                'options' => [
                    'a' => 'AndroidManifest.xml',
                    'b' => 'build.gradle',
                    'c' => 'strings.xml',
                    'd' => 'MainActivity.java',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen antarmuka dasar dalam framework Flutter yang digunakan untuk menyusun elemen secara vertikal dari atas ke bawah adalah widget ...',
                'options' => [
                    'a' => 'Column',
                    'b' => 'Row',
                    'c' => 'Stack',
                    'd' => 'Container',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function pemrogramanMobileUas(): array
    {
        return [
            [
                'question' => 'Konsep pengelolaan keadaan data dinamis pada antarmuka aplikasi mobile (seperti status login, keranjang belanja) dinamakan ...',
                'options' => [
                    'a' => 'State Management (misal Provider, Bloc, Riverpod)',
                    'b' => 'Asset Bundler',
                    'c' => 'Static Routing',
                    'd' => 'Compiler Hook',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mekanisme penyimpanan data lokal ringan berpasangan key-value pada perangkat smartphone cocok disimpan menggunakan ...',
                'options' => [
                    'a' => 'SharedPreferences (Android) / NSUserDefaults (iOS)',
                    'b' => 'Server Cloud MySQL',
                    'c' => 'File RAM statis',
                    'd' => 'Cookie web biasa',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Format file distribusi penerbitan aplikasi Android modern yang diwajibkan oleh Google Play Store untuk optimasi ukuran download perangkat adalah ...',
                'options' => [
                    'a' => 'AAB (Android App Bundle)',
                    'b' => 'JAR file',
                    'c' => 'ZIP archive',
                    'd' => 'ISO image',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pendekatan pemrograman yang mengeksekusi pengambilan data dari internet di latar belakang tanpa membuat antarmuka layar membeku (freeze) menggunakan konsep ...',
                'options' => [
                    'a' => 'Asynchronous Programming (Async / Await / Futures)',
                    'b' => 'Blocking Synchronous Loop',
                    'c' => 'Infinite Thread Sleep',
                    'd' => 'Single State Constant',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sertifikat keamanan digital yang digunakan pengembang untuk menandatangani paket aplikasi Android sebelum dirilis secara publik dinamakan ...',
                'options' => [
                    'a' => 'App Signing Keystore (.jks / .keystore)',
                    'b' => 'SSL Apache Certificate',
                    'c' => 'SSH RSA Key',
                    'd' => 'PGP Public Signature',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= IOT & SISTEM TERTANAM =================
    private static function iotSistemTertanamUts(): array
    {
        return [
            [
                'question' => 'Papan mikrokontroler kompak berbiaya terjangkau yang sudah dilengkapi modul WiFi dan Bluetooth terintegrasi sehingga sangat populer untuk proyek IoT adalah ...',
                'options' => [
                    'a' => 'ESP32 / ESP8266 NodeMCU',
                    'b' => 'Arduino Uno tanpa shield',
                    'c' => 'Processor Intel Core i7',
                    'd' => 'Raspberry Pi Power Supply',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pin serbaguna pada mikrokontroler yang dapat diprogram sebagai masukan sensor atau keluaran aktuator dinamakan pin ...',
                'options' => [
                    'a' => 'GPIO (General Purpose Input/Output)',
                    'b' => 'VCC Power Pin',
                    'c' => 'GND Ground Pin',
                    'd' => 'RESET Pin',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sensor digital yang sering digunakan pada proyek IoT lingkungan untuk mengukur suhu dan kelembaban udara ruangan adalah sensor ...',
                'options' => [
                    'a' => 'DHT11 / DHT22',
                    'b' => 'LDR (Light Dependent Resistor)',
                    'c' => 'MQ-2 Gas Sensor',
                    'd' => 'HC-SR04 Ultrasonic',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen elektronika sakelar elektromekanik yang digunakan mikrokontroler untuk menghidupkan dan mematikan peralatan listrik rumah bertagangan 220V AC adalah ...',
                'options' => [
                    'a' => 'Modul Relay',
                    'b' => 'Motor Servo',
                    'c' => 'LED Indikator',
                    'd' => 'Buzzer pasif',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi utama dari Analog-to-Digital Converter (ADC) pada board sistem mikrokontroler adalah ...',
                'options' => [
                    'a' => 'Mengubah tegangan analog kontinu dari sensor menjadi nilai digital yang dapat diolah oleh mikroprosesor',
                    'b' => 'Mengubah sinyal digital menjadi arus bolak-balik PLN',
                    'c' => 'Menyimpan kode program secara permanen',
                    'd' => 'Menghubungkan board ke jaringan kabel LAN',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function iotSistemTertanamUas(): array
    {
        return [
            [
                'question' => 'Protokol komunikasi perpesanan data yang sangat ringan, hemat bandwidth, dan berbasis Publish-Subscribe yang menjadi standar komunikasi IoT adalah ...',
                'options' => [
                    'a' => 'MQTT (Message Queuing Telemetry Transport)',
                    'b' => 'FTP Transfer',
                    'c' => 'SMTP Mail',
                    'd' => 'SNMP Manager',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Server perantara yang bertugas menerima seluruh pesan dari perangkat publisher dan menyalurkannya ke subscriber yang berlangganan topik pada arsitektur MQTT dinamakan ...',
                'options' => [
                    'a' => 'MQTT Broker (misal Eclipse Mosquitto)',
                    'b' => 'Web Browser',
                    'c' => 'Database Engine',
                    'd' => 'DNS Master',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fitur hemat daya pada mikrokontroler ESP32 di mana sebagian besar modul dimatikan saat tidak ada tugas pembacaan sensor dinamakan mode ...',
                'options' => [
                    'a' => 'Deep Sleep Mode',
                    'b' => 'Overclocking Mode',
                    'c' => 'High Performance Mode',
                    'd' => 'Continuous Polling',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Platform cloud IoT yang menyediakan antarmuka dashboard mobile/web siap pakai untuk memantau data sensor dan tombol kendali adalah ...',
                'options' => [
                    'a' => 'Blynk / ThingsBoard / ThingSpeak',
                    'b' => 'Microsoft Word 365',
                    'c' => 'Adobe Photoshop Cloud',
                    'd' => 'VLC Media Player',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kecepatan transfer data simbol per detik pada komunikasi port serial antara mikrokontroler dan komputer dinamakan ...',
                'options' => [
                    'a' => 'Baud Rate (misal 9600 atau 115200 bps)',
                    'b' => 'Refresh Rate Hz',
                    'c' => 'Frame Per Second',
                    'd' => 'Bit Depth Audio',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= VIRTUALISASI & CLOUD =================
    private static function virtualisasiCloudUts(): array
    {
        return [
            [
                'question' => 'Tipe hypervisor (Tipe 1 / Bare-metal) yang langsung diinstal di atas perangkat keras server tanpa memerlukan sistem operasi induk perantara adalah ...',
                'options' => [
                    'a' => 'Proxmox VE / VMware ESXi',
                    'b' => 'Oracle VirtualBox',
                    'c' => 'VMware Workstation Pro',
                    'd' => 'BlueStacks Emulator',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perbedaan utama antara kontainerisasi (seperti Docker) dan Mesin Virtual (Virtual Machine) konvensional adalah ...',
                'options' => [
                    'a' => 'Kontainer berbagi kernel sistem operasi induk sehingga jauh lebih ringan dan instan dinyalakan, sedangkan VM mengisolasi OS tamu lengkap beserta virtual hardware',
                    'b' => 'Mesin virtual tidak membutuhkan memori RAM',
                    'c' => 'Kontainer hanya bisa berjalan pada prosesor smartphone',
                    'd' => 'VM tidak dapat terhubung ke jaringan internet',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Model layanan komputasi awan yang menyediakan infrastruktur dasar seperti server komputasi virtual, penyimpanan, dan jaringan adalah model ...',
                'options' => [
                    'a' => 'IaaS (Infrastructure as a Service)',
                    'b' => 'PaaS (Platform as a Service)',
                    'c' => 'SaaS (Software as a Service)',
                    'd' => 'DaaS (Data as a Service)',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Layanan aplikasi email Google Workspace atau Microsoft 365 yang dapat langsung digunakan pengguna akhir melalui browser tergolong model layanan ...',
                'options' => [
                    'a' => 'SaaS (Software as a Service)',
                    'b' => 'IaaS',
                    'c' => 'PaaS',
                    'd' => 'BaaS',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mode antarmuka jaringan pada software virtualisasi yang membuat Mesin Virtual mendapatkan IP Address sendiri langsung dari DHCP router fisik dinamakan mode ...',
                'options' => [
                    'a' => 'Bridged Adapter',
                    'b' => 'NAT (Network Address Translation)',
                    'c' => 'Internal Network Only',
                    'd' => 'Host-Only Adapter',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function virtualisasiCloudUas(): array
    {
        return [
            [
                'question' => 'Kemampuan sistem cloud untuk menambah atau mengurangi kapasitas sumber daya server secara otomatis menyesuaikan lonjakan beban trafik dinamakan ...',
                'options' => [
                    'a' => 'Elasticity / Auto Scaling',
                    'b' => 'Static Allocation',
                    'c' => 'Manual Provisioning',
                    'd' => 'Hard Partitioning',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fitur pada software virtualisasi yang berfungsi menyimpan status lengkap sistem operasi VM pada satu titik waktu tertentu untuk kemudahan pemulihan cepat dinamakan ...',
                'options' => [
                    'a' => 'Snapshot',
                    'b' => 'Defragmentation',
                    'c' => 'Overclock',
                    'd' => 'Direct Storage',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Penyimpanan cloud berbasis objek (Object Storage) yang sangat cocok untuk menyimpan berkas media tidak terstruktur dalam skala besar contohnya adalah ...',
                'options' => [
                    'a' => 'Amazon S3 / Google Cloud Storage',
                    'b' => 'Kabel SATA Lokal',
                    'c' => 'Flash ROM BIOS',
                    'd' => 'RAM DDR4',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Konsep arsitektur di mana infrastruktur server publik dibagi pakai oleh banyak pelanggan namun tetap terisolasi secara aman dinamakan ...',
                'options' => [
                    'a' => 'Multi-Tenancy',
                    'b' => 'Single-User Lock',
                    'c' => 'Private Bare-Metal Only',
                    'd' => 'Localhost Isolation',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Teknologi virtualisasi tingkat kontainer yang mengotomatisasi penyebaran, penskalaan, dan pengelolaan kontainer aplikasi dalam klaster server dinamakan ...',
                'options' => [
                    'a' => 'Kubernetes (K8s)',
                    'b' => 'Apache Server',
                    'c' => 'FileZilla FTP',
                    'd' => 'PuTTY Client',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= TROUBLESHOOTING JARINGAN =================
    private static function troubleshootingJaringanUts(): array
    {
        return [
            [
                'question' => 'Pendekatan pemecahan masalah jaringan yang dimulai dari pemeriksaan perangkat keras fisik, kabel LAN, dan port lampu indikator kartu jaringan dinamakan metode ...',
                'options' => [
                    'a' => 'Bottom-Up Troubleshooting',
                    'b' => 'Top-Down Troubleshooting',
                    'c' => 'Divide and Conquer',
                    'd' => 'Trial and Error acak',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Alat penguji perangkat keras yang digunakan teknisi untuk memeriksa urutan pin dan memastikan tidak ada jalur kabel UTP yang putus adalah ...',
                'options' => [
                    'a' => 'LAN Tester (Cable Tester)',
                    'b' => 'Multimeter Analog',
                    'c' => 'Oscilloscope',
                    'd' => 'Fusion Splicer',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Masalah jaringan di mana dua perangkat berbeda dalam satu jaringan lokal diberikan alamat IP yang sama persis dinamakan ...',
                'options' => [
                    'a' => 'IP Address Conflict',
                    'b' => 'Default Gateway Missing',
                    'c' => 'DNS Failure',
                    'd' => 'Broadcast Storm',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah command prompt pada sistem operasi Windows yang digunakan untuk menghapus memori singgahan (cache) DNS yang rusak atau usang adalah ...',
                'options' => [
                    'a' => 'ipconfig /flushdns',
                    'b' => 'ipconfig /release',
                    'c' => 'netstat -a',
                    'd' => 'route print',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Gejala kabel LAN terhubung namun ikon koneksi Windows menampilkan tanda seru kuning dengan keterangan "No Internet Access" umumnya disebabkan oleh ...',
                'options' => [
                    'a' => 'Konfigurasi IP/Gateway salah, atau router/ISP mengalami gangguan koneksi ke internet',
                    'b' => 'Monitor komputer resolusinya terlalu rendah',
                    'c' => 'Keyboard tidak terdeteksi',
                    'd' => 'Kipas CPU mati',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function troubleshootingJaringanUas(): array
    {
        return [
            [
                'question' => 'Perintah diagnostik jaringan yang digunakan untuk melacak jalur rute lompatan router (hop) yang dilalui paket data dari komputer lokal hingga tujuan adalah ...',
                'options' => [
                    'a' => 'tracert (Windows) / traceroute (Linux)',
                    'b' => 'nslookup',
                    'c' => 'arp -a',
                    'd' => 'nbtstat',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perangkat lunak analisis protokol jaringan (packet sniffer) populer yang digunakan teknisi untuk merekam dan menganalisis paket data yang lewat secara mendalam adalah ...',
                'options' => [
                    'a' => 'Wireshark',
                    'b' => 'WinRAR',
                    'c' => 'Sublime Text',
                    'd' => 'Notepad++',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah untuk melihat tabel pemetaan antara IP Address dan MAC Address perangkat lain di jaringan lokal pada komputer kita adalah ...',
                'options' => [
                    'a' => 'arp -a',
                    'b' => 'ping 127.0.0.1',
                    'c' => 'hostname',
                    'd' => 'net view',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Alat ukur jaringan berbasis baris perintah (CLI) yang digunakan untuk menguji kecepatan throughput bandwidth jaringan secara maksimal antara dua host adalah ...',
                'options' => [
                    'a' => 'iPerf / iPerf3',
                    'b' => 'Speedometer',
                    'c' => 'Telnet',
                    'd' => 'TFTP Client',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Jika seorang pengguna dapat membuka situs web menggunakan alamat IP server (misal http://142.250.190.46) tetapi gagal saat mengetik nama domain (http://google.com), letak masalahnya adalah ...',
                'options' => [
                    'a' => 'Konfigurasi DNS Server klien salah atau DNS server tidak merespon',
                    'b' => 'Kabel UTP fisik putus',
                    'c' => 'Kartu jaringan LAN rusak',
                    'd' => 'Default gateway tidak aktif',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= ROUTING & SWITCHING =================
    private static function routingSwitchingUts(): array
    {
        return [
            [
                'question' => 'Teknologi jaringan pada switch yang memungkinkan pembagian satu switch fisik menjadi beberapa jaringan logis yang berbeda broadcast domain dinamakan ...',
                'options' => [
                    'a' => 'VLAN (Virtual Local Area Network)',
                    'b' => 'VPN (Virtual Private Network)',
                    'c' => 'NAT (Network Address Translation)',
                    'd' => 'DMZ (Demilitarized Zone)',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mode port switch yang digunakan untuk menghubungkan switch dengan perangkat akhir (seperti PC klien atau printer) dinamakan mode ...',
                'options' => [
                    'a' => 'Access Port',
                    'b' => 'Trunk Port',
                    'c' => 'Bridge Port',
                    'd' => 'Mirror Port',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mode port switch yang berfungsi membawa lalu lintas data dari berbagai VLAN secara bersamaan melalui satu kabel penghubung antarswitch dinamakan ...',
                'options' => [
                    'a' => 'Trunk Port (IEEE 802.1Q)',
                    'b' => 'Access Port',
                    'c' => 'Dynamic Port',
                    'd' => 'Loopback Port',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metode routing di mana penentuan rute jalur pengiriman paket jaringan dikonfigurasi secara manual satu per satu oleh administrator jaringan dinamakan ...',
                'options' => [
                    'a' => 'Routing Statis (Static Routing)',
                    'b' => 'Routing Dinamis (Dynamic Routing)',
                    'c' => 'Default Route otomatis',
                    'd' => 'Adaptive Routing',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Protokol pada switch layer 2 yang berfungsi mencegah terjadinya loop jaringan (bridging loops) dan badai broadcast (broadcast storm) adalah ...',
                'options' => [
                    'a' => 'STP (Spanning Tree Protocol)',
                    'b' => 'RIP (Routing Information Protocol)',
                    'c' => 'OSPF',
                    'd' => 'BGP',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function routingSwitchingUas(): array
    {
        return [
            [
                'question' => 'Protokol routing dinamis berbasis Link-State yang menggunakan algoritma Dijkstra (Shortest Path First) untuk menentukan rute terbaik dalam jaringan internal besar adalah ...',
                'options' => [
                    'a' => 'OSPF (Open Shortest Path First)',
                    'b' => 'RIPv1',
                    'c' => 'EGP',
                    'd' => 'Static Route',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metode perutean antarmuka sub-interface pada satu port fisik router untuk menghubungkan komunikasi antarkelompok VLAN dinamakan teknik ...',
                'options' => [
                    'a' => 'Router-on-a-Stick',
                    'b' => 'Switch Stacking',
                    'c' => 'Port Mirroring',
                    'd' => 'Daisy Chaining',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Protokol routing eksterior standar internasional yang digunakan untuk saling mempertukarkan informasi rute antar Autonomous System (AS) di seluruh internet adalah ...',
                'options' => [
                    'a' => 'BGP (Border Gateway Protocol)',
                    'b' => 'OSPF',
                    'c' => 'RIPv2',
                    'd' => 'IS-IS',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Nilai preferensi keandalan suatu sumber informasi routing pada router yang menentukan rute mana yang dipasang ke routing table dinamakan ...',
                'options' => [
                    'a' => 'Administrative Distance (AD)',
                    'b' => 'Subnet Mask',
                    'c' => 'Hop Count saja',
                    'd' => 'Bandwidth Cost',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah pada router Cisco untuk menampilkan seluruh tabel perutean yang sedang aktif adalah ...',
                'options' => [
                    'a' => 'show ip route',
                    'b' => 'show running-config',
                    'c' => 'show interfaces status',
                    'd' => 'show vlan brief',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= ETHICAL HACKING DASAR =================
    private static function ethicalHackingUts(): array
    {
        return [
            [
                'question' => 'Istilah untuk peretas beretika profesional yang melakukan pengujian keamanan sistem komputer atas izin resmi pemilik sistem untuk mencari celah kerentanan dinamakan ...',
                'options' => [
                    'a' => 'White Hat Hacker (Ethical Hacker)',
                    'b' => 'Black Hat Hacker (Cracker)',
                    'c' => 'Script Kiddie',
                    'd' => 'Cyber Terrorist',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Tahap awal dalam metodologi ethical hacking yang berfokus pada pengumpulan informasi target secara pasif maupun aktif dinamakan tahap ...',
                'options' => [
                    'a' => 'Reconnaissance / Footprinting',
                    'b' => 'Exploitation',
                    'c' => 'Maintaining Access',
                    'd' => 'Clearing Tracks',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perangkat lunak open-source paling populer yang digunakan untuk memindai port terbuka dan mendeteksi versi sistem operasi perangkat target di jaringan adalah ...',
                'options' => [
                    'a' => 'Nmap (Network Mapper)',
                    'b' => 'Microsoft Paint',
                    'c' => 'VLC Media Player',
                    'd' => 'Winamp',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Dokumen tertulis resmi yang memuat persetujuan cakupan batasan pengujian keamanan, jadwal, dan aturan hukum antara penetration tester dan klien dinamakan ...',
                'options' => [
                    'a' => 'Rules of Engagement (RoE)',
                    'b' => 'Kartu Identitas Karyawan',
                    'c' => 'Faktur Pembelian Alat',
                    'd' => 'Surat Bebas Narkoba',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pengumpulan data target menggunakan sumber data publik terbuka di internet (seperti Google Dorking, Whois, dan media sosial) dinamakan metode ...',
                'options' => [
                    'a' => 'OSINT (Open Source Intelligence)',
                    'b' => 'Direct Port Attack',
                    'c' => 'Hardware Tampering',
                    'd' => 'Physical Infiltration',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function ethicalHackingUas(): array
    {
        return [
            [
                'question' => 'Kerentanan aplikasi web yang terjadi saat input pengguna langsung digabungkan ke query database tanpa sanitasi sehingga penyerang dapat memanipulasi data dinamakan ...',
                'options' => [
                    'a' => 'SQL Injection (SQLi)',
                    'b' => 'Cross-Site Scripting (XSS)',
                    'c' => 'Buffer Overflow',
                    'd' => 'Directory Traversal',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Teknik pencegahan paling ampuh terhadap serangan SQL Injection pada kode backend aplikasi web adalah menggunakan ...',
                'options' => [
                    'a' => 'Prepared Statements / Parameterized Queries',
                    'b' => 'Mematikan fitur database',
                    'c' => 'Menghapus tabel database',
                    'd' => 'Mengganti nama kolom menjadi acak',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Serangan web di mana penyerang menyisipkan skrip JavaScript berbahaya ke dalam situs terpercaya sehingga dieksekusi di browser pengunjung lain dinamakan ...',
                'options' => [
                    'a' => 'Cross-Site Scripting (XSS)',
                    'b' => 'Clickjacking',
                    'c' => 'DNS Poisoning',
                    'd' => 'Man-in-the-Middle',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metode penyerangan pemecah kata sandi yang mencoba ribuan kata dari daftar kamus kata sandi populer yang telah disiapkan sebelumnya dinamakan ...',
                'options' => [
                    'a' => 'Dictionary Attack',
                    'b' => 'Brute Force murni',
                    'c' => 'Rainbow Table Collision',
                    'd' => 'Social Phishing',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Langkah penutup paling penting bagi seorang ethical hacker setelah menemukan celah kerentanan dalam simulasi pengujian resmi adalah ...',
                'options' => [
                    'a' => 'Menyusun Laporan Kerentanan Lengkap (Vulnerability Assessment Report) disertai rekomendasi perbaikan (remediasi)',
                    'b' => 'Menjual data target ke forum gelap dark web',
                    'c' => 'Menghapus database perusahaan target tanpa izin',
                    'd' => 'Mengubah halaman beranda situs target (defacing)',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= MANAJEMEN PROYEK IT =================
    private static function manajemenProyekItUts(): array
    {
        return [
            [
                'question' => 'Kerangka kerja pengembangan perangkat lunak berbasis metodologi Agile yang mengutamakan kolaborasi tim, fleksibilitas perubahan, dan iterasi kerja berkala dinamakan ...',
                'options' => [
                    'a' => 'Scrum',
                    'b' => 'Waterfall murni',
                    'c' => 'COBIT Audit',
                    'd' => 'ISO 9001',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Siklus waktu pengerjaan iteratif dalam Scrum yang umumnya berdurasi 1 hingga 4 minggu untuk menyelesaikan sekumpulan fitur aplikasi dinamakan ...',
                'options' => [
                    'a' => 'Sprint',
                    'b' => 'Milestone',
                    'c' => 'Epic',
                    'd' => 'Backlog',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Peran dalam tim Scrum yang bertanggung jawab memaksimalkan nilai produk dan mengelola daftar prioritas kebutuhan pengguna (Product Backlog) adalah ...',
                'options' => [
                    'a' => 'Product Owner (PO)',
                    'b' => 'Scrum Master',
                    'c' => 'Developer',
                    'd' => 'Project Sponsor',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pertemuan singkat harian berdurasi 15 menit bagi tim Scrum untuk mengevaluasi apa yang dikerjakan kemarin, hari ini, dan hambatan kerja dinamakan ...',
                'options' => [
                    'a' => 'Daily Standup Meeting (Daily Scrum)',
                    'b' => 'Sprint Planning',
                    'c' => 'Sprint Review',
                    'd' => 'Sprint Retrospective',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Peran dalam tim Scrum yang bertindak sebagai fasilitator, pelatih proses Agile, dan bertugas menyingkirkan hambatan yang dihadapi tim adalah ...',
                'options' => [
                    'a' => 'Scrum Master',
                    'b' => 'Technical Writer',
                    'c' => 'Quality Assurance Lead',
                    'd' => 'DevOps Engineer',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function manajemenProyekItUas(): array
    {
        return [
            [
                'question' => 'Diagram visual berbentuk batang horizontal yang memetakan jadwal proyek, durasi kegiatan, dan ketergantungan antarpekerjaan dinamakan ...',
                'options' => [
                    'a' => 'Gantt Chart',
                    'b' => 'Pie Chart',
                    'c' => 'Scatter Plot',
                    'd' => 'Entity Relationship Diagram',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Papan visual pelacak status alur kerja tugas (misal kolom To Do, In Progress, Review, dan Done) dinamakan papan ...',
                'options' => [
                    'a' => 'Kanban Board',
                    'b' => 'Whiteboard statis',
                    'c' => 'Leaderboard skor',
                    'd' => 'Story map',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fenomena membengkaknya ruang lingkup kebutuhan proyek yang tidak terkontrol di tengah perjalanan tanpa penyesuaian waktu dan anggaran dinamakan ...',
                'options' => [
                    'a' => 'Scope Creep',
                    'b' => 'Sprint Drift',
                    'c' => 'Critical Path Failure',
                    'd' => 'Budget Freeze',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pertemuan di akhir siklus sprint di mana tim Scrum melakukan evaluasi diri mengenai cara kerja dan menyepakati perbaikan untuk sprint berikutnya dinamakan ...',
                'options' => [
                    'a' => 'Sprint Retrospective',
                    'b' => 'Sprint Demo',
                    'c' => 'Kickoff Meeting',
                    'd' => 'Budget Auditing',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perangkat lunak kolaborasi manajemen proyek digital yang sangat populer digunakan oleh tim IT modern contohnya adalah ...',
                'options' => [
                    'a' => 'Jira / Trello / Asana',
                    'b' => 'VLC Media Player',
                    'c' => 'Windows Media Player',
                    'd' => 'Adobe Premiere',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= MULTIMEDIA, DESAIN & UI/UX =================
    private static function multimediaUiUxUts(): array
    {
        return [
            [
                'question' => 'Dua model warna standar dalam desain grafis: model RGB digunakan untuk ..., sedangkan model CMYK digunakan untuk ...',
                'options' => [
                    'a' => 'Media layar tampilan digital / Media cetak fisik',
                    'b' => 'Media cetak koran / Tampilan monitor komputer',
                    'c' => 'Gambar hitam putih / Gambar berwarna',
                    'd' => 'Foto kamera analog / Desain web vektor',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Karakteristik utama dari gambar grafik berbasis vektor (seperti file SVG atau Illustrator) adalah ...',
                'options' => [
                    'a' => 'Tersusun dari rumus matematis garis dan bidang sehingga tidak akan pecah atau buram saat diperbesar',
                    'b' => 'Tersusun dari susunan piksel tetap yang pecah saat di-zoom',
                    'c' => 'Ukuran filenya selalu berukuran gigabyte',
                    'd' => 'Hanya bisa dilihat di smartphone Android',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perbedaan mendasar antara User Interface (UI) dan User Experience (UX) adalah ...',
                'options' => [
                    'a' => 'UI fokus pada keindahan estetika visual antarmuka, sedangkan UX fokus pada kenyamanan, efisiensi, dan perasaan pengguna saat memakai aplikasi',
                    'b' => 'UI adalah koding database, UX adalah desain banner',
                    'c' => 'UI hanya untuk mobile, UX hanya untuk desktop',
                    'd' => 'UI dikerjakan programmer backend, UX dikerjakan mekanik',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sketsa tata letak kerangka dasar halaman web atau aplikasi berupa garis dan kotak sederhana tanpa elemen estetika warna dinamakan ...',
                'options' => [
                    'a' => 'Wireframe (Low-Fidelity)',
                    'b' => 'High-Fidelity Mockup',
                    'c' => 'Production Release',
                    'd' => 'Final Artboard',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Lima tahapan proses berpikir desain pemecahan masalah yang berpusat pada manusia (Design Thinking) secara berurutan adalah ...',
                'options' => [
                    'a' => 'Empathize -> Define -> Ideate -> Prototype -> Test',
                    'b' => 'Coding -> Testing -> Deploying -> Marketing -> Selling',
                    'c' => 'Plan -> Budget -> Build -> Run -> Close',
                    'd' => 'Design -> Animate -> Render -> Export -> Publish',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function multimediaUiUxUas(): array
    {
        return [
            [
                'question' => 'Aplikasi desain berbasis antarmuka kolaboratif daring berbasis cloud yang menjadi standar industri global untuk perancangan UI/UX saat ini adalah ...',
                'options' => [
                    'a' => 'Figma',
                    'b' => 'Microsoft Paint',
                    'c' => 'Corel Ventura',
                    'd' => 'Notepad++',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metode pengujian langsung di mana calon pengguna diminta mencoba menjalankan tugas-tugas pada prototipe aplikasi guna mengevaluasi kemudahan pemakaian dinamakan ...',
                'options' => [
                    'a' => 'Usability Testing',
                    'b' => 'Unit Testing koding',
                    'c' => 'Stress Testing server',
                    'd' => 'Security Penetration Test',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Prinsip desain visual yang mengatur perbedaan ketebalan font, ukuran teks, dan warna untuk memandu mata pengguna membaca informasi terpenting lebih dahulu dinamakan ...',
                'options' => [
                    'a' => 'Visual Hierarchy (Hierarki Visual)',
                    'b' => 'Random Color Palette',
                    'c' => 'Uniform Contrast Balance',
                    'd' => 'Flat Spacing',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Karakter fiktif representatif yang dibuat oleh tim UX berdasarkan riset data nyata untuk menggambarkan profil, kebutuhan, dan kendala target pengguna aplikasi dinamakan ...',
                'options' => [
                    'a' => 'User Persona',
                    'b' => 'Celebrity Endorser',
                    'c' => 'Virtual Influencer',
                    'd' => 'NPC Character',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kumpulan panduan standar komponen desain visual terpadu yang dapat digunakan berulang oleh tim desainer dan developer (seperti warna, tombol, tipografi) dinamakan ...',
                'options' => [
                    'a' => 'Design System',
                    'b' => 'Moodboard acak',
                    'c' => 'Clip Art Gallery',
                    'd' => 'Stock Photo Bundle',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= DEVOPS DASAR =================
    private static function devOpsUts(): array
    {
        return [
            [
                'question' => 'Filosofi dan praktik kerja rekayasa perangkat lunak yang menggabungkan kolaborasi antara tim pengembang (Dev) dan tim operasional TI (Ops) dinamakan ...',
                'options' => [
                    'a' => 'DevOps',
                    'b' => 'Waterfall Silo',
                    'c' => 'Monolithic Segregation',
                    'd' => 'Manual Staging',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sistem pengontrol versi terdistribusi (VCS) paling populer yang digunakan untuk mencatat riwayat perubahan berkas kode program adalah ...',
                'options' => [
                    'a' => 'Git',
                    'b' => 'SVN kuno',
                    'c' => 'Dropbox sync',
                    'd' => 'FTP Uploader',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perintah Git yang digunakan untuk menyimpan rekaman snapshot perubahan berkas yang telah dipilih ke repositori lokal disertai pesan keterangan adalah ...',
                'options' => [
                    'a' => 'git commit -m "pesan komit"',
                    'b' => 'git push origin main',
                    'c' => 'git pull origin main',
                    'd' => 'git status',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Berkas konfigurasi khusus di repositori Git yang bertugas mendefinisikan daftar file rahasia atau folder sementara yang dilarang diunggah ke repositori publik adalah ...',
                'options' => [
                    'a' => '.gitignore',
                    'b' => 'README.md',
                    'c' => 'LICENSE',
                    'd' => '.gitconfig',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Layanan hosting repositori Git daring berbasis cloud yang banyak digunakan developer untuk kolaborasi kode dan otomasi alur kerja CI/CD adalah ...',
                'options' => [
                    'a' => 'GitHub / GitLab',
                    'b' => 'Google Drive',
                    'c' => 'MediaFire',
                    'd' => 'Mega Upload',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function devOpsUas(): array
    {
        return [
            [
                'question' => 'Praktik otomatisasi pengujian kode setiap kali developer melakukan push kode ke repositori bersama untuk mendeteksi error sedini mungkin dinamakan ...',
                'options' => [
                    'a' => 'Continuous Integration (CI)',
                    'b' => 'Manual Debugging',
                    'c' => 'Scheduled Patching',
                    'd' => 'Cold Standby',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Praktik otomatisasi peluncuran dan perilisan aplikasi ke lingkungan server produksi setiap kali kode lolos tahap pengujian dinamakan ...',
                'options' => [
                    'a' => 'Continuous Deployment (CD)',
                    'b' => 'Manual FTP Upload',
                    'c' => 'Copy Paste Server',
                    'd' => 'Offline Flashdisk Deployment',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Konsep pengelolaan infrastruktur server, jaringan, dan konfigurasi menggunakan kode terprogram yang dapat direproduksi secara konsisten dinamakan ...',
                'options' => [
                    'a' => 'Infrastructure as Code (IaC, misal Terraform / Ansible)',
                    'b' => 'Manual Click Setup',
                    'c' => 'Hardcoded Topology',
                    'd' => 'Ad-hoc Maintenance',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perangkat lunak orkestrasi pipeline CI/CD bawaan GitHub yang menjalankan workflow otomatis menggunakan file berekstensi YAML adalah ...',
                'options' => [
                    'a' => 'GitHub Actions',
                    'b' => 'Git LFS',
                    'c' => 'GitHub Desktop',
                    'd' => 'Git Bash GUI',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Berkas konfigurasi teks yang berisi instruksi bertahap untuk membangun image kontainer Docker mandiri dinamakan ...',
                'options' => [
                    'a' => 'Dockerfile',
                    'b' => 'docker-compose.lock',
                    'c' => 'Container.conf',
                    'd' => 'kernel.iso',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= NODE.JS & BACKEND =================
    private static function nodeJsBackendUts(): array
    {
        return [
            [
                'question' => 'Lingkungan eksekusi (runtime environment) yang memungkinkan bahasa pemrograman JavaScript dijalankan di sisi server di luar browser adalah ...',
                'options' => [
                    'a' => 'Node.js',
                    'b' => 'V8 Browser Only',
                    'c' => 'Apache Tomcat',
                    'd' => 'XAMPP Lite',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Manajer paket resmi default untuk ekosistem Node.js yang digunakan untuk menginstal modul pustaka eksternal adalah ...',
                'options' => [
                    'a' => 'NPM (Node Package Manager)',
                    'b' => 'Composer',
                    'c' => 'Pip',
                    'd' => 'Maven',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Karakteristik arsitektur komputasi I/O pada Node.js yang membuatnya sangat efisien menangani ribuan koneksi konkuren simultan adalah ...',
                'options' => [
                    'a' => 'Asynchronous and Non-Blocking I/O berbasis Event Loop',
                    'b' => 'Multi-threaded synchronous blocking',
                    'c' => 'One thread per connection model',
                    'd' => 'Static batch processing',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Framework web minimalis dan fleksibel yang paling populer digunakan untuk membangun aplikasi web dan RESTful API di atas Node.js adalah ...',
                'options' => [
                    'a' => 'Express.js',
                    'b' => 'Angular',
                    'c' => 'Vue.js',
                    'd' => 'jQuery',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Berkas manifestasi utama pada proyek Node.js yang memuat nama proyek, versi, skrip eksekusi, dan daftar dependensi pustaka adalah ...',
                'options' => [
                    'a' => 'package.json',
                    'b' => 'server.xml',
                    'c' => 'manifest.json',
                    'd' => 'composer.json',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function nodeJsBackendUas(): array
    {
        return [
            [
                'question' => 'Standar format token berbasis string ringkas yang banyak digunakan untuk autentikasi stateless antara klien dan server REST API backend adalah ...',
                'options' => [
                    'a' => 'JWT (JSON Web Token)',
                    'b' => 'Session ID Cookie murni',
                    'c' => 'API Key publik',
                    'd' => 'Plaintext Password',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi perantara pada framework Express.js yang memiliki akses ke objek permintaan (req), respon (res), dan fungsi lanjutan (next) dinamakan ...',
                'options' => [
                    'a' => 'Middleware',
                    'b' => 'Router Handler',
                    'c' => 'Event Dispatcher',
                    'd' => 'Static Asset Parser',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pustaka pembuat hash satu arah yang sangat populer di Node.js untuk mengenkripsi kata sandi pengguna dengan garam (salt) adalah ...',
                'options' => [
                    'a' => 'bcrypt / bcryptjs',
                    'b' => 'MD5 biasa',
                    'c' => 'Base64 encoder',
                    'd' => 'Rot13',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Manajer proses produksi (Process Manager) populer untuk aplikasi Node.js yang bertugas menjaga aplikasi tetap hidup dan otomatis restart saat crash adalah ...',
                'options' => [
                    'a' => 'PM2',
                    'b' => 'Nodemon dev',
                    'c' => 'Task Manager',
                    'd' => 'Cron Shell',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Library Object Data Modeling (ODM) yang digunakan di Node.js untuk menghubungkan aplikasi dengan database NoSQL MongoDB secara terstruktur adalah ...',
                'options' => [
                    'a' => 'Mongoose',
                    'b' => 'Prisma',
                    'c' => 'Sequelize',
                    'd' => 'Knex',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= PYTHON UNTUK JARINGAN & AUTOMATION SCRIPTING =================
    private static function pythonAutomationUts(): array
    {
        return [
            [
                'question' => 'Pustaka (library) Python yang sangat populer digunakan oleh engineer jaringan untuk mengotomatisasi konfigurasi perangkat router dan switch multi-vendor melalui koneksi SSH adalah ...',
                'options' => [
                    'a' => 'Netmiko / Paramiko',
                    'b' => 'TensorFlow',
                    'c' => 'Matplotlib',
                    'd' => 'PyGame',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Karakter penanda baris pertama pada skrip shell Bash di Linux yang memberi tahu sistem operasi jenis interpreter yang digunakan dinamakan baris ...',
                'options' => [
                    'a' => 'Shebang (#!/bin/bash)',
                    'b' => 'Comment tag (#)',
                    'c' => 'Macro directive',
                    'd' => 'Header import',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Struktur perulangan dasar pada skrip Bash shell untuk memproses daftar alamat IP target dari sebuah file adalah ...',
                'options' => [
                    'a' => 'for IP in $(cat list.txt); do ... done',
                    'b' => 'loop until end ... finish',
                    'c' => 'repeat while IP ... stop',
                    'd' => 'iterate list.txt ... next',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Layanan penjadwalan tugas otomatis berkala di sistem operasi Linux yang menggunakan format lima bintang waktu (menit, jam, hari, bulan, hari-minggu) dinamakan ...',
                'options' => [
                    'a' => 'Cron Daemon (crontab)',
                    'b' => 'Task Scheduler Windows',
                    'c' => 'Systemd Timer Only',
                    'd' => 'Sleep loop command',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pustaka standar bawaan Python yang digunakan untuk menangani komunikasi socket jaringan tingkat rendah (seperti cek port terbuka TCP/UDP) adalah modul ...',
                'options' => [
                    'a' => 'socket',
                    'b' => 'math',
                    'c' => 'random',
                    'd' => 'datetime',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function pythonAutomationUas(): array
    {
        return [
            [
                'question' => 'Perintah Linux yang paling sering digunakan dalam skrip otomatisasi pencadangan untuk menyalin dan menyinkronkan file ke server jarak jauh secara efisien adalah ...',
                'options' => [
                    'a' => 'rsync',
                    'b' => 'ftp manual',
                    'c' => 'cp lokal',
                    'd' => 'wget',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Blok penanganan kesalahan (exception handling) pada bahasa Python yang mencegah skrip otomatisasi berhenti mendadak saat terjadi error koneksi ke perangkat offline adalah ...',
                'options' => [
                    'a' => 'try ... except',
                    'b' => 'if ... else',
                    'c' => 'do ... catch',
                    'd' => 'switch ... case',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pustaka Python yang digunakan untuk melakukan permintaan HTTP request (seperti GET, POST) ke REST API perangkat jaringan dinamakan ...',
                'options' => [
                    'a' => 'requests',
                    'b' => 'urllib_old',
                    'c' => 'flask',
                    'd' => 'pandas',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Format file pertukaran data yang sering digunakan dalam otomatisasi jaringan karena strukturnya yang berbasis indentasi bersih dan mudah dibaca manusia adalah ...',
                'options' => [
                    'a' => 'YAML (.yml / .yaml)',
                    'b' => 'Binary file',
                    'c' => 'HTML tag',
                    'd' => 'PostScript',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Alat otomatisasi orkestrasi konfigurasi server dan jaringan tanpa agen (agentless) yang menggunakan modul Python dan playbook YAML adalah ...',
                'options' => [
                    'a' => 'Ansible',
                    'b' => 'Puppet Agent',
                    'c' => 'Chef Solo',
                    'd' => 'SaltStack Minion',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= DATA ANALYTICS, ML & AI =================
    private static function dataAiMlUts(): array
    {
        return [
            [
                'question' => 'Dua paradigma utama dalam pembelajaran mesin (Machine Learning): pembelajaran dengan data yang memiliki target label yang jelas dinamakan ..., sedangkan data tanpa label dinamakan ...',
                'options' => [
                    'a' => 'Supervised Learning / Unsupervised Learning',
                    'b' => 'Manual Coding / Deep Learning',
                    'c' => 'Deterministic / Probabilistic',
                    'd' => 'Regression Only / Binary Only',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pustaka Python yang paling fundamental dan standar digunakan untuk manipulasi dan analisis struktur data tabular (DataFrame) adalah ...',
                'options' => [
                    'a' => 'Pandas',
                    'b' => 'PyGame',
                    'c' => 'Tkinter',
                    'd' => 'Flask',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pustaka Python yang menyediakan fungsi komputasi numerik array multidimensi berkecepatan tinggi adalah ...',
                'options' => [
                    'a' => 'NumPy',
                    'b' => 'Requests',
                    'c' => 'BeautifulSoup',
                    'd' => 'Seaborn',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Tahapan penting dalam analisis data yang berfokus menangani data yang hilang (missing values), menghapus duplikasi, dan memperbaiki inkonsistensi format data dinamakan ...',
                'options' => [
                    'a' => 'Data Cleaning (Pembersihan Data)',
                    'b' => 'Data Mining Ekstrem',
                    'c' => 'Model Prediction',
                    'd' => 'Deep Training',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Jenis algoritma pembelajaran mesin yang digunakan untuk memprediksi nilai kuantitatif kontinu (misal memprediksi harga sewa atau konsumsi listrik) dinamakan ...',
                'options' => [
                    'a' => 'Regresi (Regression)',
                    'b' => 'Klasifikasi (Classification)',
                    'c' => 'Klastering (Clustering)',
                    'd' => 'Asosiasi (Association)',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function dataAiMlUas(): array
    {
        return [
            [
                'question' => 'Kondisi kegagalan model Machine Learning di mana model menghafal data latih secara berlebihan sehingga akurasinya sangat tinggi di data latih namun gagal di data baru dinamakan ...',
                'options' => [
                    'a' => 'Overfitting',
                    'b' => 'Underfitting',
                    'c' => 'Good Fit',
                    'd' => 'Data Leakage',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pembagian kumpulan dataset (dataset split) standar sebelum melatih model machine learning dibagi menjadi dua kelompok yaitu ...',
                'options' => [
                    'a' => 'Data Latih (Training Data) dan Data Uji (Testing Data)',
                    'b' => 'Data Publik dan Data Rahasia',
                    'c' => 'Data Online dan Data Offline',
                    'd' => 'Data Primer dan Data Tersier',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Metrik evaluasi pada model klasifikasi yang mengukur perbandingan antara prediksi positif yang benar terhadap total seluruh data yang diprediksi positif dinamakan ...',
                'options' => [
                    'a' => 'Presisi (Precision)',
                    'b' => 'Recall',
                    'c' => 'Akurasi global',
                    'd' => 'Mean Squared Error',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Model kecerdasan buatan berbasis jaringan syaraf tiruan mendalam yang dirancang untuk memahami, menganalisis, dan menghasilkan bahasa alami manusia dinamakan ...',
                'options' => [
                    'a' => 'Large Language Model (LLM)',
                    'b' => 'Decision Tree Parser',
                    'c' => 'Linear Discriminant',
                    'd' => 'Genetic Algorithm',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pustaka Python populer yang menyediakan berbagai implementasi algoritma machine learning siap pakai (seperti KNN, Random Forest, SVM) adalah ...',
                'options' => [
                    'a' => 'Scikit-Learn',
                    'b' => 'Django',
                    'c' => 'Bootstrap',
                    'd' => 'Tailwind',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= GAME DEVELOPMENT =================
    private static function gameDevUts(): array
    {
        return [
            [
                'question' => 'Perangkat lunak terpadu yang menyediakan lingkungan kerja, mesin render grafis, mesin fisika, dan editor untuk membuat video game dinamakan ...',
                'options' => [
                    'a' => 'Game Engine (misal Unity, Godot, Unreal Engine)',
                    'b' => 'Video Converter',
                    'c' => 'Media Player',
                    'd' => 'Screen Recorder',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Siklus inti yang terus berulang tanpa henti setiap frame dalam pemrograman game untuk menangani input, memperbarui logika fisika, dan menggambar ke layar dinamakan ...',
                'options' => [
                    'a' => 'Game Loop (Input -> Update -> Render)',
                    'b' => 'Life Cycle Loop',
                    'c' => 'Event Dispatcher',
                    'd' => 'Frame Freeze',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen mesin fisika pada game engine yang bertugas mendeteksi tabrakan batas fisik antarentitas objek dalam dunia game dinamakan ...',
                'options' => [
                    'a' => 'Collider (misal BoxCollider, CircleCollider)',
                    'b' => 'AudioSource',
                    'c' => 'Camera Viewport',
                    'd' => 'Mesh Renderer',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Komponen pada game engine Unity yang memberikan sifat fisik nyata kepada objek (seperti gravitasi, massa, dan gaya dorong) adalah ...',
                'options' => [
                    'a' => 'Rigidbody (atau Rigidbody2D)',
                    'b' => 'Transform biasa',
                    'c' => 'Sprite Renderer',
                    'd' => 'Canvas UI',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Bahasa pemrograman utama yang digunakan untuk menulis skrip logika permainan pada game engine Unity adalah ...',
                'options' => [
                    'a' => 'C# (C-Sharp)',
                    'b' => 'PHP',
                    'c' => 'HTML',
                    'd' => 'SQL',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function gameDevUas(): array
    {
        return [
            [
                'question' => 'Gambar bitmap 2D yang digunakan sebagai representasi grafis visual karakter atau objek dalam pembuatan game 2D dinamakan ...',
                'options' => [
                    'a' => 'Sprite',
                    'b' => 'Polygon Mesh',
                    'c' => 'Texture Shader',
                    'd' => 'Voxel Matrix',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Struktur perancangan logika karakter game yang mengatur transisi status aksi (seperti status Diam/Idle, Berjalan/Walk, Melompat/Jump, dan Menyerang/Attack) dinamakan ...',
                'options' => [
                    'a' => 'Finite State Machine (FSM)',
                    'b' => 'Data Binding',
                    'c' => 'Relational Schema',
                    'd' => 'Buffer Queue',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Teknik optimasi grafis game 3D di mana model objek dibuat dengan detail geometri poligon yang lebih rendah saat objek berada jauh dari kamera dinamakan ...',
                'options' => [
                    'a' => 'Level of Detail (LOD)',
                    'b' => 'Ray Tracing Refraction',
                    'c' => 'Anti-Aliasing Maksimal',
                    'd' => 'Motion Blur',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Standar satuan frekuensi pembaruan frame gambar ke layar monitor setiap detik dalam video game diukur dalam satuan ...',
                'options' => [
                    'a' => 'FPS (Frames Per Second)',
                    'b' => 'DPI',
                    'c' => 'Baud Rate',
                    'd' => 'Kbps',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Proses akhir mengkompilasi seluruh aset grafis, audio, dan skrip game menjadi file aplikasi mandiri yang siap dimainkan oleh pengguna dinamakan proses ...',
                'options' => [
                    'a' => 'Build / Export Game',
                    'b' => 'Import Asset',
                    'c' => 'Wireframing',
                    'd' => 'Texture Baking',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= BLOCKCHAIN BASICS =================
    private static function blockchainUts(): array
    {
        return [
            [
                'question' => 'Pengertian mendasar dari teknologi Blockchain adalah ...',
                'options' => [
                    'a' => 'Buku besar digital terdistribusi (Distributed Ledger) yang mencatat transaksi secara transparan, terdesentralisasi, dan bersifat kekal tidak dapat diubah (immutable)',
                    'b' => 'Program spreadsheet database terpusat di kantor pusat',
                    'c' => 'Aplikasi pemutar video internet',
                    'd' => 'Kabel jaringan bawah laut berkecepatan tinggi',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Setiap blok dalam rantai blockchain terhubung secara kriptografis ke blok sebelumnya melalui penyertaan ...',
                'options' => [
                    'a' => 'Hash dari blok sebelumnya (Previous Block Hash)',
                    'b' => 'Nomor KTP penambang',
                    'c' => 'Alamat IP server pusat',
                    'd' => 'Nama pengguna admin',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Fungsi hash kriptografis satu arah standar yang sangat terkenal dan digunakan pada jaringan blockchain Bitcoin adalah ...',
                'options' => [
                    'a' => 'SHA-256',
                    'b' => 'MD5',
                    'c' => 'Base64',
                    'd' => 'Caesar Shift',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Karakteristik penting blockchain yang memastikan data transaksi yang telah diverifikasi dan masuk ke dalam blok tidak dapat diedit atau dihapus kembali dinamakan sifat ...',
                'options' => [
                    'a' => 'Immutability (Kekal / Tidak Dapat Diubah)',
                    'b' => 'Flexibility',
                    'c' => 'Reversibility',
                    'd' => 'Centralization',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Struktur jaringan komputer di mana setiap komputer (node) memiliki kedudukan setara dan saling berkomunikasi langsung tanpa bergantung pada satu server pusat dinamakan jaringan ...',
                'options' => [
                    'a' => 'Peer-to-Peer (P2P)',
                    'b' => 'Client-Server terpusat',
                    'c' => 'Mainframe Terminal',
                    'd' => 'Master-Slave Hierarki',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function blockchainUas(): array
    {
        return [
            [
                'question' => 'Program komputer otomatis yang berjalan sendiri di atas jaringan blockchain dan mengeksekusi kesepakatan secara otomatis saat syarat kondisi terpenuhi dinamakan ...',
                'options' => [
                    'a' => 'Smart Contract',
                    'b' => 'Stored Procedure SQL',
                    'c' => 'Bat Script Shell',
                    'd' => 'Cron Job Runner',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Mekanisme konsensus blockchain di mana para validator menyetujui validitas transaksi berdasarkan jumlah koin kripto yang mereka jaminkan (staking) dinamakan ...',
                'options' => [
                    'a' => 'Proof of Stake (PoS)',
                    'b' => 'Proof of Work (PoW)',
                    'c' => 'Proof of Authority',
                    'd' => 'Round Robin Consensus',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Kunci kriptografis rahasia pada dompet blockchain (Crypto Wallet) yang wajib dijaga kerahasiaannya dan digunakan untuk menandatangani otorisasi pengiriman transaksi adalah ...',
                'options' => [
                    'a' => 'Private Key',
                    'b' => 'Public Key',
                    'c' => 'Wallet Address publik',
                    'd' => 'Username akun',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Pemanfaatan nyata teknologi blockchain di luar mata uang kripto dalam dunia industri modern misalnya untuk ...',
                'options' => [
                    'a' => 'Pelacakan transparansi rantai pasok (Supply Chain) dan verifikasi keaslian ijazah/sertifikat digital',
                    'b' => 'Mempercepat kecepatan kipas pendingin laptop',
                    'c' => 'Menggantikan monitor komputer',
                    'd' => 'Menghapus kebutuhan kabel LAN',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perbedaan antara Blockchain Publik (Permissionless) dan Blockchain Privat (Permissioned) adalah ...',
                'options' => [
                    'a' => 'Blockchain publik dapat diikuti dan dibaca oleh siapa saja di internet, sedangkan blockchain privat hanya dapat diakses oleh pihak yang mendapatkan otorisasi',
                    'b' => 'Blockchain publik tidak menggunakan kriptografi',
                    'c' => 'Blockchain privat tidak memiliki blok transaksi',
                    'd' => 'Blockchain publik dijalankan oleh satu perusahaan saja',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    // ================= PENGELOLAAN INFRASTRUKTUR IT =================
    private static function infrastrukturItUts(): array
    {
        return [
            [
                'question' => 'Perangkat cadangan catu daya darurat yang berfungsi melindungi perangkat server dari lonjakan arus dan menyuplai listrik sementara saat daya PLN padam adalah ...',
                'options' => [
                    'a' => 'UPS (Uninterruptible Power Supply)',
                    'b' => 'Genset tanpa baterai',
                    'c' => 'Inverter mobil mini',
                    'd' => 'Stabilizer analog meja',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Desain tata letak penataan rak server di Data Center yang mengatur aliran udara dingin masuk ke bagian depan server dan udara panas dibuang ke bagian belakang dinamakan konsep ...',
                'options' => [
                    'a' => 'Hot Aisle / Cold Aisle Containment',
                    'b' => 'Open Space Airflow',
                    'c' => 'Random Ventilation',
                    'd' => 'Crossdraft Windows',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sistem pemadam kebakaran otomatis yang wajib digunakan di ruang server/data center untuk memadamkan api tanpa menggunakan air yang merusak komponen elektronik adalah sistem gas bersih ...',
                'options' => [
                    'a' => 'Clean Agent Fire Suppression (misal FM-200 / Novec 1230)',
                    'b' => 'Water Sprinkler pipa air',
                    'c' => 'Busa sabun cair (foam)',
                    'd' => 'Pasir basah',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Panel terminal kabel yang terpasang di rak server untuk merapikan koneksi kabel UTP dari stopkontak dinding ke switch jaringan dinamakan ...',
                'options' => [
                    'a' => 'Patch Panel',
                    'b' => 'Kabel Ties',
                    'c' => 'Power Strip PDU',
                    'd' => 'Blanking Panel',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Sistem lantai panggung berongga pada Data Center yang digunakan untuk menyalurkan aliran udara dingin dan menyembunyikan instalasi kabel bawah tanah dinamakan ...',
                'options' => [
                    'a' => 'Raised Floor',
                    'b' => 'Lantai keramik biasa',
                    'c' => 'Karpet wol tebal',
                    'd' => 'Plester semen kasar',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }

    private static function infrastrukturItUas(): array
    {
        return [
            [
                'question' => 'Protokol standar lapisan aplikasi yang digunakan oleh software pemantau jaringan (Network Monitoring System) untuk memonitor beban trafik perangkat router, switch, dan server adalah ...',
                'options' => [
                    'a' => 'SNMP (Simple Network Management Protocol)',
                    'b' => 'SMTP Mail Protocol',
                    'c' => 'FTP Transfer Protocol',
                    'd' => 'HTTP Web Protocol',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perangkat lunak open-source populer yang digunakan di industri TI untuk memantau ketersediaan (uptime) server, latensi jaringan, dan memicu peringatan otomatis saat terjadi masalah adalah ...',
                'options' => [
                    'a' => 'Zabbix / PRTG Network Monitor',
                    'b' => 'Microsoft Word',
                    'c' => 'WinRAR',
                    'd' => 'Adobe Illustrator',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Perjanjian formal antara penyedia layanan TI dan pelanggan yang mendefinisikan standar tingkat jaminan ketersediaan layanan (misal jaminan 99,9% uptime) dinamakan ...',
                'options' => [
                    'a' => 'SLA (Service Level Agreement)',
                    'b' => 'NDA (Non-Disclosure Agreement)',
                    'c' => 'MOU Kesepakatan Awal',
                    'd' => 'Surat Perintah Kerja',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Dokumen rencana komprehensif yang memuat prosedur pemulihan infrastruktur TI dan data penting saat terjadi insiden bencana besar (kebakaran, gempa, kebanjiran) dinamakan ...',
                'options' => [
                    'a' => 'Disaster Recovery Plan (DRP)',
                    'b' => 'Sales Marketing Plan',
                    'c' => 'Inventory Shopping List',
                    'd' => 'Sprint Retrospective',
                ],
                'correct_answer' => 'a',
            ],
            [
                'question' => 'Konfigurasi dua sumber jalur koneksi internet berbeda dari dua provider ISP yang bekerja bergantian otomatis jika jalur utama mengalami putus dinamakan ...',
                'options' => [
                    'a' => 'Dual ISP Failover',
                    'b' => 'Single Point of Failure',
                    'c' => 'Single Homing',
                    'd' => 'Bridging Loop',
                ],
                'correct_answer' => 'a',
            ],
        ];
    }
}

