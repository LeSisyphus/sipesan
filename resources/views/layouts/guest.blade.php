<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SiPesan') }} — {{ $title ?? 'Autentikasi' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-[#f8f9ff] bg-[radial-gradient(circle_at_15%_50%,rgba(0,112,235,0.07),transparent_30%),radial-gradient(circle_at_85%_30%,rgba(102,100,228,0.07),transparent_30%)] font-[Poppins] text-[#121c2a] antialiased">
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-[10%] -top-[10%] h-[55%] w-[55%] rounded-full bg-[#0070eb]/20 blur-[130px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] h-[65%] w-[65%] rounded-full bg-[#6664e4]/20 blur-[160px]"></div>
    </div>

    <main class="relative z-10 flex min-h-screen items-center justify-center p-4 md:p-12">
        <section class="flex w-full max-w-5xl flex-col overflow-hidden rounded-[28px] border border-white/45 bg-white/60 shadow-[0_40px_80px_rgba(0,88,188,0.10)] backdrop-blur-[20px] md:flex-row">
            <aside class="relative hidden min-h-[560px] overflow-hidden bg-[#0058bc] md:flex md:w-1/2 md:flex-col md:justify-between">
                @isset($panelBackground)
                    {{ $panelBackground }}
                @else
                    <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(0,88,188,0.92),rgba(0,26,65,0.78))]"></div>
                    <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/15 blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 h-72 w-72 rounded-full bg-[#adc6ff]/20 blur-3xl"></div>
                @endisset

                <div class="relative z-10 flex h-full flex-col justify-between p-12">
                    @isset($panelContent)
                        {{ $panelContent }}
                    @else
                        <div>
                            <div class="mb-12 flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 backdrop-blur">
                                    <span class="material-symbols-outlined text-2xl text-white">description</span>
                                </div>
                                <span class="text-xl font-black tracking-tight text-white">SIPESAN</span>
                            </div>

                            <h1 class="mb-4 max-w-sm text-3xl font-bold leading-tight text-white">
                                Sistem Pengajuan Surat Akademik
                            </h1>
                            <p class="max-w-md text-base leading-relaxed text-[#d8e2ff]">
                                Kelola pengajuan dokumen akademik dengan cepat, transparan, dan mudah dilacak.
                            </p>
                        </div>
                    @endisset

                    @isset($panelDots)
                        {{ $panelDots }}
                    @else
                        <div class="flex items-center gap-2">
                            <div class="h-1 w-12 rounded-full bg-white/30"></div>
                            <div class="h-1 w-2 rounded-full bg-white/30"></div>
                            <div class="h-1 w-2 rounded-full bg-white/30"></div>
                        </div>
                    @endisset
                </div>
            </aside>

            <div class="flex w-full flex-col justify-center bg-white/40 p-6 md:w-1/2 md:p-12">
                <div class="mb-12 flex items-center gap-2 md:hidden">
                    <span class="material-symbols-outlined text-2xl text-[#0058bc]">description</span>
                    <span class="text-2xl font-bold tracking-tight text-[#0058bc]">SIPESAN</span>
                </div>

                {{ $slot }}
            </div>
        </section>
    </main>
</body>
</html>
