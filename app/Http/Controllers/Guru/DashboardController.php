<?php

// FILE: app/Http/Controllers/Guru/DashboardController.php
// Dashboard utama guru
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $id_guru = session('id_guru');

        // Ambil data guru dari session id_user
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        // Jadwal mengajar hari ini
        $hariIni = now()->locale('id')->dayName;
        $hariMap = [
            'Minggu' => 'Minggu', 'Senin' => 'Senin', 'Selasa' => 'Selasa',
            'Rabu'   => 'Rabu',   'Kamis' => 'Kamis', 'Jumat'  => 'Jumat',
            'Sabtu'  => 'Sabtu',
        ];
        $hariSekarang = $hariMap[now()->locale('id')->dayName] ?? now()->englishDayOfWeek;

        $jadwalHariIni = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select('jadwal_pelajaran.*', 'kelas.nama_kelas', 'mata_pelajaran.nama_mapel')
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->where('jadwal_pelajaran.hari', $hariSekarang)
            ->orderBy('jam_mulai')
            ->get();

        // Total kelas yang diajar
        $totalKelas = DB::table('jadwal_pelajaran')
            ->where('id_guru', $guru->id_guru)
            ->distinct('id_kelas')
            ->count('id_kelas');

        // Total siswa yang diajar
        $totalSiswa = DB::table('jadwal_pelajaran')
            ->join('siswa', 'jadwal_pelajaran.id_kelas', '=', 'siswa.id_kelas')
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->distinct('siswa.id_siswa')
            ->count('siswa.id_siswa');

        // Presensi yang dibuat guru hari ini
        $presensiHariIni = DB::table('presensi')
            ->join('jadwal_pelajaran', 'presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->whereDate('presensi.tanggal', today())
            ->count();

        // Sesi QR aktif milik guru ini
        $sesiAktif = DB::table('sesi_presensi')
            ->where('id_guru', $guru->id_guru)
            ->where('status_sesi', 'aktif')
            ->whereDate('tanggal', today())
            ->first();

        return view('guru.dashboard.index', compact(
            'guru',
            'jadwalHariIni',
            'totalKelas',
            'totalSiswa',
            'presensiHariIni',
            'sesiAktif',
        ));
    }
}
