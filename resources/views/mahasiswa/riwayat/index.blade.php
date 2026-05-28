@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pengajuan')

@section('content')

<div
    x-data="riwayatPage()"
    class="space-y-8"
>

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
            bg-primary text-white font-semibold
            shadow-lg shadow-blue-500/30
            hover:bg-blue-700 hover:-translate-y-1
            transition-all duration-300"
        >
            <span class="material-symbols-rounded text-[20px]">add</span>
            Pengajuan Baru
        </a>

    </div>

    {{-- SEARCH + FILTER --}}
    <div class="glass-panel rounded-[28px] p-4 flex flex-col lg:flex-row gap-3">

        {{-- SEARCH --}}
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

        {{-- FILTER --}}
        <div class="flex gap-2 flex-wrap">

            <button
                @click="filter='all'"
                :class="filter === 'all'
                    ? 'bg-primary text-white shadow-lg shadow-blue-500/20'
                    : 'bg-white text-slate-600 hover:bg-slate-100'"

                class="px-5 py-2.5 rounded-full
                font-semibold transition-all duration-300"
            >
                Semua
            </button>

            <button
                @click="filter='waiting'"
                :class="filter === 'waiting'
                    ? 'bg-primary text-white shadow-lg shadow-blue-500/20'
                    : 'bg-white text-slate-600 hover:bg-slate-100'"

                class="px-5 py-2.5 rounded-full
                font-semibold transition-all duration-300"
            >
                Menunggu
            </button>

            <button
                @click="filter='process'"
                :class="filter === 'process'
                    ? 'bg-primary text-white shadow-lg shadow-blue-500/20'
                    : 'bg-white text-slate-600 hover:bg-slate-100'"

                class="px-5 py-2.5 rounded-full
                font-semibold transition-all duration-300"
            >
                Diproses
            </button>

            <button
                @click="filter='done'"
                :class="filter === 'done'
                    ? 'bg-primary text-white shadow-lg shadow-blue-500/20'
                    : 'bg-white text-slate-600 hover:bg-slate-100'"

                class="px-5 py-2.5 rounded-full
                font-semibold transition-all duration-300"
            >
                Selesai
            </button>

        </div>

    </div>

    {{-- CARDS --}}
    <div
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 items-start"
    >

        <template x-for="item in filteredItems" :key="item.id">

        <div
            @click="openDetail(item)"
            x-transition
            class="glass-panel rounded-[28px]
            px-7 py-6
            h-[172px]
            flex flex-col justify-between
            hover:-translate-y-1.5
            hover:shadow-xl
            transition-all duration-300
            cursor-pointer group"
        >

            {{-- TOP --}}
            <div class="flex items-start justify-between">

                <div class="flex items-start gap-4">

                    {{-- ICON --}}
                    <div
                        class="w-[50px] h-[50px]
                        rounded-[18px]
                        flex items-center justify-center
                        shrink-0"

                        :class="{
                            'bg-blue-100 text-primary': item.status === 'done',
                            'bg-violet-100 text-violet-600': item.status === 'process',
                            'bg-slate-100 text-slate-500': item.status === 'waiting'
                        }"
                    >

                        <span
                            class="material-symbols-rounded text-[26px]"
                            style="font-variation-settings:'FILL' 1"
                            x-text="item.icon"
                        ></span>

                    </div>

                    {{-- TEXT --}}
                    <div class="pt-1">

                        <h3
                            class="text-[17px]
                            font-semibold
                            text-slate-900
                            leading-[1.15]
                            max-w-[170px]"
                            x-text="item.title"
                        ></h3>

                        <p
                            class="text-slate-400
                            text-[13px]
                            font-semibold
                            mt-1"
                            x-text="'#'+item.id"
                        ></p>

                    </div>

                </div>

                {{-- STATUS --}}
                <span
                    class="inline-flex items-center gap-1.5
                    px-3 py-1.5 rounded-full
                    text-[12px]
                    font-semibold border"

                    :class="{
                        'bg-blue-100 text-primary border-blue-200': item.status === 'done',
                        'bg-violet-100 text-violet-600 border-violet-200': item.status === 'process',
                        'bg-slate-100 text-slate-500 border-slate-200': item.status === 'waiting'
                    }"
                >

                    <span
                        class="w-1.5 h-1.5 rounded-full"

                        :class="{
                            'bg-primary': item.status === 'done',
                            'bg-violet-500': item.status === 'process',
                            'bg-slate-400': item.status === 'waiting'
                        }"
                    ></span>

                    <span x-text="statusLabel(item.status)"></span>

                </span>

            </div>

            {{-- DIVIDER --}}
            <div class="h-px bg-slate-100"></div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-between">

                <div
                    class="flex items-center gap-2
                    text-slate-400
                    text-[14px]
                    font-medium"
                >

                    <span class="material-symbols-rounded text-[18px]">
                        calendar_today
                    </span>

                    <span x-text="item.date"></span>

                </div>

                <div
                    class="flex items-center gap-1
                    text-primary text-[14px]
                    font-semibold
                    opacity-0 group-hover:opacity-100
                    translate-x-2 group-hover:translate-x-0
                    transition-all duration-300"
                >

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
        class="glass-panel rounded-[28px]
        py-20 flex flex-col items-center
        justify-center text-center"
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
        class="fixed inset-0 z-50 flex items-center justify-center
        bg-black/20 backdrop-blur-md p-4"
    >

        <div
            @click.outside="modal = false"

            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0 scale-95 translate-y-6"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"

            class="w-full max-w-2xl
            bg-white/95 backdrop-blur-2xl
            rounded-[32px]
            shadow-[0_30px_80px_rgba(0,0,0,0.18)]
            border border-white/60
            overflow-hidden"
        >

            {{-- HEADER --}}
            <div class="px-8 pt-7 pb-5 flex items-start justify-between">

                <div>

                    <h2
                        class="text-[32px] leading-tight
                        font-semibold text-slate-900"
                        x-text="selected.title"
                    ></h2>

                    <p
                        class="text-primary font-semibold text-lg mt-1"
                        x-text="'#'+selected.id"
                    ></p>

                </div>

                <button
                    @click="modal = false"
                    class="text-slate-400 hover:text-red-500 transition"
                >

                    <span class="material-symbols-rounded text-[34px]">
                        close
                    </span>

                </button>

            </div>

            {{-- CONTENT --}}
            <div class="px-8 pb-8 max-h-[68vh] overflow-y-auto">

                {{-- STATUS CARD --}}
                <div
                    class="rounded-[24px]
                    bg-slate-50 border border-slate-100
                    px-5 py-5
                    flex items-center justify-between"
                >

                    <span class="text-slate-500 font-semibold">
                        Status saat ini
                    </span>

                    <span
                        class="px-5 py-2 rounded-full
                        text-sm font-semibold"

                        :class="{
                            'bg-blue-100 text-primary': selected.status === 'done',
                            'bg-violet-100 text-violet-600': selected.status === 'process',
                            'bg-slate-200 text-slate-600': selected.status === 'waiting'
                        }"
                    >

                        ● <span x-text="statusLabel(selected.status)"></span>

                    </span>

                </div>

                {{-- INFO GRID --}}
                <div class="grid grid-cols-2 gap-4 mt-5">

                    <div
                        class="rounded-[22px]
                        bg-slate-50 border border-slate-100
                        p-5"
                    >

                        <p class="text-slate-400 font-medium text-sm mb-2">
                            Tanggal Pengajuan
                        </p>

                        <h3
                            class="text-[20px] font-semibold text-slate-900"
                            x-text="selected.date"
                        ></h3>

                    </div>

                    <div
                        class="rounded-[22px]
                        bg-slate-50 border border-slate-100
                        p-5"
                    >

                        <p class="text-slate-400 font-medium text-sm mb-2">
                            Jenis Surat
                        </p>

                        <h3
                            class="text-[20px] font-semibold text-slate-900 leading-tight"
                            x-text="selected.title"
                        ></h3>

                    </div>

                </div>

                {{-- CATATAN --}}
                <div
                    class="rounded-[22px]
                    bg-slate-50 border border-slate-100
                    p-5 mt-5"
                >

                    <p class="text-slate-400 font-semibold text-sm mb-3">
                        Catatan Admin
                    </p>

                    <p
                        class="text-slate-800 text-[17px]"
                        x-text="selected.note"
                    ></p>

                </div>

                {{-- DOKUMEN --}}
                <div class="mt-7">

                    <h3
                        class="text-slate-400 uppercase
                        tracking-wider text-sm
                        font-semibold mb-4"
                    >
                        Dokumen dari Admin
                    </h3>

                    <div
                        class="rounded-[24px]
                        bg-white border border-slate-100
                        shadow-sm
                        p-5 flex items-center justify-between"
                    >

                        <div class="flex items-center gap-4">

                            {{-- ICON --}}
                            <div
                                class="w-14 h-14 rounded-2xl
                                bg-red-50
                                flex items-center justify-center"
                            >

                                <span
                                    class="material-symbols-rounded
                                    text-red-500 text-[30px]"
                                >
                                    picture_as_pdf
                                </span>

                            </div>

                            {{-- FILE --}}
                            <div>

                                <h4 class="font-semibold text-[18px] text-slate-900">
                                    Surat_Keterangan_Aktif_Ahmad.pdf
                                </h4>

                                <p class="text-slate-400 mt-1">
                                    245 KB • Diunggah 14 Okt 2023
                                </p>

                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="flex items-center gap-3">

                            <button
                                class="w-10 h-10 rounded-xl
                                bg-blue-50 text-primary
                                hover:bg-blue-100 transition
                                flex items-center justify-center"
                            >

                                <span class="material-symbols-rounded">
                                    visibility
                                </span>

                            </button>

                            <button
                                class="w-10 h-10 rounded-xl
                                bg-blue-50 text-primary
                                hover:bg-blue-100 transition
                                flex items-center justify-center"
                            >

                                <span class="material-symbols-rounded">
                                    download
                                </span>

                            </button>

                        </div>

                    </div>

                </div>

                {{-- TIMELINE --}}
                <div class="mt-8">

                    <h3
                        class="text-slate-500 font-semibold
                        text-xl mb-5"
                    >
                        Riwayat Status
                    </h3>

                    <div class="relative ml-3 border-l-2 border-blue-100 pl-8 space-y-8">

                        {{-- ITEM --}}
                        <div class="relative">

                            <div
                                class="absolute -left-[42px]
                                w-8 h-8 rounded-full
                                bg-primary text-white
                                flex items-center justify-center"
                            >

                                <span class="material-symbols-rounded text-[18px]">
                                    check
                                </span>

                            </div>

                            <h4 class="font-semibold text-[20px] text-slate-900">
                                Selesai
                            </h4>

                            <p class="text-slate-500 mt-1">
                                Dokumen dari admin siap diunduh
                            </p>

                        </div>

                        {{-- ITEM --}}
                        <div class="relative">

                            <div
                                class="absolute -left-[42px]
                                w-8 h-8 rounded-full
                                bg-violet-100 text-violet-600
                                flex items-center justify-center"
                            >

                                <span class="material-symbols-rounded text-[18px]">
                                    verified_user
                                </span>

                            </div>

                            <h4 class="font-semibold text-[20px] text-slate-900">
                                Diverifikasi Admin
                            </h4>

                            <p class="text-slate-500 mt-1">
                                Berkas telah disetujui
                            </p>

                        </div>

                        {{-- ITEM --}}
                        <div class="relative">

                            <div
                                class="absolute -left-[42px]
                                w-8 h-8 rounded-full
                                bg-slate-100 text-slate-500
                                flex items-center justify-center"
                            >

                                <span class="material-symbols-rounded text-[18px]">
                                    upload_file
                                </span>

                            </div>

                            <h4 class="font-semibold text-[20px] text-slate-900">
                                Berkas Diunggah
                            </h4>

                            <p class="text-slate-500 mt-1">
                                Pengajuan pertama kali masuk
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div
                class="px-8 py-5
                border-t border-slate-100
                flex justify-end gap-4
                bg-white"
            >

                <button
                    @click="modal = false"

                    class="px-8 py-3 rounded-full
                    bg-slate-100 text-slate-700
                    font-semibold
                    hover:bg-slate-200
                    transition-all"
                >
                    Tutup
                </button>

                <a
                    href="{{ route('mahasiswa.pengajuan') }}"

                    class="px-8 py-3 rounded-full
                    bg-primary text-white
                    font-semibold
                    shadow-lg shadow-blue-500/30
                    hover:-translate-y-1
                    hover:bg-blue-700
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

            items: [

                {
                    id: 'REQ-001',
                    title: 'Surat Keterangan Aktif',
                    status: 'done',
                    date: '12 Okt 2023',
                    note: 'Tidak ada catatan.',
                    icon: 'description'
                },

                {
                    id: 'REQ-002',
                    title: 'Transkrip Nilai Sementara',
                    status: 'process',
                    date: '10 Okt 2023',
                    note: 'Sedang diverifikasi admin.',
                    icon: 'description'
                },

                {
                    id: 'REQ-003',
                    title: 'Surat Pengantar Penelitian',
                    status: 'waiting',
                    date: '08 Okt 2023',
                    note: 'Menunggu antrian verifikasi.',
                    icon: 'description'
                },

                {
                    id: 'REQ-004',
                    title: 'Surat Keterangan Lulus',
                    status: 'done',
                    date: '01 Okt 2023',
                    note: 'Dokumen siap diambil.',
                    icon: 'workspace_premium'
                },

                {
                    id: 'REQ-005',
                    title: 'Surat Cuti Akademik',
                    status: 'process',
                    date: '28 Sep 2023',
                    note: 'Menunggu persetujuan admin.',
                    icon: 'event_busy'
                }

            ],

            openDetail(item) {
                this.selected = item
                this.modal = true
            },

            statusLabel(status) {
                if(status === 'done') return 'Selesai'
                if(status === 'process') return 'Diproses'
                return 'Menunggu'
            },

            get filteredItems() {

                return this.items.filter(item => {

                    const matchFilter =
                        this.filter === 'all'
                        || item.status === this.filter

                    const matchSearch =
                        item.title.toLowerCase().includes(this.search.toLowerCase())
                        || item.id.toLowerCase().includes(this.search.toLowerCase())

                    return matchFilter && matchSearch
                })
            }
        }
    }
</script>

@endsection