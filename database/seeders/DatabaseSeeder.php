<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed seluruh data awal CampusCare.
     */
    public function run(): void
    {
        $this->call([
            FakultasSeeder::class,
            ProdiSeeder::class,
            KategoriSeeder::class,
            UserSeeder::class,
            PengaturanSeeder::class,
            LaporanSeeder::class,
        ]);
    }
}
