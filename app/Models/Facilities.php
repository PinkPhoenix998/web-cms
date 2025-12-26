<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Facilities extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'school_id',
        'name',
        'description',
        'photo_url',
    ];
}