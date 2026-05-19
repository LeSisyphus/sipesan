<header class="fixed top-0 right-0 left-0 md:left-64 h-16 flex items-center justify-between px-6 z-40 bg-white/70 backdrop-blur-md border-b border-white/40 shadow-[0_4px_24px_rgba(0,88,188,0.06)]">
  <div class="flex items-center gap-4">
    <!-- Hamburger (mobile) -->
    <button class="md:hidden p-2 rounded-xl hover:bg-black/5 transition-colors text-slate-600" onclick="openSidebar()">
      <span class="material-symbols-outlined">menu</span>
    </button>
    <span class="md:hidden font-h3 text-h3 text-blue-600 font-bold tracking-tight">SIPESAN</span>
  </div>
  <div class="flex items-center gap-md">
    <!-- Search -->
    <div class="hidden md:flex items-center bg-black/5 rounded-full px-4 py-2 border border-white/40 focus-within:border-primary/50 focus-within:bg-white/80 transition-all duration-300">
      <span class="material-symbols-outlined text-outline mr-2">search</span>
      <input class="bg-transparent border-none outline-none text-body-md text-on-surface placeholder:text-outline w-48 focus:w-64 transition-all duration-300" placeholder="Cari..." type="text"/>
    </div>
    <!-- Notif -->
    <button class="w-10 h-10 flex items-center justify-center rounded-full glass-panel text-blue-600 hover:bg-white/60 transition-colors">
      <span class="material-symbols-outlined">notifications</span>
    </button>
    <!-- Avatar -->
    <button class="w-10 h-10 rounded-full overflow-hidden border-2 border-white/80 shadow-sm active:scale-95 transition-transform">
      <img alt="Admin" class="w-full h-full object-cover"
           src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWGL2Kh1PSsm8u3lDd7-uVZs_447rmRW8tnsZEa2yXBtIyRuAU-RKc3Po6433mfg9XQiYyXTjG9m4_LzvCR-NcqZEdl8Ovtd3B5OnLCZGYzp0SeOgwji6ugNK0hAGCW3llJzcEI7LVbhHI7Z7kk9McaBpIh4tL0Bw4n24OsPPEG1CnVdkgP3Sfzsqoh2vvmdnCzZU0ARNX8g9NiHARmP-soazc1VoZS-s8ZVi712J9-7RR-hsYCnbjut4KULxnkkccBKU5hWGemrpC"/>
    </button>
  </div>
</header>