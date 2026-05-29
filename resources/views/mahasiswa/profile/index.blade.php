@extends('layouts.mahasiswa')

@section('title', 'Profil Saya')

@section('content')

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

    {{-- PROFILE HERO --}}
    <section class="glass-panel rounded-[24px] overflow-hidden">

    {{-- Banner --}}
    <div class="h-32 py-8 bg-gradient-to-br from-primary via-blue-500 to-indigo-600 relative">

        <div class="absolute inset-0 opacity-20"
            style="background-image:radial-gradient(circle at 20% 50%,white 1px,transparent 1px),
            radial-gradient(circle at 80% 20%,white 1px,transparent 1px);
            background-size:30px 30px;">
        </div>

        <button
            class="absolute top-3 right-3
            flex items-center gap-2
            px-3 py-1.5 rounded-full
            bg-white/20 backdrop-blur
            text-white text-xs font-semibold">

            <span class="material-symbols-rounded text-[14px]">
                edit
            </span>

            Ubah Banner

        </button>

    </div>

    {{-- Profile Info --}}
    <div
        class="px-6 pb-6
        flex flex-col sm:flex-row
        items-start sm:items-end
        gap-5 -mt-14">

        <div class="relative shrink-0">

            <div
                class="w-24 h-24
                rounded-2xl
                bg-primary/15
                border-4 border-white
                shadow-xl
                flex items-center justify-center
                text-3xl font-semibold text-primary">

                {{ strtoupper(substr(Auth::user()->name,0,2)) }}

            </div>

            <button
                class="absolute
                -bottom-2 -right-2
                w-8 h-8 rounded-full
                bg-primary text-white
                flex items-center justify-center">

                <span class="material-symbols-rounded text-[16px]">
                    photo_camera
                </span>

            </button>

        </div>

        <div class="flex-1 mt-10 sm:mt-0">

            <div class="flex justify-between items-start">

                <div>

                    <h2 class="text-3xl font-semibold">
                        {{ Auth::user()->name }}
                    </h2>

                    <p class="text-slate-500 text-sm mt-1">

                        {{ Auth::user()->nim }}

                        •

                        {{ Auth::user()->mahasiswa->prodi->nama_prodi }}

                        •

                        Angkatan
                        {{ Auth::user()->mahasiswa->angkatan }}

                    </p>

                </div>

                <span
                    class="px-3 py-1.5
                    rounded-full
                    bg-primary/10
                    text-primary
                    text-xs font-semibold">

                    Aktif

                </span>

            </div>

        </div>

    </div>

    {{-- Stats --}}
    <div
        class="border-t border-white/40
        grid grid-cols-3 divide-x divide-white/40">

        <div class="text-center py-4">
            <p class="text-3xl font-semibold text-primary">
                0
            </p>
            <p class="text-xs text-slate-500">
                Total Pengajuan
            </p>
        </div>

        <div class="text-center py-4">
            <p class="text-3xl font-semibold text-green-500">
                {{ $selesai ?? 0 }}
            </p>
            <p class="text-xs text-slate-500">
                Selesai
            </p>
        </div>

        <div class="text-center py-4">
            <p class="text-3xl font-semibold text-violet-500">
                {{ $diproses ?? 0 }}
            </p>
            <p class="text-xs text-slate-500">
                Diproses
            </p>
        </div>

    </div>

</section>

    <div
    x-data="{ tab: 'profil' }"
    class="space-y-8"
>

    {{-- TABS --}}
    <div class="flex gap-1 p-1 glass-panel rounded-2xl overflow-x-auto">

    <button
        @click="tab='profil'"
        :class="tab === 'profil'
        ? 'bg-primary text-white'
        : 'text-slate-500 hover:bg-white/60'"

        class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold">

        <span class="material-symbols-rounded text-[18px]">
            person
        </span>

        Profil

    </button>

    <button
        @click="tab='keamanan'"
        :class="tab === 'keamanan'
        ? 'bg-primary text-white'
        : 'text-slate-500 hover:bg-white/60'"

        class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold">

        <span class="material-symbols-rounded text-[18px]">
            lock
        </span>

        Keamanan

    </button>

    <button
        @click="tab='notifikasi'"
        :class="tab === 'notifikasi'
        ? 'bg-primary text-white'
        : 'text-slate-500 hover:bg-white/60'"

        class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold">

        <span class="material-symbols-rounded text-[18px]">
            notifications
        </span>

        Notifikasi

    </button>

    <button
        @click="tab='aktivitas'"
        :class="tab === 'aktivitas'
        ? 'bg-primary text-white'
        : 'text-slate-500 hover:bg-white/60'"

        class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold">

        <span class="material-symbols-rounded text-[18px]">
            history
        </span>

        Aktivitas

    </button>

