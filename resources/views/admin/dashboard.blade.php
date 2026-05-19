@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard')

@section('content')
<main class="ml-0 md:ml-64 min-h-screen flex flex-col">
<div class="flex-1 px-6 pb-12 pt-24 w-full space-y-8 pt-24">

    <!-- Page header -->
    <div class="flex flex-col gap-1">
      <h2 class="font-h2 text-h2 text-on-surface">Dashboard Overview</h2>
      <p class="font-body-md text-body-md text-on-surface-variant">Selamat datang kembali, Admin. Berikut ringkasan hari ini.</p>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
      <!-- Card 1 -->
      <div class="glass-panel rounded-[24px] p-lg flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-8">
          <div class="w-12 h-12 rounded-xl bg-white/50 border border-white/60 flex items-center justify-center shadow-sm">
            <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1;">groups</span>
          </div>
          <span class="px-3 py-1 bg-surface-container-highest/50 text-on-surface-variant rounded-full font-label-sm text-label-sm">+12%</span>
        </div>
        <div>
          <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Mahasiswa</h3>
          <p class="font-h1 text-h1 text-on-surface">2.450</p>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="glass-panel rounded-[24px] p-lg flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-secondary/5 rounded-full blur-2xl group-hover:bg-secondary/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-8">
          <div class="w-12 h-12 rounded-xl bg-white/50 border border-white/60 flex items-center justify-center shadow-sm">
            <span class="material-symbols-outlined text-secondary" style="font-variation-settings:'FILL' 1;">draft</span>
          </div>
          <span class="px-3 py-1 bg-surface-container-highest/50 text-on-surface-variant rounded-full font-label-sm text-label-sm">Aktif</span>
        </div>
        <div>
          <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Jenis Surat</h3>
          <p class="font-h1 text-h1 text-on-surface">18</p>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="glass-panel rounded-[24px] p-lg flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group border-primary/20 bg-primary/5">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-error/5 rounded-full blur-2xl group-hover:bg-error/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-8">
          <div class="w-12 h-12 rounded-xl bg-white/80 border border-white flex items-center justify-center shadow-sm">
            <span class="material-symbols-outlined text-error" style="font-variation-settings:'FILL' 1;">pending_actions</span>
          </div>
          <span class="px-3 py-1 bg-error-container/50 text-on-error-container rounded-full font-label-sm text-label-sm animate-pulse">Perlu Tindakan</span>
        </div>
        <div>
          <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-1">Menunggu Diproses</h3>
          <p class="font-h1 text-h1 text-primary">34</p>
        </div>
      </div>
    </div>

    <!-- Recent requests table -->
    <div class="glass-panel rounded-[24px] overflow-hidden flex flex-col">
      <div class="p-lg border-b border-white/40 flex items-center justify-between">
        <h3 class="font-h3 text-h3 text-on-surface">Pengajuan Terbaru</h3>
        <a href="Admin_Pengajuan.html"
           class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors flex items-center gap-1">
          Lihat Semua <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
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
            <tr class="hover:bg-white/30 transition-colors duration-200">
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface font-medium">REQ-001</td>
              <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary font-bold text-xs">AJ</div>
                  <span class="font-body-md text-body-md text-on-surface">Ahmad Jaelani</span>
                </div>
              </td>
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">Surat Keterangan Aktif</td>
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">12 Okt 2023</td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-error-container/50 text-on-error-container border border-error-container font-label-sm text-label-sm gap-1">
                  <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Menunggu
                </span>
              </td>
              <td class="py-4 px-6 text-right">
                <a href="Admin_Pengajuan.html" class="p-2 rounded-lg hover:bg-white/50 text-primary transition-colors inline-flex">
                  <span class="material-symbols-outlined">visibility</span>
                </a>
              </td>
            </tr>
            <tr class="hover:bg-white/30 transition-colors duration-200">
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface font-medium">REQ-002</td>
              <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary font-bold text-xs">BK</div>
                  <span class="font-body-md text-body-md text-on-surface">Budi Kusuma</span>
                </div>
              </td>
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">Surat Pengantar PKL</td>
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">12 Okt 2023</td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-container-high text-on-surface border border-outline-variant font-label-sm text-label-sm gap-1">
                  <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> Diproses
                </span>
              </td>
              <td class="py-4 px-6 text-right">
                <a href="Admin_Pengajuan.html" class="p-2 rounded-lg hover:bg-white/50 text-primary transition-colors inline-flex">
                  <span class="material-symbols-outlined">visibility</span>
                </a>
              </td>
            </tr>
            <tr class="hover:bg-white/30 transition-colors duration-200">
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface font-medium">REQ-003</td>
              <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary font-bold text-xs">CD</div>
                  <span class="font-body-md text-body-md text-on-surface">Citra Dewi</span>
                </div>
              </td>
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">Transkrip Nilai</td>
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">11 Okt 2023</td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-error-container/50 text-on-error-container border border-error-container font-label-sm text-label-sm gap-1">
                  <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Menunggu
                </span>
              </td>
              <td class="py-4 px-6 text-right">
                <a href="Admin_Pengajuan.html" class="p-2 rounded-lg hover:bg-white/50 text-primary transition-colors inline-flex">
                  <span class="material-symbols-outlined">visibility</span>
                </a>
              </td>
            </tr>
            <tr class="hover:bg-white/30 transition-colors duration-200">
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface font-medium">REQ-004</td>
              <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary font-bold text-xs">DS</div>
                  <span class="font-body-md text-body-md text-on-surface">Dian Sastro</span>
                </div>
              </td>
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">Surat Cuti Akademik</td>
              <td class="py-4 px-6 font-body-md text-body-md text-on-surface-variant">10 Okt 2023</td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary border border-primary/20 font-label-sm text-label-sm gap-1">
                  <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Selesai
                </span>
              </td>
              <td class="py-4 px-6 text-right">
                <a href="Admin_Pengajuan.html" class="p-2 rounded-lg hover:bg-white/50 text-primary transition-colors inline-flex">
                  <span class="material-symbols-outlined">visibility</span>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>

@endsection