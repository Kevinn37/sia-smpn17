{{-- FILE: resources/views/siswa/profil/index.blade.php --}}
{{-- Halaman edit profil siswa --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('siswa.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('siswa.presensi.index') }}">
        <i data-lucide="qr-code"></i> Presensi
    </a>
    <a href="{{ route('siswa.nilai') }}">
        <i data-lucide="book-open"></i> Nilai
    </a>
    <a href="{{ route('siswa.jadwal') }}">
        <i data-lucide="calendar-days"></i> Jadwal
    </a>
    <span class="sidebar-nav-label">Akun</span>
    <a href="{{ route('siswa.profil') }}" class="aktif">
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
            <p>Perbarui foto dan password akun</p>
        </div>
    </div>

    <div class="profil-wrapper">

        {{-- Kartu profil kiri --}}
        <div class="profil-kartu" data-aos="fade-right">
            <div class="profil-foto-wrapper">
                @if ($siswa->foto)
                    <img src="{{ asset('img/siswa/' . $siswa->foto) }}" alt="{{ $siswa->nama }}" class="profil-foto">
                @else
                    <div class="profil-foto-inisial">
                        {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h3 class="profil-nama">{{ $siswa->nama }}</h3>
            <span class="profil-role">Siswa</span>
            <div class="profil-info-list">
                <div class="profil-info-item">
                    <i data-lucide="hash"></i>
                    <span>{{ $siswa->nis }}</span>
                </div>
                <div class="profil-info-item">
                    <i data-lucide="door-open"></i>
                    <span>Kelas {{ $siswa->nama_kelas }}</span>
                </div>
                <div class="profil-info-item">
                    <i data-lucide="user"></i>
                    <span>{{ $siswa->username }}</span>
                </div>
                <div class="profil-info-item">
                    <i data-lucide="calendar"></i>
                    <span>{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '—' }}</span>
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

            <form action="{{ route('siswa.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Foto --}}
                <div class="profil-section-title">
                    <i data-lucide="image"></i>
                    Foto Profil
                </div>

                <div class="form-field" style="margin-bottom:1.5rem;">
                    <label class="neo-label" for="foto">
                        Upload Foto Baru <span class="form-opsional">(opsional)</span>
                    </label>
                    <input type="file" id="foto" name="foto" class="neo-input-file" accept="image/jpg,image/jpeg,image/png">
                    <span class="form-hint">Format: JPG, JPEG, PNG. Maks: 2MB</span>
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
