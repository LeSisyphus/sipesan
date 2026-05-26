<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prodi', function (Blueprint $table) {
            $table->string('kode_prodi')->unique()->after('id');
            $table->enum('jenjang', ['S1', 'D3', 'D4', 'S2'])->after('nama_prodi');
            $table->enum('akreditasi', ['A', 'B', 'C'])->default('B')->after('jenjang');
            $table->string('ketua_prodi')->nullable()->after('fakultas');
            $table->integer('tahun_berdiri')->nullable()->after('ketua_prodi');
            $table->text('deskripsi')->nullable()->after('tahun_berdiri');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prodi', function (Blueprint $table) {
            $table->dropColumn([
                'kode_prodi',
                'jenjang',
                'akreditasi',
                'ketua_prodi',
                'tahun_berdiri',
                'deskripsi',
                'status'
            ]);
        });
    }
};
