<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah nilai 'laporan_baru' ke ENUM tipe
        DB::statement("ALTER TABLE notifikasis MODIFY COLUMN tipe ENUM('status_update','assignment','verification','reminder','system','laporan_baru') DEFAULT 'status_update'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifikasis MODIFY COLUMN tipe ENUM('status_update','assignment','verification','reminder','system') DEFAULT 'status_update'");
    }
};
