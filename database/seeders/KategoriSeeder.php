<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// php artisan db:seed --class=KategoriSeeder
class KategoriSeeder extends Seeder
{
    /**
     * Seed data kategori layanan global CampusCare.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $daftarKategori = [
                ['nama' => 'Fasilitas Kelas', 'ikon' => 'chair', 'estimasi_hari' => 3, 'urutan' => 1],
                ['nama' => 'Kebersihan', 'ikon' => 'trash', 'estimasi_hari' => 1, 'urutan' => 2],
                ['nama' => 'Jaringan & Internet', 'ikon' => 'wifi', 'estimasi_hari' => 2, 'urutan' => 3],
                ['nama' => 'Akademik', 'ikon' => 'book', 'estimasi_hari' => 5, 'urutan' => 4],
                ['nama' => 'Keamanan', 'ikon' => 'shield', 'estimasi_hari' => 1, 'urutan' => 5],
                ['nama' => 'Administrasi', 'ikon' => 'file-text', 'estimasi_hari' => 3, 'urutan' => 6],
                ['nama' => 'Lainnya', 'ikon' => 'dots', 'estimasi_hari' => 3, 'urutan' => 7],
            ];

            foreach ($daftarKategori as $kategori) {
                Kategori::firstOrCreate(
                    ['slug' => Str::slug($kategori['nama'])],
                    [
                        'nama' => $kategori['nama'],
                        'ikon' => $kategori['ikon'],
                        'fakultas_id' => null,
                        'estimasi_hari' => $kategori['estimasi_hari'],
                        'urutan' => $kategori['urutan'],
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
