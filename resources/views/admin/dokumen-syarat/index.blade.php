@extends('layouts.admin')

@section('title', 'Dokumen Syarat')

@section('content')

<div x-data="{ openTambahModal: false, openCard: 1, openRequirementModal: false }">
<main class="ml-0 md:ml-64 min-h-screen flex flex-col pt-6">
    <div class="flex-1 px-6 pb-10 pt-6 w-full space-y-7">
    <div class="w-full px-8 py-8 space-y-7">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

            <div>
                <h1 class="text-[34px] leading-none font-bold text-[#111827]">
                    Dokumen Syarat
                </h1>

                <p class="mt-2 text-[15px] text-[#64748b]">
                    Kelola persyaratan dokumen untuk setiap jenis surat pengajuan.
                </p>
            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- CARD --}}
            <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-[#eaf2ff]
                    flex items-center justify-center text-[#0058BC]">

                    <span class="material-symbols-outlined text-[30px]">
                        folder_open
                    </span>
                </div>

                <div>
                    <p class="text-[15px] text-[#64748b] font-medium">
                        Jenis Surat
                    </p>

                    <h2 class="text-[40px] leading-none font-bold text-[#0f172a] mt-1">
                        5
                    </h2>
                </div>
            </div>

            <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-[#f3ebff]
                    flex items-center justify-center text-[#7c3aed]">

                    <span class="material-symbols-outlined text-[30px]">
                        attach_file
                    </span>
                </div>

                <div>
                    <p class="text-[15px] text-[#64748b] font-medium">
                        Total Syarat
                    </p>

                    <h2 class="text-[40px] leading-none font-bold text-[#0f172a] mt-1">
                        21
                    </h2>
                </div>
            </div>

            <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-[#ffecec]
                    flex items-center justify-center text-[#ef4444]">

                    <span class="material-symbols-outlined text-[30px]">
                        priority_high
                    </span>
                </div>

                <div>
                    <p class="text-[15px] text-[#64748b] font-medium">
                        Wajib
                    </p>

                    <h2 class="text-[40px] leading-none font-bold text-[#0f172a] mt-1">
                        19
                    </h2>
                </div>
            </div>

            <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-[#f1f5f9]
                    flex items-center justify-center text-[#475569]">

                    <span class="material-symbols-outlined text-[30px]">
                        info
                    </span>
                </div>

                <div>
                    <p class="text-[15px] text-[#64748b] font-medium">
                        Opsional
                    </p>

                    <h2 class="text-[40px] leading-none font-bold text-[#0f172a] mt-1">
                        2
                    </h2>
                </div>
            </div>

        </div>

        {{-- FILTER --}}
        <div class="flex flex-wrap gap-3">

            <button class="h-12 px-6 rounded-full bg-[#0058BC]
                text-white font-semibold text-[15px]
                shadow-[0_8px_20px_rgba(0,88,188,0.25)]">

                Semua
            </button>

            <button class="h-12 px-6 rounded-full bg-white
                border border-[#e5e7eb]
                text-[#334155] font-semibold text-[15px]">

                Tampilkan Hanya Wajib
            </button>

            <button class="h-12 px-6 rounded-full bg-white
                border border-[#e5e7eb]
                text-[#334155] font-semibold text-[15px]
                flex items-center gap-2">

                <span class="material-symbols-outlined text-[18px]">
                    unfold_more
                </span>

                Buka Semua
            </button>

            <button class="h-12 px-6 rounded-full bg-white
                border border-[#e5e7eb]
                text-[#334155] font-semibold text-[15px]
                flex items-center gap-2">

                <span class="material-symbols-outlined text-[18px]">
                    unfold_less
                </span>

                Tutup Semua
            </button>
        </div>

        {{-- CARD SURAT --}}
        <div class="space-y-4">

            <div class="bg-white border border-[#e8edf7]
                rounded-[24px] overflow-hidden">

                {{-- HEADER --}}
                <div class="px-6 py-5 flex items-center gap-5">

                    <div class="w-14 h-14 rounded-2xl bg-[#eaf2ff]
                        flex items-center justify-center text-[#2563eb]">

                        <span class="material-symbols-outlined text-[30px]">
                            description
                        </span>
                    </div>

                    <div class="flex-1">

                        <div class="flex items-center gap-3 flex-wrap">

                            <h2 class="text-[20px] font-bold text-[#0f172a]">
                                Surat Keterangan Aktif
                            </h2>

                            <span class="px-3 py-1 rounded-full
                                bg-[#eaf2ff] text-[#2563eb]
                                text-[12px] font-bold border border-[#bfdbfe]">

                                Aktif
                            </span>
                        </div>

                        <p class="mt-1 text-[15px] text-[#64748b]">
                            Menyatakan bahwa mahasiswa masih aktif terdaftar di institusi.
                        </p>
                    </div>

                    <div class="hidden md:flex items-center gap-5 text-[15px] text-[#64748b]">

                        <span class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            5 wajib
                        </span>

                        <span class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                            1 opsional
                        </span>
                    </div>

                    <div class="flex items-center gap-3 ml-4">

                        <button class="text-[#2563eb]">
                            <span class="material-symbols-outlined">
                                edit
                            </span>
                        </button>

                        <button class="text-[#ef4444]">
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                        </button>

                        <button 
                            class="text-[#64748b]"
                            @click="openCard === 1 ? openCard = null : openCard = 1"
                        >
                            <span 
                                class="material-symbols-outlined transition duration-300"
                                :class="openCard === 1 ? 'rotate-180' : ''"
                            >
                                expand_more
                            </span>
                        </button>
                    </div>
                </div>


        {{-- REQUIREMENT CONTENT --}}
        <div
            x-show="openCard === 1"
            x-transition
            class="px-6 pb-5 pt-4 border-t border-[#edf2f7] space-y-3"
        >

            {{-- DOC ITEM --}}
            <div class="group flex items-start gap-3 p-4 rounded-[20px] bg-[#f8fafc] border border-[#edf2f7] hover:bg-white transition-all">

                {{-- drag --}}
                <div class="mt-1 text-[#94a3b8] opacity-0 group-hover:opacity-100 transition">
                    <span class="material-symbols-outlined text-[18px]">
                        drag_indicator
                    </span>
                </div>

                {{-- content --}}
                <div class="flex-1 min-w-0">

                    <div class="flex items-center gap-2 flex-wrap">

                        <span class="px-2 py-[3px]
                            rounded-full
                            bg-red-100
                            text-red-500
                            border border-red-200
                            text-[10px]
                            font-bold">

                            ● Wajib
                        </span>

                        <h3 class="text-[17px] font-bold text-[#0f172a]">
                            Kartu Keluarga (KK)
                        </h3>
                    </div>

                    <p class="mt-2 text-[14px] text-[#64748b]">
                        Scan semua halaman, pastikan terbaca jelas.
                    </p>

                    {{-- FORMAT --}}
                    <div class="flex items-center gap-2 flex-wrap mt-3">

                        <span class="px-2 py-[3px]
                            rounded-full
                            border border-red-200
                            text-red-500
                            bg-red-50
                            text-[10px]
                            font-bold">
                            PDF
                        </span>

                        <span class="px-2 py-[3px]
                            rounded-full
                            border border-violet-200
                            text-violet-500
                            bg-violet-50
                            text-[10px]
                            font-bold">
                            JPG
                        </span>

                        <span class="px-2 py-[3px]
                            rounded-full
                            border border-blue-200
                            text-blue-500
                            bg-blue-50
                            text-[10px]
                            font-bold">
                            PNG
                        </span>

                        <span class="flex items-center gap-1
                            text-[11px]
                            text-[#94a3b8]">

                            <span class="material-symbols-outlined text-[13px]">
                                storage
                            </span>

                            Maks. 5 MB
                        </span>
                    </div>
                </div>

                {{-- action --}}
                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">

                    <button class="p-1.5 rounded-lg text-blue-500 hover:bg-blue-50">
                        <span class="material-symbols-outlined text-[18px]">
                            edit
                        </span>
                    </button>

                    <button class="p-1.5 rounded-lg text-red-500 hover:bg-red-50">
                        <span class="material-symbols-outlined text-[18px]">
                            delete
                        </span>
                    </button>
                </div>
            </div>

            {{-- ADD DOC BUTTON --}}
            <button
                type="button"
                @click="openRequirementModal = true"
                class="w-full flex items-center justify-center gap-2
                p-4 rounded-[18px]
                border-2 border-dashed border-[#dbe4f0]
                text-[#64748b]
                hover:border-[#0A65CC]
                hover:text-[#0A65CC]
                hover:bg-[#f8fbff]
                transition-all
                text-[15px]
                font-semibold"
            >

                <span class="material-symbols-outlined text-[20px]">
                    add_circle
                </span>

                Tambah Dokumen Syarat
            </button>
        </div>
            </div>

        </div>
    </div>
</div>
<!-- MODAL TAMBAH DOKUMEN -->
<div
    x-show="openRequirementModal"
    x-transition
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
    style="display: none;"
>

    <div
        @click.outside="openRequirementModal = false"
        class="w-full max-w-[560px] max-h-[90vh] overflow-y-auto rounded-[32px] bg-white p-8 shadow-2xl"
    >

        <!-- HEADER -->
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-[36px] font-bold leading-none text-[#111827]">
                    Tambah Dokumen Syarat
                </h2>

                <p class="mt-2 text-[#2563EB] font-semibold">
                    Surat Keterangan Aktif
                </p>
            </div>

            <button
                @click="openRequirementModal = false"
                class="text-gray-400 hover:text-gray-700 transition"
            >
                <span class="material-symbols-outlined text-[32px]">
                    close
                </span>
            </button>
        </div>

        <!-- FORM -->
        <div class="space-y-6">

            <!-- Nama -->
            <div>
                <label class="block mb-2 font-semibold">
                    Nama Dokumen <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    placeholder="Contoh: Kartu Keluarga (KK)"
                    class="w-full h-[58px] rounded-2xl border border-gray-300 px-5 outline-none focus:border-blue-500"
                >
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block mb-2 font-semibold">
                    Keterangan / Petunjuk
                </label>

                <textarea
                    rows="3"
                    placeholder="Contoh: Scan semua halaman, pastikan terbaca jelas..."
                    class="w-full rounded-2xl border border-gray-300 p-5 outline-none focus:border-blue-500 resize-none"
                ></textarea>
            </div>

            <!-- FORMAT -->
            <div>
                <label class="block mb-3 font-semibold">
                    Format File yang Diterima
                </label>

                <div class="flex flex-wrap gap-3">

                    <button class="px-4 py-2 rounded-full border border-red-300 text-red-500 text-sm font-semibold">
                        PDF
                    </button>

                    <button class="px-4 py-2 rounded-full border border-blue-300 text-blue-500 text-sm font-semibold">
                        JPG
                    </button>

                    <button class="px-4 py-2 rounded-full border border-indigo-300 text-indigo-500 text-sm font-semibold">
                        PNG
                    </button>

                    <button class="px-4 py-2 rounded-full border border-sky-300 text-sky-600 text-sm font-semibold">
                        DOCX
                    </button>

                </div>
            </div>

            <!-- GRID -->
            <div class="grid grid-cols-2 gap-4">

                <!-- Ukuran -->
                <div>
                    <label class="block mb-2 font-semibold">
                        Ukuran Maks.
                    </label>

                    <select
                        class="w-full h-[58px] rounded-2xl border border-gray-300 px-5 outline-none"
                    >
                        <option>5 MB</option>
                        <option>10 MB</option>
                        <option>20 MB</option>
                    </select>
                </div>

                <!-- Kewajiban -->
                <div>
                    <label class="block mb-2 font-semibold">
                        Kewajiban
                    </label>

                    <select
                        class="w-full h-[58px] rounded-2xl border border-gray-300 px-5 outline-none"
                    >
                        <option>Wajib</option>
                        <option>Opsional</option>
                    </select>
                </div>

            </div>

            <!-- Berlaku -->
            <div>
                <label class="block mb-2 font-semibold">
                    Berlaku Untuk
                </label>

                <select
                    class="w-full h-[58px] rounded-2xl border border-gray-300 px-5 outline-none"
                >
                    <option>Semua Mahasiswa</option>
                    <option>Ortu PNS</option>
                    <option>Ortu Swasta</option>
                    <option>Ortu TNI/POLRI</option>
                    <option>Ortu Wirausahawan</option>
                    <option>Ortu Pensiunan</option>
                </select>
            </div>

            <!-- Urutan -->
            <div>
                <label class="block mb-2 font-semibold">
                    Urutan Tampil
                </label>

                <input
                    type="number"
                    placeholder="Contoh: 1"
                    class="w-full h-[58px] rounded-2xl border border-gray-300 px-5 outline-none focus:border-blue-500"
                >
            </div>

        </div>

        <!-- FOOTER -->
        <div class="mt-8 flex justify-end gap-4">

            <button
                @click="openRequirementModal = false"
                class="h-[54px] px-8 rounded-full bg-gray-100 font-semibold"
            >
                Batal
            </button>

            <button
                class="h-[54px] px-8 rounded-full bg-[#0F67E8] text-white font-semibold shadow-lg"
            >
                Simpan Dokumen
            </button>

        </div>

    </div>
</div>
</main>
<!-- MODAL TAMBAH JENIS SURAT -->
<div
    x-show="openTambahModal"
    x-transition
    class="fixed inset-0 z-[999] flex items-center justify-center overflow-y-auto bg-bold/30 backdrop-blur-sm px-4"
    style="display: none;"
>
    <div
        @click.outside="openTambahModal = false"
        class="w-full max-w-[520px] max-h-[90vh] rounded-[28px] bg-white shadow-2xl overflow-y-auto"
    >

        <!-- HEADER -->
        <div class="flex items-start justify-between px-6 pt-6">
            <div>
                <h2 class="text-[24px] leading-none font-bold text-[#0F172A]">
                    Tambah Jenis Surat
                </h2>

                <p class="mt-2 text-[18px] text-slate-500">
                    Data master jenis surat pengajuan
                </p>
            </div>

            <button
                @click="openTambahModal = false"
                class="text-slate-400 hover:text-slate-600 transition"
            >
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>
        </div>

        <!-- BODY -->
        <form class="px-6 py-7 space-y-5">

            <!-- NAMA -->
            <div>
                <label class="block text-[18px] font-semibold text-slate-700 mb-3">
                    Nama Jenis Surat <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    placeholder="Contoh: Surat Keterangan Aktif"
                    class="w-full h-[48px] rounded-2xl border border-slate-300 px-6 text-[16px] focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- ICON -->
            <div>
                <label class="block text-[15px] font-semibold text-slate-700 mb-4">
                    Ikon (Material Symbol)
                </label>

                <div class="flex flex-wrap gap-3">

                    @php
                        $icons = [
                            'description',
                            'badge',
                            'business_center',
                            'school',
                            'workspace_premium',
                            'apartment',
                            'groups',
                            'assignment',
                            'settings',
                            'article'
                        ];
                    @endphp

                    @foreach ($icons as $icon)
                        <button
                            type="button"
                            class="w-11 h-11 rounded-2xl border border-slate-200 flex items-center justify-center hover:border-blue-500 hover:bg-blue-50 transition"
                        >
                            <span class="material-symbols-outlined text-[20px] text-slate-600">
                                {{ $icon }}
                            </span>
                        </button>
                    @endforeach 

                </div>
            </div>

            <!-- ICON NAME -->
            <div>
                <input
                    type="text"
                    value="description"
                    class="w-full h-[64px] rounded-2xl border border-slate-300 px-6 text-[20px]"
                >
            </div>

            <!-- WARNA -->
            <div>
                <label class="block text-[18px] font-semibold text-slate-700 mb-4">
                    Warna Aksen
                </label>

                <div class="flex items-center gap-4">

                    <button type="button" class="w-10 h-10 rounded-full bg-blue-600 ring-4 ring-blue-200"></button>

                    <button type="button" class="w-10 h-10 rounded-full bg-violet-500"></button>

                    <button type="button" class="w-10 h-10 rounded-full bg-green-500"></button>

                    <button type="button" class="w-10 h-10 rounded-full bg-amber-500"></button>

                    <button type="button" class="w-10 h-10 rounded-full bg-red-500"></button>

                    <button type="button" class="w-10 h-10 rounded-full bg-slate-500"></button>

                </div>
            </div>

            <!-- DESKRIPSI -->
            <div>
                <label class="block text-[18px] font-semibold text-slate-700 mb-3">
                    Deskripsi
                </label>

                <textarea
                    rows="4"
                    placeholder="Keterangan singkat tentang jenis surat ini..."
                    class="w-full rounded-2xl border border-slate-300 px-6 py-5 text-[18px] resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
            </div>

            <!-- FOOTER -->
            <div class="flex justify-end gap-4 pt-2">

                <button
                    type="button"
                    @click="openTambahModal = false"
                    class="h-[48px] px-6 rounded-2xl bg-slate-100 text-slate-700 text-[15px] font-semibold hover:bg-slate-200 transition"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="h-[48px] px-6 rounded-2xl bg-blue-600 text-white text-[15px] font-semibold shadow-lg shadow-blue-200 hover:bg-blue-700 transition flex items-center gap-2"
                >
                    <span class="material-symbols-outlined">
                        save
                    </span>

                    Simpan
                </button>

            </div>

        </form>
    </div>
</div>
</div>

@endsection