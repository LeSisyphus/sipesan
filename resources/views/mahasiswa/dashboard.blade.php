@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa')

@section('content')

@php
    $namaMahasiswa = $user?->name ?? 'Mahasiswa';

    $statusConfig = [
        'menunggu' => [
            'label' => 'Menunggu',
            'badge' => 'bg-slate-100 text-slate-700',
            'icon' => 'hourglass_empty',
        ],
        'diproses' => [
            'label' => 'Diproses',
            'badge' => 'bg-violet-100 text-violet-700',
            'icon' => 'pending_actions',
        ],
        'selesai' => [
            'label' => 'Selesai',
            'badge' => 'bg-blue-100 text-primary',
            'icon' => 'mark_email_read',
        ],
        'ditolak' => [
            'label' => 'Ditolak',
            'badge' => 'bg-red-100 text-red-600',
            'icon' => 'cancel',
        ],
    ];
@endphp

<div class="max-w-[1400px] mx-auto space-y-6">

    {{-- HERO --}}
    <section class="glass-panel rounded-[28px] p-8 lg:p-10 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-[48px] lg:text-[50px] font-bold leading-[1.05] text-slate-900">
                Selamat Datang,<br>

                <span class="text-primary">
                    {{ $namaMahasiswa }}
                </span>
            </h1>

            <p class="mt-5 text-[18px] leading-relaxed text-slate-600 max-w-3xl">
                Pantau status pengajuan dokumen akademik Anda dengan mudah.
                Sistem ini dirancang untuk memberikan transparansi dan
                kecepatan dalam setiap proses administrasi.
            </p>
        </div>

        <div class="hidden lg:block absolute -top-12 -right-12 w-52 h-52 rounded-full bg-blue-300/30 blur-3xl"></div>
    </section>

    {{-- STATS --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- TOTAL --}}
        <div class="glass-panel rounded-[28px] p-6 min-h-[190px] flex flex-col justify-between">
            <div class="w-14 h-14 rounded-full bg-[#EEF4FF] flex items-center justify-center">
                <span class="material-symbols-rounded text-primary text-[28px]">
                    description
                </span>
            </div>

            <div>
                <p class="text-slate-500 font-medium text-base">
                    Total Pengajuan Saya
                </p>

                <h3 class="text-[42px] font-bold text-slate-900">
                    {{ $totalPengajuan }}
                </h3>
            </div>
        </div>

        {{-- DIPROSES --}}
        <div class="glass-panel rounded-[28px] p-6 min-h-[190px] flex flex-col justify-between">
            <div class="w-14 h-14 rounded-full bg-[#F1EDFF] flex items-center justify-center">
                <span class="material-symbols-rounded text-[#6D5EF9] text-[28px]">
                    pending_actions
                </span>
            </div>

            <div>
                <p class="text-slate-500 font-medium text-base">
                    Sedang Diproses
                </p>

                <h3 class="text-[42px] font-black text-slate-900">
                    {{ $diproses }}
                </h3>
            </div>
        </div>

        {{-- CTA --}}
        <a
            href="{{ route('mahasiswa.pengajuan') }}"
            class="rounded-[28px] bg-primary text-white p-6 min-h-[190px]
            flex flex-col items-center justify-center gap-4
            shadow-[0_12px_40px_-10px_rgba(0,88,188,0.45)]
            hover:scale-[1.02] transition-all duration-300"
        >
            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">
                <span class="material-symbols-rounded text-[34px]">
                    add
                </span>
            </div>

            <h3 class="text-[22px] font-bold text-center leading-tight">
                Buat Pengajuan Baru
            </h3>
        </a>
    </section>

    {{-- STATUS RINGKAS --}}
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="glass-panel rounded-[24px] p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center">
                <span class="material-symbols-rounded">hourglass_empty</span>
            </div>
            <div>
                <p class="text-sm text-slate-500">Menunggu</p>
                <p class="text-2xl font-bold text-slate-900">{{ $menunggu }}</p>
            </div>
        </div>

        <div class="glass-panel rounded-[24px] p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center">
                <span class="material-symbols-rounded">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-slate-500">Selesai</p>
                <p class="text-2xl font-bold text-slate-900">{{ $selesai }}</p>
            </div>
        </div>

        <div class="glass-panel rounded-[24px] p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center">
                <span class="material-symbols-rounded">cancel</span>
            </div>
            <div>
                <p class="text-sm text-slate-500">Ditolak</p>
                <p class="text-2xl font-bold text-slate-900">{{ $ditolak }}</p>
            </div>
        </div>
    </section>

    {{-- AKTIVITAS --}}
    <section class="glass-panel rounded-[28px] p-6 lg:p-8">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-200">
            <h2 class="text-[32px] font-black text-slate-900">
                Aktivitas Terbaru
            </h2>

            <a href="{{ route('mahasiswa.riwayat') }}" class="text-primary font-semibold hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="space-y-4">
            @forelse ($aktivitasTerbaru as $item)
                @php
                    $config = $statusConfig[$item->status] ?? $statusConfig['menunggu'];
                @endphp

                <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-slate-50 transition">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                            <span class="material-symbols-rounded text-slate-500">
                                {{ $config['icon'] }}
                            </span>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-[20px] font-medium text-slate-900 truncate">
                                {{ $item->jenisSurat?->nama_surat ?? 'Jenis Surat Tidak Ditemukan' }}
                            </h3>

                            <p class="text-slate-500 text-sm">
                                {{ optional($item->tgl_ajuan)->translatedFormat('d F Y') }}
                                •
                                {{ optional($item->created_at)->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>

                    <span class="px-4 py-1 rounded-full text-sm font-semibold {{ $config['badge'] }}">
                        {{ $config['label'] }}
                    </span>
                </div>
            @empty
                <div class="py-14 text-center">
                    <span class="material-symbols-rounded text-6xl text-slate-300">
                        inbox
                    </span>

                    <h3 class="mt-4 text-xl font-semibold text-slate-700">
                        Belum ada aktivitas
                    </h3>

                    <p class="text-slate-400 mt-1">
                        Pengajuan terbaru Anda akan muncul di sini.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

</div>

@endsection
