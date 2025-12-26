<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            // KUNCI MULTI-TENANT
            $table->foreignId('school_id')->constrained()->onDelete('cascade'); 
            
            // KOLOM DATA GURU
            $table->string('name');// Misal: Guru Matematika
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('set null');
            $table->enum('gender', ['L', 'P'])->default('L'); // Tambahkan kolom gender untuk dashboard
            $table->string('nip')->unique()->nullable(); // Nomor Induk Pegawai
            $table->string('photo_url')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};