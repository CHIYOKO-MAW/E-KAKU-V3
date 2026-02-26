<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('biodata', function (Blueprint $table) {
            if (! Schema::hasColumn('biodata', 'status_verifikasi')) {
                $table->enum('status_verifikasi', ['pending','verified','rejected'])->default('pending')->after('keahlian');
            }
            if (! Schema::hasColumn('biodata', 'tanggal_verifikasi')) {
                $table->date('tanggal_verifikasi')->nullable()->after('status_verifikasi');
            }
            if (! Schema::hasColumn('biodata', 'verifikator_id')) {
                $table->foreignId('verifikator_id')->nullable()->constrained('users')->nullOnDelete()->after('tanggal_verifikasi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('biodata', function (Blueprint $table) {
            $table->dropForeign(['verifikator_id']);
            $table->dropColumn(['verifikator_id', 'tanggal_verifikasi', 'status_verifikasi']);
        });
    }
};
