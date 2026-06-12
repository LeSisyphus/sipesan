@props(['title', 'icon', 'iconBg' => 'bg-blue-100', 'iconText' => 'text-primary', 'contentClass' => 'grid grid-cols-1 md:grid-cols-2 gap-5'])

<section class="glass-panel rounded-[28px] p-7 mb-8 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
    <div class="flex items-center gap-3 border-b border-slate-200 pb-4 mb-6">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center {{ $iconBg }}">
            <span class="material-symbols-rounded {{ $iconText }}">
                {{ $icon }}
            </span>
        </div>

        <h2 class="text-[26px] font-semibold text-slate-900">
            {{ $title }}
        </h2>
    </div>

    <div class="{{ $contentClass }}">
        {{ $slot }}
    </div>
</section>