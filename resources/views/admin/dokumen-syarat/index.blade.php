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

{{-- Panggil Komponen Alerts Global --}}
<x-admin-alerts />

<div
    x-data="{
        openModal: false,
        editMode: false,
        actionUrl: '',
        allOpen: false,
        openCard: null,
        openRequirementModal: false,

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
            allowed_formats: ['pdf'],
            max_size: 5
        },

        // Data array untuk Stat Cards (DRY)
        stats: [
            { label: 'Jenis Surat', value: '{{ $totalJenisSurat }}', icon: 'folder_open', bg: 'bg-[#eaf2ff]', text: 'text-[#0058BC]' },
            { label: 'Total Syarat', value: '{{ $totalSyarat }}', icon: 'attach_file', bg: 'bg-[#f3ebff]', text: 'text-[#7c3aed]' },
            { label: 'Format PDF', value: '{{ $totalPdf }}', icon: 'picture_as_pdf', bg: 'bg-[#ffecec]', text: 'text-[#ef4444]' },
            { label: 'Format Gambar', value: '{{ $totalGambar }}', icon: 'image', bg: 'bg-[#f1f5f9]', text: 'text-[#475569]' }
        ],

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

        addDocument() {
            this.editMode = false;
            this.actionUrl = '{{ route('admin.dokumen-syarat.store') }}';
            this.selectedDocument = {
                id: '',
                nama_dokumen: '',
                keterangan: '',
                allowed_formats: ['pdf'],
                max_size: 5
            };
            this.openModal = true;
        },

        editDocument(dokumen) {
            this.editMode = true;
            this.actionUrl = dokumen.update_url;
            this.selectedDocument = {
                id: dokumen.id,
                nama_dokumen: dokumen.nama_dokumen || '',
                keterangan: dokumen.keterangan || '',
                allowed_formats: dokumen.allowed_formats || [],
                max_size: dokumen.max_size || 5
            };
            this.openModal = true;
        },

        closeModal() {
            this.openModal = false;
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

                {{-- HEADER KOMPONEN --}}
                <x-admin-header 
                    title="Dokumen Syarat" 
                    description="Kelola persyaratan dokumen untuk setiap jenis surat pengajuan." 
                    buttonText="" 
                    buttonAction="" 
                />

                {{-- STATS CARDS (Refactored using x-for) --}}
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-5">
                    <template x-for="stat in stats" :key="stat.label">
                        <div class="bg-white rounded-[24px] border border-[#e8edf7] p-5 flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center" :class="stat.bg + ' ' + stat.text">
                                <span class="material-symbols-outlined text-[30px]" x-text="stat.icon"></span>
                            </div>
                            <div>
                                <p class="text-[15px] text-[#64748b] font-medium" x-text="stat.label"></p>
                                <h2 class="text-[40px] leading-none font-semibold text-[#0f172a] mt-1" x-text="stat.value"></h2>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- FILTER ACTIONS --}}
                <div class="flex flex-wrap gap-4">
                    <button type="button" class="h-12 px-6 rounded-full bg-[#0058BC] text-white font-semibold text-[15px] shadow-[0_8px_20px_rgba(0,88,188,0.25)]">Semua</button>
                    <button type="button" class="h-12 px-6 rounded-full bg-white border border-[#e5e7eb] text-[#334155] font-semibold text-[15px]">Semua Dokumen Wajib</button>
                    <button type="button" @click="openAllCards()" class="h-12 px-6 rounded-full bg-white border border-[#e5e7eb] text-[#334155] font-semibold text-[15px] flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">unfold_more</span> Buka Semua
                    </button>
                    <button type="button" @click="closeAllCards()" class="h-12 px-6 rounded-full bg-white border border-[#e5e7eb] text-[#334155] font-semibold text-[15px] flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">unfold_less</span> Tutup Semua
                    </button>
                    <button type="button" @click="addDocument()" class="h-12 px-6 rounded-full bg-[#0058BC] text-white font-semibold text-[15px] flex items-center gap-2 shadow-[0_8px_20px_rgba(0,88,188,0.25)]">
                        <span class="material-symbols-outlined">note_add</span> Tambah Dokumen Syarat
                    </button>
                </div>

                {{-- MASTER DOKUMEN SYARAT --}}
                <div class="bg-white border border-[#e8edf7] rounded-[24px] overflow-hidden">
                    <div class="px-6 py-5 border-b border-[#edf2f7]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-[#eaf2ff] flex items-center justify-center text-[#2563eb]">
                                    <span class="material-symbols-outlined">folder_open</span>
                                </div>
                                <div>
                                    <h2 class="text-[22px] font-semibold text-[#0f172a]">Master Dokumen Syarat</h2>
                                    <p class="text-[14px] text-[#64748b]">Daftar seluruh dokumen syarat yang tersedia.</p>
                                </div>
                            </div>
                            <button type="button" @click="addDocument()" class="h-11 px-5 rounded-full border border-[#dbe3ef] text-[#334155] font-semibold text-[14px]">
                                Kelola Master
                            </button>
                        </div>
                    </div>

                    {{-- TABLE MASTER DOKUMEN --}}
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-[#f8fafc]">
                                    <th class="text-left px-6 py-4 text-sm font-semibold">Nama Dokumen</th>
                                    <th class="text-left px-6 py-4 text-sm font-semibold">Deskripsi</th>
                                    <th class="text-left px-6 py-4 text-sm font-semibold">Format</th>
                                    <th class="text-left px-6 py-4 text-sm font-semibold">Maks</th>
                                    <th class="text-center px-6 py-4 text-sm font-semibold">Aksi</th>
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
                                                    <span class="material-symbols-outlined text-[20px]">{{ $icon['icon'] }}</span>
                                                </div>
                                                <span class="font-semibold">{{ $dokumen->nama_dokumen }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-[#64748b]">{{ $dokumen->keterangan ?: '-' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-2 flex-wrap">
                                                @forelse ($formats as $format)
                                                    <span class="px-2 py-1 rounded-full border text-xs font-semibold {{ $formatBadgeClass[$format] ?? 'border-slate-200 text-slate-500 bg-slate-50' }}">
                                                        {{ strtoupper($format) }}
                                                    </span>
                                                @empty
                                                    <span class="text-sm text-[#94a3b8]">-</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">{{ $dokumen->max_size }} MB</td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">
                                                <button
                                                    type="button"
                                                    @click="editDocument({{ Illuminate\Support\Js::from([
                                                        'id' => (string) $dokumen->id,
                                                        'nama_dokumen' => $dokumen->nama_dokumen,
                                                        'keterangan' => $dokumen->keterangan,
                                                        'allowed_formats' => $formats->values(),
                                                        'max_size' => (int) $dokumen->max_size,
                                                        'update_url' => route('admin.dokumen-syarat.update', $dokumen),
                                                    ]) }})"
                                                    class="text-blue-500 hover:text-blue-700"
                                                >
                                                    <span class="material-symbols-outlined">edit</span>
                                                </button>

                                                <form method="POST" action="{{ route('admin.dokumen-syarat.destroy', $dokumen) }}" @submit="confirmDelete($event, 'Hapus Dokumen?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50">
                                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-t border-[#edf2f7]">
                                        <td colspan="5" class="px-6 py-10 text-center text-[#64748b]">Belum ada dokumen syarat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- CARD SURAT & REQUIREMENT ASSIGNMENT --}}
                <div class="space-y-4">
                    @forelse ($jenisSurats as $surat)
                        @php
                            $suratPayload = [
                                'id' => (string) $surat->id,
                                'nama_surat' => $surat->nama_surat,
                                'deskripsi' => $surat->deskripsi,
                                'dokumen_ids' => $surat->dokumenSyarat->pluck('id')->map(fn ($id) => (string) $id)->values(),
                            ];
                        @endphp
                        <div class="bg-white border border-[#e8edf7] rounded-[24px] overflow-hidden">
                            {{-- HEADER SURAT --}}
                            <div class="px-6 py-5 flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-[#eaf2ff] flex items-center justify-center text-[#2563eb]">
                                    <span class="material-symbols-outlined text-[30px]">description</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <h2 class="text-[20px] font-semibold text-[#0f172a]">{{ $surat->nama_surat }}</h2>
                                        <span class="px-3 py-1 rounded-full bg-[#eaf2ff] text-[#2563eb] text-[12px] font-semibold border border-[#bfdbfe]">Aktif</span>
                                    </div>
                                    <p class="mt-1 text-[15px] text-[#64748b]">{{ $surat->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                                </div>
                                <div class="hidden md:flex items-center gap-5 text-[15px] text-[#64748b]">
                                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>{{ $surat->dokumenSyarat->count() }} syarat</span>
                                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>wajib upload</span>
                                </div>
                                <div class="flex items-center gap-3 ml-4">
                                    <button type="button" class="text-[#64748b]" @click="toggleCard('{{ $surat->id }}')">
                                        <span class="material-symbols-outlined transition duration-300" :class="isCardOpen('{{ $surat->id }}') ? 'rotate-180' : ''">expand_more</span>
                                    </button>
                                </div>
                            </div>

                            {{-- REQUIREMENT CONTENT --}}
                            <div x-show="isCardOpen('{{ $surat->id }}')" x-transition class="px-6 pb-5 pt-4 border-t border-[#edf2f7] space-y-3">
                                @forelse ($surat->dokumenSyarat as $dokumen)
                                    @php $formats = $getFormats($dokumen); @endphp
                                    <div class="group flex items-start gap-3 p-4 rounded-[20px] bg-[#f8fafc] border border-[#edf2f7] hover:bg-white transition-all">
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-[17px] font-semibold text-[#0f172a]">{{ $dokumen->nama_dokumen }}</h3>
                                            <p class="mt-2 text-[14px] text-[#64748b]">{{ $dokumen->keterangan ?: '-' }}</p>
                                            <div class="flex items-center gap-2 flex-wrap mt-3">
                                                @foreach ($formats as $format)
                                                    <span class="px-2 py-[3px] rounded-full border text-[10px] font-semibold {{ $formatBadgeClass[$format] ?? 'border-slate-200 text-slate-500 bg-slate-50' }}">
                                                        {{ strtoupper($format) }}
                                                    </span>
                                                @endforeach
                                                <span class="flex items-center gap-1 text-[11px] text-[#94a3b8]">
                                                    <span class="material-symbols-outlined text-[13px]">storage</span> Maks. {{ $dokumen->max_size }} MB
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                            <form method="POST" action="{{ route('admin.dokumen-syarat.putuskan') }}" @submit="confirmDelete($event, 'Lepas Syarat dari Surat?')">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="jenis_surat_id" value="{{ $surat->id }}">
                                                <input type="hidden" name="dokumen_syarat_id" value="{{ $dokumen->id }}">
                                                <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50" title="Lepas dari jenis surat">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-5 rounded-[20px] bg-[#f8fafc] border border-[#edf2f7] text-[#64748b]">Belum ada dokumen syarat untuk jenis surat ini.</div>
                                @endforelse
                                <button type="button" @click="openAssignModal({{ Illuminate\Support\Js::from($suratPayload) }})" class="w-full py-5 border-2 border-dashed border-[#c7d7f2] rounded-[20px] text-[#64748b] hover:border-[#0058BC] hover:text-[#0058BC] transition">
                                    <span class="material-symbols-outlined text-[20px]">add_circle</span> Tambah Syarat ke Surat Ini
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-[#e8edf7] rounded-[24px] p-8 text-center text-[#64748b]">Belum ada jenis surat.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    {{-- MODAL KOMPONEN UTAMA (TAMBAH & EDIT MASTER) --}}
    <x-admin-modal 
        titleAdd="Tambah Dokumen Syarat" 
        titleEdit="Edit Dokumen Syarat" 
        descAdd="Tambahkan dokumen ke master dokumen syarat." 
        descEdit="Perbarui data master dokumen." 
        formAction="actionUrl"
    >
        <x-form-input id="nama_dokumen" label="Nama Dokumen" x-model="selectedDocument.nama_dokumen" placeholder="Contoh: Kartu Keluarga (KK)" required="true" />
        <x-form-textarea id="keterangan" label="Deskripsi" x-model="selectedDocument.keterangan" rows="3" />
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-select id="max_size" label="Ukuran Maksimum" x-model="selectedDocument.max_size" required="true">
                @foreach ($maxSizeOptions as $size)
                    <option value="{{ $size }}">{{ $size }} MB</option>
                @endforeach
            </x-form-select>
            
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-500">Format Izin</label>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    @foreach ($formatOptions as $value => $label)
                        <label class="h-14 rounded-2xl border px-4 flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="allowed_formats[]" value="{{ $value }}" x-model="selectedDocument.allowed_formats" class="rounded">
                            <span class="font-semibold text-sm">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </x-admin-modal>

    {{-- MODAL TAMBAH SYARAT KE SURAT (TETAP CUSTOM KARENA BEDA LOGIC DAN CHECKBOX) --}}
    <div x-show="openRequirementModal" x-transition class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4" style="display:none;">
        <form method="POST" action="{{ route('admin.dokumen-syarat.hubungkan') }}" @click.outside="openRequirementModal=false" class="w-full max-w-[600px] bg-white rounded-[32px] p-8">
            @csrf
            <input type="hidden" name="jenis_surat_id" :value="selectedJenisSurat.id">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-[30px] font-semibold">Tambah Syarat ke Surat</h2>
                    <p class="text-slate-500" x-text="selectedJenisSurat.nama_surat || '-'"></p>
                </div>
                <button type="button" @click="openRequirementModal=false"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="space-y-3 max-h-[55vh] overflow-y-auto pr-1">
                @forelse ($dokumenSyarats as $index => $dokumen)
                    @php $icon = $iconList[$index % count($iconList)]; @endphp
                    <label class="flex items-center gap-4 p-5 border border-slate-200 rounded-[20px] hover:border-blue-300 hover:bg-blue-50/30 transition cursor-pointer">
                        <input type="checkbox" name="dokumen_ids[]" value="{{ $dokumen->id }}" x-model="selectedDocIds" class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500">
                        <div class="w-10 h-10 rounded-xl {{ $icon['class'] }} flex items-center justify-center"><span class="material-symbols-outlined">{{ $icon['icon'] }}</span></div>
                        <div>
                            <p class="font-semibold text-slate-800">{{ $dokumen->nama_dokumen }}</p>
                            <p class="text-sm text-slate-500">{{ $dokumen->keterangan ?: 'Dokumen syarat' }}</p>
                        </div>
                    </label>
                @empty
                    <div class="p-5 border border-slate-200 rounded-[20px] text-slate-500">Belum ada master dokumen syarat.</div>
                @endforelse
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" @click="openRequirementModal=false" class="px-6 py-3 rounded-full bg-slate-100 font-semibold">Batal</button>
                <button type="submit" class="px-6 py-3 rounded-full bg-[#0058BC] text-white font-semibold">Tambahkan</button>
            </div>
        </form>
    </div>
</div>
@endsection