<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; // Wajib

class Student extends Model
{
    use HasFactory, BelongsToTenant; // Terapkan Trait

    protected $fillable = [
        'school_id', // Wajib untuk Trait
        'name', 
        'nisn', 
        'class',
        'gender',
        'photo_url', 
        'status',
    ];
}