@props(['id', 'label', 'value' => '', 'rows' => 4, 'required' => false, 'wrapperClass' => ''])

<div class="{{ $wrapperClass }}">
    <label for="{{ $id }}" class="block mb-2 text-sm font-semibold text-slate-500">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>

    <textarea
        id="{{ $id }}"
        name="{{ $id }}"
        rows="{{ $rows }}"
        class="glass-input w-full px-5 py-3 resize-none @error($id) border-red-400 @enderror"
        @if($required) required @endif
        {{ $attributes }}
    >{{ $value }}</textarea>

    @error($id)
        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
    @enderror
</div>