<header class="fixed top-0 right-0 left-0 md:left-64
h-20 px-6 lg:px-10 bg-white/80 backdrop-blur-xl
border-b border-slate-200 z-40">

    <div class="h-full flex items-center justify-between">

        {{-- SEARCH --}}
        <div class="hidden md:flex items-center gap-3
        bg-slate-100 rounded-full px-4 py-2 w-[320px]">

            <span class="material-symbols-rounded text-slate-400">
                search
            </span>

            <input
                type="text"
                placeholder="Cari..."
                class="bg-transparent outline-none text-sm w-full"
            >
        </div>

        {{-- USER --}}
        <div class="flex items-center gap-4 ml-auto">

            <button class="relative">

                <span class="material-symbols-rounded text-slate-600">
                    notifications
                </span>

            </button>

            <div class="w-11 h-11 rounded-full bg-slate-200"></div>

        </div>

    </div>

</header>