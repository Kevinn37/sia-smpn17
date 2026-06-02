@extends('layouts.dashboard')

@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')

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
    <a href="{{ route('admin.kelas.index') }}" class="aktif">
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
    <a href="{{ route('admin.laporan.index') }}">
        <i data-lucide="file-text"></i> Laporan
    </a>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelas.css') }}">
@endpush


@section('konten')

    <div class="page-header">
        <div class="page-header-teks">
            <h2>Data Kelas</h2>
            <p>Kelola data kelas SMP Negeri 17 Makassar</p>
        </div>
        <a href="{{ route('admin.kelas.tambah') }}" class="neo-btn neo-btn-kuning">
            <i data-lucide="plus"></i>
            Tambah Kelas
        </a>
    </div>

    {{-- Grid kelas per tingkat --}}
    @foreach ([7, 8, 9] as $tingkat)
        @php
            $kelasTingkat = $daftarKelas->where('tingkat', $tingkat);
        @endphp

        @if ($kelasTingkat->count() > 0)
            <div class="neo-card kelas-section" data-aos="fade-up">

                <div class="neo-card-header">
                    <h3>
                        <i data-lucide="layers"></i>
                        Kelas {{ $tingkat }}
                    </h3>
                    <span class="neo-badge neo-badge-biru">
                        {{ $kelasTingkat->count() }} kelas
                    </span>
                </div>

                <div class="kelas-grid">
                    @foreach ($kelasTingkat as $kelas)
                        <div class="kelas-card">
                            <div class="kelas-card-nama">
                                {{ $kelas->nama_kelas }}
                            </div>
                            <div class="kelas-card-info">
                                <i data-lucide="users"></i>
                                <span>{{ $jumlahSiswaPerKelas[$kelas->id_kelas] ?? 0 }} siswa</span>
                            </div>
                            <div class="kelas-card-aksi">
                                <a href="{{ route('admin.kelas.edit', $kelas->id_kelas) }}"
                                    class="neo-btn neo-btn-kuning neo-btn-sm">
                                    <i data-lucide="pencil"></i>
                                    Edit
                                </a>
                                <form id="form-hapus-{{ $kelas->id_kelas }}"
                                    action="{{ route('admin.kelas.hapus', $kelas->id_kelas) }}" method="POST">
                                    @csrf
                                    <button type="button" class="neo-btn neo-btn-fuchsia neo-btn-sm"
                                        onclick="konfirmasiHapus('form-hapus-{{ $kelas->id_kelas }}')">
                                        <i data-lucide="trash-2"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @endif
    @endforeach

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
    @if (session('gagal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('gagal') }}',
                    timer: 3000,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif
@endpush
