@props(['status'])

@php
    $statusLabel = match (strtolower($status)) {
        'menunggu' => 'Menunggu',
        'diproses' => 'Diproses',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
        default => ucfirst($status ?? '-'),
    };

    $statusClass = match (strtolower($status)) {
        'menunggu' => 'bg-error-container/50 text-on-error-container border-error-container',
        'diproses' => 'bg-surface-container-high text-on-surface border-outline-variant',
        'selesai' => 'bg-primary/10 text-primary border-primary/20',
        'ditolak' => 'bg-error/10 text-error border-error/20',
        default => 'bg-surface-container-high text-on-surface border-outline-variant',
    };

    $dotClass = match (strtolower($status)) {
        'menunggu' => 'bg-error',
        'diproses' => 'bg-tertiary',
        'selesai' => 'bg-primary',
        'ditolak' => 'bg-error',
        default => 'bg-outline',
    };
@endphp

<span class="inline-flex items-center px-3 py-1 rounded-full border font-label-sm text-label-sm gap-1 {{ $statusClass }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
    {{ $statusLabel }}
</span>