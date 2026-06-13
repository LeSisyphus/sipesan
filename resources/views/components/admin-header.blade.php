@props(['title', 'description', 'buttonText', 'buttonAction'])

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="font-h2 text-h2 text-on-surface">
            {{ $title }}
        </h1>
        <p class="text-on-surface-variant mt-1">
            {{ $description }}
        </p>
    </div>

    @if($buttonText)
    <button
        @click="{{ $buttonAction }}"
        class="bg-primary text-white px-6 py-3 rounded-full flex items-center gap-2 hover:scale-[1.02] transition-all shadow-lg"
    >
        <span class="material-symbols-outlined text-[20px]">
            add
        </span>
        {{ $buttonText }}
    </button>
    @endif
</div>