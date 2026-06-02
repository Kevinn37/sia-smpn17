<?php

// FILE: app/Http/Controllers/Guru/PresensiController.php
// Presensi QR dan manual oleh guru
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PresensiController extends Controller
{
    // Tampilkan halaman utama presensi guru
    public function index(Request $request)
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        // Daftar jadwal guru
        $daftarJadwal = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.id_kelas', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select('jadwal_pelajaran.*', 'kelas.nama_kelas', 'mata_pelajaran.nama_mapel')
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('jam_mulai')
            ->get();

        // Sesi QR aktif — diperbaiki: join langsung tanpa nested join
        $sesiAktif = DB::table('sesi_presensi')
            ->join('kelas', 'sesi_presensi.id_kelas', '=', 'kelas.id_kelas')
            ->join('jadwal_pelajaran', 'sesi_presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'sesi_presensi.*',
                'kelas.nama_kelas',
                'mata_pelajaran.nama_mapel'
            )
            ->where('sesi_presensi.id_guru', $guru->id_guru)
            ->where('sesi_presensi.status_sesi', 'aktif')
            ->whereDate('sesi_presensi.tanggal', today())
            ->first();

        // Rekap presensi hari ini
        $rekapHariIni = DB::table('presensi')
            ->join('jadwal_pelajaran', 'presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->whereDate('presensi.tanggal', today())
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('guru.presensi.index', compact(
            'guru',
            'daftarJadwal',
            'sesiAktif',
            'rekapHariIni',
        ));
    }

    // Buka sesi presensi QR
    public function bukaSesi(Request $request)
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        $request->validate([
            'id_jadwal' => 'required',
        ]);

        $jadwal = DB::table('jadwal_pelajaran')
            ->where('id_jadwal', $request->id_jadwal)
            ->where('id_guru', $guru->id_guru)
            ->first();

        if (!$jadwal) {
            abort(403);
        }

        // Cek apakah sesi sudah ada hari ini
        $sudahAda = DB::table('sesi_presensi')
            ->where('id_jadwal', $request->id_jadwal)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAda) {
            // Kalau sudah ada langsung redirect ke QR
            $sesi = DB::table('sesi_presensi')
                ->where('id_jadwal', $request->id_jadwal)
                ->whereDate('tanggal', today())
                ->first();

            return redirect()->route('guru.presensi.tampilQr', ['token' => $sesi->token_qr]);
        }

        // Buat token QR unik
        $tokenQr = Str::uuid()->toString();

        DB::table('sesi_presensi')->insert([
            'id_jadwal'   => $request->id_jadwal,
            'id_guru'     => $guru->id_guru,
            'id_kelas'    => $jadwal->id_kelas,
            'tanggal'     => today(),
            'token_qr'    => $tokenQr,
            'status_sesi' => 'aktif',
            'dibuka_pada' => now(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('guru.presensi.tampilQr', ['token' => $tokenQr]);
    }

    // Tampilkan QR Code sesi aktif
    public function tampilQr($token)
    {
        $sesi = DB::table('sesi_presensi')
            ->join('kelas', 'sesi_presensi.id_kelas', '=', 'kelas.id_kelas')
            ->join('jadwal_pelajaran', 'sesi_presensi.id_jadwal', '=', 'jadwal_pelajaran.id_jadwal')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'sesi_presensi.*',
                'kelas.nama_kelas',
                'mata_pelajaran.nama_mapel'
            )
            ->where('sesi_presensi.token_qr', $token)
            ->where('sesi_presensi.status_sesi', 'aktif')
            ->first();

        if (!$sesi) {
            abort(404);
        }

        // Daftar siswa yang sudah scan
        $daftarHadir = DB::table('presensi')
            ->join('siswa', 'presensi.id_siswa', '=', 'siswa.id_siswa')
            ->select('siswa.nama', 'siswa.nis', 'presensi.waktu_scan', 'presensi.status')
            ->where('presensi.id_sesi', $sesi->id_sesi)
            ->orderBy('presensi.waktu_scan')
            ->get();

        // Total siswa di kelas ini
        $totalSiswaKelas = DB::table('siswa')
            ->where('id_kelas', $sesi->id_kelas)
            ->count();

        return view('guru.presensi.qr', compact(
            'sesi',
            'daftarHadir',
            'totalSiswaKelas',
        ));
    }

    // Tutup sesi presensi
    public function tutupSesi($id_sesi)
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        $sesi = DB::table('sesi_presensi')
            ->where('id_sesi', $id_sesi)
            ->where('id_guru', $guru->id_guru)
            ->first();

        if (!$sesi) {
            abort(403);
        }

        DB::table('sesi_presensi')->where('id_sesi', $id_sesi)->update([
            'status_sesi'  => 'selesai',
            'ditutup_pada' => now(),
            'updated_at'   => now(),
        ]);

        // Tandai siswa yang tidak scan sebagai alfa
        $daftarSiswaKelas = DB::table('siswa')
            ->where('id_kelas', $sesi->id_kelas)
            ->pluck('id_siswa');

        $sudahPresensi = DB::table('presensi')
            ->where('id_sesi', $id_sesi)
            ->pluck('id_siswa');

        $belumPresensi = $daftarSiswaKelas->diff($sudahPresensi);

        foreach ($belumPresensi as $id_siswa) {
            DB::table('presensi')->insert([
                'id_sesi'    => $id_sesi,
                'id_siswa'   => $id_siswa,
                'id_jadwal'  => $sesi->id_jadwal,
                'tanggal'    => $sesi->tanggal,
                'status'     => 'alfa',
                'metode'     => 'manual',
                'waktu_scan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('guru.presensi.index')
            ->with('sukses', 'Sesi presensi berhasil ditutup. Siswa yang tidak hadir dicatat sebagai alfa.');
    }

    // Tampilkan form presensi manual
    public function manual($id_jadwal)
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

        $daftarSiswa = DB::table('siswa')
            ->where('id_kelas', $jadwal->id_kelas)
            ->orderBy('nama')
            ->get();

        // Status presensi hari ini jika sudah ada
        $sudahPresensi = DB::table('presensi')
            ->where('id_jadwal', $id_jadwal)
            ->whereDate('tanggal', today())
            ->pluck('status', 'id_siswa');

        return view('guru.presensi.manual', compact(
            'jadwal',
            'daftarSiswa',
            'sudahPresensi',
        ));
    }

    // Simpan presensi manual
    public function simpanManual(Request $request)
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        $id_jadwal = $request->input('id_jadwal');

        $jadwal = DB::table('jadwal_pelajaran')
            ->where('id_jadwal', $id_jadwal)
            ->where('id_guru', $guru->id_guru)
            ->first();

        if (!$jadwal) {
            abort(403);
        }

        $daftarStatus = $request->input('status', []);

        foreach ($daftarStatus as $id_siswa => $status) {

            $sudahAda = DB::table('presensi')
                ->where('id_jadwal', $id_jadwal)
                ->where('id_siswa', $id_siswa)
                ->whereDate('tanggal', today())
                ->exists();

            if ($sudahAda) {
                DB::table('presensi')
                    ->where('id_jadwal', $id_jadwal)
                    ->where('id_siswa', $id_siswa)
                    ->whereDate('tanggal', today())
                    ->update([
                        'status'     => $status,
                        'metode'     => 'manual',
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('presensi')->insert([
                    'id_sesi'    => null,
                    'id_siswa'   => $id_siswa,
                    'id_jadwal'  => $id_jadwal,
                    'tanggal'    => today(),
                    'status'     => $status,
                    'metode'     => 'manual',
                    'waktu_scan' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('guru.presensi.index')
            ->with('sukses', 'Presensi manual berhasil disimpan.');
    }

    // Rekap presensi
    public function rekap(Request $request)
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

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
            )
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru);

        if ($id_kelas) {
            $query->where('siswa.id_kelas', $id_kelas);
        }

        if ($bulan) {
            $query->whereMonth('presensi.tanggal', date('m', strtotime($bulan)))
                  ->whereYear('presensi.tanggal', date('Y', strtotime($bulan)));
        }

        $daftarPresensi = $query->orderBy('presensi.tanggal', 'desc')->get();

        $daftarKelas = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.id_kelas', '=', 'kelas.id_kelas')
            ->where('jadwal_pelajaran.id_guru', $guru->id_guru)
            ->distinct()
            ->select('kelas.id_kelas', 'kelas.nama_kelas')
            ->get();

        return view('guru.presensi.rekap', compact(
            'daftarPresensi',
            'daftarKelas',
            'id_kelas',
            'bulan',
        ));
    }
}
