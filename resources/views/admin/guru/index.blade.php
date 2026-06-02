{{-- FILE: resources/views/admin/guru/index.blade.php --}}
{{-- Halaman daftar guru --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Data Guru')
@section('page-title', 'Data Guru')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('admin.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Data Sekolah</span>
    <a href="{{ route('admin.siswa.index') }}">
        <i data-lucide="users"></i> Data Siswa
    </a>
    <a href="{{ route('admin.guru.index') }}" class="aktif">
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
    <a href="{{ route('admin.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/guru.css') }}">
@endpush


@section('konten')

    {{-- Header halaman --}}
    <div class="page-header">
        <div class="page-header-teks">
            <h2>Data Guru</h2>
            <p>Kelola seluruh data guru SMP Negeri 17 Makassar</p>
        </div>
        <a href="{{ route('admin.guru.tambah') }}" class="neo-btn neo-btn-kuning">
            <i data-lucide="plus"></i>
            Tambah Guru
        </a>
    </div>

    {{-- Filter & pencarian --}}
    <div class="neo-card filter-card">
        <form action="{{ route('admin.guru.index') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Cari Guru</label>
                <input type="text" name="cari" class="neo-input" placeholder="Nama atau NIP..."
                    value="{{ $cari }}">
            </div>
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Cari
                </button>
                <a href="{{ route('admin.guru.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel data guru --}}
    <div class="neo-card" data-aos="fade-up">

        <div class="neo-card-header">
            <h3>
                <i data-lucide="user-tie"></i>
                Daftar Guru
            </h3>
            <span class="neo-badge neo-badge-hadir">
                {{ $daftarGuru->count() }} guru
            </span>
        </div>

        @if ($daftarGuru->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>NIP</th>
                            <th>Nama Guru</th>
                            <th>JK</th>
                            <th>No. Telepon</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarGuru as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="tabel-foto">
                                        @if ($guru->foto)
                                            <img src="{{ asset('img/guru/' . $guru->foto) }}" alt="{{ $guru->nama }}">
                                        @else
                                            <div class="tabel-foto-inisial">
                                                {{ strtoupper(substr($guru->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td><strong>{{ $guru->nip ?? '-' }}</strong></td>
                                <td>{{ $guru->nama }}</td>
                                <td>
                                    <span
                                        class="neo-badge {{ $guru->jenis_kelamin == 'L' ? 'neo-badge-sakit' : 'neo-badge-fuchsia' }}">
                                        {{ $guru->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    </span>
                                </td>
                                <td>{{ $guru->no_telepon ?? '-' }}</td>
                                <td>{{ $guru->username }}</td>
                                <td>
                                    <div class="tabel-aksi">
                                        <a href="{{ route('admin.guru.edit', $guru->id_guru) }}"
                                            class="neo-btn neo-btn-kuning neo-btn-sm">
                                            <i data-lucide="pencil"></i>
                                            Edit
                                        </a>
                                        <form id="form-hapus-{{ $guru->id_guru }}"
                                            action="{{ route('admin.guru.hapus', $guru->id_guru) }}" method="POST">
                                            @csrf
                                            <button type="button" class="neo-btn neo-btn-fuchsia neo-btn-sm"
                                                onclick="konfirmasiHapus('form-hapus-{{ $guru->id_guru }}')">
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
                <i data-lucide="user-tie"></i>
                <p>Belum ada data guru{{ $cari ? ' yang cocok dengan pencarian.' : '.' }}</p>
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
