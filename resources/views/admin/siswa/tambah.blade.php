{{-- FILE: resources/views/admin/siswa/tambah.blade.php --}}
{{-- Form tambah siswa baru --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Siswa')

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
@endpush

@section('konten')

    {{-- Header halaman --}}
    <div class="page-header">
        <div class="page-header-teks">
            <h2>Tambah Siswa</h2>
            <p>Tambahkan data siswa baru ke sistem</p>
        </div>
        <a href="{{ route('admin.siswa.index') }}" class="neo-btn neo-btn-putih">
            <i data-lucide="arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="neo-card form-card" data-aos="fade-up">

        {{-- Error validasi --}}
        @if ($errors->any())
            <div class="neo-alert-error">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.siswa.simpan') }}" method="POST" enctype="multipart/form-data" class="form-grid">
            @csrf

            {{-- NIS --}}
            <div class="form-field">
                <label class="neo-label" for="nis">
                    NIS <span class="form-opsional">(otomatis)</span>
                </label>
                <input type="text" id="nis" name="nis" class="neo-input" value="{{ old('nis', $nisBaru) }}"
                    readonly style="background:#f5f5f0; cursor:not-allowed;">
                <span class="form-hint">NIS dibuat otomatis oleh sistem</span>
            </div>

            {{-- Nama --}}
            <div class="form-field">
                <label class="neo-label" for="nama">
                    Nama Lengkap <span class="form-required">*</span>
                </label>
                <input type="text" id="nama" name="nama" class="neo-input" placeholder="Nama lengkap siswa"
                    value="{{ old('nama') }}" required>
            </div>

            {{-- Kelas --}}
            <div class="form-field">
                <label class="neo-label" for="id_kelas">
                    Kelas <span class="form-required">*</span>
                </label>
                <select id="id_kelas" name="id_kelas" class="neo-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id_kelas }}"
                            {{ old('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                            Kelas {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jenis Kelamin --}}
            <div class="form-field">
                <label class="neo-label" for="jenis_kelamin">
                    Jenis Kelamin <span class="form-required">*</span>
                </label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="neo-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Tanggal Lahir --}}
            <div class="form-field">
                <label class="neo-label" for="tanggal_lahir">
                    Tanggal Lahir <span class="form-required">*</span>
                </label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="neo-input"
                    value="{{ old('tanggal_lahir') }}" required>
            </div>

            {{-- Foto --}}
            <div class="form-field">
                <label class="neo-label" for="foto">
                    Foto <span class="form-opsional">(opsional)</span>
                </label>
                <input type="file" id="foto" name="foto" class="neo-input-file"
                    accept="image/jpg,image/jpeg,image/png">
                <span class="form-hint">Format: JPG, JPEG, PNG. Maks: 2MB</span>
            </div>

            {{-- Alamat --}}
            <div class="form-field form-field-full">
                <label class="neo-label" for="alamat">
                    Alamat <span class="form-opsional">(opsional)</span>
                </label>
                <textarea id="alamat" name="alamat" class="neo-textarea" placeholder="Alamat lengkap siswa" rows="3">{{ old('alamat') }}</textarea>
            </div>

            {{-- Info akun --}}
            <div class="form-field form-field-full">
                <div class="form-info-box">
                    <i data-lucide="info"></i>
                    <p>Akun login siswa akan dibuat otomatis. Username dan password default = NIS siswa.</p>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="form-field form-field-full form-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="save"></i>
                    Simpan Data
                </button>
                <a href="{{ route('admin.siswa.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
