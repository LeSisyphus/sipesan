@props([
    'title', 
    'value', 
    'icon', 
    'badgeText', 
    'theme' => 'primary', 
    'pulse' => false
])

@php
    $config = match($theme) {
        'secondary' => [
            'blur' => 'bg-secondary/5 group-hover:bg-secondary/10', 
            'icon' => 'text-secondary', 
            'badge' => 'bg-surface-container-highest/50 text-on-surface-variant',
            'border' => 'border-white/60'
        ],
        'error' => [
            'blur' => 'bg-error/5 group-hover:bg-error/10', 
            'icon' => 'text-error', 
            'badge' => 'bg-error-container/50 text-on-error-container',
            'border' => 'border-error/20 bg-error/5'
        ],
        default => [
            'blur' => 'bg-primary/5 group-hover:bg-primary/10', 
            'icon' => 'text-primary', 
            'badge' => 'bg-surface-container-highest/50 text-on-surface-variant',
            'border' => 'border-white/60'
        ],
    };
@endphp

<div class="glass-panel rounded-[24px] p-lg flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group {{ $theme === 'error' ? 'border-error/20 bg-error/5' : '' }}">
    <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full blur-2xl transition-colors {{ $config['blur'] }}"></div>

    <div class="flex items-center justify-between mb-8 relative z-10">
        <div class="w-12 h-12 rounded-xl bg-white/50 border flex items-center justify-center shadow-sm {{ $config['border'] }}">
            <span class="material-symbols-outlined {{ $config['icon'] }}" style="font-variation-settings:'FILL' 1;">
                {{ $icon }}
            </span>
        </div>

        <span class="px-3 py-1 rounded-full font-label-sm text-label-sm {{ $config['badge'] }} {{ $pulse ? 'animate-pulse' : '' }}">
            {{ $badgeText }}
        </span>
    </div>

    <div class="relative z-10">
        <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-1">
            {{ $title }}
        </h3>

        <p class="font-h1 text-h1 {{ $theme === 'error' ? 'text-error' : 'text-on-surface' }}">
            {{ $value }}
        </p>
    </div>
</div>