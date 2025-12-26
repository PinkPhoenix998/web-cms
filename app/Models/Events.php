<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // WAJIB: Tambahkan use BelongsTo

class Events extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'date_time',
        'banner_url',
        'status',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];
    
    /**
     * [FIX RELASI]: Relasi eksplisit ke Model School.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class); 
    }
}