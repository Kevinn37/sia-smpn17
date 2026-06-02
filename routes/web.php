<?php

// FILE: routes/web.php — FINAL COMPLETE
// Semua route aplikasi
// SIAKAD SMP Negeri 17 Makassar

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwal;
use App\Http\Controllers\Admin\KalenderController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;

// Guru
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Guru\PresensiController as GuruPresensi;
use App\Http\Controllers\Guru\NilaiController as GuruNilai;
use App\Http\Controllers\Guru\JadwalController as GuruJadwal;
use App\Http\Controllers\Guru\ProfilController as GuruProfil;

// Siswa
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\PresensiController as SiswaPresensi;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilai;
use App\Http\Controllers\Siswa\JadwalController as SiswaJadwal;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfil;

// Kepala Sekolah
use App\Http\Controllers\KepalaSekolah\DashboardController as KepsekDashboard;
use App\Http\Controllers\KepalaSekolah\MonitoringController;
use App\Http\Controllers\KepalaSekolah\LaporanController as KepsekLaporan;

// ===========================
// LANDING PAGE
// ===========================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// ===========================
// AUTH
// ===========================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===========================
// ADMIN
// ===========================
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('index');
        Route::get('/tambah', [SiswaController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [SiswaController::class, 'simpan'])->name('simpan');
        Route::get('/edit/{id_siswa}', [SiswaController::class, 'edit'])->name('edit');
        Route::post('/update/{id_siswa}', [SiswaController::class, 'update'])->name('update');
        Route::post('/hapus/{id_siswa}', [SiswaController::class, 'hapus'])->name('hapus');
    });

    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('index');
        Route::get('/tambah', [GuruController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [GuruController::class, 'simpan'])->name('simpan');
        Route::get('/edit/{id_guru}', [GuruController::class, 'edit'])->name('edit');
        Route::post('/update/{id_guru}', [GuruController::class, 'update'])->name('update');
        Route::post('/hapus/{id_guru}', [GuruController::class, 'hapus'])->name('hapus');
    });

    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('index');
        Route::get('/tambah', [KelasController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [KelasController::class, 'simpan'])->name('simpan');
        Route::get('/edit/{id_kelas}', [KelasController::class, 'edit'])->name('edit');
        Route::post('/update/{id_kelas}', [KelasController::class, 'update'])->name('update');
        Route::post('/hapus/{id_kelas}', [KelasController::class, 'hapus'])->name('hapus');
    });

    Route::prefix('mata-pelajaran')->name('mapel.')->group(function () {
        Route::get('/', [MataPelajaranController::class, 'index'])->name('index');
        Route::get('/tambah', [MataPelajaranController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [MataPelajaranController::class, 'simpan'])->name('simpan');
        Route::get('/edit/{id_mapel}', [MataPelajaranController::class, 'edit'])->name('edit');
        Route::post('/update/{id_mapel}', [MataPelajaranController::class, 'update'])->name('update');
        Route::post('/hapus/{id_mapel}', [MataPelajaranController::class, 'hapus'])->name('hapus');
    });

    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', [AdminJadwal::class, 'index'])->name('index');
        Route::get('/tambah', [AdminJadwal::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [AdminJadwal::class, 'simpan'])->name('simpan');
        Route::get('/edit/{id_jadwal}', [AdminJadwal::class, 'edit'])->name('edit');
        Route::post('/update/{id_jadwal}', [AdminJadwal::class, 'update'])->name('update');
        Route::post('/hapus/{id_jadwal}', [AdminJadwal::class, 'hapus'])->name('hapus');
    });

    Route::prefix('kalender')->name('kalender.')->group(function () {
        Route::get('/', [KalenderController::class, 'index'])->name('index');
        Route::get('/tambah', [KalenderController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [KalenderController::class, 'simpan'])->name('simpan');
        Route::get('/edit/{id_kalender}', [KalenderController::class, 'edit'])->name('edit');
        Route::post('/update/{id_kalender}', [KalenderController::class, 'update'])->name('update');
        Route::post('/hapus/{id_kalender}', [KalenderController::class, 'hapus'])->name('hapus');
    });

    Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
        Route::get('/', [PengumumanController::class, 'index'])->name('index');
        Route::get('/tambah', [PengumumanController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [PengumumanController::class, 'simpan'])->name('simpan');
        Route::get('/edit/{id_pengumuman}', [PengumumanController::class, 'edit'])->name('edit');
        Route::post('/update/{id_pengumuman}', [PengumumanController::class, 'update'])->name('update');
        Route::post('/hapus/{id_pengumuman}', [PengumumanController::class, 'hapus'])->name('hapus');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [AdminLaporan::class, 'index'])->name('index');
        Route::get('/presensi', [AdminLaporan::class, 'presensi'])->name('presensi');
        Route::get('/nilai', [AdminLaporan::class, 'nilai'])->name('nilai');
        Route::get('/export/presensi', [AdminLaporan::class, 'exportPresensi'])->name('export.presensi');
        Route::get('/export/nilai', [AdminLaporan::class, 'exportNilai'])->name('export.nilai');
    });

});

