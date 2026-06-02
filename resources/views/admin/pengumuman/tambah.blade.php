@extends('layouts.dashboard')

@section('title', 'Buat Pengumuman')
@section('page-title', 'Buat Pengumuman')

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
    <a href="{{ route('admin.pengumuman.index') }}" class="aktif">
        <i data-lucide="megaphone"></i> Pengumuman
    </a>
    <span class="sidebar-nav-label">Laporan</span>
    <a href="{{ route('admin.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengumuman.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Buat Pengumuman</h2>
            <p>Buat pengumuman baru untuk siswa atau guru</p>
        </div>
        <a href="{{ route('admin.pengumuman.index') }}" class="neo-btn neo-btn-putih">
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

        <form action="{{ route('admin.pengumuman.simpan') }}" method="POST" class="form-grid">
            @csrf

            {{-- Judul --}}
            <div class="form-field form-field-full">
                <label class="neo-label" for="judul">
                    Judul Pengumuman <span class="form-required">*</span>
                </label>
                <input type="text" id="judul" name="judul" class="neo-input" placeholder="Judul pengumuman"
                    value="{{ old('judul') }}" required>
            </div>

            {{-- Ditujukan --}}
            <div class="form-field">
                <label class="neo-label" for="ditujukan">
                    Ditujukan Kepada <span class="form-required">*</span>
                </label>
                <select id="ditujukan" name="ditujukan" class="neo-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="semua" {{ old('ditujukan') == 'semua' ? 'selected' : '' }}>Semua Pengguna</option>
                    <option value="siswa" {{ old('ditujukan') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ old('ditujukan') == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>

            {{-- Tanggal Tayang --}}
            <div class="form-field">
                <label class="neo-label" for="tanggal_tayang">
                    Tanggal Tayang <span class="form-required">*</span>
                </label>
                <input type="date" id="tanggal_tayang" name="tanggal_tayang" class="neo-input"
                    value="{{ old('tanggal_tayang', today()->toDateString()) }}" required>
            </div>

            {{-- Tanggal Berakhir --}}
            <div class="form-field">
                <label class="neo-label" for="tanggal_berakhir">
                    Tanggal Berakhir <span class="form-opsional">(opsional)</span>
                </label>
                <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" class="neo-input"
                    value="{{ old('tanggal_berakhir') }}">
                <span class="form-hint">Kosongkan jika pengumuman tayang permanen</span>
            </div>

            {{-- Isi --}}
            <div class="form-field form-field-full">
                <label class="neo-label" for="isi">
                    Isi Pengumuman <span class="form-required">*</span>
                </label>
                <textarea id="isi" name="isi" class="neo-textarea" placeholder="Tulis isi pengumuman di sini..."
                    rows="6" required>{{ old('isi') }}</textarea>
            </div>

            <div class="form-field form-field-full form-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="send"></i>
                    Publikasikan
                </button>
                <a href="{{ route('admin.pengumuman.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
