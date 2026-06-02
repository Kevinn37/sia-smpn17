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
// MULAI SCAN KAMERA
// ===========================
function mulaiScan() {
    const btnMulai = document.getElementById("btn-mulai-scan");
    const btnStop = document.getElementById("btn-stop-scan");

    // Cek apakah browser mendukung getUserMedia
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        Swal.fire({
            icon: "error",
            title: "Kamera Tidak Didukung",
            text: "Browser ini tidak mendukung akses kamera. Pastikan halaman dibuka lewat HTTPS dan gunakan Chrome atau Safari versi terbaru.",
            confirmButtonColor: "#2c46c4",
        });
        return;
    }

    html5QrCode = new Html5Qrcode("qr-reader");

    // Langsung start tanpa getCameras() — lebih kompatibel di HP
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
                // Abaikan error scanning frame biasa
            },
        )
        .then(function () {
            sedangScan = true;
            btnMulai.style.display = "none";
            btnStop.style.display = "block";
            lucide.createIcons();
        })
        .catch(function (err) {
            console.error("QR Scanner Error:", err);

            let pesanError =
                "Pastikan browser memiliki izin kamera dan halaman diakses lewat HTTPS.";

            // Pesan lebih spesifik berdasarkan jenis error
            if (err && typeof err === "string") {
                pesanError = err;
            } else if (err?.message) {
                if (
                    err.message.includes("Permission") ||
                    err.message.includes("permission") ||
                    err.message.includes("NotAllowed")
                ) {
                    pesanError =
                        "Izin kamera ditolak. Buka pengaturan browser dan izinkan akses kamera untuk situs ini.";
                } else if (
                    err.message.includes("NotFound") ||
                    err.message.includes("Requested device not found")
                ) {
                    pesanError = "Kamera tidak ditemukan pada perangkat ini.";
                } else if (err.message.includes("NotReadable")) {
                    pesanError =
                        "Kamera sedang digunakan oleh aplikasi lain. Tutup aplikasi kamera lalu coba lagi.";
                } else {
                    pesanError = err.message;
                }
            }

            Swal.fire({
                icon: "error",
                title: "Kamera tidak bisa diakses",
                text: pesanError,
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
        html5QrCode
            .stop()
            .then(function () {
                html5QrCode.clear();
                sedangScan = false;
                btnMulai.style.display = "block";
                btnStop.style.display = "none";
                lucide.createIcons();
            })
            .catch(function (err) {
                // Paksa reset state meski stop gagal
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
