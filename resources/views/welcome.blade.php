{{-- FILE: resources/views/welcome/index.blade.php --}}
{{-- Halaman welcome page publik --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.app')

@section('title', 'Selamat Datang')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endpush

@section('konten')

    {{-- ===========================
         TICKER / RUNNING TEXT
    =========================== --}}
    <div class="neo-ticker">
        <div class="ticker-wrap">
            <div class="ticker-item">★ SIAKAD SMP NEGERI 17 MAKASSAR KINI LEBIH MODERN ★ PRESENSI DIGITAL QR CODE CEPAT &
                AKURAT ★ MONITORING AKADEMIK TERPADU ★ REVOLUSI DIGITAL MENUJU SEKOLAH MAJU ★</div>
            <div class="ticker-item">★ SIAKAD SMP NEGERI 17 MAKASSAR KINI LEBIH MODERN ★ PRESENSI DIGITAL QR CODE CEPAT &
                AKURAT ★ MONITORING AKADEMIK TERPADU ★ REVOLUSI DIGITAL MENUJU SEKOLAH MAJU ★</div>
        </div>
    </div>

    {{-- ===========================
         NAVIGASI
    =========================== --}}
    <header class="nav-wrapper">
        <nav class="nav-isi">
            <div class="nav-brand">
                <img src="{{ asset('img/logo.png') }}" alt="Logo SMPN 17 Makassar">
                <div class="nav-brand-teks">
                    <span class="nav-brand-sistem">SIAKAD</span>
                    <span class="nav-brand-sekolah">SMP Negeri 17 Makassar</span>
                </div>
            </div>

            <div class="nav-aksi">
                <a href="{{ route('login') }}" class="neo-btn neo-btn-biru">
                    <i data-lucide="log-in"></i>
                    <span>Masuk</span>
                </a>
            </div>
        </nav>
    </header>

    <main>

        {{-- ===========================
             SECTION HERO
        =========================== --}}
        <section class="hero-wrapper" id="hero">
            <div class="section-isi">
                <div class="hero-teks" data-aos="fade-right">
                    <div class="hero-badge">
                        <i data-lucide="zap"></i>
                        <span>Sistem Akademik Digital</span>
                    </div>
                    <h1 class="hero-judul">
                        Akademik Lebih <span class="hero-judul-aksen">Modern</span>,<br>
                        Sekolah Lebih <span class="hero-judul-aksen-hijau">Maju</span>
                    </h1>
                    <p class="hero-deskripsi">
                        SIAKAD hadir untuk membantu SMP Negeri 17 Makassar dalam mengelola kegiatan akademik secara digital
                        — dari presensi QR Code hingga monitoring nilai siswa secara real-time.
                    </p>
                    <div class="hero-aksi">
                        <a href="{{ route('login') }}" class="neo-btn neo-btn-kuning">
                            <span>Masuk ke Sistem</span>
                            <i data-lucide="arrow-right"></i>
                        </a>
                        <a href="#fitur" class="neo-btn neo-btn-putih">
                            <i data-lucide="info"></i>
                            <span>Pelajari Fitur</span>
                        </a>
                    </div>
                </div>

                <div class="hero-gambar" data-aos="fade-left">
                    <div class="hero-gambar-box">
                        <div class="pattern-bg"></div>
                        <img src="{{ asset('img/hero-siswa.png') }}" alt="Ilustrasi Siswa SMPN 17 Makassar">
                    </div>
                    <div class="hero-stat-card hero-stat-1" data-aos="zoom-in" data-aos-delay="200">
                        <div class="stat-icon-wrapper b-biru"><i data-lucide="users"></i></div>
                        <div>
                            <span class="hero-stat-angka">{{ $jumlahSiswa }}</span>
                            <span class="hero-stat-label">Siswa Aktif</span>
                        </div>
                    </div>
                    <div class="hero-stat-card hero-stat-2" data-aos="zoom-in" data-aos-delay="300">
                        <div class="stat-icon-wrapper b-fuchsia"><i data-lucide="qr-code"></i></div>
                        <div>
                            <span class="hero-stat-angka">QR CODE</span>
                            <span class="hero-stat-label">Presensi Digital</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===========================
             SECTION TENTANG SEKOLAH
        =========================== --}}
        <section class="tentang-wrapper" id="tentang">
            <div class="section-isi">
                <div class="tentang-gambar" data-aos="fade-right">
                    <div class="tentang-gambar-box">
                        <div class="pattern-bg-dots"></div>
                        <img src="{{ asset('img/sekolah.png') }}" alt="SMP Negeri 17 Makassar">
                    </div>
                </div>

                <div class="tentang-teks" data-aos="fade-left">
                    <div class="section-label">Tentang Sekolah</div>
                    <h2 class="section-judul">SMP Negeri 17 Makassar</h2>
                    <p class="tentang-deskripsi">
                        SMP Negeri 17 Makassar adalah sekolah menengah pertama negeri yang berkomitmen dalam menghadirkan
                        pendidikan berkualitas bagi generasi muda Makassar.
                    </p>
                    <p class="tentang-deskripsi">
                        Dengan SIAKAD, proses akademik sekolah kini dikelola secara digital — mulai dari absensi, penilaian,
                        jadwal, hingga monitoring oleh kepala sekolah, semua dalam satu sistem terpadu.
                    </p>
                    <div class="tentang-info-grid">
                        <div class="tentang-info-item">
                            <i data-lucide="map-pin"></i>
                            <span>Makassar, Sulawesi Selatan</span>
                        </div>
                        <div class="tentang-info-item">
                            <i data-lucide="graduation-cap"></i>
                            <span>Kelas 7, 8, dan 9</span>
                        </div>
                        <div class="tentang-info-item">
                            <i data-lucide="clock"></i>
                            <span>Senin — Jumat (Full Day)</span>
                        </div>
                        <div class="tentang-info-item">
                            <i data-lucide="shield-check"></i>
                            <span>Terakreditasi Unggul</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===========================
             SECTION VISI & MISI
        =========================== --}}
        <section class="visimisi-wrapper" id="visimisi">
            <div class="section-isi section-isi-tengah">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-label">Arah & Tujuan</div>
                    <h2 class="section-judul">Visi & Misi</h2>
                </div>

                <div class="visimisi-grid">
                    <div class="visimisi-card visimisi-visi" data-aos="fade-right">
                        <div class="visimisi-card-icon">
                            <i data-lucide="eye"></i>
                        </div>
                        <h3>Visi</h3>
                        <p>
                            Terwujudnya peserta didik yang beriman, berilmu, berkarakter, dan berdaya saing dalam era global
                            berbasis teknologi informasi.
                        </p>
                    </div>

                    <div class="visimisi-card visimisi-misi" data-aos="fade-left">
                        <div class="visimisi-card-icon">
                            <i data-lucide="target"></i>
                        </div>
                        <h3>Misi</h3>
                        <ul class="visimisi-misi-list">
                            <li>Menyelenggarakan pembelajaran yang aktif, kreatif, efektif, dan menyenangkan.</li>
                            <li>Menumbuhkan semangat keunggulan kepada seluruh warga sekolah.</li>
                            <li>Mendorong dan membantu siswa mengenali potensi dirinya.</li>
                            <li>Menerapkan manajemen berbasis sekolah yang partisipatif.</li>
                            <li>Memanfaatkan teknologi informasi dalam proses pembelajaran.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===========================
             SECTION FITUR SISTEM
        =========================== --}}
        <section class="fitur-wrapper" id="fitur">
            <div class="section-isi section-isi-tengah">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-label">Apa yang Kami Hadirkan</div>
                    <h2 class="section-judul">Fitur Unggulan SIAKAD</h2>
                </div>

                <div class="fitur-grid">
                    <div class="fitur-card" data-aos="fade-up" data-aos-delay="0">
                        <div class="fitur-card-icon fitur-icon-kuning"><i data-lucide="qr-code"></i></div>
                        <h3>Presensi QR Code</h3>
                        <p>Absensi siswa cepat dan akurat menggunakan QR Code yang aktif sesuai jadwal pelajaran.</p>
                    </div>

                    <div class="fitur-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="fitur-card-icon fitur-icon-biru"><i data-lucide="book-open"></i></div>
                        <h3>Pengelolaan Nilai</h3>
                        <p>Guru menginput nilai tugas, UTS, dan UAS. Nilai akhir dihitung otomatis oleh sistem.</p>
                    </div>

                    <div class="fitur-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="fitur-card-icon fitur-icon-fuchsia"><i data-lucide="calendar"></i></div>
                        <h3>Jadwal & Kalender</h3>
                        <p>Admin mengatur jadwal pelajaran dan kalender akademik sekolah dalam satu tempat.</p>
                    </div>

                    <div class="fitur-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="fitur-card-icon fitur-icon-hijau"><i data-lucide="bar-chart-2"></i></div>
                        <h3>Monitoring Akademik</h3>
                        <p>Kepala sekolah dapat memantau seluruh kegiatan akademik dan mengekspor laporan.</p>
                    </div>

                    <div class="fitur-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="fitur-card-icon fitur-icon-kuning"><i data-lucide="users"></i></div>
                        <h3>Multi Role Access</h3>
                        <p>Empat role berbeda: Admin, Guru, Siswa, dan Kepala Sekolah dengan hak akses masing-masing.</p>
                    </div>

                    <div class="fitur-card" data-aos="fade-up" data-aos-delay="500">
                        <div class="fitur-card-icon fitur-icon-biru"><i data-lucide="megaphone"></i></div>
                        <h3>Pengumuman Sekolah</h3>
                        <p>Admin dapat membuat pengumuman yang langsung tampil ke seluruh pengguna sistem.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===========================
             SECTION CAROUSEL (DOKUMENTASI/FASILITAS)
        =========================== --}}
        <section class="carousel-section">
            <div class="section-isi section-isi-tengah">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-label">Galeri Sekolah</div>
                    <h2 class="section-judul">Fasilitas & Kegiatan</h2>
                </div>

                <div class="neo-carousel-container" data-aos="fade-up">
                    <div class="neo-carousel-track">
                        <div class="carousel-slide">
                            <img src="{{ asset('img/fasilitas-1.png') }}" alt="Laboratorium Komputer">
                            <div class="slide-badge">LAB KOMPUTER</div>
                        </div>
                        <div class="carousel-slide">
                            <img src="{{ asset('img/fasilitas-2.png') }}" alt="Perpustakaan Digital">
                            <div class="slide-badge">PERPUSTAKAAN</div>
                        </div>
                        <div class="carousel-slide">
                            <img src="{{ asset('img/fasilitas-3.png') }}" alt="Ruang Kelas Nyaman">
                            <div class="slide-badge">RUANG KELAS AI</div>
                        </div>
                        <div class="carousel-slide">
                            <img src="{{ asset('img/fasilitas-4.png') }}" alt="Lapangan Olahraga">
                            <div class="slide-badge">LAPANGAN UTAMA</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===========================
             SECTION PENGUMUMAN
        =========================== --}}
        @if ($daftarPengumuman->count() > 0)
            <section class="pengumuman-wrapper" id="pengumuman">
                <div class="section-isi section-isi-tengah">
                    <div class="section-header" data-aos="fade-up">
                        <div class="section-label">Informasi Terkini</div>
                        <h2 class="section-judul">Pengumuman Sekolah</h2>
                    </div>

                    <div class="pengumuman-grid">
                        @foreach ($daftarPengumuman as $pengumuman)
                            <article class="pengumuman-card" data-aos="fade-up"
                                data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="pengumuman-card-header">
                                    <i data-lucide="bell"></i>
                                    <span class="pengumuman-tanggal">
                                        {{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                <h3 class="pengumuman-judul">{{ $pengumuman->judul }}</h3>
                                <p class="pengumuman-isi">{{ Str::limit($pengumuman->isi, 120) }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- ===========================
             SECTION LOKASI
        =========================== --}}
        <section class="lokasi-wrapper" id="lokasi">
            <div class="section-isi section-isi-tengah">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-label">Temukan Kami</div>
                    <h2 class="section-judul">Lokasi Sekolah</h2>
                </div>

                <div class="lokasi-grid" data-aos="fade-up">
                    <div class="lokasi-info">
                        <div class="lokasi-info-item">
                            <div class="lokasi-info-icon"><i data-lucide="map-pin"></i></div>
                            <div>
                                <strong>Alamat</strong>
                                <p>Jl. Bonto Lebang No.9, Bulo Gading,<br>Kec. Ujung Pandang, Kota Makassar,<br>Sulawesi
                                    Selatan 90111</p>
                            </div>
                        </div>
                        <div class="lokasi-info-item">
                            <div class="lokasi-info-icon"><i data-lucide="clock"></i></div>
                            <div>
                                <strong>Jam Operasional</strong>
                                <p>Senin — Jumat<br>07.00 — 15.00 WITA</p>
                            </div>
                        </div>
                    </div>

                    <div class="lokasi-maps">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.3!2d119.4221!3d-5.1477!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbee0f0b3af1a1f%3A0x1234567890abcdef!2sSMP%20Negeri%2017%20Makassar!5e0!3m2!1sid!2sid!4v1234567890"
                            width="100%" height="340" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" title="Lokasi SMP Negeri 17 Makassar">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- ===========================
         FOOTER
    =========================== --}}
    <footer class="footer-wrapper">
        <div class="footer-isi">
            <div class="footer-brand">
                <img src="{{ asset('img/logo.png') }}" alt="Logo SMPN 17 Makassar">
                <div>
                    <span class="footer-brand-sistem">SIAKAD</span>
                    <span class="footer-brand-sekolah">SMP Negeri 17 Makassar</span>
                </div>
            </div>
            <p class="footer-copy">
                &copy; {{ date('Y') }} SIAKAD SMP Negeri 17 Makassar. Built Tough via Neo-Brutalism Engine.
            </p>
        </div>
    </footer>

@endsection

@push('js')
    <script src="{{ asset('js/welcome.js') }}"></script>
@endpush
