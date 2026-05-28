@extends('layouts.mahasiswa')

@section('title', 'Buat Pengajuan')

@section('content')

<div
    x-data="{
        step: 1,

        nextStep() {
            if (this.step < 3) this.step++
        },

        prevStep() {
            if (this.step > 1) this.step--
        }
    }"
    class="max-w-[1400px] mx-auto space-y-8"
>

    {{-- HEADER --}}
    <div>

        <h1 class="text-[40px] font-medium text-slate-900">
            Buat Pengajuan Baru
        </h1>

        <p class="mt-2 text-slate-500 text-lg">
            Lengkapi data dan unggah berkas persyaratan.
        </p>

    </div>

    {{-- STEPPER --}}
    <div class="glass-panel rounded-[24px] p-6">

        <div class="relative max-w-3xl mx-auto">

            {{-- BACKGROUND LINE --}}
            <div
                class="absolute top-5 left-0
                w-full h-[4px]
                bg-slate-200 rounded-full"
            ></div>

            {{-- PROGRESS LINE --}}
            <div
                class="absolute top-5 left-0
                h-[4px]
                bg-primary rounded-full
                transition-all duration-500"
                :style="{
                    width:
                        step === 1 ? '0%' :
                        step === 2 ? '50%' :
                        '100%'
                }"
            ></div>

            {{-- STEPS --}}
            <div class="relative flex items-center justify-between">

                {{-- STEP 1 --}}
                <div class="flex flex-col items-center gap-2 z-10">

                    <div
                        :class="step >= 1
                            ? 'bg-primary text-white step-circle active'
                            : 'bg-slate-200 text-slate-500 step-circle'"
                        class="w-11 h-11 rounded-full
                        flex items-center justify-center"
                    >

                        <span class="material-symbols-rounded">
                            edit_note
                        </span>

                    </div>

                    <span class="text-sm font-semibold">
                        Isi Form
                    </span>

                </div>

                {{-- STEP 2 --}}

                <div class="flex flex-col items-center gap-2 z-10">

                    <div
                        :class="step >= 2
                            ? 'bg-primary text-white step-circle active'
                            : 'bg-slate-200 text-slate-500 step-circle'"
                        class="w-11 h-11 rounded-full
                        flex items-center justify-center
                        shadow-lg shadow-blue-500/20"
                    >

                        <template x-if="step < 2">

                            <span class="text-sm font-bold">
                                2
                            </span>

                        </template>

                        <template x-if="step >= 2">

                            <span class="material-symbols-rounded">
                                upload_file
                            </span>

                        </template>

                    </div>

                    <span class="text-sm font-semibold">
                        Upload Berkas
                    </span>

                </div>

                {{-- STEP 3 --}}
                <div class="flex flex-col items-center gap-2 z-10">

                    <div
                        :class="step >= 3
                            ? 'bg-primary text-white step-circle active'
                            : 'bg-slate-200 text-slate-500 step-circle'"
                        class="w-11 h-11 rounded-full
                        flex items-center justify-center"
                    >

                        <span class="material-symbols-rounded">
                            check_circle
                        </span>

                    </div>

                    <span class="text-sm font-semibold">
                        Selesai
                    </span>

                </div>

            </div>

        </div>

    </div>

    {{-- STEP 1 --}}
    <div x-show="step === 1 " class="step-panel">

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">

            {{-- DATA DIRI --}}
            <div class="glass-panel animated-glass hover-float rounded-[28px] p-7 space-y-5 self-start">

                <h2 class="text-[28px] font-medium text-slate-900">
                    Data Diri
                </h2>

                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-500">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        class="glass-input w-full px-5 py-3"
                        placeholder="Masukkan nama lengkap"
                    >

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-500">
                            NIM
                        </label>

                        <input
                            type="text"
                            class="glass-input w-full px-5 py-3"
                            placeholder="NIM"
                        >

                    </div>

                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-500">
                            TTL
                        </label>

                        <input
                            type="text"
                            class="glass-input w-full px-5 py-3"
                            placeholder="Tempat, tanggal lahir"
                        >

                    </div>

                </div>

                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-500">
                        Program Studi
                    </label>

                    <select class="glass-input w-full px-5 py-3">

                        <option>Pilih Prodi</option>
                        <option>Teknik Informatika</option>
                        <option>Sistem Informasi</option>

                    </select>

                </div>

                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-500">
                        Alamat
                    </label>

                    <textarea
                        rows="4"
                        class="glass-input w-full px-5 py-3 resize-none"
                    ></textarea>

                </div>

            </div>

            {{-- DATA AKADEMIK --}}
            <div class="glass-panel animated-glass hover-float rounded-[28px] p-7 space-y-5">

                <h2 class="text-[28px] font-medium text-slate-900">
                    Data Akademik
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-500">
                            Tahun Ajaran
                        </label>

                        <select class="glass-input w-full px-5 py-3">

                            <option>2024/2025</option>
                            <option>2023/2024</option>

                        </select>

                    </div>

                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-500">
                            Semester
                        </label>

                        <select class="glass-input w-full px-5 py-3">

                            <option>Ganjil</option>
                            <option>Genap</option>

                        </select>

                    </div>

                </div>

                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-500">
                        Jenis Surat
                    </label>

                    <select class="glass-input w-full px-5 py-3">

                        <option>Pilih Jenis Surat</option>
                        <option>Surat Aktif Kuliah</option>
                        <option>Surat PKL</option>
                        <option>Transkrip Nilai</option>

                    </select>

                </div>


            </div>

        </div>

        {{-- ACTION --}}
        <div class="flex justify-end mt-8">

            <button
                @click="nextStep()"
                class="px-8 py-3 rounded-full
                bg-primary text-white glow-button
                font-semibold
                hover:brightness-110 transition-all"
            >
                Lanjut
            </button>

        </div>

    </div>

    {{-- STEP 2 --}}
    <div x-show="step === 2" class="step-panel">

        <div class="glass-panel animated-glass hover-float rounded-[28px] p-7 space-y-6">

            <div>

                <h2 class="text-[28px] font-bold text-slate-900">
                    Upload Berkas
                </h2>

                <p class="text-slate-500 mt-1">
                    Upload file pendukung pengajuan.
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                {{-- ITEM --}}
                <label
                    class="upload-card border-2 border-dashed border-slate-300
                    rounded-[24px] p-6
                    flex flex-col items-center justify-center
                    text-center gap-3
                    cursor-pointer hover:border-primary transition-all"
                >

                    <span class="material-symbols-rounded text-[40px] text-primary">
                        upload_file
                    </span>

                    <div>

                        <h3 class="font-bold text-slate-800">
                            Upload KK
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            PDF / JPG / PNG
                        </p>

                    </div>

                    <input
                        type="file"
                        class="hidden"
                    >

                </label>

            </div>

        </div>

        {{-- ACTION --}}
        <div class="flex items-center justify-between mt-8">

            <button
                @click="prevStep()"
                class="px-8 py-3 rounded-full
                glass-panel font-semibold"
            >
                Kembali
            </button>

            <button
                @click="nextStep()"
                class="px-8 py-3 rounded-full
                bg-primary text-white glow-button
                font-semibold"
            >
                Kirim Pengajuan
            </button>

        </div>

    </div>

    {{-- STEP 3 --}}
    <div x-show="step === 3" class="step-panel">

        <div
            class="glass-panel rounded-[32px]
            p-16 text-center"
        >

            <div
                class="w-24 h-24 rounded-full
                bg-blue-100
                mx-auto
                flex items-center justify-center"
            >

                <span class="material-symbols-rounded text-primary text-[54px]">
                    check_circle
                </span>

            </div>

            <h2 class="mt-8 text-[42px] font-black text-slate-900">
                Pengajuan Berhasil!
            </h2>

            <p class="mt-3 text-lg text-slate-500 max-w-2xl mx-auto">
                Pengajuan Anda berhasil dikirim dan sedang diproses admin.
            </p>

            <div class="flex justify-center gap-4 mt-10">

                <a
                    href="{{ route('mahasiswa.riwayat') }}"
                    class="px-8 py-3 rounded-full
                    bg-primary text-white glow-button
                    font-semibold"
                >
                    Lihat Riwayat
                </a>

                <a
                    href="{{ route('mahasiswa.dashboard') }}"
                    class="px-8 py-3 rounded-full
                    glass-panel font-semibold"
                >
                    Dashboard
                </a>

            </div>

        </div>

    </div>

</div>

@endsection