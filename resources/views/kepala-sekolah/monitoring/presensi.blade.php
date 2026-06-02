@extends('layouts.dashboard')

@section('title', 'Monitoring Presensi')
@section('page-title', 'Monitoring Presensi')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('kepala-sekolah.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Monitoring</span>
    <a href="{{ route('kepala-sekolah.monitoring.presensi') }}" class="aktif">
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
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kepsek-monitoring.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Monitoring Presensi</h2>
            <p>Data kehadiran siswa seluruh kelas</p>
        </div>
    </div>

    {{-- Rekap total --}}
    <div class="kepsek-rekap-row" data-aos="fade-up">
        <div class="kepsek-rekap-card kepsek-rekap-hadir">
            <span class="kepsek-rekap-angka">{{ $rekapStatus['hadir'] ?? 0 }}</span>
            <span class="kepsek-rekap-label">Total Hadir</span>
        </div>
        <div class="kepsek-rekap-card kepsek-rekap-izin">
            <span class="kepsek-rekap-angka">{{ $rekapStatus['izin'] ?? 0 }}</span>
            <span class="kepsek-rekap-label">Total Izin</span>
        </div>
        <div class="kepsek-rekap-card kepsek-rekap-sakit">
            <span class="kepsek-rekap-angka">{{ $rekapStatus['sakit'] ?? 0 }}</span>
            <span class="kepsek-rekap-label">Total Sakit</span>
        </div>
        <div class="kepsek-rekap-card kepsek-rekap-alfa">
            <span class="kepsek-rekap-angka">{{ $rekapStatus['alfa'] ?? 0 }}</span>
            <span class="kepsek-rekap-label">Total Alfa</span>
        </div>
    </div>

    {{-- Filter --}}
    <div class="neo-card filter-card">
        <form action="{{ route('kepala-sekolah.monitoring.presensi') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Filter Kelas</label>
                <select name="id_kelas" class="neo-select">
                    <option value="">Semua Kelas</option>
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ $id_kelas == $kelas->id_kelas ? 'selected' : '' }}>
                            Kelas {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label class="neo-label">Bulan</label>
                <input type="month" name="bulan" class="neo-input" value="{{ $bulan }}">
            </div>
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Filter
                </button>
                <a href="{{ route('kepala-sekolah.monitoring.presensi') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel presensi --}}
    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="clipboard-list"></i>
                Data Presensi
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
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Status</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarPresensi as $presensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $presensi->nis }}</td>
                                <td>{{ $presensi->nama_siswa }}</td>
                                <td><span class="neo-badge neo-badge-biru">{{ $presensi->nama_kelas }}</span></td>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="clipboard-list"></i>
                <p>Belum ada data presensi.</p>
            </div>
        @endif
    </div>

@endsection
