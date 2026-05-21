@extends('layouts.admin')

@section('title', 'Pengajuan Masuk')

@section('content')
<main
    class="md:ml-64 pt-24 px-6 pb-12 relative z-10"
    x-data="{
    activeFilter: 'all',
    openModal: false,

    savePengajuan() {

        Swal.fire({
            title: 'Perubahan Disimpan',
            text: 'Status pengajuan berhasil diperbarui.',
            icon: 'success',
            confirmButtonColor: '#0058bc',
            confirmButtonText: 'Oke',
            background: '#ffffffee',
            backdrop: 'rgba(15,23,42,0.35)',
            customClass: {
                popup: 'rounded-[28px]',
                confirmButton: 'rounded-full px-6 py-2'
            }
        })

        this.openModal = false
    }
}"
>

    {{-- FILTER --}}
    <div class="flex flex-wrap items-center gap-3 mb-8">

        <template x-for="item in ['all','menunggu','diproses','selesai','ditolak']">

            <button
                @click="activeFilter = item"
                :class="activeFilter === item
                    ? 'bg-blue-600 text-white shadow-[0_4px_12px_rgba(0,112,235,0.25)]'
                    : 'bg-white/60 text-slate-600 hover:bg-white'"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 capitalize backdrop-blur-xl border border-white/40"
                x-text="item === 'all' ? 'Semua' : item"
            ></button>

        </template>

    </div>

    {{-- TABLE --}}
    <div class="rounded-[24px] overflow-hidden bg-white/55 backdrop-blur-xl border border-white/40 shadow-[0_12px_40px_rgba(0,112,235,0.08)]">

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>

                    <tr class="border-b border-white/40 bg-white/20">

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            ID Pengajuan
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Nama Pemohon
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Jenis Surat
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Tanggal
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Status
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-white/40">

                    {{-- ROW --}}
                    @php
                        $items = [
                            [
                                'id' => '#REQ-2023-001',
                                'nama' => 'Ahmad S.',
                                'inisial' => 'AS',
                                'jenis' => 'Surat Keterangan Aktif',
                                'tanggal' => '24 Okt 2023',
                                'status' => 'menunggu',
                                'badge' => 'bg-slate-100 text-slate-600',
                                'dot' => 'bg-slate-500',
                                'avatar' => 'bg-violet-100 text-violet-600'
                            ],
                            [
                                'id' => '#REQ-2023-002',
                                'nama' => 'Budi W.',
                                'inisial' => 'BW',
                                'jenis' => 'Surat Izin Penelitian',
                                'tanggal' => '23 Okt 2023',
                                'status' => 'diproses',
                                'badge' => 'bg-violet-100 text-violet-600',
                                'dot' => 'bg-violet-500',
                                'avatar' => 'bg-slate-200 text-slate-600'
                            ],
                            [
                                'id' => '#REQ-2023-003',
                                'nama' => 'Citra D.',
                                'inisial' => 'CD',
                                'jenis' => 'Legalisir Ijazah',
                                'tanggal' => '21 Okt 2023',
                                'status' => 'selesai',
                                'badge' => 'bg-blue-100 text-blue-600',
                                'dot' => 'bg-blue-500',
                                'avatar' => 'bg-blue-100 text-blue-600'
                            ],
                            [
                                'id' => '#REQ-2023-004',
                                'nama' => 'Dian P.',
                                'inisial' => 'DP',
                                'jenis' => 'Surat Cuti Akademik',
                                'tanggal' => '20 Okt 2023',
                                'status' => 'ditolak',
                                'badge' => 'bg-red-100 text-red-600',
                                'dot' => 'bg-red-500',
                                'avatar' => 'bg-red-100 text-red-600'
                            ],
                        ];
                    @endphp

                    @foreach($items as $item)

                    <tr
                        x-show="activeFilter === 'all' || activeFilter === '{{ $item['status'] }}'"
                        class="hover:bg-white/30 transition-colors"
                    >

                        <td class="p-6 text-[15px] font-semibold text-slate-800">
                            {{ $item['id'] }}
                        </td>

                        <td class="p-6">

                            <div class="flex items-center gap-3">

                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $item['avatar'] }}">
                                    {{ $item['inisial'] }}
                                </div>

                                <div class="text-[15px] text-slate-700">
                                    {{ $item['nama'] }}
                                </div>

                            </div>

                        </td>

                        <td class="p-6 text-[15px] text-slate-500">
                            {{ $item['jenis'] }}
                        </td>

                        <td class="p-6 text-[15px] text-slate-500">
                            {{ $item['tanggal'] }}
                        </td>

                        <td class="p-6">

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-medium border border-white/50 {{ $item['badge'] }}">

                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $item['dot'] }}"></span>

                                {{ ucfirst($item['status']) }}

                            </span>

                        </td>

                        <td class="p-6 text-center">

                            <button
                                @click="openModal = true"
                                class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-colors"
                            >
                                <span class="material-symbols-outlined">
                                    visibility
                                </span>
                            </button>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{-- MODAL --}}
    <div
        x-show="openModal"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center p-4"
        style="display:none;"
    >

        {{-- BACKDROP --}}
        <div
            @click="openModal = false"
            class="absolute inset-0 z-[998] bg-black/20 backdrop-blur-md"
        ></div>

        {{-- MODAL CONTENT --}}
        <div class="relative z-[1000] w-full max-w-2xl max-h-[92vh] overflow-hidden rounded-[24px] bg-white/90 backdrop-blur-2xl border border-white/50 shadow-[0_24px_80px_rgba(0,112,235,0.18)] flex flex-col">

            {{-- HEADER --}}
            <div class="px-8 py-5 border-b border-white/40 bg-white/30 flex items-center justify-between shrink-0">

                <div>

                    <h2 class="text-[32px] font-bold tracking-tight text-slate-900">
                        Review Pengajuan
                    </h2>

                    <p class="mt-1 text-sm font-semibold text-blue-600">
                        #REQ-2023-001
                    </p>

                </div>

                <button
                    @click="openModal = false"
                    class="w-9 h-9 rounded-full flex items-center justify-center text-slate-400 hover:bg-white/50 hover:text-red-500 transition-colors"
                >
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </button>

            </div>

            {{-- BODY --}}
            <div class="overflow-y-auto flex-1 p-8 space-y-7">

                {{-- INFORMASI --}}
                <section>

                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-semibold mb-3">
                        Informasi Pemohon
                    </p>

                    <div class="grid grid-cols-2 gap-4">

                        @php
                            $info = [
                                ['Nama Pemohon', 'Ahmad Sulaiman'],
                                ['NIM', '20210101001'],
                                ['Jenis Surat', 'Surat Keterangan Aktif'],
                                ['Tanggal Pengajuan', '24 Oktober 2023'],
                            ];
                        @endphp

                        @foreach($info as [$label, $value])

                        <div class="p-4 rounded-xl bg-white/40 border border-white/50">

                            <p class="text-xs text-slate-400 mb-1">
                                {{ $label }}
                            </p>

                            <p class="text-[15px] font-semibold text-slate-800">
                                {{ $value }}
                            </p>

                        </div>

                        @endforeach

                    </div>

                </section>

                {{-- BERKAS --}}
