{{-- FILE: resources/views/admin/siswa/index.blade.php --}}
{{-- Halaman daftar siswa --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('admin.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Data Sekolah</span>
    <a href="{{ route('admin.siswa.index') }}" class="aktif">
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
    <a href="{{ route('admin.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">
@endpush

@section('konten')

    {{-- Header halaman --}}
    <div class="page-header">
        <div class="page-header-teks">
            <h2>Data Siswa</h2>
            <p>Kelola seluruh data siswa SMP Negeri 17 Makassar</p>
        </div>
        <a href="{{ route('admin.siswa.tambah') }}" class="neo-btn neo-btn-kuning">
            <i data-lucide="plus"></i>
            Tambah Siswa
        </a>
    </div>

    {{-- Filter & pencarian --}}
    <div class="neo-card filter-card">
        <form action="{{ route('admin.siswa.index') }}" method="GET" class="filter-form">

            <div class="filter-field">
                <label class="neo-label">Cari Siswa</label>
                <input type="text" name="cari" class="neo-input" placeholder="Nama atau NIS..."
                    value="{{ $cari }}">
            </div>

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
                    Cari
                </button>
                <a href="{{ route('admin.siswa.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>

        </form>
    </div>

    {{-- Tabel data siswa --}}
    <div class="neo-card" data-aos="fade-up">

        <div class="neo-card-header">
            <h3>
                <i data-lucide="users"></i>
                Daftar Siswa
            </h3>
            <span class="neo-badge neo-badge-hadir">
                {{ $daftarSiswa->count() }} siswa
            </span>
        </div>

        @if ($daftarSiswa->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>JK</th>
                            <th>Tanggal Lahir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarSiswa as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="tabel-foto">
                                        @if ($siswa->foto)
                                            <img src="{{ asset('img/siswa/' . $siswa->foto) }}" alt="{{ $siswa->nama }}">
                                        @else
                                            <div class="tabel-foto-inisial">
                                                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td><strong>{{ $siswa->nis }}</strong></td>
                                <td>{{ $siswa->nama }}</td>
                                <td>
                                    <span class="neo-badge neo-badge-hadir">
                                        {{ $siswa->nama_kelas }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="neo-badge {{ $siswa->jenis_kelamin == 'L' ? 'neo-badge-sakit' : 'neo-badge-fuchsia' }}">
                                        {{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    <div class="tabel-aksi">
                                        <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}"
                                            class="neo-btn neo-btn-kuning neo-btn-sm">
                                            <i data-lucide="pencil"></i>
                                            Edit
                                        </a>
                                        <form id="form-hapus-{{ $siswa->id_siswa }}"
                                            action="{{ route('admin.siswa.hapus', $siswa->id_siswa) }}" method="POST">
                                            @csrf
                                            <button type="button" class="neo-btn neo-btn-fuchsia neo-btn-sm"
                                                onclick="konfirmasiHapus('form-hapus-{{ $siswa->id_siswa }}')">
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
                <i data-lucide="users"></i>
                <p>Belum ada data siswa{{ $cari ? ' yang cocok dengan pencarian.' : '.' }}</p>
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
