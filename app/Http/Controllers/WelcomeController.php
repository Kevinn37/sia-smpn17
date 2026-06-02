<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil pengumuman yang masih aktif untuk ditampilkan di landing
        $daftarPengumuman = DB::table('pengumuman')
            ->where('ditujukan', 'semua')
            ->where('tanggal_tayang', '<=', now()->toDateString())
            ->where(function ($query) {
                $query->whereNull('tanggal_berakhir')
                      ->orWhere('tanggal_berakhir', '>=', now()->toDateString());
            })
            ->orderBy('tanggal_tayang', 'desc')
            ->limit(3)
            ->get();

        $jumlahSiswa = DB::table('siswa')->count();

        return view('welcome', compact('daftarPengumuman', 'jumlahSiswa'));
    }
}
