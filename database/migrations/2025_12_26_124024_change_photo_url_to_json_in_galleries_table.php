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
    Schema::table('galleries', function (Blueprint $table) {
        // Ganti 'photo_url' menjadi 'file_path'
        $table->text('file_path')->change(); 
    });
}

public function down(): void
{
    Schema::table('galleries', function (Blueprint $table) {
        $table->string('file_path')->change();
    });
}
};
