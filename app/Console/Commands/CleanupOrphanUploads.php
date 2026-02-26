<?php

namespace App\Console\Commands;

use App\Models\Upload;
use Illuminate\Console\Command;

class CleanupOrphanUploads extends Command
{
    protected $signature = 'uploads:cleanup-orphans {--dry-run : Hanya tampilkan kandidat orphan tanpa menghapus}';

    protected $description = 'Bersihkan record upload yang file fisiknya sudah tidak ada di server.';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $processed = 0;
        $deleted = 0;
        $hardDeleted = 0;
        $kept = 0;

        Upload::withTrashed()->orderBy('id')->chunkById(200, function ($uploads) use ($dryRun, &$processed, &$deleted, &$hardDeleted, &$kept) {
            foreach ($uploads as $upload) {
                $processed++;
                if ($this->uploadFileExists($upload->file_path)) {
                    $kept++;
                    continue;
                }

                if ($dryRun) {
                    $this->line("ORPHAN [dry-run] id={$upload->id} user={$upload->user_id} path={$upload->file_path}");
                    continue;
                }

                if ($upload->trashed()) {
                    $upload->forceDelete();
                    $hardDeleted++;
                } else {
                    $upload->delete();
                    $deleted++;
                }
            }
        });

        $this->newLine();
        $this->info('Cleanup orphan upload selesai.');
        $this->line("Processed    : {$processed}");
        $this->line("File ada     : {$kept}");
        if ($dryRun) {
            $this->line('Mode         : dry-run (tidak ada data dihapus)');
        } else {
            $this->line("Soft deleted : {$deleted}");
            $this->line("Hard deleted : {$hardDeleted}");
        }

        return self::SUCCESS;
    }

    private function uploadFileExists(string $filePath): bool
    {
        $normalized = ltrim($filePath, '/');
        $legacyNormalized = ltrim(str_replace('public/', '', $normalized), '/');

        $candidates = [
            storage_path('app/' . $normalized),
            storage_path('app/public/' . $normalized),
            storage_path('app/public/' . $legacyNormalized),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return true;
            }
        }

        return false;
    }
}
