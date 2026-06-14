@props(['titleAdd', 'titleEdit', 'descAdd', 'descEdit', 'formAction'])

<div
    x-show="openModal"
    class="relative z-[999]"
    style="display: none;"
    x-init="$watch('openModal', value => {
        if (value) { document.body.style.overflow = 'hidden'; }
        else { document.body.style.overflow = ''; }
    })"
>
    {{-- Backdrop Layer --}}
    <div
        x-show="openModal"
        x-transition.opacity
        class="fixed inset-0 bg-black/20 backdrop-blur-[8px]"
    ></div>

    {{-- Modal Placement Layer --}}
    <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">
        <form
            :action="{{ $formAction }}"
            method="POST"
            @click.outside="closeModal()"
            x-show="openModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="w-full max-w-[550px] pointer-events-auto bg-surface-container-lowest/90 border border-white/80 rounded-[28px] shadow-[0_24px_60px_rgba(0,88,188,0.15)] overflow-hidden flex flex-col"
            style="max-height: 85vh;"
        >
            @csrf
            <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">
            
            {{-- Slot buat hidden input khusus (kalo ada) --}}
            {{ $hiddenInputs ?? '' }}

            {{-- Header --}}
            <div class="px-8 py-6 border-b border-outline-variant/20 flex justify-between items-center flex-shrink-0">
                <div>
                    <h3 class="font-h3 text-h3 text-on-surface">
                        <span x-show="!editMode">{{ $titleAdd }}</span>
                        <span x-show="editMode">{{ $titleEdit }}</span>
                    </h3>
                    <p class="text-sm text-on-surface-variant mt-1">
                        <span x-show="!editMode">{{ $descAdd }}</span>
                        <span x-show="editMode">{{ $descEdit }}</span>
                    </p>
                </div>
                <button type="button" @click="closeModal()" class="p-2 rounded-full hover:bg-error/10 transition-all text-slate-500 hover:text-red-500">
                    <span class="material-symbols-outlined block">close</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-8 space-y-4 flex-grow overflow-y-auto">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <div class="px-8 py-6 border-t border-outline-variant/20 flex justify-end gap-3 bg-slate-50/50 flex-shrink-0">
                <button type="button" @click="closeModal()" class="px-6 py-2.5 rounded-full border border-outline-variant/50 hover:bg-surface-container transition-all text-sm font-medium">
                    Batal
                </button>
                <button type="submit" class="px-8 py-2.5 rounded-full bg-primary hover:bg-primary-container text-white transition-all shadow-lg flex items-center gap-2 text-sm font-semibold">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span x-show="!editMode">Simpan Data</span>
                    <span x-show="editMode">Update Data</span>
                </button>
            </div>
        </form>
    </div>
</div>