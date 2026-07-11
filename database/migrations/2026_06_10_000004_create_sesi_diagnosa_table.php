<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_diagnosa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengguna')->nullable();
            $table->string('nama_laptop')->nullable();
            $table->json('gejala_dipilih'); // array kode gejala
            $table->json('hasil_diagnosa'); // array hasil CF per kerusakan
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_diagnosa');
    }
};
