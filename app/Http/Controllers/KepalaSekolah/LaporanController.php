<?php

// FILE: app/Http/Controllers/KepalaSekolah/LaporanController.php
// Laporan & export oleh kepala sekolah
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Halaman utama laporan
    public function index()
    {
        $totalSiswa    = DB::table('siswa')->count();
        $totalGuru     = DB::table('guru')->count();
        $totalPresensi = DB::table('presensi')->count();
        $totalNilai    = DB::table('nilai')->count();

        $rekapPresensi = DB::table('presensi')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('kepala-sekolah.laporan.index', compact(
            'totalSiswa',
            'totalGuru',
            'totalPresensi',
            'totalNilai',
            'rekapPresensi',
        ));
    }

    // Export presensi ke CSV
    public function export(Request $request)
    {
        $tipe     = $request->input('tipe', 'presensi');
        $id_kelas = $request->input('id_kelas');
        $bulan    = $request->input('bulan');

        if ($tipe == 'nilai') {
            return $this->exportNilai($id_kelas);
        }

        return $this->exportPresensi($id_kelas, $bulan);
    }

    private function exportPresensi($id_kelas, $bulan)
    {
        $query = DB::table('presensi')
            ->join('siswa', 'presensi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('jadwal_pelajaran', 'presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'siswa.nis', 'siswa.nama as nama_siswa',
                'kelas.nama_kelas', 'mata_pelajaran.nama_mapel',
                'presensi.tanggal', 'presensi.status', 'presensi.metode'
            );

        if ($id_kelas) {
            $query->where('siswa.id_kelas', $id_kelas);
        }

        if ($bulan) {
            $query->whereMonth('presensi.tanggal', date('m', strtotime($bulan)))
                  ->whereYear('presensi.tanggal', date('Y', strtotime($bulan)));
        }

        $result   = $query->orderBy('presensi.tanggal', 'desc')->get();
        $namaFile = 'laporan_presensi_' . date('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ];

        $callback = function () use ($result) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['NIS', 'Nama Siswa', 'Kelas', 'Mata Pelajaran', 'Tanggal', 'Status', 'Metode']);
            foreach ($result as $row) {
                fputcsv($file, [
                    $row->nis, $row->nama_siswa, $row->nama_kelas,
                    $row->nama_mapel, $row->tanggal,
                    ucfirst($row->status), ucfirst($row->metode),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportNilai($id_kelas)
    {
        $query = DB::table('nilai')
            ->join('siswa', 'nilai.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'nilai.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'siswa.nis', 'siswa.nama as nama_siswa',
                'kelas.nama_kelas', 'mata_pelajaran.nama_mapel',
                'nilai.semester', 'nilai.tahun_ajaran',
                'nilai.nilai_tugas', 'nilai.nilai_uts',
                'nilai.nilai_uas', 'nilai.nilai_akhir'
            );

        if ($id_kelas) {
            $query->where('nilai.id_kelas', $id_kelas);
        }

        $result   = $query->orderBy('kelas.nama_kelas')->orderBy('siswa.nama')->get();
        $namaFile = 'laporan_nilai_' . date('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ];

        $callback = function () use ($result) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['NIS', 'Nama', 'Kelas', 'Mapel', 'Semester', 'Tahun Ajaran', 'Tugas', 'UTS', 'UAS', 'Nilai Akhir']);
            foreach ($result as $row) {
                fputcsv($file, [
                    $row->nis, $row->nama_siswa, $row->nama_kelas,
                    $row->nama_mapel, $row->semester, $row->tahun_ajaran,
                    $row->nilai_tugas ?? '-', $row->nilai_uts ?? '-',
                    $row->nilai_uas ?? '-', $row->nilai_akhir ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
