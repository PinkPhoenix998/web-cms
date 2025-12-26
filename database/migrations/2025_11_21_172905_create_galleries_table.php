<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            // KUNCI MULTI-TENANT
            $table->foreignId('school_id')->constrained()->onDelete('cascade'); 
            
            // KOLOM DATA GALERI
            $table->string('title');
            $table->text('caption')->nullable();
            $table->string('file_path'); // Path atau URL ke gambar/video
            $table->enum('type', ['image', 'video'])->default('image'); // Tipe media
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};