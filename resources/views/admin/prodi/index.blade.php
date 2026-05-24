@extends('layouts.admin')

@section('title', 'Manajemen Prodi')

@section('content')

<main
    class="ml-0 md:ml-64 min-h-screen flex flex-col pt-20"
    x-data="{
        openModal: false,
        deleteModal: false,

        activeFilter: 'Semua'
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
                @click="openModal = true"
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
                        6
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
                        5
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
                        2.450
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
                        3
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

                        {{-- ROW --}}
                        <tr class="hover:bg-[#F8FAFC] transition">

                            <td class="px-5 py-5">
                                <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold">
                                    TIF
                                </span>
                            </td>

                            <td class="px-5 py-5">

                                <h3 class="font-semibold text-slate-800">
                                    Teknik Informatika
                                </h3>

                                <p class="text-xs text-slate-500 mt-1">
                                    Pengembangan perangkat lunak dan sistem komputer.
                                </p>

                            </td>

                            <td class="px-5 py-5">

                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">
                                    S1
                                </span>

                            </td>

                            <td class="px-5 py-5">

                                <span class="inline-flex items-center gap-1 px-3 py-1
                                    rounded-full bg-blue-50 text-blue-600 text-xs font-bold">

                                    <span class="material-symbols-outlined text-[14px]">
                                        workspace_premium
                                    </span>

                                    A
                                </span>

                            </td>

                            <td class="px-5 py-5 text-sm text-slate-600">
                                Dr. Budi Santoso, M.Kom
                            </td>

                            <td class="px-5 py-5">

                                <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">

                                    <span class="material-symbols-outlined text-[16px] text-slate-400">
                                        groups
                                    </span>

                                    620
                                </div>

                            </td>

                            <td class="px-5 py-5">

                                <span class="inline-flex items-center gap-2 px-3 py-1
                                    rounded-full bg-green-50 text-green-600 text-xs font-semibold">

                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                    Aktif
                                </span>

                            </td>

                            <td class="px-5 py-5">

                                <div class="flex items-center justify-center gap-1">

                                    <button
                                        @click="openModal = true"
                                        class="w-9 h-9 rounded-xl flex items-center justify-center
                                        text-blue-600 hover:bg-blue-50 transition"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">
                                            edit
                                        </span>
                                    </button>

                                    <button
                                        @click="deleteModal = true"
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

        <div
            @click.outside="openModal = false"
            class="w-full max-w-2xl rounded-[32px] bg-white
            shadow-2xl overflow-hidden"
        >

            {{-- HEADER --}}
            <div class="px-8 py-6 border-b border-[#E2E8F0]
                flex items-center justify-between">

                <div>

                    <h2 class="text-[30px] font-bold text-slate-800">
                        Tambah Program Studi
                    </h2>

                    <p class="text-slate-500 mt-1">
                        Isi semua data yang diperlukan
                    </p>

                </div>

                <button
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
                            placeholder="TIF"
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Jenjang
                        </label>

                        <select
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                            <option>S1</option>
                            <option>D3</option>
                            <option>D4</option>
                            <option>S2</option>
                        </select>
                    </div>

                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Nama Program Studi
                    </label>

                    <input
                        type="text"
                        placeholder="Teknik Informatika"
                        class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                        px-5 focus:border-blue-500 focus:ring-0"
                    >
                </div>

                <div>

                </div>

                <div class="grid grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Ketua Prodi
                        </label>

                        <input
                            type="text"
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
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                        </select>
                    </div>

                </div>

                {{-- TAHUN BERDIRI + JUMLAH MAHASISWA --}}
                <div class="grid grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Tahun Berdiri
                        </label>

                        <input
                            type="number"
                            placeholder="2002"
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Jumlah Mahasiswa
                        </label>

                        <input
                            type="number"
                            placeholder="620"
                            class="w-full h-[54px] rounded-2xl border border-[#E2E8F0]
                            px-5 focus:border-blue-500 focus:ring-0"
                        >
                    </div>

                </div>

                {{-- DESKRIPSI --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Deskripsi Singkat
                    </label>

                    <textarea
                        rows="4"
                        placeholder="Deskripsi singkat program studi..."
                        class="w-full rounded-2xl border border-[#E2E8F0]
                        px-5 py-4 resize-none focus:border-blue-500 focus:ring-0"
                    ></textarea>

                </div>

                {{-- STATUS --}}
                <div>

                    <label class="block mb-3 text-sm font-semibold text-slate-700">
                        Status
                    </label>

                    <div class="flex items-center gap-6">

                        {{-- AKTIF --}}
                        <label class="flex items-center gap-3 cursor-pointer">

                            <input
                                type="radio"
                                name="status"
                                checked
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

            {{-- FOOTER --}}
            <div class="px-8 py-5 border-t border-[#E2E8F0]
                flex justify-end gap-3">

                <button
                    @click="openModal = false"
                    class="px-6 py-3 rounded-full bg-slate-100
                    text-slate-700 font-semibold hover:bg-slate-200 transition"
                >
                    Batal
                </button>

                <button
                    @click="
                        openModal = false;

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data program studi berhasil disimpan.',
                            confirmButtonColor: '#2563EB',
                            confirmButtonText: 'Oke'
                        })
                    "
                    class="px-7 py-3 rounded-full bg-blue-600 text-white
                    font-semibold shadow-lg hover:bg-blue-700 transition"
                >
                    Simpan Data
                </button>

            </div>

        </div>

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
                    @click="deleteModal = false"
                    class="flex-1 h-[52px] rounded-full bg-slate-100
                    font-semibold text-slate-700"
                >
                    Batal
                </button>

                <button
                    @click="
                        deleteModal = false;

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data program studi berhasil dihapus.',
                            confirmButtonColor: '#DC2626',
                            confirmButtonText: 'Oke'
                        })
                    "
                    class="flex-1 h-[52px] rounded-full bg-red-500
                    text-white font-semibold"
                >
                    Ya, Hapus
                </button>

            </div>

        </div>

    </div>

</main>

@endsection