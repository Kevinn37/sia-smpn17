@extends('layouts.dashboard')

@section('title', 'QR Presensi')
@section('page-title', 'QR Presensi')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('guru.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('guru.presensi.index') }}" class="aktif">
        <i data-lucide="clipboard-list"></i> Presensi
    </a>
    <a href="{{ route('guru.nilai.index') }}">
        <i data-lucide="book-open"></i> Nilai Siswa
    </a>
    <a href="{{ route('guru.jadwal') }}">
        <i data-lucide="calendar-days"></i> Jadwal Mengajar
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/presensi.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>QR Code Presensi</h2>
            <p>{{ $sesi->nama_mapel }} — Kelas {{ $sesi->nama_kelas }}</p>
        </div>
        <div style="display:flex; gap:0.5rem;">
            <a href="{{ route('guru.presensi.index') }}" class="neo-btn neo-btn-putih">
                <i data-lucide="arrow-left"></i>
                Kembali
            </a>
            <form action="{{ route('guru.presensi.tutup-sesi', $sesi->id_sesi) }}" method="POST" id="form-tutup">
                @csrf
                <button type="button" class="neo-btn neo-btn-fuchsia" onclick="konfirmasiTutup()">
                    <i data-lucide="x-circle"></i>
                    Tutup Sesi
                </button>
            </form>
        </div>
    </div>

    <div class="qr-wrapper">

        {{-- QR Code --}}
        <div class="qr-box" data-aos="zoom-in">
            <div class="qr-box-header">
                <i data-lucide="qr-code"></i>
                <span>Scan QR Code untuk Presensi</span>
            </div>

            <div class="qr-code-area" id="qr-code-area">
                {{-- QR Code dirender oleh JS --}}
            </div>

            <div class="qr-box-info">
                <div class="qr-info-item">
                    <i data-lucide="book-open"></i>
                    <span>{{ $sesi->nama_mapel }}</span>
                </div>
                <div class="qr-info-item">
                    <i data-lucide="door-open"></i>
                    <span>Kelas {{ $sesi->nama_kelas }}</span>
                </div>
                <div class="qr-info-item">
                    <i data-lucide="calendar"></i>
                    <span>{{ \Carbon\Carbon::parse($sesi->tanggal)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="qr-info-item">
                    <i data-lucide="clock"></i>
                    <span id="jam-sekarang">--:--:--</span>
                </div>
            </div>

            <div class="qr-counter">
                <span class="qr-counter-hadir">{{ $daftarHadir->count() }}</span>
                <span class="qr-counter-label">/ {{ $totalSiswaKelas }} siswa hadir</span>
            </div>
        </div>

        {{-- Daftar siswa yang sudah scan --}}
        <div class="qr-hadir-box" data-aos="fade-left">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="users"></i>
                    Siswa yang Sudah Hadir
                </h3>
                <span class="neo-badge neo-badge-hadir">
                    {{ $daftarHadir->count() }} siswa
                </span>
            </div>

            @if ($daftarHadir->count() > 0)
                <div class="qr-hadir-list">
                    @foreach ($daftarHadir as $hadir)
                        <div class="qr-hadir-item">
                            <div class="qr-hadir-avatar">
                                {{ strtoupper(substr($hadir->nama, 0, 1)) }}
                            </div>
                            <div class="qr-hadir-info">
                                <span class="qr-hadir-nama">{{ $hadir->nama }}</span>
                                <span class="qr-hadir-nis">{{ $hadir->nis }}</span>
                            </div>
                            <span class="qr-hadir-waktu">
                                {{ \Carbon\Carbon::parse($hadir->waktu_scan)->format('H:i') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="neo-empty">
                    <i data-lucide="clock"></i>
                    <p>Menunggu siswa scan QR...</p>
                </div>
            @endif
        </div>

    </div>

@endsection

@push('js')
    {{-- Library QR Code --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="{{ asset('js/presensi-qr.js') }}"></script>
    <script>
        // Data token untuk QR — URL scan siswa
        const tokenQr = '{{ $sesi->token_qr }}';
        const urlScan = '{{ route('siswa.presensi.scan') }}';
        const idSesi = {{ $sesi->id_sesi }};

        // Generate QR Code
        new QRCode(document.getElementById('qr-code-area'), {
            text: urlScan + '?token=' + tokenQr,
            width: 260,
            height: 260,
            colorDark: '#111111',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M,
        });

        // Konfirmasi tutup sesi
        function konfirmasiTutup() {
            Swal.fire({
                title: 'Tutup sesi presensi?',
                text: 'Siswa yang belum scan akan dicatat sebagai alfa.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, tutup',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d234b0',
                cancelButtonColor: '#111111',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-tutup').submit();
                }
            });
        }
    </script>
@endpush
