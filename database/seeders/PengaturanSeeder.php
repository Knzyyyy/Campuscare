<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// php artisan db:seed --class=PengaturanSeeder
class PengaturanSeeder extends Seeder
{
    /**
     * Seed pengaturan default aplikasi CampusCare.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $daftarPengaturan = [
                [
                    'kunci' => 'nama_aplikasi',
                    'nilai' => 'CampusCare',
                    'tipe' => 'string',
                    'grup' => 'umum',
                    'label' => 'Nama Aplikasi',
                    'deskripsi' => 'Nama aplikasi yang ditampilkan di header dan halaman login',
                ],
                [
                    'kunci' => 'tagline',
                    'nilai' => 'Layanan kampus, lebih mudah',
                    'tipe' => 'string',
                    'grup' => 'umum',
                    'label' => 'Tagline',
                    'deskripsi' => 'Slogan aplikasi CampusCare',
                ],
                [
                    'kunci' => 'email_admin',
                    'nilai' => 'admin@campuscare.id',
                    'tipe' => 'string',
                    'grup' => 'umum',
                    'label' => 'Email Admin',
                    'deskripsi' => 'Alamat email administrator utama',
                ],
                [
                    'kunci' => 'sla_default_hari',
                    'nilai' => '3',
                    'tipe' => 'integer',
                    'grup' => 'laporan',
                    'label' => 'SLA Default (Hari)',
                    'deskripsi' => 'Estimasi penyelesaian laporan default dalam hari kerja',
                ],
                [
                    'kunci' => 'max_upload_mb',
                    'nilai' => '2',
                    'tipe' => 'integer',
                    'grup' => 'laporan',
                    'label' => 'Maksimal Upload (MB)',
                    'deskripsi' => 'Ukuran maksimal file lampiran per unggahan',
                ],
                [
                    'kunci' => 'max_foto_laporan',
                    'nilai' => '3',
                    'tipe' => 'integer',
                    'grup' => 'laporan',
                    'label' => 'Maksimal Foto Laporan',
                    'deskripsi' => 'Jumlah maksimal foto yang dapat dilampirkan per laporan',
                ],
            ];

            foreach ($daftarPengaturan as $pengaturan) {
                Pengaturan::firstOrCreate(
                    ['kunci' => $pengaturan['kunci']],
                    $pengaturan
                );
            }
        });
    }
}
