// FILE: public/js/admin-dashboard.js
// Logic halaman dashboard admin
// SIAKAD SMP Negeri 17 Makassar

document.addEventListener("DOMContentLoaded", function () {
    // Tandai menu sidebar yang sedang aktif
    const urlSekarang = window.location.pathname;
    const daftarMenuNav = document.querySelectorAll(".sidebar-nav a");

    daftarMenuNav.forEach(function (menu) {
        if (menu.getAttribute("href") === urlSekarang) {
            menu.classList.add("aktif");
        } else {
            menu.classList.remove("aktif");
        }
    });
});
