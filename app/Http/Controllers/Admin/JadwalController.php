<?php

// FILE: app/Http/Controllers/Admin/JadwalController.php
// CRUD jadwal pelajaran
// SIAKAD SMP Negeri 17 Makassar

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    // Tampilkan daftar jadwal
    public function index(Request $request)
    {
        $id_kelas = $request->input('id_kelas');
        $hari     = $request->input('hari');

        $query = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'jadwal_pelajaran.id_guru', '=', 'guru.id_guru')
            ->join('mata_pelajaran', 'jadwal_pelajaran.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'jadwal_pelajaran.*',
                'kelas.nama_kelas',
                'guru.nama as nama_guru',
                'mata_pelajaran.nama_mapel',
                'mata_pelajaran.kode_mapel'
            );

        if ($id_kelas) {
            $query->where('jadwal_pelajaran.id_kelas', $id_kelas);
        }

        if ($hari) {
            $query->where('jadwal_pelajaran.hari', $hari);
        }

        $daftarJadwal = $query
            ->orderByRaw("FIELD(jadwal_pelajaran.hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('jadwal_pelajaran.jam_mulai')
            ->get();

        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();

        $daftarHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('admin.jadwal.index', compact(
            'daftarJadwal',
            'daftarKelas',
            'daftarHari',
            'id_kelas',
            'hari'
        ));
    }

    // Tampilkan form tambah jadwal
    public function tambah()
    {
        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();
        $daftarGuru  = DB::table('guru')->orderBy('nama')->get();
        $daftarMapel = DB::table('mata_pelajaran')->orderBy('nama_mapel')->get();
        $daftarHari  = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('admin.jadwal.tambah', compact(
            'daftarKelas',
            'daftarGuru',
            'daftarMapel',
            'daftarHari'
        ));
    }

    // Simpan jadwal baru
    public function simpan(Request $request)
    {
        $request->validate([
            'id_kelas'    => 'required',
            'id_guru'     => 'required',
            'id_mapel'    => 'required',
            'hari'        => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // Cek bentrok jadwal guru di hari dan jam yang sama
        $bentrokGuru = DB::table('jadwal_pelajaran')
            ->where('id_guru', $request->id_guru)
            ->where('hari', $request->hari)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })
            ->exists();

        if ($bentrokGuru) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jam_mulai' => 'Guru sudah memiliki jadwal di hari dan jam tersebut.']);
        }

        // Cek bentrok jadwal kelas di hari dan jam yang sama
        $bentrokKelas = DB::table('jadwal_pelajaran')
            ->where('id_kelas', $request->id_kelas)
            ->where('hari', $request->hari)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })
            ->exists();

        if ($bentrokKelas) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jam_mulai' => 'Kelas sudah memiliki jadwal di hari dan jam tersebut.']);
        }

        DB::table('jadwal_pelajaran')->insert([
            'id_kelas'    => $request->id_kelas,
            'id_guru'     => $request->id_guru,
            'id_mapel'    => $request->id_mapel,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('sukses', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    // Tampilkan form edit jadwal
    public function edit($id_jadwal)
    {
        $result = DB::table('jadwal_pelajaran')->where('id_jadwal', $id_jadwal)->first();

        if (!$result) {
            abort(404);
        }

        $daftarKelas = DB::table('kelas')->orderBy('tingkat')->orderBy('nomor')->get();
        $daftarGuru  = DB::table('guru')->orderBy('nama')->get();
        $daftarMapel = DB::table('mata_pelajaran')->orderBy('nama_mapel')->get();
        $daftarHari  = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('admin.jadwal.edit', compact(
            'result',
            'daftarKelas',
            'daftarGuru',
            'daftarMapel',
            'daftarHari'
        ));
    }

    // Update jadwal
    public function update(Request $request, $id_jadwal)
    {
        $result = DB::table('jadwal_pelajaran')->where('id_jadwal', $id_jadwal)->first();

        if (!$result) {
            abort(404);
        }

        $request->validate([
            'id_kelas'    => 'required',
            'id_guru'     => 'required',
            'id_mapel'    => 'required',
            'hari'        => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // Cek bentrok guru kecuali jadwal ini sendiri
        $bentrokGuru = DB::table('jadwal_pelajaran')
            ->where('id_guru', $request->id_guru)
            ->where('hari', $request->hari)
            ->where('id_jadwal', '!=', $id_jadwal)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })
            ->exists();

        if ($bentrokGuru) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jam_mulai' => 'Guru sudah memiliki jadwal di hari dan jam tersebut.']);
        }

        // Cek bentrok kelas kecuali jadwal ini sendiri
        $bentrokKelas = DB::table('jadwal_pelajaran')
            ->where('id_kelas', $request->id_kelas)
            ->where('hari', $request->hari)
            ->where('id_jadwal', '!=', $id_jadwal)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })
            ->exists();

        if ($bentrokKelas) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jam_mulai' => 'Kelas sudah memiliki jadwal di hari dan jam tersebut.']);
        }

        DB::table('jadwal_pelajaran')->where('id_jadwal', $id_jadwal)->update([
            'id_kelas'    => $request->id_kelas,
            'id_guru'     => $request->id_guru,
            'id_mapel'    => $request->id_mapel,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('sukses', 'Jadwal pelajaran berhasil diperbarui.');
    }

    // Hapus jadwal
    public function hapus($id_jadwal)
    {
        $result = DB::table('jadwal_pelajaran')->where('id_jadwal', $id_jadwal)->first();

        if (!$result) {
            abort(404);
        }

        DB::table('jadwal_pelajaran')->where('id_jadwal', $id_jadwal)->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('sukses', 'Jadwal pelajaran berhasil dihapus.');
    }
}
