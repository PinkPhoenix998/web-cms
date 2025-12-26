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
        Schema::table('schools', function (Blueprint $table) {
            // Ubah kolom 'domain' menjadi opsional (nullable)
            $table->string('domain')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // Jika Anda ingin mengembalikan, Anda perlu mendefinisikan ulang properti sebelumnya
            // Catatan: Laravel mungkin tidak mengizinkan perubahan kembali ke NOT NULL jika ada data NULL.
            // Biarkan saja seperti ini untuk keamanan.
        });
    }
};