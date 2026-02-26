<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('biodata', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('nik')->unique();
    $table->string('tempat_lahir');
    $table->date('tanggal_lahir');
    $table->text('alamat');
    $table->string('pendidikan');
    $table->string('keahlian')->nullable();
    $table->enum('status_verifikasi', ['pending','verified','rejected'])->default('pending');
    $table->timestamps();
    $table->softDeletes();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodata');
    }
};
