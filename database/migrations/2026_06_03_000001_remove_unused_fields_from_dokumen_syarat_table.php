<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen_syarat', function (Blueprint $table) {
            if (Schema::hasColumn('dokumen_syarat', 'is_wajib')) {
                $table->dropColumn('is_wajib');
            }

            if (Schema::hasColumn('dokumen_syarat', 'berlaku_untuk')) {
                $table->dropColumn('berlaku_untuk');
            }

            if (Schema::hasColumn('dokumen_syarat', 'urutan')) {
                $table->dropColumn('urutan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_syarat', function (Blueprint $table) {
            if (! Schema::hasColumn('dokumen_syarat', 'is_wajib')) {
                $table->boolean('is_wajib')->default(true)->after('max_size');
            }

            if (! Schema::hasColumn('dokumen_syarat', 'berlaku_untuk')) {
                $table->string('berlaku_untuk')->nullable()->after('is_wajib');
            }

            if (! Schema::hasColumn('dokumen_syarat', 'urutan')) {
                $table->unsignedInteger('urutan')->default(1)->after('berlaku_untuk');
            }
        });
    }
};
