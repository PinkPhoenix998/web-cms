<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School; 
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // PENTING: Untuk Transaksi Database

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan tampilan pendaftaran.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Tangani permintaan pendaftaran yang masuk (membuat School dan User).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi: sekarang termasuk input 'slug' manual
        $request->validate([
            'school_name' => ['required', 'string', 'max:255', 'unique:schools,name'],
            'slug' => ['required', 'string', 'max:255', 'unique:schools,slug', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'], // Slug harus unik dan formatnya benar
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Menggunakan transaksi untuk memastikan kedua operasi (School & User) sukses atau gagal bersamaan
        $user = DB::transaction(function () use ($request) {
            
            $schoolSlug = $request->slug; // Ambil slug langsung dari input form

            // --- 1. Buat Tenant (Sekolah) BARU ---
            $school = School::create([
                'name' => $request->school_name,
                'slug' => $schoolSlug, // Nilai slug diambil langsung, dijamin ada
                'is_active' => true,
            ]);

            // --- 2. Buat User (Admin Sekolah) ---
            return User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                
                // Kaitkan pengguna dengan tenant yang baru dibuat
                'school_id' => $school->id, 
                'role' => 'admin_sekolah',
            ]);
        });

        event(new Registered($user));
        Auth::login($user);

        // Redirect absolut ke Admin Panel (/admin)
        return redirect()->to('/admin') 
            ->with('status', 'Pendaftaran sekolah berhasil! Silakan kelola konten Anda.');
    }
}