{{-- FILE: resources/views/admin/dashboard/index.blade.php --}}
{{-- Halaman dashboard admin --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('sidebar-menu')

    <span class="sidebar-nav-label">Menu Utama</span>

    <a href="{{ route('admin.dashboard') }}" class="aktif">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>

    <span class="sidebar-nav-label">Data Sekolah</span>

    <a href="{{ route('admin.siswa.index') }}">
        <i data-lucide="users"></i> Data Siswa
    </a>
    <a href="{{ route('admin.guru.index') }}">
        <i data-lucide="graduation-cap"></i> Data Guru
    </a>
    <a href="{{ route('admin.kelas.index') }}">
        <i data-lucide="door-open"></i> Data Kelas
    </a>
    <a href="{{ route('admin.mapel.index') }}">
        <i data-lucide="book"></i> Mata Pelajaran
    </a>

    <span class="sidebar-nav-label">Akademik</span>

    <a href="{{ route('admin.jadwal.index') }}">
        <i data-lucide="calendar-days"></i> Jadwal Pelajaran
    </a>
    <a href="{{ route('admin.kalender.index') }}">
        <i data-lucide="calendar"></i> Kalender Akademik
    </a>
    <a href="{{ route('admin.pengumuman.index') }}">
        <i data-lucide="megaphone"></i> Pengumuman
    </a>

    <span class="sidebar-nav-label">Laporan</span>

    <a href="{{ route('admin.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('konten')

    {{-- Kartu statistik utama --}}
    <div class="stat-grid">

        <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
            <div class="stat-card-icon kuning">
                <i data-lucide="users"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $jumlahSiswa }}</span>
                <span class="stat-card-label">Total Siswa</span>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card-icon biru">
                <i data-lucide="user-tie"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $jumlahGuru }}</span>
                <span class="stat-card-label">Total Guru</span>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card-icon fuchsia">
                <i data-lucide="door-open"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $jumlahKelas }}</span>
                <span class="stat-card-label">Total Kelas</span>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card-icon hijau">
                <i data-lucide="book"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $jumlahMapel }}</span>
                <span class="stat-card-label">Mata Pelajaran</span>
            </div>
        </div>

    </div>

    {{-- Baris kedua — presensi + kegiatan --}}
    <div class="dashboard-grid-2" data-aos="fade-up">

        {{-- Rekap presensi hari ini --}}
        <div class="neo-card">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="clipboard-list"></i>
                    Presensi Hari Ini
                </h3>
                <span class="neo-badge neo-badge-hadir">
                    {{ today()->translatedFormat('l, d F Y') }}
                </span>
            </div>

            @if ($presensiHariIni > 0)
                <div class="presensi-rekap-grid">
                    <div class="presensi-rekap-item presensi-rekap-hadir">
                        <span class="presensi-rekap-angka">{{ $rekapPresensi['hadir'] ?? 0 }}</span>
                        <span class="presensi-rekap-label">Hadir</span>
                    </div>
                    <div class="presensi-rekap-item presensi-rekap-izin">
                        <span class="presensi-rekap-angka">{{ $rekapPresensi['izin'] ?? 0 }}</span>
                        <span class="presensi-rekap-label">Izin</span>
                    </div>
                    <div class="presensi-rekap-item presensi-rekap-sakit">
                        <span class="presensi-rekap-angka">{{ $rekapPresensi['sakit'] ?? 0 }}</span>
                        <span class="presensi-rekap-label">Sakit</span>
                    </div>
                    <div class="presensi-rekap-item presensi-rekap-alfa">
                        <span class="presensi-rekap-angka">{{ $rekapPresensi['alfa'] ?? 0 }}</span>
                        <span class="presensi-rekap-label">Alfa</span>
                    </div>
                </div>
            @else
                <div class="neo-empty">
                    <i data-lucide="inbox"></i>
                    <p>Belum ada data presensi hari ini.</p>
                </div>
            @endif
        </div>

        {{-- Kegiatan yang akan datang --}}
        <div class="neo-card">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="calendar"></i>
                    Kegiatan Mendatang
                </h3>
            </div>

            @if ($daftarKegiatan->count() > 0)
                <ul class="kegiatan-list">
                    @foreach ($daftarKegiatan as $kegiatan)
                        <li class="kegiatan-item">
                            <div class="kegiatan-tanggal">
                                <span>{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d') }}</span>
                                <span>{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->translatedFormat('M') }}</span>
                            </div>
                            <div class="kegiatan-info">
                                <span class="kegiatan-judul">{{ $kegiatan->judul }}</span>
                                <span class="neo-badge kegiatan-badge-{{ $kegiatan->jenis }}">
                                    {{ ucfirst(str_replace('_', ' ', $kegiatan->jenis)) }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="neo-empty">
                    <i data-lucide="inbox"></i>
                    <p>Tidak ada kegiatan mendatang.</p>
                </div>
            @endif
        </div>

    </div>

    {{-- Baris ketiga — siswa baru + pengumuman --}}
    <div class="dashboard-grid-2" data-aos="fade-up">

        {{-- Siswa terbaru --}}
        <div class="neo-card">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="user-plus"></i>
                    Siswa Terbaru
                </h3>
                <a href="{{ route('admin.siswa.index') }}" class="neo-btn neo-btn-kuning neo-btn-sm">
                    Lihat Semua
                </a>
            </div>

            <table class="neo-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarSiswaBaru as $siswa)
                        <tr>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>
                                <span class="neo-badge neo-badge-hadir">
                                    {{ $siswa->nama_kelas }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pengumuman aktif --}}
        <div class="neo-card">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="megaphone"></i>
                    Pengumuman Aktif
                </h3>
                <a href="{{ route('admin.pengumuman.index') }}" class="neo-btn neo-btn-biru neo-btn-sm">
                    Kelola
                </a>
            </div>

            @if ($daftarPengumuman->count() > 0)
                <ul class="pengumuman-list">
                    @foreach ($daftarPengumuman as $pengumuman)
                        <li class="pengumuman-list-item">
                            <div class="pengumuman-list-icon">
                                <i data-lucide="bell"></i>
                            </div>
                            <div class="pengumuman-list-info">
                                <span class="pengumuman-list-judul">{{ $pengumuman->judul }}</span>
                                <span class="pengumuman-list-tanggal">
                                    {{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="neo-empty">
                    <i data-lucide="inbox"></i>
                    <p>Belum ada pengumuman aktif.</p>
                </div>
            @endif
        </div>

    </div>

@endsection

@push('js')
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
@endpush
