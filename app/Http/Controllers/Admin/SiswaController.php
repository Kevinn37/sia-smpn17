<?php

// FILE: app/Http/Controllers/Admin/SiswaController.php
// CRUD data siswa
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    // Tampilkan daftar semua siswa
    public function index(Request $request)
    {
        $cari       = $request->input('cari');
        $id_kelas   = $request->input('id_kelas');

        $query = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->select('siswa.*', 'kelas.nama_kelas');

        // Filter pencarian nama atau NIS
        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('siswa.nama', 'like', "%$cari%")
                  ->orWhere('siswa.nis', 'like', "%$cari%");
            });
        }

        // Filter per kelas
        if ($id_kelas) {
            $query->where('siswa.id_kelas', $id_kelas);
        }

        $daftarSiswa = $query->orderBy('kelas.tingkat')->orderBy('kelas.nomor')->orderBy('siswa.nama')->get();
        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();

        return view('admin.siswa.index', compact('daftarSiswa', 'daftarKelas', 'cari', 'id_kelas'));
    }

    // Tampilkan form tambah siswa
    public function tambah()
    {
        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();

        return view('admin.siswa.tambah', compact('daftarKelas'));
    }

    // Simpan data siswa baru
    public function simpan(Request $request)
    {
        $request->validate([
            'nis'           => 'required|unique:siswa,nis',
            'nama'          => 'required',
            'id_kelas'      => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'nullable',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload foto jika ada
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $namaFoto = 'siswa_' . time() . '.' . $request->file('foto')->extension();
            $request->file('foto')->move(public_path('img/siswa'), $namaFoto);
        }

        // Buat akun user untuk siswa
        // Username dan password default = NIS
        $id_user = DB::table('users')->insertGetId([
            'nama'       => $request->nama,
            'username'   => $request->nis,
            'password'   => bcrypt($request->nis),
            'role'       => 'siswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan data siswa
        DB::table('siswa')->insert([
            'id_user'       => $id_user,
            'id_kelas'      => $request->id_kelas,
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'foto'          => $namaFoto,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('sukses', 'Data siswa berhasil ditambahkan.');
    }

    // Tampilkan form edit siswa
    public function edit($id_siswa)
    {
        $result      = DB::table('siswa')->where('id_siswa', $id_siswa)->first();
        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();

        if (!$result) {
            abort(404);
        }

        return view('admin.siswa.edit', compact('result', 'daftarKelas'));
    }

    // Update data siswa
    public function update(Request $request, $id_siswa)
    {
        $result = DB::table('siswa')->where('id_siswa', $id_siswa)->first();

        if (!$result) {
            abort(404);
        }

        $request->validate([
            'nis'           => 'required|unique:siswa,nis,' . $id_siswa . ',id_siswa',
            'nama'          => 'required',
            'id_kelas'      => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'nullable',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload foto baru jika ada
        $namaFoto = $result->foto;
        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada
            if ($namaFoto && file_exists(public_path('img/siswa/' . $namaFoto))) {
                unlink(public_path('img/siswa/' . $namaFoto));
            }

            $namaFoto = 'siswa_' . time() . '.' . $request->file('foto')->extension();
            $request->file('foto')->move(public_path('img/siswa'), $namaFoto);
        }

        // Update data siswa
        DB::table('siswa')->where('id_siswa', $id_siswa)->update([
            'id_kelas'      => $request->id_kelas,
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'foto'          => $namaFoto,
            'updated_at'    => now(),
        ]);

        // Update nama dan username di tabel users
        DB::table('users')->where('id_user', $result->id_user)->update([
            'nama'       => $request->nama,
            'username'   => $request->nis,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('sukses', 'Data siswa berhasil diperbarui.');
    }

    // Hapus data siswa
    public function hapus($id_siswa)
    {
        $result = DB::table('siswa')->where('id_siswa', $id_siswa)->first();

        if (!$result) {
            abort(404);
        }

        // Hapus foto jika ada
        if ($result->foto && file_exists(public_path('img/siswa/' . $result->foto))) {
            unlink(public_path('img/siswa/' . $result->foto));
        }

        // Hapus akun user (cascade akan hapus siswa juga)
        DB::table('users')->where('id_user', $result->id_user)->delete();

        return redirect()->route('admin.siswa.index')
            ->with('sukses', 'Data siswa berhasil dihapus.');
    }
}
