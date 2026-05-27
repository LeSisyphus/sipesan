@extends('layouts.admin')

@section('title', 'Pengajuan Masuk')

@section('content')
<main
    class="md:ml-64 pt-24 px-6 pb-12 relative z-10"
    x-data="{
        openModal: false,
        selectedPengajuan: null,
        selectedStatus: 'menunggu',
        catatanAdmin: '',
        fileSuratName: null,
        fileSuratUrl: null,

        openDetail(data) {
            this.selectedPengajuan = data;
            this.selectedStatus = data.status_raw ?? 'menunggu';
            this.catatanAdmin = data.catatan_admin ?? '';
            this.fileSuratName = null;

            if (this.fileSuratUrl) {
                URL.revokeObjectURL(this.fileSuratUrl);
            }

            this.fileSuratUrl = null;
            this.openModal = true;
        },

        closeModal() {
            this.openModal = false;
            this.selectedPengajuan = null;
            this.selectedStatus = 'menunggu';
            this.catatanAdmin = '';
            this.fileSuratName = null;

            if (this.fileSuratUrl) {
                URL.revokeObjectURL(this.fileSuratUrl);
            }

            this.fileSuratUrl = null;
        },

        handleFileSurat(event) {
            const file = event.target.files[0];

            if (!file) {
                this.fileSuratName = null;

                if (this.fileSuratUrl) {
                    URL.revokeObjectURL(this.fileSuratUrl);
                }

                this.fileSuratUrl = null;
                return;
            }

            const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');

            if (!isPdf) {
                event.target.value = '';
                this.fileSuratName = null;

                if (this.fileSuratUrl) {
                    URL.revokeObjectURL(this.fileSuratUrl);
                }

                this.fileSuratUrl = null;

                Swal.fire({
                    title: 'Format Tidak Valid',
                    text: 'Dokumen balasan harus berupa file PDF.',
                    icon: 'warning',
                    confirmButtonColor: '#0058bc',
                    confirmButtonText: 'Oke',
                    background: '#ffffffee',
                    backdrop: 'rgba(15,23,42,0.35)',
                    customClass: {
                        popup: 'rounded-[28px]',
                        confirmButton: 'rounded-full px-6 py-2'
                    }
                });

                return;
            }

            this.fileSuratName = file.name;

            if (this.fileSuratUrl) {
                URL.revokeObjectURL(this.fileSuratUrl);
            }

            this.fileSuratUrl = URL.createObjectURL(file);
            this.selectedStatus = 'selesai';
        },

        clearFileSurat() {
            if (this.$refs.fileSurat) {
                this.$refs.fileSurat.value = '';
            }

            this.fileSuratName = null;

            if (this.fileSuratUrl) {
                URL.revokeObjectURL(this.fileSuratUrl);
            }

            this.fileSuratUrl = null;
        },

        savePengajuan() {
            if (this.selectedStatus === 'ditolak' && !this.catatanAdmin.trim()) {
                Swal.fire({
                    title: 'Catatan Wajib Diisi',
                    text: 'Catatan atau alasan wajib diisi jika pengajuan ditolak.',
                    icon: 'warning',
                    confirmButtonColor: '#0058bc',
                    confirmButtonText: 'Oke',
                    background: '#ffffffee',
                    backdrop: 'rgba(15,23,42,0.35)',
                    customClass: {
                        popup: 'rounded-[28px]',
                        confirmButton: 'rounded-full px-6 py-2'
                    }
                });

                return;
            }

            const fileInput = this.$refs.fileSurat;
            const hasNewFile = fileInput && fileInput.files && fileInput.files.length > 0;
            const hasExistingFile = !!this.selectedPengajuan?.file_surat;

            if (hasNewFile && this.selectedStatus !== 'selesai') {
                Swal.fire({
                    title: 'Status Belum Selesai',
                    text: 'Jika mengunggah dokumen balasan, status pengajuan harus diubah menjadi selesai.',
                    icon: 'warning',
                    confirmButtonColor: '#0058bc',
                    confirmButtonText: 'Oke',
                    background: '#ffffffee',
                    backdrop: 'rgba(15,23,42,0.35)',
                    customClass: {
                        popup: 'rounded-[28px]',
                        confirmButton: 'rounded-full px-6 py-2'
                    }
                });

                return;
            }

            if (this.selectedStatus === 'selesai' && !hasNewFile && !hasExistingFile) {
                Swal.fire({
                    title: 'Dokumen Balasan Wajib',
                    text: 'Upload dokumen balasan terlebih dahulu sebelum menyelesaikan pengajuan.',
                    icon: 'warning',
                    confirmButtonColor: '#0058bc',
                    confirmButtonText: 'Oke',
                    background: '#ffffffee',
                    backdrop: 'rgba(15,23,42,0.35)',
                    customClass: {
                        popup: 'rounded-[28px]',
                        confirmButton: 'rounded-full px-6 py-2'
                    }
                });

                return;
            }

            this.$refs.formPengajuan.submit();
        },

        deleteSurat() {
            if (!this.selectedPengajuan?.surat_delete_url) {
                return;
            }

            Swal.fire({
                title: 'Hapus Surat Balasan?',
                text: 'File surat balasan akan dihapus. Jika status pengajuan sudah selesai, status akan dikembalikan menjadi diproses.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                background: '#ffffffee',
                backdrop: 'rgba(15,23,42,0.35)',
                customClass: {
                    popup: 'rounded-[28px]',
                    confirmButton: 'rounded-full px-6 py-2',
                    cancelButton: 'rounded-full px-6 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs.formHapusSurat.setAttribute('action', this.selectedPengajuan.surat_delete_url);
                    this.$refs.formHapusSurat.submit();
                }
            });
        }
    }"
