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
    Schema::table('users', function (Blueprint $table) {
        // school_id adalah Foreign Key yang menunjuk ke tabel schools.id
        $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['school_id']);
        $table->dropColumn('school_id');
    });
}
};
