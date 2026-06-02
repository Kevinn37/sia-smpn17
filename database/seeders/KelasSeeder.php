<?php

// FILE: database/seeders/KelasSeeder.php
// Seeder data kelas 7, 8, 9
// SIAKAD SMP Negeri 17 Makassar

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $daftarKelas = [
            ['tingkat' => 7, 'nomor' => 1, 'nama_kelas' => '7.1'],
            ['tingkat' => 7, 'nomor' => 2, 'nama_kelas' => '7.2'],
            ['tingkat' => 7, 'nomor' => 3, 'nama_kelas' => '7.3'],
            ['tingkat' => 8, 'nomor' => 1, 'nama_kelas' => '8.1'],
            ['tingkat' => 8, 'nomor' => 2, 'nama_kelas' => '8.2'],
            ['tingkat' => 8, 'nomor' => 3, 'nama_kelas' => '8.3'],
            ['tingkat' => 9, 'nomor' => 1, 'nama_kelas' => '9.1'],
            ['tingkat' => 9, 'nomor' => 2, 'nama_kelas' => '9.2'],
            ['tingkat' => 9, 'nomor' => 3, 'nama_kelas' => '9.3'],
        ];

        foreach ($daftarKelas as $kelas) {
            DB::table('kelas')->insert([
                'tingkat'    => $kelas['tingkat'],
                'nomor'      => $kelas['nomor'],
                'nama_kelas' => $kelas['nama_kelas'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
