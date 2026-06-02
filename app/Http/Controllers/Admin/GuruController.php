<?php

// FILE: app/Http/Controllers/Admin/GuruController.php
// CRUD data guru
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    // Tampilkan daftar semua guru
    public function index(Request $request)
    {
        $cari = $request->input('cari');

        $query = DB::table('guru')
            ->join('users', 'guru.id_user', '=', 'users.id_user')
            ->select('guru.*', 'users.username');

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('guru.nama', 'like', "%$cari%")
                  ->orWhere('guru.nip', 'like', "%$cari%");
            });
        }

        $daftarGuru = $query->orderBy('guru.nama')->get();

        return view('admin.guru.index', compact('daftarGuru', 'cari'));
    }

    // Tampilkan form tambah guru
    public function tambah()
    {
        // Auto generate NIP — ambil NIP terbesar lalu +1
        $nipTermakhir = DB::table('guru')
            ->whereNotNull('nip')
            ->orderByRaw('CAST(nip AS UNSIGNED) DESC')
            ->value('nip');

        $nipBaru = $nipTermakhir
            ? str_pad((int)$nipTermakhir + 1, strlen($nipTermakhir), '0', STR_PAD_LEFT)
            : date('Y') . '0001';

        return view('admin.guru.tambah', compact('nipBaru'));
    }

    // Simpan data guru baru
    public function simpan(Request $request)
    {
        $request->validate([
            'nip'           => 'nullable|unique:guru,nip',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'nullable|date',
            'no_telepon'    => 'nullable',
            'alamat'        => 'nullable',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload foto jika ada
        $namaFoto = null;
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $folderTujuan = public_path('img/guru');
            if (!file_exists($folderTujuan)) {
                mkdir($folderTujuan, 0755, true);
            }
            $namaFoto = 'guru_' . time() . '.' . $request->file('foto')->extension();
            $request->file('foto')->move($folderTujuan, $namaFoto);
        }

        // Username dan password otomatis = NIP
        $username = $request->nip;
        $password = bcrypt($request->nip);

        // Buat akun user untuk guru
        $id_user = DB::table('users')->insertGetId([
            'nama'       => $request->nama,
            'username'   => $username,
            'password'   => $password,
            'role'       => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan data guru
        DB::table('guru')->insert([
            'id_user'       => $id_user,
            'nip'           => $request->nip,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'no_telepon'    => $request->no_telepon,
            'foto'          => $namaFoto,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('admin.guru.index')
            ->with('sukses', 'Data guru berhasil ditambahkan.');
    }

    // Tampilkan form edit guru
    public function edit($id_guru)
    {
        $result = DB::table('guru')
            ->join('users', 'guru.id_user', '=', 'users.id_user')
            ->select('guru.*', 'users.username')
            ->where('guru.id_guru', $id_guru)
            ->first();

        if (!$result) {
            abort(404);
        }

        return view('admin.guru.edit', compact('result'));
    }

    // Update data guru
    public function update(Request $request, $id_guru)
    {
        $result = DB::table('guru')->where('id_guru', $id_guru)->first();

        if (!$result) {
            abort(404);
        }

        $request->validate([
            'nip'           => 'nullable|unique:guru,nip,' . $id_guru . ',id_guru',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'nullable|date',
            'no_telepon'    => 'nullable',
            'alamat'        => 'nullable',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'username'      => 'required|unique:users,username,' . $result->id_user . ',id_user',
            'password'      => 'nullable|min:6',
        ]);

        // Upload foto baru jika ada
        $namaFoto = $result->foto;
        if ($request->hasFile('foto')) {
            if ($namaFoto && file_exists(public_path('img/guru/' . $namaFoto))) {
                unlink(public_path('img/guru/' . $namaFoto));
            }
            $namaFoto = 'guru_' . time() . '.' . $request->file('foto')->extension();
            $request->file('foto')->move(public_path('img/guru'), $namaFoto);
        }

        // Update data guru
        DB::table('guru')->where('id_guru', $id_guru)->update([
            'nip'           => $request->nip,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'no_telepon'    => $request->no_telepon,
            'foto'          => $namaFoto,
            'updated_at'    => now(),
        ]);

        // Update akun user
        $updateUser = [
            'nama'       => $request->nama,
            'username'   => $request->username,
            'updated_at' => now(),
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $updateUser['password'] = bcrypt($request->password);
        }

        DB::table('users')->where('id_user', $result->id_user)->update($updateUser);

        return redirect()->route('admin.guru.index')
            ->with('sukses', 'Data guru berhasil diperbarui.');
    }

    // Hapus data guru
    public function hapus($id_guru)
    {
        $result = DB::table('guru')->where('id_guru', $id_guru)->first();

        if (!$result) {
            abort(404);
        }

        // Hapus foto jika ada
        if ($result->foto && file_exists(public_path('img/guru/' . $result->foto))) {
            unlink(public_path('img/guru/' . $result->foto));
        }

        // Hapus akun user (cascade hapus guru juga)
        DB::table('users')->where('id_user', $result->id_user)->delete();

        return redirect()->route('admin.guru.index')
            ->with('sukses', 'Data guru berhasil dihapus.');
    }
}
