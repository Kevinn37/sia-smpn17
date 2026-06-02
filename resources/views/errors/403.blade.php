{{-- FILE: resources/views/errors/403.blade.php --}}
{{-- Halaman 403 Forbidden --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700;900&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family      : 'Inter', sans-serif;
            background       : #d234b0;
            min-height       : 100vh;
            display          : flex;
            align-items      : center;
            justify-content  : center;
            padding          : 2rem;
        }
        .error-box {
            background    : #ffffff;
            border        : 4px solid #111111;
            box-shadow    : 10px 10px 0px #111111;
            padding       : 3rem;
            text-align    : center;
            max-width     : 480px;
            width         : 100%;
        }
        .error-kode {
            font-family   : 'Archivo', sans-serif;
            font-size     : 8rem;
            font-weight   : 900;
            color         : #111111;
            line-height   : 1;
            border-bottom : 4px solid #111111;
            padding-bottom: 1rem;
            margin-bottom : 1.5rem;
        }
        .error-icon {
            display         : flex;
            align-items     : center;
            justify-content : center;
            width           : 64px;
            height          : 64px;
            background      : #d234b0;
            border          : 3px solid #111111;
            box-shadow      : 4px 4px 0px #111111;
            margin          : 0 auto 1.5rem;
        }
        .error-icon i { width: 32px; height: 32px; color: #ffffff; }
        .error-judul {
            font-family   : 'Archivo', sans-serif;
            font-size     : 1.5rem;
            font-weight   : 900;
            color         : #111111;
            margin-bottom : 0.75rem;
        }
        .error-pesan {
            font-family   : 'Inter', sans-serif;
            font-size     : 0.9rem;
            color         : #555555;
            line-height   : 1.7;
            margin-bottom : 2rem;
        }
        .error-aksi {
            display   : flex;
            gap       : 0.75rem;
            justify-content: center;
            flex-wrap : wrap;
        }
        .error-btn {
            display         : inline-flex;
            align-items     : center;
            gap             : 0.5rem;
            font-family     : 'Archivo', sans-serif;
            font-weight     : 800;
            font-size       : 0.95rem;
            padding         : 0.75rem 1.75rem;
            border          : 3px solid #111111;
            box-shadow      : 4px 4px 0px #111111;
            text-decoration : none;
            transition      : transform 0.1s, box-shadow 0.1s;
        }
        .error-btn:hover {
            transform  : translate(2px, 2px);
            box-shadow : 2px 2px 0px #111111;
        }
        .error-btn i  { width: 18px; height: 18px; }
        .btn-biru     { background: #2c46c4; color: #ffffff; }
        .btn-putih    { background: #ffffff; color: #111111; }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-kode">403</div>
        <div class="error-icon">
            <i data-lucide="shield-x"></i>
        </div>
        <h1 class="error-judul">Akses Ditolak</h1>
        <p class="error-pesan">
            Kamu tidak memiliki izin untuk mengakses halaman ini.
            Silakan login dengan akun yang sesuai.
        </p>
        <div class="error-aksi">
            <a href="{{ url('/') }}" class="error-btn btn-putih">
                <i data-lucide="home"></i>
                Beranda
            </a>
            <a href="{{ route('login') }}" class="error-btn btn-biru">
                <i data-lucide="log-in"></i>
                Login
            </a>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
