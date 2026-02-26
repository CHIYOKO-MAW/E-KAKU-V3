<?php

namespace Tests\Feature;

use App\Models\StatusPekerjaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_laporan_page_can_be_rendered(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        StatusPekerjaan::create([
            'user_id' => $user->id,
            'status_pekerjaan' => 'belum_bekerja',
            'tanggal_update' => now()->toDateString(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.laporan'));
        $response->assertOk();
    }
}
