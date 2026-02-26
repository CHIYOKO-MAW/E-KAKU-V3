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
      Schema::create('kartu_kuning', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('nomor_ak1')->unique()->nullable();
    $table->date('tanggal_cetak')->nullable();
    $table->string('qr_code_path')->nullable();
    $table->enum('status',['pending','printed','expired'])->default('pending');
    $table->timestamps();
    $table->softDeletes();
});
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_kuning');
    }
};
