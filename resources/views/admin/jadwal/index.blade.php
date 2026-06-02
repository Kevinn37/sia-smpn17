@extends('layouts.dashboard')

@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')

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
    <a href="{{ route('admin.jadwal.index') }}" class="aktif">
        <i data-lucide="calendar-days"></i> Jadwal Pelajaran
    </a>
    <a href="{{ route('admin.kalender.index') }}">
        <i data-lucide="calendar"></i> Kalender Akademik
    </a>
    <a href="{{ route('admin.pengumuman.index') }}">
        <i data-lucide="megaphone"></i> Pengumuman
    </a>
    <span class="sidebar-nav-label">Laporan</span>
    <a href="{{ route('admin.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Jadwal Pelajaran</h2>
            <p>Kelola jadwal mengajar seluruh kelas</p>
        </div>
        <a href="{{ route('admin.jadwal.tambah') }}" class="neo-btn neo-btn-kuning">
            <i data-lucide="plus"></i>
            Tambah Jadwal
        </a>
    </div>

    {{-- Filter --}}
    <div class="neo-card filter-card">
        <form action="{{ route('admin.jadwal.index') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Filter Kelas</label>
                <select name="id_kelas" class="neo-select">
                    <option value="">Semua Kelas</option>
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ $id_kelas == $kelas->id_kelas ? 'selected' : '' }}>
                            Kelas {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label class="neo-label">Filter Hari</label>
                <select name="hari" class="neo-select">
                    <option value="">Semua Hari</option>
                    @foreach ($daftarHari as $h)
                        <option value="{{ $h }}" {{ $hari == $h ? 'selected' : '' }}>
                            {{ $h }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Filter
                </button>
                <a href="{{ route('admin.jadwal.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel jadwal --}}
    <div class="neo-card" data-aos="fade-up">

        <div class="neo-card-header">
            <h3>
                <i data-lucide="calendar-days"></i>
                Daftar Jadwal
            </h3>
            <span class="neo-badge neo-badge-hadir">
                {{ $daftarJadwal->count() }} jadwal
            </span>
        </div>

        @if ($daftarJadwal->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarJadwal as $jadwal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="neo-badge jadwal-badge-{{ strtolower($jadwal->hari) }}">
                                        {{ $jadwal->hari }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ substr($jadwal->jam_mulai, 0, 5) }}</strong>
                                    —
                                    {{ substr($jadwal->jam_selesai, 0, 5) }}
                                </td>
                                <td>
                                    <span class="neo-badge neo-badge-hadir">
                                        {{ $jadwal->nama_kelas }}
                                    </span>
                                </td>
                                <td>
                                    <span class="neo-badge neo-badge-biru">{{ $jadwal->kode_mapel }}</span>
                                    {{ $jadwal->nama_mapel }}
                                </td>
                                <td>{{ $jadwal->nama_guru }}</td>
                                <td>
                                    <div class="tabel-aksi">
                                        <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal) }}"
                                            class="neo-btn neo-btn-kuning neo-btn-sm">
                                            <i data-lucide="pencil"></i>
                                            Edit
                                        </a>
                                        <form id="form-hapus-{{ $jadwal->id_jadwal }}"
                                            action="{{ route('admin.jadwal.hapus', $jadwal->id_jadwal) }}" method="POST">
                                            @csrf
                                            <button type="button" class="neo-btn neo-btn-fuchsia neo-btn-sm"
                                                onclick="konfirmasiHapus('form-hapus-{{ $jadwal->id_jadwal }}')">
                                                <i data-lucide="trash-2"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="calendar-days"></i>
                <p>Belum ada jadwal pelajaran.</p>
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
