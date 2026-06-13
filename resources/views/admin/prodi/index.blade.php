@extends('layouts.admin')

@section('title', 'Manajemen Prodi')

@section('content')

{{-- Panggil Komponen Alerts --}}
<x-admin-alerts />

<main
    class="ml-0 md:ml-64 min-h-screen flex flex-col pt-20"
    x-data="{
        openModal: false,
        activeFilter: 'Semua',
        search: '',
        
        isEdit: false,
        actionUrl: '',
        formData: {
            kode_prodi: '',
            nama_prodi: '',
            jenjang: 'S1',
            akreditasi: 'A',
            fakultas: '',
            ketua_prodi: '',
            tahun_berdiri: '',
            deskripsi: '',
            status: 'aktif'
        },

        // Data untuk kotak summary (DRY)
        stats: [
            { label: 'Total Prodi', value: '{{ $totalProdi }}', icon: 'school', bg: 'bg-blue-100', text: 'text-blue-600' },
            { label: 'Aktif', value: '{{ $totalAktif }}', icon: 'check_circle', bg: 'bg-green-100', text: 'text-green-600' },
            { label: 'Mahasiswa', value: '{{ number_format($totalMahasiswa, 0, ',', '.') }}', icon: 'groups', bg: 'bg-violet-100', text: 'text-violet-600' },
            { label: 'Akreditasi A', value: '{{ $totalAkreditasiA }}', icon: 'workspace_premium', bg: 'bg-amber-100', text: 'text-amber-600' }
        ],

        // Data untuk filter buttons (DRY)
        filters: ['Semua', 'S1', 'D3', 'D4', 'S2'],

        editProdi(prodi) {
            this.isEdit = true;
            this.actionUrl = '{{ url('/admin/prodi') }}/' + prodi.id;
            this.formData = {
                kode_prodi: prodi.kode_prodi,
                nama_prodi: prodi.nama_prodi,
                jenjang: prodi.jenjang,
                akreditasi: prodi.akreditasi,
                fakultas: prodi.fakultas,
                ketua_prodi: prodi.ketua_prodi || '',
                tahun_berdiri: prodi.tahun_berdiri || '',
                deskripsi: prodi.deskripsi || '',
                status: prodi.status
            };
            this.openModal = true;
        },

        addProdi() {
            this.isEdit = false;
            this.actionUrl = '{{ route('admin.prodi.store') }}';
            this.formData = {
                kode_prodi: '',
                nama_prodi: '',
                jenjang: 'S1',
                akreditasi: 'A',
                fakultas: '',
                ketua_prodi: '',
                tahun_berdiri: '',
                deskripsi: '',
                status: 'aktif'
            };
            this.openModal = true;
        },

        closeModal() {
            this.openModal = false;
        },

        deleteData(id) {
            Swal.fire({
                title: 'Hapus Prodi?',
                text: 'Data program studi akan dihapus permanen dan tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById('deleteForm');
                    form.action = '/admin/prodi/' + id;
                    form.submit();
                }
            });
        }
    }"
