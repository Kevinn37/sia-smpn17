@extends('layouts.dashboard')

@section('title', 'Nilai Siswa')
@section('page-title', 'Nilai Siswa')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('guru.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('guru.presensi.index') }}">
        <i data-lucide="clipboard-list"></i> Presensi
    </a>
    <a href="{{ route('guru.nilai.index') }}" class="aktif">
        <i data-lucide="book-open"></i> Nilai Siswa
    </a>
    <a href="{{ route('guru.jadwal') }}">
        <i data-lucide="calendar-days"></i> Jadwal Mengajar
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/nilai.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Nilai Siswa</h2>
            <p>Pilih kelas untuk menginput nilai</p>
        </div>
    </div>

    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="book-open"></i>
                Pilih Jadwal
            </h3>
        </div>

        @if ($daftarJadwal->count() > 0)
            <div class="nilai-jadwal-grid">
                @foreach ($daftarJadwal as $jadwal)
                    <a href="{{ route('guru.nilai.input', $jadwal->id_jadwal) }}" class="nilai-jadwal-card">
                        <div class="nilai-jadwal-hari nilai-hari-{{ strtolower($jadwal->hari) }}">
                            {{ $jadwal->hari }}
                        </div>
                        <div class="nilai-jadwal-body">
                            <span class="nilai-jadwal-kode">{{ $jadwal->kode_mapel }}</span>
                            <span class="nilai-jadwal-mapel">{{ $jadwal->nama_mapel }}</span>
                            <span class="nilai-jadwal-kelas">
                                <i data-lucide="door-open"></i>
                                Kelas {{ $jadwal->nama_kelas }}
                            </span>
                            <span class="nilai-jadwal-jam">
                                {{ substr($jadwal->jam_mulai, 0, 5) }} — {{ substr($jadwal->jam_selesai, 0, 5) }}
                            </span>
                        </div>
                        <div class="nilai-jadwal-arrow">
                            <i data-lucide="arrow-right"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="book-open"></i>
                <p>Belum ada jadwal mengajar.</p>
            </div>
        @endif

    </div>

@endsection
