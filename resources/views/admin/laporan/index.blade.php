@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')

{{-- SweetAlert Flash Message & Validation Errors --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0058bc',
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
            confirmButtonColor: '#dc2626',
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
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Oke'
        });
    });
</script>
@endif

<script>
    window.laporanData = {
        periode: @json($from_date && $to_date ? '' : $periode),
        chartDataBulanan: @json($chartDataBulanan),
        chartDataMingguan: @json($chartDataMingguan),
        csvContent: @json($csvContent)
    };
</script>

<main
    class="ml-0 md:ml-64 min-h-screen flex flex-col pt-24"
    x-data="{
    activePeriod: window.laporanData.periode,
    chartMode: 'bulanan',
    chartDataBulanan: window.laporanData.chartDataBulanan,
    chartDataMingguan: window.laporanData.chartDataMingguan,

    exportPDF() {
        window.print()
    },

    printReport() {
        window.print()
    },

    exportExcel() {
        const csvContent = window.laporanData.csvContent;

        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        })

        const link = document.createElement('a')

        link.href = URL.createObjectURL(blob)
        link.download = 'laporan-sipesan.csv'

        link.click()
    }
}"
>

    <div class="flex-1 px-6 lg:px-10 pb-12 w-full max-w-[1400px] mx-auto space-y-7">

        {{-- PAGE HEADER --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-5">

            <div>
                <h1 class="font-h2 text-h2 text-on-surface">
                    Laporan & Statistik
                </h1>

                <p class="text-on-surface-variant mt-1">
                    Pantau performa pengajuan dokumen mahasiswa secara menyeluruh.
                </p>
            </div>

            {{-- EXPORT BUTTON --}}
            <div class="flex flex-wrap items-center gap-2">

                <button
                    @click="exportPDF()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full
                    glass-panel hover:bg-white/80 transition-all
                    text-sm font-semibold text-slate-700"
                >
                    <span class="material-symbols-outlined text-[18px] text-red-500">
                        picture_as_pdf
                    </span>

                    PDF
                </button>

                <button
                    @click="exportExcel()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full
                    glass-panel hover:bg-white/80 transition-all
                    text-sm font-semibold text-slate-700"
                >
                    <span class="material-symbols-outlined text-[18px] text-blue-600">
                        table_view
                    </span>

                    CSV
                </button>

                <button
                    @click="printReport()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full
                    bg-primary text-white shadow-lg shadow-primary/20
                    hover:brightness-110 transition-all
                    text-sm font-semibold"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        print
                    </span>

                    Cetak
                </button>

            </div>

        </div>

        <form id="filterForm" method="GET" action="{{ route('admin.laporan.index') }}" class="w-full">
            <input type="hidden" name="periode" :value="activePeriod">
            
            <div class="glass-panel rounded-[24px] p-4 flex flex-wrap xl:flex-nowrap items-end gap-5">

                {{-- PERIODE --}}
                <div class="space-y-2">

                    <label class="text-xs font-semibold text-slate-500">
                        Periode
                    </label>

                    <div class="flex flex-wrap gap-2">

                        {{-- 7 HARI --}}
                        <button
                            type="button"
                            @click="activePeriod = '7 Hari'; document.getElementsByName('from_date')[0].value = ''; document.getElementsByName('to_date')[0].value = ''; $nextTick(() => document.getElementById('filterForm').submit())"
                            :class="activePeriod === '7 Hari'
                                ? 'bg-blue-600 text-white'
                                : 'glass-panel text-slate-600'"
                            class="px-4 py-2 rounded-full text-xs font-semibold transition"
                        >
                            7 Hari
                        </button>

                        {{-- 30 HARI --}}
                        <button
                            type="button"
                            @click="activePeriod = '30 Hari'; document.getElementsByName('from_date')[0].value = ''; document.getElementsByName('to_date')[0].value = ''; $nextTick(() => document.getElementById('filterForm').submit())"
                            :class="activePeriod === '30 Hari'
                                ? 'bg-blue-600 text-white'
                                : 'glass-panel text-slate-600'"
                            class="px-4 py-2 rounded-full text-xs font-semibold transition"
                        >
                            30 Hari
                        </button>

                        {{-- 3 BULAN --}}
                        <button
                            type="button"
                            @click="activePeriod = '3 Bulan'; document.getElementsByName('from_date')[0].value = ''; document.getElementsByName('to_date')[0].value = ''; $nextTick(() => document.getElementById('filterForm').submit())"
                            :class="activePeriod === '3 Bulan'
                                ? 'bg-blue-600 text-white'
                                : 'glass-panel text-slate-600'"
                            class="px-4 py-2 rounded-full text-xs font-semibold transition"
                        >
                            3 Bulan
                        </button>

                        {{-- 1 TAHUN --}}
                        <button
                            type="button"
                            @click="activePeriod = '1 Tahun'; document.getElementsByName('from_date')[0].value = ''; document.getElementsByName('to_date')[0].value = ''; $nextTick(() => document.getElementById('filterForm').submit())"
                            :class="activePeriod === '1 Tahun'
                                ? 'bg-blue-600 text-white'
                                : 'glass-panel text-slate-600'"
                            class="px-4 py-2 rounded-full text-xs font-semibold transition"
                        >
                            1 Tahun
                        </button>

                    </div>

                </div>

                {{-- DATE --}}
                <div class="space-y-2">

                    <label class="text-xs font-semibold text-slate-500">
                        Dari Tanggal
                    </label>

                    <input
                        type="date"
                        name="from_date"
                        value="{{ $from_date }}"
                        onchange="this.form.submit()"
                        class="glass-input rounded-xl px-4 py-2 text-sm"
                    >

                </div>

                <div class="space-y-2">

                    <label class="text-xs font-semibold text-slate-500">
                        Sampai Tanggal
                    </label>

                    <input
                        type="date"
                        name="to_date"
                        value="{{ $to_date }}"
                        onchange="this.form.submit()"
                        class="glass-input rounded-xl px-4 py-2 text-sm"
                    >

                </div>

                {{-- PRODI --}}
                <div class="space-y-2 min-w-[240px]">

                    <label class="text-xs font-semibold text-slate-500">
                        Program Studi
                    </label>

                    <select
                        name="prodi_id"
                        onchange="this.form.submit()"
                        class="glass-input rounded-xl px-4 py-2 text-sm min-w-[220px]"
                    >
                        <option value="Semua Prodi" {{ $prodiId == 'Semua Prodi' ? 'selected' : '' }}>Semua Prodi</option>
                        @foreach($allProdis as $prodi)
                            <option value="{{ $prodi->id }}" {{ $prodiId == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->jenjang }} {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>

                </div>

            </div>
        </form>

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-2 xl:grid-cols-3 gap-4">

            {{-- TOTAL --}}
            <div class="glass-panel rounded-[24px] p-5 space-y-4
            hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

                <div class="flex items-center justify-between">

                    <div class="w-12 h-12 rounded-2xl bg-blue-100
                        flex items-center justify-center text-blue-600">

                        <span class="material-symbols-outlined">
                            draft
                        </span>

                    </div>

                    <span class="px-2 py-1 rounded-full
                        bg-blue-100 text-blue-600
                        text-xs font-bold">

                        {{ $totalGrowthStr }}
                    </span>

                </div>

                <div>

                    <p class="text-xs text-slate-500 font-medium">
                        Total Pengajuan
                    </p>

                    <h3 class="text-3xl font-bold text-slate-800">
                        {{ number_format($totalCurrent, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">

                    <div class="h-full rounded-full bg-blue-600" style="width: {{ $totalBar }}%"></div>

                </div>

            </div>

            {{-- SELESAI --}}
            <div class="glass-panel rounded-[24px] p-5 space-y-4
            hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

                <div class="flex items-center justify-between">

                    <div class="w-12 h-12 rounded-2xl bg-green-100
                        flex items-center justify-center text-green-600">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                    </div>

                    <span class="px-2 py-1 rounded-full
                        bg-green-100 text-green-600
                        text-xs font-bold">

                        {{ $selesaiGrowthStr }}
                    </span>

                </div>

                <div>

                    <p class="text-xs text-slate-500 font-medium">
                        Pengajuan Selesai
                    </p>

                    <h3 class="text-3xl font-bold text-slate-800">
                        {{ number_format($selesaiCurrent, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">

                    <div class="h-full rounded-full bg-green-500" style="width: {{ $selesaiBar }}%"></div>

                </div>

            </div>

            {{-- MENUNGGU --}}
            <div class="glass-panel rounded-[24px] p-5 space-y-4
            hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

                <div class="flex items-center justify-between">

                    <div class="w-12 h-12 rounded-2xl bg-red-100
                        flex items-center justify-center text-red-500">

                        <span class="material-symbols-outlined">
                            pending_actions
                        </span>

                    </div>

                    <span class="px-2 py-1 rounded-full
                        bg-red-100 text-red-500
                        text-xs font-bold">

                        {{ $menungguGrowthStr }}
                    </span>

                </div>

                <div>

                    <p class="text-xs text-slate-500 font-medium">
                        Menunggu
                    </p>

                    <h3 class="text-3xl font-bold text-slate-800">
                        {{ number_format($menungguCurrent, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">

                    <div class="h-full rounded-full bg-red-500" style="width: {{ $menungguBar }}%"></div>

                </div>

            </div>

        </div>

        {{-- CHARTS --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- TREN --}}
            <div class="xl:col-span-2 glass-panel rounded-[28px] p-6">

                <div class="flex items-center justify-between mb-6">

                    <div>

                        <h3 class="font-h3 text-h3 text-on-surface">
                            Tren Pengajuan
                        </h3>

                        <p class="text-sm text-on-surface-variant mt-1">
                            Statistik pengajuan dokumen mahasiswa
                        </p>

                    </div>

                    <div class="flex gap-2">

                    {{-- BULANAN --}}
                    <button
                        type="button"
                        @click="chartMode = 'bulanan'"
                        :class="chartMode === 'bulanan'
                            ? 'bg-blue-600 text-white'
                            : 'glass-panel text-slate-600'"
                        class="px-4 py-2 rounded-full text-xs font-semibold transition"
                    >
                        Bulanan
                    </button>

                    {{-- MINGGUAN --}}
                    <button
                        type="button"
                        @click="chartMode = 'mingguan'"
                        :class="chartMode === 'mingguan'
                            ? 'bg-blue-600 text-white'
                            : 'glass-panel text-slate-600'"
                        class="px-4 py-2 rounded-full text-xs font-semibold transition"
                    >
                        Mingguan
                    </button>

                </div>

                </div>

                {{-- FAKE CHART --}}
                <div class="h-[320px] flex items-end gap-4">
                    <template x-for="(item, index) in (chartMode === 'bulanan' ? chartDataBulanan : chartDataMingguan)" :key="index">
                        <div class="flex-1 flex flex-col items-center gap-2">
                            <div class="w-full h-[260px] flex items-end justify-center">
                                <div :class="item.class" :style="`height: ${item.percentage}%; background-color: ${item.color}`" :title="`Total: ${item.count}`"></div>
                            </div>
                            <span class="text-xs text-slate-500" x-text="item.label"></span>
                        </div>
                    </template>
                </div>

            </div>

            {{-- DISTRIBUSI --}}
            <div class="glass-panel rounded-[28px] p-6 flex flex-col">

                <div>

                    <h3 class="font-h3 text-h3 text-on-surface">
                        Distribusi Status
                    </h3>

                    <p class="text-sm text-on-surface-variant mt-1">
                        Komposisi status pengajuan
                    </p>

                </div>

                {{-- DONUT CHART --}}
                <div class="flex-1 flex items-center justify-center">
                    @if($totalCurrent > 0)
                        <div class="relative w-52 h-52 rounded-full transition-all duration-500" 
                             style="background: conic-gradient(#3b82f6 0% {{ $diprosesEnd }}%, #22c55e {{ $diprosesEnd }}% {{ $selesaiEnd }}%, #ef4444 {{ $selesaiEnd }}% 100%)">
                            <div class="absolute inset-[22px] rounded-full bg-white flex items-center justify-center">
                                <div class="text-center">
                                    <h3 class="text-3xl font-bold text-slate-800">
                                        {{ $selesaiPct }}%
                                    </h3>
                                    <p class="text-xs text-slate-500">
                                        Selesai
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="relative w-52 h-52 rounded-full transition-all duration-500 bg-slate-200">
                            <div class="absolute inset-[22px] rounded-full bg-white flex items-center justify-center">
                                <div class="text-center">
                                    <h3 class="text-3xl font-bold text-slate-400">
                                        0%
                                    </h3>
                                    <p class="text-xs text-slate-400">
                                        Selesai
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- LEGEND --}}
                <div class="space-y-3 mt-4">

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-2">

                            <span class="w-3 h-3 rounded-full bg-blue-600"></span>

                            <span class="text-sm text-slate-600">
                                Diproses
                            </span>

                        </div>

                        <span class="text-sm font-bold text-slate-700">
                            {{ $diprosesPct }}%
                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-2">

                            <span class="w-3 h-3 rounded-full bg-green-500"></span>

                            <span class="text-sm text-slate-600">
                                Selesai
                            </span>

                        </div>

                        <span class="text-sm font-bold text-slate-700">
                            {{ $selesaiPct }}%
                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-2">

                            <span class="w-3 h-3 rounded-full bg-red-500"></span>

                            <span class="text-sm text-slate-600">
                                Ditolak
                            </span>

                        </div>

                        <span class="text-sm font-bold text-slate-700">
                            {{ $ditolakPct }}%
                        </span>

                    </div>

                </div>

            </div>

        </div>

        {{-- REKAP TABLE --}}
        <div class="glass-panel rounded-[28px] overflow-hidden">

            <div class="px-6 py-5 border-b border-[#E2E8F0]">

                <h3 class="font-h3 text-h3 text-on-surface">
                    Rekap Pengajuan per Prodi
                </h3>

                <p class="text-sm text-on-surface-variant mt-1">
                    Statistik volume pengajuan berdasarkan program studi
                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">

                    <thead>

                        <tr class="bg-[#F8FAFC] border-b border-[#E2E8F0]">

                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">
                                Program Studi
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-500">
                                Total
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-500">
                                Selesai
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-500">
                                Diproses
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-500">
                                Menunggu
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-500">
                                Tingkat Selesai
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-[#EDF2F7]">

                        @forelse ($rekapProdi as $rekap)
                        <tr class="hover:bg-[#F8FAFC] transition">

                            <td class="px-6 py-5 font-semibold text-slate-800">
                                {{ $rekap['nama_prodi'] }}
                            </td>

                            <td class="px-6 py-5 text-center font-bold text-slate-800">
                                {{ number_format($rekap['total'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-5 text-center text-green-600 font-semibold">
                                {{ number_format($rekap['selesai'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-5 text-center text-blue-600 font-semibold">
                                {{ number_format($rekap['diproses'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-5 text-center text-red-500 font-semibold">
                                {{ number_format($rekap['menunggu'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">

                                        <div class="h-full bg-green-500 rounded-full" style="width: {{ $rekap['completion_rate'] }}%"></div>

                                    </div>

                                    <span class="text-xs font-bold text-green-600">
                                        {{ $rekap['completion_rate'] }}%
                                    </span>

                                </div>

                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500 italic">
                                Belum ada data pengajuan untuk filter terpilih.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>

@endsection
