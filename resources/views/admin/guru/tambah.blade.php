{{-- FILE: resources/views/admin/guru/tambah.blade.php --}}
{{-- Form tambah guru baru --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Tambah Guru')
@section('page-title', 'Tambah Guru')

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
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Tambah Guru</h2>
            <p>Tambahkan data guru baru ke sistem</p>
        </div>
        <a href="{{ route('admin.guru.index') }}" class="neo-btn neo-btn-putih">
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

        <form action="{{ route('admin.guru.simpan') }}" method="POST" enctype="multipart/form-data" class="form-grid">
            @csrf

            {{-- NIP --}}
            <div class="form-field">
                <label class="neo-label" for="nip">
                    NIP <span class="form-opsional">(opsional)</span>
                </label>
                <input
                    type="text"
                    id="nip"
                    name="nip"
                    class="neo-input"
                    placeholder="Nomor Induk Pegawai"
                    value="{{ old('nip', $nipBaru) }}"
                >
            </div>

            {{-- Nama --}}
            <div class="form-field">
                <label class="neo-label" for="nama">
                    Nama Lengkap <span class="form-required">*</span>
                </label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="neo-input"
                    placeholder="Nama lengkap guru"
                    value="{{ old('nama') }}"
                    required
                >
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
                    Tanggal Lahir <span class="form-opsional">(opsional)</span>
                </label>
                <input
                    type="date"
                    id="tanggal_lahir"
                    name="tanggal_lahir"
                    class="neo-input"
                    value="{{ old('tanggal_lahir') }}"
                >
            </div>

            {{-- No Telepon --}}
            <div class="form-field">
                <label class="neo-label" for="no_telepon">
                    No. Telepon <span class="form-opsional">(opsional)</span>
                </label>
                <input
                    type="text"
                    id="no_telepon"
                    name="no_telepon"
                    class="neo-input"
                    placeholder="08xxxxxxxxxx"
                    value="{{ old('no_telepon') }}"
                >
            </div>

            {{-- Foto --}}
            <div class="form-field">
                <label class="neo-label" for="foto">
                    Foto <span class="form-opsional">(opsional)</span>
                </label>
                <input
                    type="file"
                    id="foto"
                    name="foto"
                    class="neo-input-file"
                    accept="image/jpg,image/jpeg,image/png"
                >
                <span class="form-hint">Format: JPG, JPEG, PNG. Maks: 2MB</span>
            </div>

            {{-- Alamat --}}
            <div class="form-field form-field-full">
                <label class="neo-label" for="alamat">
                    Alamat <span class="form-opsional">(opsional)</span>
                </label>
                <textarea
                    id="alamat"
                    name="alamat"
                    class="neo-textarea"
                    placeholder="Alamat lengkap guru"
                    rows="3"
                >{{ old('alamat') }}</textarea>
            </div>

            {{-- Divider akun login --}}
            <div class="form-field form-field-full">
                <hr class="neo-divider">
                <p class="form-section-title">
                    <i data-lucide="lock"></i>
                    Akun Login Guru
                </p>
            </div>

            {{-- Username --}}
            <div class="form-field">
                <label class="neo-label" for="username">
                    Username <span class="form-opsional">(otomatis = NIP)</span>
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="neo-input"
                    value="{{ old('username', $nipBaru) }}"
                    readonly
                    style="background:#f5f5f0; cursor:not-allowed;"
                >
            </div>

            {{-- Password --}}
            <div class="form-field">
                <label class="neo-label" for="password">
                    Password <span class="form-opsional">(otomatis = NIP)</span>
                </label>
                <input
                    type="text"
                    id="password"
                    name="password"
                    class="neo-input"
                    value="{{ old('password', $nipBaru) }}"
                    readonly
                    style="background:#f5f5f0; cursor:not-allowed;"
                >
                <span class="form-hint">Password default sama dengan NIP. Guru bisa ganti sendiri di profil.</span>
            </div>

            {{-- Tombol --}}
            <div class="form-field form-field-full form-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="save"></i>
                    Simpan Data
                </button>
                <a href="{{ route('admin.guru.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
