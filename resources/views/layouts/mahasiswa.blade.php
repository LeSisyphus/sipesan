<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mahasiswa')</title>
    <link rel="icon" type="image/png" href="{{ asset('sipesan-logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- MATERIAL SYMBOLS & GOOGLE FONT --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-[Poppins] antialiased bg-[#F4F7FF] text-slate-800 bg-background text-on-surface">

    {{-- BACKDROP MOBILE (Layar Gelap) --}}
    <div id="mobile-backdrop" 
         onclick="toggleSidebar()" 
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300 opacity-0">
    </div>

    <div class="min-h-screen flex flex-col min-w-0">

        {{-- SIDEBAR --}}
        @include('mahasiswa.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-h-screen lg:ml-64 bg-[#F5F7FF] overflow-x-hidden transition-all duration-300">

            {{-- TOPBAR --}}
            @include('mahasiswa.partials.topbar')

            {{-- PAGE --}}
            <div class="w-full max-w-none px-6 lg:px-10 pt-24 pb-10">
                @yield('content')
            </div>

        </main>

    </div>

    {{-- SCRIPT VANILLA JS (Senjata Pamungkas) --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const backdrop = document.getElementById('mobile-backdrop');

            // Geser sidebar masuk/keluar
            sidebar.classList.toggle('-translate-x-full');

            // Munculin/Hilangin layar gelap dengan animasi
            if (backdrop.classList.contains('hidden')) {
                backdrop.classList.remove('hidden');
                // Kasih delay 10ms biar transisi CSS-nya ngebaca
                setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
            } else {
                backdrop.classList.add('opacity-0');
                setTimeout(() => backdrop.classList.add('hidden'), 300);
            }
        }
    </script>
</body>
</html>