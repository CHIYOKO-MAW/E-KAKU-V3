<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePhotoAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_photo_endpoint_can_be_accessed_by_owner_and_admin(): void
    {
        $owner = User::factory()->create(['role' => 'user', 'profile_photo_path' => 'profile-photos/1/fake.jpg']);
        $admin = User::factory()->create(['role' => 'admin']);
        $other = User::factory()->create(['role' => 'user']);

        $this->actingAs($other)->get(route('profile.photo', $owner))->assertForbidden();
        $this->actingAs($admin)->get(route('profile.photo', $owner))->assertStatus(404);
        $this->actingAs($owner)->get(route('profile.photo', $owner))->assertStatus(404);
    }
}
