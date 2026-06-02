<?php

// FILE: app/Http/Controllers/Siswa/ProfilController.php
// Edit profil siswa — fix upload foto
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function index()
    {
        $siswa = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('users', 'siswa.id_user', '=', 'users.id_user')
            ->select('siswa.*', 'kelas.nama_kelas', 'users.username')
            ->where('siswa.id_user', session('id_user'))
            ->first();

        return view('siswa.profil.index', compact('siswa'));
    }

    public function update(Request $request)
    {
        $siswa = DB::table('siswa')
            ->where('id_user', session('id_user'))
            ->first();

        $request->validate([
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $namaFoto = $siswa->foto;

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {

            // Pastikan folder ada
            $folderTujuan = public_path('img/siswa');
            if (!file_exists($folderTujuan)) {
                mkdir($folderTujuan, 0755, true);
            }

            // Hapus foto lama
            if ($namaFoto && file_exists($folderTujuan . '/' . $namaFoto)) {
                unlink($folderTujuan . '/' . $namaFoto);
            }

            // Simpan foto baru
            $namaFoto = 'siswa_' . session('id_user') . '_' . time() . '.' . $request->file('foto')->extension();
            $request->file('foto')->move($folderTujuan, $namaFoto);
        }

        DB::table('siswa')->where('id_siswa', $siswa->id_siswa)->update([
            'foto'       => $namaFoto,
            'updated_at' => now(),
        ]);

        if ($request->filled('password')) {
            DB::table('users')->where('id_user', session('id_user'))->update([
                'password'   => bcrypt($request->password),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('siswa.profil')
            ->with('sukses', 'Profil berhasil diperbarui.');
    }
}
