@extends('layouts.admin')

@section('title', 'Akun Mahasiswa')

@section('content')

@php
$students = [
    [
        'name' => 'Ahmad Sulaiman',
        'nim' => '20210101001',
        'email' => 'ahmad@student.ac.id',
        'prodi' => 'Teknik Informatika',
        'angkatan' => '2021',
        'status' => 'aktif',
        'initial' => 'AS',
        'avatar' => 'bg-blue-100 text-blue-600',
    ],
    [
        'name' => 'Budi Wijaya',
        'nim' => '20210101002',
        'email' => 'budi@student.ac.id',
        'prodi' => 'Sistem Informasi',
        'angkatan' => '2021',
        'status' => 'nonaktif',
        'initial' => 'BW',
        'avatar' => 'bg-red-100 text-red-600',
    ],
    [
        'name' => 'Citra Dewi',
        'nim' => '20220101003',
        'email' => 'citra@student.ac.id',
        'prodi' => 'Teknik Informatika',
        'angkatan' => '2022',
        'status' => 'aktif',
        'initial' => 'CD',
        'avatar' => 'bg-violet-100 text-violet-600',
    ],
];
@endphp

<main
    class="md:ml-64 pt-24 px-6 pb-12 relative z-10"
    x-data="{
        activeFilter: 'all',
        searchQuery: '',
        openDetail: false,

        resetPassword() {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Password mahasiswa akan direset.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0058bc',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                background: '#ffffffee',
            })
        },

        suspendAccount() {
            Swal.fire({
                title: 'Nonaktifkan Akun?',
                text: 'Mahasiswa tidak dapat login sementara.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Nonaktifkan',
                cancelButtonText: 'Batal',
                background: '#ffffffee',
            })
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

                <span class="material-symbols-outlined">
                    groups
                </span>

            </div>

            <div>

                <p class="text-sm text-slate-400">
                    Total Mahasiswa
                </p>

                <h3 class="text-3xl font-medium text-slate-900">
                    8
                </h3>

            </div>

        </div>

    </div>

    {{-- AKTIF --}}
    <div class="bg-white/55 backdrop-blur-xl border border-white/40 rounded-[28px] p-6 shadow-[0_10px_30px_rgba(0,112,235,0.08)]">

        <div class="flex items-center gap-4">

            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-600">

                <span class="material-symbols-outlined">
                    check_circle
                </span>

            </div>

            <div>

                <p class="text-sm text-slate-400">
                    Aktif
                </p>

                <h3 class="text-3xl font-medium text-slate-900">
                    6
                </h3>

            </div>

        </div>

    </div>

    {{-- NONAKTIF --}}
    <div class="bg-white/55 backdrop-blur-xl border border-white/40 rounded-[28px] p-6 shadow-[0_10px_30px_rgba(0,112,235,0.08)]">

        <div class="flex items-center gap-4">

            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-red-600">

                <span class="material-symbols-outlined">
                    block
                </span>

            </div>

            <div>

                <p class="text-sm text-slate-400">
                    Dinonaktifkan
                </p>

                <h3 class="text-3xl font-medium text-slate-900">
                    2
                </h3>

            </div>

        </div>

    </div>

    {{-- BULAN INI --}}
    <div class="bg-white/55 backdrop-blur-xl border border-white/40 rounded-[28px] p-6 shadow-[0_10px_30px_rgba(0,112,235,0.08)]">

        <div class="flex items-center gap-4">

            <div class="w-14 h-14 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-600">

                <span class="material-symbols-outlined">
                    person_add
                </span>

            </div>

            <div>

                <p class="text-sm text-slate-400">
                    Baru Bulan Ini
                </p>

                <h3 class="text-3xl font-medium text-slate-900">
                    0
                </h3>

            </div>

        </div>

    </div>

</div>

    {{-- ADVANCED FILTER --}}
<div class="bg-white/55 backdrop-blur-xl border border-white/40 rounded-[28px] px-6 py-5 mb-8 shadow-[0_10px_30px_rgba(0,112,235,0.08)]">

    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">

        <div class="flex flex-wrap items-center gap-3">

            <span class="text-sm font-semibold text-slate-500">
                Status:
            </span>

            <button
                @click="activeFilter = 'all'"
                :class="activeFilter === 'all'
                    ? 'bg-blue-600 text-white'
                    : 'bg-white/60 text-slate-600'"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all"
            >
                Semua
            </button>

            <button
                @click="activeFilter = 'aktif'"
                :class="activeFilter === 'aktif'
                    ? 'bg-blue-600 text-white'
                    : 'bg-white/60 text-slate-600'"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all"
            >
                Aktif
            </button>

            <button
                @click="activeFilter = 'nonaktif'"
                :class="activeFilter === 'nonaktif'
                    ? 'bg-blue-600 text-white'
                    : 'bg-white/60 text-slate-600'"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all"
            >
                Nonaktif
            </button>

        </div>

        <div class="flex flex-wrap items-center gap-4">

            {{-- PRODI --}}
            <select class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-2 text-sm text-slate-600 focus:ring-2 focus:ring-blue-500">

                <option>Semua Prodi</option>
                <option>Teknik Informatika</option>
                <option>Sistem Informasi</option>

            </select>

            {{-- ANGKATAN --}}
            <select class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-2 text-sm text-slate-600 focus:ring-2 focus:ring-blue-500">

                <option>Semua</option>
                <option>2021</option>
                <option>2022</option>

            </select>

            <span class="text-sm text-slate-400">
                8 akun ditemukan
            </span>

        </div>

    </div>

</div>

    {{-- TABLE --}}
    <div class="rounded-[28px] overflow-hidden bg-white/55 backdrop-blur-xl border border-white/40 shadow-[0_12px_40px_rgba(0,112,235,0.08)]">

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>

                    <tr class="border-b border-white/40 bg-white/20">

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Mahasiswa
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            NIM
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Email
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Prodi
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Angkatan
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

                    @foreach($students as $student)

                    <tr
                        x-show="
                            (activeFilter === 'all' || activeFilter === '{{ $student['status'] }}')
                            &&
                            (
                                '{{ strtolower($student['name']) }}'.includes(searchQuery.toLowerCase())
                                ||
                                '{{ strtolower($student['nim']) }}'.includes(searchQuery.toLowerCase())
                            )
                        "
                        class="hover:bg-white/30 transition-colors"
                    >

                        {{-- MAHASISWA --}}
                        <td class="p-6">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold {{ $student['avatar'] }}">
                                    {{ $student['initial'] }}
                                </div>

                                <div>

                                    <p class="text-[15px] font-semibold text-slate-800">
                                        {{ $student['name'] }}
                                    </p>

                                    <p class="text-sm text-slate-400">
                                        Mahasiswa
                                    </p>

                                </div>

                            </div>

                        </td>

                        {{-- NIM --}}
                        <td class="p-6 text-[15px] text-slate-700">
                            {{ $student['nim'] }}
                        </td>

                        {{-- EMAIL --}}
                        <td class="p-6 text-[15px] text-slate-500">
                            {{ $student['email'] }}
                        </td>

                        {{-- PRODI --}}
                        <td class="p-6 text-[15px] text-slate-500">
                            {{ $student['prodi'] }}
                        </td>

                        {{-- ANGKATAN --}}
                        <td class="p-6 text-[15px] text-slate-500">
                            {{ $student['angkatan'] }}
                        </td>

                        {{-- STATUS --}}
                        <td class="p-6">

                            @if($student['status'] === 'aktif')

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-medium bg-blue-100 text-blue-600">

                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2"></span>

                                    Aktif

                                </span>

                            @else

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-medium bg-red-100 text-red-600">

                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2"></span>

                                    Nonaktif

                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="p-6">

                            <div class="flex items-center justify-center gap-2">

                                <button
                                    @click="openDetail = true"
                                    class="w-10 h-10 rounded-xl text-blue-600 hover:bg-blue-50 transition-colors flex items-center justify-center"
                                >

                                    <span class="material-symbols-outlined">
                                        visibility
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

    {{-- MODAL DETAIL --}}
    <div
        x-show="openDetail"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center p-4"
        style="display:none;"
    >

        {{-- BACKDROP --}}
        <div
            @click="openDetail = false"
            class="absolute inset-0 bg-black/20 backdrop-blur-md"
        ></div>

        {{-- MODAL --}}
        <div class="relative z-[1000] w-full max-w-2xl rounded-[28px] bg-white/90 backdrop-blur-2xl border border-white/50 shadow-[0_24px_80px_rgba(0,112,235,0.18)] overflow-hidden">

            {{-- HEADER --}}
            <div class="px-8 py-5 border-b border-white/40 flex items-center justify-between bg-white/30">

                <div>

                    <h2 class="text-[30px] font-bold tracking-tight text-slate-900">
                        Detail Mahasiswa
                    </h2>

                    <p class="text-sm text-blue-600 font-semibold mt-1">
                        20210101001
                    </p>

                </div>

                <button
                    @click="openDetail = false"
                    class="w-10 h-10 rounded-full flex items-center justify-center text-slate-400 hover:bg-white/50 hover:text-red-500 transition-colors"
                >

                    <span class="material-symbols-outlined">
                        close
                    </span>

                </button>

            </div>

            {{-- BODY --}}
            <div class="p-8 space-y-7">

                {{-- PROFILE --}}
                <div class="flex flex-col items-center text-center">

                    <div class="w-24 h-24 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-3xl font-black mb-4">
                        AS
                    </div>

                    <h3 class="text-xl font-bold text-slate-900">
                        Ahmad Sulaiman
                    </h3>

                    <p class="text-slate-500">
                        Teknik Informatika
                    </p>

                </div>

                {{-- INFO --}}
                <div class="grid grid-cols-2 gap-4">

                    @php
                        $details = [
                            ['Email', 'ahmad@student.ac.id'],
                            ['NIM', '20210101001'],
                            ['Angkatan', '2021'],
                            ['Status', 'Aktif'],
                        ];
                    @endphp

                    @foreach($details as [$label, $value])

                    <div class="p-4 rounded-2xl bg-white/40 border border-white/50">

                        <p class="text-xs text-slate-400 mb-1">
                            {{ $label }}
                        </p>

                        <p class="text-[15px] font-semibold text-slate-800">
                            {{ $value }}
                        </p>

                    </div>

                    @endforeach

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="px-8 py-5 border-t border-white/40 bg-white/20 flex items-center justify-between">

                <button
                    @click="suspendAccount()"
                    class="px-6 py-2.5 rounded-full text-sm font-semibold bg-red-100 text-red-600 hover:bg-red-200 transition-all"
                >
                    Nonaktifkan
                </button>

                <div class="flex items-center gap-3">

                    <button
                        @click="resetPassword()"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold bg-white/70 text-slate-700 hover:bg-white transition-all border border-white/50"
                    >
                        Reset Password
                    </button>

                    <button
                        @click="openDetail = false"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold bg-blue-600 text-white hover:brightness-110 transition-all"
                    >
                        Tutup
                    </button>

                </div>

            </div>

        </div>

    </div>

</main>

@endsection