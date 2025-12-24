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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // Kunci Multi-Tenant
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            
            // Kolom Data Siswa
            $table->string('name');
            $table->string('nisn', 50)->unique()->nullable();
            $table->string('class', 50)->nullable()->comment('Contoh: X TKJ 1');
            $table->string('photo_url')->nullable();
            $table->enum('status', ['aktif', 'lulus', 'pindah'])->default('aktif');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};