@extends('layouts.mahasiswa')

@section('title', 'Buat Pengajuan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <section class="glass-panel rounded-[28px] p-8">

        <h1 class="text-4xl font-black text-on-surface">
            Buat Pengajuan
        </h1>

        <p class="mt-3 text-on-surface-variant text-lg">
            Pilih jenis surat yang ingin Anda ajukan.
        </p>

    </section>

    {{-- LIST SURAT --}}
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        {{-- CARD --}}
        <div class="glass-panel rounded-[24px] p-6">

            <div class="w-14 h-14 rounded-2xl bg-[#EEF4FF]
            flex items-center justify-center">

                <span class="material-symbols-rounded text-primary text-[28px]">
                    description
                </span>

            </div>

            <h3 class="mt-6 text-2xl font-bold">
                Surat Aktif Kuliah
            </h3>

            <p class="mt-2 text-on-surface-variant">
                Digunakan untuk keperluan administrasi akademik.
            </p>

            <button
                class="mt-6 w-full rounded-2xl bg-primary
                text-white py-3 font-semibold
                hover:brightness-110 transition"
            >
                Ajukan Sekarang
            </button>

        </div>

        {{-- CARD --}}
        <div class="glass-panel rounded-[24px] p-6">

            <div class="w-14 h-14 rounded-2xl bg-[#F1EDFF]
            flex items-center justify-center">

                <span class="material-symbols-rounded text-[#6D5EF9] text-[28px]">
                    school
                </span>

            </div>

            <h3 class="mt-6 text-2xl font-bold">
                Transkrip Nilai
            </h3>

            <p class="mt-2 text-on-surface-variant">
                Pengajuan transkrip nilai sementara mahasiswa.
            </p>

            <button
                class="mt-6 w-full rounded-2xl bg-primary
                text-white py-3 font-semibold
                hover:brightness-110 transition"
            >
                Ajukan Sekarang
            </button>

        </div>

        {{-- CARD --}}
        <div class="glass-panel rounded-[24px] p-6">

            <div class="w-14 h-14 rounded-2xl bg-[#FFF4E9]
            flex items-center justify-center">

                <span class="material-symbols-rounded text-[#FF8A00] text-[28px]">
                    lab_profile
                </span>

            </div>

            <h3 class="mt-6 text-2xl font-bold">
                Surat Penelitian
            </h3>

            <p class="mt-2 text-on-surface-variant">
                Digunakan untuk kebutuhan penelitian mahasiswa.
            </p>

            <button
                class="mt-6 w-full rounded-2xl bg-primary
                text-white py-3 font-semibold
                hover:brightness-110 transition"
            >
                Ajukan Sekarang
            </button>

        </div>

    </section>

</div>

@endsection