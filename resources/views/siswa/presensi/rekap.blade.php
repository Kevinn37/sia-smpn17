@extends('layouts.dashboard')

@section('title', 'Rekap Kehadiran')
@section('page-title', 'Rekap Kehadiran')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('siswa.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('siswa.presensi.index') }}" class="aktif">
        <i data-lucide="qr-code"></i> Presensi
    </a>
    <a href="{{ route('siswa.nilai') }}">
        <i data-lucide="book-open"></i> Nilai
    </a>
    <a href="{{ route('siswa.jadwal') }}">
        <i data-lucide="calendar-days"></i> Jadwal
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/siswa-presensi.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Rekap Kehadiran</h2>
            <p>Riwayat lengkap kehadiran saya</p>
        </div>
        <a href="{{ route('siswa.presensi.index') }}" class="neo-btn neo-btn-putih">
            <i data-lucide="arrow-left"></i>
            Kembali
        </a>
    </div>

    {{-- Rekap total --}}
    <div class="siswa-rekap-row" data-aos="fade-up">
        <div class="siswa-rekap-card siswa-rekap-hadir">
            <span class="siswa-rekap-angka">{{ $rekapStatus['hadir'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Total Hadir</span>
        </div>
        <div class="siswa-rekap-card siswa-rekap-izin">
            <span class="siswa-rekap-angka">{{ $rekapStatus['izin'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Total Izin</span>
        </div>
        <div class="siswa-rekap-card siswa-rekap-sakit">
            <span class="siswa-rekap-angka">{{ $rekapStatus['sakit'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Total Sakit</span>
        </div>
        <div class="siswa-rekap-card siswa-rekap-alfa">
            <span class="siswa-rekap-angka">{{ $rekapStatus['alfa'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Total Alfa</span>
        </div>
    </div>

    {{-- Filter --}}
    <div class="neo-card filter-card">
        <form action="{{ route('siswa.presensi.rekap') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Filter Bulan</label>
                <input type="month" name="bulan" class="neo-input" value="{{ $bulan }}">
            </div>
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Filter
                </button>
                <a href="{{ route('siswa.presensi.rekap') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="clipboard-list"></i>
                Riwayat Kehadiran
            </h3>
            <span class="neo-badge neo-badge-hadir">{{ $daftarPresensi->count() }} data</span>
        </div>

        @if ($daftarPresensi->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Mata Pelajaran</th>
                            <th>Status</th>
                            <th>Metode</th>
                            <th>Waktu Scan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarPresensi as $presensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $presensi->nama_mapel }}</td>
                                <td>
                                    <span class="neo-badge neo-badge-{{ $presensi->status }}">
                                        {{ ucfirst($presensi->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="neo-badge {{ $presensi->metode == 'qr' ? 'neo-badge-hijau' : 'neo-badge-kuning' }}">
                                        {{ strtoupper($presensi->metode) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $presensi->waktu_scan ? \Carbon\Carbon::parse($presensi->waktu_scan)->format('H:i') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="clipboard-list"></i>
                <p>Belum ada data kehadiran.</p>
            </div>
        @endif
    </div>

@endsection
