<?php

namespace App\Models;

use App\Traits\BelongsToTenant; // Import Trait
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory, BelongsToTenant; // <<< WAJIB: Tambahkan BelongsToTenant

    protected $fillable = [
        'school_id', 
        'name', 
        'position', 
        'nip',
        'photo_url'
    ];
    
    // Opsional: Definisikan relasi ke School
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}