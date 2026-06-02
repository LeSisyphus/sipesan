@extends('layouts.admin')

@section('title', 'Dokumen Syarat')

@section('content')

<div x-data="{ openTambahModal: false, openCard: 1, openRequirementModal: false, openEditDocumentModal: false,
                selectedDocument:{
                    nama: '',
                    deskripsi: '',
                    ukuran: ''
                    } 
                }">
<main class="ml-0 md:ml-64 min-h-screen flex flex-col pt-6">
    <div class="flex-1 px-6 pb-10 pt-6 w-full space-y-7">
    <div class="w-full px-8 py-8 space-y-7">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

            <div>
                <h1 class="text-[34px] leading-none font-semibold text-[#111827]">
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

                    <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
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

                    <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
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

                    <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
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

                    <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
                        2
                    </h2>
                </div>
            </div>

        </div>

        {{-- FILTER --}}
        <div class="flex flex-wrap gap-4">

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

            <button
                @click="openTambahModal = true"
                class="h-12 px-6 rounded-full
                bg-[#0058BC]
                text-white font-semibold text-[15px]
                flex items-center gap-2
                shadow-[0_8px_20px_rgba(0,88,188,0.25)]"
            >

                <span class="material-symbols-outlined">
                    note_add
                </span>

                Tambah Dokumen Syarat

            </button>
        </div>

        {{-- MASTER DOKUMEN SYARAT --}}
        <div class="bg-white border border-[#e8edf7] rounded-[24px] overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b border-[#edf2f7]">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-2xl bg-[#eaf2ff]
                            flex items-center justify-center text-[#2563eb]">

                            <span class="material-symbols-outlined">
                                folder_open
                            </span>

                        </div>

                        <div>

                            <h2 class="text-[22px] font-semibold text-[#0f172a]">
                                Master Dokumen Syarat
                            </h2>

                            <p class="text-[14px] text-[#64748b]">
                                Daftar seluruh dokumen syarat yang tersedia.
                            </p>

                        </div>

                    </div>

                    <button
                        class="h-11 px-5 rounded-full
                        border border-[#dbe3ef]
                        text-[#334155]
                        font-semibold text-[14px]"
                    >

                        Kelola Master

                    </button>

                </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="bg-[#f8fafc]">

                            <th class="text-left px-6 py-4 text-sm font-semibold">
                                Nama Dokumen
                            </th>

                            <th class="text-left px-6 py-4 text-sm font-semibold">
                                Deskripsi
                            </th>

                            <th class="text-left px-6 py-4 text-sm font-semibold">
                                Format
                            </th>

                            <th class="text-left px-6 py-4 text-sm font-semibold">
                                Maks
                            </th>

                            <th class="text-center px-6 py-4 text-sm font-semibold">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        {{-- KK --}}
                        <tr class="border-t border-[#edf2f7]">

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 rounded-xl
                                        bg-blue-50 text-blue-600
                                        flex items-center justify-center"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">
                                            groups
                                        </span>
                                    </div>

                                    <span class="font-semibold">
                                        Kartu Keluarga (KK)
                                    </span>

                                </div>

                            </td>

                            <td class="px-6 py-4 text-[#64748b]">
                                Scan semua halaman.
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <span class="px-2 py-1 rounded-full bg-red-50 text-red-500 text-xs font-semibold">
                                        PDF
                                    </span>

                                    <span class="px-2 py-1 rounded-full bg-blue-50 text-blue-500 text-xs font-semibold">
                                        JPG
                                    </span>

                                    <span class="px-2 py-1 rounded-full bg-indigo-50 text-indigo-500 text-xs font-semibold">
                                        PNG
                                    </span>

                                </div>

                            </td>

                            <td class="px-6 py-4">
                                5 MB
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <button
                                        @click="
                                            selectedDocument = {
                                                nama: 'Kartu Keluarga (KK)',
                                                deskripsi: 'Scan semua halaman, pastikan terbaca jelas.',
                                                ukuran: '5 MB'
                                            };

                                            openEditDocumentModal = true;
                                        "
                                        class="text-blue-500 hover:text-blue-700"
                                    >
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </button>

                                    <button
                                        @click="
                                            Swal.fire({
                                                title: 'Hapus Dokumen?',
                                                text: 'Dokumen syarat yang dihapus tidak dapat dikembalikan.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#ef4444',
                                                cancelButtonColor: '#94a3b8',
                                                confirmButtonText: 'Ya, Hapus',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire({
                                                        title: 'Berhasil!',
                                                        text: 'Dokumen berhasil dihapus.',
                                                        icon: 'success',
                                                        confirmButtonColor: '#2563eb'
                                                    })
                                                }
                                            })
                                        "
                                        class="p-1.5 rounded-lg text-red-500 hover:bg-red-50"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">
                                            delete
                                        </span>
                                    </button>

                                </div>

                            </td>

                        </tr>

                        {{-- KTP --}}
                        <tr class="border-t border-[#edf2f7]">

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 rounded-xl
                                        bg-violet-50 text-violet-600
                                        flex items-center justify-center"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">
                                            badge
                                        </span>
                                    </div>

                                    <span class="font-semibold">
                                        KTP
                                    </span>

                                </div>

                            </td>

                            <td class="px-6 py-4 text-[#64748b]">
                                Scan KTP asli.
                            </td>

                            <td class="px-6 py-4">
                                PDF, JPG
                            </td>

                            <td class="px-6 py-4">
                                5 MB
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <button
                                        @click="
                                            selectedDocument = {
                                                nama: 'Kartu Keluarga (KK)',
                                                deskripsi: 'Scan semua halaman, pastikan terbaca jelas.',
                                                ukuran: '5 MB'
                                            };

                                            openEditDocumentModal = true;
                                        "
                                        class="text-blue-500 hover:text-blue-700"
                                    >
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </button>

                                    <button
                                        @click="
                                            Swal.fire({
                                                title: 'Hapus Dokumen?',
                                                text: 'Dokumen syarat yang dihapus tidak dapat dikembalikan.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#ef4444',
                                                cancelButtonColor: '#94a3b8',
                                                confirmButtonText: 'Ya, Hapus',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire({
                                                        title: 'Berhasil!',
                                                        text: 'Dokumen berhasil dihapus.',
                                                        icon: 'success',
                                                        confirmButtonColor: '#2563eb'
                                                    })
                                                }
                                            })
                                        "
                                        class="p-1.5 rounded-lg text-red-500 hover:bg-red-50"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">
                                            delete
                                        </span>
                                    </button>

                                </div>

                            </td>

                        </tr>

                        {{-- KTM --}}
                        <tr class="border-t border-[#edf2f7]">

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 rounded-xl
                                        bg-green-50 text-green-600
                                        flex items-center justify-center"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">
                                            school
                                        </span>
                                    </div>

                                    <span class="font-semibold">
                                        KTM
                                    </span>

                                </div>

                            </td>

                            <td class="px-6 py-4 text-[#64748b]">
                                Scan KTM aktif.
                            </td>

                            <td class="px-6 py-4">
                                PDF, JPG
                            </td>

                            <td class="px-6 py-4">
                                5 MB
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <button
                                        @click="
                                            selectedDocument = {
                                                nama: 'Kartu Keluarga (KK)',
                                                deskripsi: 'Scan semua halaman, pastikan terbaca jelas.',
                                                ukuran: '5 MB'
                                            };

                                            openEditDocumentModal = true;
                                        "
                                        class="text-blue-500 hover:text-blue-700"
                                    >
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </button>

                                    <button
                                        @click="
                                            Swal.fire({
                                                title: 'Hapus Dokumen?',
                                                text: 'Dokumen syarat yang dihapus tidak dapat dikembalikan.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#ef4444',
                                                cancelButtonColor: '#94a3b8',
                                                confirmButtonText: 'Ya, Hapus',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire({
                                                        title: 'Berhasil!',
                                                        text: 'Dokumen berhasil dihapus.',
                                                        icon: 'success',
                                                        confirmButtonColor: '#2563eb'
                                                    })
                                                }
                                            })
                                        "
                                        class="p-1.5 rounded-lg text-red-500 hover:bg-red-50"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">
                                            delete
                                        </span>
                                    </button>

                                </div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

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

                            <h2 class="text-[20px] font-semibold text-[#0f172a]">
                                Surat Keterangan Aktif
                            </h2>

                            <span class="px-3 py-1 rounded-full
                                bg-[#eaf2ff] text-[#2563eb]
                                text-[12px] font-semibold border border-[#bfdbfe]">

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
                            font-semibold">

                            ● Wajib
                        </span>

                        <h3 class="text-[17px] font-semibold text-[#0f172a]">
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
                            font-semibold">
                            PDF
                        </span>

                        <span class="px-2 py-[3px]
                            rounded-full
                            border border-violet-200
                            text-violet-500
                            bg-violet-50
                            text-[10px]
                            font-semibold">
                            JPG
                        </span>

                        <span class="px-2 py-[3px]
                            rounded-full
                            border border-blue-200
                            text-blue-500
                            bg-blue-50
                            text-[10px]
                            font-semibold">
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

                    <button
                        @click="
                            Swal.fire({
                                title: 'Hapus Dokumen?',
                                text: 'Dokumen syarat yang dihapus tidak dapat dikembalikan.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#ef4444',
                                cancelButtonColor: '#94a3b8',
                                confirmButtonText: 'Ya, Hapus',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Dokumen berhasil dihapus.',
                                        icon: 'success',
                                        confirmButtonColor: '#2563eb'
                                    })
                                }
                            })
                        "
                        class="p-1.5 rounded-lg text-red-500 hover:bg-red-50"
                    >
                        <span class="material-symbols-outlined text-[18px]">
                            delete
                        </span>
                    </button>
                </div>
            </div>

            {{-- ADD DOC BUTTON --}}
            <button
                @click="openRequirementModal = true"
                class="w-full py-5
                border-2 border-dashed
                border-[#c7d7f2]
                rounded-[20px]
                text-[#64748b]
                hover:border-[#0058BC]
                hover:text-[#0058BC]
                transition"
            >

                <span class="material-symbols-outlined text-[20px]">
                    add_circle
                </span>

                Tambah Syarat ke Surat Ini
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
        class="fixed inset-0 z-[9999]
        flex items-center justify-center
        bg-black/40 backdrop-blur-sm p-4"
    >

    <div
        @click.outside="openRequirementModal=false"
        class="w-full max-w-[600px]
        bg-white rounded-[32px]
        p-8"
    >

        <div class="flex items-center justify-between mb-6">

            <div>
                <h2 class="text-[30px] font-semibold">
                    Tambah Syarat ke Surat
                </h2>

                <p class="text-slate-500">
                    Surat Keterangan Aktif
                </p>
            </div>

            <button @click="openRequirementModal=false">
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>

        </div>

        <div class="space-y-3">

            {{-- KK --}}
            <label
                class="flex items-center gap-4
                p-5 border border-slate-200
                rounded-[20px]
                hover:border-blue-300
                hover:bg-blue-50/30
                transition cursor-pointer"
            >

                <input
                    type="checkbox"
                    class="w-5 h-5 rounded"
                >

                <div
                    class="w-10 h-10 rounded-xl
                    bg-blue-50 text-blue-600
                    flex items-center justify-center"
                >
                    <span class="material-symbols-outlined">
                        groups
                    </span>
                </div>

                <div>
                    <p class="font-semibold text-slate-800">
                        Kartu Keluarga (KK)
                    </p>

                    <p class="text-sm text-slate-500">
                        Dokumen identitas keluarga
                    </p>
                </div>

            </label>

            {{-- KTP --}}
            <label
                class="flex items-center gap-4
                p-5 border border-slate-200
                rounded-[20px]
                hover:border-violet-300
                hover:bg-violet-50/30
                transition cursor-pointer"
            >

                <input
                    type="checkbox"
                    class="w-5 h-5 rounded"
                >

                <div
                    class="w-10 h-10 rounded-xl
                    bg-violet-50 text-violet-600
                    flex items-center justify-center"
                >
                    <span class="material-symbols-outlined">
                        badge
                    </span>
                </div>

                <div>
                    <p class="font-semibold text-slate-800">
                        Kartu Tanda Penduduk (KTP)
                    </p>

                    <p class="text-sm text-slate-500">
                        Identitas resmi penduduk
                    </p>
                </div>

            </label>

            {{-- KTM --}}
            <label
                class="flex items-center gap-4
                p-5 border border-slate-200
                rounded-[20px]
                hover:border-green-300
                hover:bg-green-50/30
                transition cursor-pointer"
            >

                <input
                    type="checkbox"
                    class="w-5 h-5 rounded"
                >

                <div
                    class="w-10 h-10 rounded-xl
                    bg-green-50 text-green-600
                    flex items-center justify-center"
                >
                    <span class="material-symbols-outlined">
                        school
                    </span>
                </div>

                <div>
                    <p class="font-semibold text-slate-800">
                        Kartu Tanda Mahasiswa (KTM)
                    </p>

                    <p class="text-sm text-slate-500">
                        Bukti status mahasiswa aktif
                    </p>
                </div>

            </label>

            {{-- PAS FOTO --}}
            <label
                class="flex items-center gap-4
                p-5 border border-slate-200
                rounded-[20px]
                hover:border-amber-300
                hover:bg-amber-50/30
                transition cursor-pointer"
            >

                <input
                    type="checkbox"
                    class="w-5 h-5 rounded"
                >

                <div
                    class="w-10 h-10 rounded-xl
                    bg-amber-50 text-amber-600
                    flex items-center justify-center"
                >
                    <span class="material-symbols-outlined">
                        photo_camera
                    </span>
                </div>

                <div>
                    <p class="font-semibold text-slate-800">
                        Pas Foto
                    </p>

                    <p class="text-sm text-slate-500">
                        Foto formal terbaru mahasiswa
                    </p>
                </div>

            </label>

            {{-- TRANSKRIP --}}
            <label
                class="flex items-center gap-4
                p-5 border border-slate-200
                rounded-[20px]
                hover:border-red-300
                hover:bg-red-50/30
                transition cursor-pointer"
            >

                <input
                    type="checkbox"
                    class="w-5 h-5 rounded"
                >

                <div
                    class="w-10 h-10 rounded-xl
                    bg-red-50 text-red-600
                    flex items-center justify-center"
                >
                    <span class="material-symbols-outlined">
                        description
                    </span>
                </div>

                <div>
                    <p class="font-semibold text-slate-800">
                        Transkrip Nilai
                    </p>

                    <p class="text-sm text-slate-500">
                        Riwayat nilai akademik mahasiswa
                    </p>
                </div>

            </label>

        </div>

        <div class="flex justify-end gap-3 mt-8">

            <button
                @click="openRequirementModal=false"
                class="px-6 py-3 rounded-full bg-slate-100"
            >
                Batal
            </button>

            <button
                class="px-6 py-3 rounded-full
                bg-[#0058BC]
                text-white"
            >
                Tambahkan
            </button>

        </div>

    </div>
    </div>
</main>
<!-- MODAL TAMBAH JENIS SURAT -->
<!-- MODAL TAMBAH MASTER DOKUMEN -->
    <div
        x-show="openTambahModal"
        x-transition
        class="fixed inset-0 z-[9999]
        flex items-center justify-center
        bg-black/40 backdrop-blur-sm p-4"
    >

    <div
        @click.outside="openTambahModal = false"
        class="w-full max-w-[650px]
        rounded-[32px]
        bg-white p-8"
    >

        <div class="flex items-center justify-between mb-8">

            <div>
                <h2 class="text-[32px] font-semibold">
                    Tambah Dokumen Syarat
                </h2>

                <p class="text-slate-500 mt-2">
                    Tambahkan dokumen ke master dokumen syarat.
                </p>
            </div>

            <button @click="openTambahModal=false">
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>

        </div>

        <div class="space-y-5">

            <div>
                <label class="font-semibold">
                    Nama Dokumen
                </label>

                <input
                    type="text"
                    class="w-full mt-2 h-14 rounded-2xl border px-5"
                    placeholder="Contoh: Kartu Keluarga (KK)"
                >
            </div>

            <div>
                <label class="font-semibold">
                    Deskripsi
                </label>

                <textarea
                    rows="3"
                    class="w-full mt-2 rounded-2xl border p-5"
                ></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold">
                        Ukuran Maks.
                    </label>

                    <select class="w-full mt-2 h-14 rounded-2xl border px-5">
                        <option>2 MB</option>
                        <option>5 MB</option>
                        <option>10 MB</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold">
                        Format
                    </label>

                    <select class="w-full mt-2 h-14 rounded-2xl border px-5">
                        <option>PDF</option>
                        <option>JPG</option>
                        <option>PNG</option>
                    </select>
                </div>

            </div>

        </div>

        <div class="flex justify-end gap-3 mt-8">

            <button
                @click="openTambahModal=false"
                class="px-6 py-3 rounded-full bg-slate-100"
            >
                Batal
            </button>

            <button
                class="px-6 py-3 rounded-full
                bg-[#0058BC] text-white"
            >
                Simpan Dokumen
            </button>

        </div>

    </div>
    </div>

<div
    x-show="openEditModal"
    x-transition
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
    style="display:none;"
>

    <div
        @click.outside="openEditModal = false"
        class="w-full max-w-[600px] bg-white rounded-[28px] p-8"
    >

        <h2 class="text-2xl font-semibold mb-2">
            Edit Dokumen
        </h2>

        <p class="text-slate-500 mb-6">
            <span x-text="selectedDocument"></span>
        </p>

        <div class="space-y-4">

            <input
                type="text"
                class="w-full h-14 border rounded-2xl px-4"
                value="Kartu Keluarga (KK)"
            >

            <textarea
                rows="4"
                class="w-full border rounded-2xl p-4"
            >Scan semua halaman.</textarea>

        </div>

        <div class="flex justify-end gap-3 mt-6">

            <button
                @click="openEditModal = false"
                class="px-6 py-3 rounded-full bg-slate-100"
            >
                Batal
            </button>

            <button
                class="px-6 py-3 rounded-full bg-blue-600 text-white"
            >
                Simpan
            </button>

        </div>

    </div>

</div>

<div
    x-show="openEditDocumentModal"
    x-transition
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
    style="display:none;"
>

    <div
        @click.outside="openEditDocumentModal = false"
        class="w-full max-w-[600px] rounded-[28px] bg-white p-8"
    >

        <div class="flex items-start justify-between mb-6">

            <div>
                <h2 class="text-[28px] font-semibold">
                    Edit Dokumen Syarat
                </h2>

                <p class="text-slate-500 mt-1">
                    Perbarui data master dokumen
                </p>
            </div>

            <button
                @click="openEditDocumentModal = false"
            >
                <span class="material-symbols-outlined text-[28px]">
                    close
                </span>
            </button>

        </div>

        <div class="space-y-5">

            <div>

                <label class="block mb-2 font-semibold">
                    Nama Dokumen
                </label>

                <input
                    x-model="selectedDocument.nama"
                    type="text"
                    class="w-full h-14 border border-slate-300 rounded-2xl px-5"
                >

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    Deskripsi
                </label>

                <textarea
                    x-model="selectedDocument.deskripsi"
                    rows="4"
                    class="w-full border border-slate-300 rounded-2xl p-5"
                ></textarea>

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    Ukuran Maksimum
                </label>

                <input
                    x-model="selectedDocument.ukuran"
                    type="text"
                    class="w-full h-14 border border-slate-300 rounded-2xl px-5"
                >

            </div>

        </div>

        <div class="flex justify-end gap-3 mt-8">

            <button
                @click="openEditDocumentModal = false"
                class="px-6 py-3 rounded-full bg-slate-100"
            >
                Batal
            </button>

            <button
                @click="
                    openEditDocumentModal = false;

                    Swal.fire({
                        icon:'success',
                        title:'Berhasil',
                        text:'Perubahan berhasil disimpan',
                        confirmButtonColor:'#2563eb'
                    });
                "
                class="px-6 py-3 rounded-full bg-[#0058BC] text-white"
            >
                Simpan Perubahan
            </button>

        </div>

    </div>

</div>

@endsection