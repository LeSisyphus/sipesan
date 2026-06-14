<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" type="image/png" href="{{ asset('sipesan-logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"/>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="text-on-surface font-body-md bg-[#F4F7FF] antialiased">

    {{-- BACKDROP MOBILE (Layar Gelap Vanilla JS) --}}
    <div id="mobile-backdrop" 
         onclick="toggleSidebar()" 
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300 opacity-0">
    </div>

    {{-- SIDEBAR --}}
    @include('components.admin-sidebar')

    {{-- CONTENT WRAPPER --}}
    {{-- FIX: HAPUS lg:ml-64 di sini biar ga double margin sama file childnya --}}
    <div class="min-h-screen flex flex-col transition-all duration-300 min-w-0">
        
        {{-- NAVBAR --}}
        @include('components.admin-navbar')

        {{-- MAIN CONTENT --}}
        @yield('content')

    </div>

    {{-- SCRIPT VANILLA JS --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const backdrop = document.getElementById('mobile-backdrop');

            // Geser sidebar masuk/keluar
            sidebar.classList.toggle('-translate-x-full');

            // Munculin/Hilangin layar gelap dengan animasi
            if (backdrop.classList.contains('hidden')) {
                backdrop.classList.remove('hidden');
                setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
            } else {
                backdrop.classList.add('opacity-0');
                setTimeout(() => backdrop.classList.add('hidden'), 300);
            }
        }
    </script>
</body>
</html>