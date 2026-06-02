{{-- FILE: resources/views/guru/presensi/index.blade.php --}}
{{-- Halaman utama presensi guru --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Presensi')
@section('page-title', 'Presensi')

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
            <h2>Presensi Siswa</h2>
            <p>Kelola presensi QR Code dan manual</p>
        </div>
        <a href="{{ route('guru.presensi.rekap') }}" class="neo-btn neo-btn-putih">
            <i data-lucide="bar-chart-2"></i>
            Rekap Presensi
        </a>
    </div>

    {{-- Sesi aktif --}}
    @if ($sesiAktif)
        <div class="presensi-sesi-aktif" data-aos="fade-down">
            <div class="presensi-sesi-aktif-info">
                <div class="presensi-sesi-aktif-icon">
                    <i data-lucide="radio"></i>
                </div>
                <div>
                    <span class="presensi-sesi-aktif-label">Sesi QR Aktif Sekarang</span>
                    <span class="presensi-sesi-aktif-detail">
                        {{ $sesiAktif->nama_mapel }} — Kelas {{ $sesiAktif->nama_kelas }}
                    </span>
                </div>
            </div>
            <div class="presensi-sesi-aktif-aksi">
                <a href="{{ route('guru.presensi.tampilQr', ['token' => $sesiAktif->token_qr]) }}" class="neo-btn neo-btn-kuning">
                    <i data-lucide="qr-code"></i>
                    Lihat QR
                </a>
                <form action="{{ route('guru.presensi.tutup-sesi', $sesiAktif->id_sesi) }}" method="POST" id="form-tutup-sesi">
                    @csrf
                    <button type="button" class="neo-btn neo-btn-fuchsia" onclick="konfirmasiTutupSesi()">
                        <i data-lucide="x-circle"></i>
                        Tutup Sesi
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- Rekap hari ini --}}
    <div class="presensi-rekap-row" data-aos="fade-up">
        <div class="presensi-rekap-card presensi-rekap-hadir">
            <span class="presensi-rekap-angka">{{ $rekapHariIni['hadir'] ?? 0 }}</span>
            <span class="presensi-rekap-label">Hadir</span>
        </div>
        <div class="presensi-rekap-card presensi-rekap-izin">
            <span class="presensi-rekap-angka">{{ $rekapHariIni['izin'] ?? 0 }}</span>
            <span class="presensi-rekap-label">Izin</span>
        </div>
        <div class="presensi-rekap-card presensi-rekap-sakit">
            <span class="presensi-rekap-angka">{{ $rekapHariIni['sakit'] ?? 0 }}</span>
            <span class="presensi-rekap-label">Sakit</span>
        </div>
        <div class="presensi-rekap-card presensi-rekap-alfa">
            <span class="presensi-rekap-angka">{{ $rekapHariIni['alfa'] ?? 0 }}</span>
            <span class="presensi-rekap-label">Alfa</span>
        </div>
    </div>

    {{-- Pilih jadwal untuk presensi --}}
    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="calendar-days"></i>
                Pilih Jadwal untuk Presensi
            </h3>
        </div>

        @if ($daftarJadwal->count() > 0)
            <div class="presensi-jadwal-grid">
                @foreach ($daftarJadwal as $jadwal)
                    <div class="presensi-jadwal-card">

                        <div class="presensi-jadwal-hari presensi-hari-{{ strtolower($jadwal->hari) }}">
                            {{ $jadwal->hari }}
                        </div>

                        <div class="presensi-jadwal-info">
                            <span class="presensi-jadwal-mapel">{{ $jadwal->nama_mapel }}</span>
                            <span class="presensi-jadwal-kelas">Kelas {{ $jadwal->nama_kelas }}</span>
                            <span class="presensi-jadwal-jam">
                                {{ substr($jadwal->jam_mulai, 0, 5) }} — {{ substr($jadwal->jam_selesai, 0, 5) }}
                            </span>
                        </div>

                        <div class="presensi-jadwal-aksi">
                            {{-- Tombol QR --}}
                            <form action="{{ route('guru.presensi.buka-sesi') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">
                                <button type="submit" class="neo-btn neo-btn-biru neo-btn-sm">
                                    <i data-lucide="qr-code"></i>
                                    QR
                                </button>
                            </form>

                            {{-- Tombol Manual --}}
                            <a href="{{ route('guru.presensi.manual', $jadwal->id_jadwal) }}" class="neo-btn neo-btn-kuning neo-btn-sm">
                                <i data-lucide="pencil"></i>
                                Manual
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="calendar-days"></i>
                <p>Belum ada jadwal mengajar.</p>
            </div>
        @endif

    </div>

@endsection

@push('js')
    @if (session('sukses'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon              : 'success',
                    title             : '{{ session('sukses') }}',
                    timer             : 2000,
                    showConfirmButton : false,
                });
            });
        </script>
    @endif
    @if (session('gagal'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon              : 'error',
                    title             : '{{ session('gagal') }}',
                    timer             : 3000,
                    showConfirmButton : false,
                });
            });
        </script>
    @endif
    <script>
        function konfirmasiTutupSesi() {
            Swal.fire({
                title             : 'Tutup sesi presensi?',
                text              : 'Siswa yang belum scan akan dicatat sebagai alfa.',
                icon              : 'warning',
                showCancelButton  : true,
                confirmButtonText : 'Ya, tutup',
                cancelButtonText  : 'Batal',
                confirmButtonColor: '#d234b0',
                cancelButtonColor : '#111111',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-tutup-sesi').submit();
                }
            });
        }
    </script>
@endpush
