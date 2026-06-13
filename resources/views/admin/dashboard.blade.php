@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard')

@section('content')
<main class="ml-0 md:ml-64 min-h-screen flex flex-col">
<div class="flex-1 px-6 pb-12 pt-24 w-full space-y-8">

    <div class="flex flex-col gap-1">
        <h2 class="font-h2 text-h2 text-on-surface">Dashboard Overview</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Selamat datang kembali, Admin. Berikut ringkasan hari ini.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
        <x-admin-stat-card 
            theme="primary"
            icon="groups"
            title="Total Mahasiswa"
            :value="number_format($totalMahasiswa)"
            badgeText="{{ number_format($totalPengajuan) }} pengajuan"
        />

        <x-admin-stat-card 
            theme="secondary"
            icon="draft"
            title="Total Jenis Surat"
            :value="number_format($totalJenisSurat)"
            badgeText="Aktif"
        />

        <x-admin-stat-card 
            theme="error"
            icon="pending_actions"
            title="Menunggu Diproses"
            :value="number_format($menunggu)"
            badgeText="{{ $menunggu > 0 ? 'Perlu Tindakan' : 'Aman' }}"
            :pulse="$menunggu > 0"
        />
    </div>

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
                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">ID Pengajuan</th>
                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">Mahasiswa</th>
                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">Jenis Surat</th>
                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">Tanggal</th>
                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40">Status</th>
                        <th class="py-4 px-6 font-label-sm text-label-sm text-on-surface-variant font-medium border-b border-white/40 text-right">Aksi</th>
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
                                {{-- Use the new component for clean badge rendering --}}
                                <x-admin-status-badge :status="$item->status" />
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