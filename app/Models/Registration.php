<?php

namespace App\Models;

use App\Traits\BelongsToTenant; // Pastikan Trait ini ada di project Anda
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory, BelongsToTenant;

    // Masukkan semua kolom agar bisa diisi (Mass Assignment)
    protected $guarded = []; 

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}