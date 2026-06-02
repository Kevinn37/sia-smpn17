{{-- FILE: resources/views/guru/jadwal/index.blade.php --}}
{{-- Jadwal mengajar guru --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Jadwal Mengajar')
@section('page-title', 'Jadwal Mengajar')

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
    <a href="{{ route('guru.jadwal') }}" class="aktif">
        <i data-lucide="calendar-days"></i> Jadwal Mengajar
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Jadwal Mengajar</h2>
            <p>Daftar jadwal mengajar minggu ini</p>
        </div>
    </div>

    @if ($daftarJadwal->count() > 0)
        <div class="jadwal-hari-grid">
            @foreach ($daftarHari as $hari)
                @if (isset($daftarJadwal[$hari]))
                    <div class="jadwal-hari-section" data-aos="fade-up">

                        <div class="jadwal-hari-header {{ strtolower($hari) }}">
                            <i data-lucide="calendar"></i>
                            <span class="jadwal-hari-nama">{{ $hari }}</span>
                            <span class="neo-badge" style="margin-left:auto; background:#ffffff; color:#111111; border:2px solid #111111;">
                                {{ $daftarJadwal[$hari]->count() }} sesi
                            </span>
                        </div>

                        <div class="jadwal-hari-body">
                            @foreach ($daftarJadwal[$hari] as $jadwal)
                                <div class="jadwal-row">
                                    <div class="jadwal-row-jam">
                                        {{ substr($jadwal->jam_mulai, 0, 5) }} — {{ substr($jadwal->jam_selesai, 0, 5) }}
                                    </div>
                                    <div class="jadwal-row-mapel">
                                        <span class="jadwal-row-mapel-nama">{{ $jadwal->nama_mapel }}</span>
                                        <span class="jadwal-row-mapel-guru">
                                            <i data-lucide="door-open" style="width:12px;height:12px;"></i>
                                            Kelas {{ $jadwal->nama_kelas }}
                                        </span>
                                    </div>
                                    <div class="jadwal-row-aksi">
                                        <a href="{{ route('guru.presensi.manual', $jadwal->id_jadwal) }}" class="neo-btn neo-btn-kuning neo-btn-sm">
                                            <i data-lucide="clipboard-list"></i>
                                            Presensi
                                        </a>
                                        <a href="{{ route('guru.nilai.input', $jadwal->id_jadwal) }}" class="neo-btn neo-btn-biru neo-btn-sm">
                                            <i data-lucide="book-open"></i>
                                            Nilai
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="neo-card">
            <div class="neo-empty">
                <i data-lucide="calendar-days"></i>
                <p>Belum ada jadwal mengajar.</p>
            </div>
        </div>
    @endif

@endsection
