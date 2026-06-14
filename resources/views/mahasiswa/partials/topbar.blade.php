@php
    $currentUser = Auth::user();
    $initials = collect(explode(' ', $currentUser?->name ?? 'User'))
        ->filter()
        ->map(fn ($word) => substr($word, 0, 1))
        ->take(2)
        ->implode('');
@endphp

<header class="fixed top-0 right-0 left-0 lg:left-64 h-20 px-6 lg:px-10 bg-white/80 backdrop-blur-xl border-b border-slate-200 z-40">
    <div class="h-full flex items-center justify-between">
       
        {{-- HAMBURGER BUTTON MOBILE --}}
        <div class="flex items-center gap-4 lg:hidden">
            <button onclick="toggleSidebar()" class="p-2 rounded-xl hover:bg-black/5 transition-colors text-slate-600">
                <span class="material-symbols-rounded">menu</span>
            </button>
            <span class="font-h3 text-h3 text-blue-600 font-bold tracking-tight">SIPESAN</span>
        </div>

        {{-- USER PROFILE --}}
        <div class="flex items-center gap-4 ml-auto">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold text-slate-800">
                    {{ $currentUser?->name ?? 'Mahasiswa' }}
                </p>
                <p class="text-xs text-slate-400">
                    {{ $currentUser?->nim ?? 'NIM belum tersedia' }}
                </p>
            </div>

            <div class="w-11 h-11 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                {{ strtoupper($initials ?: 'US') }}
            </div>
        </div>
    </div>
</header>