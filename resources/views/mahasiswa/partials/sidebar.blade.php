<aside id="mobile-sidebar"
       class="fixed inset-y-0 left-0 w-64 flex flex-col z-50 bg-white/70 backdrop-blur-xl border-r border-white/40 shadow-xl shadow-blue-500/5 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

    {{-- LOGO --}}
    <div class="px-6 py-6 flex flex-col items-center border-b border-white/40">
        <div class="w-14 h-14 rounded-2xl glass-panel flex items-center justify-center mb-3">
            <span class="material-symbols-rounded text-4xl text-primary" style="font-variation-settings:'FILL' 1;">
                description
            </span>
        </div>

        <h1 class="font-h3 text-h3 text-blue-600 font-black tracking-tight">
            SIPESAN
        </h1>

        <p class="text-xs text-outline tracking-widest uppercase mt-1">
            Sistem Dokumen
        </p>
    </div>

    {{-- NAV --}}
    <nav class="flex-1 overflow-y-auto py-5 px-4 space-y-1">
        <a href="{{ route('mahasiswa.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold tracking-wide transition-all
           {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600' : 'text-slate-500 hover:bg-white/50' }}">
            <span class="material-symbols-rounded" style="font-variation-settings:'FILL' 1;">dashboard</span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('mahasiswa.pengajuan') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold tracking-wide transition-all
           {{ request()->routeIs('mahasiswa.pengajuan') || request()->routeIs('mahasiswa.pengajuan.*') ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600' : 'text-slate-500 hover:bg-white/50' }}">
            <span class="material-symbols-rounded">note_add</span>
            <span>Buat Pengajuan</span>
        </a>

        <a href="{{ route('mahasiswa.riwayat') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold tracking-wide transition-all
           {{ request()->routeIs('mahasiswa.riwayat') ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600' : 'text-slate-500 hover:bg-white/50' }}">
            <span class="material-symbols-rounded">history</span>
            <span>Riwayat Pengajuan</span>
        </a>

        <a href="{{ route('mahasiswa.profile') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold tracking-wide transition-all
           {{ request()->routeIs('mahasiswa.profile') || request()->routeIs('mahasiswa.profile.*') ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600' : 'text-slate-500 hover:bg-white/50' }}">
            <span class="material-symbols-rounded">account_circle</span>
            <span>Profil Saya</span>
        </a>

        {{-- LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}" class="w-full mt-2">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold tracking-wide transition-all text-slate-500 hover:bg-red-50 hover:text-red-500">
                <span class="material-symbols-rounded text-red-500">logout</span>
                <span class="text-red-500">Keluar</span>
            </button>
        </form>
    </nav>
</aside>