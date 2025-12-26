<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        // 1. Tambahkan Global Scope untuk memfilter query
        static::addGlobalScope('school', function (Builder $builder) {
            // Hanya filter jika pengguna sudah login dan terikat dengan sekolah
            if (auth()->check() && auth()->user()->school_id) {
                $builder->where('school_id', auth()->user()->school_id);
            }
        });

        // 2. Secara otomatis isi school_id saat membuat data baru
        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->school_id) {
                $model->school_id = auth()->user()->school_id;
            }
        });
    }
}