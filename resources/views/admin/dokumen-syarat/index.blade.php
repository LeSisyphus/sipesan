@extends('layouts.admin')

@section('title', 'Dokumen Syarat')

@section('content')
@php
    $formatOptions = [
        'pdf' => 'PDF',
        'jpg' => 'JPG',
        'png' => 'PNG',
        'docx' => 'DOCX',
    ];

    $maxSizeOptions = [2, 5, 10, 20];

    $formatBadgeClass = [
        'pdf' => 'border-red-200 text-red-500 bg-red-50',
        'jpg' => 'border-violet-200 text-violet-500 bg-violet-50',
        'png' => 'border-blue-200 text-blue-500 bg-blue-50',
        'docx' => 'border-sky-200 text-sky-500 bg-sky-50',
    ];

    $iconList = [
        ['icon' => 'groups', 'class' => 'bg-blue-50 text-blue-600'],
        ['icon' => 'badge', 'class' => 'bg-violet-50 text-violet-600'],
        ['icon' => 'school', 'class' => 'bg-green-50 text-green-600'],
        ['icon' => 'photo_camera', 'class' => 'bg-amber-50 text-amber-600'],
        ['icon' => 'description', 'class' => 'bg-red-50 text-red-600'],
        ['icon' => 'article', 'class' => 'bg-cyan-50 text-cyan-600'],
    ];

    $getFormats = function ($dokumen) {
        return collect(explode(',', $dokumen->allowed_formats ?? ''))
            ->map(fn ($format) => strtolower(trim($format)))
            ->filter()
            ->values();
    };

    $totalPdf = $dokumenSyarats->filter(fn ($dokumen) => $getFormats($dokumen)->contains('pdf'))->count();
    $totalGambar = $dokumenSyarats->filter(function ($dokumen) use ($getFormats) {
        $formats = $getFormats($dokumen);

        return $formats->contains('jpg') || $formats->contains('png');
    })->count();
@endphp

