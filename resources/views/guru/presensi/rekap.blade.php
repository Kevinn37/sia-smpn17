{{-- FILE: resources/views/guru/presensi/manual.blade.php --}}
{{-- Form presensi manual oleh guru --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Presensi Manual')
@section('page-title', 'Presensi Manual')

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
            <h2>Presensi Manual</h2>
            <p>{{ $jadwal->nama_mapel }} — Kelas {{ $jadwal->nama_kelas }}</p>
        </div>
        <a href="{{ route('guru.presensi.index') }}" class="neo-btn neo-btn-putih">
            <i data-lucide="arrow-left"></i>
            Kembali
        </a>
    </div>

    {{-- Info jadwal --}}
    <div class="manual-info-bar" data-aos="fade-down">
        <div class="manual-info-item">
            <i data-lucide="book-open"></i>
            <span>{{ $jadwal->nama_mapel }}</span>
        </div>
        <div class="manual-info-item">
            <i data-lucide="door-open"></i>
            <span>Kelas {{ $jadwal->nama_kelas }}</span>
        </div>
        <div class="manual-info-item">
            <i data-lucide="calendar"></i>
            <span>{{ now()->translatedFormat('d F Y') }}</span>
        </div>
        <div class="manual-info-item">
            <i data-lucide="clock"></i>
            <span>{{ substr($jadwal->jam_mulai, 0, 5) }} — {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
        </div>
    </div>

    {{-- Tombol pilih semua --}}
    <div class="manual-pilih-semua">
        <span class="manual-pilih-label">Pilih semua:</span>
        <button type="button" class="neo-btn neo-btn-hijau neo-btn-sm" onclick="pilihSemua('hadir')">
            Semua Hadir
        </button>
        <button type="button" class="neo-btn neo-btn-fuchsia neo-btn-sm" onclick="pilihSemua('alfa')">
            Semua Alfa
        </button>
    </div>

    <div class="neo-card" data-aos="fade-up">

        <form action="{{ route('guru.presensi.manual.simpan') }}" method="POST">
            @csrf
            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">

            <div class="manual-siswa-list">
                @foreach ($daftarSiswa as $index => $siswa)
                    @php
                        $statusAwal = $sudahPresensi[$siswa->id_siswa] ?? 'hadir';
                    @endphp
                    <div class="manual-siswa-item">

                        <div class="manual-siswa-nomor">{{ $index + 1 }}</div>

                        <div class="manual-siswa-avatar">
                            @if ($siswa->foto)
                                <img src="{{ asset('img/siswa/' . $siswa->foto) }}" alt="{{ $siswa->nama }}">
                            @else
                                <div class="manual-siswa-inisial">
                                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="manual-siswa-info">
                            <span class="manual-siswa-nama">{{ $siswa->nama }}</span>
                            <span class="manual-siswa-nis">{{ $siswa->nis }}</span>
                        </div>

                        <div class="manual-status-group">
                            <label class="manual-status-label manual-status-hadir">
                                <input type="radio" name="status[{{ $siswa->id_siswa }}]" value="hadir"
                                    {{ $statusAwal == 'hadir' ? 'checked' : '' }}>
                                <span>Hadir</span>
                            </label>
                            <label class="manual-status-label manual-status-izin">
                                <input type="radio" name="status[{{ $siswa->id_siswa }}]" value="izin"
                                    {{ $statusAwal == 'izin' ? 'checked' : '' }}>
                                <span>Izin</span>
                            </label>
                            <label class="manual-status-label manual-status-sakit">
                                <input type="radio" name="status[{{ $siswa->id_siswa }}]" value="sakit"
                                    {{ $statusAwal == 'sakit' ? 'checked' : '' }}>
                                <span>Sakit</span>
                            </label>
                            <label class="manual-status-label manual-status-alfa">
                                <input type="radio" name="status[{{ $siswa->id_siswa }}]" value="alfa"
                                    {{ $statusAwal == 'alfa' ? 'checked' : '' }}>
                                <span>Alfa</span>
                            </label>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="manual-simpan-bar">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="save"></i>
                    Simpan Presensi
                </button>
                <a href="{{ route('guru.presensi.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection

@push('js')
    <script>
        function pilihSemua(status) {
            const radios = document.querySelectorAll('input[type="radio"][value="' + status + '"]');
            radios.forEach(function(radio) {
                radio.checked = true;
            });
        }
    </script>
@endpush
