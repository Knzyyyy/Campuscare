<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: tambah field CampusCare ke tabel users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'mahasiswa',
                'dosen',
                'admin_prodi',
                'admin_fakultas',
                'staff',
                'super_admin',
            ])->default('mahasiswa')->after('password');

            $table->string('nim', 30)->nullable()->unique()->comment('Nomor Induk Mahasiswa');
            $table->string('nip', 30)->nullable()->unique()->comment('Nomor Induk Pegawai (dosen/staff/admin)');
            $table->string('phone', 20)->nullable();
            $table->string('avatar')->nullable();

            $table->foreignId('fakultas_id')->nullable()->after('avatar')
                ->constrained('fakultas')->nullOnDelete();
            $table->foreignId('prodi_id')->nullable()->after('fakultas_id')
                ->constrained('prodi')->nullOnDelete();

            $table->boolean('is_active')->default(true)->after('prodi_id');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->softDeletes();

            $table->index('role');
            $table->index('is_active');
            $table->index(['fakultas_id', 'prodi_id']);
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign(['fakultas_id']);
            $table->dropForeign(['prodi_id']);
            $table->dropIndex(['fakultas_id', 'prodi_id']);
            $table->dropIndex(['role']);
            $table->dropIndex(['is_active']);

            $table->dropColumn([
                'role',
                'nim',
                'nip',
                'phone',
                'avatar',
                'fakultas_id',
                'prodi_id',
                'is_active',
                'last_login_at',
            ]);
        });
    }
};
