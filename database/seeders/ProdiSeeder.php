<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// php artisan db:seed --class=ProdiSeeder
class ProdiSeeder extends Seeder
{
    /**
     * Seed data program studi CampusCare.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $daftarProdi = [
                'FT' => [
                    ['kode' => 'TS', 'nama' => 'Teknik Sipil'],
                    ['kode' => 'TE', 'nama' => 'Teknik Elektro'],
                ],
                'FEB' => [
                    ['kode' => 'MNJ', 'nama' => 'Manajemen'],
                    ['kode' => 'AKT', 'nama' => 'Akuntansi'],
                ],
                'FILKOM' => [
                    ['kode' => 'IF', 'nama' => 'Informatika'],
                    ['kode' => 'SI', 'nama' => 'Sistem Informasi'],
                ],
            ];

            foreach ($daftarProdi as $kodeFakultas => $prodiList) {
                $fakultas = Fakultas::where('kode', $kodeFakultas)->firstOrFail();

                foreach ($prodiList as $prodi) {
                    Prodi::firstOrCreate(
                        ['kode' => $prodi['kode']],
                        [
                            'fakultas_id' => $fakultas->id,
                            'nama' => $prodi['nama'],
                            'jenjang' => 'S1',
                            'is_active' => true,
                        ]
                    );
                }
            }
        });
    }
}
