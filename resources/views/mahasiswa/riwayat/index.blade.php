@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pengajuan')

@section('content')

<div x-data="riwayatPage()" class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-[32px] font-semibold text-slate-900 leading-tight tracking-tight">
                Riwayat Pengajuan
            </h1>

            <p class="text-slate-500 text-lg mt-2">
                Pantau status semua pengajuan dokumen Anda.
            </p>
        </div>

        <a
            href="{{ route('mahasiswa.pengajuan') }}"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-full
            bg-primary text-white font-semibold shadow-lg shadow-blue-500/30
            hover:bg-blue-700 hover:-translate-y-1 transition-all duration-300"
        >
            <span class="material-symbols-rounded text-[20px]">add</span>
            Pengajuan Baru
        </a>
    </div>

    {{-- SUMMARY (Refactored to be DRY using AlpineJS x-for) --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <template x-for="stat in stats" :key="stat.label">
            <div class="glass-panel rounded-[22px] p-5">
                <p class="text-sm text-slate-500" x-text="stat.label"></p>
                <p class="text-3xl font-semibold mt-1" :class="stat.color" x-text="stat.value"></p>
            </div>
        </template>
    </div>

    {{-- SEARCH + FILTER (Refactored to be DRY using AlpineJS x-for) --}}
    <div class="glass-panel rounded-[28px] p-4 flex flex-col lg:flex-row gap-3">
        <div class="flex-1 flex items-center gap-3 bg-white rounded-2xl border border-slate-200 px-5 py-3">
            <span class="material-symbols-rounded text-slate-400">
                search
            </span>

            <input
                x-model="search"
                type="text"
                placeholder="Cari jenis surat atau nomor pengajuan..."
                class="w-full bg-transparent outline-none text-slate-700"
            >
        </div>

        <div class="flex gap-2 flex-wrap">
            <template x-for="btn in filters" :key="btn.val">
                <button
                    @click="filter = btn.val"
                    :class="filter === btn.val ? 'bg-primary text-white shadow-lg shadow-blue-500/20' : 'bg-white text-slate-600 hover:bg-slate-100'"
                    class="px-5 py-2.5 rounded-full font-semibold transition-all duration-300"
                    x-text="btn.label"
                ></button>
            </template>
        </div>
    </div>

    {{-- CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 items-start">
        <template x-for="item in filteredItems" :key="item.id">
            <div
                @click="openDetail(item)"
                x-transition
                class="glass-panel rounded-[28px] px-7 py-6 h-[190px]
                flex flex-col justify-between hover:-translate-y-1.5 hover:shadow-xl
                transition-all duration-300 cursor-pointer group"
            >
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4 min-w-0">
                        <div
                            class="w-[50px] h-[50px] rounded-[18px] flex items-center justify-center shrink-0"
                            :class="statusIconClass(item.status)"
                        >
                            <span
                                class="material-symbols-rounded text-[26px]"
                                style="font-variation-settings:'FILL' 1"
                                x-text="item.icon"
                            ></span>
                        </div>

                        <div class="pt-1 min-w-0">
                            <h3
                                class="text-[17px] font-semibold text-slate-900 leading-[1.15] max-w-[190px] line-clamp-2"
                                x-text="item.title"
                            ></h3>

                            <p class="text-slate-400 text-[13px] font-semibold mt-1" x-text="item.code"></p>
                        </div>
                    </div>

                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-semibold border shrink-0"
                        :class="statusBadgeClass(item.status)"
                    >
                        <span class="w-1.5 h-1.5 rounded-full" :class="statusDotClass(item.status)"></span>
                        <span x-text="item.status_label"></span>
                    </span>
                </div>

                <div class="h-px bg-slate-100"></div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-slate-400 text-[14px] font-medium">
                        <span class="material-symbols-rounded text-[18px]">
                            calendar_today
                        </span>

                        <span x-text="item.date"></span>
                    </div>

                    <div class="flex items-center gap-1 text-primary text-[14px] font-semibold opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                        Detail
                        <span class="material-symbols-rounded text-[18px]">
                            arrow_forward
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- EMPTY --}}
    <div
        x-show="filteredItems.length === 0"
        class="glass-panel rounded-[28px] py-20 flex flex-col items-center justify-center text-center"
    >
        <span class="material-symbols-rounded text-7xl text-slate-300">
            search_off
        </span>

        <h3 class="text-2xl font-bold text-slate-700 mt-5">
            Tidak ada data ditemukan
        </h3>

        <p class="text-slate-400 mt-2">
            Coba ubah filter atau kata kunci pencarian.
        </p>
    </div>

    {{-- MODAL --}}
    <div
        x-show="modal"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-md p-4"
        style="display: none;"
    >
        <div
            @click.outside="modal = false"
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0 scale-95 translate-y-6"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="w-full max-w-2xl bg-white/95 backdrop-blur-2xl rounded-[32px]
            shadow-[0_30px_80px_rgba(0,0,0,0.18)] border border-white/60 overflow-hidden"
        >
            <div class="px-8 pt-7 pb-5 flex items-start justify-between">
                <div>
                    <h2 class="text-[32px] leading-tight font-semibold text-slate-900" x-text="selected.title"></h2>
                    <p class="text-primary font-semibold text-lg mt-1" x-text="selected.code"></p>
                </div>

                <button @click="modal = false" class="text-slate-400 hover:text-red-500 transition">
                    <span class="material-symbols-rounded text-[34px]">
                        close
                    </span>
                </button>
            </div>

            <div class="px-8 pb-8 max-h-[68vh] overflow-y-auto">
                <div class="rounded-[24px] bg-slate-50 border border-slate-100 px-5 py-5 flex items-center justify-between">
                    <span class="text-slate-500 font-semibold">
                        Status saat ini
                    </span>

                    <span class="px-5 py-2 rounded-full text-sm font-semibold" :class="statusSoftClass(selected.status)">
                        ● <span x-text="selected.status_label"></span>
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                    <div class="rounded-[22px] bg-slate-50 border border-slate-100 p-5">
                        <p class="text-slate-400 font-medium text-sm mb-2">
                            Tanggal Pengajuan
                        </p>

                        <h3 class="text-[20px] font-semibold text-slate-900" x-text="selected.date"></h3>
                        <p class="text-sm text-slate-400 mt-1" x-text="selected.time"></p>
                    </div>

                    <div class="rounded-[22px] bg-slate-50 border border-slate-100 p-5">
                        <p class="text-slate-400 font-medium text-sm mb-2">
                            Jenis Surat
                        </p>

                        <h3 class="text-[20px] font-semibold text-slate-900 leading-tight" x-text="selected.title"></h3>
                    </div>
                </div>

                <div class="rounded-[22px] bg-slate-50 border border-slate-100 p-5 mt-5">
                    <p class="text-slate-400 font-semibold text-sm mb-3">
                        Keperluan
                    </p>

                    <p class="text-slate-800 text-[17px]" x-text="selected.keperluan || '-'"></p>
                </div>

                <div class="rounded-[22px] bg-slate-50 border border-slate-100 p-5 mt-5">
                    <p class="text-slate-400 font-semibold text-sm mb-3">
                        Catatan Admin
                    </p>

                    <p class="text-slate-800 text-[17px]" x-text="selected.note"></p>
                </div>

                {{-- DOKUMEN ADMIN --}}
                <div class="mt-7">
                    <h3 class="text-slate-400 uppercase tracking-wider text-sm font-semibold mb-4">
                        Dokumen dari Admin
                    </h3>

                    <template x-if="selected.has_final_file">
                        <div class="rounded-[24px] bg-white border border-slate-100 shadow-sm p-5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-rounded text-red-500 text-[30px]">
                                        picture_as_pdf
                                    </span>
                                </div>

                                <div class="min-w-0">
                                    <h4 class="font-semibold text-[18px] text-slate-900 truncate" x-text="selected.file_name"></h4>
                                    <p class="text-slate-400 mt-1">
                                        Dokumen final dari admin
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 shrink-0">
                                <a
                                    :href="selected.lihat_url"
                                    target="_blank"
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-primary hover:bg-blue-100 transition flex items-center justify-center"
                                >
                                    <span class="material-symbols-rounded">
                                        visibility
                                    </span>
                                </a>

                                <a
                                    :href="selected.download_url"
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-primary hover:bg-blue-100 transition flex items-center justify-center"
                                >
                                    <span class="material-symbols-rounded">
                                        download
                                    </span>
                                </a>
                            </div>
                        </div>
                    </template>

                    <template x-if="! selected.has_final_file">
                        <div class="rounded-[24px] bg-slate-50 border border-dashed border-slate-200 p-6 text-center text-slate-400">
                            Dokumen final belum tersedia.
                        </div>
                    </template>
                </div>

                {{-- DOKUMEN PERSYARATAN --}}
                <div class="mt-7">
                    <h3 class="text-slate-400 uppercase tracking-wider text-sm font-semibold mb-4">
                        Dokumen Persyaratan yang Diunggah
                    </h3>

                    <div class="space-y-3">
                        <template x-for="dokumen in selected.dokumen || []" :key="dokumen.file">
                            <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 flex items-center gap-3">
                                <span class="material-symbols-rounded text-primary">
                                    attach_file
                                </span>

                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800" x-text="dokumen.nama"></p>
                                    <p class="text-sm text-slate-400 truncate" x-text="dokumen.file"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- TIMELINE --}}
                <div class="mt-8">
                    <h3 class="text-slate-500 font-semibold text-xl mb-5">
                        Riwayat Status
                    </h3>

                    <div class="relative ml-3 border-l-2 border-blue-100 pl-8 space-y-8">
                        <template x-for="timeline in selected.timeline || []" :key="timeline.title + timeline.date">
                            <div class="relative">
                                <div class="absolute -left-[42px] w-8 h-8 rounded-full flex items-center justify-center" :class="timelineIconClass(timeline.tone)">
                                    <span class="material-symbols-rounded text-[18px]" x-text="timeline.icon"></span>
                                </div>

                                <h4 class="font-semibold text-[20px] text-slate-900" x-text="timeline.title"></h4>
                                <p class="text-slate-500 mt-1" x-text="timeline.description"></p>
                                <p class="text-xs text-slate-400 mt-1" x-text="timeline.date"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="px-8 py-5 border-t border-slate-100 flex justify-end gap-4 bg-white">
                <button
                    @click="modal = false"
                    class="px-8 py-3 rounded-full bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition-all"
                >
                    Tutup
                </button>

                <a
                    href="{{ route('mahasiswa.pengajuan') }}"
                    class="px-8 py-3 rounded-full bg-primary text-white font-semibold
                    shadow-lg shadow-blue-500/30 hover:-translate-y-1 hover:bg-blue-700
                    transition-all duration-300"
                >
                    Ajukan Lagi
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function riwayatPage() {
        return {
            search: '',
            filter: 'all',
            modal: false,
            selected: {},
            items: @json($riwayatItems),

            // Data untuk kotak summary (DRY)
            stats: [
                { label: 'Total', value: '{{ $totalPengajuan }}', color: 'text-slate-900' },
                { label: 'Menunggu', value: '{{ $menunggu }}', color: 'text-slate-600' },
                { label: 'Diproses', value: '{{ $diproses }}', color: 'text-violet-600' },
                { label: 'Selesai', value: '{{ $selesai }}', color: 'text-primary' },
                { label: 'Ditolak', value: '{{ $ditolak }}', color: 'text-red-500' }
            ],

            // Data untuk filter buttons (DRY)
            filters: [
                { val: 'all', label: 'Semua' },
                { val: 'menunggu', label: 'Menunggu' },
                { val: 'diproses', label: 'Diproses' },
                { val: 'selesai', label: 'Selesai' },
                { val: 'ditolak', label: 'Ditolak' }
            ],

            openDetail(item) {
                this.selected = item
                this.modal = true
            },

            statusIconClass(status) {
                return {
                    'bg-blue-100 text-primary': status === 'selesai',
                    'bg-violet-100 text-violet-600': status === 'diproses',
                    'bg-red-100 text-red-500': status === 'ditolak',
                    'bg-slate-100 text-slate-500': status === 'menunggu',
                }
            },

            statusBadgeClass(status) {
                return {
                    'bg-blue-100 text-primary border-blue-200': status === 'selesai',
                    'bg-violet-100 text-violet-600 border-violet-200': status === 'diproses',
                    'bg-red-100 text-red-500 border-red-200': status === 'ditolak',
                    'bg-slate-100 text-slate-500 border-slate-200': status === 'menunggu',
                }
            },

            statusSoftClass(status) {
                return {
                    'bg-blue-100 text-primary': status === 'selesai',
                    'bg-violet-100 text-violet-600': status === 'diproses',
                    'bg-red-100 text-red-500': status === 'ditolak',
                    'bg-slate-200 text-slate-600': status === 'menunggu',
                }
            },

            statusDotClass(status) {
                return {
                    'bg-primary': status === 'selesai',
                    'bg-violet-500': status === 'diproses',
                    'bg-red-500': status === 'ditolak',
                    'bg-slate-400': status === 'menunggu',
                }
            },

            timelineIconClass(tone) {
                return {
                    'bg-primary text-white': tone === 'primary',
                    'bg-violet-100 text-violet-600': tone === 'violet',
                    'bg-green-100 text-green-600': tone === 'success',
                    'bg-red-100 text-red-600': tone === 'danger',
                    'bg-slate-100 text-slate-500': !['primary', 'violet', 'success', 'danger'].includes(tone),
                }
            },

            get filteredItems() {
                return this.items.filter(item => {
                    const keyword = this.search.toLowerCase()

                    const matchFilter =
                        this.filter === 'all'
                        || item.status === this.filter

                    const matchSearch =
                        item.title.toLowerCase().includes(keyword)
                        || item.code.toLowerCase().includes(keyword)

                    return matchFilter && matchSearch
                })
            }
        }
    }
</script>

@endsection