{{-- resources/views/components/form-input.blade.php --}}
@props(['id', 'label', 'type' => 'text', 'value' => '', 'readonly' => false, 'required' => false])

<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-semibold text-slate-500">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>

    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $id }}"
        class="glass-input w-full px-5 py-3 @if($readonly) bg-white/50 @endif @error($id) border-red-400 @enderror"
        value="{{ $value }}"
        @if($readonly) readonly @endif
        @if($required) required @endif
        {{ $attributes }}
    >

    @error($id)
        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
    @enderror
</div>