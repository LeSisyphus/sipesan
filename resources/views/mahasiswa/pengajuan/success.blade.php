@extends('layouts.mahasiswa')

@section('title', 'Pengajuan Berhasil')

@section('content')
<div class="max-w-[1000px] mx-auto">
    <div class="glass-panel rounded-[32px] p-10 md:p-16 text-center">
        <div class="w-24 h-24 rounded-full bg-blue-100 mx-auto flex items-center justify-center">
            <span class="material-symbols-rounded text-primary text-[54px]">
                check_circle
            </span>
        </div>

        <h1 class="mt-8 text-[34px] md:text-[42px] font-black text-slate-900">
            Pengajuan Berhasil Dikirim!
        </h1>

        <p class="mt-3 text-lg text-slate-500 max-w-2xl mx-auto">
            Pengajuan surat Anda berhasil dikirim dan sedang menunggu proses dari admin.
        </p>

        <div class="mt-8 max-w-xl mx-auto rounded-[24px] bg-white/70 border border-white/60 p-6 text-left space-y-4">
            <div class="flex items-center justify-between gap-4">
                <span class="text-sm font-semibold text-slate-500">Nomor Pengajuan</span>
                <span class="font-bold text-slate-800">
                    #PGJ-{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-sm font-semibold text-slate-500">Jenis Surat</span>
                <span class="font-bold text-slate-800 text-right">
                    {{ $pengajuan->jenisSurat?->nama_surat ?? '-' }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-sm font-semibold text-slate-500">Tanggal Pengajuan</span>
                <span class="font-bold text-slate-800">
                    {{ optional($pengajuan->tgl_ajuan)->format('d M Y') }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-sm font-semibold text-slate-500">Status</span>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-yellow-100 text-yellow-700 text-sm font-bold capitalize">
                    {{ $pengajuan->status }}
                </span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-10">
            <a
                href="{{ route('mahasiswa.riwayat') }}"
                class="px-8 py-3 rounded-full bg-primary text-white glow-button font-semibold"
            >
                Lihat Riwayat
            </a>

            <a
                href="{{ route('mahasiswa.dashboard') }}"
                class="px-8 py-3 rounded-full glass-panel font-semibold"
            >
                Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
