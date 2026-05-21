<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <x-slot name="panelContent">
        <div x-data="{ step: {{ $errors->hasAny(['email', 'password']) ? 2 : 1 }} }" x-on:register-step.window="step = $event.detail.step" class="flex h-full flex-col">
            <div>
                <div class="mb-8 flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-[10px] border border-white/35 bg-white/20">
                        <span class="material-symbols-outlined text-xl text-white">description</span>
                    </div>
                    <span class="text-lg font-black tracking-wider text-white">SIPESAN</span>
                </div>

                <div class="mb-10">
                    <h1 class="mb-3 text-[1.6rem] font-extrabold leading-tight text-white">Buat Akun<br>Mahasiswa Baru</h1>
                    <p class="text-sm leading-relaxed text-white/75">Daftarkan diri Anda untuk mulai mengajukan dokumen akademik secara online.</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-3 transition" :class="step === 1 ? 'opacity-100' : 'opacity-45'">
                        <div class="flex h-[38px] w-[38px] items-center justify-center rounded-full border-2 transition" :class="step === 1 ? 'border-white bg-white text-[#0d4bcf]' : 'border-white/30 bg-white/15 text-white/85'">
                            <span class="material-symbols-outlined text-xl">person</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Data Diri</p>
                            <p class="text-xs text-white/60">Info akademik Anda</p>
                        </div>
                    </div>

                    <div class="ml-[18px] h-6 w-0.5 rounded-full bg-white/20"></div>

                    <div class="flex items-center gap-3 transition" :class="step === 2 ? 'opacity-100' : 'opacity-45'">
                        <div class="flex h-[38px] w-[38px] items-center justify-center rounded-full border-2 transition" :class="step === 2 ? 'border-white bg-white text-[#0d4bcf]' : 'border-white/30 bg-white/15 text-white/85'">
                            <span class="material-symbols-outlined text-xl">lock</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Data Akun</p>
                            <p class="text-xs text-white/60">Email & password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="panelDots">
        <div x-data="{ step: {{ $errors->hasAny(['email', 'password']) ? 2 : 1 }} }" x-on:register-step.window="step = $event.detail.step" class="flex items-center gap-2">
            <div class="h-1 rounded-full bg-white transition-all" :class="step >= 1 ? 'w-7 opacity-100' : 'w-3 opacity-35'"></div>
            <div class="h-1 rounded-full bg-white transition-all" :class="step >= 2 ? 'w-7 opacity-100' : 'w-3 opacity-35'"></div>
        </div>
    </x-slot>

    <div
        x-data="{
            step: {{ $errors->hasAny(['email', 'password']) ? 2 : 1 }},
            showPassword: false,
            showPasswordConfirm: false,
            agreed: false,
            form: {
                name: @js(old('name', '')),
                nim: @js(old('nim', '')),
                prodi_id: @js(old('prodi_id', '')),
                angkatan: @js(old('angkatan', '')),
                no_hp: @js(old('no_hp', '')),
                email: @js(old('email', '')),
                password: '',
                password_confirmation: '',
            },
            errors: {},
            goTo(nextStep) {
                this.step = nextStep;
                window.dispatchEvent(new CustomEvent('register-step', { detail: { step: nextStep } }));
            },
            next() {
                this.errors = {};
                if (!this.form.name.trim()) this.errors.name = 'Nama lengkap wajib diisi.';
                if (!this.form.nim.trim()) this.errors.nim = 'NIM wajib diisi.';
                if (!this.form.prodi_id) this.errors.prodi_id = 'Program studi wajib dipilih.';
                if (!this.form.angkatan) this.errors.angkatan = 'Angkatan wajib dipilih.';
                if (Object.keys(this.errors).length === 0) this.goTo(2);
            }
        }"
    >
        <div class="mb-3 inline-flex items-center rounded-full bg-[#e8f0fe] px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#0d4bcf]">
            <span x-text="`Langkah ${step} dari 2`"></span>
        </div>

        <h2 class="mb-1 text-[1.55rem] font-extrabold text-slate-900" x-text="step === 1 ? 'Data Diri' : 'Data Akun'"></h2>
        <p class="mb-4 text-sm text-slate-500" x-text="step === 1 ? 'Isi informasi akademik Anda.' : 'Buat email & password untuk login.'"></p>

        <div class="mb-8 h-[3px] overflow-hidden rounded-full bg-[#e8ecf5]">
            <div class="h-full rounded-full bg-gradient-to-r from-[#0d4bcf] to-blue-500 transition-all duration-500" :class="step === 1 ? 'w-1/2' : 'w-full'"></div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div x-show="step === 1" class="space-y-4">
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-800">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input id="name" name="name" type="text" x-model="form.name" placeholder="Sesuai KTP / Ijazah" autocomplete="name"
                        class="w-full rounded-xl border border-slate-200 bg-[#f8faff] px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#0d4bcf] focus:bg-white focus:ring-4 focus:ring-[#0d4bcf]/10 @error('name') border-red-400 bg-red-50 @enderror">
                    <p x-show="errors.name" x-cloak class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span><span x-text="errors.name"></span></p>
                    @error('name')<p class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nim" class="mb-2 block text-sm font-semibold text-slate-800">NIM <span class="text-red-500">*</span></label>
                    <input id="nim" name="nim" type="text" x-model="form.nim" placeholder="Nomor Induk Mahasiswa" autocomplete="off"
                        class="w-full rounded-xl border border-slate-200 bg-[#f8faff] px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#0d4bcf] focus:bg-white focus:ring-4 focus:ring-[#0d4bcf]/10 @error('nim') border-red-400 bg-red-50 @enderror">
                    <p x-show="errors.nim" x-cloak class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span><span x-text="errors.nim"></span></p>
                    @error('nim')<p class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="prodi_id" class="mb-2 block text-sm font-semibold text-slate-800">Program Studi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-lg text-slate-400">school</span>
                        <select id="prodi_id" name="prodi_id" x-model="form.prodi_id"
                            class="w-full appearance-none rounded-xl border border-slate-200 bg-[#f8faff] py-3 pl-11 pr-10 text-sm text-slate-800 outline-none transition focus:border-[#0d4bcf] focus:bg-white focus:ring-4 focus:ring-[#0d4bcf]/10 @error('prodi_id') border-red-400 bg-red-50 @enderror">
                            <option value="">Pilih Program Studi</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }} — {{ $prodi->fakultas }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-lg text-slate-400">expand_more</span>
                    </div>
                    <p x-show="errors.prodi_id" x-cloak class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span><span x-text="errors.prodi_id"></span></p>
                    @error('prodi_id')<p class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="angkatan" class="mb-2 block text-sm font-semibold text-slate-800">Angkatan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-lg text-slate-400">calendar_month</span>
                            <select id="angkatan" name="angkatan" x-model="form.angkatan"
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-[#f8faff] py-3 pl-11 pr-10 text-sm text-slate-800 outline-none transition focus:border-[#0d4bcf] focus:bg-white focus:ring-4 focus:ring-[#0d4bcf]/10 @error('angkatan') border-red-400 bg-red-50 @enderror">
                                <option value="">Tahun</option>
                                @for ($year = now()->year; $year >= 2010; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                            <span class="material-symbols-outlined pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-lg text-slate-400">expand_more</span>
                        </div>
                        <p x-show="errors.angkatan" x-cloak class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span><span x-text="errors.angkatan"></span></p>
                        @error('angkatan')<p class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="no_hp" class="mb-2 block text-sm font-semibold text-slate-800">No. WhatsApp / HP</label>
                        <input id="no_hp" name="no_hp" type="tel" x-model="form.no_hp" placeholder="Contoh: 08123456789" autocomplete="tel"
                            class="w-full rounded-xl border border-slate-200 bg-[#f8faff] px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#0d4bcf] focus:bg-white focus:ring-4 focus:ring-[#0d4bcf]/10 @error('no_hp') border-red-400 bg-red-50 @enderror">
                        @error('no_hp')<p class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>@enderror
                    </div>
                </div>

                <button type="button" class="flex w-full items-center justify-center gap-2 rounded-[14px] bg-gradient-to-br from-[#0d4bcf] to-[#1a6fd4] px-6 py-3.5 text-sm font-semibold text-white shadow-[0_4px_14px_rgba(13,75,207,0.35)] transition hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(13,75,207,0.40)]" @click="next()">
                    Lanjut
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </button>
            </div>

            <div x-show="step === 2" x-cloak class="space-y-4">
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-800">Alamat Email <span class="text-red-500">*</span></label>
                    <input id="email" name="email" type="email" x-model="form.email" placeholder="nama@email.com" autocomplete="username"
                        class="w-full rounded-xl border border-slate-200 bg-[#f8faff] px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#0d4bcf] focus:bg-white focus:ring-4 focus:ring-[#0d4bcf]/10 @error('email') border-red-400 bg-red-50 @enderror">
                    @error('email')<p class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-800">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input id="password" name="password" :type="showPassword ? 'text' : 'password'" x-model="form.password" placeholder="Minimal 8 karakter" autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-200 bg-[#f8faff] py-3 pl-4 pr-12 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#0d4bcf] focus:bg-white focus:ring-4 focus:ring-[#0d4bcf]/10 @error('password') border-red-400 bg-red-50 @enderror">
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md p-1 text-slate-400 transition hover:text-slate-600" @click="showPassword = !showPassword">
                            <span class="material-symbols-outlined text-xl" x-text="showPassword ? 'visibility' : 'visibility_off'"></span>
                        </button>
                    </div>
                    @error('password')<p class="mt-1 flex items-center gap-1 text-xs text-red-600"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-800">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" :type="showPasswordConfirm ? 'text' : 'password'" x-model="form.password_confirmation" placeholder="Ulangi password" autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-200 bg-[#f8faff] py-3 pl-4 pr-12 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#0d4bcf] focus:bg-white focus:ring-4 focus:ring-[#0d4bcf]/10">
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md p-1 text-slate-400 transition hover:text-slate-600" @click="showPasswordConfirm = !showPasswordConfirm">
                            <span class="material-symbols-outlined text-xl" x-text="showPasswordConfirm ? 'visibility' : 'visibility_off'"></span>
                        </button>
                    </div>
                </div>

                <label class="flex cursor-pointer items-start gap-2 text-xs leading-relaxed text-slate-600">
                    <input type="checkbox" x-model="agreed" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#0d4bcf] focus:ring-[#0d4bcf]">
                    <span>Saya menyetujui <a href="#" class="font-semibold text-[#0d4bcf] hover:underline">Syarat &amp; Ketentuan</a> serta <a href="#" class="font-semibold text-[#0d4bcf] hover:underline">Kebijakan Privasi</a> SIPESAN.</span>
                </label>

                <div class="flex items-center gap-3">
                    <button type="button" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:border-slate-300 hover:bg-slate-100" @click="goTo(1)">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                    </button>
                    <button type="submit" :disabled="!agreed" class="flex flex-1 items-center justify-center gap-2 rounded-[14px] bg-gradient-to-br from-[#0d4bcf] to-[#1a6fd4] px-6 py-3.5 text-sm font-semibold text-white shadow-[0_4px_14px_rgba(13,75,207,0.35)] transition hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(13,75,207,0.40)] disabled:cursor-not-allowed disabled:opacity-55 disabled:hover:translate-y-0 disabled:hover:shadow-[0_4px_14px_rgba(13,75,207,0.35)]">
                        Buat Akun
                        <span class="material-symbols-outlined text-xl">check_circle</span>
                    </button>
                </div>
            </div>
        </form>

        <p class="mt-5 text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-[#0d4bcf] transition hover:text-[#1a6fd4]">Masuk di sini</a>
        </p>
    </div>
</x-guest-layout>
