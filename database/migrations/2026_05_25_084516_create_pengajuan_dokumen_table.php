<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_dokumen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_id')
                ->constrained('pengajuan')
                ->cascadeOnDelete();

            $table->foreignId('dokumen_syarat_id')
                ->constrained('dokumen_syarat')
                ->restrictOnDelete();

            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->timestamps();

            $table->unique(['pengajuan_id', 'dokumen_syarat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_dokumen');
    }
};