<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $siswa = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->select('siswa.*', 'kelas.nama_kelas')
            ->where('siswa.id_user', session('id_user'))
            ->first();

        $daftarHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $daftarJadwal = DB::table('jadwal_pelajaran')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->join('guru', 'jadwal_pelajaran.id_guru', '=', 'guru.id_guru')
            ->select('jadwal_pelajaran.*', 'mata_pelajaran.nama_mapel', 'mata_pelajaran.kode_mapel', 'guru.nama as nama_guru')
            ->where('jadwal_pelajaran.id_kelas', $siswa->id_kelas)
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('siswa.jadwal.index', compact(
            'siswa',
            'daftarJadwal',
            'daftarHari',
        ));
    }
}
