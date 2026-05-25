@extends('layouts.admin')

@section('title', 'Akun Mahasiswa')

@section('content')

<main
    class="md:ml-64 pt-24 px-6 pb-12 relative z-10"
    x-data="{
        activeFilter: '{{ request('status', 'all') }}',
        searchQuery: '{{ request('search', '') }}',
        prodiId: '{{ request('prodi_id', '') }}',
        angkatanId: '{{ request('angkatan', '') }}',
        openDetail: false,
        detailData: {},

        openDetailModal(data) {
            this.detailData = data;
            this.openDetail = true;
        },

        resetPassword(id) {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Password mahasiswa akan direset menjadi NIM.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0058bc',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                background: '#ffffffee',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reset-form-' + id).submit();
                }
            })
        },

        toggleStatus(id, currentStatus) {
            let actionText = currentStatus === 'aktif' ? 'Nonaktifkan' : 'Aktifkan';
            let confirmColor = currentStatus === 'aktif' ? '#dc2626' : '#16a34a';
            
            Swal.fire({
                title: actionText + ' Akun?',
                text: currentStatus === 'aktif' ? 'Mahasiswa tidak dapat login sementara.' : 'Mahasiswa akan dapat login kembali.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, ' + actionText,
                cancelButtonText: 'Batal',
                background: '#ffffffee',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('toggle-form-' + id).submit();
                }
            })
        },

        applyFilter() {
            let url = new URL(window.location.href);
            url.searchParams.set('status', this.activeFilter);
            if(this.searchQuery) url.searchParams.set('search', this.searchQuery);
            else url.searchParams.delete('search');
            
            if(this.prodiId) url.searchParams.set('prodi_id', this.prodiId);
            else url.searchParams.delete('prodi_id');
            
            if(this.angkatanId) url.searchParams.set('angkatan', this.angkatanId);
            else url.searchParams.delete('angkatan');

            window.location.href = url.toString();
        }
    }"
