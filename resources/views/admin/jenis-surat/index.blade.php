@extends('layouts.admin')

@section('title', 'Master Jenis Surat')

@section('content')

{{-- SweetAlert Flash Message & Validation Errors --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0058bc',
            confirmButtonText: 'Oke'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Oke'
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Oke'
        });
    });
</script>
@endif

<div
    x-data="{
        openModal: false,
        editMode: false,
        selectedSurat: {
            id: null,
            nama_surat: '',
            deskripsi: '',
            template_isi: '',
            dokumen_syarat_ids: []
        },

        openTambah() {
            this.editMode = false;
            this.selectedSurat = {
                id: null,
                nama_surat: '',
                deskripsi: '',
                template_isi: '',
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
                template_isi: surat.template_isi || '',
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

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

        <div>
            <h1 class="font-h2 text-h2 text-on-surface">
                Master Jenis Surat
            </h1>

            <p class="text-on-surface-variant mt-1">
                Kelola master jenis surat sistem.
            </p>
        </div>

        <button
            @click="openTambah()"
            class="bg-primary text-white px-6 py-3 rounded-full flex items-center gap-2 hover:scale-[1.02] transition-all shadow-lg"
        >
            <span class="material-symbols-outlined text-[20px]">
                add
            </span>

            Tambah Jenis Surat
        </button>

    </div>

    <!-- TABLE -->
    <div class="glass-panel rounded-[24px] overflow-hidden">

        <table class="w-full">

            <thead class="bg-surface-container/40">
                <tr>

                    <th class="text-left p-5 text-sm font-semibold">
                        ID
                    </th>

                    <th class="text-left p-5 text-sm font-semibold">
                        Nama Surat
                    </th>

                    <th class="text-left p-5 text-sm font-semibold">
                        Deskripsi
                    </th>

                    <th class="text-right p-5 text-sm font-semibold">
                        Aksi
                    </th>

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

                            <!-- EDIT -->
                            <button
                                @click="openEdit({
                                    id: {{ $surat->id }},
                                    nama_surat: {{ json_encode($surat->nama_surat) }},
                                    deskripsi: {{ json_encode($surat->deskripsi ?? '') }},
                                    template_isi: {{ json_encode($surat->template_isi ?? '') }},
                                    dokumen_syarat_ids: {{ json_encode($surat->dokumenSyarat->pluck('id')->toArray()) }}
                                })"
                                class="w-10 h-10 rounded-full hover:bg-primary/10 text-primary transition-all flex items-center justify-center"
                                title="Edit"
                            >
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </button>

                            <!-- DELETE -->
                            <button
                                @click="deleteData({{ $surat->id }})"
                                class="w-10 h-10 rounded-full hover:bg-error/10 text-error transition-all flex items-center justify-center"
                                title="Hapus"
                            >
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
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

    <!-- MODAL -->
    <div
        x-show="openModal"
        x-transition.opacity
        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/20 backdrop-blur-[8px]"
        style="display: none;"
    >

        <!-- BOX -->
        <form
            :action="editMode ? '/admin/jenis-surat/' + selectedSurat.id : '/admin/jenis-surat'"
            method="POST"
            @click.away="closeModal()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="w-full max-w-[550px]
                   backdrop-blur-[30px]
                   bg-surface-container-lowest/90
                   border border-white/80
                   rounded-[28px]
                   shadow-[0_24px_60px_rgba(0,88,188,0.15)]
                   overflow-hidden"
        >
            @csrf
            <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">

            <!-- HEADER -->
            <div class="px-8 py-6 border-b border-outline-variant/20 flex justify-between items-center">

                <div>

                    <h3 class="font-h3 text-h3 text-on-surface">

                        <span x-show="!editMode">
                            Tambah Jenis Surat
                        </span>

                        <span x-show="editMode">
                            Edit Jenis Surat
                        </span>

                    </h3>

                    <p class="text-sm text-on-surface-variant mt-1">

                        <span x-show="!editMode">
                            Tambahkan data baru.
                        </span>

                        <span x-show="editMode">
                            Update data jenis surat.
                        </span>

                    </p>

                </div>

                <button
                    type="button"
                    @click="closeModal()"
                    class="p-2 rounded-full hover:bg-error/10 transition-all text-slate-500 hover:text-red-500"
                >
                    <span class="material-symbols-outlined block">
                        close
                    </span>
                </button>

            </div>

            <!-- BODY -->
            <div class="p-8 space-y-4 max-h-[420px] overflow-y-auto">

                <div>
                    <label class="block mb-2 font-medium text-slate-700 text-sm">
                        Nama Surat <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_surat"
                        x-model="selectedSurat.nama_surat"
                        required
                        placeholder="Masukkan nama surat"
                        class="glass-input w-full px-5 py-3 rounded-[16px] focus:outline-none focus:border-primary transition"
                    >
                </div>

                <div>
                    <label class="block mb-2 font-medium text-slate-700 text-sm">
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        x-model="selectedSurat.deskripsi"
                        rows="2"
                        placeholder="Masukkan deskripsi"
                        class="glass-input w-full px-5 py-3 rounded-[16px] resize-none focus:outline-none focus:border-primary transition text-slate-700"
                    ></textarea>
                </div>



            </div>

            <!-- FOOTER -->
            <div class="px-8 py-6 border-t border-outline-variant/20 flex justify-end gap-3 bg-slate-50/50">

                <button
                    type="button"
                    @click="closeModal()"
                    class="px-6 py-2.5 rounded-full border border-outline-variant/50 hover:bg-surface-container transition-all text-sm font-medium"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-8 py-2.5 rounded-full bg-primary hover:bg-primary-container text-white transition-all shadow-lg flex items-center gap-2 text-sm font-semibold"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        save
                    </span>

                    <span x-show="!editMode">
                        Simpan Data
                    </span>

                    <span x-show="editMode">
                        Update Data
                    </span>

                </button>

            </div>

        </form>

    </div>

</div>

{{-- Hidden Form Delete --}}
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection