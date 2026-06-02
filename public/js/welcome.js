// FILE: public/js/landing.js
// Logic halaman landing page
// SIAKAD SMP Negeri 17 Makassar

document.addEventListener("DOMContentLoaded", function () {
    // Smooth scroll untuk link anchor
    const daftarLinkAnchor = document.querySelectorAll('a[href^="#"]');

    daftarLinkAnchor.forEach(function (link) {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const targetId = this.getAttribute("href");
            const targetEl = document.querySelector(targetId);

            if (targetEl) {
                targetEl.scrollIntoView({ behavior: "smooth" });
            }
        });
    });

    // Aktifkan nav highlight saat scroll
    const daftarSection = document.querySelectorAll("section[id]");

    window.addEventListener("scroll", function () {
        const scrollY = window.scrollY;

        daftarSection.forEach(function (section) {
            const tinggiSection = section.offsetHeight;
            const offsetSection = section.offsetTop - 80;

            if (
                scrollY > offsetSection &&
                scrollY <= offsetSection + tinggiSection
            ) {
                section.classList.add("section-aktif");
            } else {
                section.classList.remove("section-aktif");
            }
        });
    });
});
