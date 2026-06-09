<x-guest-layout>
    <x-slot name="title">Lupa Password</x-slot>

    <div class="mb-8">
        <h2 class="mb-2 text-3xl font-semibold tracking-tight text-[#121c2a]">
            Lupa Password?
        </h2>

        <p class="text-base leading-relaxed text-[#414755]">
            Jika Anda lupa password akun SiPesan, silakan hubungi admin untuk melakukan reset password.
        </p>
    </div>

    <div class="space-y-4">
        {{-- WHATSAPP / TELEPON --}}
        <a
            href="https://wa.me/6288242667283"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center gap-4 rounded-2xl border border-[#c1c6d7]/60 bg-white/60 p-5 shadow-sm transition hover:border-[#0058bc]/40 hover:bg-white"
        >
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#0058bc]/10 text-[#0058bc]">
                <span class="material-symbols-outlined">
                    call
                </span>
            </div>

            <div>
                <p class="text-sm font-medium text-[#717786]">
                    WhatsApp / Telepon Admin
                </p>
                <p class="text-base font-semibold text-[#121c2a]">
                    088242667283
                </p>
            </div>
        </a>

        {{-- EMAIL --}}
        <a
            href="mailto:admin@sipesan.com"
            class="flex items-center gap-4 rounded-2xl border border-[#c1c6d7]/60 bg-white/60 p-5 shadow-sm transition hover:border-[#0058bc]/40 hover:bg-white"
        >
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#0058bc]/10 text-[#0058bc]">
                <span class="material-symbols-outlined">
                    mail
                </span>
            </div>

            <div>
                <p class="text-sm font-medium text-[#717786]">
                    Email Admin
                </p>
                <p class="text-base font-semibold text-[#121c2a]">
                    admin@sipesan.com
                </p>
            </div>
        </a>
    </div>

    <div class="mt-8 rounded-2xl border border-yellow-200 bg-yellow-50 px-5 py-4">
        <div class="flex gap-3">
            <span class="material-symbols-outlined text-yellow-600">
                info
            </span>

            <p class="text-sm leading-relaxed text-yellow-800">
                Admin akan membantu melakukan reset password akun Anda. Setelah password direset, segera login dan ubah password anda
            </p>
        </div>
    </div>

    <p class="mt-10 text-center text-sm font-medium text-[#414755]">
        Ingat password?
        <a href="{{ route('login') }}" class="font-semibold text-[#0058bc] transition hover:text-[#0070eb]">
            Kembali ke Login
        </a>
    </p>
</x-guest-layout>