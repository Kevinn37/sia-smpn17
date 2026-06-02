<?php

// FILE: app/Http/Controllers/Admin/DashboardController.php
// Dashboard utama admin
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $jumlahSiswa    = DB::table('siswa')->count();
        $jumlahGuru     = DB::table('guru')->count();
        $jumlahKelas    = DB::table('kelas')->count();
        $jumlahMapel    = DB::table('mata_pelajaran')->count();

        // Presensi hari ini
        $presensiHariIni = DB::table('presensi')
            ->whereDate('tanggal', today())
            ->count();

        // Rekap presensi hari ini per status
        $rekapPresensi = DB::table('presensi')
            ->whereDate('tanggal', today())
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Pengumuman aktif
        $daftarPengumuman = DB::table('pengumuman')
            ->where('tanggal_tayang', '<=', today())
            ->where(function ($query) {
                $query->whereNull('tanggal_berakhir')
                      ->orWhere('tanggal_berakhir', '>=', today());
            })
            ->orderBy('tanggal_tayang', 'desc')
            ->limit(5)
            ->get();

        // Kegiatan kalender yang akan datang
        $daftarKegiatan = DB::table('kalender_akademik')
            ->where('tanggal_mulai', '>=', today())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(5)
            ->get();

        // Siswa terbaru didaftarkan
        $daftarSiswaBaru = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->select('siswa.nama', 'siswa.nis', 'kelas.nama_kelas', 'siswa.created_at')
            ->orderBy('siswa.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'jumlahSiswa',
            'jumlahGuru',
            'jumlahKelas',
            'jumlahMapel',
            'presensiHariIni',
            'rekapPresensi',
            'daftarPengumuman',
            'daftarKegiatan',
            'daftarSiswaBaru',
        ));
    }
}
