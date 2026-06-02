// FILE: public/js/sidebar.js
// Toggle sidebar mobile
// SIAKAD SMP Negeri 17 Makassar

document.addEventListener('DOMContentLoaded', function () {

    const sidebar       = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

    // Toggle sidebar saat tombol diklik
    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('sidebar-aktif');
    });

    // Tutup sidebar jika klik di luar area sidebar (mobile)
    document.addEventListener('click', function (e) {
        const klikDiLuarSidebar  = !sidebar.contains(e.target);
        const klikBukanToggle    = !sidebarToggle.contains(e.target);
        const sidebarSedangBuka  = sidebar.classList.contains('sidebar-aktif');

        if (klikDiLuarSidebar && klikBukanToggle && sidebarSedangBuka) {
            sidebar.classList.remove('sidebar-aktif');
        }
    });

});
