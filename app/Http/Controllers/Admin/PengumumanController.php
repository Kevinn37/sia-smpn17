<?php

// FILE: app/Http/Controllers/Admin/PengumumanController.php
// CRUD pengumuman sekolah
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    // Tampilkan daftar pengumuman
    public function index(Request $request)
    {
        $ditujukan = $request->input('ditujukan');

        $query = DB::table('pengumuman');

        if ($ditujukan) {
            $query->where('ditujukan', $ditujukan);
        }

        $daftarPengumuman = $query->orderBy('tanggal_tayang', 'desc')->get();

        return view('admin.pengumuman.index', compact('daftarPengumuman', 'ditujukan'));
    }

    // Tampilkan form tambah
    public function tambah()
    {
        return view('admin.pengumuman.tambah');
    }

    // Simpan pengumuman baru
    public function simpan(Request $request)
    {
        $request->validate([
            'judul'            => 'required|max:150',
            'isi'              => 'required',
            'ditujukan'        => 'required|in:semua,siswa,guru',
            'tanggal_tayang'   => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_tayang',
        ]);

        DB::table('pengumuman')->insert([
            'judul'            => $request->judul,
            'isi'              => $request->isi,
            'ditujukan'        => $request->ditujukan,
            'tanggal_tayang'   => $request->tanggal_tayang,
            'tanggal_berakhir' => $request->tanggal_berakhir ?: null,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return redirect()->route('admin.pengumuman.index')
            ->with('sukses', 'Pengumuman berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id_pengumuman)
    {
        $result = DB::table('pengumuman')->where('id_pengumuman', $id_pengumuman)->first();

        if (!$result) {
            abort(404);
        }

        return view('admin.pengumuman.edit', compact('result'));
    }

    // Update pengumuman
    public function update(Request $request, $id_pengumuman)
    {
        $result = DB::table('pengumuman')->where('id_pengumuman', $id_pengumuman)->first();

        if (!$result) {
            abort(404);
        }

        $request->validate([
            'judul'            => 'required|max:150',
            'isi'              => 'required',
            'ditujukan'        => 'required|in:semua,siswa,guru',
            'tanggal_tayang'   => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_tayang',
        ]);

        DB::table('pengumuman')->where('id_pengumuman', $id_pengumuman)->update([
            'judul'            => $request->judul,
            'isi'              => $request->isi,
            'ditujukan'        => $request->ditujukan,
            'tanggal_tayang'   => $request->tanggal_tayang,
            'tanggal_berakhir' => $request->tanggal_berakhir ?: null,
            'updated_at'       => now(),
        ]);

        return redirect()->route('admin.pengumuman.index')
            ->with('sukses', 'Pengumuman berhasil diperbarui.');
    }

    // Hapus pengumuman
    public function hapus($id_pengumuman)
    {
        $result = DB::table('pengumuman')->where('id_pengumuman', $id_pengumuman)->first();

        if (!$result) {
            abort(404);
        }

        DB::table('pengumuman')->where('id_pengumuman', $id_pengumuman)->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('sukses', 'Pengumuman berhasil dihapus.');
    }
}
