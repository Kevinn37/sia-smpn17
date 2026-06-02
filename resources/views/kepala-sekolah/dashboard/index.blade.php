{{-- FILE: resources/views/kepala-sekolah/dashboard/index.blade.php --}}
{{-- Dashboard kepala sekolah --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('kepala-sekolah.dashboard') }}" class="aktif">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Monitoring</span>
    <a href="{{ route('kepala-sekolah.monitoring.presensi') }}">
        <i data-lucide="clipboard-list"></i> Presensi
    </a>
    <a href="{{ route('kepala-sekolah.monitoring.nilai') }}">
        <i data-lucide="book-open"></i> Nilai
    </a>
    <a href="{{ route('kepala-sekolah.monitoring.guru') }}">
        <i data-lucide="user-tie"></i> Guru
    </a>
    <a href="{{ route('kepala-sekolah.monitoring.siswa') }}">
        <i data-lucide="users"></i> Siswa
    </a>
    <span class="sidebar-nav-label">Laporan</span>
    <a href="{{ route('kepala-sekolah.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/kepsek-dashboard.css') }}">
@endpush

@section('konten')

    {{-- Sambutan --}}
    <div class="kepsek-sambutan" data-aos="fade-right">
        <div>
            <h2>Selamat datang, {{ session('nama') }}!</h2>
            <p>{{ now()->translatedFormat('l, d F Y') }} — Monitoring Akademik SMPN 17 Makassar</p>
        </div>
        <div class="kepsek-sambutan-badge">
            <i data-lucide="shield-check"></i>
            Kepala Sekolah
        </div>
    </div>

    {{-- Statistik utama --}}
    <div class="stat-grid">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
            <div class="stat-card-icon kuning">
                <i data-lucide="users"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalSiswa }}</span>
                <span class="stat-card-label">Total Siswa</span>
            </div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card-icon biru">
                <i data-lucide="user-tie"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalGuru }}</span>
                <span class="stat-card-label">Total Guru</span>
            </div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card-icon fuchsia">
                <i data-lucide="door-open"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalKelas }}</span>
                <span class="stat-card-label">Total Kelas</span>
            </div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card-icon hijau">
                <i data-lucide="megaphone"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $jumlahPengumuman }}</span>
                <span class="stat-card-label">Pengumuman Aktif</span>
            </div>
        </div>
    </div>

    <div class="kepsek-grid-2">

        {{-- Rekap presensi hari ini --}}
        <div class="neo-card" data-aos="fade-up">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="clipboard-list"></i>
                    Presensi Hari Ini
                </h3>
                <a href="{{ route('kepala-sekolah.monitoring.presensi') }}" class="neo-btn neo-btn-biru neo-btn-sm">
                    Detail
                </a>
            </div>
            <div class="kepsek-rekap-grid">
                <div class="kepsek-rekap-item kepsek-rekap-hadir">
                    <span class="kepsek-rekap-angka">{{ $rekapPresensiHariIni['hadir'] ?? 0 }}</span>
                    <span class="kepsek-rekap-label">Hadir</span>
                </div>
                <div class="kepsek-rekap-item kepsek-rekap-izin">
                    <span class="kepsek-rekap-angka">{{ $rekapPresensiHariIni['izin'] ?? 0 }}</span>
                    <span class="kepsek-rekap-label">Izin</span>
                </div>
                <div class="kepsek-rekap-item kepsek-rekap-sakit">
                    <span class="kepsek-rekap-angka">{{ $rekapPresensiHariIni['sakit'] ?? 0 }}</span>
                    <span class="kepsek-rekap-label">Sakit</span>
                </div>
                <div class="kepsek-rekap-item kepsek-rekap-alfa">
                    <span class="kepsek-rekap-angka">{{ $rekapPresensiHariIni['alfa'] ?? 0 }}</span>
                    <span class="kepsek-rekap-label">Alfa</span>
                </div>
            </div>
        </div>

        {{-- Kegiatan mendatang --}}
        <div class="neo-card" data-aos="fade-up">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="calendar"></i>
                    Kegiatan Mendatang
                </h3>
            </div>
            @if ($daftarKegiatan->count() > 0)
                <div class="kepsek-kegiatan-list">
                    @foreach ($daftarKegiatan as $kegiatan)
                        <div class="kepsek-kegiatan-item">
                            <div class="kepsek-kegiatan-tgl">
                                <span>{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d') }}</span>
                                <span>{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->translatedFormat('M') }}</span>
                            </div>
                            <div class="kepsek-kegiatan-info">
                                <span class="kepsek-kegiatan-judul">{{ $kegiatan->judul }}</span>
                                <span class="neo-badge kalender-badge-{{ $kegiatan->jenis }}">
                                    {{ ucfirst(str_replace('_', ' ', $kegiatan->jenis)) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="neo-empty">
                    <i data-lucide="inbox"></i>
                    <p>Tidak ada kegiatan mendatang.</p>
                </div>
            @endif
        </div>

    </div>

    <div class="kepsek-grid-2">

        {{-- Presensi per kelas bulan ini --}}
        <div class="neo-card" data-aos="fade-up">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="bar-chart-2"></i>
                    Presensi per Kelas Bulan Ini
                </h3>
            </div>
            @if ($presensiPerKelas->count() > 0)
                <div class="kepsek-bar-list">
                    @php $maxPresensi = $presensiPerKelas->max('total'); @endphp
                    @foreach ($presensiPerKelas as $item)
                        <div class="kepsek-bar-item">
                            <span class="kepsek-bar-label">{{ $item->nama_kelas }}</span>
                            <div class="kepsek-bar-track">
                                <div class="kepsek-bar-fill kepsek-bar-biru"
                                    style="width: {{ $maxPresensi > 0 ? ($item->total / $maxPresensi) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="kepsek-bar-angka">{{ $item->total }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="neo-empty">
                    <i data-lucide="inbox"></i>
                    <p>Belum ada data presensi bulan ini.</p>
                </div>
            @endif
        </div>

        {{-- Rata-rata nilai per kelas --}}
        <div class="neo-card" data-aos="fade-up">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="trending-up"></i>
                    Rata-rata Nilai per Kelas
                </h3>
            </div>
            @if ($nilaiPerKelas->count() > 0)
                <div class="kepsek-bar-list">
                    @php $maxNilai = $nilaiPerKelas->max('rata_rata'); @endphp
                    @foreach ($nilaiPerKelas as $item)
                        <div class="kepsek-bar-item">
                            <span class="kepsek-bar-label">{{ $item->nama_kelas }}</span>
                            <div class="kepsek-bar-track">
                                <div class="kepsek-bar-fill {{ $item->rata_rata >= 80 ? 'kepsek-bar-hijau' : ($item->rata_rata >= 70 ? 'kepsek-bar-kuning' : 'kepsek-bar-merah') }}"
                                    style="width: {{ $maxNilai > 0 ? ($item->rata_rata / $maxNilai) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="kepsek-bar-angka">{{ $item->rata_rata }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="neo-empty">
                    <i data-lucide="inbox"></i>
                    <p>Belum ada data nilai.</p>
                </div>
            @endif
        </div>

    </div>

@endsection
