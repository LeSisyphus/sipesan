@extends('layouts.admin')

@section('title', 'Master Jenis Surat')

@section('content')

{{-- Panggil Komponen Alerts --}}
<x-admin-alerts />

<div
    x-data="{
        openModal: false,
        editMode: false,
        selectedSurat: {
            id: null,
            nama_surat: '',
            deskripsi: '',
            dokumen_syarat_ids: []
        },

        openTambah() {
            this.editMode = false;
            this.selectedSurat = {
                id: null,
                nama_surat: '',
                deskripsi: '',
                dokumen_syarat_ids: []
            };
            this.openModal = true;
        },

        openEdit(surat) {
            this.editMode = true;
            this.selectedSurat = {
                id: surat.id,
                nama_surat: surat.nama_surat,
                deskripsi: surat.deskripsi || '',
                dokumen_syarat_ids: [...surat.dokumen_syarat_ids]
            };
            this.openModal = true;
        },

        closeModal() {
            this.openModal = false;
        },

        toggleRequirement(id) {
            let index = this.selectedSurat.dokumen_syarat_ids.indexOf(id);
            if (index > -1) {
                this.selectedSurat.dokumen_syarat_ids.splice(index, 1);
            } else {
                this.selectedSurat.dokumen_syarat_ids.push(id);
            }
        },

        deleteData(id) {
            Swal.fire({
                title: 'Hapus Jenis Surat?',
                text: 'Menghapus jenis surat ini akan melepas hubungannya dari data pengajuan. Tindakan ini tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById('deleteForm');
                    form.action = '/admin/jenis-surat/' + id;
                    form.submit();
                }
            });
        }
    }"
    class="ml-0 md:ml-64 pt-24 p-6 lg:px-12 pb-12"
>

    <x-admin-header 
        title="Master Jenis Surat" 
        description="Kelola master jenis surat sistem." 
        buttonText="Tambah Jenis Surat" 
        buttonAction="openTambah()" 
    />

    <div class="glass-panel rounded-[24px] overflow-hidden">
        <table class="w-full">
            <thead class="bg-surface-container/40">
                <tr>
                    <th class="text-left p-5 text-sm font-semibold">ID</th>
                    <th class="text-left p-5 text-sm font-semibold">Nama Surat</th>
                    <th class="text-left p-5 text-sm font-semibold">Deskripsi</th>
                    <th class="text-right p-5 text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jenisSurats as $surat)
                <tr class="border-t border-outline-variant/10 hover:bg-primary/5 transition-all">
                    <td class="p-5 font-semibold text-primary">
                        #SRT-{{ str_pad($surat->id, 3, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="p-5 font-semibold text-slate-800 text-[15px]">
                        {{ $surat->nama_surat }}
                    </td>
                    <td class="p-5 text-on-surface-variant max-w-[300px] truncate" title="{{ $surat->deskripsi }}">
                        {{ $surat->deskripsi ?? '-' }}
                    </td>
                    <td class="p-5">
                        <div class="flex justify-end gap-2">
                            <button
                                @click="openEdit({
                                    id: {{ $surat->id }},
                                    nama_surat: {{ json_encode($surat->nama_surat) }},
                                    deskripsi: {{ json_encode($surat->deskripsi ?? '') }},
                                    dokumen_syarat_ids: {{ json_encode($surat->dokumenSyarat->pluck('id')->toArray()) }}
                                })"
                                class="w-10 h-10 rounded-full hover:bg-primary/10 text-primary transition-all flex items-center justify-center"
                                title="Edit"
                            >
                                <span class="material-symbols-outlined">edit</span>
                            </button>

                            <button
                                @click="deleteData({{ $surat->id }})"
                                class="w-10 h-10 rounded-full hover:bg-error/10 text-error transition-all flex items-center justify-center"
                                title="Hapus"
                            >
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-500 italic">
                        Belum ada jenis surat. Silakan buat baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-admin-modal 
        titleAdd="Tambah Jenis Surat" 
        titleEdit="Edit Jenis Surat" 
        descAdd="Tambahkan data baru." 
        descEdit="Update data jenis surat." 
        formAction="editMode ? '/admin/jenis-surat/' + selectedSurat.id : '/admin/jenis-surat'"
    >
        {{-- Slot untuk hidden inputs (AlpineJS arrays) --}}
        <x-slot:hiddenInputs>
            <template x-for="id in selectedSurat.dokumen_syarat_ids" :key="id">
                <input type="hidden" name="dokumen_syarat_ids[]" :value="id">
            </template>
        </x-slot:hiddenInputs>

        {{-- Pakai komponen form yang kita bikin di task Mahasiswa --}}
        <x-form-input 
            id="nama_surat" 
            label="Nama Surat" 
            x-model="selectedSurat.nama_surat" 
            placeholder="Masukkan nama surat" 
            required="true" 
        />
        
        <x-form-textarea 
            id="deskripsi" 
            label="Deskripsi" 
            x-model="selectedSurat.deskripsi" 
            rows="2" 
            placeholder="Masukkan deskripsi" 
        />
    </x-admin-modal>

</div>

{{-- Hidden Form Delete --}}
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection