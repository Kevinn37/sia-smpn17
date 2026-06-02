{{-- FILE: resources/views/admin/laporan/index.blade.php --}}
{{-- Halaman utama laporan admin --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('admin.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Data Sekolah</span>
    <a href="{{ route('admin.siswa.index') }}">
        <i data-lucide="users"></i> Data Siswa
    </a>
    <a href="{{ route('admin.guru.index') }}">
        <i data-lucide="user-tie"></i> Data Guru
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
    <a href="{{ route('admin.laporan.index') }}" class="aktif">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Laporan Akademik</h2>
            <p>Ringkasan dan export data akademik sekolah</p>
        </div>
    </div>

    {{-- Stat ringkas --}}
    <div class="stat-grid" style="margin-bottom: 1.5rem;">
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
            <div class="stat-card-icon hijau">
                <i data-lucide="clipboard-list"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalPresensi }}</span>
                <span class="stat-card-label">Total Presensi</span>
            </div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card-icon fuchsia">
                <i data-lucide="book-open"></i>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalNilai }}</span>
                <span class="stat-card-label">Total Data Nilai</span>
            </div>
        </div>
    </div>

    {{-- Menu laporan --}}
    <div class="laporan-menu-grid" data-aos="fade-up">

        <div class="laporan-menu-card">
            <div class="laporan-menu-icon laporan-icon-biru">
                <i data-lucide="clipboard-list"></i>
            </div>
            <div class="laporan-menu-info">
                <h3>Laporan Presensi</h3>
                <p>Lihat dan export data kehadiran siswa per kelas atau per tanggal</p>
            </div>
            <div class="laporan-menu-aksi">
                <a href="{{ route('admin.laporan.presensi') }}" class="neo-btn neo-btn-biru">
                    <i data-lucide="eye"></i>
                    Lihat
                </a>
                <a href="{{ route('admin.laporan.export.presensi') }}" class="neo-btn neo-btn-hijau">
                    <i data-lucide="download"></i>
                    Export CSV
                </a>
            </div>
        </div>

        <div class="laporan-menu-card">
            <div class="laporan-menu-icon laporan-icon-fuchsia">
                <i data-lucide="book-open"></i>
            </div>
            <div class="laporan-menu-info">
                <h3>Laporan Nilai</h3>
                <p>Lihat dan export data nilai siswa per kelas, mapel, atau semester</p>
            </div>
            <div class="laporan-menu-aksi">
                <a href="{{ route('admin.laporan.nilai') }}" class="neo-btn neo-btn-biru">
                    <i data-lucide="eye"></i>
                    Lihat
                </a>
                <a href="{{ route('admin.laporan.export.nilai') }}" class="neo-btn neo-btn-hijau">
                    <i data-lucide="download"></i>
                    Export CSV
                </a>
            </div>
        </div>

    </div>

    {{-- Rekap presensi --}}
    <div class="laporan-grid-2" data-aos="fade-up">

        <div class="neo-card">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="pie-chart"></i>
                    Rekap Presensi Keseluruhan
                </h3>
            </div>
            <div class="laporan-rekap-grid">
                <div class="laporan-rekap-item laporan-rekap-hadir">
                    <span class="laporan-rekap-angka">{{ $rekapPresensi['hadir'] ?? 0 }}</span>
                    <span class="laporan-rekap-label">Hadir</span>
                </div>
                <div class="laporan-rekap-item laporan-rekap-izin">
                    <span class="laporan-rekap-angka">{{ $rekapPresensi['izin'] ?? 0 }}</span>
                    <span class="laporan-rekap-label">Izin</span>
                </div>
                <div class="laporan-rekap-item laporan-rekap-sakit">
                    <span class="laporan-rekap-angka">{{ $rekapPresensi['sakit'] ?? 0 }}</span>
                    <span class="laporan-rekap-label">Sakit</span>
                </div>
                <div class="laporan-rekap-item laporan-rekap-alfa">
                    <span class="laporan-rekap-angka">{{ $rekapPresensi['alfa'] ?? 0 }}</span>
                    <span class="laporan-rekap-label">Alfa</span>
                </div>
            </div>
        </div>

        <div class="neo-card">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="bar-chart-2"></i>
                    Presensi per Kelas
                </h3>
            </div>
            @if ($rekapPerKelas->count() > 0)
                <div class="laporan-bar-list">
                    @php $maxTotal = $rekapPerKelas->max('total'); @endphp
                    @foreach ($rekapPerKelas as $rekap)
                        <div class="laporan-bar-item">
                            <span class="laporan-bar-label">{{ $rekap->nama_kelas }}</span>
                            <div class="laporan-bar-track">
                                <div
                                    class="laporan-bar-fill"
                                    style="width: {{ $maxTotal > 0 ? ($rekap->total / $maxTotal * 100) : 0 }}%"
                                ></div>
                            </div>
                            <span class="laporan-bar-angka">{{ $rekap->total }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="neo-empty">
                    <i data-lucide="inbox"></i>
                    <p>Belum ada data presensi.</p>
                </div>
            @endif
        </div>

    </div>

@endsection
