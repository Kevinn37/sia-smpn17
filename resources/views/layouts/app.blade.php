{{-- FILE: resources/views/layouts/app.blade.php --}}
{{-- Layout dasar — dipakai semua halaman --}}
{{-- SIAKAD SMP Negeri 17 Makassar --}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIAKAD') — SMP Negeri 17 Makassar</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    {{-- Google Fonts — Archivo + Inter --}}
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

    {{-- CSS tambahan per halaman --}}
    @stack('css')
</head>

<body>

    {{-- Konten halaman --}}
    @yield('konten')

    {{-- SweetAlert2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.all.min.js"></script>

    {{-- AOS JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    {{-- App JS --}}
    <script>
        // Inisialisasi Lucide Icon
        lucide.createIcons();

        // Inisialisasi AOS
        AOS.init({
            duration: 600,
            once: true,
            offset: 80,
        });
    </script>

    {{-- JS tambahan per halaman --}}
    @stack('js')

</body>

</html>
