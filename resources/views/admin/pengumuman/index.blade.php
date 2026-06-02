@extends('layouts.dashboard')

@section('title', 'Pengumuman')
@section('page-title', 'Pengumuman')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('admin.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Data Sekolah</span>
    <a href="{{ route('admin.siswa.index') }}">
        <i data-lucide="users"></i> Data Siswa
    </a>
    <a href="{{ route('admin.guru.index') }}">
        <i data-lucide="user-tie"></i> Data Guru
    </a>
    <a href="{{ route('admin.kelas.index') }}">
        <i data-lucide="door-open"></i> Data Kelas
    </a>
    <a href="{{ route('admin.mapel.index') }}">
        <i data-lucide="book"></i> Mata Pelajaran
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('admin.jadwal.index') }}">
        <i data-lucide="calendar-days"></i> Jadwal Pelajaran
    </a>
    <a href="{{ route('admin.kalender.index') }}">
        <i data-lucide="calendar"></i> Kalender Akademik
    </a>
    <a href="{{ route('admin.pengumuman.index') }}" class="aktif">
        <i data-lucide="megaphone"></i> Pengumuman
    </a>
    <span class="sidebar-nav-label">Laporan</span>
    <a href="{{ route('admin.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengumuman.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Pengumuman</h2>
            <p>Kelola pengumuman untuk siswa dan guru</p>
        </div>
        <a href="{{ route('admin.pengumuman.tambah') }}" class="neo-btn neo-btn-kuning">
            <i data-lucide="plus"></i>
            Buat Pengumuman
        </a>
    </div>

    {{-- Filter --}}
    <div class="neo-card filter-card">
        <form action="{{ route('admin.pengumuman.index') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Filter Ditujukan</label>
                <select name="ditujukan" class="neo-select">
                    <option value="">Semua</option>
                    <option value="semua" {{ $ditujukan == 'semua' ? 'selected' : '' }}>Semua Pengguna</option>
                    <option value="siswa" {{ $ditujukan == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ $ditujukan == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Filter
                </button>
                <a href="{{ route('admin.pengumuman.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Daftar pengumuman --}}
    <div class="neo-card" data-aos="fade-up">

        <div class="neo-card-header">
            <h3>
                <i data-lucide="megaphone"></i>
                Daftar Pengumuman
            </h3>
            <span class="neo-badge neo-badge-hadir">
                {{ $daftarPengumuman->count() }} pengumuman
            </span>
        </div>

        @if ($daftarPengumuman->count() > 0)
            <div class="pengumuman-admin-list">
                @foreach ($daftarPengumuman as $pengumuman)
                    @php
                        // Cek status aktif atau kadaluarsa
                        $aktif =
                            \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->lte(now()) &&
                            (is_null($pengumuman->tanggal_berakhir) ||
                                \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->gte(now()));
                    @endphp

                    <div class="pengumuman-admin-item {{ $aktif ? 'pengumuman-aktif' : 'pengumuman-nonaktif' }}">

                        <div class="pengumuman-admin-kiri">
                            <div class="pengumuman-admin-tanggal">
                                <span>{{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->format('d') }}</span>
                                <span>{{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->translatedFormat('M Y') }}</span>
                            </div>
                        </div>

                        <div class="pengumuman-admin-isi">
                            <div class="pengumuman-admin-meta">
                                <span class="neo-badge pengumuman-badge-{{ $pengumuman->ditujukan }}">
                                    {{ ucfirst($pengumuman->ditujukan) }}
                                </span>
                                <span class="neo-badge {{ $aktif ? 'neo-badge-hadir' : 'neo-badge-alfa' }}">
                                    {{ $aktif ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <h3 class="pengumuman-admin-judul">{{ $pengumuman->judul }}</h3>
                            <p class="pengumuman-admin-teks">{{ Str::limit($pengumuman->isi, 150) }}</p>
                            <span class="pengumuman-admin-berakhir">
                                @if ($pengumuman->tanggal_berakhir)
                                    Berakhir:
                                    {{ \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->translatedFormat('d F Y') }}
                                @else
                                    Tayang permanen
                                @endif
                            </span>
                        </div>

                        <div class="pengumuman-admin-aksi">
                            <a href="{{ route('admin.pengumuman.edit', $pengumuman->id_pengumuman) }}"
                                class="neo-btn neo-btn-kuning neo-btn-sm">
                                <i data-lucide="pencil"></i>
                                Edit
                            </a>
                            <form id="form-hapus-{{ $pengumuman->id_pengumuman }}"
                                action="{{ route('admin.pengumuman.hapus', $pengumuman->id_pengumuman) }}" method="POST">
                                @csrf
                                <button type="button" class="neo-btn neo-btn-fuchsia neo-btn-sm"
                                    onclick="konfirmasiHapus('form-hapus-{{ $pengumuman->id_pengumuman }}')">
                                    <i data-lucide="trash-2"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="megaphone"></i>
                <p>Belum ada pengumuman.</p>
            </div>
        @endif

    </div>

@endsection

@push('js')
    @if (session('sukses'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('sukses') }}',
                    timer: 2000,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif
@endpush
