<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Laporan;
use App\Models\LaporanStatusLog;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// php artisan db:seed --class=LaporanSeeder
class LaporanSeeder extends Seeder
{
    /**
     * Seed data laporan dummy beserta riwayat status.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $faker = Faker::create('id_ID');

            $mahasiswaDummy = User::where('role', User::ROLE_MAHASISWA)
                ->where('email', 'like', 'mahasiswa.dummy%@campuscare.id')
                ->get();

            if ($mahasiswaDummy->isEmpty()) {
                $this->command?->warn('Mahasiswa dummy tidak ditemukan. Jalankan UserSeeder terlebih dahulu.');

                return;
            }

            $adminProdi = User::where('email', 'admin.prodi@campuscare.id')->first();
            $staff = User::where('email', 'staff@campuscare.id')->first();
            $kategoris = Kategori::all();

            // Distribusi status: 2 terkirim, 2 diverifikasi, 2 diproses, 2 selesai, 1 ditolak, 1 selesai+rated
            $distribusiStatus = [
                Laporan::STATUS_TERKIRIM,
                Laporan::STATUS_TERKIRIM,
                Laporan::STATUS_DIVERIFIKASI,
                Laporan::STATUS_DIVERIFIKASI,
                Laporan::STATUS_DIPROSES,
                Laporan::STATUS_DIPROSES,
                Laporan::STATUS_SELESAI,
                Laporan::STATUS_SELESAI,
                Laporan::STATUS_DITOLAK,
                Laporan::STATUS_SELESAI,
            ];

            $prioritas = [
                Laporan::PRIORITAS_RENDAH,
                Laporan::PRIORITAS_SEDANG,
                Laporan::PRIORITAS_TINGGI,
            ];

            $lokasi = [
                'Gedung A Lantai 2',
                'Lab Komputer FILKOM',
                'Perpustakaan Pusat',
                'Ruang Kuliah B-301',
                'Kantin Kampus',
                'Parkir Motor Blok C',
                'Aula Utama',
                'Masjid Kampus',
                'Gedung Administrasi',
                'Lapangan Olahraga',
            ];

            foreach ($distribusiStatus as $index => $status) {
                $mahasiswa = $mahasiswaDummy[$index % $mahasiswaDummy->count()];
                $kategori = $kategoris->random();
                $nomorLaporan = 'CC-2026-'.str_pad((string) ($index + 1), 5, '0', STR_PAD_LEFT);

                $denganRating = ($index === 9);

                $dataLaporan = [
                    'user_id' => $mahasiswa->id,
                    'kategori_id' => $kategori->id,
                    'judul' => $faker->sentence(4),
                    'deskripsi' => $faker->paragraph(2),
                    'lokasi' => $lokasi[$index],
                    'prioritas' => $faker->randomElement($prioritas),
                    'status' => $status,
                    'fakultas_id' => $mahasiswa->fakultas_id,
                    'prodi_id' => $mahasiswa->prodi_id,
                    'submitted_at' => now()->subDays(10 - $index),
                ];

                // Isi milestone & relasi sesuai status
                match ($status) {
                    Laporan::STATUS_DIVERIFIKASI => $dataLaporan += [
                        'verified_by' => $adminProdi?->id,
                        'verified_at' => now()->subDays(8 - $index),
                    ],
                    Laporan::STATUS_DIPROSES => $dataLaporan += [
                        'verified_by' => $adminProdi?->id,
                        'verified_at' => now()->subDays(7 - $index),
                        'assigned_staff_id' => $staff?->id,
                        'assigned_at' => now()->subDays(6 - $index),
                        'processed_by' => $staff?->id,
                        'processed_at' => now()->subDays(5 - $index),
                    ],
                    Laporan::STATUS_SELESAI => $dataLaporan += [
                        'verified_by' => $adminProdi?->id,
                        'verified_at' => now()->subDays(7 - $index),
                        'assigned_staff_id' => $staff?->id,
                        'assigned_at' => now()->subDays(6 - $index),
                        'processed_by' => $staff?->id,
                        'processed_at' => now()->subDays(4 - $index),
                        'completed_at' => now()->subDays(2),
                        'catatan_staff' => 'Masalah telah ditangani dan diverifikasi.',
                    ],
                    Laporan::STATUS_DITOLAK => $dataLaporan += [
                        'verified_by' => $adminProdi?->id,
                        'verified_at' => now()->subDays(5),
                        'rejected_at' => now()->subDays(4),
                        'alasan_penolakan' => 'Laporan tidak memenuhi kriteria layanan kampus.',
                        'catatan_admin' => 'Mohon ajukan ulang dengan bukti yang lebih jelas.',
                    ],
                    default => null,
                };

                if ($denganRating) {
                    $dataLaporan['rating'] = $faker->numberBetween(4, 5);
                    $dataLaporan['feedback'] = 'Pelayanan cepat dan petugas sangat responsif. Terima kasih!';
                }

                $laporan = Laporan::firstOrCreate(
                    ['nomor_laporan' => $nomorLaporan],
                    $dataLaporan
                );

                $this->buatStatusLogs($laporan, $status, $mahasiswa, $adminProdi, $staff, $denganRating);
            }
        });
    }

    /**
     * Buat riwayat perubahan status untuk satu laporan.
     */
    private function buatStatusLogs(
        Laporan $laporan,
        string $statusAkhir,
        User $pelapor,
        ?User $adminProdi,
        ?User $staff,
        bool $denganRating
    ): void {
        $riwayat = [];

        // Entri awal: laporan dibuat
        $riwayat[] = [
            'status_lama' => null,
            'status_baru' => Laporan::STATUS_TERKIRIM,
            'user_id' => $pelapor->id,
            'keterangan' => 'Laporan berhasil dikirim oleh pelapor.',
        ];

        if (in_array($statusAkhir, [
            Laporan::STATUS_DIVERIFIKASI,
            Laporan::STATUS_DIPROSES,
            Laporan::STATUS_SELESAI,
            Laporan::STATUS_DITOLAK,
        ], true) && $adminProdi) {
            $riwayat[] = [
                'status_lama' => Laporan::STATUS_TERKIRIM,
                'status_baru' => $statusAkhir === Laporan::STATUS_DITOLAK
                    ? Laporan::STATUS_DITOLAK
                    : Laporan::STATUS_DIVERIFIKASI,
                'user_id' => $adminProdi->id,
                'keterangan' => $statusAkhir === Laporan::STATUS_DITOLAK
                    ? 'Laporan ditolak oleh admin prodi.'
                    : 'Laporan diverifikasi oleh admin prodi.',
            ];
        }

        if (in_array($statusAkhir, [Laporan::STATUS_DIPROSES, Laporan::STATUS_SELESAI], true) && $staff) {
            $riwayat[] = [
                'status_lama' => Laporan::STATUS_DIVERIFIKASI,
                'status_baru' => Laporan::STATUS_DIPROSES,
                'user_id' => $staff->id,
                'keterangan' => 'Laporan ditugaskan dan sedang diproses oleh staff.',
            ];
        }

        if ($statusAkhir === Laporan::STATUS_SELESAI && $staff) {
            $riwayat[] = [
                'status_lama' => Laporan::STATUS_DIPROSES,
                'status_baru' => Laporan::STATUS_SELESAI,
                'user_id' => $staff->id,
                'keterangan' => $denganRating
                    ? 'Laporan selesai ditangani. Pelapor memberikan rating.'
                    : 'Laporan selesai ditangani.',
            ];
        }

        foreach ($riwayat as $log) {
            LaporanStatusLog::firstOrCreate(
                [
                    'laporan_id' => $laporan->id,
                    'status_lama' => $log['status_lama'],
                    'status_baru' => $log['status_baru'],
                    'user_id' => $log['user_id'],
                ],
                [
                    'keterangan' => $log['keterangan'],
                    'ip_address' => '127.0.0.1',
                ]
            );
        }
    }
}