>

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-[32px] font-bold tracking-tight text-slate-900">
                Akun Mahasiswa
            </h1>
            <p class="text-slate-500 mt-1">
                Kelola akun mahasiswa SIPESAN.
            </p>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        {{-- TOTAL --}}
        <div class="bg-white/55 backdrop-blur-xl border border-white/40 rounded-[28px] p-6 shadow-[0_10px_30px_rgba(0,112,235,0.08)]">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <div>
                    <p class="text-sm text-slate-400">Total Mahasiswa</p>
                    <h3 class="text-3xl font-medium text-slate-900">{{ collect($mahasiswa->items())->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- ADVANCED FILTER --}}
    <div class="bg-white/55 backdrop-blur-xl border border-white/40 rounded-[28px] px-6 py-5 mb-8 shadow-[0_10px_30px_rgba(0,112,235,0.08)]">
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm font-semibold text-slate-500">Status:</span>
                <button
                    @click="activeFilter = 'all'; applyFilter()"
                    :class="activeFilter === 'all' ? 'bg-blue-600 text-white' : 'bg-white/60 text-slate-600'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all"
                >Semua</button>
                <button
                    @click="activeFilter = 'aktif'; applyFilter()"
                    :class="activeFilter === 'aktif' ? 'bg-blue-600 text-white' : 'bg-white/60 text-slate-600'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all"
                >Aktif</button>
                <button
                    @click="activeFilter = 'nonaktif'; applyFilter()"
                    :class="activeFilter === 'nonaktif' ? 'bg-blue-600 text-white' : 'bg-white/60 text-slate-600'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all"
                >Nonaktif</button>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    @keydown.enter="applyFilter()"
                    placeholder="Cari nama atau NIM..."
                    class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-2 text-sm text-slate-600 focus:ring-2 focus:ring-blue-500"
                >
                {{-- PRODI --}}
                <select x-model="prodiId" @change="applyFilter()" class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-2 text-sm text-slate-600 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Prodi</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>

                {{-- ANGKATAN --}}
                <select x-model="angkatanId" @change="applyFilter()" class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-2 text-sm text-slate-600 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                    @endforeach
                </select>

                <span class="text-sm text-slate-400">{{ $mahasiswa->total() }} akun ditemukan</span>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="rounded-[28px] overflow-hidden bg-white/55 backdrop-blur-xl border border-white/40 shadow-[0_12px_40px_rgba(0,112,235,0.08)]">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-white/40 bg-white/20">
                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">Mahasiswa</th>
                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">NIM</th>
                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">Email</th>
                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">Prodi</th>
                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">Angkatan</th>
                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">Status</th>
                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/40">
                    @forelse($mahasiswa as $m)
                    <tr class="hover:bg-white/30 transition-colors">
                        <td class="p-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold bg-blue-100 text-blue-600">
                                    {{ strtoupper($m->user->inisial ?? 'M') }}
                                </div>
                                <div>
                                    <p class="text-[15px] font-semibold text-slate-800">{{ $m->user->name ?? '-' }}</p>
                                    <p class="text-sm text-slate-400">Mahasiswa</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-[15px] text-slate-700">{{ $m->user->nim ?? '-' }}</td>
                        <td class="p-6 text-[15px] text-slate-500">{{ $m->user->email ?? '-' }}</td>
                        <td class="p-6 text-[15px] text-slate-500">{{ $m->prodi->nama_prodi ?? '-' }}</td>
                        <td class="p-6 text-[15px] text-slate-500">{{ $m->angkatan ?? '-' }}</td>
                        <td class="p-6">
                            @if(($m->user->status ?? 'aktif') === 'aktif')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-medium bg-blue-100 text-blue-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2"></span>Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-medium bg-red-100 text-red-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2"></span>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="p-6">
                            <div class="flex items-center justify-center gap-2">
                                @php
                                    $detailData = [
                                        'id' => $m->id,
                                        'nama' => $m->user->name ?? '-',
                                        'nim' => $m->user->nim ?? '-',
                                        'email' => $m->user->email ?? '-',
                                        'angkatan' => $m->angkatan ?? '-',
                                        'prodi' => $m->prodi->nama_prodi ?? '-',
                                        'inisial' => strtoupper($m->user->inisial ?? 'M'),
                                        'status' => $m->user->status ?? 'aktif'
                                    ];
                                @endphp
                                <button
                                    @click="openDetailModal({{ Illuminate\Support\Js::from($detailData) }})"
                                    class="w-10 h-10 rounded-xl text-blue-600 hover:bg-blue-50 transition-colors flex items-center justify-center"
                                >
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>

                                <form id="reset-form-{{ $m->id }}" action="{{ route('admin.akun-mahasiswa.reset-password', $m->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>

                                <form id="toggle-form-{{ $m->id }}" action="{{ route('admin.akun-mahasiswa.toggle-status', $m->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500">Belum ada data mahasiswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($mahasiswa->hasPages())
        <div class="p-6 border-t border-white/40">
            {{ $mahasiswa->links() }}
        </div>
        @endif
    </div>

    {{-- MODAL DETAIL --}}
    <div x-show="openDetail" x-transition class="fixed inset-0 z-[999] flex items-center justify-center p-4" style="display:none;">
        <div @click="openDetail = false" class="absolute inset-0 bg-black/20 backdrop-blur-md"></div>
        <div class="relative z-[1000] w-full max-w-2xl rounded-[28px] bg-white/90 backdrop-blur-2xl border border-white/50 shadow-[0_24px_80px_rgba(0,112,235,0.18)] overflow-hidden">
            <div class="px-8 py-5 border-b border-white/40 flex items-center justify-between bg-white/30">
                <div>
                    <h2 class="text-[30px] font-bold tracking-tight text-slate-900">Detail Mahasiswa</h2>
                    <p class="text-sm text-blue-600 font-semibold mt-1" x-text="detailData.nim"></p>
                </div>
                <button @click="openDetail = false" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-400 hover:bg-white/50 hover:text-red-500 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-8 space-y-7">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-3xl font-black mb-4" x-text="detailData.inisial"></div>
                    <h3 class="text-xl font-bold text-slate-900" x-text="detailData.nama"></h3>
                    <p class="text-slate-500" x-text="detailData.prodi"></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-white/40 border border-white/50">
                        <p class="text-xs text-slate-400 mb-1">Email</p>
                        <p class="text-[15px] font-semibold text-slate-800" x-text="detailData.email"></p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/40 border border-white/50">
                        <p class="text-xs text-slate-400 mb-1">NIM</p>
                        <p class="text-[15px] font-semibold text-slate-800" x-text="detailData.nim"></p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/40 border border-white/50">
                        <p class="text-xs text-slate-400 mb-1">Angkatan</p>
                        <p class="text-[15px] font-semibold text-slate-800" x-text="detailData.angkatan"></p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/40 border border-white/50">
                        <p class="text-xs text-slate-400 mb-1">Status</p>
                        <p class="text-[15px] font-semibold text-slate-800">
                            <span x-show="detailData.status === 'aktif'" class="text-blue-600">Aktif</span>
                            <span x-show="detailData.status === 'nonaktif'" class="text-red-600">Nonaktif</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="px-8 py-5 border-t border-white/40 bg-white/20 flex items-center justify-between">
                <button
                    @click="toggleStatus(detailData.id, detailData.status)"
                    :class="detailData.status === 'aktif' ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-green-100 text-green-600 hover:bg-green-200'"
                    class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all"
                >
                    <span x-text="detailData.status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'"></span>
                </button>
                <div class="flex items-center gap-3">
                    <button @click="resetPassword(detailData.id)" class="px-6 py-2.5 rounded-full text-sm font-semibold bg-white/70 text-slate-700 hover:bg-white transition-all border border-white/50">
                        Reset Password
                    </button>
                    <button @click="openDetail = false" class="px-6 py-2.5 rounded-full text-sm font-semibold bg-blue-600 text-white hover:brightness-110 transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection