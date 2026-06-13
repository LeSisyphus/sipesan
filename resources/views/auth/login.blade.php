<x-guest-layout>
    <x-slot name="title">Login</x-slot>
    <div x-data="{ showPassword: false, loading: false }">
        <div class="mb-8">
            <h2 class="text-[34px] font-semibold tracking-tight text-[#111827]">
                Selamat Datang
            </h2>

            <p class="mt-2 text-[17px] text-[#414755]">
                Masuk untuk melanjutkan ke dashboard Anda.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-5 rounded-xl border border-[#0058bc]/20 bg-[#0058bc]/10 px-4 py-3 text-sm font-medium text-[#0058bc]">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6" @submit="loading = true">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-[#111827]">
                    Alamat Email
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                    autofocus
                    placeholder="Masukkan alamat email"
                    class="w-full h-14 rounded-2xl border border-[#cbd5e1] bg-white/60 px-5 text-[15px] text-[#111827] outline-none transition focus:border-[#0058bc] focus:ring-4 focus:ring-[#0058bc]/15 @error('email') border-red-500 @enderror"
                >

                @error('email')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-[#111827]">
                    Password
                </label>

                <div class="relative">
                    <input
                        id="password"
                        name="password"
                        :type="showPassword ? 'text' : 'password'"
                        autocomplete="current-password"
                        required
                        placeholder="Masukkan password"
                        class="w-full h-14 rounded-2xl border border-[#cbd5e1] bg-white/60 px-5 pr-14 text-[15px] text-[#111827] outline-none transition focus:border-[#0058bc] focus:ring-4 focus:ring-[#0058bc]/15 @error('password') border-red-500 @enderror"
                    >

                    <button
                        type="button"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[#64748b] hover:text-[#111827] transition"
                        @click="showPassword = !showPassword"
                    >
                        <span
                            class="material-symbols-outlined"
                            x-text="showPassword ? 'visibility' : 'visibility_off'"
                        ></span>
                    </button>
                </div>

                @error('password')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- REMEMBER + FORGOT --}}
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input
                        id="remember_me"
                        name="remember"
                        type="checkbox"
                        class="h-5 w-5 rounded border-[#cbd5e1] text-[#0058bc] focus:ring-[#0058bc]"
                    >

                    <span class="text-sm font-medium text-[#414755]">
                        Ingat saya
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm font-semibold text-[#0058bc] hover:text-[#0070eb] transition"
                    >
                        Lupa Password?
                    </a>
                @endif
            </div>

            {{-- SUBMIT --}}
            <button
                type="submit"
                :disabled="loading"
                class="w-full h-16 rounded-2xl bg-[#0058bc] text-white font-semibold text-[16px] shadow-[0_10px_24px_rgba(0,88,188,0.25)] hover:bg-[#0070eb] transition disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
                <span x-show="!loading" class="flex items-center gap-2">
                    Masuk
                    <span class="material-symbols-outlined">
                        arrow_forward
                    </span>
                </span>

                <span x-show="loading">
                    Memproses...
                </span>
            </button>
        </form>

        <p class="mt-12 text-center text-sm font-medium text-[#414755]">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-[#0058bc] hover:text-[#0070eb] transition">
                Daftar Sekarang
            </a>
        </p>
    </div>
</x-guest-layout>