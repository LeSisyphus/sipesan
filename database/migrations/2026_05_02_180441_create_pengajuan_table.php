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
       Schema::create('pengajuan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
        $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
        $table->text('keperluan');
        $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
        $table->date('tgl_ajuan');
        $table->date('tgl_proses')->nullable();
        $table->text('catatan_admin')->nullable();
        $table->string('file_surat')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
