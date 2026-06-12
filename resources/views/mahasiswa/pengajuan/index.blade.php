@extends('layouts.mahasiswa')

@section('title', 'Buat Pengajuan')

@section('content')
@php
    $jenisSuratOptions = $jenisSurat->map(function ($surat) {
        return [
            'id' => (string) $surat->id,
            'nama_surat' => $surat->nama_surat,
            'deskripsi' => $surat->deskripsi,
            'dokumen_syarat' => $surat->dokumenSyarat->map(function ($dokumen) {
                return [
                    'id' => (string) $dokumen->id,
                    'nama_dokumen' => $dokumen->nama_dokumen,
                    'keterangan' => $dokumen->keterangan,
                    'allowed_formats' => $dokumen->allowed_formats ?: 'pdf,jpg,jpeg,png',
                    'max_size' => (int) ($dokumen->max_size ?: 5),
                ];
            })->values(),
        ];
    })->values();

    $tahunSekarang = now()->year;
    $tahunAjaranOptions = [
        ($tahunSekarang - 1) . '/' . $tahunSekarang,
        $tahunSekarang . '/' . ($tahunSekarang + 1),
        ($tahunSekarang + 1) . '/' . ($tahunSekarang + 2),
    ];
@endphp

<div
    x-data="pengajuanForm({
        jenisSurat: @js($jenisSuratOptions),
        oldJenisSuratId: @js((string) old('jenis_surat_id', ''))
    })"
    x-init="init()"
    class="max-w-[1400px] mx-auto space-y-8"
