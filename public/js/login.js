document.addEventListener("DOMContentLoaded", function () {
    const inputPassword = document.getElementById("password");
    const tombolToggle = document.getElementById("toggle-password");
    const ikonPassword = document.getElementById("icon-password");

    // Toggle tampil / sembunyikan password
    tombolToggle.addEventListener("click", function () {
        const sedangSembunyi = inputPassword.type === "password";

        inputPassword.type = sedangSembunyi ? "text" : "password";

        // Ganti ikon sesuai kondisi
        ikonPassword.setAttribute(
            "data-lucide",
            sedangSembunyi ? "eye-off" : "eye",
        );

        // Re-render lucide icon
        lucide.createIcons();
    });
});
