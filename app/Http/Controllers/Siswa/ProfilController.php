<?php

// FILE: app/Http/Controllers/Siswa/ProfilController.php
// Edit profil siswa — fix upload foto
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
            try {
                $file    = $request->file('foto');
                $token   = env('BLOB_READ_WRITE_TOKEN');
                $namaFile = 'siswa_' . session('id_user') . '_' . time() . '.' . $file->extension();

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => $file->getMimeType(),
                ])->withBody(
                    file_get_contents($file->getRealPath()),
                    $file->getMimeType()
                )->put('https://blob.vercel-storage.com/' . $namaFile);

                if ($response->successful()) {
                    $namaFoto = $response->json('url');
                }
            } catch (\Exception $e) {
                // Skip jika gagal
            }
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
