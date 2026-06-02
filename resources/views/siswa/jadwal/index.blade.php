@extends('layouts.dashboard')

@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')

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
    <a href="{{ route('siswa.jadwal') }}" class="aktif">
        <i data-lucide="calendar-days"></i> Jadwal
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Jadwal Pelajaran</h2>
            <p>Kelas {{ $siswa->nama_kelas }}</p>
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
                            <span class="neo-badge"
                                style="margin-left:auto; background:#ffffff; color:#111111; border:2px solid #111111;">
                                {{ $daftarJadwal[$hari]->count() }} pelajaran
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
                                        <span class="jadwal-row-mapel-guru">{{ $jadwal->nama_guru }}</span>
                                    </div>
                                    <div class="jadwal-row-kelas">
                                        <span class="neo-badge neo-badge-biru">{{ $jadwal->kode_mapel }}</span>
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
                <p>Belum ada jadwal pelajaran.</p>
            </div>
        </div>
    @endif

@endsection
