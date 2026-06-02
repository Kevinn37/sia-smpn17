<?php

// FILE: database/seeders/UserSeeder.php
// Seeder akun login semua role
// SIAKAD SMP Negeri 17 Makassar

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $daftarUser = [

            // Admin
            [
                'nama'     => 'Administrator',
                'username' => 'admin',
                'password' => bcrypt('admin123'),
                'role'     => 'admin',
            ],

            // Kepala Sekolah
            [
                'nama'     => 'Drs. Ahmad Fauzi, M.Pd',
                'username' => 'kepsek',
                'password' => bcrypt('kepsek123'),
                'role'     => 'kepala_sekolah',
            ],

            // Guru — username: nip masing-masing
            [
                'nama'     => 'Budi Santoso, S.Pd',
                'username' => '198501012010011001',
                'password' => bcrypt('198501012010011001'),
                'role'     => 'guru',
            ],
            [
                'nama'     => 'Sari Dewi, S.Pd',
                'username' => '198703152012012002',
                'password' => bcrypt('198703152012012002'),
                'role'     => 'guru',
            ],
            [
                'nama'     => 'Hendra Wijaya, S.Pd',
                'username' => '199001202014011003',
                'password' => bcrypt('199001202014011003'),
                'role'     => 'guru',
            ],
            [
                'nama'     => 'Rina Marlina, S.Pd',
                'username' => '198906102013012004',
                'password' => bcrypt('198906102013012004'),
                'role'     => 'guru',
            ],
            [
                'nama'     => 'Agus Pratama, S.Pd',
                'username' => '199205182015011005',
                'password' => bcrypt('199205182015011005'),
                'role'     => 'guru',
            ],

            // Siswa — username: NIS masing-masing (dibuat di SiswaSeeder)
        ];

        foreach ($daftarUser as $user) {
            DB::table('users')->insert([
                'nama'       => $user['nama'],
                'username'   => $user['username'],
                'password'   => $user['password'],
                'role'       => $user['role'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
