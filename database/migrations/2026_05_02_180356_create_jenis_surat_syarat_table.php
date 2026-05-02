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
        Schema::create('jenis_surat_syarat', function (Blueprint $table) {
        $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
        $table->foreignId('dokumen_syarat_id')->constrained('dokumen_syarat')->onDelete('cascade');
        $table->primary(['jenis_surat_id', 'dokumen_syarat_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surat_syarat');
    }
};
