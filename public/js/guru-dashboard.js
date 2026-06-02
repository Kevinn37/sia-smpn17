// FILE: public/js/guru-dashboard.js
// Logic dashboard guru
// SIAKAD SMP Negeri 17 Makassar

document.addEventListener('DOMContentLoaded', function () {

    // Auto refresh halaman setiap 5 menit
    // Berguna agar status sesi presensi selalu up to date
    setTimeout(function () {
        window.location.reload();
    }, 5 * 60 * 1000);

});
