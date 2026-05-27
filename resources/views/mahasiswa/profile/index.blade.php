@extends('layouts.mahasiswa')

@section('title', 'Profil Saya')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <section class="glass-panel rounded-[28px] p-8">

        <h1 class="text-4xl font-black text-on-surface">
            Profil Saya
        </h1>

        <p class="mt-3 text-on-surface-variant text-lg">
            Informasi data mahasiswa Anda.
        </p>

    </section>

    {{-- PROFILE CARD --}}
    <section class="glass-panel rounded-[28px] p-8">

        <div class="flex items-center gap-6">

            <div class="w-24 h-24 rounded-full bg-slate-200"></div>

            <div>

                <h2 class="text-3xl font-black">
                    Aliza Beth
                </h2>

                <p class="text-on-surface-variant mt-1">
                    Mahasiswa Sistem Informasi
                </p>

            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">

            <div>

                <p class="text-sm text-on-surface-variant">
                    NIM
                </p>

                <h3 class="text-xl font-bold mt-1">
                    221011400123
                </h3>

            </div>

            <div>

                <p class="text-sm text-on-surface-variant">
                    Email
                </p>

                <h3 class="text-xl font-bold mt-1">
                    aliza@student.ac.id
                </h3>

            </div>

            <div>

                <p class="text-sm text-on-surface-variant">
                    Program Studi
                </p>

                <h3 class="text-xl font-bold mt-1">
                    Teknologi Informasi
                </h3>

            </div>

            <div>

                <p class="text-sm text-on-surface-variant">
                    Fakultas
                </p>

                <h3 class="text-xl font-bold mt-1">
                    Ilmu Komputer
                </h3>

            </div>

        </div>

    </section>

</div>

@endsection