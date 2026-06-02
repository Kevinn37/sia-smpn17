{{-- FILE: resources/views/guru/profil/index.blade.php --}}
{{-- Halaman edit profil guru --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('guru.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('guru.presensi.index') }}">
        <i data-lucide="clipboard-list"></i> Presensi
    </a>
    <a href="{{ route('guru.nilai.index') }}">
        <i data-lucide="book-open"></i> Nilai Siswa
    </a>
    <a href="{{ route('guru.jadwal') }}">
        <i data-lucide="calendar-days"></i> Jadwal Mengajar
    </a>
    <span class="sidebar-nav-label">Akun</span>
    <a href="{{ route('guru.profil') }}" class="aktif">
        <i data-lucide="user"></i> Profil Saya
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Profil Saya</h2>
            <p>Perbarui foto, kontak, dan password akun</p>
        </div>
    </div>

    <div class="profil-wrapper">

        {{-- Kartu profil kiri --}}
        <div class="profil-kartu" data-aos="fade-right">
            <div class="profil-foto-wrapper">
                @if ($guru->foto)
                    <img src="{{ asset('img/guru/' . $guru->foto) }}" alt="{{ $guru->nama }}" class="profil-foto">
                @else
                    <div class="profil-foto-inisial">
                        {{ strtoupper(substr($guru->nama, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h3 class="profil-nama">{{ $guru->nama }}</h3>
            <span class="profil-role">Guru</span>
            <div class="profil-info-list">
                <div class="profil-info-item">
                    <i data-lucide="hash"></i>
                    <span>{{ $guru->nip ?? '—' }}</span>
                </div>
                <div class="profil-info-item">
                    <i data-lucide="user"></i>
                    <span>{{ $guru->username }}</span>
                </div>
                <div class="profil-info-item">
                    <i data-lucide="phone"></i>
                    <span>{{ $guru->no_telepon ?? '—' }}</span>
                </div>
                <div class="profil-info-item">
                    <i data-lucide="map-pin"></i>
                    <span>{{ $guru->alamat ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Form edit kanan --}}
        <div class="profil-form-box" data-aos="fade-left">

            @if (session('sukses'))
                <div class="neo-alert-sukses" style="margin-bottom:1rem;">
                    ✅ {{ session('sukses') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="neo-alert-error" style="margin-bottom:1rem;">
                    <ul style="list-style:none;">
                        @foreach ($errors->all() as $error)
                            <li>⚠ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guru.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Foto --}}
                <div class="profil-section-title">
                    <i data-lucide="image"></i>
                    Foto Profil
                </div>

                <div class="form-field" style="margin-bottom:1.25rem;">
                    <label class="neo-label" for="foto">
                        Upload Foto Baru <span class="form-opsional">(opsional)</span>
                    </label>
                    <input type="file" id="foto" name="foto" class="neo-input-file" accept="image/jpg,image/jpeg,image/png">
                    <span class="form-hint">Format: JPG, JPEG, PNG. Maks: 2MB</span>
                </div>

                {{-- Kontak --}}
                <div class="profil-section-title">
                    <i data-lucide="phone"></i>
                    Informasi Kontak
                </div>

                <div class="form-field" style="margin-bottom:1rem;">
                    <label class="neo-label" for="no_telepon">No. Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" class="neo-input"
                        value="{{ old('no_telepon', $guru->no_telepon) }}" placeholder="08xxxxxxxxxx">
                </div>

                <div class="form-field" style="margin-bottom:1.5rem;">
                    <label class="neo-label" for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="neo-textarea" rows="3">{{ old('alamat', $guru->alamat) }}</textarea>
                </div>

                {{-- Password --}}
                <div class="profil-section-title">
                    <i data-lucide="lock"></i>
                    Ganti Password
                </div>

                <div class="form-field" style="margin-bottom:1rem;">
                    <label class="neo-label" for="password">
                        Password Baru <span class="form-opsional">(kosongkan jika tidak ingin ganti)</span>
                    </label>
                    <input type="password" id="password" name="password" class="neo-input" placeholder="Minimal 6 karakter">
                </div>

                <div class="form-field" style="margin-bottom:1.5rem;">
                    <label class="neo-label" for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="neo-input" placeholder="Ulangi password baru">
                </div>

                <div class="profil-aksi">
                    <button type="submit" class="neo-btn neo-btn-biru">
                        <i data-lucide="save"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>

@endsection
