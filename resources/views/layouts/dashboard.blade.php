<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — SIAKAD SMPN 17 Makassar</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    {{-- AOS CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    {{-- Lucide Icon --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- Tailwind + App CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Dashboard CSS --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    {{-- CSS tambahan per halaman --}}
    @stack('css')
</head>

<body>

    {{-- Wrapper utama --}}
    <div class="dashboard-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar" id="sidebar">

            {{-- Logo & nama sekolah --}}
            <div class="sidebar-header">
                <img src="{{ asset('img/logo.png') }}" alt="Logo SMPN 17 Makassar">
                <div class="sidebar-nama">
                    <span class="sidebar-nama-sistem">SIAKAD</span>
                    <span class="sidebar-nama-sekolah">SMPN 17 Makassar</span>
                </div>
            </div>

            {{-- Info pengguna --}}
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(session('nama'), 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <span class="sidebar-user-nama">{{ session('nama') }}</span>
                    <span class="sidebar-user-role">{{ ucfirst(str_replace('_', ' ', session('role'))) }}</span>
                </div>
            </div>

            {{-- Menu navigasi sesuai role --}}
            <nav class="sidebar-nav">
                @yield('sidebar-menu')
            </nav>

            {{-- Tombol logout --}}
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="form-logout">
                    @csrf
                </form>
                <button class="neo-btn neo-btn-putih sidebar-logout" onclick="konfirmasiLogout()">
                    <i data-lucide="log-out"></i>
                    Keluar
                </button>
            </div>

        </aside>

        {{-- KONTEN UTAMA --}}
        <div class="dashboard-main">

            {{-- Header atas --}}
            <header class="dashboard-header">
                <button class="sidebar-toggle" id="sidebar-toggle">
                    <i data-lucide="menu"></i>
                </button>
                <h1 class="dashboard-page-title">@yield('page-title', 'Dashboard')</h1>
            </header>

            {{-- Isi halaman --}}
            <main class="dashboard-konten">
                @yield('konten')
            </main>

        </div>

    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.all.min.js"></script>

    {{-- AOS JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    {{-- Sidebar JS --}}
    <script src="{{ asset('js/sidebar.js') }}"></script>

    {{-- App JS --}}
    <script>
        // Inisialisasi Lucide Icon
        lucide.createIcons();

        // Inisialisasi AOS
        AOS.init({
            duration: 500,
            once: true,
            offset: 60,
        });

        // Konfirmasi logout
        function konfirmasiLogout() {
            Swal.fire({
                title: 'Keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2c46c4',
                cancelButtonColor: '#111111',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-logout').submit();
                }
            });
        }

        // Konfirmasi hapus data — dipakai semua halaman
        function konfirmasiHapus(formId) {
            Swal.fire({
                title: 'Hapus data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d234b0',
                cancelButtonColor: '#111111',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    {{-- JS tambahan per halaman --}}
    @stack('js')

</body>

</html>
