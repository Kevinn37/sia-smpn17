{{-- FILE: resources/views/admin/laporan/presensi.blade.php --}}
{{-- Laporan presensi siswa --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Laporan Presensi')
@section('page-title', 'Laporan Presensi')

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
            <h2>Laporan Presensi</h2>
            <p>Data kehadiran siswa seluruh kelas</p>
        </div>
        <div class="laporan-header-aksi">
            <a href="{{ route('admin.laporan.index') }}" class="neo-btn neo-btn-putih">
                <i data-lucide="arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.laporan.export.presensi', ['id_kelas' => $id_kelas, 'bulan' => $bulan]) }}"
                class="neo-btn neo-btn-hijau">
                <i data-lucide="download"></i>
                Export CSV
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="neo-card filter-card">
        <form action="{{ route('admin.laporan.presensi') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Kelas</label>
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
                <label class="neo-label">Tanggal</label>
                <input type="date" name="tanggal" class="neo-input" value="{{ $tanggal }}">
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
                <a href="{{ route('admin.laporan.presensi') }}" class="neo-btn neo-btn-putih">
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
            <span class="neo-badge neo-badge-hadir">
                {{ $daftarPresensi->count() }} data
            </span>
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
                                <td>
                                    <span class="neo-badge neo-badge-biru">{{ $presensi->nama_kelas }}</span>
                                </td>
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
