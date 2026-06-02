<?php

// FILE: database/seeders/KalenderAkademikSeeder.php
// Seeder kalender akademik tahun ajaran 2024/2025
// SIAKAD SMP Negeri 17 Makassar

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KalenderAkademikSeeder extends Seeder
{
    public function run(): void
    {
        $daftarKalender = [
            [
                'judul'           => 'Hari Raya Idul Fitri',
                'tanggal_mulai'   => '2025-03-30',
                'tanggal_selesai' => '2025-04-07',
                'jenis'           => 'libur_nasional',
                'keterangan'      => 'Libur Hari Raya Idul Fitri 1446 H',
            ],
            [
                'judul'           => 'Ujian Tengah Semester Genap',
                'tanggal_mulai'   => '2025-03-10',
                'tanggal_selesai' => '2025-03-14',
                'jenis'           => 'ujian',
                'keterangan'      => 'UTS Semester Genap Tahun Ajaran 2024/2025',
            ],
            [
                'judul'           => 'Ujian Akhir Semester Genap',
                'tanggal_mulai'   => '2025-05-19',
                'tanggal_selesai' => '2025-05-23',
                'jenis'           => 'ujian',
                'keterangan'      => 'UAS Semester Genap Tahun Ajaran 2024/2025',
            ],
            [
                'judul'           => 'Class Meeting',
                'tanggal_mulai'   => '2025-05-26',
                'tanggal_selesai' => '2025-05-30',
                'jenis'           => 'kegiatan',
                'keterangan'      => 'Class Meeting Akhir Semester Genap',
            ],
            [
                'judul'           => 'Libur Kenaikan Kelas',
                'tanggal_mulai'   => '2025-06-16',
                'tanggal_selesai' => '2025-07-13',
                'jenis'           => 'libur_sekolah',
                'keterangan'      => 'Libur akhir tahun ajaran 2024/2025',
            ],
            [
                'judul'           => 'Hari Pendidikan Nasional',
                'tanggal_mulai'   => '2025-05-02',
                'tanggal_selesai' => '2025-05-02',
                'jenis'           => 'libur_nasional',
                'keterangan'      => 'Peringatan Hari Pendidikan Nasional',
            ],
        ];

        foreach ($daftarKalender as $kalender) {
            DB::table('kalender_akademik')->insert([
                'judul'           => $kalender['judul'],
                'tanggal_mulai'   => $kalender['tanggal_mulai'],
                'tanggal_selesai' => $kalender['tanggal_selesai'],
                'jenis'           => $kalender['jenis'],
                'keterangan'      => $kalender['keterangan'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}


// ===================================================
// FILE: database/seeders/PengumumanSeeder.php
// Seeder data pengumuman sekolah
// SIAKAD SMP Negeri 17 Makassar
// ===================================================

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $daftarPengumuman = [
            [
                'judul'            => 'Jadwal Ujian Akhir Semester Genap 2024/2025',
                'isi'              => 'Ujian Akhir Semester Genap akan dilaksanakan pada tanggal 19 - 23 Mei 2025. Seluruh siswa diharapkan mempersiapkan diri dengan baik dan hadir tepat waktu.',
                'ditujukan'        => 'semua',
                'tanggal_tayang'   => '2025-05-01',
                'tanggal_berakhir' => '2025-05-23',
            ],
            [
                'judul'            => 'Pengumuman Class Meeting Akhir Semester',
                'isi'              => 'Class Meeting akan dilaksanakan pada tanggal 26 - 30 Mei 2025. Berbagai lomba menarik telah disiapkan. Seluruh siswa wajib mengikuti kegiatan ini.',
                'ditujukan'        => 'semua',
                'tanggal_tayang'   => '2025-05-15',
                'tanggal_berakhir' => '2025-05-30',
            ],
            [
                'judul'            => 'Informasi Pengisian Presensi Digital',
                'isi'              => 'Mulai semester ini, presensi siswa dilakukan secara digital menggunakan SIAKAD. Siswa wajib melakukan scan QR Code saat pelajaran dimulai.',
                'ditujukan'        => 'siswa',
                'tanggal_tayang'   => '2025-04-01',
                'tanggal_berakhir' => null,
            ],
        ];

        foreach ($daftarPengumuman as $pengumuman) {
            DB::table('pengumuman')->insert([
                'judul'            => $pengumuman['judul'],
                'isi'              => $pengumuman['isi'],
                'ditujukan'        => $pengumuman['ditujukan'],
                'tanggal_tayang'   => $pengumuman['tanggal_tayang'],
                'tanggal_berakhir' => $pengumuman['tanggal_berakhir'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
