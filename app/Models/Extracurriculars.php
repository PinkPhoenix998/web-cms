<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // WAJIB: Tambahkan use BelongsTo


class extracurriculars extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'school_id',
        'name',
        'description',
        'instructor_name',
        'schedule',
        'photo_url',
    ];
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class); 
    }
}