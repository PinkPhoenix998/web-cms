<?php

namespace App\Models;

use App\Traits\BelongsToTenant; // Import Trait
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, BelongsToTenant; // <<< Tambahkan BelongsToTenant

    protected $fillable = [
        'school_id', 
        'title',
        'caption', 
        'file_path',
        'type'
    ];
}