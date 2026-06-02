<?php

// FILE: database/seeders/DatabaseSeeder.php
// Seeder utama — memanggil semua seeder
// SIAKAD SMP Negeri 17 Makassar

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KelasSeeder::class,
            UserSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            MataPelajaranSeeder::class,
            JadwalPelajaranSeeder::class,
            KalenderAkademikSeeder::class,
            PengumumanSeeder::class,
        ]);
    }
}
