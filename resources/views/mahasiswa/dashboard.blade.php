@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<div class="max-w-[1400px] mx-auto space-y-6">

    {{-- HERO --}}
    <section
        class="glass-panel rounded-[28px]
        p-8 lg:p-10
        relative overflow-hidden"
    >

        <div class="relative z-10">

            <h1
                class="text-[48px] lg:text-[50px]
                font-bold leading-[1.05]
                text-slate-900"
            >
                Selamat Datang,<br>

                <span class="text-primary">
                    Aliza Beth
                </span>
            </h1>

            <p
                class="mt-5
                text-[18px]
                leading-relaxed
                text-slate-600
                max-w-3xl"
            >
                Pantau status pengajuan dokumen akademik Anda dengan mudah.
                Sistem ini dirancang untuk memberikan transparansi dan
                kecepatan dalam setiap proses administrasi.
            </p>

        </div>

        {{-- blur decoration --}}
        <div
            class="hidden lg:block
            absolute -top-12 -right-12
            w-52 h-52 rounded-full
            bg-blue-300/30 blur-3xl"
        ></div>

    </section>

    {{-- STATS --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- TOTAL --}}
        <div
            class="glass-panel rounded-[28px]
            p-6 min-h-[190px]
            flex flex-col justify-between"
        >

            <div
                class="w-14 h-14 rounded-full
                bg-[#EEF4FF]
                flex items-center justify-center"
            >

                <span class="material-symbols-rounded text-primary text-[28px]">
                    description
                </span>

            </div>

            <div>

                <p class="text-slate-500 font-medium text-base">
                    Total Pengajuan Saya
                </p>

                <h3 class="text-[42px] font-bold text-slate-900">
                    14
                </h3>

            </div>

        </div>

        {{-- DIPROSES --}}
        <div
            class="glass-panel rounded-[28px]
            p-6 min-h-[190px]
            flex flex-col justify-between"
        >

            <div
                class="w-14 h-14 rounded-full
                bg-[#F1EDFF]
                flex items-center justify-center"
            >

                <span class="material-symbols-rounded text-[#6D5EF9] text-[28px]">
                    pending_actions
                </span>

            </div>

            <div>

                <p class="text-slate-500 font-medium text-base">
                    Sedang Diproses
                </p>

                <h3 class="text-[42px] font-black text-slate-900">
                    3
                </h3>

            </div>

        </div>

        {{-- CTA --}}
        <a
            href="{{ route('mahasiswa.pengajuan') }}"
            class="rounded-[28px]
            bg-primary text-white
            p-6 min-h-[190px]
            flex flex-col items-center justify-center gap-4
            shadow-[0_12px_40px_-10px_rgba(0,88,188,0.45)]
            hover:scale-[1.02]
            transition-all duration-300"
        >

            <div
                class="w-16 h-16 rounded-full
                bg-white/20
                flex items-center justify-center"
            >

                <span class="material-symbols-rounded text-[34px]">
                    add
                </span>

            </div>

            <h3 class="text-[22px] font-bold text-center leading-tight">
                Buat Pengajuan Baru
            </h3>

        </a>

    </section>

    {{-- AKTIVITAS --}}
    <section
        class="glass-panel rounded-[28px]
        p-6 lg:p-8"
    >

        {{-- HEADER --}}
        <div
            class="flex items-center justify-between
            pb-4 mb-6
            border-b border-slate-200"
        >

            <h2 class="text-[32px] font-black text-slate-900">
                Aktivitas Terbaru
            </h2>

            <a
                href="{{ route('mahasiswa.riwayat') }}"
                class="text-primary font-semibold hover:underline"
            >
                Lihat Semua
            </a>

        </div>

        {{-- ITEMS --}}
        <div class="space-y-4">

            {{-- ITEM --}}
            <div
                class="flex items-center justify-between
                p-4 rounded-2xl
                hover:bg-slate-50 transition"
            >

                <div class="flex items-center gap-4">

                    <div
                        class="w-11 h-11 rounded-full
                        bg-slate-100
                        flex items-center justify-center"
                    >

                        <span class="material-symbols-rounded text-slate-500">
                            mark_email_read
                        </span>

                    </div>

                    <div>

                        <h3 class="text-[20px] font-medium text-slate-900">
                            Surat Keterangan Aktif Kuliah
                        </h3>

                        <p class="text-slate-500 text-sm">
                            12 Oktober 2023 • 10:30 WIB
                        </p>

                    </div>

                </div>

                <span
                    class="px-4 py-1 rounded-full
                    bg-blue-100 text-primary
                    text-sm font-semibold"
                >
                    Selesai
                </span>

            </div>

            {{-- ITEM --}}
            <div
                class="flex items-center justify-between
                p-4 rounded-2xl
                hover:bg-slate-50 transition"
            >

                <div class="flex items-center gap-4">

                    <div
                        class="w-11 h-11 rounded-full
                        bg-slate-100
                        flex items-center justify-center"
                    >

                        <span class="material-symbols-rounded text-slate-500">
                            hourglass_empty
                        </span>

                    </div>

                    <div>

                        <h3 class="text-[20px] font-medium text-slate-900">
                            Transkrip Nilai Sementara
                        </h3>

                        <p class="text-slate-500 text-sm">
                            10 Oktober 2023 • 14:15 WIB
                        </p>

                    </div>

                </div>

                <span
                    class="px-4 py-1 rounded-full
                    bg-slate-100 text-slate-700
                    text-sm font-semibold"
                >
                    Diproses
                </span>

            </div>

        </div>

    </section>

</div>

@endsection