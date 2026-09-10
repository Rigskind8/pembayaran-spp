@php
    $role = Auth::user()->role;
    $normalizedRole = str_replace(' ', '_', strtolower((string) $role));
    $isAdminSchoolRole = $normalizedRole === 'admin';
    $isKepsekRole = $normalizedRole === 'kepala_sekolah';
    $isGuruRole = in_array($normalizedRole, ['guru', 'teacher'], true);
    $roleNames = [
        'admin' => __('ui.roles.admin'),
        'guru' => __('ui.roles.guru'),
        'siswa' => __('ui.roles.siswa'),
        'kepala_sekolah' => __('ui.roles.kepala_sekolah'),
    ];
    $roleLabel = $roleNames[$role] ?? ucfirst($role);
    $currentRoute = request()->route()?->getName() ?: '';

@endphp


<aside class="sb" style="width:var(--sw);max-width:var(--sw-open);min-width:var(--sw);background:#e5e7eb !important;">
    <div class="sb-brand">
        <div class="sb-mark"><i class="fas fa-graduation-cap"></i></div>
        <span class="sb-name sb-name-text">SMK Travina Prima</span>
    </div>


    <nav class="sb-nav">
        <span class="sb-grp">MENU</span>

        @if($role === 'siswa')
            <a href="{{ route('dashboard') }}" class="sb-a {{ request()->routeIs('dashboard') ? 'on' : '' }}">
                <div class="ic"><i class="fas fa-house"></i></div>
                <span class="sb-lbl">Beranda</span>
            </a>
            @if(Route::has('schedule.index'))
                <a href="{{ route('schedule.index') }}" class="sb-a {{ request()->routeIs('schedule.index') || request()->is('jadwal*') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-book-open"></i></div>
                    <span class="sb-lbl">Jadwal Pelajaran</span>
                </a>
            @else
                <a href="{{ url('jadwal') }}" class="sb-a {{ request()->is('jadwal*') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-book-open"></i></div>
                    <span class="sb-lbl">Jadwal Pelajaran</span>
                </a>
            @endif
            @if(Route::has('student.attendance.today'))
                <a href="{{ route('student.attendance.today') }}" class="sb-a {{ request()->routeIs('student.attendance.today') || request()->is('absensi-siswa*') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-user-check"></i></div>
                    <span class="sb-lbl">Absen Hari Ini</span>
                </a>
            @endif
            @if(Route::has('attendance.history'))
                <a href="{{ route('attendance.history') }}" class="sb-a {{ request()->routeIs('attendance.history') || request()->is('riwayat-absensi-siswa*') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-calendar-check"></i></div>
                    <span class="sb-lbl">Riwayat Absensi</span>
                </a>
            @endif
            @if(Route::has('nilai.student'))
                <a href="{{ route('nilai.student') }}" class="sb-a {{ request()->routeIs('nilai.student') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-star"></i></div>
                    <span class="sb-lbl">Nilai Saya</span>
                </a>
            @endif
            @if(Route::has('ujian.uts'))
                <a href="{{ route('ujian.uts') }}" class="sb-a {{ request()->routeIs('ujian.uts') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-file-pen"></i></div>
                    <span class="sb-lbl">UTS</span>
                </a>
            @endif
            @if(Route::has('ujian.uas'))
                <a href="{{ route('ujian.uas') }}" class="sb-a {{ request()->routeIs('ujian.uas') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-graduation-cap"></i></div>
                    <span class="sb-lbl">UAS</span>
                </a>
            @endif
            @if(Route::has('ujian.jadwal'))
                <a href="{{ route('ujian.jadwal') }}" class="sb-a {{ request()->routeIs('ujian.jadwal') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-calendar-alt"></i></div>
                    <span class="sb-lbl">Jadwal Ulangan</span>
                </a>
            @endif
            @if(Route::has('siswa.pembayaran'))
                <a href="{{ route('siswa.pembayaran') }}" class="sb-a {{ request()->routeIs('siswa.pembayaran') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-wallet"></i></div>
                    <span class="sb-lbl">Pembayaran SPP</span>
                </a>
            @endif
            @if(Route::has('admin.wa'))
                <a href="{{ route('admin.wa') }}" class="sb-a {{ request()->routeIs('admin.wa') ? 'on' : '' }}">
                    <div class="ic"><i class="fab fa-whatsapp"></i></div>
                    <span class="sb-lbl">Chat Admin</span>
                </a>
            @endif
        @else
            @if(Route::has('dashboard'))
                <a href="{{ route('dashboard') }}" class="sb-a {{ request()->routeIs('dashboard') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-house"></i></div>
                    <span class="sb-lbl">Beranda</span>
                </a>
            @endif
            @if($isKepsekRole && Route::has('kepala-sekolah.pengumuman.index'))
                <a href="{{ route('kepala-sekolah.pengumuman.index') }}" class="sb-a {{ request()->routeIs('kepala-sekolah.pengumuman.*') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-bullhorn"></i></div>
                    <span class="sb-lbl">Buat Pengumuman</span>
                </a>
            @endif
            @if(Route::has('admin.wa'))
                <a href="{{ route('admin.wa') }}" class="sb-a {{ request()->routeIs('admin.wa') ? 'on' : '' }}">
                    <div class="ic"><i class="fab fa-whatsapp"></i></div>
                    <span class="sb-lbl">Chat Admin</span>
                </a>
            @endif
            @if($isKepsekRole && (Route::has('admin.payments') || Route::has('payments.report')))
                <span class="sb-grp">Keuangan</span>
                @if(Route::has('admin.payments'))
                    <a href="{{ route('admin.payments') }}" class="sb-a {{ request()->routeIs('admin.payments') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-file-invoice-dollar"></i></div>
                        <span class="sb-lbl">Pembayaran SPP</span>
                    </a>
                @endif
                @if(Route::has('payments.report'))
                    <a href="{{ route('payments.report') }}" class="sb-a {{ request()->routeIs('payments.report') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-chart-bar"></i></div>
                        <span class="sb-lbl">Laporan SPP</span>
                    </a>
                @endif
            @endif
            @if($isAdminSchoolRole && Route::has('admin.about.edit'))
                <a href="{{ route('admin.about.edit') }}" class="sb-a {{ request()->routeIs('admin.about.*') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-image"></i></div>
                    <span class="sb-lbl">Kelola Tentang Landing</span>
                </a>
            @endif

            @if($isGuruRole && Route::has('teacher.schedule'))
                <a href="{{ route('teacher.schedule') }}" class="sb-a {{ request()->routeIs('teacher.schedule') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-calendar-days"></i></div>
                    <span class="sb-lbl">Jadwal Mengajar</span>
                </a>
            @endif
            @if($isGuruRole && Route::has('teacher.attendance'))
                <a href="{{ route('teacher.attendance') }}" class="sb-a {{ request()->routeIs('teacher.attendance') ? 'on' : '' }}">
                    <div class="ic"><i class="fas fa-user-check"></i></div>
                    <span class="sb-lbl">Absen Mengajar</span>
                </a>
        @endif
        @if($isGuruRole && Route::has('guru.hasil-ujian'))
            <a href="{{ route('guru.hasil-ujian') }}" class="sb-a {{ request()->routeIs('guru.hasil-ujian') ? 'on' : '' }}">
                <div class="ic"><i class="fas fa-poll"></i></div>
                <span class="sb-lbl">{{ __('ui.menu.exam_results_teacher') }}</span>
            </a>
            @endif

            @if($isAdminSchoolRole && (Route::has('students.index') || Route::has('users.index')))
                <span class="sb-grp">Master Data</span>
                @if(Route::has('students.index'))
                    <a href="{{ route('students.index') }}" class="sb-a {{ request()->routeIs('students.*') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-user-graduate"></i></div>
                        <span class="sb-lbl">Data Siswa</span>
                    </a>
                @endif
                @if(Route::has('exam-questions.index'))
                    <a href="{{ route('exam-questions.index') }}" class="sb-a {{ request()->routeIs('exam-questions.*') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-clipboard-question"></i></div>
                        <span class="sb-lbl">Soal Ujian</span>
                    </a>
                @endif
                @if(Route::has('users.index'))
                    <a href="{{ route('users.index') }}" class="sb-a {{ request()->routeIs('users.*') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-users-gear"></i></div>
                        <span class="sb-lbl">Pengguna</span>
                    </a>
                @endif
                @if(Route::has('surat.index'))
                    <a href="{{ route('surat.index') }}" class="sb-a {{ request()->routeIs('surat.*') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-envelope-open-text"></i></div>
                        <span class="sb-lbl">Surat Masuk/Keluar</span>
                    </a>
                @endif
                @if(Route::has('admin.activity-logs'))
                    <a href="{{ route('admin.activity-logs') }}" class="sb-a {{ request()->routeIs('admin.activity-logs') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-receipt"></i></div>
                        <span class="sb-lbl">Activity Log</span>
                    </a>
                @endif
            @endif

            @if($isAdminSchoolRole || $isGuruRole || ($role === 'siswa' && Route::has('nilai.student')))
                <span class="sb-grp">Akademik</span>
                @if($isGuruRole && Route::has('attendance.manage'))
                    <a href="{{ route('attendance.manage') }}" class="sb-a {{ request()->routeIs('attendance.manage') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-calendar-check"></i></div>
                        <span class="sb-lbl">Input Presensi Siswa</span>
                    </a>
                @elseif($isGuruRole && Route::has('absensi.admin'))
                    <a href="{{ route('absensi.admin') }}" class="sb-a {{ request()->routeIs('absensi.admin') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-calendar-check"></i></div>
                        <span class="sb-lbl">Input Presensi</span>
                    </a>
                @endif
                @if(($isAdminSchoolRole || $isGuruRole || $isKepsekRole) && Route::has('attendance.scanQr'))
                    <a href="{{ route('attendance.scanQr') }}" class="sb-a {{ request()->routeIs('attendance.scanQr') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-qrcode"></i></div>
                        <span class="sb-lbl">Scan QR Absensi</span>
                    </a>
                @endif
                @if($isAdminSchoolRole && Route::has('schedule.manage'))
                    <a href="{{ route('schedule.manage') }}" class="sb-a {{ request()->routeIs('schedule.manage') || request()->is('manage-schedule*') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-calendar-days"></i></div>
                        <span class="sb-lbl">Jadwal</span>
                    </a>
                @endif
                @if($isGuruRole && Route::has('manage.ujian'))
                    <a href="{{ route('manage.ujian') }}" class="sb-a {{ request()->routeIs('manage.ujian') || request()->is('manage-ujian*') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-clipboard-check"></i></div>
                        <span class="sb-lbl">Kelola Ujian</span>
                    </a>
                @endif
                @if($isGuruRole && Route::has('exam-results.index'))
                    <a href="{{ route('exam-results.index') }}" class="sb-a {{ request()->routeIs('exam-results.*') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-chart-simple"></i></div>
                        <span class="sb-lbl">Hasil Ujian</span>
                    </a>
                @endif
                @if($isAdminSchoolRole && Route::has('teacher.attendance.monitor'))
                    <a href="{{ route('teacher.attendance.monitor') }}" class="sb-a {{ request()->routeIs('teacher.attendance.monitor') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-chalkboard-user"></i></div>
                        <span class="sb-lbl">Monitor Guru Mengajar</span>
                    </a>
                @endif
                @if(Route::has('nilai.admin') && $isGuruRole)
                    <a href="{{ route('nilai.admin') }}" class="sb-a {{ request()->routeIs('nilai.admin') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-star"></i></div>
                        <span class="sb-lbl">Input Nilai</span>
                    </a>
                @endif

                @if($role === 'siswa' && Route::has('nilai.student'))
                    <a href="{{ route('nilai.student') }}" class="sb-a {{ request()->routeIs('nilai.student') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-star"></i></div>
                        <span class="sb-lbl">{{ __('ui.menu.my_scores') }}</span>
                    </a>
                @endif
            @endif

            @if($isAdminSchoolRole)
                <span class="sb-grp">Keuangan</span>
                @if(Route::has('admin.payments'))
                    <a href="{{ route('admin.payments') }}" class="sb-a {{ request()->routeIs('admin.payments') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-file-invoice-dollar"></i></div>
                        <span class="sb-lbl">Pembayaran SPP</span>
                    </a>
                @endif
                @if(Route::has('payments.report'))
                    <a href="{{ route('payments.report') }}" class="sb-a {{ request()->routeIs('payments.report') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-chart-bar"></i></div>
                        <span class="sb-lbl">Laporan SPP</span>
                    </a>
                @endif
                @if(Route::has('admin.tagihan.create'))
                    <a href="{{ route('admin.tagihan.create') }}" class="sb-a hl {{ request()->routeIs('admin.tagihan.create') ? 'on' : '' }}">
                        <div class="ic"><i class="fas fa-plus"></i></div>
                        <span class="sb-lbl">Buat Tagihan</span>
                    </a>
                @endif
                @if(Route::has('admin.profile.edit'))
                    <a href="{{ route('admin.profile.edit') }}" class="sb-a{{ request()->routeIs('admin.profile.edit') ? ' on' : '' }}">
                        <div class="ic"><i class="fas fa-user-cog"></i></div>
                        <span class="sb-lbl">Edit Profil</span>
                    </a>
                @endif
            @endif
        @endif
        @if($role === 'siswa')
            <a href="{{ route('dashboard', ['settings' => 'profil']) }}" class="sb-a {{ request()->routeIs('dashboard') && request()->query('settings') === 'profil' ? 'on' : '' }}" style="margin-bottom:10px;">
                <div class="ic"><i class="fas fa-gear"></i></div>
                <span class="sb-lbl">Pengaturan Profil</span>
            </a>
        @endif

        <div class="sb-user">
            <div class="sb-av" style="position:relative;width:48px;height:48px;min-width:48px;min-height:48px;max-width:48px;max-height:48px;border-radius:50%;overflow:hidden;background:#fff!important;border:2px solid transparent!important;box-shadow:0 2px 8px rgba(0,0,0,0.04);display:flex;align-items:center;justify-content:center;">
                @php $user = Auth::user(); @endphp
                <img id="sidebar-profile-photo"
                     src="@if($role === 'siswa')
                         @if(!empty($user->avatar_path))
                             {{ asset('storage/' . $user->avatar_path) }}
                         @elseif(!empty($user->photo))
                             {{ asset('storage/' . $user->photo) }}
                         @else
                             https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ededed&color=222
                         @endif
                     @else
                         {{ !empty($user->photo) ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ededed&color=222' }}
                     @endif"
                     alt="Foto Profil {{ $user->name }}"
                     style="width:48px;height:48px;object-fit:cover;display:block;border-radius:50%;aspect-ratio:1/1;border:none;box-shadow:none;background:#ededed;">
            </div>
            <div style="overflow:hidden;white-space:nowrap;" class="sb-lbl">
                <div class="sb-uname" style="color:#1d3a6e;font-weight:800;font-size:16px;text-shadow:0 2px 6px rgba(37,99,235,0.10);">{{ Auth::user()->name }}</div>
                <div class="sb-urole" style="color:#2563eb;font-weight:700;text-shadow:0 1px 2px rgba(0,0,0,.08);">{{ $roleLabel }}</div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sb-out" title="Keluar">
                <div class="ic"><i class="fas fa-power-off"></i></div>
                <span class="sb-lbl">{{ __('ui.menu.logout') }}</span>
            </button>
        </form>
    </nav>
</aside>
