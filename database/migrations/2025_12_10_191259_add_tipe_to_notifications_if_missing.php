<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Jika ada in_app_notifications (kamu sudah rename sebelumnya), ubah itu
        if (Schema::hasTable('in_app_notifications')) {
            Schema::table('in_app_notifications', function (Blueprint $table) {
                if (! Schema::hasColumn('in_app_notifications', 'tipe')) {
                    $table->enum('tipe', ['status_update','kartu_expired'])->nullable()->after('pesan');
                }
            });
            return;
        }

        // Jika tidak ada, cek notifications
        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                if (! Schema::hasColumn('notifications', 'tipe')) {
                    $table->enum('tipe', ['status_update','kartu_expired'])->nullable()->after('pesan');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('in_app_notifications') && Schema::hasColumn('in_app_notifications', 'tipe')) {
            Schema::table('in_app_notifications', function (Blueprint $table) {
                $table->dropColumn('tipe');
            });
        }

        if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'tipe')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropColumn('tipe');
            });
        }
    }
};
