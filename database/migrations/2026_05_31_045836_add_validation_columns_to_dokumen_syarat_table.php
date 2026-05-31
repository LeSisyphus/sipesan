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
        Schema::table('dokumen_syarat', function (Blueprint $table) {
            $table->string('allowed_formats')->default('pdf,jpg,jpeg,png')->after('keterangan');
            $table->integer('max_size')->default(5)->after('allowed_formats'); // in MB
            $table->boolean('is_wajib')->default(true)->after('max_size');
            $table->string('berlaku_untuk')->default('Semua Mahasiswa')->after('is_wajib');
            $table->integer('urutan')->default(1)->after('berlaku_untuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen_syarat', function (Blueprint $table) {
            $table->dropColumn(['allowed_formats', 'max_size', 'is_wajib', 'berlaku_untuk', 'urutan']);
        });
    }
};
