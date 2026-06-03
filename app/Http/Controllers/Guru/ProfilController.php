<?php

// FILE: app/Http/Controllers/Guru/ProfilController.php
// Edit profil guru — fix upload foto
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProfilController extends Controller
{
    public function index()
    {
        $guru = DB::table('guru')
            ->join('users', 'guru.id_user', '=', 'users.id_user')
            ->select('guru.*', 'users.username')
            ->where('guru.id_user', session('id_user'))
            ->first();

        return view('guru.profil.index', compact('guru'));
    }

    public function update(Request $request)
    {
        $guru = DB::table('guru')
            ->where('id_user', session('id_user'))
            ->first();

        $request->validate([
            'no_telepon' => 'nullable|max:20',
            'alamat'     => 'nullable',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'   => 'nullable|min:6|confirmed',
        ]);

        $namaFoto = $guru->foto;

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            try {
                $file = $request->file('foto');
                $namaFile = 'guru_' . session('id_user') . '_' . time() . '.' . $file->extension();

                $token = env('BLOB_READ_WRITE_TOKEN');

                // Upload ke Vercel Blob lewat HTTP API
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => $file->getMimeType(),
                    'x-content-type' => $file->getMimeType(),
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

        DB::table('guru')->where('id_guru', $guru->id_guru)->update([
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
            'foto'       => $namaFoto,
            'updated_at' => now(),
        ]);

        if ($request->filled('password')) {
            DB::table('users')->where('id_user', session('id_user'))->update([
                'password'   => bcrypt($request->password),
                'updated_at' => now(),
            ]);
        }

        // Update session nama jika berubah
        session(['foto_guru' => $namaFoto]);

        return redirect()->route('guru.profil')
            ->with('sukses', 'Profil berhasil diperbarui.');
    }
}
