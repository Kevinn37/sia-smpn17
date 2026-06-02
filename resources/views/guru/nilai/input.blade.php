@extends('layouts.dashboard')

@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai')

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
            <h2>Input Nilai</h2>
            <p>{{ $jadwal->nama_mapel }} — Kelas {{ $jadwal->nama_kelas }}</p>
        </div>
        <a href="{{ route('guru.nilai.index') }}" class="neo-btn neo-btn-putih">
            <i data-lucide="arrow-left"></i>
            Kembali
        </a>
    </div>

    {{-- Filter semester --}}
    <div class="nilai-filter-bar">
        <form action="{{ route('guru.nilai.input', $jadwal->id_jadwal) }}" method="GET" class="nilai-filter-form">
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
            <div class="filter-aksi" style="padding-top: 1.6rem;">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="search"></i>
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    {{-- Info rumus --}}
    <div class="nilai-rumus-box" data-aos="fade-down">
        <i data-lucide="info"></i>
        <span>Rumus Nilai Akhir: <strong>(Tugas × 30%) + (UTS × 30%) + (UAS × 40%)</strong> — Nilai akhir dihitung otomatis
            saat disimpan.</span>
    </div>

    <div class="neo-card" data-aos="fade-up">

        @if (session('sukses'))
            <div class="neo-alert-sukses" style="margin-bottom: 1rem;">
                ✅ {{ session('sukses') }}
            </div>
        @endif

        <form action="{{ route('guru.nilai.simpan') }}" method="POST">
            @csrf
            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="tahun_ajaran" value="{{ $tahun_ajaran }}">

            <div class="tabel-wrapper">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Tugas (0-100)</th>
                            <th>UTS (0-100)</th>
                            <th>UAS (0-100)</th>
                            <th>Nilai Akhir</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarSiswa as $siswa)
                            @php
                                $na = $siswa->nilai_akhir;
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
                                <td><strong>{{ $siswa->nama }}</strong></td>
                                <td>{{ $siswa->nis }}</td>
                                <td>
                                    <input type="number" name="nilai[{{ $siswa->id_siswa }}][tugas]" class="nilai-input"
                                        value="{{ $siswa->nilai_tugas }}" min="0" max="100" step="0.01"
                                        placeholder="—">
                                </td>
                                <td>
                                    <input type="number" name="nilai[{{ $siswa->id_siswa }}][uts]" class="nilai-input"
                                        value="{{ $siswa->nilai_uts }}" min="0" max="100" step="0.01"
                                        placeholder="—">
                                </td>
                                <td>
                                    <input type="number" name="nilai[{{ $siswa->id_siswa }}][uas]" class="nilai-input"
                                        value="{{ $siswa->nilai_uas }}" min="0" max="100" step="0.01"
                                        placeholder="—">
                                </td>
                                <td>
                                    <strong class="nilai-akhir-display">
                                        {{ $siswa->nilai_akhir ?? '—' }}
                                    </strong>
                                </td>
                                <td>
                                    @if ($na)
                                        <span class="neo-badge {{ $badgeClass }}">{{ $predikat }}</span>
                                    @else
                                        <span>—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="nilai-simpan-bar">
                <button type="submit" class="neo-btn neo-btn-biru">
                    <i data-lucide="save"></i>
                    Simpan Semua Nilai
                </button>
                <a href="{{ route('guru.nilai.index') }}" class="neo-btn neo-btn-putih">
                    <i data-lucide="x"></i>
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection

@push('js')
    <script src="{{ asset('js/nilai.js') }}"></script>
@endpush
