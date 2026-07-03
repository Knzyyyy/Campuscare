<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: relasi staff dengan kategori yang ditangani.
     * Memudahkan admin saat assign staff ke laporan.
     */
    public function up(): void
    {
        Schema::create('staff_kategoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()
                ->comment('Staff/teknisi');
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'kategori_id']);
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_kategoris');
    }
};