>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Berhasil',
                    text: @json(session('success')),
                    icon: 'success',
                    confirmButtonColor: '#0058bc',
                    confirmButtonText: 'Oke',
                    background: '#ffffffee',
                    backdrop: 'rgba(15,23,42,0.35)',
                    customClass: {
                        popup: 'rounded-[28px]',
                        confirmButton: 'rounded-full px-6 py-2'
                    }
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Gagal',
                    text: @json(session('errorr')),
                    icon: 'error',
                    confirmButtonColor: '#0058bc',
                    confirmButtonText: 'Oke',
                    background: '#ffffffee',
                    backdrop: 'rgba(15,23,42,0.35)',
                    customClass: {
                        popup: 'rounded-[28px]',
                        confirmButton: 'rounded-full px-6 py-2'
                    }
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Validasi Gagal',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    icon: 'error',
                    confirmButtonColor: '#0058bc',
                    confirmButtonText: 'Oke',
                    background: '#ffffffee',
                    backdrop: 'rgba(15,23,42,0.35)',
                    customClass: {
                        popup: 'rounded-[28px]',
                        confirmButton: 'rounded-full px-6 py-2'
                    }
                });
            });
        </script>
    @endif


     {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <h1 class="text-[32px] font-bold tracking-tight text-slate-900">
                Pengajuan Masuk
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola pengajuan surat.
            </p>

        </div>

    </div>

    {{-- FILTER --}}
    @php
        $filters = [
            'semua' => 'Semua',
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        $activeStatus = $status ?? 'semua';
    @endphp

    <div class="flex flex-wrap items-center gap-3 mb-8">
        @foreach ($filters as $key => $label)
            <a
                href="{{ $key === 'semua'
                    ? route('admin.pengajuan.index')
                    : route('admin.pengajuan.index', ['status' => $key]) }}"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 capitalize backdrop-blur-xl border border-white/40
                {{ $activeStatus === $key
                    ? 'bg-blue-600 text-white shadow-[0_4px_12px_rgba(0,112,235,0.25)]'
                    : 'bg-white/60 text-slate-600 hover:bg-white' }}"
            >
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- TABLE --}}
    <div class="rounded-[24px] overflow-hidden bg-white/55 backdrop-blur-xl border border-white/40 shadow-[0_12px_40px_rgba(0,112,235,0.08)]">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-white/40 bg-white/20">
                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            ID Pengajuan
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Nama Pemohon
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Jenis Surat
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Tanggal
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400">
                            Status
                        </th>

                        <th class="p-6 text-xs uppercase tracking-wider font-semibold text-slate-400 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/40">
                    @forelse ($pengajuan as $item)
                        @php
                            $nama = $item->mahasiswa->user->name ?? '-';
                            $inisial = collect(explode(' ', $nama))
                                ->filter()
                                ->map(fn ($word) => substr($word, 0, 1))
                                ->take(2)
                                ->implode('');

                            $statusClass = match ($item->status) {
                                'menunggu' => 'bg-slate-100 text-slate-600',
                                'diproses' => 'bg-violet-100 text-violet-600',
                                'selesai' => 'bg-blue-100 text-blue-600',
                                'ditolak' => 'bg-red-100 text-red-600',
                                default => 'bg-slate-100 text-slate-600',
                            };

                            $dotClass = match ($item->status) {
                                'menunggu' => 'bg-slate-500',
                                'diproses' => 'bg-violet-500',
                                'selesai' => 'bg-blue-500',
                                'ditolak' => 'bg-red-500',
                                default => 'bg-slate-500',
                            };

                            $avatarClass = match ($item->status) {
                                'menunggu' => 'bg-violet-100 text-violet-600',
                                'diproses' => 'bg-slate-200 text-slate-600',
                                'selesai' => 'bg-blue-100 text-blue-600',
                                'ditolak' => 'bg-red-100 text-red-600',
                                default => 'bg-blue-100 text-blue-600',
                            };
                        @endphp

                        <tr class="hover:bg-white/30 transition-colors">
                            <td class="p-6 text-[15px] font-semibold text-slate-800">
                                #REQ-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="p-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $avatarClass }}">
                                        {{ strtoupper($inisial ?: 'M') }}
                                    </div>

                                    <div class="text-[15px] text-slate-700">
                                        {{ $nama }}
                                    </div>
                                </div>
                            </td>

                            <td class="p-6 text-[15px] text-slate-500">
                                {{ $item->jenisSurat->nama_surat ?? '-' }}
                            </td>

                            <td class="p-6 text-[15px] text-slate-500">
                                {{ $item->tgl_ajuan
                                    ? \Carbon\Carbon::parse($item->tgl_ajuan)->translatedFormat('d M Y')
                                    : '-' }}
                            </td>

                            <td class="p-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-medium border border-white/50 {{ $statusClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $dotClass }}"></span>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <td class="p-6 text-center">
    @php
                                    $dokumenPertama = $item->dokumen->first();

                                    $detailPengajuan = [
                                        'id' => '#REQ-' . str_pad($item->id, 4, '0', STR_PAD_LEFT),
                                        'nama' => $item->mahasiswa->user->name ?? '-',
                                        'nim' => $item->mahasiswa->user->nim ?? '-',
                                        'jenis_surat' => $item->jenisSurat->nama_surat ?? '-',
                                        'tanggal' => $item->tgl_ajuan
                                            ? \Carbon\Carbon::parse($item->tgl_ajuan)->translatedFormat('d F Y')
                                            : '-',
                                        'keperluan' => $item->keperluan ?? '-',
                                        'status' => ucfirst($item->status),
                                        'status_raw' => $item->status,
                                        'catatan_admin' => $item->catatan_admin ?? '',
                                        'file_surat' => $item->file_surat ? basename($item->file_surat) : null,
                                        'surat_lihat_url' => $item->file_surat
                                            ? route('admin.pengajuan.surat.lihat', $item->id)
                                            : null,
                                        'surat_download_url' => $item->file_surat
                                            ? route('admin.pengajuan.surat.download', $item->id)
                                            : null,
                                        'surat_delete_url' => $item->file_surat
                                            ? route('admin.pengajuan.surat.hapus', $item->id)
                                            : null,
                                        'update_url' => route('admin.pengajuan.update', $item->id),
                                        'dokumen_pemohon' => $dokumenPertama ? [
                                            'nama' => $dokumenPertama->dokumenSyarat->nama_dokumen ?? 'Dokumen Pemohon',
                                            'original_name' => $dokumenPertama->original_name ?? 'Dokumen Pemohon',
                                            'file_size' => $dokumenPertama->file_size
                                                ? number_format($dokumenPertama->file_size / 1024, 1) . ' KB'
                                                : '-',
                                            'lihat_url' => route('admin.pengajuan.dokumen.lihat', $dokumenPertama->id),
                                            'download_url' => route('admin.pengajuan.dokumen.download', $dokumenPertama->id),
                                        ] : null,
                                    ];
                                @endphp

    <button
        type="button"
        @click="openDetail({{ Illuminate\Support\Js::from($detailPengajuan) }})"
        class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-colors"
    >
        <span class="material-symbols-outlined">
            visibility
        </span>
    </button>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Belum ada data pengajuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pengajuan->hasPages())
            <div class="p-6 border-t border-white/40">
                {{ $pengajuan->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL --}}
    <div
        x-show="openModal"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center p-4"
        style="display:none;"
    >
        {{-- BACKDROP --}}
        <div
            @click="closeModal()"
            class="absolute inset-0 z-[998] bg-black/20 backdrop-blur-md"
        ></div>

        {{-- MODAL CONTENT --}}
        <form
            x-ref="formPengajuan"
            method="POST"
            :action="selectedPengajuan?.update_url ?? '#'"
            enctype="multipart/form-data"
            class="relative z-[1000] w-full max-w-2xl max-h-[92vh] overflow-hidden rounded-[24px] bg-white/90 backdrop-blur-2xl border border-white/50 shadow-[0_24px_80px_rgba(0,112,235,0.18)] flex flex-col"
        >
            @csrf
            @method('PATCH')

            {{-- HEADER --}}
            <div class="px-8 py-5 border-b border-white/40 bg-white/30 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-[32px] font-bold tracking-tight text-slate-900">
                        Review Pengajuan
                    </h2>

                    <p class="mt-1 text-sm font-semibold text-blue-600" x-text="selectedPengajuan?.id ?? '-'"></p>
                </div>

                <button
                    type="button"
                    @click="closeModal()"
                    class="w-9 h-9 rounded-full flex items-center justify-center text-slate-400 hover:bg-white/50 hover:text-red-500 transition-colors"
                >
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </button>
            </div>

            {{-- BODY --}}
            <div class="overflow-y-auto flex-1 p-8 space-y-7">

                {{-- INFORMASI --}}
                <section>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-semibold mb-3">
                        Informasi Pemohon
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-white/40 border border-white/50">
                            <p class="text-xs text-slate-400 mb-1">
                                Nama Pemohon
                            </p>

                            <p class="text-[15px] font-semibold text-slate-800" x-text="selectedPengajuan?.nama ?? '-'"></p>
                        </div>

                        <div class="p-4 rounded-xl bg-white/40 border border-white/50">
                            <p class="text-xs text-slate-400 mb-1">
                                NIM
                            </p>

                            <p class="text-[15px] font-semibold text-slate-800" x-text="selectedPengajuan?.nim ?? '-'"></p>
                        </div>

                        <div class="p-4 rounded-xl bg-white/40 border border-white/50">
                            <p class="text-xs text-slate-400 mb-1">
                                Jenis Surat
                            </p>

                            <p class="text-[15px] font-semibold text-slate-800" x-text="selectedPengajuan?.jenis_surat ?? '-'"></p>
                        </div>

                        <div class="p-4 rounded-xl bg-white/40 border border-white/50">
                            <p class="text-xs text-slate-400 mb-1">
                                Tanggal Pengajuan
                            </p>

                            <p class="text-[15px] font-semibold text-slate-800" x-text="selectedPengajuan?.tanggal ?? '-'"></p>
                        </div>
                    </div>
                </section>

                {{-- DETAIL KEPERLUAN --}}
                <section>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-semibold mb-3">
                        Detail Keperluan
                    </p>

                    <div class="p-4 rounded-xl bg-white/40 border border-white/50">
                        <p class="text-xs text-slate-400 mb-1">
                            Keperluan
                        </p>

                        <p class="text-[15px] font-semibold text-slate-800 leading-relaxed" x-text="selectedPengajuan?.keperluan ?? '-'"></p>
                    </div>
                </section>

                {{-- BERKAS --}}
                <section>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-semibold mb-3">
                        Berkas Dari Pemohon
                    </p>

                    <div class="space-y-4">
                        <div class="rounded-2xl bg-white/50 border border-white/60 overflow-hidden">
                            <div class="flex items-center justify-between p-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[20px]">
                                            picture_as_pdf
                                        </span>
                                    </div>

                                    <div>
                                        <p class="text-[14px] font-medium text-slate-800" x-text="selectedPengajuan?.dokumen_pemohon?.nama ?? 'Dokumen Pemohon'">
                                        </p>

                                        <p class="text-xs text-slate-400" x-text="selectedPengajuan?.dokumen_pemohon?.original_name ?? 'Belum tersedia'">
                                        </p>
                                    </div>
                                </div>

                                <a
                                    :href="selectedPengajuan?.dokumen_pemohon?.download_url ?? '#'"
                                    class="px-4 py-2 rounded-xl bg-blue-50 text-blue-600 text-sm font-semibold hover:bg-blue-100 transition-colors"
                                >
                                    Download
                                </a>
                            </div>

                            <div class="aspect-video bg-slate-100 flex items-center justify-center">
                                <div class="text-center">
                                    <span class="material-symbols-outlined text-[64px] text-slate-300">
                                        description
                                    </span>

                                    <p class="text-sm text-slate-400 mt-2">
                                        Preview Dokumen
                                    </p>

                                    <a
                                        x-show="selectedPengajuan?.dokumen_pemohon?.lihat_url"
                                        :href="selectedPengajuan?.dokumen_pemohon?.lihat_url ?? '#'"
                                        target="_blank"
                                        class="inline-flex mt-3 px-4 py-2 rounded-xl bg-white text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors border border-slate-200"
                                    >
                                        Lihat Dokumen
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- TINDAKAN --}}
                <section>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-semibold mb-3">
                        Tindakan Admin
                    </p>

                    <div class="space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Update Status
                            </label>

                            <select
                                name="status"
                                x-model="selectedStatus"
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white/70 text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="menunggu">Menunggu</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Catatan / Alasan
                            </label>

                            <textarea
                                name="catatan_admin"
                                rows="3"
                                placeholder="Tambahkan catatan untuk pemohon..."
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white/70 resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                x-model="catatanAdmin"
                            ></textarea>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Upload Dokumen Balasan
                            </label>

                            <label
                                class="flex flex-col items-center justify-center
                                       w-full p-8 rounded-[24px]
                                       border-2 border-dashed border-slate-200
                                       bg-white/50 hover:bg-white/70
                                       transition-all cursor-pointer"
                            >
                                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-[28px]">
                                        upload_file
                                    </span>
                                </div>

                                <p class="text-[15px] font-semibold text-slate-700">
                                    Upload Dokumen Balasan
                                </p>

                                <p class="text-sm text-slate-400 mt-1">
                                    PDF maksimal 5MB
                                </p>

                                <input
                                    type="file"
                                    name="file_surat"
                                    x-ref="fileSurat"
                                    @change="handleFileSurat($event)"
                                    class="hidden"
                                    accept=".pdf,application/pdf"
                                >
                            </label>
                        </div>

                        <div
                            x-show="selectedPengajuan?.file_surat || fileSuratName"
                            class="rounded-2xl bg-white/50 border border-white/60 p-4"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined">
                                            description
                                        </span>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-[14px] font-medium text-slate-800">
                                            Surat Balasan
                                        </p>

                                        <p
                                            class="text-xs text-slate-400 truncate"
                                            x-text="fileSuratName ?? selectedPengajuan?.file_surat"
                                        ></p>

                                        <p
                                            x-show="fileSuratName"
                                            class="text-[11px] text-blue-500 mt-1"
                                        >
                                            File baru dipilih, belum disimpan.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    <a
                                        x-show="fileSuratUrl || selectedPengajuan?.surat_lihat_url"
                                        :href="fileSuratUrl ?? selectedPengajuan?.surat_lihat_url ?? '#'"
                                        target="_blank"
                                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-colors"
                                        title="Lihat surat"
                                    >
                                        <span class="material-symbols-outlined">
                                            visibility
                                        </span>
                                    </a>

                                    <a
                                        x-show="fileSuratUrl || selectedPengajuan?.surat_download_url"
                                        :href="fileSuratUrl ?? selectedPengajuan?.surat_download_url ?? '#'"
                                        :download="fileSuratName ?? null"
                                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-colors"
                                        title="Download surat"
                                    >
                                        <span class="material-symbols-outlined">
                                            download
                                        </span>
                                    </a>

                                    <button
                                        type="button"
                                        x-show="fileSuratName"
                                        @click="clearFileSurat()"
                                        class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors"
                                        title="Batalkan file baru"
                                    >
                                        <span class="material-symbols-outlined">
                                            close
                                        </span>
                                    </button>

                                    <button
                                        type="button"
                                        x-show="selectedPengajuan?.surat_delete_url && !fileSuratName"
                                        @click="deleteSurat()"
                                        class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors"
                                        title="Hapus surat"
                                    >
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- FOOTER --}}
            <div class="px-8 py-5 border-t border-white/40 bg-white/20 flex items-center justify-between shrink-0">
                <button
                    type="button"
                    @click="closeModal()"
                    class="px-6 py-2.5 rounded-full text-sm font-semibold bg-white/70 text-slate-700 hover:bg-white transition-all border border-white/50"
                >
                    Batal
                </button>

                <button
                    type="button"
                    @click="savePengajuan()"
                    class="px-7 py-2.5 rounded-full text-sm font-semibold bg-blue-600 text-white shadow-[0_4px_16px_rgba(0,112,235,0.3)] hover:brightness-110 transition-all flex items-center gap-2"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        save
                    </span>

                    Simpan Perubahan
                </button>
            </div>
        </form>

        <form
            x-ref="formHapusSurat"
            method="POST"
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>
    </div>
</main>
@endsection