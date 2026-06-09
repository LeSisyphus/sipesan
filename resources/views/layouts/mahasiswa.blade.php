<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Mahasiswa')</title>
    <link rel="icon" type="image/png" href="{{ asset('sipesan-logo.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- MATERIAL SYMBOLS --}}
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"
    />

    {{-- GOOGLE FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    />

    {{-- VITE --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="font-[Poppins] antialiased bg-[#F4F7FF] text-slate-800 bg-background text-on-surface">

    <div class="min-h-screen">

        {{-- SIDEBAR --}}
        @include('mahasiswa.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="min-h-screen ml-64 bg-[#F5F7FF] overflow-x-hidden">

            {{-- TOPBAR --}}
            @include('mahasiswa.partials.topbar')

            {{-- PAGE --}}
            <div class="w-full max-w-none px-6 lg:px-10 pt-24 pb-10">
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>