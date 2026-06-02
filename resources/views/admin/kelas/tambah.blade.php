@extends('layouts.dashboard')

@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas')

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
    <a href="{{ route('admin.kelas.index') }}" class="aktif">
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
    <link rel="stylesheet" href="{{ asset('css/kelas.css') }}">
@endpush


@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Tambah Kelas</h2>
            <p>Tambahkan kelas baru ke sistem</p>
        </div>
        <a href="{{ route('admin.kelas.index') }}" class="neo-btn neo-btn-putih">
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

        <form action="{{ route('admin.kelas.simpan') }}" method="POST" class="form-grid">
            @csrf

            {{-- Tingkat --}}
            <div class="form-field">
                <label class="neo-label" for="tingkat">
                    Tingkat <span class="form-required">*</span>
                </label>
                <select id="tingkat" name="tingkat" class="neo-select" required>
                    <option value="">-- Pilih Tingkat --</option>
                    <option value="7" {{ old('tingkat') == '7' ? 'selected' : '' }}>Kelas 7</option>
                    <option value="8" {{ old('tingkat') == '8' ? 'selected' : '' }}>Kelas 8</option>
                    <option value="9" {{ old('tingkat') == '9' ? 'selected' : '' }}>Kelas 9</option>
                </select>
            </div>

            {{-- Nomor Kelas --}}
            <div class="form-field">
                <label class="neo-label" for="nomor">
                    Nomor Kelas <span class="form-required">*</span>
                </label>
                <input type="number" id="nomor" name="nomor" class="neo-input" placeholder="Contoh: 1, 2, 3"
                    value="{{ old('nomor') }}" min="1" required>
                <span class="form-hint">Nama kelas akan otomatis: Tingkat.Nomor (contoh: 7.1)</span>
            </div>

            <div class="form-field form-field-full form-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="save"></i>
                    Simpan Kelas
                </button>
                <a href="{{ route('admin.kelas.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
