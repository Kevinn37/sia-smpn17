@extends('layouts.dashboard')

@section('title', 'Edit Kegiatan')
@section('page-title', 'Edit Kegiatan')

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
            <h2>Edit Kegiatan</h2>
            <p>Perbarui kegiatan <strong>{{ $result->judul }}</strong></p>
        </div>
        <a href="{{ route('admin.kalender.index') }}" class="neo-btn neo-btn-putih">
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

        <form action="{{ route('admin.kalender.update', $result->id_kalender) }}" method="POST" class="form-grid">
            @csrf

            <div class="form-field form-field-full">
                <label class="neo-label" for="judul">
                    Judul Kegiatan <span class="form-required">*</span>
                </label>
                <input
                    type="text"
                    id="judul"
                    name="judul"
                    class="neo-input"
                    value="{{ old('judul', $result->judul) }}"
                    required
                >
            </div>

            <div class="form-field">
                <label class="neo-label" for="tanggal_mulai">
                    Tanggal Mulai <span class="form-required">*</span>
                </label>
                <input
                    type="date"
                    id="tanggal_mulai"
                    name="tanggal_mulai"
                    class="neo-input"
                    value="{{ old('tanggal_mulai', $result->tanggal_mulai) }}"
                    required
                >
            </div>

            <div class="form-field">
                <label class="neo-label" for="tanggal_selesai">
                    Tanggal Selesai <span class="form-required">*</span>
                </label>
                <input
                    type="date"
                    id="tanggal_selesai"
                    name="tanggal_selesai"
                    class="neo-input"
                    value="{{ old('tanggal_selesai', $result->tanggal_selesai) }}"
                    required
                >
            </div>

            <div class="form-field">
                <label class="neo-label" for="jenis">
                    Jenis Kegiatan <span class="form-required">*</span>
                </label>
                <select id="jenis" name="jenis" class="neo-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach ($daftarJenis as $j)
                        <option value="{{ $j }}" {{ old('jenis', $result->jenis) == $j ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $j)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-field form-field-full">
                <label class="neo-label" for="keterangan">
                    Keterangan <span class="form-opsional">(opsional)</span>
                </label>
                <textarea
                    id="keterangan"
                    name="keterangan"
                    class="neo-textarea"
                    rows="3"
                >{{ old('keterangan', $result->keterangan) }}</textarea>
            </div>

            <div class="form-field form-field-full form-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="save"></i>
                    Perbarui
                </button>
                <a href="{{ route('admin.kalender.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
