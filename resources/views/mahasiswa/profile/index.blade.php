@extends('layouts.mahasiswa')

@section('title', 'Profil Saya')

@section('content')

@php
    $prodi = $mahasiswa?->prodi;

    $nim = $user?->nim ?? '-';
    $namaProdi = $prodi?->nama_prodi ?? '-';
    $angkatan = $mahasiswa?->angkatan ?? '-';
    $statusMahasiswa = ($user?->status ?? 'aktif') === 'aktif' ? 'Aktif' : 'Nonaktif';

    $tanggalLahir = $mahasiswa?->tanggal_lahir
        ? $mahasiswa->tanggal_lahir->format('Y-m-d')
        : '';

    $jenisKelamin = $mahasiswa?->jenis_kelamin ?? '';
@endphp

<div class="max-w-[1100px] mx-auto space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-[34px] font-semibold text-slate-900">
            Profil Saya
        </h1>

        <p class="text-slate-500 mt-2 text-lg">
            Kelola informasi pribadi dan akademik Anda.
        </p>
    </div>

    @if (session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-200 text-green-700 px-5 py-4 font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if (session('success_keamanan'))
        <div class="rounded-2xl bg-green-50 border border-green-200 text-green-700 px-5 py-4 font-medium">
            {{ session('success_keamanan') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl bg-red-50 border border-red-200 text-red-700 px-5 py-4">
            <p class="font-semibold mb-2">Ada data yang perlu diperbaiki:</p>
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PROFILE HERO --}}
    <section class="glass-panel rounded-[24px] overflow-hidden">
        <div class="px-6 py-6 flex flex-col sm:flex-row items-start sm:items-center gap-5">
            <div class="relative shrink-0">
                <div class="w-24 h-24 rounded-2xl bg-primary/15 border-4 border-white shadow-xl flex items-center justify-center text-3xl font-semibold text-primary">
                    {{ strtoupper(substr($user->name ?? 'US', 0, 2)) }}
                </div>
            </div>

            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <div>
                        <h2 class="text-3xl font-semibold">
                            {{ $user->name }}
                        </h2>
                        <p class="text-slate-500 text-sm mt-1">
                            {{ $nim }} • {{ $namaProdi }} • Angkatan {{ $angkatan }}
                        </p>
                    </div>

                    <span class="w-fit px-3 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-semibold">
                        {{ $statusMahasiswa }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="border-t border-white/40 grid grid-cols-1 sm:grid-cols-3 sm:divide-x divide-white/40">
            <div class="text-center py-4">
                <p class="text-3xl font-semibold text-primary">{{ $totalPengajuan }}</p>
                <p class="text-xs text-slate-500">Total Pengajuan</p>
            </div>
            <div class="text-center py-4">
                <p class="text-3xl font-semibold text-green-500">{{ $selesai }}</p>
                <p class="text-xs text-slate-500">Selesai</p>
            </div>
            <div class="text-center py-4">
                <p class="text-3xl font-semibold text-violet-500">{{ $diproses }}</p>
                <p class="text-xs text-slate-500">Diproses</p>
            </div>
        </div>
    </section>

    <div x-data="{ tab: '{{ session('success_keamanan') || $errors->has('current_password') || $errors->has('password') ? 'keamanan' : 'profil' }}' }" class="space-y-8">
        {{-- TABS --}}
        <div class="flex gap-1 p-1 rounded-2xl overflow-x-auto">
            <button type="button" @click="tab='profil'" :class="tab === 'profil' ? 'bg-primary text-white' : 'text-slate-500 hover:bg-white/60'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold">
                <span class="material-symbols-rounded text-[18px]">person</span> Profil
            </button>
            <button type="button" @click="tab='keamanan'" :class="tab === 'keamanan' ? 'bg-primary text-white' : 'text-slate-500 hover:bg-white/60'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold">
                <span class="material-symbols-rounded text-[18px]">lock</span> Keamanan
            </button>
        </div>

        {{-- PROFIL TAB --}}
        <div x-show="tab === 'profil'" x-transition>
            <form method="POST" action="{{ route('mahasiswa.profile.update') }}">
                @csrf
                @method('PATCH')

                {{-- DATA AKADEMIK --}}
                <x-profile-section title="Data Akademik" icon="school" iconBg="bg-blue-100" iconText="text-primary">
                    <x-form-input id="nim" label="NIM" value="{{ $nim }}" readonly="true" />
                    <x-form-input id="prodi" label="Program Studi" value="{{ $namaProdi }}" readonly="true" />
                    <x-form-input id="fakultas" label="Fakultas" value="{{ $prodi?->fakultas ?? '-' }}" readonly="true" />
                    <x-form-input id="angkatan" label="Angkatan" value="{{ $angkatan }}" readonly="true" />
                </x-profile-section>

                {{-- DATA PRIBADI --}}
                <x-profile-section title="Data Pribadi" icon="person" iconBg="bg-violet-100" iconText="text-violet-600">
                    <x-form-input id="name" label="Nama Lengkap" value="{{ old('name', $user->name) }}" required="true" />
                    <x-form-input id="tempat_lahir" label="Tempat Lahir" value="{{ old('tempat_lahir', $mahasiswa?->tempat_lahir) }}" />
                    <x-form-input id="tanggal_lahir" type="date" label="Tanggal Lahir" value="{{ old('tanggal_lahir', $tanggalLahir) }}" />
                    
                    <x-form-select id="jenis_kelamin" label="Jenis Kelamin">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Laki-laki" @selected(old('jenis_kelamin', $jenisKelamin) === 'Laki-laki')>Laki-laki</option>
                        <option value="Perempuan" @selected(old('jenis_kelamin', $jenisKelamin) === 'Perempuan')>Perempuan</option>
                    </x-form-select>

                    <x-form-textarea id="alamat" label="Alamat" wrapperClass="md:col-span-2" value="{{ old('alamat', $mahasiswa?->alamat) }}" />
                </x-profile-section>

                {{-- KONTAK --}}
                <x-profile-section title="Informasi Kontak" icon="call" iconBg="bg-green-100" iconText="text-green-600">
                    <x-form-input id="email" type="email" label="Email" value="{{ old('email', $user->email) }}" required="true" />
                    <x-form-input id="no_hp" label="Nomor WhatsApp" value="{{ old('no_hp', $mahasiswa?->no_hp) }}" />
                    <x-form-input id="email_alternatif" type="email" label="Email Alternatif" value="{{ old('email_alternatif', $mahasiswa?->email_alternatif) }}" />
                    <x-form-input id="kontak_darurat" label="Kontak Darurat" value="{{ old('kontak_darurat', $mahasiswa?->kontak_darurat) }}" />
                </x-profile-section>

                <div class="flex justify-end mb-8">
                    <button type="submit" class="px-8 py-3 rounded-full bg-primary text-white font-semibold shadow-lg shadow-blue-500/30 hover:-translate-y-1 hover:bg-blue-700 transition-all duration-300">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- KEAMANAN TAB --}}
        <div x-show="tab === 'keamanan'" x-transition>
            <x-profile-section title="Keamanan Akun" icon="lock" iconBg="bg-red-100" iconText="text-red-600" contentClass="">
                <form method="POST" action="{{ route('mahasiswa.profile.password.update') }}" class="space-y-5 max-w-xl">
                    @csrf
                    @method('PATCH')
                    
                    <x-form-input id="current_password" type="password" label="Password Lama" autocomplete="current-password" />
                    <x-form-input id="password" type="password" label="Password Baru" autocomplete="new-password" />
                    <x-form-input id="password_confirmation" type="password" label="Konfirmasi Password" autocomplete="new-password" />

                    <button type="submit" class="px-8 py-3 rounded-full bg-primary text-white font-semibold shadow-lg shadow-blue-500/30 hover:-translate-y-1 hover:bg-blue-700 transition-all duration-300">
                        Update Password
                    </button>
                </form>
            </x-profile-section>
        </div>
    </div>
</div>

@endsection