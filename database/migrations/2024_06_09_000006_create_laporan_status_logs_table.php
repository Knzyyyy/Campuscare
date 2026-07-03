<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: riwayat perubahan status laporan.
     */
    public function up(): void
    {
        Schema::create('laporan_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()
                ->comment('User yang melakukan perubahan status');

            $table->enum('status_lama', [
                'terkirim',
                'diverifikasi',
                'diproses',
                'selesai',
                'ditolak',
            ])->nullable()->comment('Null jika status pertama kali dibuat');

            $table->enum('status_baru', [
                'terkirim',
                'diverifikasi',
                'diproses',
                'selesai',
                'ditolak',
            ]);

            $table->text('keterangan')->nullable()->comment('Catatan perubahan status');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['laporan_id', 'created_at']);
            $table->index('status_baru');
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_status_logs');
    }
};
