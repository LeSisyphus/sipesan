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
    

    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"/>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="text-on-surface font-body-md min-h-screen overflow-x-hidden antialiased">

    {{-- Sidebar --}}
    @include('components.admin-sidebar')

    {{-- Navbar --}}
    @include('components.admin-navbar')

    {{-- Main Content --}}
    @yield('content')

</body>
</html>