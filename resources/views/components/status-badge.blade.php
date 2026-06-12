@props(['status'])

@php
    $config = match(strtolower($status)) {
        'diproses' => ['label' => 'Diproses', 'badge' => 'bg-violet-100 text-violet-700', 'icon' => 'pending_actions'],
        'selesai' => ['label' => 'Selesai', 'badge' => 'bg-blue-100 text-primary', 'icon' => 'mark_email_read'],
        'ditolak' => ['label' => 'Ditolak', 'badge' => 'bg-red-100 text-red-600', 'icon' => 'cancel'],
        default => ['label' => 'Menunggu', 'badge' => 'bg-slate-100 text-slate-700', 'icon' => 'hourglass_empty'],
    };
@endphp

<span {{ $attributes->merge(['class' => "px-4 py-1 rounded-full text-sm font-semibold {$config['badge']}"]) }}>
    {{ $config['label'] }}
</span>