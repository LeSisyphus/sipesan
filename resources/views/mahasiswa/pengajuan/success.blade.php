@extends('layouts.mahasiswa')

@section('title', 'Pengajuan Berhasil')

@section('content')

<div class="max-w-3xl mx-auto">
    <section class="glass-panel rounded-[32px] p-8 lg:p-10 text-center">
        <div class="w-20 h-20 mx-auto rounded-full bg-green-100 text-green-600 flex items-center justify-center">
            <span class="material-symbols-rounded text-[44px]">
                check_circle
            </span>
        </div>

        <h1 class="text-[34px] font-semibold text-slate-900 mt-6">
            Pengajuan Berhasil Dikirim
        </h1>

        <p class="text-slate-500 text-lg mt-3 leading-relaxed">
            Pengajuan untuk <span class="font-semibold text-slate-700">{{ $pengajuan->jenisSurat?->nama_surat }}</span>
            sudah masuk ke sistem dan sedang menunggu verifikasi admin.
        </p>

        <div class="mt-8 rounded-2xl bg-slate-50 border border-slate-100 p-5 text-left">
            <div class="flex justify-between gap-4 py-2">
                <span class="text-slate-500">Nomor Pengajuan</span>
                <span class="font-semibold text-slate-900">REQ-{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="flex justify-between gap-4 py-2 border-t border-slate-200">
                <span class="text-slate-500">Status</span>
                <span class="font-semibold text-slate-900">Menunggu</span>
            </div>

            <div class="flex justify-between gap-4 py-2 border-t border-slate-200">
                <span class="text-slate-500">Tanggal</span>
                <span class="font-semibold text-slate-900">{{ optional($pengajuan->tgl_ajuan)->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row justify-center gap-3">
            <a
                href="{{ route('mahasiswa.riwayat') }}"
                class="px-8 py-3 rounded-full bg-primary text-white font-semibold shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all"
            >
                Lihat Riwayat
            </a>

            <a
                href="{{ route('mahasiswa.pengajuan') }}"
                class="px-8 py-3 rounded-full bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition-all"
            >
                Buat Pengajuan Lagi
            </a>
        </div>
    </section>
</div>

@endsection
