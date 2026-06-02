<?php

// FILE: app/Http/Controllers/Admin/MataPelajaranController.php
// CRUD data mata pelajaran
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MataPelajaranController extends Controller
{
    // Tampilkan daftar mata pelajaran
    public function index()
    {
        $daftarMapel = DB::table('mata_pelajaran')
            ->orderBy('nama_mapel')
            ->get();

        return view('admin.mata-pelajaran.index', compact('daftarMapel'));
    }

    // Tampilkan form tambah
    public function tambah()
    {
        return view('admin.mata-pelajaran.tambah');
    }

    // Simpan mata pelajaran baru
    public function simpan(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel|max:10',
            'nama_mapel' => 'required|max:100',
        ]);

        DB::table('mata_pelajaran')->insert([
            'kode_mapel' => strtoupper($request->kode_mapel),
            'nama_mapel' => $request->nama_mapel,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.mapel.index')
            ->with('sukses', 'Mata pelajaran berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id_mapel)
    {
        $result = DB::table('mata_pelajaran')->where('id_mapel', $id_mapel)->first();

        if (!$result) {
            abort(404);
        }

        return view('admin.mata-pelajaran.edit', compact('result'));
    }

    // Update mata pelajaran
    public function update(Request $request, $id_mapel)
    {
        $result = DB::table('mata_pelajaran')->where('id_mapel', $id_mapel)->first();

        if (!$result) {
            abort(404);
        }

        $request->validate([
            'kode_mapel' => 'required|max:10|unique:mata_pelajaran,kode_mapel,' . $id_mapel . ',id_mapel',
            'nama_mapel' => 'required|max:100',
        ]);

        DB::table('mata_pelajaran')->where('id_mapel', $id_mapel)->update([
            'kode_mapel' => strtoupper($request->kode_mapel),
            'nama_mapel' => $request->nama_mapel,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.mapel.index')
            ->with('sukses', 'Mata pelajaran berhasil diperbarui.');
    }

    // Hapus mata pelajaran
    public function hapus($id_mapel)
    {
        $result = DB::table('mata_pelajaran')->where('id_mapel', $id_mapel)->first();

        if (!$result) {
            abort(404);
        }

        // Cek apakah mapel masih dipakai di jadwal
        $adaDiJadwal = DB::table('jadwal_pelajaran')->where('id_mapel', $id_mapel)->exists();

        if ($adaDiJadwal) {
            return redirect()->route('admin.mapel.index')
                ->with('gagal', 'Mata pelajaran tidak bisa dihapus karena masih dipakai di jadwal pelajaran.');
        }

        DB::table('mata_pelajaran')->where('id_mapel', $id_mapel)->delete();

        return redirect()->route('admin.mapel.index')
            ->with('sukses', 'Mata pelajaran berhasil dihapus.');
    }
}
