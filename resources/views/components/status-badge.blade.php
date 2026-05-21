@props(['status'])

@php
    $classes = match($status) {

        'menunggu' =>
            'bg-slate-100 text-slate-600',

        'diproses' =>
            'bg-purple-100 text-purple-600',

        'selesai' =>
            'bg-blue-100 text-blue-600',

        'ditolak' =>
            'bg-red-100 text-red-600',

        default =>
            'bg-slate-100 text-slate-600',
    };
@endphp

<span
    {{ $attributes->merge([
        'class' =>
            "inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold {$classes}"
    ]) }}
>

    <span class="w-2 h-2 rounded-full bg-current"></span>

    {{ ucfirst($status) }}

</span>