<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kerusakan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // K001, K002, ...
            $table->string('nama'); // LCD, Keyboard, dll
            $table->string('komponen_pengganti'); // nama part
            $table->integer('est_part_min'); // estimasi harga min
            $table->integer('est_part_max'); // estimasi harga max
            $table->integer('service_fee')->default(0); // biaya jasa
            $table->json('solutions'); // array solusi
            $table->string('icon')->nullable(); // emoji/icon
            $table->string('kategori')->default('hardware');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kerusakan');
    }
};
