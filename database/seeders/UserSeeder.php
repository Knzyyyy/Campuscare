<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Kategori;
use App\Models\Prodi;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// php artisan db:seed --class=UserSeeder
class UserSeeder extends Seeder
{
    /**
     * Seed data pengguna CampusCare untuk semua role.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $fakultasFt = Fakultas::where('kode', 'FT')->firstOrFail();
            $fakultasFilkom = Fakultas::where('kode', 'FILKOM')->firstOrFail();
            $prodiIf = Prodi::where('kode', 'IF')->firstOrFail();
            $prodiSi = Prodi::where('kode', 'SI')->firstOrFail();

            $password = Hash::make('password');

            $akunUtama = [
                [
                    'role' => User::ROLE_SUPER_ADMIN,
                    'name' => 'Super Admin',
                    'email' => 'superadmin@campuscare.id',
                    'nim' => null,
                    'nip' => null,
                    'fakultas_id' => null,
                    'prodi_id' => null,
                ],
                [
                    'role' => User::ROLE_ADMIN_FAKULTAS,
                    'name' => 'Admin Fakultas',
                    'email' => 'admin.fakultas@campuscare.id',
                    'nim' => null,
                    'nip' => '197001012000011001',
                    'fakultas_id' => $fakultasFt->id,
                    'prodi_id' => null,
                ],
                [
                    'role' => User::ROLE_ADMIN_PRODI,
                    'name' => 'Admin Prodi',
                    'email' => 'admin.prodi@campuscare.id',
                    'nim' => null,
                    'nip' => '198001012005011001',
                    'fakultas_id' => $fakultasFilkom->id,
                    'prodi_id' => $prodiIf->id,
                ],
                [
                    'role' => User::ROLE_STAFF,
                    'name' => 'Budi Teknisi',
                    'email' => 'staff@campuscare.id',
                    'nim' => null,
                    'nip' => '199001012015011001',
                    'fakultas_id' => $fakultasFilkom->id,
                    'prodi_id' => null,
                ],
                [
                    'role' => User::ROLE_DOSEN,
                    'name' => 'Dr. Siti Rahayu',
                    'email' => 'dosen@campuscare.id',
                    'nim' => null,
                    'nip' => '198501012010011001',
                    'fakultas_id' => $fakultasFilkom->id,
                    'prodi_id' => $prodiIf->id,
                ],
                [
                    'role' => User::ROLE_MAHASISWA,
                    'name' => 'Dinda Aulia',
                    'email' => 'mahasiswa@campuscare.id',
                    'nim' => '2021001001',
                    'nip' => null,
                    'fakultas_id' => $fakultasFilkom->id,
                    'prodi_id' => $prodiIf->id,
                ],
            ];

            foreach ($akunUtama as $akun) {
                User::firstOrCreate(
                    ['email' => $akun['email']],
                    [
                        'name' => $akun['name'],
                        'password' => $password,
                        'role' => $akun['role'],
                        'nim' => $akun['nim'],
                        'nip' => $akun['nip'],
                        'fakultas_id' => $akun['fakultas_id'],
                        'prodi_id' => $akun['prodi_id'],
                        'is_active' => true,
                    ]
                );
            }

            // Assign staff ke semua kategori via pivot staff_kategoris
            $staff = User::where('email', 'staff@campuscare.id')->firstOrFail();
            $kategoriIds = Kategori::pluck('id')->toArray();
            $staff->kategoriStaff()->syncWithoutDetaching($kategoriIds);

            // 5 mahasiswa dummy dengan Faker (nama Indonesia, prodi random FILKOM)
            $faker = Faker::create('id_ID');
            $prodiFilkom = [$prodiIf, $prodiSi];

            for ($i = 1; $i <= 5; $i++) {
                $prodi = $faker->randomElement($prodiFilkom);
                $nim = '2022002'.str_pad((string) $i, 3, '0', STR_PAD_LEFT);

                User::firstOrCreate(
                    ['email' => "mahasiswa.dummy{$i}@campuscare.id"],
                    [
                        'name' => $faker->name(),
                        'password' => $password,
                        'role' => User::ROLE_MAHASISWA,
                        'nim' => $nim,
                        'nip' => null,
                        'fakultas_id' => $fakultasFilkom->id,
                        'prodi_id' => $prodi->id,
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
