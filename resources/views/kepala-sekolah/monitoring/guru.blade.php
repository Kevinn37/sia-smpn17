@extends('layouts.dashboard')

@section('title', 'Monitoring Guru')
@section('page-title', 'Monitoring Guru')

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
    <a href="{{ route('kepala-sekolah.monitoring.guru') }}" class="aktif">
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
            <h2>Monitoring Guru</h2>
            <p>Data seluruh guru dan jadwal mengajar</p>
        </div>
    </div>

    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="user-tie"></i>
                Daftar Guru
            </h3>
            <span class="neo-badge neo-badge-biru">{{ $daftarGuru->count() }} guru</span>
        </div>

        @if ($daftarGuru->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Guru</th>
                            <th>JK</th>
                            <th>No. Telepon</th>
                            <th>Kelas Diajar</th>
                            <th>Total Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarGuru as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $guru->nip ?? '—' }}</td>
                                <td><strong>{{ $guru->nama }}</strong></td>
                                <td>
                                    <span
                                        class="neo-badge {{ $guru->jenis_kelamin == 'L' ? 'neo-badge-biru' : 'neo-badge-fuchsia' }}">
                                        {{ $guru->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    </span>
                                </td>
                                <td>{{ $guru->no_telepon ?? '—' }}</td>
                                <td>
                                    <span class="neo-badge neo-badge-hadir">
                                        {{ $kelasPerGuru[$guru->id_guru] ?? 0 }} kelas
                                    </span>
                                </td>
                                <td>
                                    <span class="neo-badge neo-badge-kuning">
                                        {{ $jadwalPerGuru[$guru->id_guru] ?? 0 }} jadwal
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="user-tie"></i>
                <p>Belum ada data guru.</p>
            </div>
        @endif
    </div>

@endsection
