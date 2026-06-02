@extends('layouts.dashboard')

@section('title', 'Kalender Akademik')
@section('page-title', 'Kalender Akademik')

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
    <a href="{{ route('admin.kalender.index') }}" class="aktif">
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
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Kalender Akademik</h2>
            <p>Kelola kegiatan dan jadwal akademik sekolah</p>
        </div>
        <a href="{{ route('admin.kalender.tambah') }}" class="neo-btn neo-btn-kuning">
            <i data-lucide="plus"></i>
            Tambah Kegiatan
        </a>
    </div>

    {{-- Filter jenis --}}
    <div class="neo-card filter-card">
        <form action="{{ route('admin.kalender.index') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Filter Jenis</label>
                <select name="jenis" class="neo-select">
                    <option value="">Semua Jenis</option>
                    @foreach ($daftarJenis as $j)
                        <option value="{{ $j }}" {{ $jenis == $j ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $j)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Filter
                </button>
                <a href="{{ route('admin.kalender.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Daftar kegiatan --}}
    <div class="neo-card" data-aos="fade-up">

        <div class="neo-card-header">
            <h3>
                <i data-lucide="calendar"></i>
                Daftar Kegiatan
            </h3>
            <span class="neo-badge neo-badge-hadir">
                {{ $daftarKalender->count() }} kegiatan
            </span>
        </div>

        @if ($daftarKalender->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarKalender as $kalender)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $kalender->judul }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($kalender->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($kalender->tanggal_selesai)->translatedFormat('d F Y') }}</td>
                                <td>
                                    <span class="neo-badge kalender-badge-{{ $kalender->jenis }}">
                                        {{ ucfirst(str_replace('_', ' ', $kalender->jenis)) }}
                                    </span>
                                </td>
                                <td>{{ $kalender->keterangan ?? '-' }}</td>
                                <td>
                                    <div class="tabel-aksi">
                                        <a href="{{ route('admin.kalender.edit', $kalender->id_kalender) }}"
                                            class="neo-btn neo-btn-kuning neo-btn-sm">
                                            <i data-lucide="pencil"></i>
                                            Edit
                                        </a>
                                        <form id="form-hapus-{{ $kalender->id_kalender }}"
                                            action="{{ route('admin.kalender.hapus', $kalender->id_kalender) }}"
                                            method="POST">
                                            @csrf
                                            <button type="button" class="neo-btn neo-btn-fuchsia neo-btn-sm"
                                                onclick="konfirmasiHapus('form-hapus-{{ $kalender->id_kalender }}')">
                                                <i data-lucide="trash-2"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="calendar"></i>
                <p>Belum ada kegiatan akademik.</p>
            </div>
        @endif

    </div>

@endsection

@push('js')
    @if (session('sukses'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('sukses') }}',
                    timer: 2000,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif
@endpush
