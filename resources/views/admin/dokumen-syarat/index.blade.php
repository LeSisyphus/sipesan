@extends('layouts.admin')

@section('title', 'Dokumen Syarat')

@section('content')

{{-- SweetAlert Flash Message & Validation Errors --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2563EB',
            confirmButtonText: 'Oke'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#DC2626',
            confirmButtonText: 'Oke'
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#DC2626',
            confirmButtonText: 'Oke'
        });
    });
</script>
@endif

<div x-data="{ 
    openTambahModal: false, 
    openedCards: {
        @foreach($jenisSurats as $js)
            '{{ $js->id }}': {{ $loop->first ? 'true' : 'false' }},
        @endforeach
    },
    openRequirementModal: false, 
    openEditDocumentModal: false,
    showOnlyWajib: false,
    selectedJenisSurat: { id: null, nama_surat: '' },
    requirementIds: [],
    selectedDocument: {
        id: null,
        nama: '',
        deskripsi: '',
        allowed_formats: [],
        max_size: 5,
        is_wajib: 1,
        berlaku_untuk: 'Semua Mahasiswa',
        urutan: 1
    },
    openAttachModal(jenisSurat, attachedIds) {
        this.selectedJenisSurat = {
            id: jenisSurat.id,
            nama_surat: jenisSurat.nama_surat
        };
        this.requirementIds = [...attachedIds];
        this.openRequirementModal = true;
    },
    toggleRequirement(id) {
        let index = this.requirementIds.indexOf(id);
        if (index > -1) {
            this.requirementIds.splice(index, 1);
        } else {
            this.requirementIds.push(id);
        }
    },
    editDocument(doc) {
        this.selectedDocument = {
            id: doc.id,
            nama: doc.nama_dokumen,
            deskripsi: doc.keterangan || '',
            allowed_formats: doc.allowed_formats ? doc.allowed_formats.split(',') : [],
            max_size: doc.max_size || 5,
            is_wajib: doc.is_wajib,
            berlaku_untuk: doc.berlaku_untuk || 'Semua Mahasiswa',
            urutan: doc.urutan || 1
        };
        this.openEditDocumentModal = true;
    },
    toggleFormat(format, isEditMode = false) {
        if (isEditMode) {
            let index = this.selectedDocument.allowed_formats.indexOf(format);
            if (index > -1) {
                this.selectedDocument.allowed_formats.splice(index, 1);
            } else {
                this.selectedDocument.allowed_formats.push(format);
            }
        }
    },
    deleteMasterDocument(id) {
        Swal.fire({
            title: 'Hapus Master Dokumen?',
            text: 'Menghapus dokumen master ini akan melepas hubungannya dari semua surat. Tindakan ini tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('deleteMasterForm');
                form.action = '/admin/dokumen-syarat/' + id;
                form.submit();
            }
        });
    },
    unlinkRequirement(jenisSuratId, syaratId) {
        Swal.fire({
            title: 'Hapus Hubungan Syarat?',
            text: 'Apakah Anda yakin ingin melepas dokumen syarat ini dari jenis surat?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Lepas',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('putuskan_jenis_surat_id').value = jenisSuratId;
                document.getElementById('putuskan_dokumen_syarat_id').value = syaratId;
                document.getElementById('putuskanForm').submit();
            }
        });
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
                            priority_high
                        </span>
                    </div>
                    <div>
                        <p class="text-[15px] text-[#64748b] font-medium">
                            Wajib
                        </p>
                        <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
                            {{ $totalWajib }}
                        </h2>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#f1f5f9] flex items-center justify-center text-[#475569]">
                        <span class="material-symbols-outlined text-[30px]">
                            info
                        </span>
                    </div>
                    <div>
                        <p class="text-[15px] text-[#64748b] font-medium">
                            Opsional
                        </p>
                        <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1">
                            {{ $totalOpsional }}
                        </h2>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="flex flex-wrap gap-4">
                <button 
                    @click="showOnlyWajib = false"
                    class="h-12 px-6 rounded-full font-semibold text-[15px] transition"
                    :class="!showOnlyWajib ? 'bg-[#0058BC] text-white shadow-[0_8px_20px_rgba(0,88,188,0.25)]' : 'bg-white border border-[#e5e7eb] text-[#334155]'"
                >
                    Semua
                </button>

                <button 
                    @click="showOnlyWajib = true"
                    class="h-12 px-6 rounded-full font-semibold text-[15px] transition"
                    :class="showOnlyWajib ? 'bg-[#0058BC] text-white shadow-[0_8px_20px_rgba(0,88,188,0.25)]' : 'bg-white border border-[#e5e7eb] text-[#334155]'"
                >
                    Tampilkan Hanya Wajib
                </button>

                <button 
                    @click="Object.keys(openedCards).forEach(k => openedCards[k] = true)"
                    class="h-12 px-6 rounded-full bg-white border border-[#e5e7eb] text-[#334155] font-semibold text-[15px] flex items-center gap-2 hover:bg-slate-50 transition"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        unfold_more
                    </span>
                    Buka Semua
                </button>

                <button 
                    @click="Object.keys(openedCards).forEach(k => openedCards[k] = false)"
                    class="h-12 px-6 rounded-full bg-white border border-[#e5e7eb] text-[#334155] font-semibold text-[15px] flex items-center gap-2 hover:bg-slate-50 transition"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        unfold_less
                    </span>
                    Tutup Semua
                </button>

                <button
                    @click="openTambahModal = true"
                    class="h-12 px-6 rounded-full bg-[#0058BC] text-white font-semibold text-[15px] flex items-center gap-2 shadow-[0_8px_20px_rgba(0,88,188,0.25)] hover:bg-blue-700 transition"
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
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-[#f8fafc]">
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">
                                    Nama Dokumen
                                </th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">
                                    Deskripsi
                                </th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">
                                    Format
                                </th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">
                                    Maks
                                </th>
                                <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokumenSyarats as $syarat)
                                @php
                                    $nameLower = strtolower($syarat->nama_dokumen);
                                    $icon = 'description';
                                    $colorClass = 'bg-blue-50 text-blue-600';
                                    
                                    if (str_contains($nameLower, 'keluarga') || str_contains($nameLower, 'kk')) {
                                        $icon = 'groups';
                                        $colorClass = 'bg-blue-50 text-blue-600';
                                    } elseif (str_contains($nameLower, 'ktp') || str_contains($nameLower, 'identitas') || str_contains($nameLower, 'penduduk')) {
                                        $icon = 'badge';
                                        $colorClass = 'bg-violet-50 text-violet-600';
                                    } elseif (str_contains($nameLower, 'ktm') || str_contains($nameLower, 'mahasiswa')) {
                                        $icon = 'school';
                                        $colorClass = 'bg-green-50 text-green-600';
                                    } elseif (str_contains($nameLower, 'foto')) {
                                        $icon = 'photo_camera';
                                        $colorClass = 'bg-amber-50 text-amber-600';
                                    } elseif (str_contains($nameLower, 'transkrip') || str_contains($nameLower, 'nilai')) {
                                        $icon = 'description';
                                        $colorClass = 'bg-red-50 text-red-600';
                                    } elseif (str_contains($nameLower, 'ukt') || str_contains($nameLower, 'spp') || str_contains($nameLower, 'bayar') || str_contains($nameLower, 'keuangan')) {
                                        $icon = 'receipt_long';
                                        $colorClass = 'bg-emerald-50 text-emerald-600';
                                    } elseif (str_contains($nameLower, 'ijazah')) {
                                        $icon = 'history_edu';
                                        $colorClass = 'bg-teal-50 text-teal-600';
                                    }
                                @endphp
                                <tr class="border-t border-[#edf2f7] hover:bg-slate-50/40 transition-colors" x-show="!showOnlyWajib || {{ $syarat->is_wajib ? 'true' : 'false' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl {{ $colorClass }} flex items-center justify-center">
                                                <span class="material-symbols-outlined text-[20px]">
                                                    {{ $icon }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-slate-850">
                                                {{ $syarat->nama_dokumen }}
                                                @if($syarat->is_wajib)
                                                    <span class="text-red-500 font-bold" title="Wajib">*</span>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-[#64748b] max-w-[250px] truncate" title="{{ $syarat->keterangan }}">
                                        {{ $syarat->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-1.5 flex-wrap">
                                            @foreach(explode(',', $syarat->allowed_formats) as $fmt)
                                                @php
                                                    $fmtClass = 'bg-slate-50 text-slate-500 border border-slate-200';
                                                    $fmtLower = strtolower(trim($fmt));
                                                    if ($fmtLower === 'pdf') $fmtClass = 'bg-red-50 text-red-500 border border-red-200';
                                                    elseif (in_array($fmtLower, ['jpg', 'jpeg'])) $fmtClass = 'bg-blue-50 text-blue-500 border border-blue-200';
                                                    elseif ($fmtLower === 'png') $fmtClass = 'bg-indigo-50 text-indigo-500 border border-indigo-200';
                                                    elseif ($fmtLower === 'docx') $fmtClass = 'bg-sky-50 text-sky-500 border border-sky-200';
                                                @endphp
                                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold uppercase {{ $fmtClass }}">
                                                    {{ trim($fmt) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-700">
                                        {{ $syarat->max_size }} MB
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <button
                                                @click="editDocument({
                                                    id: {{ $syarat->id }},
                                                    nama_dokumen: '{{ addslashes($syarat->nama_dokumen) }}',
                                                    keterangan: '{{ addslashes($syarat->keterangan ?? '') }}',
                                                    allowed_formats: '{{ $syarat->allowed_formats }}',
                                                    max_size: {{ $syarat->max_size }},
                                                    is_wajib: {{ $syarat->is_wajib ? 1 : 0 }},
                                                    berlaku_untuk: '{{ $syarat->berlaku_untuk }}',
                                                    urutan: {{ $syarat->urutan }}
                                                })"
                                                class="text-blue-500 hover:text-blue-700 p-1.5 rounded-lg hover:bg-blue-50 transition"
                                                title="Edit Master Dokumen"
                                            >
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                            </button>
                                            <button
                                                @click="deleteMasterDocument({{ $syarat->id }})"
                                                class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition"
                                                title="Hapus Master Dokumen"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">
                                                    delete
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- CARD SURAT --}}
            <div class="space-y-4">
                @foreach($jenisSurats as $jenisSurat)
                    <div class="bg-white border border-[#e8edf7] rounded-[24px] overflow-hidden">
                        {{-- HEADER --}}
                        <div class="px-6 py-5 flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-[#eaf2ff] flex items-center justify-center text-[#2563eb] shrink-0">
                                <span class="material-symbols-outlined text-[30px]">
                                    description
                                </span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <h2 class="text-[20px] font-semibold text-[#0f172a] truncate">
                                        {{ $jenisSurat->nama_surat }}
                                    </h2>
                                    <span class="px-3 py-1 rounded-full bg-[#eaf2ff] text-[#2563eb] text-[12px] font-semibold border border-[#bfdbfe]">
                                        Aktif
                                    </span>
                                </div>
                                <p class="mt-1 text-[15px] text-[#64748b] truncate" title="{{ $jenisSurat->deskripsi }}">
                                    {{ $jenisSurat->deskripsi }}
                                </p>
                            </div>

                            <div class="hidden md:flex items-center gap-5 text-[15px] text-[#64748b] shrink-0">
                                <span class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                    {{ $jenisSurat->dokumenSyarat->where('is_wajib', true)->count() }} wajib
                                </span>
                                <span class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-450"></span>
                                    {{ $jenisSurat->dokumenSyarat->where('is_wajib', false)->count() }} opsional
                                </span>
                            </div>

                            <div class="flex items-center gap-3 ml-4 shrink-0">
                                <button 
                                    class="text-[#64748b] p-1 rounded-full hover:bg-slate-100 transition"
                                    @click="openedCards[{{ $jenisSurat->id }}] = !openedCards[{{ $jenisSurat->id }}]"
                                >
                                    <span 
                                        class="material-symbols-outlined transition duration-300 block"
                                        :class="openedCards[{{ $jenisSurat->id }}] ? 'rotate-180' : ''"
                                    >
                                        expand_more
                                    </span>
                                </button>
                            </div>
                        </div>

                        {{-- REQUIREMENT CONTENT --}}
                        <div
                            x-show="openedCards[{{ $jenisSurat->id }}]"
                            x-transition
                            class="px-6 pb-5 pt-4 border-t border-[#edf2f7] space-y-3"
                        >
                            @forelse($jenisSurat->dokumenSyarat->sortBy('urutan') as $syarat)
                                <div 
                                    class="group flex items-start gap-3 p-4 rounded-[20px] bg-[#f8fafc] border border-[#edf2f7] hover:bg-white hover:shadow-md hover:border-slate-300/60 transition-all duration-200"
                                    x-show="!showOnlyWajib || {{ $syarat->is_wajib ? 'true' : 'false' }}"
                                >
                                    {{-- drag --}}
                                    <div class="mt-1 text-[#94a3b8] opacity-0 group-hover:opacity-100 transition cursor-grab">
                                        <span class="material-symbols-outlined text-[18px]">
                                            drag_indicator
                                        </span>
                                    </div>

                                    {{-- content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            @if($syarat->is_wajib)
                                                <span class="px-2 py-[3px] rounded-full bg-red-100 text-red-500 border border-red-200 text-[10px] font-semibold">
                                                    ● Wajib
                                                </span>
                                            @else
                                                <span class="px-2 py-[3px] rounded-full bg-slate-100 text-slate-500 border border-slate-200 text-[10px] font-semibold">
                                                    ● Opsional
                                                </span>
                                            @endif

                                            <h3 class="text-[17px] font-semibold text-[#0f172a]">
                                                {{ $syarat->nama_dokumen }}
                                            </h3>
                                            
                                            <span class="text-xs text-slate-450 font-normal">
                                                (Urutan: {{ $syarat->urutan }}, Berlaku: {{ $syarat->berlaku_untuk }})
                                            </span>
                                        </div>

                                        <p class="mt-2 text-[14px] text-[#64748b]">
                                            {{ $syarat->keterangan ?? '-' }}
                                        </p>

                                        {{-- FORMAT --}}
                                        <div class="flex items-center gap-2 flex-wrap mt-3">
                                            @foreach(explode(',', $syarat->allowed_formats) as $fmt)
                                                @php
                                                    $fmtClass = 'bg-slate-50 text-slate-500 border border-slate-200';
                                                    $fmtLower = strtolower(trim($fmt));
                                                    if ($fmtLower === 'pdf') $fmtClass = 'bg-red-50 text-red-500 border border-red-200';
                                                    elseif (in_array($fmtLower, ['jpg', 'jpeg'])) $fmtClass = 'bg-blue-50 text-blue-500 border border-blue-200';
                                                    elseif ($fmtLower === 'png') $fmtClass = 'bg-indigo-50 text-indigo-500 border border-indigo-200';
                                                    elseif ($fmtLower === 'docx') $fmtClass = 'bg-sky-50 text-sky-500 border border-sky-200';
                                                @endphp
                                                <span class="px-2 py-[3px] rounded-full border text-[10px] font-semibold uppercase {{ $fmtClass }}">
                                                    {{ trim($fmt) }}
                                                </span>
                                            @endforeach

                                            <span class="flex items-center gap-1 text-[11px] text-[#94a3b8]">
                                                <span class="material-symbols-outlined text-[13px]">
                                                    storage
                                                </span>
                                                Maks. {{ $syarat->max_size }} MB
                                            </span>
                                        </div>
                                    </div>

                                    {{-- action --}}
                                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition shrink-0">
                                        <button
                                            @click="editDocument({
                                                id: {{ $syarat->id }},
                                                nama_dokumen: '{{ addslashes($syarat->nama_dokumen) }}',
                                                keterangan: '{{ addslashes($syarat->keterangan ?? '') }}',
                                                allowed_formats: '{{ $syarat->allowed_formats }}',
                                                max_size: {{ $syarat->max_size }},
                                                is_wajib: {{ $syarat->is_wajib ? 1 : 0 }},
                                                berlaku_untuk: '{{ $syarat->berlaku_untuk }}',
                                                urutan: {{ $syarat->urutan }}
                                            })"
                                            class="p-1.5 rounded-lg text-blue-500 hover:bg-blue-50 transition"
                                            title="Edit Dokumen Syarat"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">
                                                edit
                                            </span>
                                        </button>

                                        <button
                                            @click="unlinkRequirement({{ $jenisSurat->id }}, {{ $syarat->id }})"
                                            class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition"
                                            title="Lepas Hubungan Syarat dari Surat ini"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">
                                                link_off
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="py-6 text-center text-slate-500 text-sm">
                                    Belum ada dokumen syarat yang dihubungkan ke jenis surat ini.
                                </div>
                            @endforelse

                            {{-- ADD DOC BUTTON --}}
                            <button
                                @click="openAttachModal(
                                    { id: {{ $jenisSurat->id }}, nama_surat: '{{ addslashes($jenisSurat->nama_surat) }}' },
                                    {{ json_encode($jenisSurat->dokumenSyarat->pluck('id')->toArray()) }}
                                )"
                                class="w-full py-5 border-2 border-dashed border-[#c7d7f2] rounded-[20px] text-[#64748b] hover:border-[#0058BC] hover:text-[#0058BC] hover:bg-blue-50/10 transition flex items-center justify-center gap-2 font-semibold"
                            >
                                <span class="material-symbols-outlined text-[20px]">
                                    add_circle
                                </span>
                                Tambah Syarat ke Surat Ini
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</main>

<!-- MODAL HUBUNGKAN SYARAT KE SURAT -->
<div
    x-show="openRequirementModal"
    x-transition
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
    style="display: none;"
>
    <div
        @click.outside="openRequirementModal=false"
        class="w-full max-w-[600px] bg-white rounded-[32px] p-8 shadow-2xl relative"
    >
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-[26px] font-semibold text-slate-800">
                    Hubungkan Syarat Dokumen
                </h2>
                <p class="text-slate-500 mt-1" x-text="selectedJenisSurat.nama_surat"></p>
            </div>
            <button @click="openRequirementModal=false" class="text-slate-400 hover:text-slate-650 transition p-1.5 rounded-full hover:bg-slate-100">
                <span class="material-symbols-outlined block">
                    close
                </span>
            </button>
        </div>

        <form action="{{ route('admin.dokumen-syarat.hubungkan') }}" method="POST">
            @csrf
            <input type="hidden" name="jenis_surat_id" :value="selectedJenisSurat.id">
            
            <div class="space-y-3 max-h-[350px] overflow-y-auto pr-2">
                @forelse($dokumenSyarats as $syarat)
                    <label
                        class="flex items-center gap-4 p-4 border rounded-[20px] transition cursor-pointer select-none"
                        :class="requirementIds.includes({{ $syarat->id }}) ? 'border-blue-400 bg-blue-50/30 text-blue-700' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50/50'"
                    >
                        <input
                            type="checkbox"
                            name="dokumen_ids[]"
                            value="{{ $syarat->id }}"
                            class="w-5 h-5 rounded text-[#0058BC] focus:ring-[#0058BC] border-slate-300 transition"
                            :checked="requirementIds.includes({{ $syarat->id }})"
                            @change="toggleRequirement({{ $syarat->id }})"
                        >
                        @php
                            $nameLower = strtolower($syarat->nama_dokumen);
                            $icon = 'description';
                            $colorClass = 'bg-blue-50 text-blue-600';
                            if (str_contains($nameLower, 'keluarga') || str_contains($nameLower, 'kk')) {
                                $icon = 'groups';
                                $colorClass = 'bg-blue-50 text-blue-600';
                            } elseif (str_contains($nameLower, 'ktp') || str_contains($nameLower, 'identitas') || str_contains($nameLower, 'penduduk')) {
                                $icon = 'badge';
                                $colorClass = 'bg-violet-50 text-violet-600';
                            } elseif (str_contains($nameLower, 'ktm') || str_contains($nameLower, 'mahasiswa')) {
                                $icon = 'school';
                                $colorClass = 'bg-green-50 text-green-600';
                            } elseif (str_contains($nameLower, 'foto')) {
                                $icon = 'photo_camera';
                                $colorClass = 'bg-amber-50 text-amber-600';
                            }
                        @endphp
                        <div class="w-10 h-10 rounded-xl {{ $colorClass }} flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-lg">
                                {{ $icon }}
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-slate-800 truncate">
                                {{ $syarat->nama_dokumen }}
                            </p>
                            <p class="text-xs text-slate-500 truncate">
                                {{ $syarat->keterangan ?? 'Tidak ada deskripsi.' }}
                            </p>
                        </div>
                    </label>
                @empty
                    <div class="py-6 text-center text-slate-500 text-sm">
                        Belum ada dokumen syarat master. Silakan buat terlebih dahulu.
                    </div>
                @endforelse
            </div>

            <div class="flex justify-end gap-3 mt-8 border-t pt-4">
                <button
                    type="button"
                    @click="openRequirementModal=false"
                    class="px-6 py-3 rounded-full bg-slate-100 text-slate-705 font-semibold hover:bg-slate-200 transition text-sm"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-6 py-3 rounded-full bg-[#0058BC] text-white font-semibold hover:bg-blue-750 shadow-lg shadow-blue-100 transition text-sm"
                >
                    Simpan Hubungan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL TAMBAH MASTER DOKUMEN -->
<div
    x-show="openTambahModal"
    x-transition
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
    style="display: none;"
>
    <div
        @click.outside="openTambahModal = false"
        class="w-full max-w-[650px] rounded-[32px] bg-white p-8 shadow-2xl relative"
    >
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-[28px] font-semibold text-slate-800">
                    Tambah Dokumen Syarat
                </h2>
                <p class="text-slate-500 mt-1">
                    Tambahkan dokumen ke master dokumen syarat.
                </p>
            </div>
            <button @click="openTambahModal=false" class="text-slate-400 hover:text-slate-650 transition p-1.5 rounded-full hover:bg-slate-100">
                <span class="material-symbols-outlined block">
                    close
                </span>
            </button>
        </div>

        <form action="{{ route('admin.dokumen-syarat.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                        Nama Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_dokumen"
                        required
                        class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition text-slate-705"
                        placeholder="Contoh: Kartu Tanda Mahasiswa (KTM)"
                    >
                </div>

                <div>
                    <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                        Deskripsi / Keterangan
                    </label>
                    <textarea
                        name="keterangan"
                        rows="3"
                        class="w-full border border-slate-300 rounded-2xl p-5 focus:outline-none focus:border-blue-500 transition resize-none text-slate-700"
                        placeholder="Contoh: Scan KTM asli berwarna dan harus terbaca jelas."
                    ></textarea>
                </div>

                <div>
                    <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                        Format File yang Diterima <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach(['pdf', 'jpg', 'png', 'docx'] as $fmt)
                            <label class="flex items-center gap-2 px-4 py-2.5 rounded-full border border-slate-200 bg-white hover:border-slate-350 hover:bg-slate-50 transition cursor-pointer select-none">
                                <input type="checkbox" name="allowed_formats[]" value="{{ $fmt }}" checked class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                                <span class="text-xs font-semibold uppercase text-slate-700">{{ $fmt }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                            Ukuran Maksimum <span class="text-red-500">*</span>
                        </label>
                        <select name="max_size" required class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition bg-white text-slate-700">
                            <option value="2">2 MB</option>
                            <option value="5" selected>5 MB</option>
                            <option value="10">10 MB</option>
                            <option value="20">20 MB</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                            Kewajiban <span class="text-red-500">*</span>
                        </label>
                        <select name="is_wajib" required class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition bg-white text-slate-700">
                            <option value="1" selected>Wajib</option>
                            <option value="0">Opsional</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                            Berlaku Untuk <span class="text-red-500">*</span>
                        </label>
                        <select name="berlaku_untuk" required class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition bg-white text-slate-700">
                            <option value="Semua Mahasiswa" selected>Semua Mahasiswa</option>
                            <option value="Ortu PNS">Ortu PNS</option>
                            <option value="Ortu Swasta">Ortu Swasta</option>
                            <option value="Ortu TNI/POLRI">Ortu TNI/POLRI</option>
                            <option value="Ortu Wirausahawan">Ortu Wirausahawan</option>
                            <option value="Ortu Pensiunan">Ortu Pensiunan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                            Urutan Tampil <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="urutan"
                            value="1"
                            required
                            min="1"
                            class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition text-slate-700"
                        >
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 border-t pt-4">
                <button
                    type="button"
                    @click="openTambahModal=false"
                    class="px-6 py-3 rounded-full bg-slate-100 text-slate-705 font-semibold hover:bg-slate-200 transition text-sm"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-6 py-3 rounded-full bg-[#0058BC] text-white font-semibold hover:bg-blue-750 shadow-lg shadow-blue-100 transition text-sm"
                >
                    Simpan Dokumen
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT MASTER DOKUMEN -->
<div
    x-show="openEditDocumentModal"
    x-transition
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
    style="display: none;"
>
    <div
        @click.outside="openEditDocumentModal = false"
        class="w-full max-w-[650px] rounded-[32px] bg-white p-8 shadow-2xl relative"
    >
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-[28px] font-semibold text-slate-800">
                    Edit Dokumen Syarat
                </h2>
                <p class="text-slate-500 mt-1">
                    Perbarui data master dokumen syarat.
                </p>
            </div>
            <button @click="openEditDocumentModal = false" class="text-slate-400 hover:text-slate-650 transition p-1.5 rounded-full hover:bg-slate-100">
                <span class="material-symbols-outlined block">
                    close
                </span>
            </button>
        </div>

        <form :action="'/admin/dokumen-syarat/' + selectedDocument.id" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                        Nama Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_dokumen"
                        x-model="selectedDocument.nama"
                        required
                        class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition text-slate-705"
                    >
                </div>

                <div>
                    <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                        Deskripsi / Keterangan
                    </label>
                    <textarea
                        name="keterangan"
                        x-model="selectedDocument.deskripsi"
                        rows="3"
                        class="w-full border border-slate-300 rounded-2xl p-5 focus:outline-none focus:border-blue-500 transition resize-none text-slate-700"
                    ></textarea>
                </div>

                <div>
                    <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                        Format File yang Diterima <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach(['pdf', 'jpg', 'png', 'docx'] as $fmt)
                            <label 
                                class="flex items-center gap-2 px-4 py-2.5 rounded-full border transition cursor-pointer select-none"
                                :class="selectedDocument.allowed_formats.includes('{{ $fmt }}') ? 'border-blue-400 bg-blue-50/40 text-blue-700 font-semibold' : 'border-slate-200 bg-white hover:bg-slate-50 text-slate-700'"
                            >
                                <input 
                                    type="checkbox" 
                                    name="allowed_formats[]" 
                                    value="{{ $fmt }}" 
                                    class="hidden"
                                    :checked="selectedDocument.allowed_formats.includes('{{ $fmt }}')"
                                    @change="toggleFormat('{{ $fmt }}', true)"
                                >
                                <span class="text-xs uppercase">{{ $fmt }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                            Ukuran Maksimum <span class="text-red-500">*</span>
                        </label>
                        <select name="max_size" x-model="selectedDocument.max_size" required class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition bg-white text-slate-750">
                            <option value="2">2 MB</option>
                            <option value="5">5 MB</option>
                            <option value="10">10 MB</option>
                            <option value="20">20 MB</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                            Kewajiban <span class="text-red-500">*</span>
                        </label>
                        <select name="is_wajib" x-model="selectedDocument.is_wajib" required class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition bg-white text-slate-750">
                            <option value="1">Wajib</option>
                            <option value="0">Opsional</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                            Berlaku Untuk <span class="text-red-500">*</span>
                        </label>
                        <select name="berlaku_untuk" x-model="selectedDocument.berlaku_untuk" required class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition bg-white text-slate-750">
                            <option value="Semua Mahasiswa">Semua Mahasiswa</option>
                            <option value="Ortu PNS">Ortu PNS</option>
                            <option value="Ortu Swasta">Ortu Swasta</option>
                            <option value="Ortu TNI/POLRI">Ortu TNI/POLRI</option>
                            <option value="Ortu Wirausahawan">Ortu Wirausahawan</option>
                            <option value="Ortu Pensiunan">Ortu Pensiunan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1.5 font-semibold text-slate-700 text-sm">
                            Urutan Tampil <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="urutan"
                            x-model="selectedDocument.urutan"
                            required
                            min="1"
                            class="w-full h-13 border border-slate-300 rounded-2xl px-5 focus:outline-none focus:border-blue-500 transition text-slate-705"
                        >
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 border-t pt-4">
                <button
                    type="button"
                    @click="openEditDocumentModal = false"
                    class="px-6 py-3 rounded-full bg-slate-100 text-slate-705 font-semibold hover:bg-slate-200 transition text-sm"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-6 py-3 rounded-full bg-[#0058BC] text-white font-semibold hover:bg-blue-750 shadow-lg shadow-blue-100 transition text-sm"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- FORM UTILITY UNTUK ACTION SUBMIT --}}
{{-- Form delete master --}}
<form id="deleteMasterForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- Form detach relasi --}}
<form id="putuskanForm" action="{{ route('admin.dokumen-syarat.putuskan') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="jenis_surat_id" id="putuskan_jenis_surat_id">
    <input type="hidden" name="dokumen_syarat_id" id="putuskan_dokumen_syarat_id">
</form>

</div>

@endsection
