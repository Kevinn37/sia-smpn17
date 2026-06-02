<?php

// FILE: app/Http/Controllers/Admin/KelasController.php
// CRUD data kelas
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    // Tampilkan daftar semua kelas
    public function index()
    {
        $daftarKelas = DB::table('kelas')
            ->orderBy('tingkat')
            ->orderBy('nomor')
            ->get();

        // Hitung jumlah siswa per kelas
        $jumlahSiswaPerKelas = DB::table('siswa')
            ->select('id_kelas', DB::raw('count(*) as total'))
            ->groupBy('id_kelas')
            ->pluck('total', 'id_kelas');

        return view('admin.kelas.index', compact('daftarKelas', 'jumlahSiswaPerKelas'));
    }

    // Tampilkan form tambah kelas
    public function tambah()
    {
        return view('admin.kelas.tambah');
    }

    // Simpan data kelas baru
    public function simpan(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:7,8,9',
            'nomor'   => 'required|integer|min:1',
        ]);

        // Cek duplikat kelas
        $sudahAda = DB::table('kelas')
            ->where('tingkat', $request->tingkat)
            ->where('nomor', $request->nomor)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nomor' => 'Kelas ' . $request->tingkat . '.' . $request->nomor . ' sudah ada.']);
        }

        $namaKelas = $request->tingkat . '.' . $request->nomor;

        DB::table('kelas')->insert([
            'tingkat'    => $request->tingkat,
            'nomor'      => $request->nomor,
            'nama_kelas' => $namaKelas,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('sukses', 'Kelas ' . $namaKelas . ' berhasil ditambahkan.');
    }

    // Tampilkan form edit kelas
    public function edit($id_kelas)
    {
        $result = DB::table('kelas')->where('id_kelas', $id_kelas)->first();

        if (!$result) {
            abort(404);
        }

        return view('admin.kelas.edit', compact('result'));
    }

    // Update data kelas
    public function update(Request $request, $id_kelas)
    {
        $result = DB::table('kelas')->where('id_kelas', $id_kelas)->first();

        if (!$result) {
            abort(404);
        }

        $request->validate([
            'tingkat' => 'required|in:7,8,9',
            'nomor'   => 'required|integer|min:1',
        ]);

        // Cek duplikat kecuali kelas ini sendiri
        $sudahAda = DB::table('kelas')
            ->where('tingkat', $request->tingkat)
            ->where('nomor', $request->nomor)
            ->where('id_kelas', '!=', $id_kelas)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nomor' => 'Kelas ' . $request->tingkat . '.' . $request->nomor . ' sudah ada.']);
        }

        $namaKelas = $request->tingkat . '.' . $request->nomor;

        DB::table('kelas')->where('id_kelas', $id_kelas)->update([
            'tingkat'    => $request->tingkat,
            'nomor'      => $request->nomor,
            'nama_kelas' => $namaKelas,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('sukses', 'Data kelas berhasil diperbarui.');
    }

    // Hapus kelas
    public function hapus($id_kelas)
    {
        $result = DB::table('kelas')->where('id_kelas', $id_kelas)->first();

        if (!$result) {
            abort(404);
        }

        // Cek apakah masih ada siswa di kelas ini
        $adaSiswa = DB::table('siswa')->where('id_kelas', $id_kelas)->exists();

        if ($adaSiswa) {
            return redirect()->route('admin.kelas.index')
                ->with('gagal', 'Kelas tidak bisa dihapus karena masih ada siswa di kelas ini.');
        }

        DB::table('kelas')->where('id_kelas', $id_kelas)->delete();

        return redirect()->route('admin.kelas.index')
            ->with('sukses', 'Kelas ' . $result->nama_kelas . ' berhasil dihapus.');
    }
}
