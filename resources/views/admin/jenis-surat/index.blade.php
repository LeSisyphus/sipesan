@extends('layouts.admin')

@section('title', 'Master Jenis Surat')

@section('content')

<div
    x-data="{
        openModal: false,
        editMode: false,

        openTambah() {
            this.editMode = false;
            this.openModal = true;
        },

        openEdit() {
            this.editMode = true;
            this.openModal = true;
        },

        closeModal() {
            this.openModal = false;
        },

        saveData() {
            this.openModal = false;

            Swal.fire({
                icon: 'success',
                title: this.editMode
                    ? 'Data berhasil diupdate'
                    : 'Data berhasil ditambahkan',
                showConfirmButton: false,
                timer: 2000,
                confirmButtonColor: '#0058bc'
            });
        },

        deleteData() {
            Swal.fire({
                title: 'Hapus data?',
                text: 'Data yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data berhasil dihapus',
                        showConfirmButton: false,
                        timer: 2000
                    });
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

                    <th class="text-left p-5">
                        ID
                    </th>

                    <th class="text-left p-5">
                        Nama Surat
                    </th>

                    <th class="text-left p-5">
                        Deskripsi
                    </th>

                    <th class="text-right p-5">
                        Aksi
                    </th>

                </tr>
            </thead>

            <tbody>

                @for ($i = 1; $i <= 4; $i++)

                <tr class="border-t border-outline-variant/10 hover:bg-primary/5 transition-all">

                    <td class="p-5 font-semibold text-primary">
                        #SRT-0{{ $i }}
                    </td>

                    <td class="p-5 font-semibold">
                        Surat Keterangan Aktif
                    </td>

                    <td class="p-5 text-on-surface-variant">
                        Dokumen keterangan mahasiswa aktif.
                    </td>

                    <td class="p-5">

                        <div class="flex justify-end gap-2">

                            <!-- EDIT -->
                            <button
                                @click="openEdit()"
                                class="w-10 h-10 rounded-full hover:bg-primary/10 text-primary transition-all flex items-center justify-center"
                            >
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </button>

                            <!-- DELETE -->
                            <button
                                @click="deleteData()"
                                class="w-10 h-10 rounded-full hover:bg-error/10 text-error transition-all flex items-center justify-center"
                            >
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </button>

                        </div>

                    </td>

                </tr>

                @endfor

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
        <div
            @click.away="closeModal()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="w-full max-w-[520px]
                   backdrop-blur-[30px]
                   bg-surface-container-lowest/90
                   border border-white/80
                   rounded-[28px]
                   shadow-[0_24px_60px_rgba(0,88,188,0.15)]
                   overflow-hidden"
        >

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
                    @click="closeModal()"
                    class="p-2 rounded-full hover:bg-error/10 transition-all"
                >
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </button>

            </div>

            <!-- BODY -->
            <div class="p-8 space-y-5">

                <div>

                    <label class="block mb-2 font-medium">
                        Nama Surat
                    </label>

                    <input
                        type="text"
                        placeholder="Masukkan nama surat"
                        class="glass-input w-full px-5 py-3 rounded-[16px]"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Deskripsi
                    </label>

                    <textarea
                        rows="4"
                        placeholder="Masukkan deskripsi"
                        class="glass-input w-full px-5 py-3 rounded-[16px] resize-none"
                    ></textarea>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="px-8 py-6 border-t border-outline-variant/20 flex justify-end gap-3">

                <button
                    @click="closeModal()"
                    class="px-6 py-2.5 rounded-full border border-outline-variant/50 hover:bg-surface-container transition-all"
                >
                    Batal
                </button>

                <button
                    @click="saveData()"
                    class="px-8 py-2.5 rounded-full bg-primary hover:bg-primary-container text-white transition-all shadow-lg flex items-center gap-2"
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

        </div>

    </div>

</div>

@endsection