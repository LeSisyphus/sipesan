<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- NIM --}}
        <div class="mt-4">
            <x-input-label for="nim" :value="__('NIM')" />
            <x-text-input id="nim" class="block mt-1 w-full" type="text"
                name="nim" :value="old('nim')" required autocomplete="off" />
            <x-input-error :messages="$errors->get('nim')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Program Studi --}}
        <div class="mt-4">
            <x-input-label for="prodi_id" :value="__('Program Studi')" />
            <select id="prodi_id" name="prodi_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                <option value="">-- Pilih Prodi --</option>
                @foreach ($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }} — {{ $prodi->fakultas }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('prodi_id')" class="mt-2" />
        </div>

        {{-- Angkatan --}}
        <div class="mt-4">
            <x-input-label for="angkatan" :value="__('Angkatan')" />
            <x-text-input id="angkatan" class="block mt-1 w-full" type="number"
                name="angkatan" :value="old('angkatan')" required
                min="2000" max="{{ date('Y') }}" placeholder="{{ date('Y') }}" />
            <x-input-error :messages="$errors->get('angkatan')" class="mt-2" />
        </div>

        {{-- No HP --}}
        <div class="mt-4">
            <x-input-label for="no_hp" :value="__('No. HP (opsional)')" />
            <x-text-input id="no_hp" class="block mt-1 w-full" type="text"
                name="no_hp" :value="old('no_hp')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>