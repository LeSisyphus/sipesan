@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard')

@section('content')
<main class="ml-0 md:ml-64 min-h-screen flex flex-col">
<div class="flex-1 px-6 pb-12 pt-24 w-full space-y-8">

    <!-- Page header -->
    <div class="flex flex-col gap-1">
        <h2 class="font-h2 text-h2 text-on-surface">Dashboard Overview</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Selamat datang kembali, Admin. Berikut ringkasan hari ini.
        </p>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
        <!-- Card 1 -->
        <div class="glass-panel rounded-[24px] p-lg flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>

            <div class="flex items-center justify-between mb-8">
                <div class="w-12 h-12 rounded-xl bg-white/50 border border-white/60 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1;">
                        groups
                    </span>
                </div>

                <span class="px-3 py-1 bg-surface-container-highest/50 text-on-surface-variant rounded-full font-label-sm text-label-sm">
                    {{ number_format($totalPengajuan) }} pengajuan
                </span>
            </div>

            <div>
                <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-1">
                    Total Mahasiswa
                </h3>

                <p class="font-h1 text-h1 text-on-surface">
                    {{ number_format($totalMahasiswa) }}
                </p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="glass-panel rounded-[24px] p-lg flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-secondary/5 rounded-full blur-2xl group-hover:bg-secondary/10 transition-colors"></div>

            <div class="flex items-center justify-between mb-8">
                <div class="w-12 h-12 rounded-xl bg-white/50 border border-white/60 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings:'FILL' 1;">
                        draft
                    </span>
                </div>

                <span class="px-3 py-1 bg-surface-container-highest/50 text-on-surface-variant rounded-full font-label-sm text-label-sm">
                    Aktif
                </span>
            </div>

            <div>
                <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-1">
                    Total Jenis Surat
                </h3>

                <p class="font-h1 text-h1 text-on-surface">
                    {{ number_format($totalJenisSurat) }}
                </p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="glass-panel rounded-[24px] p-lg flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group border-primary/20 bg-primary/5">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-error/5 rounded-full blur-2xl group-hover:bg-error/10 transition-colors"></div>

            <div class="flex items-center justify-between mb-8">
                <div class="w-12 h-12 rounded-xl bg-white/80 border border-white flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-error" style="font-variation-settings:'FILL' 1;">
                        pending_actions
                    </span>
                </div>

                <span class="px-3 py-1 bg-error-container/50 text-on-error-container rounded-full font-label-sm text-label-sm {{ $menunggu > 0 ? 'animate-pulse' : '' }}">
                    {{ $menunggu > 0 ? 'Perlu Tindakan' : 'Aman' }}
                </span>
            </div>

            <div>
                <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-1">
                    Menunggu Diproses
                </h3>

                <p class="font-h1 text-h1 text-primary">
                    {{ number_format($menunggu) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Recent requests table -->
    <div class="glass-panel rounded-[24px] overflow-hidden flex flex-col">
        <div class="p-lg border-b border-white/40 flex items-center justify-between">
            <h3 class="font-h3 text-h3 text-on-surface">
                Pengajuan Terbaru
            </h3>

            <a
                href="{{ route('admin.pengajuan.index') }}"
                class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors flex items-center gap-1"
            >
                Lihat Semua
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-lowest/30">
                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">
                            ID Pengajuan
                        </th>

                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">
                            Mahasiswa
                        </th>

                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">
                            Jenis Surat
                        </th>

                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">
                            Tanggal
                        </th>

                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">
                            Status
                        </th>

                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40 text-right">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/40">
                    @forelse ($pengajuanTerbaru as $item)
                        @php
                            $namaMahasiswa = $item->mahasiswa?->user?->name ?? '-';

                            $initials = collect(explode(' ', trim($namaMahasiswa)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($part) => mb_substr($part, 0, 1))
                                ->implode('');

                            $initials = $initials !== '' ? mb_strtoupper($initials) : '-';

                            $tanggal = $item->tgl_ajuan
                                ? $item->tgl_ajuan->translatedFormat('d M Y')
                                : $item->created_at?->translatedFormat('d M Y');

                            $statusLabel = match ($item->status) {
                                'menunggu' => 'Menunggu',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                                default => ucfirst($item->status ?? '-'),
                            };

                            $statusClass = match ($item->status) {
                                'menunggu' => 'bg-error-container/50 text-on-error-container border border-error-container',
                                'diproses' => 'bg-surface-container-high text-on-surface border border-outline-variant',
                                'selesai' => 'bg-primary/10 text-primary border border-primary/20',
                                'ditolak' => 'bg-error/10 text-error border border-error/20',
                                default => 'bg-surface-container-high text-on-surface border border-outline-variant',
                            };

                            $dotClass = match ($item->status) {
                                'menunggu' => 'bg-error',
                                'diproses' => 'bg-tertiary',
                                'selesai' => 'bg-primary',
                                'ditolak' => 'bg-error',
                                default => 'bg-outline',
                            };
                        @endphp

                        <tr class="hover:bg-white/30 transition-colors duration-200">
                            <td class="py-4 px-6 font-body-md text-body-md text-on-surface font-medium">
                                REQ-{{ str_pad((string) $item->id, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary font-bold text-xs">
                                        {{ $initials }}
                                    </div>

                                    <span class="font-body-md text-body-md text-on-surface">
                                        {{ $namaMahasiswa }}
                                    </span>
                                </div>
                            </td>

                            <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">
                                {{ $item->jenisSurat?->nama_surat ?? '-' }}
                            </td>

                            <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">
                                {{ $tanggal ?? '-' }}
                            </td>

                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full {{ $statusClass }} font-label-sm text-label-sm gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-right">
                                <a
                                    href="{{ route('admin.pengajuan.index', ['status' => $item->status]) }}"
                                    class="p-2 rounded-lg hover:bg-white/50 text-primary transition-colors inline-flex"
                                    title="Lihat pengajuan"
                                >
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 px-6 text-center">
                                <div class="flex flex-col items-center gap-2 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[40px] text-primary">
                                        inbox
                                    </span>

                                    <p class="font-body-md text-body-md">
                                        Belum ada pengajuan terbaru.
                                    </p>
                                </div>
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