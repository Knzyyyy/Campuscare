<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: tabel program studi.
     */
    public function up(): void
    {
        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_id')->constrained('fakultas')->cascadeOnDelete();
            $table->string('kode', 20)->unique()->comment('Kode singkat prodi, misal: TI');
            $table->string('nama');
            $table->string('jenjang', 10)->default('S1')->comment('S1, S2, S3, D3, dll');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['fakultas_id', 'is_active']);
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