// ===========================
// GURU
// ===========================
Route::prefix('guru')->name('guru.')->middleware('role:guru')->group(function () {

    Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');

    Route::prefix('presensi')->name('presensi.')->group(function () {
        Route::get('/', [GuruPresensi::class, 'index'])->name('index');
        Route::post('/buka-sesi', [GuruPresensi::class, 'bukaSesi'])->name('buka-sesi');
        Route::get('/qr/{token}', [GuruPresensi::class, 'tampilQr'])->name('tampilQr');
        Route::post('/tutup-sesi/{id_sesi}', [GuruPresensi::class, 'tutupSesi'])->name('tutup-sesi');
        Route::get('/manual/{id_jadwal}', [GuruPresensi::class, 'manual'])->name('manual');
        Route::post('/manual/simpan', [GuruPresensi::class, 'simpanManual'])->name('manual.simpan');
        Route::get('/rekap', [GuruPresensi::class, 'rekap'])->name('rekap');
    });

    Route::prefix('nilai')->name('nilai.')->group(function () {
        Route::get('/', [GuruNilai::class, 'index'])->name('index');
        Route::get('/input/{id_jadwal}', [GuruNilai::class, 'input'])->name('input');
        Route::post('/simpan', [GuruNilai::class, 'simpan'])->name('simpan');
    });

    Route::get('/jadwal', [GuruJadwal::class, 'index'])->name('jadwal');

    Route::get('/profil', [GuruProfil::class, 'index'])->name('profil');
    Route::post('/profil/update', [GuruProfil::class, 'update'])->name('profil.update');

});

// ===========================
// SISWA
// ===========================
Route::prefix('siswa')->name('siswa.')->middleware('role:siswa')->group(function () {

    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');

    Route::prefix('presensi')->name('presensi.')->group(function () {
        Route::get('/', [SiswaPresensi::class, 'index'])->name('index');
        Route::get('/scan', [SiswaPresensi::class, 'scan'])->name('scan');
        Route::get('/rekap', [SiswaPresensi::class, 'rekap'])->name('rekap');
    });

    Route::get('/nilai', [SiswaNilai::class, 'index'])->name('nilai');
    Route::get('/jadwal', [SiswaJadwal::class, 'index'])->name('jadwal');

    Route::get('/profil', [SiswaProfil::class, 'index'])->name('profil');
    Route::post('/profil/update', [SiswaProfil::class, 'update'])->name('profil.update');

});

// ===========================
// KEPALA SEKOLAH
// ===========================
Route::prefix('kepala-sekolah')->name('kepala-sekolah.')->middleware('role:kepala_sekolah')->group(function () {

    Route::get('/dashboard', [KepsekDashboard::class, 'index'])->name('dashboard');

    Route::prefix('monitoring')->name('monitoring.')->group(function () {
        Route::get('/presensi', [MonitoringController::class, 'presensi'])->name('presensi');
        Route::get('/nilai', [MonitoringController::class, 'nilai'])->name('nilai');
        Route::get('/guru', [MonitoringController::class, 'guru'])->name('guru');
        Route::get('/siswa', [MonitoringController::class, 'siswa'])->name('siswa');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [KepsekLaporan::class, 'index'])->name('index');
        Route::get('/export', [KepsekLaporan::class, 'export'])->name('export');
    });

});
