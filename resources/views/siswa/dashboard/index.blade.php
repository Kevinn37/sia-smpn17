{{-- FILE: resources/views/siswa/dashboard/index.blade.php --}}
{{-- Dashboard utama siswa --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('siswa.dashboard') }}" class="aktif">
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
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/siswa-dashboard.css') }}">
@endpush

@section('konten')

    {{-- Kartu profil siswa --}}
    <div class="siswa-profil-card" data-aos="fade-right">
        <div class="siswa-profil-foto">
            @if ($siswa->foto)
                <img src="{{ asset('img/siswa/' . $siswa->foto) }}" alt="{{ $siswa->nama }}">
            @else
                <div class="siswa-profil-inisial">
                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="siswa-profil-info">
            <h2>{{ $siswa->nama }}</h2>
            <div class="siswa-profil-meta">
                <span>
                    <i data-lucide="hash"></i>
                    {{ $siswa->nis }}
                </span>
                <span>
                    <i data-lucide="door-open"></i>
                    Kelas {{ $siswa->nama_kelas }}
                </span>
                <span>
                    <i data-lucide="calendar"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Rekap kehadiran bulan ini --}}
    <div class="siswa-rekap-grid" data-aos="fade-up">
        <div class="siswa-rekap-item siswa-rekap-hadir">
            <span class="siswa-rekap-angka">{{ $rekapHadir['hadir'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Hadir</span>
        </div>
        <div class="siswa-rekap-item siswa-rekap-izin">
            <span class="siswa-rekap-angka">{{ $rekapHadir['izin'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Izin</span>
        </div>
        <div class="siswa-rekap-item siswa-rekap-sakit">
            <span class="siswa-rekap-angka">{{ $rekapHadir['sakit'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Sakit</span>
        </div>
        <div class="siswa-rekap-item siswa-rekap-alfa">
            <span class="siswa-rekap-angka">{{ $rekapHadir['alfa'] ?? 0 }}</span>
            <span class="siswa-rekap-label">Alfa</span>
        </div>
    </div>

    <div class="siswa-grid-2">

        {{-- Jadwal hari ini --}}
        <div class="neo-card" data-aos="fade-up">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="calendar-days"></i>
                    Jadwal Hari Ini
                </h3>
                <span class="neo-badge neo-badge-biru">
                    {{ now()->translatedFormat('l') }}
                </span>
            </div>

            @if (count($jadwalHariIni) > 0)
                <div class="siswa-jadwal-list">
                    @foreach ($jadwalHariIni as $jadwal)
                        <div class="siswa-jadwal-item">
                            <div class="siswa-jadwal-jam">
                                {{ substr($jadwal->jam_mulai, 0, 5) }}
                                <span>—</span>
                                {{ substr($jadwal->jam_selesai, 0, 5) }}
                            </div>
                            <div class="siswa-jadwal-info">
                                <span class="siswa-jadwal-mapel">{{ $jadwal->nama_mapel }}</span>
                                <span class="siswa-jadwal-guru">{{ $jadwal->nama_guru }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="neo-empty">
                    <i data-lucide="coffee"></i>
                    <p>Tidak ada jadwal hari ini.</p>
                </div>
            @endif
        </div>

        {{-- Nilai terbaru --}}
        <div class="neo-card" data-aos="fade-up">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="book-open"></i>
                    Nilai Terbaru
                </h3>
                <a href="{{ route('siswa.nilai') }}" class="neo-btn neo-btn-kuning neo-btn-sm">
                    Lihat Semua
                </a>
            </div>

            @if ($daftarNilai->count() > 0)
                <div class="siswa-nilai-list">
                    @foreach ($daftarNilai as $nilai)
                        @php
                            $na = $nilai->nilai_akhir;
                            $predikat = $na
                                ? ($na >= 90
                                    ? 'A'
                                    : ($na >= 80
                                        ? 'B'
                                        : ($na >= 70
                                            ? 'C'
                                            : ($na >= 60
                                                ? 'D'
                                                : 'E'))))
                                : '-';
                        @endphp
                        <div class="siswa-nilai-item">
                            <div class="siswa-nilai-kode">{{ $nilai->kode_mapel }}</div>
                            <div class="siswa-nilai-info">
                                <span class="siswa-nilai-mapel">{{ $nilai->nama_mapel }}</span>
                            </div>
                            <div
                                class="siswa-nilai-angka {{ $na ? ($na >= 80 ? 'nilai-hijau' : ($na >= 70 ? 'nilai-kuning' : 'nilai-merah')) : '' }}">
                                {{ $na ?? '—' }}
                            </div>
                            <div class="siswa-nilai-predikat">{{ $predikat }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="neo-empty">
                    <i data-lucide="book-open"></i>
                    <p>Belum ada data nilai.</p>
                </div>
            @endif
        </div>

    </div>

    {{-- Pengumuman --}}
    @if ($daftarPengumuman->count() > 0)
        <div class="neo-card" data-aos="fade-up">
            <div class="neo-card-header">
                <h3>
                    <i data-lucide="megaphone"></i>
                    Pengumuman Terbaru
                </h3>
            </div>
            <div class="siswa-pengumuman-list">
                @foreach ($daftarPengumuman as $pengumuman)
                    <div class="siswa-pengumuman-item">
                        <div class="siswa-pengumuman-tgl">
                            <span>{{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->format('d') }}</span>
                            <span>{{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->translatedFormat('M') }}</span>
                        </div>
                        <div class="siswa-pengumuman-isi">
                            <span class="siswa-pengumuman-judul">{{ $pengumuman->judul }}</span>
                            <span class="siswa-pengumuman-teks">{{ Str::limit($pengumuman->isi, 100) }}</span>
                            <span class="sidebar-nav-label">Akun</span>
                            <a href="{{ route('guru.profil') }}">
                                <i data-lucide="user"></i> Profil Saya
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection
