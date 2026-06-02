@extends('layouts.dashboard')

@section('title', 'Nilai Saya')
@section('page-title', 'Nilai Saya')

@section('sidebar-menu')
    <span class="sidebar-nav-label">Menu Utama</span>
    <a href="{{ route('siswa.dashboard') }}">
        <i data-lucide="layout-dashboard"></i> Dashboard
    </a>
    <span class="sidebar-nav-label">Akademik</span>
    <a href="{{ route('siswa.presensi.index') }}">
        <i data-lucide="qr-code"></i> Presensi
    </a>
    <a href="{{ route('siswa.nilai') }}" class="aktif">
        <i data-lucide="book-open"></i> Nilai
    </a>
    <a href="{{ route('siswa.jadwal') }}">
        <i data-lucide="calendar-days"></i> Jadwal
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/siswa-nilai.css') }}">
@endpush

@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Nilai Saya</h2>
            <p>Data nilai akademik semester ini</p>
        </div>
    </div>

    {{-- Filter semester --}}
    <div class="neo-card filter-card">
        <form action="{{ route('siswa.nilai') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label class="neo-label">Semester</label>
                <select name="semester" class="neo-select">
                    <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester 2</option>
                </select>
            </div>
            <div class="filter-field">
                <label class="neo-label">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="neo-input" value="{{ $tahun_ajaran }}"
                    placeholder="2024/2025">
            </div>
            <div class="filter-aksi" style="padding-top:1.6rem;">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    {{-- Rata-rata --}}
    @if ($rataRata)
        <div class="siswa-nilai-rata" data-aos="fade-down">
            <i data-lucide="trending-up"></i>
            <span>Rata-rata Nilai Akhir Semester {{ $semester }}:</span>
            <strong>{{ number_format($rataRata, 2) }}</strong>
            @php
                $predikatRata =
                    $rataRata >= 90
                        ? 'A'
                        : ($rataRata >= 80
                            ? 'B'
                            : ($rataRata >= 70
                                ? 'C'
                                : ($rataRata >= 60
                                    ? 'D'
                                    : 'E')));
            @endphp
            <span
                class="neo-badge {{ $rataRata >= 80 ? 'neo-badge-hijau' : ($rataRata >= 70 ? 'neo-badge-kuning' : 'neo-badge-alfa') }}">
                {{ $predikatRata }}
            </span>
        </div>
    @endif

    <div class="neo-card" data-aos="fade-up">
        <div class="neo-card-header">
            <h3>
                <i data-lucide="book-open"></i>
                Nilai Semester {{ $semester }} — {{ $tahun_ajaran }}
            </h3>
        </div>

        @if ($daftarNilai->count() > 0)
            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
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
                                <td>
                                    <strong>{{ $nilai->nama_mapel }}</strong>
                                    <br>
                                    <small style="color:#777;">{{ $nilai->kode_mapel }}</small>
                                </td>
                                <td>{{ $nilai->nama_guru }}</td>
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
                <p>Belum ada data nilai untuk semester ini.</p>
            </div>
        @endif
    </div>

@endsection
