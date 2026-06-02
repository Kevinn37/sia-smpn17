@extends('layouts.dashboard')

@section('title', 'Monitoring Siswa')
@section('page-title', 'Monitoring Siswa')

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
    <a href="{{ route('kepala-sekolah.monitoring.siswa') }}" class="aktif">
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
            <h2>Monitoring Siswa</h2>
            <p>Data seluruh siswa per kelas</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="neo-card filter-card">
        <form action="{{ route('kepala-sekolah.monitoring.siswa') }}" method="GET" class="filter-form">
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
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Filter
                </button>
                <a href="{{ route('kepala-sekolah.monitoring.siswa') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="users"></i>
                Daftar Siswa
            </h3>
            <span class="neo-badge neo-badge-hadir">{{ $daftarSiswa->count() }} siswa</span>
        </div>

        @if ($daftarSiswa->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>JK</th>
                            <th>Tanggal Lahir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarSiswa as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $siswa->nis }}</strong></td>
                                <td>{{ $siswa->nama }}</td>
                                <td><span class="neo-badge neo-badge-biru">{{ $siswa->nama_kelas }}</span></td>
                                <td>
                                    <span
                                        class="neo-badge {{ $siswa->jenis_kelamin == 'L' ? 'neo-badge-biru' : 'neo-badge-fuchsia' }}">
                                        {{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="users"></i>
                <p>Belum ada data siswa.</p>
            </div>
        @endif
    </div>

@endsection