<div
    x-data="{
        openTambahModal: false,
        openCard: null,
        allOpen: false,
        openRequirementModal: false,
        openEditDocumentModal: false,

        selectedJenisSurat: {
            id: '',
            nama_surat: '',
            deskripsi: '',
            dokumen_ids: []
        },

        selectedDocIds: [],

        selectedDocument: {
            id: '',
            nama_dokumen: '',
            keterangan: '',
            allowed_formats: [],
            max_size: 5,
            update_url: '#'
        },

        isCardOpen(id) {
            return this.allOpen || String(this.openCard) === String(id);
        },

        toggleCard(id) {
            this.allOpen = false;
            this.openCard = String(this.openCard) === String(id) ? null : String(id);
        },

        openAllCards() {
            this.allOpen = true;
            this.openCard = null;
        },

        closeAllCards() {
            this.allOpen = false;
            this.openCard = null;
        },

        openAssignModal(surat) {
            this.selectedJenisSurat = surat;
            this.selectedDocIds = (surat.dokumen_ids || []).map((id) => String(id));
            this.openRequirementModal = true;
        },

        openEditDocument(dokumen) {
            this.selectedDocument = {
                id: dokumen.id,
                nama_dokumen: dokumen.nama_dokumen || '',
                keterangan: dokumen.keterangan || '',
                allowed_formats: dokumen.allowed_formats || [],
                max_size: dokumen.max_size || 5,
                update_url: dokumen.update_url || '#'
            };

            this.openEditDocumentModal = true;
        },

        confirmDelete(event, title = 'Hapus Dokumen?') {
            event.preventDefault();

            Swal.fire({
                title: title,
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    }"
>
    <main class="ml-0 md:ml-64 min-h-screen flex flex-col pt-6">
        <div class="flex-1 px-6 pb-10 pt-6 w-full space-y-7">
            <div class="w-full px-8 py-8 space-y-7">

                @if (session('success'))
                    <div class="rounded-[20px] bg-green-50 border border-green-200 px-5 py-4 text-green-700 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-[20px] bg-red-50 border border-red-200 px-5 py-4 text-red-700">
                        <p class="font-semibold">Data belum bisa disimpan.</p>

                        <ul class="list-disc ml-5 mt-2 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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

                    <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#eaf2ff] flex items-center justify-center text-[#0058BC]">
                            <span class="material-symbols-outlined text-[30px]">
                                folder_open
                            </span>
                        </div>

                        <div>
                            <p class="text-[15px] text-[#64748b] font-medium">
                                Jenis Surat
                            </p>

                            <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
                                {{ $totalJenisSurat }}
                            </h2>
                        </div>
                    </div>

                    <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#f3ebff] flex items-center justify-center text-[#7c3aed]">
                            <span class="material-symbols-outlined text-[30px]">
                                attach_file
                            </span>
                        </div>

                        <div>
                            <p class="text-[15px] text-[#64748b] font-medium">
                                Total Syarat
                            </p>

                            <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
                                {{ $totalSyarat }}
                            </h2>
                        </div>
                    </div>

                    <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#ffecec] flex items-center justify-center text-[#ef4444]">
                            <span class="material-symbols-outlined text-[30px]">
                                picture_as_pdf
                            </span>
                        </div>

                        <div>
                            <p class="text-[15px] text-[#64748b] font-medium">
                                Format PDF
                            </p>

                            <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
                                {{ $totalPdf }}
                            </h2>
                        </div>
                    </div>

                    <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#f1f5f9] flex items-center justify-center text-[#475569]">
                            <span class="material-symbols-outlined text-[30px]">
                                image
                            </span>
                        </div>

                        <div>
                            <p class="text-[15px] text-[#64748b] font-medium">
                                Format Gambar
                            </p>

                            <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
                                {{ $totalGambar }}
                            </h2>
                        </div>
                    </div>
                </div>

                {{-- FILTER --}}
                <div class="flex flex-wrap gap-4">
                    <button
                        type="button"
                        class="h-12 px-6 rounded-full bg-[#0058BC] text-white font-semibold text-[15px] shadow-[0_8px_20px_rgba(0,88,188,0.25)]"
                    >
                        Semua
                    </button>

                    <button
                        type="button"
                        class="h-12 px-6 rounded-full bg-white border border-[#e5e7eb] text-[#334155] font-semibold text-[15px]"
                    >
                        Semua Dokumen Wajib
                    </button>

                    <button
                        type="button"
                        @click="openAllCards()"
                        class="h-12 px-6 rounded-full bg-white border border-[#e5e7eb] text-[#334155] font-semibold text-[15px] flex items-center gap-2"
                    >
                        <span class="material-symbols-outlined text-[18px]">
                            unfold_more
                        </span>

                        Buka Semua
                    </button>

                    <button
                        type="button"
                        @click="closeAllCards()"
                        class="h-12 px-6 rounded-full bg-white border border-[#e5e7eb] text-[#334155] font-semibold text-[15px] flex items-center gap-2"
                    >
                        <span class="material-symbols-outlined text-[18px]">
                            unfold_less
                        </span>

                        Tutup Semua
                    </button>

                    <button
                        type="button"
                        @click="openTambahModal = true"
                        class="h-12 px-6 rounded-full bg-[#0058BC] text-white font-semibold text-[15px] flex items-center gap-2 shadow-[0_8px_20px_rgba(0,88,188,0.25)]"
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
                                <div class="w-12 h-12 rounded-2xl bg-[#eaf2ff] flex items-center justify-center text-[#2563eb]">
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
                                type="button"
                                @click="openTambahModal = true"
                                class="h-11 px-5 rounded-full border border-[#dbe3ef] text-[#334155] font-semibold text-[14px]"
                            >
                                Kelola Master
                            </button>
                        </div>
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
                                @forelse ($dokumenSyarats as $index => $dokumen)
                                    @php
                                        $icon = $iconList[$index % count($iconList)];
                                        $formats = $getFormats($dokumen);
                                    @endphp

                                    <tr class="border-t border-[#edf2f7]">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl {{ $icon['class'] }} flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-[20px]">
                                                        {{ $icon['icon'] }}
                                                    </span>
                                                </div>

                                                <span class="font-semibold">
                                                    {{ $dokumen->nama_dokumen }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-[#64748b]">
                                            {{ $dokumen->keterangan ?: '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex gap-2 flex-wrap">
                                                @forelse ($formats as $format)
                                                    <span class="px-2 py-1 rounded-full border text-xs font-semibold {{ $formatBadgeClass[$format] ?? 'border-slate-200 text-slate-500 bg-slate-50' }}">
                                                        {{ strtoupper($format) }}
                                                    </span>
                                                @empty
                                                    <span class="text-sm text-[#94a3b8]">
                                                        -
                                                    </span>
                                                @endforelse
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $dokumen->max_size }} MB
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">
                                                <button
                                                    type="button"
                                                    @click="openEditDocument({{ Illuminate\Support\Js::from([
                                                        'id' => (string) $dokumen->id,
                                                        'nama_dokumen' => $dokumen->nama_dokumen,
                                                        'keterangan' => $dokumen->keterangan,
                                                        'allowed_formats' => $formats->values(),
                                                        'max_size' => (int) $dokumen->max_size,
                                                        'update_url' => route('admin.dokumen-syarat.update', $dokumen),
                                                    ]) }})"
                                                    class="text-blue-500 hover:text-blue-700"
                                                >
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                </button>

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.dokumen-syarat.destroy', $dokumen) }}"
                                                    @submit="confirmDelete($event, 'Hapus Dokumen?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="p-1.5 rounded-lg text-red-500 hover:bg-red-50"
                                                    >
                                                        <span class="material-symbols-outlined text-[18px]">
                                                            delete
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-t border-[#edf2f7]">
                                        <td colspan="5" class="px-6 py-10 text-center text-[#64748b]">
                                            Belum ada dokumen syarat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- CARD SURAT --}}
                <div class="space-y-4">
                    @forelse ($jenisSurats as $surat)
                        @php
                            $suratPayload = [
                                'id' => (string) $surat->id,
                                'nama_surat' => $surat->nama_surat,
                                'deskripsi' => $surat->deskripsi,
                                'dokumen_ids' => $surat->dokumenSyarat
                                    ->pluck('id')
                                    ->map(fn ($id) => (string) $id)
                                    ->values(),
                            ];
                        @endphp

                        <div class="bg-white border border-[#e8edf7] rounded-[24px] overflow-hidden">

                            {{-- HEADER --}}
                            <div class="px-6 py-5 flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-[#eaf2ff] flex items-center justify-center text-[#2563eb]">
                                    <span class="material-symbols-outlined text-[30px]">
                                        description
                                    </span>
                                </div>

                                <div class="flex-1">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <h2 class="text-[20px] font-semibold text-[#0f172a]">
                                            {{ $surat->nama_surat }}
                                        </h2>

                                        <span class="px-3 py-1 rounded-full bg-[#eaf2ff] text-[#2563eb] text-[12px] font-semibold border border-[#bfdbfe]">
                                            Aktif
                                        </span>
                                    </div>

                                    <p class="mt-1 text-[15px] text-[#64748b]">
                                        {{ $surat->deskripsi ?: 'Tidak ada deskripsi.' }}
                                    </p>
                                </div>

                                <div class="hidden md:flex items-center gap-5 text-[15px] text-[#64748b]">
                                    <span class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                        {{ $surat->dokumenSyarat->count() }} syarat
                                    </span>

                                    <span class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                        wajib upload
                                    </span>
                                </div>

                                <div class="flex items-center gap-3 ml-4">
                                    <button
                                        type="button"
                                        class="text-[#64748b]"
                                        @click="toggleCard('{{ $surat->id }}')"
                                    >
                                        <span
                                            class="material-symbols-outlined transition duration-300"
                                            :class="isCardOpen('{{ $surat->id }}') ? 'rotate-180' : ''"
                                        >
                                            expand_more
                                        </span>
                                    </button>
                                </div>
                            </div>

                            {{-- REQUIREMENT CONTENT --}}
                            <div
                                x-show="isCardOpen('{{ $surat->id }}')"
                                x-transition
                                class="px-6 pb-5 pt-4 border-t border-[#edf2f7] space-y-3"
                            >
                                @forelse ($surat->dokumenSyarat as $dokumen)
                                    @php
                                        $formats = $getFormats($dokumen);
                                    @endphp

                                    <div class="group flex items-start gap-3 p-4 rounded-[20px] bg-[#f8fafc] border border-[#edf2f7] hover:bg-white transition-all">

                                        {{-- content --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h3 class="text-[17px] font-semibold text-[#0f172a]">
                                                    {{ $dokumen->nama_dokumen }}
                                                </h3>
                                            </div>

                                            <p class="mt-2 text-[14px] text-[#64748b]">
                                                {{ $dokumen->keterangan ?: '-' }}
                                            </p>

                                            {{-- FORMAT --}}
                                            <div class="flex items-center gap-2 flex-wrap mt-3">
                                                @foreach ($formats as $format)
                                                    <span class="px-2 py-[3px] rounded-full border text-[10px] font-semibold {{ $formatBadgeClass[$format] ?? 'border-slate-200 text-slate-500 bg-slate-50' }}">
                                                        {{ strtoupper($format) }}
                                                    </span>
                                                @endforeach

                                                <span class="flex items-center gap-1 text-[11px] text-[#94a3b8]">
                                                    <span class="material-symbols-outlined text-[13px]">
                                                        storage
                                                    </span>

                                                    Maks. {{ $dokumen->max_size }} MB
                                                </span>
                                            </div>
                                        </div>

                                        {{-- action --}}
                                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                            <form
                                                method="POST"
                                                action="{{ route('admin.dokumen-syarat.putuskan') }}"
                                                @submit="confirmDelete($event, 'Lepas Syarat dari Surat?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <input type="hidden" name="jenis_surat_id" value="{{ $surat->id }}">
                                                <input type="hidden" name="dokumen_syarat_id" value="{{ $dokumen->id }}">

                                                <button
                                                    type="submit"
                                                    class="p-1.5 rounded-lg text-red-500 hover:bg-red-50"
                                                    title="Lepas dari jenis surat"
                                                >
                                                    <span class="material-symbols-outlined text-[18px]">
                                                        delete
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-5 rounded-[20px] bg-[#f8fafc] border border-[#edf2f7] text-[#64748b]">
                                        Belum ada dokumen syarat untuk jenis surat ini.
                                    </div>
                                @endforelse

                                {{-- ADD DOC BUTTON --}}
                                <button
                                    type="button"
                                    @click="openAssignModal({{ Illuminate\Support\Js::from($suratPayload) }})"
                                    class="w-full py-5 border-2 border-dashed border-[#c7d7f2] rounded-[20px] text-[#64748b] hover:border-[#0058BC] hover:text-[#0058BC] transition"
                                >
                                    <span class="material-symbols-outlined text-[20px]">
                                        add_circle
                                    </span>

                                    Tambah Syarat ke Surat Ini
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-[#e8edf7] rounded-[24px] p-8 text-center text-[#64748b]">
                            Belum ada jenis surat.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    {{-- MODAL TAMBAH SYARAT KE SURAT --}}
    <div
        x-show="openRequirementModal"
        x-transition
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
        style="display:none;"
    >
        <form
            method="POST"
            action="{{ route('admin.dokumen-syarat.hubungkan') }}"
            @click.outside="openRequirementModal=false"
            class="w-full max-w-[600px] bg-white rounded-[32px] p-8"
        >
            @csrf

            <input type="hidden" name="jenis_surat_id" :value="selectedJenisSurat.id">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-[30px] font-semibold">
                        Tambah Syarat ke Surat
                    </h2>

                    <p class="text-slate-500" x-text="selectedJenisSurat.nama_surat || '-'"></p>
                </div>

                <button type="button" @click="openRequirementModal=false">
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </button>
            </div>

            <div class="space-y-3 max-h-[55vh] overflow-y-auto pr-1">
                @forelse ($dokumenSyarats as $index => $dokumen)
                    @php
                        $icon = $iconList[$index % count($iconList)];
                    @endphp

                    <label class="flex items-center gap-4 p-5 border border-slate-200 rounded-[20px] hover:border-blue-300 hover:bg-blue-50/30 transition cursor-pointer">
                        <input
                            type="checkbox"
                            name="dokumen_ids[]"
                            value="{{ $dokumen->id }}"
                            x-model="selectedDocIds"
                            class="w-5 h-5 rounded"
                        >

                        <div class="w-10 h-10 rounded-xl {{ $icon['class'] }} flex items-center justify-center">
                            <span class="material-symbols-outlined">
                                {{ $icon['icon'] }}
                            </span>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ $dokumen->nama_dokumen }}
                            </p>

                            <p class="text-sm text-slate-500">
                                {{ $dokumen->keterangan ?: 'Dokumen syarat' }}
                            </p>
                        </div>
                    </label>
                @empty
                    <div class="p-5 border border-slate-200 rounded-[20px] text-slate-500">
                        Belum ada master dokumen syarat.
                    </div>
                @endforelse
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button
                    type="button"
                    @click="openRequirementModal=false"
                    class="px-6 py-3 rounded-full bg-slate-100"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-full bg-[#0058BC] text-white"
                >
                    Tambahkan
                </button>
            </div>
        </form>
    </div>

    {{-- MODAL TAMBAH MASTER DOKUMEN --}}
    <div
        x-show="openTambahModal"
        x-transition
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
        style="display:none;"
    >
        <form
            method="POST"
            action="{{ route('admin.dokumen-syarat.store') }}"
            @click.outside="openTambahModal = false"
            class="w-full max-w-[650px] rounded-[32px] bg-white p-8"
        >
            @csrf

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-[32px] font-semibold">
                        Tambah Dokumen Syarat
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Tambahkan dokumen ke master dokumen syarat.
                    </p>
                </div>

                <button type="button" @click="openTambahModal=false">
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
                        name="nama_dokumen"
                        value="{{ old('nama_dokumen') }}"
                        class="w-full mt-2 h-14 rounded-2xl border px-5"
                        placeholder="Contoh: Kartu Keluarga (KK)"
                        required
                    >
                </div>

                <div>
                    <label class="font-semibold">
                        Deskripsi
                    </label>

                    <textarea
                        name="keterangan"
                        rows="3"
                        class="w-full mt-2 rounded-2xl border p-5"
                    >{{ old('keterangan') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold">
                            Ukuran Maks.
                        </label>

                        <select name="max_size" class="w-full mt-2 h-14 rounded-2xl border px-5" required>
                            @foreach ($maxSizeOptions as $size)
                                <option value="{{ $size }}" @selected((int) old('max_size', 5) === $size)>
                                    {{ $size }} MB
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">
                            Format
                        </label>

                        <div class="grid grid-cols-2 gap-2 mt-2">
                            @foreach ($formatOptions as $value => $label)
                                <label class="h-14 rounded-2xl border px-4 flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="allowed_formats[]"
                                        value="{{ $value }}"
                                        @checked(in_array($value, old('allowed_formats', ['pdf'])))
                                        class="rounded"
                                    >

                                    <span class="font-semibold text-sm">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button
                    type="button"
                    @click="openTambahModal=false"
                    class="px-6 py-3 rounded-full bg-slate-100"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-full bg-[#0058BC] text-white"
                >
                    Simpan Dokumen
                </button>
            </div>
        </form>
    </div>

    {{-- MODAL EDIT MASTER DOKUMEN --}}
    <div
        x-show="openEditDocumentModal"
        x-transition
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
        style="display:none;"
    >
        <form
            method="POST"
            :action="selectedDocument.update_url"
            @click.outside="openEditDocumentModal = false"
            class="w-full max-w-[600px] rounded-[28px] bg-white p-8"
        >
            @csrf
            @method('PUT')

            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="text-[28px] font-semibold">
                        Edit Dokumen Syarat
                    </h2>

                    <p class="text-slate-500 mt-1">
                        Perbarui data master dokumen.
                    </p>
                </div>

                <button
                    type="button"
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
                        x-model="selectedDocument.nama_dokumen"
                        name="nama_dokumen"
                        type="text"
                        class="w-full h-14 border border-slate-300 rounded-2xl px-5"
                        required
                    >
                </div>

                <div>
                    <label class="block mb-2 font-semibold">
                        Deskripsi
                    </label>

                    <textarea
                        x-model="selectedDocument.keterangan"
                        name="keterangan"
                        rows="4"
                        class="w-full border border-slate-300 rounded-2xl p-5"
                    ></textarea>
                </div>

                <div>
                    <label class="block mb-2 font-semibold">
                        Ukuran Maksimum
                    </label>

                    <select
                        x-model="selectedDocument.max_size"
                        name="max_size"
                        class="w-full h-14 border border-slate-300 rounded-2xl px-5"
                        required
                    >
                        @foreach ($maxSizeOptions as $size)
                            <option value="{{ $size }}">
                                {{ $size }} MB
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold">
                        Format
                    </label>

                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($formatOptions as $value => $label)
                            <label class="h-14 rounded-2xl border px-4 flex items-center gap-2 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="allowed_formats[]"
                                    value="{{ $value }}"
                                    x-model="selectedDocument.allowed_formats"
                                    class="rounded"
                                >

                                <span class="font-semibold text-sm">
                                    {{ $label }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button
                    type="button"
                    @click="openEditDocumentModal = false"
                    class="px-6 py-3 rounded-full bg-slate-100"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-full bg-[#0058BC] text-white"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
