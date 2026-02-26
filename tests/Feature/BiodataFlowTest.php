<?php

namespace Tests\Feature;

use App\Models\Biodata;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BiodataFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_biodata_from_profile_flow(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post(route('biodata.store'), [
            'nik' => '3601000000000012',
            'tempat_lahir' => 'Pandeglang',
            'tanggal_lahir' => '2001-05-10',
            'alamat' => 'Desa Pandeglang, Kec. Pandeglang, Kab. Pandeglang',
            'pendidikan' => 'SMA/SMK',
            'keahlian' => 'Administrasi',
        ]);

        $response->assertRedirect(route('profile.edit') . '#biodata');
        $this->assertDatabaseHas('biodata', [
            'user_id' => $user->id,
            'nik' => '3601000000000012',
            'status_verifikasi' => 'pending',
        ]);
    }

    public function test_user_can_update_own_biodata(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        Biodata::create([
            'user_id' => $user->id,
            'nik' => '3601000000000033',
            'tempat_lahir' => 'Pandeglang',
            'tanggal_lahir' => '2000-01-01',
            'alamat' => 'Alamat lama',
            'pendidikan' => 'SMA',
            'keahlian' => 'Kasir',
            'status_verifikasi' => 'pending',
        ]);

        $response = $this->actingAs($user)->put(route('biodata.update'), [
            'nik' => '3601000000000033',
            'tempat_lahir' => 'Serang',
            'tanggal_lahir' => '2000-01-01',
            'alamat' => 'Alamat baru',
            'pendidikan' => 'D3',
            'keahlian' => 'Administrasi',
        ]);

        $response->assertRedirect(route('profile.edit') . '#biodata');
        $this->assertDatabaseHas('biodata', [
            'user_id' => $user->id,
            'nik' => '3601000000000033',
            'tempat_lahir' => 'Serang',
            'alamat' => 'Alamat baru',
            'pendidikan' => 'D3',
            'keahlian' => 'Administrasi',
        ]);
    }
}
