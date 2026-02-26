<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('biodata', function (Blueprint $table) {
            if (! Schema::hasColumn('biodata', 'jenis_kelamin')) {
                $table->string('jenis_kelamin', 20)->nullable()->after('alamat');
            }
            if (! Schema::hasColumn('biodata', 'agama')) {
                $table->string('agama', 50)->nullable()->after('jenis_kelamin');
            }
            if (! Schema::hasColumn('biodata', 'rt_rw')) {
                $table->string('rt_rw', 20)->nullable()->after('agama');
            }
            if (! Schema::hasColumn('biodata', 'kode_pos')) {
                $table->string('kode_pos', 10)->nullable()->after('rt_rw');
            }
            if (! Schema::hasColumn('biodata', 'kecamatan')) {
                $table->string('kecamatan', 120)->nullable()->after('kode_pos');
            }
            if (! Schema::hasColumn('biodata', 'desa_kelurahan')) {
                $table->string('desa_kelurahan', 120)->nullable()->after('kecamatan');
            }
            if (! Schema::hasColumn('biodata', 'status_perkawinan')) {
                $table->string('status_perkawinan', 30)->nullable()->after('desa_kelurahan');
            }
            if (! Schema::hasColumn('biodata', 'tinggi_badan')) {
                $table->unsignedSmallInteger('tinggi_badan')->nullable()->after('status_perkawinan');
            }
            if (! Schema::hasColumn('biodata', 'berat_badan')) {
                $table->unsignedSmallInteger('berat_badan')->nullable()->after('tinggi_badan');
            }
            if (! Schema::hasColumn('biodata', 'disabilitas')) {
                $table->boolean('disabilitas')->nullable()->after('berat_badan');
            }
            if (! Schema::hasColumn('biodata', 'tahun_lulus')) {
                $table->string('tahun_lulus', 4)->nullable()->after('pendidikan');
            }
            if (! Schema::hasColumn('biodata', 'institusi_pendidikan')) {
                $table->string('institusi_pendidikan')->nullable()->after('tahun_lulus');
            }
            if (! Schema::hasColumn('biodata', 'jurusan')) {
                $table->string('jurusan')->nullable()->after('institusi_pendidikan');
            }
            if (! Schema::hasColumn('biodata', 'pengalaman')) {
                $table->text('pengalaman')->nullable()->after('keahlian');
            }
            if (! Schema::hasColumn('biodata', 'tujuan_lamaran')) {
                $table->string('tujuan_lamaran')->nullable()->after('pengalaman');
            }
        });
    }

    public function down(): void
    {
        Schema::table('biodata', function (Blueprint $table) {
            $columns = [
                'jenis_kelamin',
                'agama',
                'rt_rw',
                'kode_pos',
                'kecamatan',
                'desa_kelurahan',
                'status_perkawinan',
                'tinggi_badan',
                'berat_badan',
                'disabilitas',
                'tahun_lulus',
                'institusi_pendidikan',
                'jurusan',
                'pengalaman',
                'tujuan_lamaran',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('biodata', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
