<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    use HasFactory;

    /**
     * Daftarkan kolom agar bisa disimpan ke database.
     */
    protected $fillable = [
        'school_id',
        'name',
    ];

    /**
     * Relasi ke Sekolah. 
     * Ini sangat penting agar setiap data punya pemilik (sekolah).
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}