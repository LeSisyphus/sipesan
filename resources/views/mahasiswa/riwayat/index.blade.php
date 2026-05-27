@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pengajuan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <section class="glass-panel rounded-[28px] p-8">

        <h1 class="text-4xl font-black text-on-surface">
            Riwayat Pengajuan
        </h1>

        <p class="mt-3 text-on-surface-variant text-lg">
            Daftar seluruh pengajuan dokumen Anda.
        </p>

    </section>

    {{-- TABLE --}}
    <section class="glass-panel rounded-[28px] overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="text-left px-6 py-4 font-bold">
                            Jenis Surat
                        </th>

                        <th class="text-left px-6 py-4 font-bold">
                            Tanggal
                        </th>

                        <th class="text-left px-6 py-4 font-bold">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr class="border-t">

                        <td class="px-6 py-5">
                            Surat Aktif Kuliah
                        </td>

                        <td class="px-6 py-5">
                            12 Oktober 2023
                        </td>

                        <td class="px-6 py-5">

                            <span class="px-4 py-2 rounded-full
                            bg-blue-100 text-blue-700 text-sm font-semibold">

                                Selesai

                            </span>

                        </td>

                    </tr>

                    <tr class="border-t">

                        <td class="px-6 py-5">
                            Transkrip Nilai
                        </td>

                        <td class="px-6 py-5">
                            10 Oktober 2023
                        </td>

                        <td class="px-6 py-5">

                            <span class="px-4 py-2 rounded-full
                            bg-yellow-100 text-yellow-700 text-sm font-semibold">

                                Diproses

                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </section>

</div>

@endsection