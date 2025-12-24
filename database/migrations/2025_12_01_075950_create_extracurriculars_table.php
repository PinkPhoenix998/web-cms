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
        Schema::create('extracurriculars', function (Blueprint $table) {
            $table->id();
            // Kunci Multi-Tenant
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            
            // Kolom Data Eskul
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('instructor_name')->nullable();
            $table->string('schedule')->nullable()->comment('Contoh: Setiap Jumat pukul 14:00');
            $table->string('photo_url')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurriculars');
    }
};