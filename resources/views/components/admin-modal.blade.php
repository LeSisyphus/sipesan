@props([
    'show',
    'close',
    'maxWidth' => 'max-w-5xl'
])

<div
    x-show="{{ $show }}"
    x-transition.opacity.duration.300ms
    class="fixed inset-0 z-[999] flex items-center justify-center p-6"
    style="display: none;"
>

    {{-- BACKDROP --}}
    <div
        @click="{{ $close }}"
        class="absolute inset-0 bg-slate-900/20 backdrop-blur-md"
    ></div>

    {{-- MODAL --}}
    <div
        x-show="{{ $show }}"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="relative w-full {{ $maxWidth }}
               max-h-[92vh]
               overflow-hidden
               rounded-[36px]
               bg-white/85
               backdrop-blur-2xl
               border border-white/60
               shadow-[0_25px_100px_rgba(15,23,42,0.18)]
               flex flex-col"
    >

        {{ $slot }}

    </div>

</div>