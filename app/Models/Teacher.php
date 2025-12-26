<?php

namespace App\Models;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory, BelongsToTenant; 

    protected $fillable = [
        'school_id', 
        'subject_id', // Tambahkan ini
        'name', 
        'gender',    // Tambahkan ini
        'nip',
        'photo_url'
    ];

    /**
     * Relasi ke Mata Pelajaran
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    
    /**
     * Relasi ke School (Multi-tenant)
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
    
}