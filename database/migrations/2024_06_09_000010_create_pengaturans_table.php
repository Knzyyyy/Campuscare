<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: pengaturan aplikasi (dikelola Super Admin).
     */
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('kunci')->unique()->comment('Key pengaturan, misal: app_name');
            $table->text('nilai')->nullable();
            $table->string('tipe', 20)->default('string')
                ->comment('Tipe data: string, boolean, integer, json');
            $table->string('grup', 50)->default('umum')
                ->comment('Grup pengaturan: umum, notifikasi, laporan, dll');
            $table->string('label');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
