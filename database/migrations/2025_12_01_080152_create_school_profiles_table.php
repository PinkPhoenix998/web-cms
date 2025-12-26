<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            
            // =======================================================
            // Kunci Relasi One-to-One
            // =======================================================
            // 'unique()' memastikan hanya ada satu baris profil per sekolah
            $table->foreignId('school_id')
                  ->unique()
                  ->constrained('schools')
                  ->cascadeOnDelete()
                  ->comment('Relasi one-to-one ke tabel schools.');
            
            // --- Kolom Profil Detail (Visi, Misi, Deskripsi) ---
            $table->longText('vision')->nullable();
            $table->longText('mission')->nullable();
            $table->text('description')->nullable();
            
            // --- Kolom Kontak dan Alamat ---
            $table->string('address')->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->string('contact_email', 255)->nullable();
            
            // --- Kolom Kepala Sekolah ---
            $table->string('principal_name')->nullable();
            $table->string('principal_photo_url')->nullable();
            $table->text('principal_welcome_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};