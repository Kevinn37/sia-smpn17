@extends('layouts.dashboard')

@section('title', 'Mata Pelajaran')
@section('page-title', 'Mata Pelajaran')

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
    <a href="{{ route('admin.mapel.index') }}" class="aktif">
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
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Mata Pelajaran</h2>
            <p>Kelola data mata pelajaran sekolah</p>
        </div>
        <a href="{{ route('admin.mapel.tambah') }}" class="neo-btn neo-btn-kuning">
            <i data-lucide="plus"></i>
            Tambah Mapel
        </a>
    </div>

    <div class="neo-card" data-aos="fade-up">

        <div class="neo-card-header">
            <h3>
                <i data-lucide="book"></i>
                Daftar Mata Pelajaran
            </h3>
            <span class="neo-badge neo-badge-hadir">
                {{ $daftarMapel->count() }} mapel
            </span>
        </div>

        @if ($daftarMapel->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarMapel as $mapel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="neo-badge neo-badge-biru">
                                        {{ $mapel->kode_mapel }}
                                    </span>
                                </td>
                                <td><strong>{{ $mapel->nama_mapel }}</strong></td>
                                <td>
                                    <div class="tabel-aksi">
                                        <a href="{{ route('admin.mapel.edit', $mapel->id_mapel) }}"
                                            class="neo-btn neo-btn-kuning neo-btn-sm">
                                            <i data-lucide="pencil"></i>
                                            Edit
                                        </a>
                                        <form id="form-hapus-{{ $mapel->id_mapel }}"
                                            action="{{ route('admin.mapel.hapus', $mapel->id_mapel) }}" method="POST">
                                            @csrf
                                            <button type="button" class="neo-btn neo-btn-fuchsia neo-btn-sm"
                                                onclick="konfirmasiHapus('form-hapus-{{ $mapel->id_mapel }}')">
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
                <i data-lucide="book"></i>
                <p>Belum ada data mata pelajaran.</p>
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
    @if (session('gagal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('gagal') }}',
                    timer: 3000,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif
@endpush
