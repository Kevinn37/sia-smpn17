{{-- FILE: resources/views/auth/login.blade.php --}}
{{-- Halaman login semua role --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.app')

@section('title', 'Login')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('konten')

    <main class="login-wrapper">

        {{-- Sisi kiri — branding --}}
        <section class="login-branding" data-aos="fade-right">

            <div class="login-branding-isi">

                <div class="login-logo-wrapper">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo SMP Negeri 17 Makassar">
                </div>

                <h1 class="login-judul">SIAKAD</h1>
                <p class="login-subjudul">SMP Negeri 17 Makassar</p>

                <p class="login-deskripsi">
                    Sistem Informasi Akademik digital untuk mendukung
                    kegiatan belajar mengajar yang lebih efisien dan modern.
                </p>

                <div class="login-fitur-list">
                    <div class="login-fitur-item">
                        <i data-lucide="qr-code"></i>
                        <span>Presensi berbasis QR Code</span>
                    </div>
                    <div class="login-fitur-item">
                        <i data-lucide="book-open"></i>
                        <span>Pengelolaan nilai akademik</span>
                    </div>
                    <div class="login-fitur-item">
                        <i data-lucide="calendar"></i>
                        <span>Jadwal & kalender akademik</span>
                    </div>
                    <div class="login-fitur-item">
                        <i data-lucide="bar-chart-2"></i>
                        <span>Monitoring & laporan sekolah</span>
                    </div>
                </div>

            </div>

        </section>

        {{-- Sisi kanan — form login --}}
        <section class="login-form-wrapper" data-aos="fade-left">

            <div class="login-form-box">

                <div class="login-form-header">
                    <h2>Masuk ke Sistem</h2>
                    <p>Masukkan username dan password Anda</p>
                </div>

                {{-- Pesan gagal login --}}
                @if (session('gagal'))
                    <div class="login-alert-gagal">
                        <i data-lucide="alert-circle"></i>
                        {{ session('gagal') }}
                    </div>
                @endif

                {{-- Form login --}}
                <form action="{{ route('login.proses') }}" method="POST" class="login-form">
                    @csrf

                    <div class="login-field">
                        <label class="neo-label" for="username">Username</label>
                        <input class="neo-input" type="text" id="username" name="username"
                            placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                    </div>

                    <div class="login-field">
                        <label class="neo-label" for="password">Password</label>
                        <div class="login-input-password">
                            <input class="neo-input" type="password" id="password" name="password"
                                placeholder="Masukkan password" required>
                            <button type="button" class="login-toggle-password" id="toggle-password">
                                <i data-lucide="eye" id="icon-password"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="neo-btn neo-btn-biru login-btn-submit">
                        <i data-lucide="log-in"></i>
                        Masuk
                    </button>

                </form>

                <div class="login-form-footer">
                    <a href="{{ route('welcome') }}">
                        <i data-lucide="arrow-left"></i>
                        Kembali ke halaman utama
                    </a>
                </div>

            </div>

        </section>

    </main>

@endsection

@push('js')
    <script src="{{ asset('js/login.js') }}"></script>
@endpush
