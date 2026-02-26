<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kartu_kuning', function (Blueprint $table) {
            if (! Schema::hasColumn('kartu_kuning', 'qr_token')) {
                $table->string('qr_token', 64)->nullable()->unique()->after('qr_code_path');
            }
            if (! Schema::hasColumn('kartu_kuning', 'qr_issued_at')) {
                $table->timestamp('qr_issued_at')->nullable()->after('qr_token');
            }
            if (! Schema::hasColumn('kartu_kuning', 'scan_count')) {
                $table->unsignedInteger('scan_count')->default(0)->after('qr_issued_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kartu_kuning', function (Blueprint $table) {
            $columns = ['qr_token', 'qr_issued_at', 'scan_count'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('kartu_kuning', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
