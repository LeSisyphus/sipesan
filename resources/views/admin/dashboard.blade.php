<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
        <p class="text-gray-500 mb-6">Selamat datang, {{ auth()->user()->name }}</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Pengajuan</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalPengajuan }}</p>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm">
                <p class="text-sm text-gray-500">Menunggu</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $menunggu }}</p>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm">
                <p class="text-sm text-gray-500">Diproses</p>
                <p class="text-3xl font-bold text-orange-500">{{ $diproses }}</p>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm">
                <p class="text-sm text-gray-500">Selesai</p>
                <p class="text-3xl font-bold text-green-500">{{ $selesai }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg">
                Logout
            </button>
        </form>
    </div>
</body>
</html>