<?php

// FILE: app/Http/Controllers/Admin/KalenderController.php
// CRUD kalender akademik
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KalenderController extends Controller
{
    // Tampilkan daftar kalender akademik
    public function index(Request $request)
    {
        $jenis = $request->input('jenis');

        $query = DB::table('kalender_akademik');

        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        $daftarKalender = $query->orderBy('tanggal_mulai')->get();

        $daftarJenis = ['libur_nasional', 'libur_sekolah', 'ujian', 'kegiatan'];

        return view('admin.kalender.index', compact('daftarKalender', 'daftarJenis', 'jenis'));
    }

    // Tampilkan form tambah
    public function tambah()
    {
        $daftarJenis = ['libur_nasional', 'libur_sekolah', 'ujian', 'kegiatan'];

        return view('admin.kalender.tambah', compact('daftarJenis'));
    }

    // Simpan kalender baru
    public function simpan(Request $request)
    {
        $request->validate([
            'judul'           => 'required|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis'           => 'required|in:libur_nasional,libur_sekolah,ujian,kegiatan',
            'keterangan'      => 'nullable',
        ]);

        DB::table('kalender_akademik')->insert([
            'judul'           => $request->judul,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis'           => $request->jenis,
            'keterangan'      => $request->keterangan,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->route('admin.kalender.index')
            ->with('sukses', 'Kegiatan akademik berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id_kalender)
    {
        $result = DB::table('kalender_akademik')->where('id_kalender', $id_kalender)->first();

        if (!$result) {
            abort(404);
        }

        $daftarJenis = ['libur_nasional', 'libur_sekolah', 'ujian', 'kegiatan'];

        return view('admin.kalender.edit', compact('result', 'daftarJenis'));
    }

    // Update kalender
    public function update(Request $request, $id_kalender)
    {
        $result = DB::table('kalender_akademik')->where('id_kalender', $id_kalender)->first();

        if (!$result) {
            abort(404);
        }

        $request->validate([
            'judul'           => 'required|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis'           => 'required|in:libur_nasional,libur_sekolah,ujian,kegiatan',
            'keterangan'      => 'nullable',
        ]);

        DB::table('kalender_akademik')->where('id_kalender', $id_kalender)->update([
            'judul'           => $request->judul,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis'           => $request->jenis,
            'keterangan'      => $request->keterangan,
            'updated_at'      => now(),
        ]);

        return redirect()->route('admin.kalender.index')
            ->with('sukses', 'Kegiatan akademik berhasil diperbarui.');
    }

    // Hapus kalender
    public function hapus($id_kalender)
    {
        $result = DB::table('kalender_akademik')->where('id_kalender', $id_kalender)->first();

        if (!$result) {
            abort(404);
        }

        DB::table('kalender_akademik')->where('id_kalender', $id_kalender)->delete();

        return redirect()->route('admin.kalender.index')
            ->with('sukses', 'Kegiatan akademik berhasil dihapus.');
    }
}