</div>

    {{-- DATA AKADEMIK --}}
    <div x-show="tab === 'profil'" x-transition>
    <section
        class="glass-panel rounded-[28px]
        p-7 mb-8
        hover:-translate-y-1
        hover:shadow-xl
        transition-all duration-300"
    >

        <div
            class="flex items-center gap-3
            border-b border-slate-200
            pb-4 mb-6"
        >

            <div
                class="w-11 h-11 rounded-xl
                bg-blue-100
                flex items-center justify-center"
            >

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
                <label class="text-sm text-slate-500">NIM</label>

                <input
                    type="text"
                    value="221011400123"
                    readonly
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Program Studi
                </label>

                <input
                    type="text"
                    value="Sistem Informasi"
                    readonly
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Fakultas
                </label>

                <input
                    type="text"
                    value="Ilmu Komputer"
                    readonly
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Angkatan
                </label>

                <input
                    type="text"
                    value="2023"
                    readonly
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

        </div>

    </section>

    {{-- DATA PRIBADI --}}
    <section
        class="glass-panel rounded-[28px]
        p-7 mb-8
        hover:-translate-y-1
        hover:shadow-xl
        transition-all duration-300"
    >

        <div
            class="flex items-center gap-3
            border-b border-slate-200
            pb-4 mb-6"
        >

            <div
                class="w-11 h-11 rounded-xl
                bg-violet-100
                flex items-center justify-center"
            >

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
                    value="Aliza Beth"
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Tempat Lahir
                </label>

                <input
                    type="text"
                    value="Samarinda"
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Tanggal Lahir
                </label>

                <input
                    type="date"
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Jenis Kelamin
                </label>

                <select
                    class="glass-input w-full mt-2 px-5 py-3"
                >
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>
            </div>

            <div class="md:col-span-2">

                <label class="text-sm text-slate-500">
                    Alamat
                </label>

                <textarea
                    rows="4"
                    class="glass-input w-full mt-2 px-5 py-3"
                >Jl. Contoh Alamat Mahasiswa</textarea>

            </div>

        </div>

    </section>

    {{-- KONTAK --}}
    <section
        class="glass-panel rounded-[28px]
        p-7 mb-8
        hover:-translate-y-1
        hover:shadow-xl
        transition-all duration-300"
    >

        <div
            class="flex items-center gap-3
            border-b border-slate-200
            pb-4 mb-6"
        >

            <div
                class="w-11 h-11 rounded-xl
                bg-green-100
                flex items-center justify-center"
            >

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
                    value="aliza@student.ac.id"
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Nomor WhatsApp
                </label>

                <input
                    type="text"
                    value="081234567890"
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Email Alternatif
                </label>

                <input
                    type="email"
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Kontak Darurat
                </label>

                <input
                    type="text"
                    class="glass-input w-full mt-2 px-5 py-3"
                >
            </div>

        </div>

    </section>

    {{-- BUTTON --}}
    <div class="flex justify-end">

        <button
            class="px-8 py-3 rounded-full
            bg-primary text-white
            font-semibold
            shadow-lg shadow-blue-500/30
            hover:-translate-y-1
            hover:bg-blue-700
            transition-all duration-300"
        >
            Simpan Perubahan
        </button>

    </div>
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

        <div class="space-y-5 max-w-xl">

            <div>
                <label>Password Lama</label>

                <input
                    type="password"
                    class="glass-input w-full mt-2 px-5 py-3">
            </div>

            <div>
                <label>Password Baru</label>

                <input
                    type="password"
                    class="glass-input w-full mt-2 px-5 py-3">
            </div>

            <div>
                <label>Konfirmasi Password</label>

                <input
                    type="password"
                    class="glass-input w-full mt-2 px-5 py-3">
            </div>

            <button
                class="px-8 py-3 rounded-full
                bg-primary text-white">

                Update Password

            </button>

        </div>

    </section>

</div>

    {{-- NOTIF --}}
    <div x-show="tab === 'notifikasi'" x-transition>

