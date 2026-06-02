{{-- FILE: resources/views/siswa/presensi/index.blade.php --}}
{{-- Halaman presensi siswa + scan QR --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Presensi')
@section('page-title', 'Presensi')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('siswa.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('siswa.presensi.index') }}" class="aktif">
        <i data-lucide="qr-code"></i> Presensi
    </a>
    <a href="{{ route('siswa.nilai') }}">
        <i data-lucide="book-open"></i> Nilai
    </a>
    <a href="{{ route('siswa.jadwal') }}">
        <i data-lucide="calendar-days"></i> Jadwal
    </a>
    <span class="sidebar-nav-label">Akun</span>
    <a href="{{ route('siswa.profil') }}">
        <i data-lucide="user"></i> Profil Saya
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/siswa-presensi.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Presensi</h2>
            <p>Scan QR Code untuk mencatat kehadiran</p>
        </div>
        <a href="{{ route('siswa.presensi.rekap') }}" class="neo-btn neo-btn-putih">
            <i data-lucide="bar-chart-2"></i>
            Rekap Lengkap
        </a>
    </div>

    {{-- Rekap bulan ini --}}
    <div class="siswa-rekap-row" data-aos="fade-up">
        <div class="siswa-rekap-card siswa-rekap-hadir">
            <span class="siswa-rekap-angka">{{ $rekapBulanIni['hadir'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Hadir</span>
        </div>
        <div class="siswa-rekap-card siswa-rekap-izin">
            <span class="siswa-rekap-angka">{{ $rekapBulanIni['izin'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Izin</span>
        </div>
        <div class="siswa-rekap-card siswa-rekap-sakit">
            <span class="siswa-rekap-angka">{{ $rekapBulanIni['sakit'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Sakit</span>
        </div>
        <div class="siswa-rekap-card siswa-rekap-alfa">
            <span class="siswa-rekap-angka">{{ $rekapBulanIni['alfa'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Alfa</span>
        </div>
    </div>

    {{-- Area Scan QR --}}
    <div class="scan-wrapper" data-aos="fade-up">

        {{-- Tab pilihan --}}
        <div class="scan-tab-wrapper">
            <button class="scan-tab aktif" id="tab-kamera" onclick="gantiTab('kamera')">
                <i data-lucide="camera"></i>
                Scan Kamera
            </button>
            <button class="scan-tab" id="tab-manual" onclick="gantiTab('manual')">
                <i data-lucide="keyboard"></i>
                Input Manual
            </button>
        </div>

        {{-- Panel Scan Kamera --}}
        <div class="scan-panel" id="panel-kamera">
            <div class="scan-kamera-info">
                <i data-lucide="info"></i>
                <span>Arahkan kamera ke QR Code yang ditampilkan guru</span>
            </div>
            <div class="scan-kamera-box">
                <div id="qr-reader"></div>
                <div class="scan-kamera-overlay">
                    <div class="scan-kamera-frame"></div>
                </div>
            </div>
            <button class="neo-btn neo-btn-biru scan-btn-kamera" id="btn-mulai-scan" onclick="mulaiScan()">
                <i data-lucide="camera"></i>
                Mulai Scan
            </button>
            <button class="neo-btn neo-btn-fuchsia scan-btn-kamera" id="btn-stop-scan" onclick="stopScan()"
                style="display:none;">
                <i data-lucide="x"></i>
                Stop Scan
            </button>
        </div>

        {{-- Panel Input Manual --}}
        <div class="scan-panel" id="panel-manual" style="display:none;">
            <div class="scan-manual-info">
                <i data-lucide="info"></i>
                <span>Masukkan token QR yang diberikan guru jika kamera tidak tersedia</span>
            </div>
            <form action="{{ route('siswa.presensi.scan') }}" method="GET" class="scan-manual-form">
                <div class="scan-manual-input-wrapper">
                    <input type="text" name="token" class="neo-input scan-manual-input"
                        placeholder="Masukkan token QR..." required autofocus>
                    <button type="submit" class="neo-btn neo-btn-biru">
                        <i data-lucide="send"></i>
                        Kirim
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Riwayat presensi terbaru --}}
    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="clipboard-list"></i>
                Riwayat Kehadiran Terbaru
            </h3>
        </div>

        @if ($daftarPresensi->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Mata Pelajaran</th>
                            <th>Status</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarPresensi as $presensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $presensi->nama_mapel }}</td>
                                <td>
                                    <span class="neo-badge neo-badge-{{ $presensi->status }}">
                                        {{ ucfirst($presensi->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="neo-badge {{ $presensi->metode == 'qr' ? 'neo-badge-hijau' : 'neo-badge-kuning' }}">
                                        {{ strtoupper($presensi->metode) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="clipboard-list"></i>
                <p>Belum ada data presensi.</p>
            </div>
        @endif

    </div>

@endsection

@push('js')
    {{-- Library html5-qrcode --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <script src="{{ asset('js/siswa-scan.js') }}"></script>

    @if (session('sukses'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('sukses') }}',
                    timer: 2500,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif

    @if (session('gagal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('gagal') }}',
                    timer: 3000,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif
@endpush
