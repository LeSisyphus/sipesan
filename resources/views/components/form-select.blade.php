@props(['id', 'label', 'required' => false])

<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-semibold text-slate-500">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>

    <select
        id="{{ $id }}"
        name="{{ $id }}"
        class="glass-input w-full px-5 py-3 @error($id) border-red-400 @enderror"
        @if($required) required @endif
        {{ $attributes }}
    >
        {{ $slot }}
    </select>

    @error($id)
        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
    @enderror
</div>