>
    <div class="flex-1 px-6 lg:px-10 pb-12 w-full max-w-[1400px] mx-auto space-y-7">

        {{-- PAGE HEADER --}}
        <x-admin-header 
            title="Manajemen Prodi" 
            description="Kelola data program studi yang terdaftar di sistem." 
            buttonText="Tambah Prodi" 
            buttonAction="addProdi()" 
        />

        {{-- STAT CARDS (Refactored using AlpineJS) --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
            <template x-for="stat in stats" :key="stat.label">
                <div class="glass-panel rounded-[24px] p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" :class="stat.bg + ' ' + stat.text">
                        <span class="material-symbols-outlined" x-text="stat.icon"></span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium" x-text="stat.label"></p>
                        <h3 class="text-2xl font-bold text-slate-800" x-text="stat.value"></h3>
                    </div>
                </div>
            </template>
        </div>

        {{-- FILTER BAR --}}
        <div class="glass-panel rounded-[24px] p-4 flex flex-wrap items-center gap-3">
            {{-- SEARCH --}}
            <div class="relative flex-1 min-w-[240px]">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    search
                </span>
                <input
                    type="text"
                    placeholder="Cari prodi atau kode..."
                    x-model="search"
                    class="w-full h-[50px] pl-12 pr-4 rounded-2xl border border-[#E2E8F0]
                    bg-white/80 focus:border-blue-500 focus:ring-0 text-sm"
                >
            </div>

            {{-- FILTER BUTTON (Refactored using AlpineJS) --}}
            <div class="flex items-center gap-2 flex-wrap">
                <template x-for="filter in filters" :key="filter">
                    <button
                        @click="activeFilter = filter"
                        :class="activeFilter === filter ? 'bg-blue-600 text-white' : 'glass-panel text-slate-600'"
                        class="px-4 py-2 rounded-full text-xs font-semibold transition"
                        x-text="filter"
                    ></button>
                </template>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="glass-panel rounded-[28px] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-[#F8FAFC] border-b border-[#E2E8F0]">
                        <tr>
                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">Kode</th>
                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">Program Studi</th>
                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">Jenjang</th>
                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">Akreditasi</th>
                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">Ketua Prodi</th>
                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">Mahasiswa</th>
                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">Status</th>
                            <th class="px-5 py-4 text-center text-sm font-semibold text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EDF2F7]">
                        @forelse($prodis as $prodi)
                        <tr 
                            class="hover:bg-[#F8FAFC] transition"
                            x-show="(activeFilter === 'Semua' || activeFilter === '{{ $prodi->jenjang }}') && 
                            ('{{ strtolower($prodi->nama_prodi) }}'.includes(search.toLowerCase()) || 
                             '{{ strtolower($prodi->kode_prodi) }}'.includes(search.toLowerCase()) ||
                             '{{ strtolower($prodi->fakultas) }}'.includes(search.toLowerCase()))"
                        >
                            <td class="px-5 py-5">
                                <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold">
                                    {{ $prodi->kode_prodi }}
                                </span>
                            </td>
                            <td class="px-5 py-5">
                                <h3 class="font-semibold text-slate-800">{{ $prodi->nama_prodi }}</h3>
                                <p class="text-xs text-slate-500 mt-1">{{ $prodi->deskripsi ?: 'Tidak ada deskripsi singkat.' }}</p>
                            </td>
                            <td class="px-5 py-5">
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">
                                    {{ $prodi->jenjang }}
                                </span>
                            </td>
                            <td class="px-5 py-5">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold">
                                    <span class="material-symbols-outlined text-[14px]">workspace_premium</span>
                                    {{ $prodi->akreditasi }}
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm text-slate-600">
                                {{ $prodi->ketua_prodi ?: '-' }}
                            </td>
                            <td class="px-5 py-5">
                                <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">groups</span>
                                    {{ $prodi->mahasiswa_count }}
                                </div>
                            </td>
                            <td class="px-5 py-5">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $prodi->status === 'aktif' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                    <span class="w-2 h-2 rounded-full {{ $prodi->status === 'aktif' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $prodi->status === 'aktif' ? 'Aktif' : 'Non Aktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-5">
                                <div class="flex items-center justify-center gap-1">
                                    <button
                                        @click="editProdi({{ json_encode($prodi) }})"
                                        class="w-9 h-9 rounded-xl flex items-center justify-center text-blue-600 hover:bg-blue-50 transition"
                                        title="Edit"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    <button
                                        @click="deleteData({{ $prodi->id }})"
                                        class="w-9 h-9 rounded-xl flex items-center justify-center text-red-500 hover:bg-red-50 transition"
                                        title="Hapus"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-[48px]">inbox</span>
                                    <p class="text-sm font-medium">Tidak ada data program studi ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL COMPONENT --}}
    <x-admin-modal 
        titleAdd="Tambah Program Studi" 
        titleEdit="Edit Program Studi" 
        descAdd="Isi semua data yang diperlukan" 
        descEdit="Update data program studi yang diperlukan" 
        formAction="actionUrl"
    >
        <div class="grid grid-cols-2 gap-5">
            <x-form-input id="kode_prodi" label="Kode Prodi" x-model="formData.kode_prodi" placeholder="TIF" required="true" />
            <x-form-select id="jenjang" label="Jenjang" x-model="formData.jenjang" required="true">
                <option value="S1">S1</option>
                <option value="D3">D3</option>
                <option value="D4">D4</option>
                <option value="S2">S2</option>
            </x-form-select>
        </div>

        <x-form-input id="nama_prodi" label="Nama Program Studi" x-model="formData.nama_prodi" placeholder="Teknik Informatika" required="true" />
        <x-form-input id="fakultas" label="Fakultas" x-model="formData.fakultas" placeholder="Fakultas Teknik" required="true" />

        <div class="grid grid-cols-2 gap-5">
            <x-form-input id="ketua_prodi" label="Ketua Prodi" x-model="formData.ketua_prodi" placeholder="Nama Ketua Prodi" />
            <x-form-select id="akreditasi" label="Akreditasi" x-model="formData.akreditasi" required="true">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </x-form-select>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-form-input id="tahun_berdiri" type="number" label="Tahun Berdiri" x-model="formData.tahun_berdiri" placeholder="2002" />
            
            {{-- Status Radio --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-700">Status</label>
                <div class="flex items-center gap-6 mt-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="aktif" x-model="formData.status" class="w-4 h-4 text-blue-600 border-[#CBD5E1] focus:ring-blue-500">
                        <span class="text-sm font-medium text-slate-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="nonaktif" x-model="formData.status" class="w-4 h-4 text-blue-600 border-[#CBD5E1] focus:ring-blue-500">
                        <span class="text-sm font-medium text-slate-700">Non Aktif</span>
                    </label>
                </div>
            </div>
        </div>

        <x-form-textarea id="deskripsi" label="Deskripsi Singkat" x-model="formData.deskripsi" rows="4" placeholder="Deskripsi singkat program studi..." />
    </x-admin-modal>

    {{-- HIDDEN DELETE FORM --}}
    <form id="deleteForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</main>

@endsection