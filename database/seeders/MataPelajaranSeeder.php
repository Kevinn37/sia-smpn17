<?php

// FILE: database/seeders/MataPelajaranSeeder.php
// Seeder data mata pelajaran
// SIAKAD SMP Negeri 17 Makassar

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $daftarMapel = [
            ['kode_mapel' => 'MTK',  'nama_mapel' => 'Matematika'],
            ['kode_mapel' => 'BIN',  'nama_mapel' => 'Bahasa Indonesia'],
            ['kode_mapel' => 'BIG',  'nama_mapel' => 'Bahasa Inggris'],
            ['kode_mapel' => 'IPA',  'nama_mapel' => 'Ilmu Pengetahuan Alam'],
            ['kode_mapel' => 'IPS',  'nama_mapel' => 'Ilmu Pengetahuan Sosial'],
        ];

        foreach ($daftarMapel as $mapel) {
            DB::table('mata_pelajaran')->insert([
                'kode_mapel' => $mapel['kode_mapel'],
                'nama_mapel' => $mapel['nama_mapel'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}


// ===================================================
// FILE: database/seeders/JadwalPelajaranSeeder.php
// Seeder jadwal pelajaran
// SIAKAD SMP Negeri 17 Makassar
// ===================================================

// Catatan relasi:
// id_guru  : 1=Budi(MTK), 2=Sari(BIN), 3=Hendra(BIG), 4=Rina(IPA), 5=Agus(IPS)
// id_mapel : 1=MTK, 2=BIN, 3=BIG, 4=IPA, 5=IPS
// id_kelas : 1=7.1, 2=7.2, 3=7.3, 4=8.1, 5=8.2, 6=8.3, 7=9.1, 8=9.2, 9=9.3

class JadwalPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $daftarJadwal = [

            // Kelas 7.1
            ['id_kelas' => 1, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Senin',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 1, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Selasa', 'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 1, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Rabu',   'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 1, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Kamis',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 1, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Jumat',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],

            // Kelas 7.2
            ['id_kelas' => 2, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Senin',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 2, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Selasa', 'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 2, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Rabu',   'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 2, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Kamis',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 2, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Jumat',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],

            // Kelas 7.3
            ['id_kelas' => 3, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Senin',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 3, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Selasa', 'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 3, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Rabu',   'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 3, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Kamis',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 3, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Jumat',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],

            // Kelas 8.1
            ['id_kelas' => 4, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Senin',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 4, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Rabu',   'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 4, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Kamis',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 4, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Selasa', 'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 4, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Jumat',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],

            // Kelas 8.2
            ['id_kelas' => 5, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Selasa', 'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 5, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Rabu',   'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 5, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Senin',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 5, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Kamis',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 5, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Jumat',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],

            // Kelas 8.3
            ['id_kelas' => 6, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Rabu',   'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 6, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Senin',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 6, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Selasa', 'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 6, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Jumat',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 6, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Kamis',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],

            // Kelas 9.1
            ['id_kelas' => 7, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Senin',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 7, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Selasa', 'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 7, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Rabu',   'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 7, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Kamis',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 7, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Jumat',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],

            // Kelas 9.2
            ['id_kelas' => 8, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Selasa', 'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 8, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Rabu',   'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 8, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Kamis',  'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 8, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Senin',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 8, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Jumat',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],

            // Kelas 9.3
            ['id_kelas' => 9, 'id_guru' => 1, 'id_mapel' => 1, 'hari' => 'Rabu',   'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 9, 'id_guru' => 2, 'id_mapel' => 2, 'hari' => 'Kamis',  'jam_mulai' => '09:15', 'jam_selesai' => '10:45'],
            ['id_kelas' => 9, 'id_guru' => 3, 'id_mapel' => 3, 'hari' => 'Senin',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
            ['id_kelas' => 9, 'id_guru' => 4, 'id_mapel' => 4, 'hari' => 'Selasa', 'jam_mulai' => '07:30', 'jam_selesai' => '09:00'],
            ['id_kelas' => 9, 'id_guru' => 5, 'id_mapel' => 5, 'hari' => 'Jumat',  'jam_mulai' => '11:00', 'jam_selesai' => '12:30'],
        ];

        foreach ($daftarJadwal as $jadwal) {
            DB::table('jadwal_pelajaran')->insert([
                'id_kelas'    => $jadwal['id_kelas'],
                'id_guru'     => $jadwal['id_guru'],
                'id_mapel'    => $jadwal['id_mapel'],
                'hari'        => $jadwal['hari'],
                'jam_mulai'   => $jadwal['jam_mulai'],
                'jam_selesai' => $jadwal['jam_selesai'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
