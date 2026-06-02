// FILE: public/js/siswa-scan.js
// Logic scan QR Code untuk presensi siswa
// SIAKAD SMP Negeri 17 Makassar

// URL scan dari Laravel — dikirim via meta tag
const urlScan =
    document.querySelector('meta[name="url-scan"]')?.content ||
    window.location.origin + "/siswa/presensi/scan";

let html5QrCode = null;
let sedangScan = false;

// ===========================
// GANTI TAB
// ===========================
function gantiTab(tab) {
    const panelKamera = document.getElementById("panel-kamera");
    const panelManual = document.getElementById("panel-manual");
    const tabKamera = document.getElementById("tab-kamera");
    const tabManual = document.getElementById("tab-manual");

    // Stop scan dulu kalau sedang aktif
    if (sedangScan) {
        stopScan();
    }

    if (tab === "kamera") {
        panelKamera.style.display = "block";
        panelManual.style.display = "none";
        tabKamera.classList.add("aktif");
        tabManual.classList.remove("aktif");
    } else {
        panelKamera.style.display = "none";
        panelManual.style.display = "block";
        tabKamera.classList.remove("aktif");
        tabManual.classList.add("aktif");
    }

    // Re-render lucide icons
    lucide.createIcons();
}

// ===========================
// MULAI SCAN KAMERA
// ===========================
function mulaiScan() {
    const elReader = document.getElementById("qr-reader");
    const btnMulai = document.getElementById("btn-mulai-scan");
    const btnStop = document.getElementById("btn-stop-scan");

    html5QrCode = new Html5Qrcode("qr-reader");

    html5QrCode
        .start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 220, height: 220 },
                aspectRatio: 1.0,
            },
            function (decodedText) {
                // QR berhasil dibaca
                stopScan();
                prosesHasilScan(decodedText);
            },
            function (error) {
                // Abaikan error scanning biasa
            },
        )
        .then(function () {
            sedangScan = true;
            btnMulai.style.display = "none";
            btnStop.style.display = "block";
            lucide.createIcons();
        })
        .catch(function (err) {
            Swal.fire({
                icon: "error",
                title: "Kamera tidak bisa diakses",
                text: "Pastikan browser memiliki izin kamera. Gunakan Input Manual sebagai alternatif.",
                confirmButtonColor: "#2c46c4",
            });
        });
}

// ===========================
// STOP SCAN
// ===========================
function stopScan() {
    const btnMulai = document.getElementById("btn-mulai-scan");
    const btnStop = document.getElementById("btn-stop-scan");

    if (html5QrCode && sedangScan) {
        html5QrCode.stop().then(function () {
            html5QrCode.clear();
            sedangScan = false;
            btnMulai.style.display = "block";
            btnStop.style.display = "none";
            lucide.createIcons();
        });
    }
}

// ===========================
// PROSES HASIL SCAN
// ===========================
function prosesHasilScan(hasil) {
    // Ekstrak token dari URL hasil scan
    let token = hasil;

    try {
        const url = new URL(hasil);
        const params = new URLSearchParams(url.search);
        if (params.has("token")) {
            token = params.get("token");
        }
    } catch (e) {
        // Bukan URL — anggap langsung token
        token = hasil;
    }

    // Redirect ke route scan dengan token
    Swal.fire({
        icon: "info",
        title: "QR Terbaca!",
        text: "Memproses presensi...",
        timer: 1500,
        showConfirmButton: false,
    }).then(function () {
        window.location.href = urlScan + "?token=" + encodeURIComponent(token);
    });
}

// ===========================
// INIT
// ===========================
document.addEventListener("DOMContentLoaded", function () {
    lucide.createIcons();
});
