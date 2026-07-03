<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: tabel laporan layanan kampus.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_laporan', 30)->unique()
                ->comment('Nomor tiket unik, format: CC-YYYY-NNNNN');

            // Pelapor (mahasiswa / dosen)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategoris')->restrictOnDelete();

            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi')->comment('Lokasi kejadian / fasilitas');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');

            // Status alur laporan
            $table->enum('status', [
                'terkirim',      // Baru dibuat pelapor
                'diverifikasi',  // Sudah diverifikasi admin prodi/fakultas
                'diproses',      // Sedang ditangani staff/teknisi
                'selesai',       // Selesai ditangani
                'ditolak',       // Ditolak oleh admin
            ])->default('terkirim');

            // Scope organisasi untuk routing & filter
            $table->foreignId('fakultas_id')->nullable()
                ->constrained('fakultas')->nullOnDelete();
            $table->foreignId('prodi_id')->nullable()
                ->constrained('prodi')->nullOnDelete();

            // Penugasan & verifikasi
            $table->foreignId('assigned_staff_id')->nullable()
                ->constrained('users')->nullOnDelete()
                ->comment('Staff/teknisi yang ditugaskan');
            $table->foreignId('verified_by')->nullable()
                ->constrained('users')->nullOnDelete()
                ->comment('Admin yang memverifikasi laporan');
            $table->foreignId('processed_by')->nullable()
                ->constrained('users')->nullOnDelete()
                ->comment('Staff yang memproses laporan');

            // Timestamp milestone status
            $table->timestamp('submitted_at')->nullable()->comment('Waktu laporan dikirim');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->text('catatan_admin')->nullable()->comment('Catatan saat verifikasi/penolakan');
            $table->text('alasan_penolakan')->nullable();
            $table->text('catatan_staff')->nullable()->comment('Catatan penyelesaian dari staff');

            // Feedback pelapor setelah selesai
            $table->unsignedTinyInteger('rating')->nullable()->comment('Skor 1-5');
            $table->text('feedback')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('prioritas');
            $table->index(['user_id', 'status']);
            $table->index(['fakultas_id', 'prodi_id', 'status']);
            $table->index('assigned_staff_id');
            $table->index('created_at');
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
