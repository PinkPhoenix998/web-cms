<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'school_id', 
        'title',
        'caption', 
        'file_path', // Pastikan kolom ini benar
        'type'
    ];

    protected $casts = [
        // UBAH DARI photo_url MENJADI file_path agar mendukung multiple upload
        'file_path' => 'array', 
    ];
}