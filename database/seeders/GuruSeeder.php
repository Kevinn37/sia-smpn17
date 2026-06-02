<?php

// FILE: database/seeders/GuruSeeder.php
// Seeder data guru — diperbaiki relasi id_user
// SIAKAD SMP Negeri 17 Makassar

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $daftarGuru = [
            [
                'nama'          => 'Budi Santoso, S.Pd',
                'nip'           => '198501012010011001',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1985-01-01',
                'alamat'        => 'Jl. Perintis Kemerdekaan No.10, Makassar',
                'no_telepon'    => '081234567001',
            ],
            [
                'nama'          => 'Sari Dewi, S.Pd',
                'nip'           => '198703152012012002',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1987-03-15',
                'alamat'        => 'Jl. Sultan Alauddin No.25, Makassar',
                'no_telepon'    => '081234567002',
            ],
            [
                'nama'          => 'Hendra Wijaya, S.Pd',
                'nip'           => '199001202014011003',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1990-01-20',
                'alamat'        => 'Jl. Urip Sumoharjo No.5, Makassar',
                'no_telepon'    => '081234567003',
            ],
            [
                'nama'          => 'Rina Marlina, S.Pd',
                'nip'           => '198906102013012004',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1989-06-10',
                'alamat'        => 'Jl. Hertasning No.8, Makassar',
                'no_telepon'    => '081234567004',
            ],
            [
                'nama'          => 'Agus Pratama, S.Pd',
                'nip'           => '199205182015011005',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1992-05-18',
                'alamat'        => 'Jl. A.P. Pettarani No.12, Makassar',
                'no_telepon'    => '081234567005',
            ],
        ];

        foreach ($daftarGuru as $guru) {

            // Cari id_user berdasarkan username (NIP)
            // UserSeeder sudah membuat akun guru dengan username = NIP
            $id_user = DB::table('users')
                ->where('username', $guru['nip'])
                ->value('id_user');

            // Lewati jika user tidak ditemukan
            if (!$id_user) {
                continue;
            }

            DB::table('guru')->insert([
                'id_user'       => $id_user,
                'nip'           => $guru['nip'],
                'nama'          => $guru['nama'],
                'jenis_kelamin' => $guru['jenis_kelamin'],
                'tanggal_lahir' => $guru['tanggal_lahir'],
                'alamat'        => $guru['alamat'],
                'no_telepon'    => $guru['no_telepon'],
                'foto'          => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
