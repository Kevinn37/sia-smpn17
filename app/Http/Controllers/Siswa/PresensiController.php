<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresensiController extends Controller
{
    // Halaman presensi siswa
    public function index()
    {
        $siswa = DB::table('siswa')
            ->where('id_user', session('id_user'))
            ->first();

        $rekapBulanIni = DB::table('presensi')
            ->where('id_siswa', $siswa->id_siswa)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $daftarPresensi = DB::table('presensi')
            ->join('jadwal_pelajaran', 'presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select('presensi.*', 'mata_pelajaran.nama_mapel')
            ->where('presensi.id_siswa', $siswa->id_siswa)
            ->orderBy('presensi.tanggal', 'desc')
            ->limit(20)
            ->get();

        return view('siswa.presensi.index', compact(
            'siswa',
            'rekapBulanIni',
            'daftarPresensi',
        ));
    }

    // Proses scan QR Code
    public function scan(Request $request)
    {
        $siswa = DB::table('siswa')
            ->where('id_user', session('id_user'))
            ->first();

        $token = $request->input('token');

        // Cari sesi presensi berdasarkan token
        $sesi = DB::table('sesi_presensi')
            ->where('token_qr', $token)
            ->where('status_sesi', 'aktif')
            ->whereDate('tanggal', today())
            ->first();

        if (!$sesi) {
            return redirect()->route('siswa.presensi.index')
                ->with('gagal', 'QR Code tidak valid atau sesi sudah berakhir.');
        }

        // Cek apakah siswa ada di kelas yang sama
        if ($siswa->id_kelas != $sesi->id_kelas) {
            return redirect()->route('siswa.presensi.index')
                ->with('gagal', 'QR Code ini bukan untuk kelas Anda.');
        }

        // Cek apakah sudah scan hari ini untuk jadwal ini
        $sudahScan = DB::table('presensi')
            ->where('id_siswa', $siswa->id_siswa)
            ->where('id_sesi', $sesi->id_sesi)
            ->exists();

        if ($sudahScan) {
            return redirect()->route('siswa.presensi.index')
                ->with('gagal', 'Anda sudah melakukan presensi untuk sesi ini.');
        }

        // Simpan presensi
        DB::table('presensi')->insert([
            'id_sesi'    => $sesi->id_sesi,
            'id_siswa'   => $siswa->id_siswa,
            'id_jadwal'  => $sesi->id_jadwal,
            'tanggal'    => today(),
            'status'     => 'hadir',
            'metode'     => 'qr',
            'waktu_scan' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('siswa.presensi.index')
            ->with('sukses', 'Presensi berhasil dicatat. Selamat belajar!');
    }

    // Rekap kehadiran lengkap
    public function rekap(Request $request)
    {
        $siswa = DB::table('siswa')
            ->where('id_user', session('id_user'))
            ->first();

        $bulan = $request->input('bulan');

        $query = DB::table('presensi')
            ->join('jadwal_pelajaran', 'presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select('presensi.*', 'mata_pelajaran.nama_mapel')
            ->where('presensi.id_siswa', $siswa->id_siswa);

        if ($bulan) {
            $query->whereMonth('presensi.tanggal', date('m', strtotime($bulan)))
                  ->whereYear('presensi.tanggal', date('Y', strtotime($bulan)));
        }

        $daftarPresensi = $query->orderBy('presensi.tanggal', 'desc')->get();

        $rekapStatus = DB::table('presensi')
            ->where('id_siswa', $siswa->id_siswa)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('siswa.presensi.rekap', compact(
            'daftarPresensi',
            'rekapStatus',
            'bulan',
        ));
    }
}
