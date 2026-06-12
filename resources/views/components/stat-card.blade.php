@props(['title', 'value', 'icon', 'color' => 'primary'])

@php
    $bgColors = [
        'primary' => 'bg-[#EEF4FF]',
        'violet' => 'bg-[#F1EDFF]',
        'success' => 'bg-green-100',
        'danger' => 'bg-red-100',
    ];
    
    $textColors = [
        'primary' => 'text-primary',
        'violet' => 'text-[#6D5EF9]',
        'success' => 'text-green-600',
        'danger' => 'text-red-600',
    ];

    $bgColor = $bgColors[$color] ?? $bgColors['primary'];
    $textColor = $textColors[$color] ?? $textColors['primary'];
@endphp

<div class="glass-panel rounded-[28px] p-6 min-h-[190px] flex flex-col justify-between">
    <div class="w-14 h-14 rounded-full {{ $bgColor }} flex items-center justify-center">
        <span class="material-symbols-rounded {{ $textColor }} text-[28px]">
            {{ $icon }}
        </span>
    </div>

    <div>
        <p class="text-slate-500 font-medium text-base">
            {{ $title }}
        </p>

        <h3 class="text-[42px] font-bold text-slate-900">
            {{ $value }}
        </h3>
    </div>
</div>