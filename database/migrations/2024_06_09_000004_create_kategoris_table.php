<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: tabel kategori layanan kampus.
     */
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('ikon')->nullable()->comment('Nama icon atau path icon kategori');
            $table->string('warna', 20)->default('#2563EB')->comment('Warna badge kategori');

            // Null = kategori global; terisi = kategori khusus fakultas tertentu
            $table->foreignId('fakultas_id')->nullable()
                ->constrained('fakultas')->nullOnDelete();

            $table->unsignedSmallInteger('estimasi_hari')->default(3)
                ->comment('Estimasi penyelesaian dalam hari kerja');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['fakultas_id', 'is_active']);
            $table->index('urutan');
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
