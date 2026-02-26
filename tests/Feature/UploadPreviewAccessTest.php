<?php

namespace Tests\Feature;

use App\Models\Upload;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UploadPreviewAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_and_admin_can_preview_upload_but_other_user_cannot(): void
    {
        $owner = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);
        $other = User::factory()->create(['role' => 'user']);

        $path = "public/uploads/{$owner->id}/sample.txt";
        $fullPath = storage_path('app/' . $path);
        if (! is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }
        file_put_contents($fullPath, 'sample');

        $upload = Upload::create([
            'user_id' => $owner->id,
            'jenis_dokumen' => 'ktp',
            'file_path' => $path,
        ]);

        $this->actingAs($owner)->get(route('upload.preview', $upload))->assertOk();
        $this->actingAs($admin)->get(route('upload.preview', $upload))->assertOk();
        $this->actingAs($other)->get(route('upload.preview', $upload))->assertForbidden();
    }
}