<section>

    <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-semibold mb-3">
        Berkas Dari Pemohon
    </p>

    <div class="space-y-4">

        {{-- FILE --}}
        <div class="rounded-2xl bg-white/50 border border-white/60 overflow-hidden">

            {{-- FILE HEADER --}}
            <div class="flex items-center justify-between p-4 border-b border-slate-100">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">

                        <span class="material-symbols-outlined text-[20px]">
                            picture_as_pdf
                        </span>

                    </div>

                    <div>

                        <p class="text-[14px] font-medium text-slate-800">
                            KK_Ahmad.pdf
                        </p>

                        <p class="text-xs text-slate-400">
                            Kartu Keluarga • 1.2 MB
                        </p>

                    </div>

                </div>

                <button class="px-4 py-2 rounded-xl bg-blue-50 text-blue-600 text-sm font-semibold hover:bg-blue-100 transition-colors">
                    Download
                </button>

            </div>

            {{-- PREVIEW --}}
            <div class="aspect-video bg-slate-100 flex items-center justify-center">

                <div class="text-center">

                    <span class="material-symbols-outlined text-[64px] text-slate-300">
                        description
                    </span>

                    <p class="text-sm text-slate-400 mt-2">
                        Preview Dokumen
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

                {{-- TINDAKAN --}}
                <section>

                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-semibold mb-3">
                        Tindakan Admin
                    </p>

                    <div class="space-y-4">

                        <div>

                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Update Status
                            </label>

                            <select class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white/70 text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                <option>Menunggu</option>
                                <option selected>Diproses</option>
                                <option>Selesai</option>
                                <option>Ditolak</option>

                            </select>

                        </div>

                        <div>

                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Catatan / Alasan
                            </label>

                            <textarea
                                rows="3"
                                placeholder="Tambahkan catatan untuk pemohon..."
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white/70 resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            ></textarea>

                            <div>

    <label class="block mb-2 text-sm font-semibold text-slate-700">
        Upload Dokumen Balasan
    </label>

    <label
        class="flex flex-col items-center justify-center
               w-full p-8 rounded-[24px]
               border-2 border-dashed border-slate-200
               bg-white/50 hover:bg-white/70
               transition-all cursor-pointer"
    >

        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4">

            <span class="material-symbols-outlined text-[28px]">
                upload_file
            </span>

        </div>

        <p class="text-[15px] font-semibold text-slate-700">
            Upload Dokumen Balasan
        </p>

        <p class="text-sm text-slate-400 mt-1">
            PDF, DOCX, PNG, JPG
        </p>

        <input
            type="file"
            class="hidden"
        >

    </label>

</div>

<div class="rounded-2xl bg-white/50 border border-white/60 p-4">

    <div class="flex items-center justify-between">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center">

                <span class="material-symbols-outlined">
                    description
                </span>

            </div>

            <div>

                <p class="text-[14px] font-medium text-slate-800">
                    Surat_Balasan.pdf
                </p>

                <p class="text-xs text-slate-400">
                    840 KB
                </p>

            </div>

        </div>

        <button class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors">

            <span class="material-symbols-outlined">
                delete
            </span>

        </button>

    </div>

</div>

                        </div>

                    </div>

                </section>

            </div>

            {{-- FOOTER --}}
            <div class="px-8 py-5 border-t border-white/40 bg-white/20 flex items-center justify-between shrink-0">

                <button
                    @click="openModal = false"
                    class="px-6 py-2.5 rounded-full text-sm font-semibold bg-white/70 text-slate-700 hover:bg-white transition-all border border-white/50"
                >
                    Batal
                </button>

                <button
    @click="savePengajuan()"
    class="px-7 py-2.5 rounded-full text-sm font-semibold bg-blue-600 text-white shadow-[0_4px_16px_rgba(0,112,235,0.3)] hover:brightness-110 transition-all flex items-center gap-2"
>

    <span class="material-symbols-outlined text-[18px]">
        save
    </span>

    Simpan Perubahan

</button>

            </div>

        </div>

    </div>

</main>
@endsection