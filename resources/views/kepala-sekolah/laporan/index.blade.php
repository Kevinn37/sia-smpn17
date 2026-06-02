{{-- FILE: resources/views/kepala-sekolah/laporan/index.blade.php --}}
{{-- Laporan kepala sekolah --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('kepala-sekolah.dashboard') }}">
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
    <a href="{{ route('kepala-sekolah.laporan.index') }}" class="aktif">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
@endpush

@section('konten')

    <div class="page-header" style="box-shadow: 6px 6px 0px #2c46c4;">
        <div class="page-header-teks">
            <h2>Laporan Akademik</h2>
            <p>Ringkasan dan export data akademik sekolah</p>
        </div>
    </div>

    {{-- Stat --}}
    <div class="stat-grid" style="margin-bottom: 1.5rem;">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
            <div class="stat-card-icon kuning"><i data-lucide="users"></i></div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalSiswa }}</span>
                <span class="stat-card-label">Total Siswa</span>
            </div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card-icon biru"><i data-lucide="user-tie"></i></div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalGuru }}</span>
                <span class="stat-card-label">Total Guru</span>
            </div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card-icon hijau"><i data-lucide="clipboard-list"></i></div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalPresensi }}</span>
                <span class="stat-card-label">Total Presensi</span>
            </div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card-icon fuchsia"><i data-lucide="book-open"></i></div>
            <div class="stat-card-info">
                <span class="stat-card-angka">{{ $totalNilai }}</span>
                <span class="stat-card-label">Total Data Nilai</span>
            </div>
        </div>
    </div>

    {{-- Export --}}
    <div class="laporan-menu-grid" data-aos="fade-up">

        <div class="laporan-menu-card">
            <div class="laporan-menu-icon laporan-icon-biru">
                <i data-lucide="clipboard-list"></i>
            </div>
            <div class="laporan-menu-info">
                <h3>Export Presensi</h3>
                <p>Download data kehadiran siswa dalam format CSV</p>
            </div>
            <div class="laporan-menu-aksi">
                <a href="{{ route('kepala-sekolah.laporan.export', ['tipe' => 'presensi']) }}"
                    class="neo-btn neo-btn-hijau">
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
                <h3>Export Nilai</h3>
                <p>Download data nilai siswa dalam format CSV</p>
            </div>
            <div class="laporan-menu-aksi">
                <a href="{{ route('kepala-sekolah.laporan.export', ['tipe' => 'nilai']) }}" class="neo-btn neo-btn-hijau">
                    <i data-lucide="download"></i>
                    Export CSV
                </a>
            </div>
        </div>

    </div>

    {{-- Rekap presensi --}}
    <div class="neo-card" data-aos="fade-up">
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

@endsection
