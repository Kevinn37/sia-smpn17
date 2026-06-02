<?php

// FILE: database/seeders/SiswaSeeder.php
// Seeder data siswa — 5 siswa per kelas (9 kelas = 45 siswa)
// SIAKAD SMP Negeri 17 Makassar

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Data siswa per kelas
        // id_kelas 1-9 sesuai urutan KelasSeeder
        $daftarSiswa = [

            // Kelas 7.1 — id_kelas: 1
            ['id_kelas' => 1, 'nis' => '2324001', 'nama' => 'Ahmad Fadhil',        'jk' => 'L', 'tgl' => '2011-03-10'],
            ['id_kelas' => 1, 'nis' => '2324002', 'nama' => 'Aisyah Ramadhani',    'jk' => 'P', 'tgl' => '2011-06-22'],
            ['id_kelas' => 1, 'nis' => '2324003', 'nama' => 'Bagas Prasetyo',      'jk' => 'L', 'tgl' => '2011-01-15'],
            ['id_kelas' => 1, 'nis' => '2324004', 'nama' => 'Citra Aulia',         'jk' => 'P', 'tgl' => '2011-09-07'],
            ['id_kelas' => 1, 'nis' => '2324005', 'nama' => 'Dimas Ardiansyah',    'jk' => 'L', 'tgl' => '2011-04-30'],

            // Kelas 7.2 — id_kelas: 2
            ['id_kelas' => 2, 'nis' => '2324006', 'nama' => 'Elisa Putri',         'jk' => 'P', 'tgl' => '2011-07-18'],
            ['id_kelas' => 2, 'nis' => '2324007', 'nama' => 'Farhan Maulana',      'jk' => 'L', 'tgl' => '2011-02-25'],
            ['id_kelas' => 2, 'nis' => '2324008', 'nama' => 'Gita Safira',         'jk' => 'P', 'tgl' => '2011-11-03'],
            ['id_kelas' => 2, 'nis' => '2324009', 'nama' => 'Haikal Akbar',        'jk' => 'L', 'tgl' => '2011-08-12'],
            ['id_kelas' => 2, 'nis' => '2324010', 'nama' => 'Indah Permatasari',   'jk' => 'P', 'tgl' => '2011-05-20'],

            // Kelas 7.3 — id_kelas: 3
            ['id_kelas' => 3, 'nis' => '2324011', 'nama' => 'Joko Susanto',        'jk' => 'L', 'tgl' => '2011-12-01'],
            ['id_kelas' => 3, 'nis' => '2324012', 'nama' => 'Kirana Salsabila',    'jk' => 'P', 'tgl' => '2011-03-28'],
            ['id_kelas' => 3, 'nis' => '2324013', 'nama' => 'Lukman Hakim',        'jk' => 'L', 'tgl' => '2011-10-14'],
            ['id_kelas' => 3, 'nis' => '2324014', 'nama' => 'Mira Agustina',       'jk' => 'P', 'tgl' => '2011-06-05'],
            ['id_kelas' => 3, 'nis' => '2324015', 'nama' => 'Naufal Rizky',        'jk' => 'L', 'tgl' => '2011-01-22'],

            // Kelas 8.1 — id_kelas: 4
            ['id_kelas' => 4, 'nis' => '2223001', 'nama' => 'Omar Abdullah',       'jk' => 'L', 'tgl' => '2010-04-16'],
            ['id_kelas' => 4, 'nis' => '2223002', 'nama' => 'Putri Handayani',     'jk' => 'P', 'tgl' => '2010-09-30'],
            ['id_kelas' => 4, 'nis' => '2223003', 'nama' => 'Qori Ramadhani',      'jk' => 'P', 'tgl' => '2010-02-08'],
            ['id_kelas' => 4, 'nis' => '2223004', 'nama' => 'Rizal Firmansyah',    'jk' => 'L', 'tgl' => '2010-07-24'],
            ['id_kelas' => 4, 'nis' => '2223005', 'nama' => 'Siti Nurhaliza',      'jk' => 'P', 'tgl' => '2010-11-11'],

            // Kelas 8.2 — id_kelas: 5
            ['id_kelas' => 5, 'nis' => '2223006', 'nama' => 'Taufik Hidayat',      'jk' => 'L', 'tgl' => '2010-03-19'],
            ['id_kelas' => 5, 'nis' => '2223007', 'nama' => 'Ulfa Maharani',       'jk' => 'P', 'tgl' => '2010-08-07'],
            ['id_kelas' => 5, 'nis' => '2223008', 'nama' => 'Vicky Nugraha',       'jk' => 'L', 'tgl' => '2010-05-13'],
            ['id_kelas' => 5, 'nis' => '2223009', 'nama' => 'Wulandari Putri',     'jk' => 'P', 'tgl' => '2010-12-25'],
            ['id_kelas' => 5, 'nis' => '2223010', 'nama' => 'Xander Pratama',      'jk' => 'L', 'tgl' => '2010-01-31'],

            // Kelas 8.3 — id_kelas: 6
            ['id_kelas' => 6, 'nis' => '2223011', 'nama' => 'Yanti Kusuma',        'jk' => 'P', 'tgl' => '2010-06-17'],
            ['id_kelas' => 6, 'nis' => '2223012', 'nama' => 'Zaki Mubarak',        'jk' => 'L', 'tgl' => '2010-10-04'],
            ['id_kelas' => 6, 'nis' => '2223013', 'nama' => 'Annisa Fitriani',     'jk' => 'P', 'tgl' => '2010-04-22'],
            ['id_kelas' => 6, 'nis' => '2223014', 'nama' => 'Bayu Setiawan',       'jk' => 'L', 'tgl' => '2010-09-09'],
            ['id_kelas' => 6, 'nis' => '2223015', 'nama' => 'Cindy Claudia',       'jk' => 'P', 'tgl' => '2010-02-14'],

            // Kelas 9.1 — id_kelas: 7
            ['id_kelas' => 7, 'nis' => '2122001', 'nama' => 'Dani Kurniawan',      'jk' => 'L', 'tgl' => '2009-05-28'],
            ['id_kelas' => 7, 'nis' => '2122002', 'nama' => 'Eka Rahayu',          'jk' => 'P', 'tgl' => '2009-11-15'],
            ['id_kelas' => 7, 'nis' => '2122003', 'nama' => 'Fandi Ahmad',         'jk' => 'L', 'tgl' => '2009-03-03'],
            ['id_kelas' => 7, 'nis' => '2122004', 'nama' => 'Gina Septiana',       'jk' => 'P', 'tgl' => '2009-08-21'],
            ['id_kelas' => 7, 'nis' => '2122005', 'nama' => 'Hafiz Ramadan',       'jk' => 'L', 'tgl' => '2009-01-09'],

            // Kelas 9.2 — id_kelas: 8
            ['id_kelas' => 8, 'nis' => '2122006', 'nama' => 'Ika Wahyuni',         'jk' => 'P', 'tgl' => '2009-07-14'],
            ['id_kelas' => 8, 'nis' => '2122007', 'nama' => 'Jihan Nabila',        'jk' => 'P', 'tgl' => '2009-04-02'],
            ['id_kelas' => 8, 'nis' => '2122008', 'nama' => 'Kevin Ardian',        'jk' => 'L', 'tgl' => '2009-12-18'],
            ['id_kelas' => 8, 'nis' => '2122009', 'nama' => 'Laila Nur Azizah',    'jk' => 'P', 'tgl' => '2009-06-26'],
            ['id_kelas' => 8, 'nis' => '2122010', 'nama' => 'Muhammad Ilham',      'jk' => 'L', 'tgl' => '2009-10-10'],

            // Kelas 9.3 — id_kelas: 9
            ['id_kelas' => 9, 'nis' => '2122011', 'nama' => 'Nabila Azzahra',      'jk' => 'P', 'tgl' => '2009-02-07'],
            ['id_kelas' => 9, 'nis' => '2122012', 'nama' => 'Oscar Pratama',       'jk' => 'L', 'tgl' => '2009-09-23'],
            ['id_kelas' => 9, 'nis' => '2122013', 'nama' => 'Putri Amalia',        'jk' => 'P', 'tgl' => '2009-05-11'],
            ['id_kelas' => 9, 'nis' => '2122014', 'nama' => 'Rafi Putra',          'jk' => 'L', 'tgl' => '2009-03-29'],
            ['id_kelas' => 9, 'nis' => '2122015', 'nama' => 'Salma Zahra',         'jk' => 'P', 'tgl' => '2009-08-16'],
        ];

        foreach ($daftarSiswa as $siswa) {

            // Buat akun user untuk siswa
            // Username dan password default = NIS
            $id_user = DB::table('users')->insertGetId([
                'nama'       => $siswa['nama'],
                'username'   => $siswa['nis'],
                'password'   => bcrypt($siswa['nis']),
                'role'       => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Buat data siswa
            DB::table('siswa')->insert([
                'id_user'       => $id_user,
                'id_kelas'      => $siswa['id_kelas'],
                'nis'           => $siswa['nis'],
                'nama'          => $siswa['nama'],
                'jenis_kelamin' => $siswa['jk'],
                'tanggal_lahir' => $siswa['tgl'],
                'alamat'        => 'Makassar, Sulawesi Selatan',
                'foto'          => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
