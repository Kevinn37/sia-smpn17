@extends('layouts.dashboard')

@section('title', 'Monitoring Nilai')
@section('page-title', 'Monitoring Nilai')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('kepala-sekolah.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Monitoring</span>
    <a href="{{ route('kepala-sekolah.monitoring.presensi') }}">
        <i data-lucide="clipboard-list"></i> Presensi
    </a>
    <a href="{{ route('kepala-sekolah.monitoring.nilai') }}" class="aktif">
        <i data-lucide="book-open"></i> Nilai
    </a>
    <a href="{{ route('kepala-sekolah.monitoring.guru') }}">
        <i data-lucide="user-tie"></i> Guru
    </a>
    <a href="{{ route('kepala-sekolah.monitoring.siswa') }}">
        <i data-lucide="users"></i> Siswa
    </a>
    <span class="sidebar-nav-label">Laporan</span>
    <a href="{{ route('kepala-sekolah.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kepsek-monitoring.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Monitoring Nilai</h2>
            <p>Data nilai siswa seluruh kelas dan mata pelajaran</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="neo-card filter-card">
        <form action="{{ route('kepala-sekolah.monitoring.nilai') }}" method="GET" class="filter-form">
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
            <div class="filter-aksi">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Filter
                </button>
                <a href="{{ route('kepala-sekolah.monitoring.nilai') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="book-open"></i>
                Data Nilai Siswa
            </h3>
            <span class="neo-badge neo-badge-hadir">{{ $daftarNilai->count() }} data</span>
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
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Nilai Akhir</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                $badgeClass = $na
                                    ? ($na >= 80
                                        ? 'neo-badge-hijau'
                                        : ($na >= 70
                                            ? 'neo-badge-kuning'
                                            : 'neo-badge-alfa'))
                                    : '';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nilai->nis }}</td>
                                <td>{{ $nilai->nama_siswa }}</td>
                                <td><span class="neo-badge neo-badge-biru">{{ $nilai->nama_kelas }}</span></td>
                                <td>{{ $nilai->nama_mapel }}</td>
                                <td>{{ $nilai->nilai_tugas ?? '—' }}</td>
                                <td>{{ $nilai->nilai_uts ?? '—' }}</td>
                                <td>{{ $nilai->nilai_uas ?? '—' }}</td>
                                <td><strong>{{ $na ?? '—' }}</strong></td>
                                <td>
                                    @if ($na)
                                        <span class="neo-badge {{ $badgeClass }}">{{ $predikat }}</span>
                                    @else
                                        —
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