<section class="glass-panel rounded-[24px] p-6 sm:p-8 space-y-6">

    <div class="flex items-center gap-3 border-b border-slate-200 pb-4">

        <div class="p-3 bg-blue-100 rounded-xl">
            <span class="material-symbols-rounded text-primary">
                tune
            </span>
        </div>

        <div>
            <h3 class="text-[32px] font-semibold text-slate-900">
                Preferensi Notifikasi
            </h3>

            <p class="text-slate-500 text-sm">
                Pilih bagaimana kamu ingin diberitahu
            </p>
        </div>

    </div>

    {{-- EMAIL --}}
    <div class="space-y-3">

        <h4 class="font-semibold text-slate-600 uppercase text-xs tracking-wider">
            Email
        </h4>

        @foreach([
            [
                'title'=>'Status Pengajuan Berubah',
                'desc'=>'Notif saat pengajuan diproses, selesai, atau ditolak'
            ],
            [
                'title'=>'Pengajuan Siap Diambil',
                'desc'=>'Notif saat dokumen telah selesai dan siap diambil'
            ],
            [
                'title'=>'Pengingat Pengajuan Tertunda',
                'desc'=>'Reminder jika ada pengajuan yang belum dilengkapi'
            ]
        ] as $item)

        <div class="glass-panel rounded-xl p-4 flex justify-between items-center">

            <div>

                <h5 class="font-semibold">
                    {{ $item['title'] }}
                </h5>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $item['desc'] }}
                </p>

            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer" checked>

                <div
                    class="w-11 h-6 bg-slate-300
                    rounded-full peer
                    peer-checked:bg-primary
                    after:content-['']
                    after:absolute
                    after:top-[2px]
                    after:left-[2px]
                    after:bg-white
                    after:h-5 after:w-5
                    after:rounded-full
                    after:transition-all
                    peer-checked:after:translate-x-full">
                </div>

            </label>

        </div>

        @endforeach

    </div>

    {{-- WHATSAPP --}}
    <div class="space-y-3">

        <h4 class="font-semibold text-slate-600 uppercase text-xs tracking-wider">
            WhatsApp
        </h4>

        <div class="glass-panel rounded-xl p-4 flex justify-between items-center">

            <div>

                <h5 class="font-semibold">
                    Notifikasi WhatsApp
                </h5>

                <p class="text-sm text-slate-500 mt-1">
                    Aktifkan pengiriman notifikasi melalui WhatsApp
                </p>

            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer" checked>

                <div
                    class="w-11 h-6 bg-slate-300 rounded-full
                    peer peer-checked:bg-primary
                    after:absolute after:top-[2px]
                    after:left-[2px]
                    after:bg-white
                    after:h-5 after:w-5
                    after:rounded-full
                    after:transition-all
                    peer-checked:after:translate-x-full">
                </div>

            </label>

        </div>

    </div>

</section>

</div>

    {{-- AKTIVITAS --}}
    <div x-show="tab === 'aktivitas'" x-transition>

<div class="space-y-6">

    {{-- SUMMARY --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">

        <div class="glass-panel rounded-2xl p-5">
            <span class="material-symbols-rounded text-primary">
                description
            </span>

            <h3 class="text-4xl font-medium mt-3">
                14
            </h3>

            <p class="text-slate-500 text-sm">
                Total Pengajuan
            </p>
        </div>

        <div class="glass-panel rounded-2xl p-5">
            <span class="material-symbols-rounded text-green-500">
                check_circle
            </span>

            <h3 class="text-4xl font-medium mt-3 text-green-500">
                11
            </h3>

            <p class="text-slate-500 text-sm">
                Selesai
            </p>
        </div>

        <div class="glass-panel rounded-2xl p-5">
            <span class="material-symbols-rounded text-violet-500">
                autorenew
            </span>

            <h3 class="text-4xl font-medium mt-3 text-violet-500">
                3
            </h3>

            <p class="text-slate-500 text-sm">
                Diproses
            </p>
        </div>
    </div>

    {{-- TIMELINE --}}
    <section class="glass-panel rounded-[24px] p-8">

        <div class="flex items-center justify-between border-b border-slate-200 pb-4 mb-8">

            <div class="flex items-center gap-3">

                <div class="p-3 bg-slate-100 rounded-xl">

                    <span class="material-symbols-rounded text-slate-600">
                        timeline
                    </span>

                </div>

                <h2 class="text-[36px] font-semibold text-slate-900">
                    Riwayat Aktivitas
                </h2>

            </div>

            <a href="{{ route('mahasiswa.riwayat') }}" class="text-primary font-semibold">
                Lihat Semua →
            </a>

        </div>

        <div class="relative ml-5">

            <div class="absolute left-0 top-0 bottom-0 w-[2px] bg-blue-200"></div>

            @php
            $timeline = [
                ['green','Surat Keterangan Aktif — Selesai','Dokumen siap diambil di Gedung Akademik','12 Okt 2023'],
                ['violet','Transkrip Nilai — Diproses','Sedang diverifikasi oleh bagian akademik','10 Okt 2023'],
                ['gray','Surat Pengantar Penelitian — Menunggu','Menunggu antrian verifikasi admin','08 Okt 2023'],
                ['green','Surat Keterangan Lulus — Selesai','Dokumen sudah dicetak dan siap diambil','01 Okt 2023'],
                ['green','Legalisir Ijazah — Selesai','10 lembar legalisir berhasil diproses','25 Sep 2023']
            ];
            @endphp

            @foreach($timeline as $item)

            <div class="relative pl-10 pb-8">

                <div
                    class="absolute left-[-7px] top-5
                    w-4 h-4 rounded-full
                    {{ $item[0]=='green' ? 'bg-green-500' : ($item[0]=='violet' ? 'bg-violet-500' : 'bg-slate-500') }}">
                </div>

                <div class="glass-panel rounded-xl p-5">

                    <div class="flex justify-between">

                        <div>

                            <h4 class="font-semibold text-lg">
                                {{ $item[1] }}
                            </h4>

                            <p class="text-slate-500 text-sm mt-1">
                                {{ $item[2] }}
                            </p>

                        </div>

                        <span class="text-sm text-slate-400">
                            {{ $item[3] }}
                        </span>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </section>

</div>

</div>
</div>

@endsection