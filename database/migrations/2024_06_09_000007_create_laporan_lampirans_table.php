<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: lampiran & bukti laporan.
     */
    public function up(): void
    {
        Schema::create('laporan_lampirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();

            $table->enum('tipe', [
                'lampiran_awal',       // Foto/dokumen dari pelapor saat membuat laporan
                'bukti_penyelesaian',  // Bukti dari staff saat menyelesaikan
                'dokumen_tambahan',    // Dokumen pendukung lainnya
            ])->default('lampiran_awal');

            $table->string('nama_file');
            $table->string('path');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('ukuran')->nullable()->comment('Ukuran file dalam bytes');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['laporan_id', 'tipe']);
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_lampirans');
    }
};
