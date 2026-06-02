<?php

// FILE: app/Http/Controllers/Admin/LaporanController.php
// Laporan & export data akademik
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Halaman utama laporan
    public function index()
    {
        // Statistik ringkas untuk dashboard laporan
        $totalSiswa      = DB::table('siswa')->count();
        $totalGuru       = DB::table('guru')->count();
        $totalPresensi   = DB::table('presensi')->count();
        $totalNilai      = DB::table('nilai')->count();

        // Rekap presensi per status
        $rekapPresensi = DB::table('presensi')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Rekap presensi per kelas
        $rekapPerKelas = DB::table('presensi')
            ->join('siswa', 'presensi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->select('kelas.nama_kelas', DB::raw('count(*) as total'))
            ->groupBy('kelas.nama_kelas')
            ->orderBy('kelas.nama_kelas')
            ->get();

        return view('admin.laporan.index', compact(
            'totalSiswa',
            'totalGuru',
            'totalPresensi',
            'totalNilai',
            'rekapPresensi',
            'rekapPerKelas',
        ));
    }

    // Laporan presensi
    public function presensi(Request $request)
    {
        $id_kelas  = $request->input('id_kelas');
        $tanggal   = $request->input('tanggal');
        $bulan     = $request->input('bulan');

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

        if ($tanggal) {
            $query->whereDate('presensi.tanggal', $tanggal);
        } elseif ($bulan) {
            $query->whereMonth('presensi.tanggal', date('m', strtotime($bulan)))
                  ->whereYear('presensi.tanggal', date('Y', strtotime($bulan)));
        }

        $daftarPresensi = $query->orderBy('presensi.tanggal', 'desc')->get();
        $daftarKelas    = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();

        return view('admin.laporan.presensi', compact(
            'daftarPresensi',
            'daftarKelas',
            'id_kelas',
            'tanggal',
            'bulan'
        ));
    }

    // Laporan nilai
    public function nilai(Request $request)
    {
        $id_kelas  = $request->input('id_kelas');
        $id_mapel  = $request->input('id_mapel');
        $semester  = $request->input('semester');

        $query = DB::table('nilai')
            ->join('siswa', 'nilai.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'nilai.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->join('guru', 'nilai.id_guru', '=', 'guru.id_guru')
            ->select(
                'nilai.*',
                'siswa.nama as nama_siswa',
                'siswa.nis',
                'kelas.nama_kelas',
                'mata_pelajaran.nama_mapel',
                'guru.nama as nama_guru'
            );

        if ($id_kelas) {
            $query->where('nilai.id_kelas', $id_kelas);
        }

        if ($id_mapel) {
            $query->where('nilai.id_mapel', $id_mapel);
        }

        if ($semester) {
            $query->where('nilai.semester', $semester);
        }

        $daftarNilai = $query->orderBy('kelas.nama_kelas')->orderBy('siswa.nama')->get();
        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();
        $daftarMapel = DB::table('mata_pelajaran')->orderBy('nama_mapel')->get();

        return view('admin.laporan.nilai', compact(
            'daftarNilai',
            'daftarKelas',
            'daftarMapel',
            'id_kelas',
            'id_mapel',
            'semester'
        ));
    }

    // Export laporan presensi ke CSV
    public function exportPresensi(Request $request)
    {
        $id_kelas = $request->input('id_kelas');
        $bulan    = $request->input('bulan');

        $query = DB::table('presensi')
            ->join('siswa', 'presensi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('jadwal_pelajaran', 'presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'siswa.nis',
                'siswa.nama as nama_siswa',
                'kelas.nama_kelas',
                'mata_pelajaran.nama_mapel',
                'presensi.tanggal',
                'presensi.status',
                'presensi.metode'
            );

        if ($id_kelas) {
            $query->where('siswa.id_kelas', $id_kelas);
        }

        if ($bulan) {
            $query->whereMonth('presensi.tanggal', date('m', strtotime($bulan)))
                  ->whereYear('presensi.tanggal', date('Y', strtotime($bulan)));
        }

        $result = $query->orderBy('presensi.tanggal', 'desc')->get();

        // Buat file CSV
        $namaFile = 'laporan_presensi_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ];

        $callback = function () use ($result) {
            $file = fopen('php://output', 'w');

            // Header kolom
            fputcsv($file, ['NIS', 'Nama Siswa', 'Kelas', 'Mata Pelajaran', 'Tanggal', 'Status', 'Metode']);

            // Data
            foreach ($result as $row) {
                fputcsv($file, [
                    $row->nis,
                    $row->nama_siswa,
                    $row->nama_kelas,
                    $row->nama_mapel,
                    $row->tanggal,
                    ucfirst($row->status),
                    ucfirst($row->metode),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export laporan nilai ke CSV
    public function exportNilai(Request $request)
    {
        $id_kelas = $request->input('id_kelas');
        $id_mapel = $request->input('id_mapel');
        $semester = $request->input('semester');

        $query = DB::table('nilai')
            ->join('siswa', 'nilai.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'nilai.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'siswa.nis',
                'siswa.nama as nama_siswa',
                'kelas.nama_kelas',
                'mata_pelajaran.nama_mapel',
                'nilai.semester',
                'nilai.tahun_ajaran',
                'nilai.nilai_tugas',
                'nilai.nilai_uts',
                'nilai.nilai_uas',
                'nilai.nilai_akhir'
            );

        if ($id_kelas) {
            $query->where('nilai.id_kelas', $id_kelas);
        }

        if ($id_mapel) {
            $query->where('nilai.id_mapel', $id_mapel);
        }

        if ($semester) {
            $query->where('nilai.semester', $semester);
        }

        $result = $query->orderBy('kelas.nama_kelas')->orderBy('siswa.nama')->get();

        $namaFile = 'laporan_nilai_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ];

        $callback = function () use ($result) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['NIS', 'Nama Siswa', 'Kelas', 'Mata Pelajaran', 'Semester', 'Tahun Ajaran', 'Tugas', 'UTS', 'UAS', 'Nilai Akhir']);

            foreach ($result as $row) {
                fputcsv($file, [
                    $row->nis,
                    $row->nama_siswa,
                    $row->nama_kelas,
                    $row->nama_mapel,
                    $row->semester,
                    $row->tahun_ajaran,
                    $row->nilai_tugas ?? '-',
                    $row->nilai_uts   ?? '-',
                    $row->nilai_uas   ?? '-',
                    $row->nilai_akhir ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
