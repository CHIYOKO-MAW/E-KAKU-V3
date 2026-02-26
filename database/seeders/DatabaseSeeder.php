<?php

namespace Database\Seeders;

use App\Models\Biodata;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $demoUser = User::updateOrCreate(
            ['email' => 'user@ekaku.test'],
            [
                'name' => 'Demo User',
                'role' => 'user',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@ekaku.test'],
            [
                'name' => 'Demo Admin',
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'atasan@ekaku.test'],
            [
                'name' => 'Demo Atasan',
                'role' => 'atasan',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        Biodata::updateOrCreate(
            ['user_id' => $demoUser->id],
            [
                'nik' => '3601000000000001',
                'tempat_lahir' => 'Pandeglang',
                'tanggal_lahir' => '2000-01-01',
                'alamat' => 'Jl. Pandeglang, Desa Pandeglang, Kec. Pandeglang, Kab. Pandeglang, Banten',
                'pendidikan' => 'SMA/SMK',
                'keahlian' => 'Administrasi Perkantoran',
                'status_verifikasi' => 'pending',
            ]
        );
        $seedDemo = filter_var(env('SEED_DEMO_DATA', false), FILTER_VALIDATE_BOOL);
        if ($seedDemo) {
            $this->call(DemoDataSeeder::class);
        }
    }
}
