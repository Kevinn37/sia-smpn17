{{-- FILE: resources/views/guru/dashboard/index.blade.php --}}
{{-- Dashboard utama guru --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('guru.dashboard') }}" class="aktif">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('guru.presensi.index') }}">
        <i data-lucide="clipboard-list"></i> Presensi
    </a>
    <a href="{{ route('guru.nilai.index') }}">
        <i data-lucide="book-open"></i> Nilai Siswa
    </a>
    <a href="{{ route('guru.jadwal') }}">
        <i data-lucide="calendar-days"></i> Jadwal Mengajar
    </a>
    <span class="sidebar-nav-label">Akun</span>
    <a href="{{ route('guru.profil') }}">
        <i data-lucide="user"></i> Profil Saya
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/guru-dashboard.css') }}">
@endpush

@section('konten')

    {{-- Sambutan --}}
    <div class="guru-sambutan" data-aos="fade-right">
        <div class="guru-sambutan-teks">
            <h2>Selamat datang, {{ $guru->nama }}!</h2>
            <p>{{ now()->translatedFormat('l, d F Y') }} — Timezone WITA</p>
        </div>
        @if ($sesiAktif)
            <div class="guru-sesi-aktif-badge">
                <i data-lucide="radio"></i>
                Ada sesi QR aktif sekarang
            </div>
        @endif
    </div>

    {{-- Statistik --}}
    <div class="stat-grid">

        <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
            <div class="stat-card-icon kuning">
                <i data-lucide="door-open"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalKelas }}</span>
                <span class="stat-card-label">Kelas Diajar</span>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card-icon biru">
                <i data-lucide="users"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalSiswa }}</span>
                <span class="stat-card-label">Total Siswa</span>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card-icon hijau">
                <i data-lucide="clipboard-check"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $presensiHariIni }}</span>
                <span class="stat-card-label">Presensi Hari Ini</span>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card-icon fuchsia">
                <i data-lucide="calendar-days"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $jadwalHariIni->count() }}</span>
                <span class="stat-card-label">Jadwal Hari Ini</span>
            </div>
        </div>

    </div>

    {{-- Jadwal hari ini --}}
    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="calendar-days"></i>
                Jadwal Mengajar Hari Ini
            </h3>
            <span class="neo-badge neo-badge-biru">
                {{ now()->translatedFormat('l') }}
            </span>
        </div>

        @if ($jadwalHariIni->count() > 0)
            <div class="guru-jadwal-list">
                @foreach ($jadwalHariIni as $jadwal)
                    @php
                        // Cek apakah sesi presensi sudah dibuka untuk jadwal ini
                        $sudahBukaSesi = DB::table('sesi_presensi')
                            ->where('id_jadwal', $jadwal->id_jadwal)
                            ->whereDate('tanggal', today())
                            ->exists();
                    @endphp

                    <div class="guru-jadwal-item">
                        <div class="guru-jadwal-jam">
                            <span>{{ substr($jadwal->jam_mulai, 0, 5) }}</span>
                            <span class="guru-jadwal-jam-sep">—</span>
                            <span>{{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                        </div>
                        <div class="guru-jadwal-info">
                            <span class="guru-jadwal-mapel">{{ $jadwal->nama_mapel }}</span>
                            <span class="guru-jadwal-kelas">
                                <i data-lucide="door-open"></i>
                                Kelas {{ $jadwal->nama_kelas }}
                            </span>
                        </div>
                        <div class="guru-jadwal-aksi">
                            @if ($sudahBukaSesi)
                                <span class="neo-badge neo-badge-hadir">
                                    <i data-lucide="check"></i>
                                    Sesi Dibuka
                                </span>
                            @else
                                <a href="{{ route('guru.presensi.index', ['id_jadwal' => $jadwal->id_jadwal]) }}"
                                    class="neo-btn neo-btn-kuning neo-btn-sm">
                                    <i data-lucide="qr-code"></i>
                                    Mulai Presensi
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="coffee"></i>
                <p>Tidak ada jadwal mengajar hari ini.</p>
            </div>
        @endif

    </div>

@endsection

@push('js')
    <script src="{{ asset('js/guru-dashboard.js') }}"></script>
@endpush
