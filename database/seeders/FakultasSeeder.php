<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// php artisan db:seed --class=FakultasSeeder
class FakultasSeeder extends Seeder
{
    /**
     * Seed data fakultas CampusCare.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $daftarFakultas = [
                ['kode' => 'FT', 'nama' => 'Fakultas Teknik'],
                ['kode' => 'FEB', 'nama' => 'Fakultas Ekonomi & Bisnis'],
                ['kode' => 'FILKOM', 'nama' => 'Fakultas Ilmu Komputer'],
            ];

            foreach ($daftarFakultas as $fakultas) {
                Fakultas::firstOrCreate(
                    ['kode' => $fakultas['kode']],
                    [
                        'nama' => $fakultas['nama'],
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
