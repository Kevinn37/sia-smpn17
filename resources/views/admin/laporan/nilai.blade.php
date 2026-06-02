{{-- FILE: resources/views/admin/laporan/nilai.blade.php --}}
{{-- Laporan nilai siswa --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

@extends('layouts.dashboard')

@section('title', 'Laporan Nilai')
@section('page-title', 'Laporan Nilai')

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
    <a href="{{ route('admin.pengumuman.index') }}">
        <i data-lucide="megaphone"></i> Pengumuman
    </a>
    <span class="sidebar-nav-label">Laporan</span>
    <a href="{{ route('admin.laporan.index') }}" class="aktif">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Laporan Nilai</h2>
            <p>Data nilai siswa seluruh kelas dan mata pelajaran</p>
        </div>
        <div class="laporan-header-aksi">
            <a href="{{ route('admin.laporan.index') }}" class="neo-btn neo-btn-putih">
                <i data-lucide="arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.laporan.export.nilai', ['id_kelas' => $id_kelas, 'id_mapel' => $id_mapel, 'semester' => $semester]) }}"
                class="neo-btn neo-btn-hijau">
                <i data-lucide="download"></i>
                Export CSV
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="neo-card filter-card">
        <form action="{{ route('admin.laporan.nilai') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Kelas</label>
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
                <label class="neo-label">Mata Pelajaran</label>
                <select name="id_mapel" class="neo-select">
                    <option value="">Semua Mapel</option>
                    @foreach ($daftarMapel as $mapel)
                        <option value="{{ $mapel->id_mapel }}" {{ $id_mapel == $mapel->id_mapel ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label class="neo-label">Semester</label>
                <select name="semester" class="neo-select">
                    <option value="">Semua Semester</option>
                    <option value="1" {{ $semester == '1' ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ $semester == '2' ? 'selected' : '' }}>Semester 2</option>
                </select>
            </div>
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Filter
                </button>
                <a href="{{ route('admin.laporan.nilai') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel nilai --}}
    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="book-open"></i>
                Data Nilai
            </h3>
            <span class="neo-badge neo-badge-hadir">
                {{ $daftarNilai->count() }} data
            </span>
        </div>

        @if ($daftarNilai->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Smt</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Akhir</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarNilai as $nilai)
                            @php
                                $na = $nilai->nilai_akhir;
                                $predikat =
                                    $na >= 90 ? 'A' : ($na >= 80 ? 'B' : ($na >= 70 ? 'C' : ($na >= 60 ? 'D' : 'E')));
                                $badgePredikat =
                                    $na >= 80 ? 'neo-badge-hijau' : ($na >= 70 ? 'neo-badge-kuning' : 'neo-badge-alfa');
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nilai->nis }}</td>
                                <td>{{ $nilai->nama_siswa }}</td>
                                <td>
                                    <span class="neo-badge neo-badge-biru">{{ $nilai->nama_kelas }}</span>
                                </td>
                                <td>{{ $nilai->nama_mapel }}</td>
                                <td>{{ $nilai->semester }}</td>
                                <td>{{ $nilai->nilai_tugas ?? '-' }}</td>
                                <td>{{ $nilai->nilai_uts ?? '-' }}</td>
                                <td>{{ $nilai->nilai_uas ?? '-' }}</td>
                                <td><strong>{{ $nilai->nilai_akhir ?? '-' }}</strong></td>
                                <td>
                                    @if ($nilai->nilai_akhir)
                                        <span class="neo-badge {{ $badgePredikat }}">{{ $predikat }}</span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="neo-empty">
                <i data-lucide="book-open"></i>
                <p>Belum ada data nilai.</p>
            </div>
        @endif
    </div>

@endsection
