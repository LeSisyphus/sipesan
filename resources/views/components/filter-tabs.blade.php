@props([
    'filters',
    'model'
])

<div class="flex flex-wrap items-center gap-3">

    @foreach($filters as $filter)

        <button
            @click="{{ $model }} = '{{ $filter['value'] }}'"
            class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300"
            :class="{{ $model }} === '{{ $filter['value'] }}'
                ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20'
                : 'bg-white text-slate-500 hover:bg-blue-50'"
        >

            {{ $filter['label'] }}

        </button>

    @endforeach

</div>