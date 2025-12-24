<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Tambahkan use untuk Filament
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser // <<< WAJIB DITAMBAHKAN
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'school_id', // <<< Tambahan: Kunci Foreign untuk Tenant
        'role',      // <<< Tambahan: Peran untuk Otorisasi
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string', // <<< Tambahan: Type casting untuk peran
    ];

    // Helper untuk identifikasi peran Super Admin
    public function isSuperAdmin(): bool
    {
        return $this->role === 'admin_pusat';
    }

    // Fungsi wajib dari FilamentUser untuk mengontrol akses ke /admin
    public function canAccessPanel(Panel $panel): bool
    {
        // Izinkan akses jika pengguna adalah Super Admin atau Admin Sekolah (school_id tidak NULL)
        return in_array($this->role, ['admin_pusat', 'admin_sekolah']) || $this->school_id !== null;
    }
    
    // Anda bisa menambahkan relasi ke model School
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}