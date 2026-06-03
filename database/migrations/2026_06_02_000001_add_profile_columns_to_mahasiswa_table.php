<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (! Schema::hasColumn('mahasiswa', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('no_hp');
            }

            if (! Schema::hasColumn('mahasiswa', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }

            if (! Schema::hasColumn('mahasiswa', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('tanggal_lahir');
            }

            if (! Schema::hasColumn('mahasiswa', 'alamat')) {
                $table->text('alamat')->nullable()->after('jenis_kelamin');
            }

            if (! Schema::hasColumn('mahasiswa', 'email_alternatif')) {
                $table->string('email_alternatif')->nullable()->after('alamat');
            }

            if (! Schema::hasColumn('mahasiswa', 'kontak_darurat')) {
                $table->string('kontak_darurat')->nullable()->after('email_alternatif');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $columns = [
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'alamat',
                'email_alternatif',
                'kontak_darurat',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('mahasiswa', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
