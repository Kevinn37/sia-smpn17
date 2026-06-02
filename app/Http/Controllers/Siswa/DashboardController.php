<?php

// FILE: app/Http/Controllers/Siswa/DashboardController.php
// Dashboard utama siswa
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data siswa dari session id_user
        $siswa = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->select('siswa.*', 'kelas.nama_kelas')
            ->where('siswa.id_user', session('id_user'))
            ->first();

        // Rekap kehadiran bulan ini
        $rekapHadir = DB::table('presensi')
            ->where('id_siswa', $siswa->id_siswa)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Jadwal hari ini
        $hariSekarang = now()->locale('id')->dayName;
        $hariMap = [
            'Senin' => 'Senin', 'Selasa' => 'Selasa', 'Rabu' => 'Rabu',
            'Kamis' => 'Kamis', 'Jumat'  => 'Jumat',
        ];
        $hari = $hariMap[$hariSekarang] ?? null;

        $jadwalHariIni = [];
        if ($hari) {
            $jadwalHariIni = DB::table('jadwal_pelajaran')
                ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
                ->join('guru', 'jadwal_pelajaran.id_guru', '=', 'guru.id_guru')
                ->select('jadwal_pelajaran.*', 'mata_pelajaran.nama_mapel', 'guru.nama as nama_guru')
                ->where('jadwal_pelajaran.id_kelas', $siswa->id_kelas)
                ->where('jadwal_pelajaran.hari', $hari)
                ->orderBy('jam_mulai')
                ->get();
        }

        // Nilai terbaru
        $daftarNilai = DB::table('nilai')
            ->join('mata_pelajaran', 'nilai.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select('nilai.*', 'mata_pelajaran.nama_mapel', 'mata_pelajaran.kode_mapel')
            ->where('nilai.id_siswa', $siswa->id_siswa)
            ->orderBy('nilai.updated_at', 'desc')
            ->limit(5)
            ->get();

        // Pengumuman aktif
        $daftarPengumuman = DB::table('pengumuman')
            ->where('tanggal_tayang', '<=', today())
            ->where(function ($q) {
                $q->whereNull('tanggal_berakhir')
                  ->orWhere('tanggal_berakhir', '>=', today());
            })
            ->whereIn('ditujukan', ['semua', 'siswa'])
            ->orderBy('tanggal_tayang', 'desc')
            ->limit(3)
            ->get();

        return view('siswa.dashboard.index', compact(
            'siswa',
            'rekapHadir',
            'jadwalHariIni',
            'daftarNilai',
            'daftarPengumuman',
        ));
    }
}
