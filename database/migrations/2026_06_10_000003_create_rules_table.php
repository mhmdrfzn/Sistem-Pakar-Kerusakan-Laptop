<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kerusakan_id')->constrained('kerusakan')->onDelete('cascade');
            $table->foreignId('gejala_id')->constrained('gejala')->onDelete('cascade');
            $table->decimal('cf_nilai', 3, 2); // Certainty Factor: 0.1 - 1.0
            $table->timestamps();

            $table->unique(['kerusakan_id', 'gejala_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
