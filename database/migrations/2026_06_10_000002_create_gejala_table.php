<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gejala', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // G001, G002, ...
            $table->text('deskripsi'); // deskripsi gejala
            $table->string('kategori')->default('umum'); // kategori tampilan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gejala');
    }
};
