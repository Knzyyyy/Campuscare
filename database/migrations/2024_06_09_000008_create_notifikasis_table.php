<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: notifikasi in-app untuk pengguna.
     */
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('laporan_id')->nullable()->constrained('laporans')->cascadeOnDelete();

            $table->string('judul');
            $table->text('pesan');
            $table->enum('tipe', [
                'status_update',   // Perubahan status laporan
                'assignment',      // Penugasan ke staff
                'verification',    // Verifikasi laporan
                'reminder',        // Pengingat
                'system',          // Notifikasi sistem
            ])->default('status_update');

            $table->string('url')->nullable()->comment('Link tujuan saat notifikasi diklik');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
