// FILE: public/js/nilai.js
// Logic halaman input nilai
// SIAKAD SMP Negeri 17 Makassar

document.addEventListener('DOMContentLoaded', function () {

    // Hitung nilai akhir secara realtime saat input berubah
    const daftarBaris = document.querySelectorAll('tbody tr');

    daftarBaris.forEach(function (baris) {

        const inputTugas  = baris.querySelector('input[name$="[tugas]"]');
        const inputUts    = baris.querySelector('input[name$="[uts]"]');
        const inputUas    = baris.querySelector('input[name$="[uas]"]');
        const elNilaiAkhir = baris.querySelector('.nilai-akhir-display');

        if (!inputTugas || !inputUts || !inputUas || !elNilaiAkhir) {
            return;
        }

        function hitungNilaiAkhir() {
            const tugas = parseFloat(inputTugas.value);
            const uts   = parseFloat(inputUts.value);
            const uas   = parseFloat(inputUas.value);

            if (!isNaN(tugas) && !isNaN(uts) && !isNaN(uas)) {
                const nilaiAkhir = ((tugas * 0.3) + (uts * 0.3) + (uas * 0.4)).toFixed(2);
                elNilaiAkhir.textContent = nilaiAkhir;
                elNilaiAkhir.style.color = nilaiAkhir >= 80 ? '#03d930' : nilaiAkhir >= 70 ? '#e6a800' : '#d234b0';
            } else {
                elNilaiAkhir.textContent = '—';
                elNilaiAkhir.style.color = '#111111';
            }
        }

        inputTugas.addEventListener('input', hitungNilaiAkhir);
        inputUts.addEventListener('input', hitungNilaiAkhir);
        inputUas.addEventListener('input', hitungNilaiAkhir);
    });

});
