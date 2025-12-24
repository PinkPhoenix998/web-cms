<?php

// app/Models/Post.php
namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use BelongsToTenant; // <<< Terapkan Trait di sini
    protected $fillable = ['school_id', 'title', 'content'];
}