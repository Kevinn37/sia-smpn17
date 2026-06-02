<?php

// FILE: app/Http/Controllers/AuthController.php
// Menangani login dan logout semua role
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (session()->has('id_user')) {
            return $this->redirectDashboard(session('role'));
        }

        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Cari user berdasarkan username
        $result = DB::table('users')
            ->where('username', $username)
            ->first();

        // Cek user ditemukan dan password cocok
        if (!$result || !password_verify($password, $result->password)) {
            return redirect()->route('login')
                ->with('gagal', 'Username atau password salah.');
        }

        // Simpan data sesi
        session([
            'id_user' => $result->id_user,
            'nama'    => $result->nama,
            'role'    => $result->role,
        ]);

        // Redirect ke dashboard sesuai role
        return $this->redirectDashboard($result->role);
    }

    // Logout
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

    // Helper — redirect ke dashboard sesuai role
    private function redirectDashboard($role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            'kepala_sekolah' => redirect()->route('kepala-sekolah.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
