@extends('layouts.admin')

@section('title', 'Manajemen Prodi')

@section('content')

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

<main
    class="ml-0 md:ml-64 min-h-screen flex flex-col pt-20"
    x-data="{
        openModal: false,
        deleteModal: false,
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

        deleteUrl: '',
        confirmDelete(id) {
            this.deleteUrl = '{{ url('/admin/prodi') }}/' + id;
            this.deleteModal = true;
        }
    }"
>

    <div class="flex-1 px-6 lg:px-10 pb-12 w-full max-w-[1400px] mx-auto space-y-7">

        {{-- PAGE HEADER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

            <div>
                <h1 class="font-h2 text-h2 text-on-surface">
                    Manajemen Prodi
                </h1>

                <p class="text-on-surface-variant mt-1">
                    Kelola data program studi yang terdaftar di sistem.
                </p>
            </div>

            <button
                @click="addProdi()"
                class="flex items-center gap-2 bg-primary text-white hover:bg-blue-700
                px-6 py-3 rounded-full shadow-lg transition-all duration-300
                text-sm font-semibold"
            >
                <span class="material-symbols-outlined text-[20px]">
                    add
                </span>

                Tambah Prodi
            </button>

        </div>

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

            {{-- CARD --}}
            <div class="glass-panel rounded-[24px] p-5 flex items-center gap-4">

                <div class="w-12 h-12 rounded-2xl bg-blue-100
                    flex items-center justify-center text-blue-600 shrink-0">

                    <span class="material-symbols-outlined">
                        school
                    </span>
                </div>

                <div>
                    <p class="text-xs text-slate-500 font-medium">
                        Total Prodi
                    </p>

                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ $totalProdi }}
                    </h3>
                </div>
            </div>

            {{-- CARD --}}
            <div class="glass-panel rounded-[24px] p-5 flex items-center gap-4">

                <div class="w-12 h-12 rounded-2xl bg-green-100
                    flex items-center justify-center text-green-600 shrink-0">

                    <span class="material-symbols-outlined">
                        check_circle
                    </span>
                </div>

                <div>
                    <p class="text-xs text-slate-500 font-medium">
                        Aktif
                    </p>

                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ $totalAktif }}
                    </h3>
                </div>
            </div>

            {{-- CARD --}}
            <div class="glass-panel rounded-[24px] p-5 flex items-center gap-4">

                <div class="w-12 h-12 rounded-2xl bg-violet-100
                    flex items-center justify-center text-violet-600 shrink-0">

                    <span class="material-symbols-outlined">
                        groups
                    </span>
                </div>

                <div>
                    <p class="text-xs text-slate-500 font-medium">
                        Mahasiswa
                    </p>

                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ number_format($totalMahasiswa, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            {{-- CARD --}}
            <div class="glass-panel rounded-[24px] p-5 flex items-center gap-4">

                <div class="w-12 h-12 rounded-2xl bg-amber-100
                    flex items-center justify-center text-amber-600 shrink-0">

                    <span class="material-symbols-outlined">
                        workspace_premium
                    </span>
                </div>

                <div>
                    <p class="text-xs text-slate-500 font-medium">
                        Akreditasi A
                    </p>

                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ $totalAkreditasiA }}
                    </h3>
                </div>
            </div>

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

            {{-- FILTER BUTTON --}}
            <div class="flex items-center gap-2 flex-wrap">

                <button
                    @click="activeFilter = 'Semua'"
                    :class="activeFilter === 'Semua'
                        ? 'bg-blue-600 text-white'
                        : 'glass-panel text-slate-600'"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition"
                >
                    Semua
                </button>

                <button
                    @click="activeFilter = 'S1'"
                    :class="activeFilter === 'S1'
                        ? 'bg-blue-600 text-white'
                        : 'glass-panel text-slate-600'"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition"
                >
                    S1
                </button>

                <button
                    @click="activeFilter = 'D3'"
                    :class="activeFilter === 'D3'
                        ? 'bg-blue-600 text-white'
                        : 'glass-panel text-slate-600'"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition"
                >
                    D3
                </button>

                <button 
                @click="activeFilter = 'D4'"
                :class="activeFilter === 'D4'
                        ? 'bg-blue-600 text-white'
                        : 'glass-panel text-slate-600'"
                class="px-4 py-2 rounded-full text-xs font-semibold transition">
                    D4
                </button>

                <button
                    @click="activeFilter = 'S2'"
                    :class="activeFilter === 'S2'
                        ? 'bg-blue-600 text-white'
                        : 'glass-panel text-slate-600'"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition"
                >
                    S2
                </button>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="glass-panel rounded-[28px] overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">

                    {{-- HEAD --}}
                    <thead>

                        <tr class="bg-[#F8FAFC] border-b border-[#E2E8F0]">

                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">
                                Kode
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">
                                Program Studi
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">
                                Jenjang
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">
                                Akreditasi
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">
                                Ketua Prodi
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">
                                Mahasiswa
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-semibold text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-4 text-center text-sm font-semibold text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    {{-- BODY --}}
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

                                <h3 class="font-semibold text-slate-800">
                                    {{ $prodi->nama_prodi }}
                                </h3>

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $prodi->deskripsi ?: 'Tidak ada deskripsi singkat.' }}
                                </p>

                            </td>

                            <td class="px-5 py-5">

                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">
                                    {{ $prodi->jenjang }}
                                </span>

                            </td>

                            <td class="px-5 py-5">

                                <span class="inline-flex items-center gap-1 px-3 py-1
                                    rounded-full bg-blue-50 text-blue-600 text-xs font-bold">

                                    <span class="material-symbols-outlined text-[14px]">
                                        workspace_premium
                                    </span>

                                    {{ $prodi->akreditasi }}
                                </span>

                            </td>

                            <td class="px-5 py-5 text-sm text-slate-600">
                                {{ $prodi->ketua_prodi ?: '-' }}
                            </td>

                            <td class="px-5 py-5">

                                <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">

                                    <span class="material-symbols-outlined text-[16px] text-slate-400">
                                        groups
                                    </span>

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
                                        class="w-9 h-9 rounded-xl flex items-center justify-center
                                        text-blue-600 hover:bg-blue-50 transition"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">
                                            edit
                                        </span>
                                    </button>

                                    <button
                                        @click="confirmDelete({{ $prodi->id }})"
                                        class="w-9 h-9 rounded-xl flex items-center justify-center
                                        text-red-500 hover:bg-red-50 transition"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">
                                            delete
                                        </span>
                                    </button>

                                </div>

                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-[48px]">
                                        inbox
                                    </span>
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

    {{-- MODAL FORM --}}
    <div
        x-show="openModal"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center
        bg-black/30 backdrop-blur-sm p-4"
        style="display: none;"
    >

        <form
            :action="actionUrl"
            method="POST"
            @click.outside="openModal = false"
            class="w-full max-w-2xl rounded-[32px] bg-white
            shadow-2xl overflow-hidden"
        >
            @csrf
            <template x-if="isEdit">
                <input type="hidden" name="_method" value="PUT">
            </template>

            {{-- HEADER --}}
            <div class="px-8 py-6 border-b border-[#E2E8F0]
                flex items-center justify-between">

                <div>

                    <h2 class="text-[30px] font-bold text-slate-800" x-text="isEdit ? 'Edit Program Studi' : 'Tambah Program Studi'">
                        Tambah Program Studi
                    </h2>

                    <p class="text-slate-500 mt-1">
                        Isi semua data yang diperlukan
                    </p>

                </div>

                <button
                    type="button"
                    @click="openModal = false"
                    class="w-10 h-10 rounded-full hover:bg-slate-100
                    flex items-center justify-center transition"
                >
                    <span class="material-symbols-outlined text-slate-500">
                        close
                    </span>
                </button>

            </div>

            {{-- BODY --}}
            <div class="p-8 space-y-5 max-h-[70vh] overflow-y-auto">

                <div class="grid grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Kode Prodi
                        </label>

                        <input
                            type="text"
                            name="kode_prodi"
                            x-model="formData.kode_prodi"
                            placeholder="TIF"
                            required
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Jenjang
                        </label>

                        <select
                            name="jenjang"
                            x-model="formData.jenjang"
                            required
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                            <option value="S1">S1</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S2">S2</option>
                        </select>
                    </div>

                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Nama Program Studi
                    </label>

                    <input
                        type="text"
                        name="nama_prodi"
                        x-model="formData.nama_prodi"
                        placeholder="Teknik Informatika"
                        required
                        class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                        px-5 focus:border-blue-500 focus:ring-0"
                    >
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Fakultas
                    </label>

                    <input
                        type="text"
                        name="fakultas"
                        x-model="formData.fakultas"
                        placeholder="Fakultas Teknik"
                        required
                        class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                        px-5 focus:border-blue-500 focus:ring-0"
                    >
                </div>

                <div class="grid grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Ketua Prodi
                        </label>

                        <input
                            type="text"
                            name="ketua_prodi"
                            x-model="formData.ketua_prodi"
                            placeholder="Nama Ketua Prodi"
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Akreditasi
                        </label>

                        <select
                            name="akreditasi"
                            x-model="formData.akreditasi"
                            required
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>

                </div>

                {{-- TAHUN BERDIRI --}}
                <div class="grid grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Tahun Berdiri
                        </label>

                        <input
                            type="number"
                            name="tahun_berdiri"
                            x-model="formData.tahun_berdiri"
                            placeholder="2002"
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Status
                        </label>

                        <div class="flex items-center gap-6 mt-3">

                            {{-- AKTIF --}}
                            <label class="flex items-center gap-3 cursor-pointer">

                                <input
                                    type="radio"
                                    name="status"
                                    value="aktif"
                                    x-model="formData.status"
                                    class="w-4 h-4 text-blue-600 border-[#CBD5E1]
                                    focus:ring-blue-500"
                                >

                                <span class="text-sm font-medium text-slate-700">
                                    Aktif
                                </span>

                            </label>

                            {{-- NON AKTIF --}}
                            <label class="flex items-center gap-3 cursor-pointer">

                                <input
                                    type="radio"
                                    name="status"
                                    value="nonaktif"
                                    x-model="formData.status"
                                    class="w-4 h-4 text-blue-600 border-[#CBD5E1]
                                    focus:ring-blue-500"
                                >

                                <span class="text-sm font-medium text-slate-700">
                                    Non Aktif
                                </span>

                            </label>

                        </div>
                    </div>

                </div>

                {{-- DESKRIPSI --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Deskripsi Singkat
                    </label>

                    <textarea
                        name="deskripsi"
                        x-model="formData.deskripsi"
                        rows="4"
                        placeholder="Deskripsi singkat program studi..."
                        class="w-full rounded-2xl border border-[#E2E8F0]
                        px-5 py-4 resize-none focus:border-blue-500 focus:ring-0"
                    ></textarea>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="px-8 py-5 border-t border-[#E2E8F0]
                flex justify-end gap-3">

                <button
                    type="button"
                    @click="openModal = false"
                    class="px-6 py-3 rounded-full bg-slate-100
                    text-slate-700 font-semibold hover:bg-slate-200 transition"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-7 py-3 rounded-full bg-blue-600 text-white
                    font-semibold shadow-lg hover:bg-blue-700 transition"
                >
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

    {{-- DELETE MODAL --}}
    <div
        x-show="deleteModal"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center
        bg-black/30 backdrop-blur-sm p-4"
        style="display: none;"
    >

        <div
            @click.outside="deleteModal = false"
            class="w-full max-w-md rounded-[32px] bg-white p-8 shadow-2xl"
        >

            <div class="flex flex-col items-center text-center">

                <div class="w-16 h-16 rounded-2xl bg-red-100
                    flex items-center justify-center text-red-500">

                    <span class="material-symbols-outlined text-[34px]">
                        delete_forever
                    </span>
                </div>

                <h2 class="mt-5 text-[28px] font-bold text-slate-800">
                    Hapus Prodi?
                </h2>

                <p class="mt-2 text-slate-500">
                    Data program studi akan dihapus permanen dan tidak dapat dikembalikan.
                </p>

            </div>

            <div class="mt-8 flex gap-3">

                <button
                    type="button"
                    @click="deleteModal = false"
                    class="flex-1 h-[52px] rounded-full bg-slate-100
                    font-semibold text-slate-700"
                >
                    Batal
                </button>

                <button
                    type="button"
                    @click="
                        document.getElementById('delete-form').submit();
                        deleteModal = false;
                    "
                    class="flex-1 h-[52px] rounded-full bg-red-500
                    text-white font-semibold"
                >
                    Ya, Hapus
                </button>

            </div>

        </div>

    </div>

    {{-- HIDDEN DELETE FORM --}}
    <form id="delete-form" :action="deleteUrl" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

</main>

@endsection