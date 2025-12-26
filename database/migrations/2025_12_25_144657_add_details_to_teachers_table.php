<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('teachers', function (Blueprint $table) {
        // Tambahkan kolom gender untuk statistik dashboard
        $table->enum('gender', ['L', 'P'])->after('name')->default('L');
        
        // Tambahkan relasi ke tabel subjects
        $table->foreignId('subject_id')->nullable()->after('school_id')->constrained('subjects')->onDelete('set null');
        
        // Opsional: Hapus kolom position lama jika tidak diperlukan lagi
        // $table->dropColumn('position'); 
    });
}

public function down()
{
    Schema::table('teachers', function (Blueprint $table) {
        $table->dropForeign(['subject_id']);
        $table->dropColumn(['gender', 'subject_id']);
    });
}
};
