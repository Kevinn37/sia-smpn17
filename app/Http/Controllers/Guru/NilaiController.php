<?php

// FILE: app/Http/Controllers/Guru/NilaiController.php
// Input dan kelola nilai siswa oleh guru
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    // Halaman utama nilai — pilih jadwal
    public function index()
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        $daftarJadwal = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select('jadwal_pelajaran.*', 'kelas.nama_kelas', 'mata_pelajaran.nama_mapel', 'mata_pelajaran.kode_mapel')
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->get();

        return view('guru.nilai.index', compact('daftarJadwal'));
    }

    // Form input nilai per jadwal
    public function input(Request $request, $id_jadwal)
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        $jadwal = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select('jadwal_pelajaran.*', 'kelas.nama_kelas', 'mata_pelajaran.nama_mapel')
            ->where('jadwal_pelajaran.id_jadwal', $id_jadwal)
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->first();

        if (!$jadwal) {
            abort(403);
        }

        $semester     = $request->input('semester', 1);
        $tahun_ajaran = $request->input('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));

        // Daftar siswa di kelas ini beserta nilainya
        $daftarSiswa = DB::table('siswa')
            ->leftJoin('nilai', function ($join) use ($id_jadwal, $semester, $tahun_ajaran) {
                $join->on('nilai.id_siswa', '=', 'siswa.id_siswa')
                     ->where('nilai.id_mapel', '=', DB::table('jadwal_pelajaran')->where('id_jadwal', $id_jadwal)->value('id_mapel'))
                     ->where('nilai.semester', '=', $semester)
                     ->where('nilai.tahun_ajaran', '=', $tahun_ajaran);
            })
            ->select('siswa.id_siswa', 'siswa.nama', 'siswa.nis', 'nilai.id_nilai', 'nilai.nilai_tugas', 'nilai.nilai_uts', 'nilai.nilai_uas', 'nilai.nilai_akhir')
            ->where('siswa.id_kelas', $jadwal->id_kelas)
            ->orderBy('siswa.nama')
            ->get();

        return view('guru.nilai.input', compact(
            'jadwal',
            'daftarSiswa',
            'semester',
            'tahun_ajaran',
        ));
    }

    // Simpan nilai siswa
    public function simpan(Request $request)
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        $id_jadwal    = $request->input('id_jadwal');
        $semester     = $request->input('semester');
        $tahun_ajaran = $request->input('tahun_ajaran');

        $jadwal = DB::table('jadwal_pelajaran')
            ->where('id_jadwal', $id_jadwal)
            ->where('id_guru', $guru->id_guru)
            ->first();

        if (!$jadwal) {
            abort(403);
        }

        $daftarNilai = $request->input('nilai', []);

        foreach ($daftarNilai as $id_siswa => $nilaiData) {

            $nilai_tugas = isset($nilaiData['tugas']) && $nilaiData['tugas'] !== '' ? (float) $nilaiData['tugas'] : null;
            $nilai_uts   = isset($nilaiData['uts'])   && $nilaiData['uts']   !== '' ? (float) $nilaiData['uts']   : null;
            $nilai_uas   = isset($nilaiData['uas'])   && $nilaiData['uas']   !== '' ? (float) $nilaiData['uas']   : null;

            // Hitung nilai akhir jika semua komponen tersedia
            $nilai_akhir = null;
            if ($nilai_tugas !== null && $nilai_uts !== null && $nilai_uas !== null) {
                $nilai_akhir = round(($nilai_tugas * 0.3) + ($nilai_uts * 0.3) + ($nilai_uas * 0.4), 2);
            }

            // Cek apakah sudah ada nilai
            $sudahAda = DB::table('nilai')
                ->where('id_siswa', $id_siswa)
                ->where('id_mapel', $jadwal->id_mapel)
                ->where('id_kelas', $jadwal->id_kelas)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahun_ajaran)
                ->first();

            if ($sudahAda) {
                DB::table('nilai')->where('id_nilai', $sudahAda->id_nilai)->update([
                    'nilai_tugas' => $nilai_tugas,
                    'nilai_uts'   => $nilai_uts,
                    'nilai_uas'   => $nilai_uas,
                    'nilai_akhir' => $nilai_akhir,
                    'updated_at'  => now(),
                ]);
            } else {
                DB::table('nilai')->insert([
                    'id_siswa'    => $id_siswa,
                    'id_mapel'    => $jadwal->id_mapel,
                    'id_kelas'    => $jadwal->id_kelas,
                    'id_guru'     => $guru->id_guru,
                    'semester'    => $semester,
                    'tahun_ajaran'=> $tahun_ajaran,
                    'nilai_tugas' => $nilai_tugas,
                    'nilai_uts'   => $nilai_uts,
                    'nilai_uas'   => $nilai_uas,
                    'nilai_akhir' => $nilai_akhir,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        return redirect()->route('guru.nilai.input', ['id_jadwal' => $id_jadwal, 'semester' => $semester, 'tahun_ajaran' => $tahun_ajaran])
            ->with('sukses', 'Nilai berhasil disimpan.');
    }
}
