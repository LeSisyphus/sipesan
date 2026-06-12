@props(['label', 'value', 'colorClass' => 'text-slate-900'])

<div class="glass-panel rounded-[22px] p-5">
    <p class="text-sm text-slate-500">{{ $label }}</p>
    <p class="text-3xl font-semibold {{ $colorClass }} mt-1">{{ $value }}</p>
</div>