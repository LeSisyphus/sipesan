<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <div x-data="{ role: '{{ old('role', 'mahasiswa') }}', showPassword: false, loading: false }">
        <div class="mb-6">
            <h2 class="mb-2 text-3xl font-semibold tracking-tight text-[#121c2a]">Selamat Datang</h2>
            <p class="text-base text-[#414755]">Masuk untuk melanjutkan ke dashboard Anda.</p>
        </div>

        @if (session('status'))
            <div class="mb-5 rounded-xl border border-[#0058bc]/20 bg-[#0058bc]/10 px-4 py-3 text-sm font-medium text-[#0058bc]">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6" @submit="loading = true">
            @csrf

            <div class="grid grid-cols-2 gap-3 rounded-xl bg-[#e6eeff] p-1">
                <label class="cursor-pointer">
                    <input type="radio" name="role" value="mahasiswa" class="peer sr-only" x-model="role">
                    <div class="rounded-lg py-2.5 text-center text-sm font-medium text-[#414755] transition-all duration-200 peer-checked:bg-white peer-checked:font-semibold peer-checked:text-[#0058bc] peer-checked:shadow-sm">
                        Mahasiswa
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="role" value="admin" class="peer sr-only" x-model="role">
                    <div class="rounded-lg py-2.5 text-center text-sm font-medium text-[#414755] transition-all duration-200 peer-checked:bg-white peer-checked:font-semibold peer-checked:text-[#0058bc] peer-checked:shadow-sm">
                        Admin
                    </div>
                </label>
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-[#121c2a]">Alamat Email</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#717786]">mail</span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus
                        :placeholder="role === 'admin' ? 'admin@sipesan.com' : 'nama@kampus.ac.id'"
                        class="w-full rounded-xl border border-[#c1c6d7]/60 bg-white/50 py-3 pl-12 pr-4 text-base text-[#121c2a] shadow-inner outline-none backdrop-blur placeholder:text-[#717786]/60 focus:border-[#0058bc] focus:ring-4 focus:ring-[#0058bc]/15 @error('email') border-[#ba1a1a] @enderror">
                </div>
                @error('email')
                    <p class="mt-2 flex items-center gap-1 text-xs text-[#ba1a1a]"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-[#121c2a]">Password</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#717786]">lock</span>
                    <input id="password" name="password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" required placeholder="••••••••"
                        class="w-full rounded-xl border border-[#c1c6d7]/60 bg-white/50 py-3 pl-12 pr-12 text-base text-[#121c2a] shadow-inner outline-none backdrop-blur placeholder:text-[#717786]/60 focus:border-[#0058bc] focus:ring-4 focus:ring-[#0058bc]/15 @error('password') border-[#ba1a1a] @enderror">
                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#717786] transition hover:text-[#121c2a]" @click="showPassword = !showPassword">
                        <span class="material-symbols-outlined" x-text="showPassword ? 'visibility' : 'visibility_off'"></span>
                    </button>
                </div>
                @error('password')
                    <p class="mt-2 flex items-center gap-1 text-xs text-[#ba1a1a]"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="group flex cursor-pointer items-center gap-2">
                    <span class="relative flex items-center justify-center">
                        <input id="remember_me" name="remember" type="checkbox" class="peer h-5 w-5 appearance-none rounded border-2 border-[#c1c6d7] bg-white/50 transition checked:border-[#0058bc] checked:bg-[#0058bc]">
                        <span class="material-symbols-outlined pointer-events-none absolute text-base text-white opacity-0 transition peer-checked:opacity-100">check</span>
                    </span>
                    <span class="text-sm font-medium text-[#414755] transition group-hover:text-[#121c2a]">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-[#0058bc] transition hover:text-[#0070eb]">Lupa Password?</a>
                @endif
            </div>

            <button type="submit" :disabled="loading" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-[#0058bc] px-6 py-4 text-sm font-medium text-white shadow-[0_8px_16px_rgba(0,88,188,0.20)] transition hover:bg-[#0070eb] hover:shadow-[0_12px_24px_rgba(0,112,235,0.30)] disabled:cursor-not-allowed disabled:opacity-70">
                <span x-show="!loading" class="flex items-center gap-2">Masuk <span class="material-symbols-outlined transition group-hover:translate-x-1">arrow_forward</span></span>
                <span x-show="loading">Memproses...</span>
            </button>
        </form>

        <p class="mt-12 text-center text-sm font-medium text-[#414755]">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-[#0058bc] transition hover:text-[#0070eb]">Daftar Sekarang</a>
        </p>
    </div>
</x-guest-layout>
