<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne; // WAJIB: Import HasOne

class School extends Model
{
    use HasFactory;

    /**
     * Menggunakan $guarded kosong untuk mengizinkan semua kolom diisi secara massal.
     *
     * @var array
     */
    protected $guarded = []; 

    // Relasi default ke banyak user
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    /**
     * Relasi spesifik untuk mengambil Admin Sekolah.
     * Asumsi: Admin Sekolah memiliki kolom 'role' dengan nilai 'admin_sekolah' di tabel users.
     */
    public function admin(): HasOne
    {
        return $this->hasOne(User::class, 'school_id')
                    ->where('role', 'admin_sekolah'); 
    }
    
    /**
     * [✅ FIX AKHIR]: Relasi HasOne ke SchoolProfile
     * Digunakan oleh Repeater di SchoolResource.php.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(SchoolProfile::class); // Menghubungkan ke SchoolProfile::class
    }
}