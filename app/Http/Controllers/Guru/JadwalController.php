<?php

// FILE: app/Http/Controllers/Guru/JadwalController.php
// Jadwal mengajar guru
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        $daftarHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Ambil jadwal dikelompokkan per hari
        $daftarJadwal = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select('jadwal_pelajaran.*', 'kelas.nama_kelas', 'mata_pelajaran.nama_mapel', 'mata_pelajaran.kode_mapel')
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('guru.jadwal.index', compact('daftarJadwal', 'daftarHari'));
    }
}
