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
                <div
                    class="w-24 h-24 rounded-2xl bg-primary/15 border-4 border-white shadow-xl
                    flex items-center justify-center text-3xl font-semibold text-primary"
                >
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
                            {{ $nim }}
                            •
                            {{ $namaProdi }}
                            •
                            Angkatan {{ $angkatan }}
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
                <p class="text-3xl font-semibold text-primary">
                    {{ $totalPengajuan }}
                </p>
                <p class="text-xs text-slate-500">
                    Total Pengajuan
                </p>
            </div>

            <div class="text-center py-4">
                <p class="text-3xl font-semibold text-green-500">
                    {{ $selesai }}
                </p>
                <p class="text-xs text-slate-500">
                    Selesai
                </p>
            </div>

            <div class="text-center py-4">
                <p class="text-3xl font-semibold text-violet-500">
                    {{ $diproses }}
                </p>
                <p class="text-xs text-slate-500">
                    Diproses
                </p>
            </div>
        </div>
    </section>

    <div x-data="{ tab: '{{ session('success_keamanan') || $errors->has('current_password') || $errors->has('password') ? 'keamanan' : 'profil' }}' }" class="space-y-8">
        {{-- TABS --}}
        <div class="flex gap-1 p-1 rounded-2xl overflow-x-auto">
            <button
                type="button"
                @click="tab='profil'"
                :class="tab === 'profil' ? 'bg-primary text-white' : 'text-slate-500 hover:bg-white/60'"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold"
            >
                <span class="material-symbols-rounded text-[18px]">
                    person
                </span>
                Profil
            </button>

            <button
                type="button"
                @click="tab='keamanan'"
                :class="tab === 'keamanan' ? 'bg-primary text-white' : 'text-slate-500 hover:bg-white/60'"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold"
            >
                <span class="material-symbols-rounded text-[18px]">
                    lock
                </span>
                Keamanan
            </button>
        </div>

        {{-- PROFIL --}}
        <div x-show="tab === 'profil'" x-transition>
            <form method="POST" action="{{ route('mahasiswa.profile.update') }}">
                @csrf
                @method('PATCH')

                {{-- DATA AKADEMIK --}}
                <section class="glass-panel rounded-[28px] p-7 mb-8 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-3 border-b border-slate-200 pb-4 mb-6">
                        <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center">
                            <span class="material-symbols-rounded text-primary">
                                school
                            </span>
                        </div>

                        <h2 class="text-[26px] font-semibold text-slate-900">
                            Data Akademik
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="text-sm text-slate-500">
                                NIM
                            </label>

                            <input type="text" value="{{ $nim }}" readonly class="glass-input w-full mt-2 px-5 py-3">
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Program Studi
                            </label>

                            <input type="text" value="{{ $namaProdi }}" readonly class="glass-input w-full mt-2 px-5 py-3">
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Fakultas
                            </label>

                            <input type="text" value="{{ $prodi?->fakultas ?? '-' }}" readonly class="glass-input w-full mt-2 px-5 py-3">
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Angkatan
                            </label>

                            <input type="text" value="{{ $angkatan }}" readonly class="glass-input w-full mt-2 px-5 py-3">
                        </div>
                    </div>
                </section>

                {{-- DATA PRIBADI --}}
                <section class="glass-panel rounded-[28px] p-7 mb-8 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-3 border-b border-slate-200 pb-4 mb-6">
                        <div class="w-11 h-11 rounded-xl bg-violet-100 flex items-center justify-center">
                            <span class="material-symbols-rounded text-violet-600">
                                person
                            </span>
                        </div>

                        <h2 class="text-[26px] font-semibold text-slate-900">
                            Data Pribadi
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="text-sm text-slate-500">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="glass-input w-full mt-2 px-5 py-3"
                                required
                            >
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Tempat Lahir
                            </label>

                            <input
                                type="text"
                                name="tempat_lahir"
                                value="{{ old('tempat_lahir', $mahasiswa?->tempat_lahir) }}"
                                class="glass-input w-full mt-2 px-5 py-3"
                            >
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $tanggalLahir) }}"
                                class="glass-input w-full mt-2 px-5 py-3"
                            >
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Jenis Kelamin
                            </label>

                            <select name="jenis_kelamin" class="glass-input w-full mt-2 px-5 py-3">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-laki" @selected(old('jenis_kelamin', $jenisKelamin) === 'Laki-laki')>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" @selected(old('jenis_kelamin', $jenisKelamin) === 'Perempuan')>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm text-slate-500">
                                Alamat
                            </label>

                            <textarea name="alamat" rows="4" class="glass-input w-full mt-2 px-5 py-3">{{ old('alamat', $mahasiswa?->alamat) }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- KONTAK --}}
                <section class="glass-panel rounded-[28px] p-7 mb-8 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-3 border-b border-slate-200 pb-4 mb-6">
                        <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center">
                            <span class="material-symbols-rounded text-green-600">
                                call
                            </span>
                        </div>

                        <h2 class="text-[26px] font-semibold text-slate-900">
                            Informasi Kontak
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="text-sm text-slate-500">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="glass-input w-full mt-2 px-5 py-3"
                                required
                            >
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Nomor WhatsApp
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                value="{{ old('no_hp', $mahasiswa?->no_hp) }}"
                                class="glass-input w-full mt-2 px-5 py-3"
                            >
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Email Alternatif
                            </label>

                            <input
                                type="email"
                                name="email_alternatif"
                                value="{{ old('email_alternatif', $mahasiswa?->email_alternatif) }}"
                                class="glass-input w-full mt-2 px-5 py-3"
                            >
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">
                                Kontak Darurat
                            </label>

                            <input
                                type="text"
                                name="kontak_darurat"
                                value="{{ old('kontak_darurat', $mahasiswa?->kontak_darurat) }}"
                                class="glass-input w-full mt-2 px-5 py-3"
                            >
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="px-8 py-3 rounded-full bg-primary text-white font-semibold
                        shadow-lg shadow-blue-500/30 hover:-translate-y-1 hover:bg-blue-700
                        transition-all duration-300"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- KEAMANAN --}}
        <div x-show="tab === 'keamanan'" x-transition>
            <section class="glass-panel rounded-[28px] p-7">
                <div class="flex items-center gap-3 border-b pb-4 mb-6">
                    <div class="w-11 h-11 rounded-xl bg-red-100 flex items-center justify-center">
                        <span class="material-symbols-rounded text-red-600">
                            lock
                        </span>
                    </div>

                    <h2 class="text-[26px] font-semibold">
                        Keamanan Akun
                    </h2>
                </div>

                <form method="POST" action="{{ route('mahasiswa.profile.password.update') }}" class="space-y-5 max-w-xl">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-sm text-slate-500">
                            Password Lama
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="glass-input w-full mt-2 px-5 py-3"
                            autocomplete="current-password"
                        >
                    </div>

                    <div>
                        <label class="text-sm text-slate-500">
                            Password Baru
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="glass-input w-full mt-2 px-5 py-3"
                            autocomplete="new-password"
                        >
                    </div>

                    <div>
                        <label class="text-sm text-slate-500">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="glass-input w-full mt-2 px-5 py-3"
                            autocomplete="new-password"
                        >
                    </div>

                    <button
                        type="submit"
                        class="px-8 py-3 rounded-full bg-primary text-white font-semibold
                        shadow-lg shadow-blue-500/30 hover:-translate-y-1 hover:bg-blue-700
                        transition-all duration-300"
                    >
                        Update Password
                    </button>
                </form>
            </section>
        </div>
    </div>
</div>

@endsection
