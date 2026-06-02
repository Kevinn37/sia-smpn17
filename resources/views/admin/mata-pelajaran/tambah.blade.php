@extends('layouts.dashboard')

@section('title', 'Tambah Mata Pelajaran')
@section('page-title', 'Tambah Mata Pelajaran')

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
            <h2>Tambah Mata Pelajaran</h2>
            <p>Tambahkan mata pelajaran baru ke sistem</p>
        </div>
        <a href="{{ route('admin.mapel.index') }}" class="neo-btn neo-btn-putih">
            <i data-lucide="arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="neo-card form-card" data-aos="fade-up">

        @if ($errors->any())
            <div class="neo-alert-error">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.mapel.simpan') }}" method="POST" class="form-grid">
            @csrf

            {{-- Kode Mapel --}}
            <div class="form-field">
                <label class="neo-label" for="kode_mapel">
                    Kode Mapel <span class="form-required">*</span>
                </label>
                <input type="text" id="kode_mapel" name="kode_mapel" class="neo-input"
                    placeholder="Contoh: MTK, BIN, IPA" value="{{ old('kode_mapel') }}" maxlength="10" required>
                <span class="form-hint">Kode akan otomatis diubah ke huruf kapital</span>
            </div>

            {{-- Nama Mapel --}}
            <div class="form-field">
                <label class="neo-label" for="nama_mapel">
                    Nama Mata Pelajaran <span class="form-required">*</span>
                </label>
                <input type="text" id="nama_mapel" name="nama_mapel" class="neo-input" placeholder="Contoh: Matematika"
                    value="{{ old('nama_mapel') }}" required>
            </div>

            <div class="form-field form-field-full form-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="save"></i>
                    Simpan
                </button>
                <a href="{{ route('admin.mapel.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
