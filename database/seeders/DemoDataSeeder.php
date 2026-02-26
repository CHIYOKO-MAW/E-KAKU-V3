<?php

namespace Database\Seeders;

use App\Models\Biodata;
use App\Models\KartuKuning;
use App\Models\NotificationE;
use App\Models\StatusPekerjaan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $demoAdmin = User::firstOrCreate(
            ['email' => 'admin@ekaku.test'],
            [
                'name' => 'Demo Admin',
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $districts = $this->loadPandeglangDistricts();
        $existingSynthetic = User::where('role', 'user')
            ->where('email', 'like', 'demo.user.%@ekaku.demo')
            ->count();
        $targetSynthetic = 300;
        $toCreate = max(0, $targetSynthetic - $existingSynthetic);

        $pendidikanPool = ['SMP', 'SMA/SMK', 'D3', 'S1'];
        $skillPool = [
            'Administrasi Perkantoran',
            'Operator Gudang',
            'Kasir',
            'Desain Grafis',
            'Teknisi Komputer',
            'Barista',
            'Digital Marketing',
            'Staff Produksi',
            'Operator Alat Berat',
            'Customer Service',
        ];

        $faker = fake('id_ID');
        $nextNumber = $existingSynthetic + 1;
        for ($i = 0; $i < $toCreate; $i++, $nextNumber++) {
            $email = sprintf('demo.user.%03d@ekaku.demo', $nextNumber);
            if (User::where('email', $email)->exists()) {
                continue;
            }

            $district = $districts[array_rand($districts)];
            $village = $district['villages'][array_rand($district['villages'])] ?? ['name' => 'Tidak diketahui'];
            $verificationStatus = $this->randomVerificationStatus();

            $user = User::create([
                'name' => $faker->name(),
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);

            Biodata::create([
                'user_id' => $user->id,
                'nik' => $this->generateNik(),
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->dateTimeBetween('-35 years', '-18 years')->format('Y-m-d'),
                'alamat' => sprintf(
                    'Kp. %s, Desa/Kel. %s, Kec. %s, Kab. Pandeglang, Banten',
                    $faker->streetName(),
                    $village['name'],
                    $district['name']
                ),
                'jenis_kelamin' => random_int(0, 1) === 1 ? 'laki_laki' : 'perempuan',
                'agama' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'][array_rand(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'])],
                'rt_rw' => sprintf('%03d/%03d', random_int(1, 20), random_int(1, 20)),
                'kode_pos' => (string) random_int(42210, 42299),
                'kecamatan' => $district['name'],
                'desa_kelurahan' => $village['name'],
                'status_perkawinan' => ['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati'][array_rand(['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati'])],
                'tinggi_badan' => random_int(150, 180),
                'berat_badan' => random_int(45, 95),
                'disabilitas' => random_int(1, 100) <= 6,
                'pendidikan' => $pendidikanPool[array_rand($pendidikanPool)],
                'tahun_lulus' => (string) random_int(2006, 2025),
                'institusi_pendidikan' => $faker->company() . ' Institute',
                'jurusan' => ['TKJ', 'Akuntansi', 'Manajemen', 'Teknik Mesin', 'Administrasi'][array_rand(['TKJ', 'Akuntansi', 'Manajemen', 'Teknik Mesin', 'Administrasi'])],
                'keahlian' => $skillPool[array_rand($skillPool)],
                'pengalaman' => random_int(1, 100) <= 60 ? $faker->sentence(8) : null,
                'tujuan_lamaran' => random_int(1, 100) <= 70 ? $faker->company() : null,
                'status_verifikasi' => $verificationStatus,
                'tanggal_verifikasi' => $verificationStatus === 'pending' ? null : now()->subDays(random_int(1, 45))->toDateString(),
                'verifikator_id' => $verificationStatus === 'pending' ? null : $demoAdmin->id,
            ]);

            if (random_int(1, 100) <= 90) {
                $employmentStatus = random_int(1, 100) <= 58 ? 'belum_bekerja' : 'sudah_bekerja';
                StatusPekerjaan::create([
                    'user_id' => $user->id,
                    'status_pekerjaan' => $employmentStatus,
                    'nama_perusahaan' => $employmentStatus === 'sudah_bekerja' ? $faker->company() : null,
                    'tanggal_update' => now()->subDays(random_int(1, 180))->toDateString(),
                ]);
            }

            if ($verificationStatus === 'verified') {
                KartuKuning::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nomor_ak1' => 'AK1-' . now()->format('Ymd') . '-' . str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
                        'tanggal_cetak' => now()->subDays(random_int(1, 90))->toDateString(),
                        'status' => random_int(1, 100) <= 92 ? 'printed' : 'expired',
                    ]
                );
            }

            if (random_int(1, 100) <= 45) {
                NotificationE::create([
                    'user_id' => $user->id,
                    'judul' => 'Reminder Update Status Pekerjaan',
                    'pesan' => 'Silakan perbarui status pekerjaan Anda untuk menjaga data Disnaker tetap akurat.',
                    'status_baca' => random_int(0, 1) === 1,
                    'tipe' => 'status_update',
                ]);
            }
        }
    }

    private function loadPandeglangDistricts(): array
    {
        $path = database_path('data/pandeglang_wilayah.json');
        if (is_file($path)) {
            $payload = json_decode((string) file_get_contents($path), true);
            if (is_array($payload) && isset($payload['districts']) && is_array($payload['districts']) && count($payload['districts']) > 0) {
                return $payload['districts'];
            }
        }

        return [
            ['code' => '36.01.21', 'name' => 'Pandeglang', 'villages' => [['name' => 'Pandeglang']]],
            ['code' => '36.01.34', 'name' => 'Majasari', 'villages' => [['name' => 'Majasari']]],
            ['code' => '36.01.12', 'name' => 'Labuan', 'villages' => [['name' => 'Labuan']]],
            ['code' => '36.01.13', 'name' => 'Menes', 'villages' => [['name' => 'Menes']]],
            ['code' => '36.01.06', 'name' => 'Panimbang', 'villages' => [['name' => 'Panimbang']]],
        ];
    }

    private function generateNik(): string
    {
        do {
            $nik = (string) random_int(3601000000000000, 3601999999999999);
        } while (Biodata::where('nik', $nik)->exists());

        return $nik;
    }

    private function randomVerificationStatus(): string
    {
        $roll = random_int(1, 100);
        if ($roll <= 55) {
            return 'verified';
        }
        if ($roll <= 85) {
            return 'pending';
        }

        return 'rejected';
    }
}
