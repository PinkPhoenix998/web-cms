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
    Schema::create('registrations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('school_id')->constrained()->onDelete('cascade');
        
        // Data Pendaftaran
        $table->string('registration_type');
        $table->string('registration_path');
        $table->string('nik_kitas');
        $table->string('origin_school');

        // Data Pribadi
        $table->string('full_name');
        $table->string('nisn')->nullable();
        $table->enum('gender', ['L', 'P']);
        $table->string('birth_place');
        $table->date('birth_date');
        $table->string('religion');
        $table->string('nationality');
        $table->text('address');
        $table->string('village');
        $table->string('district');
        $table->string('city');
        $table->string('postal_code');
        $table->string('residence_type');
        $table->integer('child_order');
        $table->integer('siblings_count');
        $table->boolean('has_kip')->default(false);

        // Data Orang Tua (Ayah & Ibu)
        $table->string('father_name');
        $table->string('father_nik');
        $table->string('father_job');
        $table->string('father_income');
        $table->string('mother_name');
        $table->string('mother_nik');
        $table->string('mother_job');
        $table->string('mother_income');

        // Kontak & Dokumen
        $table->string('phone_number');
        $table->string('email');
        $table->string('photo_path')->nullable();
        $table->string('family_card_path')->nullable();
        $table->string('birth_cert_path')->nullable();
        
        $table->string('status')->default('pending'); // pending, accepted, rejected
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
