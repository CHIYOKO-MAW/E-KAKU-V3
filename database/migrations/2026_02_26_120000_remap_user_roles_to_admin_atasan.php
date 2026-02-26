<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // no-op: role enum is defined in base users migration for fresh setup.
    }

    public function down(): void
    {
        // no-op
    }
};
