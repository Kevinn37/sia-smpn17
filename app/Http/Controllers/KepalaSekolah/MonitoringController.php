<?php

// FILE: app/Http/Controllers/KepalaSekolah/MonitoringController.php
// Monitoring presensi, nilai, guru, siswa
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    // Monitoring presensi
    public function presensi(Request $request)
    {
        $id_kelas = $request->input('id_kelas');
        $bulan    = $request->input('bulan');

        $query = DB::table('presensi')
            ->join('siswa', 'presensi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('jadwal_pelajaran', 'presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'presensi.*',
                'siswa.nama as nama_siswa',
                'siswa.nis',
                'kelas.nama_kelas',
                'mata_pelajaran.nama_mapel'
            );

        if ($id_kelas) {
            $query->where('siswa.id_kelas', $id_kelas);
        }

        if ($bulan) {
            $query->whereMonth('presensi.tanggal', date('m', strtotime($bulan)))
                  ->whereYear('presensi.tanggal', date('Y', strtotime($bulan)));
        }

        $daftarPresensi = $query->orderBy('presensi.tanggal', 'desc')->limit(100)->get();

        // Rekap per status
        $rekapStatus = DB::table('presensi')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();

        return view('kepala-sekolah.monitoring.presensi', compact(
            'daftarPresensi',
            'rekapStatus',
            'daftarKelas',
            'id_kelas',
            'bulan',
        ));
    }

    // Monitoring nilai
    public function nilai(Request $request)
    {
        $id_kelas = $request->input('id_kelas');
        $id_mapel = $request->input('id_mapel');

        $query = DB::table('nilai')
            ->join('siswa', 'nilai.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'nilai.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'nilai.*',
                'siswa.nama as nama_siswa',
                'siswa.nis',
                'kelas.nama_kelas',
                'mata_pelajaran.nama_mapel'
            );

        if ($id_kelas) {
            $query->where('nilai.id_kelas', $id_kelas);
        }

        if ($id_mapel) {
            $query->where('nilai.id_mapel', $id_mapel);
        }

        $daftarNilai = $query->orderBy('kelas.nama_kelas')->orderBy('siswa.nama')->get();
        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();
        $daftarMapel = DB::table('mata_pelajaran')->orderBy('nama_mapel')->get();

        return view('kepala-sekolah.monitoring.nilai', compact(
            'daftarNilai',
            'daftarKelas',
            'daftarMapel',
            'id_kelas',
            'id_mapel',
        ));
    }

    // Monitoring guru
    public function guru()
    {
        $daftarGuru = DB::table('guru')
            ->orderBy('nama')
            ->get();

        // Jumlah kelas yang diajar per guru
        $kelasPerGuru = DB::table('jadwal_pelajaran')
            ->select('id_guru', DB::raw('count(distinct id_kelas) as total_kelas'))
            ->groupBy('id_guru')
            ->pluck('total_kelas', 'id_guru');

        // Jumlah jadwal per guru
        $jadwalPerGuru = DB::table('jadwal_pelajaran')
            ->select('id_guru', DB::raw('count(*) as total_jadwal'))
            ->groupBy('id_guru')
            ->pluck('total_jadwal', 'id_guru');

        return view('kepala-sekolah.monitoring.guru', compact(
            'daftarGuru',
            'kelasPerGuru',
            'jadwalPerGuru',
        ));
    }

    // Monitoring siswa
    public function siswa(Request $request)
    {
        $id_kelas = $request->input('id_kelas');

        $query = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->select('siswa.*', 'kelas.nama_kelas');

        if ($id_kelas) {
            $query->where('siswa.id_kelas', $id_kelas);
        }

        $daftarSiswa = $query->orderBy('kelas.nama_kelas')->orderBy('siswa.nama')->get();
        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();

        return view('kepala-sekolah.monitoring.siswa', compact(
            'daftarSiswa',
            'daftarKelas',
            'id_kelas',
        ));
    }
}
