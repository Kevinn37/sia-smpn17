@extends('layouts.dashboard')

@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal')

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
    <a href="{{ route('admin.jadwal.index') }}" class="aktif">
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
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Edit Jadwal</h2>
            <p>Perbarui jadwal pelajaran</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="neo-btn neo-btn-putih">
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

        <form action="{{ route('admin.jadwal.update', $result->id_jadwal) }}" method="POST" class="form-grid">
            @csrf

            {{-- Kelas --}}
            <div class="form-field">
                <label class="neo-label" for="id_kelas">
                    Kelas <span class="form-required">*</span>
                </label>
                <select id="id_kelas" name="id_kelas" class="neo-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id_kelas }}"
                            {{ old('id_kelas', $result->id_kelas) == $kelas->id_kelas ? 'selected' : '' }}>
                            Kelas {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Guru --}}
            <div class="form-field">
                <label class="neo-label" for="id_guru">
                    Guru <span class="form-required">*</span>
                </label>
                <select id="id_guru" name="id_guru" class="neo-select" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($daftarGuru as $guru)
                        <option value="{{ $guru->id_guru }}"
                            {{ old('id_guru', $result->id_guru) == $guru->id_guru ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Mata Pelajaran --}}
            <div class="form-field">
                <label class="neo-label" for="id_mapel">
                    Mata Pelajaran <span class="form-required">*</span>
                </label>
                <select id="id_mapel" name="id_mapel" class="neo-select" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($daftarMapel as $mapel)
                        <option value="{{ $mapel->id_mapel }}"
                            {{ old('id_mapel', $result->id_mapel) == $mapel->id_mapel ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Hari --}}
            <div class="form-field">
                <label class="neo-label" for="hari">
                    Hari <span class="form-required">*</span>
                </label>
                <select id="hari" name="hari" class="neo-select" required>
                    <option value="">-- Pilih Hari --</option>
                    @foreach ($daftarHari as $h)
                        <option value="{{ $h }}" {{ old('hari', $result->hari) == $h ? 'selected' : '' }}>
                            {{ $h }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jam Mulai --}}
            <div class="form-field">
                <label class="neo-label" for="jam_mulai">
                    Jam Mulai <span class="form-required">*</span>
                </label>
                <input type="time" id="jam_mulai" name="jam_mulai" class="neo-input"
                    value="{{ old('jam_mulai', substr($result->jam_mulai, 0, 5)) }}" required>
            </div>

            {{-- Jam Selesai --}}
            <div class="form-field">
                <label class="neo-label" for="jam_selesai">
                    Jam Selesai <span class="form-required">*</span>
                </label>
                <input type="time" id="jam_selesai" name="jam_selesai" class="neo-input"
                    value="{{ old('jam_selesai', substr($result->jam_selesai, 0, 5)) }}" required>
            </div>

            <div class="form-field form-field-full form-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="save"></i>
                    Perbarui Jadwal
                </button>
                <a href="{{ route('admin.jadwal.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