>
    {{-- HEADER --}}
    <div>
        <h1 class="text-[40px] font-medium text-slate-900">
            Buat Pengajuan Baru
        </h1>

        <p class="mt-2 text-slate-500 text-lg">
            Lengkapi data pengajuan dan unggah berkas persyaratan sesuai jenis surat.
        </p>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="glass-panel rounded-[20px] p-4 border border-green-200 bg-green-50/80 text-green-700 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="glass-panel rounded-[20px] p-5 border border-red-200 bg-red-50/80 text-red-700">
            <div class="flex items-start gap-3">
                <span class="material-symbols-rounded">error</span>
                <div>
                    <h3 class="font-bold">Pengajuan belum bisa dikirim.</h3>
                    <ul class="list-disc ml-5 mt-2 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- STEPPER --}}
    <div class="glass-panel rounded-[24px] p-6">
        <div class="relative max-w-3xl mx-auto">
            {{-- BACKGROUND LINE --}}
            <div class="absolute top-5 left-0 w-full h-[4px] bg-slate-200 rounded-full"></div>

            {{-- PROGRESS LINE --}}
            <div
                class="absolute top-5 left-0 h-[4px] bg-primary rounded-full transition-all duration-500"
                :style="{
                    width:
                        step === 1 ? '0%' :
                        step === 2 ? '50%' :
                        '100%'
                }"
            ></div>

            {{-- STEPS --}}
            <div class="relative flex items-center justify-between">
                {{-- STEP 1 --}}
                <div class="flex flex-col items-center gap-2 z-10">
                    <div
                        :class="step >= 1
                            ? 'bg-primary text-white step-circle active'
                            : 'bg-slate-200 text-slate-500 step-circle'"
                        class="w-11 h-11 rounded-full flex items-center justify-center"
                    >
                        <span class="material-symbols-rounded">edit_note</span>
                    </div>

                    <span class="text-sm font-semibold">Isi Form</span>
                </div>

                {{-- STEP 2 --}}
                <div class="flex flex-col items-center gap-2 z-10">
                    <div
                        :class="step >= 2
                            ? 'bg-primary text-white step-circle active'
                            : 'bg-slate-200 text-slate-500 step-circle'"
                        class="w-11 h-11 rounded-full flex items-center justify-center shadow-lg shadow-blue-500/20"
                    >
                        <template x-if="step < 2">
                            <span class="text-sm font-bold">2</span>
                        </template>

                        <template x-if="step >= 2">
                            <span class="material-symbols-rounded">upload_file</span>
                        </template>
                    </div>

                    <span class="text-sm font-semibold">Upload Berkas</span>
                </div>

                {{-- STEP 3 --}}
                <div class="flex flex-col items-center gap-2 z-10">
                    <div
                        :class="step >= 3
                            ? 'bg-primary text-white step-circle active'
                            : 'bg-slate-200 text-slate-500 step-circle'"
                        class="w-11 h-11 rounded-full flex items-center justify-center"
                    >
                        <span class="material-symbols-rounded">check_circle</span>
                    </div>

                    <span class="text-sm font-semibold">Selesai</span>
                </div>
            </div>
        </div>
    </div>

    <form
        action="{{ route('mahasiswa.pengajuan.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-8"
    >
        @csrf

        {{-- STEP 1 --}}
        <div x-show="step === 1" x-transition.opacity class="step-panel">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
                {{-- DATA DIRI --}}
                <div class="glass-panel animated-glass hover-float rounded-[28px] p-7 space-y-5 self-start">
                    <h2 class="text-[28px] font-medium text-slate-900">
                        Data Diri
                    </h2>

                    @if (! $mahasiswa)
                        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            Profil mahasiswa untuk akun ini belum tersedia. Form tidak bisa dikirim sebelum admin melengkapi data mahasiswa.
                        </div>
                    @endif

                    {{-- Implementasi komponen x-form-input biar DRY --}}
                    <x-form-input id="nama" label="Nama Lengkap" value="{{ $user->name }}" readonly="true" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-form-input id="nim" label="NIM" value="{{ $user->nim ?? '-' }}" readonly="true" />
                        <x-form-input id="angkatan" label="Angkatan" value="{{ $mahasiswa?->angkatan ?? '-' }}" readonly="true" />
                    </div>

                    <x-form-input id="prodi" label="Program Studi" value="{{ $mahasiswa?->prodi?->nama_prodi ?? '-' }}" readonly="true" />

                    <div>
                        <label for="alamat_lengkap" class="block mb-2 text-sm font-semibold text-slate-500">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            id="alamat_lengkap"
                            name="alamat_lengkap"
                            rows="4"
                            class="glass-input w-full px-5 py-3 resize-none @error('alamat_lengkap') border-red-400 @enderror"
                            placeholder="Masukkan alamat lengkap sesuai kebutuhan surat"
                            required
                        >{{ old('alamat_lengkap') }}</textarea>

                        @error('alamat_lengkap')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- DATA AKADEMIK --}}
                <div class="glass-panel animated-glass hover-float rounded-[28px] p-7 space-y-5">
                    <h2 class="text-[28px] font-medium text-slate-900">
                        Data Akademik
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="tahun_ajaran" class="block mb-2 text-sm font-semibold text-slate-500">
                                Tahun Ajaran <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="tahun_ajaran"
                                name="tahun_ajaran"
                                class="glass-input w-full px-5 py-3 @error('tahun_ajaran') border-red-400 @enderror"
                                required
                            >
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($tahunAjaranOptions as $tahunAjaran)
                                    <option
                                        value="{{ $tahunAjaran }}"
                                        @selected(old('tahun_ajaran') === $tahunAjaran)
                                    >
                                        {{ $tahunAjaran }}
                                    </option>
                                @endforeach
                            </select>

                            @error('tahun_ajaran')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="semester" class="block mb-2 text-sm font-semibold text-slate-500">
                                Semester <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="semester"
                                name="semester"
                                class="glass-input w-full px-5 py-3 @error('semester') border-red-400 @enderror"
                                required
                            >
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil" @selected(old('semester') === 'Ganjil')>Ganjil</option>
                                <option value="Genap" @selected(old('semester') === 'Genap')>Genap</option>
                            </select>

                            @error('semester')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="jenis_surat_id" class="block mb-2 text-sm font-semibold text-slate-500">
                            Jenis Surat <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="jenis_surat_id"
                            name="jenis_surat_id"
                            x-model="selectedJenisSuratId"
                            @change="syncSelectedJenisSurat()"
                            class="glass-input w-full px-5 py-3 @error('jenis_surat_id') border-red-400 @enderror"
                            required
                        >
                            <option value="">Pilih Jenis Surat</option>
                            @foreach ($jenisSurat as $surat)
                                <option
                                    value="{{ $surat->id }}"
                                    @selected((string) old('jenis_surat_id') === (string) $surat->id)
                                >
                                    {{ $surat->nama_surat }}
                                </option>
                            @endforeach
                        </select>

                        @error('jenis_surat_id')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="selectedJenisSurat" x-transition class="rounded-[22px] bg-white/60 border border-white/70 p-5 space-y-3">
                        <div>
                            <h3 class="font-bold text-slate-800" x-text="selectedJenisSurat?.nama_surat"></h3>
                            <p class="text-sm text-slate-500 mt-1" x-text="selectedJenisSurat?.deskripsi || 'Tidak ada deskripsi tambahan.'"></p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-600 mb-2">Dokumen syarat:</p>

                            <template x-if="selectedDokumen.length > 0">
                                <ul class="space-y-2">
                                    <template x-for="dokumen in selectedDokumen" :key="dokumen.id">
                                        <li class="flex items-start gap-2 text-sm text-slate-600">
                                            <span class="material-symbols-rounded text-primary text-[18px] mt-0.5">check_circle</span>
                                            <div>
                                                <span class="font-semibold" x-text="dokumen.nama_dokumen"></span>
                                                <p class="text-xs text-slate-500" x-show="dokumen.keterangan" x-text="dokumen.keterangan"></p>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </template>

                            <template x-if="selectedDokumen.length === 0">
                                <p class="text-sm text-slate-500">
                                    Jenis surat ini belum memiliki dokumen syarat. Pengajuan tetap bisa dikirim tanpa upload berkas.
                                </p>
                            </template>
                        </div>
                    </div>

                    <div>
                        <label for="keperluan" class="block mb-2 text-sm font-semibold text-slate-500">
                            Keperluan Pengajuan <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            id="keperluan"
                            name="keperluan"
                            rows="6"
                            class="glass-input w-full px-5 py-3 resize-none @error('keperluan') border-red-400 @enderror"
                            placeholder="Contoh: Digunakan untuk melengkapi persyaratan beasiswa / magang / administrasi kampus."
                            required
                        >{{ old('keperluan') }}</textarea>

                        @error('keperluan')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end mt-8">
                <button
                    type="button"
                    @click="nextStep()"
                    class="px-8 py-3 rounded-full bg-primary text-white glow-button font-semibold hover:brightness-110 transition-all"
                >
                    Lanjut
                </button>
            </div>
        </div>

        {{-- STEP 2 --}}
        <div x-show="step === 2" x-transition.opacity class="step-panel">
            <div class="glass-panel animated-glass hover-float rounded-[28px] p-7 space-y-6">
                <div>
                    <h2 class="text-[28px] font-bold text-slate-900">
                        Upload Berkas
                    </h2>

                    <p class="text-slate-500 mt-1">
                        Upload file pendukung sesuai dokumen syarat dari jenis surat yang dipilih.
                    </p>
                </div>

                <template x-if="! selectedJenisSurat">
                    <div class="rounded-[24px] border border-yellow-200 bg-yellow-50 p-5 text-yellow-700 flex items-start gap-3">
                        <span class="material-symbols-rounded">info</span>
                        <div>
                            <h3 class="font-bold">Jenis surat belum dipilih.</h3>
                            <p class="text-sm mt-1">Silakan kembali ke langkah pertama dan pilih jenis surat terlebih dahulu.</p>
                        </div>
                    </div>
                </template>

                <template x-if="selectedJenisSurat && selectedDokumen.length === 0">
                    <div class="rounded-[24px] border border-blue-200 bg-blue-50 p-5 text-blue-700 flex items-start gap-3">
                        <span class="material-symbols-rounded">task_alt</span>
                        <div>
                            <h3 class="font-bold">Tidak ada dokumen syarat.</h3>
                            <p class="text-sm mt-1">Jenis surat ini belum memiliki dokumen syarat. Kamu bisa langsung mengirim pengajuan.</p>
                        </div>
                    </div>
                </template>

                <div
                    x-show="selectedDokumen.length > 0"
                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5"
                >
                    <template x-for="dokumen in selectedDokumen" :key="dokumen.id">
                        <label
                            :for="`berkas-${dokumen.id}`"
                            class="upload-card border-2 border-dashed rounded-[24px] p-6 flex flex-col items-center justify-center text-center gap-3 cursor-pointer hover:border-primary transition-all"
                            :class="uploadedFiles[dokumen.id]
                                ? 'border-primary bg-blue-50/60'
                                : 'border-slate-300 bg-white/50'"
                        >
                            <span
                                class="material-symbols-rounded text-[40px] text-primary"
                                x-text="uploadedFiles[dokumen.id] ? 'task_alt' : 'upload_file'"
                            ></span>

                            <div>
                                <h3 class="font-bold text-slate-800" x-text="dokumen.nama_dokumen"></h3>
                                <p
                                    class="text-sm text-slate-500 mt-1"
                                    x-text="getUploadRuleText(dokumen)"
                                ></p>
                                <p class="text-xs text-slate-400 mt-1" x-show="dokumen.keterangan" x-text="dokumen.keterangan"></p>
                            </div>

                            <input
                                type="file"
                                class="hidden"
                                :id="`berkas-${dokumen.id}`"
                                :name="`berkas[${dokumen.id}]`"
                                :accept="getAcceptedFileTypes(dokumen)"
                                required
                                @change="handleFileChange($event, dokumen)"
                            >

                            <template x-if="! uploadedFiles[dokumen.id]">
                                <span class="text-xs text-slate-400">
                                    Klik kartu untuk memilih file
                                </span>
                            </template>

                            <template x-if="uploadedFiles[dokumen.id]">
                                <div class="w-full rounded-2xl bg-white/80 border border-primary/20 px-4 py-3 flex items-start gap-3 text-left shadow-sm">
                                    <span class="material-symbols-rounded text-primary text-[22px] shrink-0 mt-0.5">
                                        attach_file
                                    </span>

                                    <div class="min-w-0 flex-1">
                                        <p
                                            class="text-sm font-semibold text-slate-800 truncate"
                                            x-text="uploadedFiles[dokumen.id]?.name"
                                        ></p>
                                        <p
                                            class="text-xs text-slate-500 mt-0.5"
                                            x-text="formatFileSize(uploadedFiles[dokumen.id]?.size)"
                                        ></p>
                                    </div>

                                    <button
                                        type="button"
                                        class="w-7 h-7 rounded-full bg-slate-100 hover:bg-red-50 text-slate-500 hover:text-red-500 flex items-center justify-center transition-all shrink-0"
                                        title="Hapus file"
                                        @click.stop.prevent="clearFile(dokumen.id)"
                                    >
                                        <span class="material-symbols-rounded text-[18px]">close</span>
                                    </button>
                                </div>
                            </template>
                        </label>
                    </template>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="flex items-center justify-between mt-8">
                <button
                    type="button"
                    @click="prevStep()"
                    class="px-8 py-3 rounded-full glass-panel font-semibold"
                >
                    Kembali
                </button>

                <button
                    type="submit"
                    class="px-8 py-3 rounded-full bg-primary text-white glow-button font-semibold disabled:opacity-60 disabled:cursor-not-allowed"
                    @disabled(! $mahasiswa)
                >
                    Kirim Pengajuan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function pengajuanForm(payload) {
        return {
            step: 1,
            jenisSurat: payload.jenisSurat || [],
            selectedJenisSuratId: payload.oldJenisSuratId || '',
            selectedJenisSurat: null,
            selectedDokumen: [],
            uploadedFiles: {},

            init() {
                this.syncSelectedJenisSurat();
            },

            nextStep() {
                if (this.step < 2) {
                    this.step++;
                }
            },

            prevStep() {
                if (this.step > 1) {
                    this.step--;
                }
            },

            syncSelectedJenisSurat() {
                this.selectedJenisSurat = this.jenisSurat.find((item) => {
                    return String(item.id) === String(this.selectedJenisSuratId);
                }) || null;

                this.selectedDokumen = this.selectedJenisSurat
                    ? (this.selectedJenisSurat.dokumen_syarat || [])
                    : [];

                this.uploadedFiles = {};
            },

            getAllowedFormats(dokumen) {
                const formats = dokumen.allowed_formats || 'pdf,jpg,jpeg,png';

                if (Array.isArray(formats)) {
                    return formats
                        .map((format) => String(format).trim().replace('.', '').toLowerCase())
                        .filter(Boolean);
                }

                return formats
                    .split(',')
                    .map((format) => format.trim().replace('.', '').toLowerCase())
                    .filter(Boolean);
            },

            getUploadRuleText(dokumen) {
                const formats = this.getAllowedFormats(dokumen)
                    .map((format) => format.toUpperCase())
                    .join(' / ');

                const maxSize = Number(dokumen.max_size || 5);

                return `${formats}, maksimal ${maxSize} MB`;
            },

            getAcceptedFileTypes(dokumen) {
                return this.getAllowedFormats(dokumen)
                    .map((format) => `.${format}`)
                    .join(',');
            },

            handleFileChange(event, dokumen) {
                const file = event.target.files[0];

                if (! file) {
                    delete this.uploadedFiles[dokumen.id];
                    return;
                }

                const allowedFormats = this.getAllowedFormats(dokumen);
                const maxSizeMb = Number(dokumen.max_size || 5);
                const maxSizeBytes = maxSizeMb * 1024 * 1024;
                const extension = file.name.split('.').pop().toLowerCase();

                if (! allowedFormats.includes(extension)) {
                    alert(`Format file ${dokumen.nama_dokumen} harus ${allowedFormats.map((format) => format.toUpperCase()).join(' / ')}.`);
                    event.target.value = '';
                    delete this.uploadedFiles[dokumen.id];
                    return;
                }

                if (file.size > maxSizeBytes) {
                    alert(`Ukuran file ${dokumen.nama_dokumen} maksimal ${maxSizeMb} MB.`);
                    event.target.value = '';
                    delete this.uploadedFiles[dokumen.id];
                    return;
                }

                this.uploadedFiles[dokumen.id] = {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                };
            },

            clearFile(dokumenId) {
                const input = document.getElementById(`berkas-${dokumenId}`);

                if (input) {
                    input.value = '';
                }

                delete this.uploadedFiles[dokumenId];
            },

            formatFileSize(size) {
                if (! size) {
                    return '';
                }

                if (size < 1024 * 1024) {
                    return `${(size / 1024).toFixed(1)} KB`;
                }

                return `${(size / (1024 * 1024)).toFixed(2)} MB`;
            }
        }
    }
</script>
@endsection