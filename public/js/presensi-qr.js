// FILE: public/js/presensi-qr.js
// Logic halaman QR Code presensi
// SIAKAD SMP Negeri 17 Makassar

document.addEventListener('DOMContentLoaded', function () {

    // Tampilkan jam realtime
    const elJam = document.getElementById('jam-sekarang');

    function updateJam() {
        const sekarang = new Date();
        const jam      = String(sekarang.getHours()).padStart(2, '0');
        const menit    = String(sekarang.getMinutes()).padStart(2, '0');
        const detik    = String(sekarang.getSeconds()).padStart(2, '0');
        if (elJam) {
            elJam.textContent = jam + ':' + menit + ':' + detik;
        }
    }

    updateJam();
    setInterval(updateJam, 1000);

    // Auto refresh halaman setiap 15 detik
    // Agar daftar siswa yang scan terupdate otomatis
    setInterval(function () {
        window.location.reload();
    }, 15 * 1000);

});
