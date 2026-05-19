<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 flex flex-col z-50 bg-white/70 backdrop-blur-xl border-r border-white/40 shadow-xl shadow-blue-500/5">

  <!-- Logo -->
  <div class="px-6 py-6 flex flex-col items-center border-b border-white/40">
    <div class="w-14 h-14 rounded-2xl glass-panel flex items-center justify-center mb-3 bg-gradient-to-br from-white/80 to-white/30">
      <span class="material-symbols-outlined text-4xl text-primary" style="font-variation-settings:'FILL' 1;">description</span>
    </div>

    <h1 class="font-h3 text-h3 text-blue-600 font-black tracking-tight">
      SIPESAN
    </h1>

    <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mt-1 text-xs">
      Sistem Dokumen
    </p>
  </div>

  <!-- Nav links -->
  <nav class="flex-1 overflow-y-auto py-5 px-4 space-y-1">

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl font-sans text-sm font-semibold tracking-wide transition-all duration-200
       {{ request()->routeIs('admin.dashboard')
            ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600'
            : 'text-slate-500 hover:bg-white/50 hover:translate-x-1'
       }}">

      <span class="material-symbols-outlined"
            style="font-variation-settings:'FILL' 1;">
        dashboard
      </span>

      <span>Dashboard</span>
    </a>

    {{-- Jenis Surat --}}
    <a href="{{ route('admin.jenis-surat.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl font-sans text-sm font-semibold tracking-wide transition-all duration-200
       {{ request()->routeIs('admin.jenis-surat.*')
            ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600'
            : 'text-slate-500 hover:bg-white/50 hover:translate-x-1'
       }}">

      <span class="material-symbols-outlined">
        folder_shared
      </span>

      <span>Master Jenis Surat</span>
    </a>

    {{-- Prodi --}}
    <a href="{{ route('admin.prodi.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl font-sans text-sm font-semibold tracking-wide transition-all duration-200
       {{ request()->routeIs('admin.prodi.*')
            ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600'
            : 'text-slate-500 hover:bg-white/50 hover:translate-x-1'
       }}">

      <span class="material-symbols-outlined">
        school
      </span>

      <span>Manajemen Prodi</span>
    </a>

    {{-- Akun Mahasiswa --}}
    <a href="{{ route('admin.akun-mahasiswa.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl font-sans text-sm font-semibold tracking-wide transition-all duration-200
       {{ request()->routeIs('admin.akun-mahasiswa.*')
            ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600'
            : 'text-slate-500 hover:bg-white/50 hover:translate-x-1'
       }}">

      <span class="material-symbols-outlined">
        manage_accounts
      </span>

      <span>Akun Mahasiswa</span>
    </a>

    {{-- Dokumen Syarat --}}
    <a href="{{ route('admin.dokumen-syarat.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl font-sans text-sm font-semibold tracking-wide transition-all duration-200
       {{ request()->routeIs('admin.dokumen-syarat.*')
            ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600'
            : 'text-slate-500 hover:bg-white/50 hover:translate-x-1'
       }}">

      <span class="material-symbols-outlined">
        rule_folder
      </span>

      <span>Dokumen Syarat</span>
    </a>

    {{-- Pengajuan --}}
    <a href="{{ route('admin.pengajuan.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl font-sans text-sm font-semibold tracking-wide transition-all duration-200
       {{ request()->routeIs('admin.pengajuan.*')
            ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600'
            : 'text-slate-500 hover:bg-white/50 hover:translate-x-1'
       }}">

      <span class="material-symbols-outlined">
        move_to_inbox
      </span>

      <span>Pengajuan Masuk</span>
    </a>

    {{-- Laporan --}}
    <a href="{{ route('admin.laporan.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl font-sans text-sm font-semibold tracking-wide transition-all duration-200
       {{ request()->routeIs('admin.laporan.*')
            ? 'bg-blue-600/10 text-blue-600 border-r-4 border-blue-600'
            : 'text-slate-500 hover:bg-white/50 hover:translate-x-1'
       }}">

      <span class="material-symbols-outlined">
        bar_chart
      </span>

      <span>Laporan</span>
    </a>

  </nav>

  <!-- Logout -->
  <div class="px-4 pb-5 border-t border-white/40 pt-4">

    <form method="POST" action="{{ route('logout') }}">
      @csrf

      <button
          type="submit"
          class="w-full flex items-center gap-3 px-4 py-3 text-error/80 hover:bg-error/5 rounded-2xl font-sans text-sm font-semibold tracking-wide hover:translate-x-1 transition-all duration-200"
      >
          <span class="material-symbols-outlined">
            logout
          </span>

          <span>Keluar</span>
      </button>
    </form>

  </div>
</aside>