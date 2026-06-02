<?php

// FILE: app/Http/Controllers/KepalaSekolah/DashboardController.php
// Dashboard kepala sekolah
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalSiswa  = DB::table('siswa')->count();
        $totalGuru   = DB::table('guru')->count();
        $totalKelas  = DB::table('kelas')->count();
        $totalMapel  = DB::table('mata_pelajaran')->count();

        // Presensi hari ini
        $rekapPresensiHariIni = DB::table('presensi')
            ->whereDate('tanggal', today())
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Presensi bulan ini per kelas
        $presensiPerKelas = DB::table('presensi')
            ->join('siswa', 'presensi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->whereMonth('presensi.tanggal', now()->month)
            ->whereYear('presensi.tanggal', now()->year)
            ->select('kelas.nama_kelas', DB::raw('count(*) as total'))
            ->groupBy('kelas.nama_kelas')
            ->orderBy('kelas.nama_kelas')
            ->get();

        // Rata-rata nilai per kelas
        $nilaiPerKelas = DB::table('nilai')
            ->join('kelas', 'nilai.id_kelas', '=', 'kelas.id_kelas')
            ->whereNotNull('nilai.nilai_akhir')
            ->select('kelas.nama_kelas', DB::raw('round(avg(nilai_akhir), 2) as rata_rata'))
            ->groupBy('kelas.nama_kelas')
            ->orderBy('kelas.nama_kelas')
            ->get();

        // Kegiatan mendatang
        $daftarKegiatan = DB::table('kalender_akademik')
            ->where('tanggal_mulai', '>=', today())
            ->orderBy('tanggal_mulai')
            ->limit(5)
            ->get();

        // Pengumuman aktif
        $jumlahPengumuman = DB::table('pengumuman')
            ->where('tanggal_tayang', '<=', today())
            ->where(function ($q) {
                $q->whereNull('tanggal_berakhir')
                  ->orWhere('tanggal_berakhir', '>=', today());
            })
            ->count();

        return view('kepala-sekolah.dashboard.index', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'rekapPresensiHariIni',
            'presensiPerKelas',
            'nilaiPerKelas',
            'daftarKegiatan',
            'jumlahPengumuman',
        ));
    }
}
