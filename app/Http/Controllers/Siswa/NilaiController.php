<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $siswa = DB::table('siswa')
            ->where('id_user', session('id_user'))
            ->first();

        $semester     = $request->input('semester', 1);
        $tahun_ajaran = $request->input('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));

        $daftarNilai = DB::table('nilai')
            ->join('mata_pelajaran', 'nilai.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->join('guru', 'nilai.id_guru', '=', 'guru.id_guru')
            ->select('nilai.*', 'mata_pelajaran.nama_mapel', 'mata_pelajaran.kode_mapel', 'guru.nama as nama_guru')
            ->where('nilai.id_siswa', $siswa->id_siswa)
            ->where('nilai.semester', $semester)
            ->where('nilai.tahun_ajaran', $tahun_ajaran)
            ->orderBy('mata_pelajaran.nama_mapel')
            ->get();

        // Hitung rata-rata nilai akhir
        $rataRata = $daftarNilai->whereNotNull('nilai_akhir')->avg('nilai_akhir');

        return view('siswa.nilai.index', compact(
            'siswa',
            'daftarNilai',
            'semester',
            'tahun_ajaran',
            'rataRata',
        ));
    }
}
