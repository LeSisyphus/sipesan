@props([
    'title',
    'date',
    'time',
    'icon',
    'status'
])

<div class="flex items-center justify-between p-4 rounded-2xl hover:bg-slate-50 transition">

    <div class="flex items-center gap-4 min-w-0">

        <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
            <span class="material-symbols-rounded text-slate-500">
                {{ $icon }}
            </span>
        </div>

        <div class="min-w-0">

            <h3 class="text-[20px] font-medium text-slate-900 truncate">
                {{ $title }}
            </h3>

            <p class="text-slate-500 text-sm">
                {{ $date }} • {{ $time }}
            </p>

        </div>

    </div>

    <x-status-badge :status="$status" />

</div>