<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicWebsiteController;
use App\Http\Middleware\IdentifyTenant; // Middleware Identifikasi Tenant
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTES OTENTIKASI (LOGIN, REGISTER, DASHBOARD ADMIN)
|--------------------------------------------------------------------------
| Route untuk login, register, dan lupa password (Breeze)
*/

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    // Route bawaan Breeze setelah login (Anda bisa menggantinya ke /admin jika mau)
    Route::view('/dashboard', 'dashboard')->name('dashboard'); 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| ROUTE FRONTRND PUBLIK (WEB PROFIL SEKOLAH)
|--------------------------------------------------------------------------
*/

Route::middleware(['web'])->group(function () { 

    // 1. Route untuk Landing Page Platform (Diakses ketika URL TIDAK mengandung /s/{slug})
    Route::view('/', 'landing')->name('landing'); 

    
    // 2. Route untuk semua website profil sekolah
    // URL format: /s/{slug-sekolah}/halaman
    // Middleware IdentifyTenant akan berjalan di group 'web' dan menangani path ini.
    Route::prefix('s/{schoolSlug}')->middleware([IdentifyTenant::class])->group(function () {
        
        Route::controller(PublicWebsiteController::class)->group(function () {
            
            // Halaman-halaman konten
            Route::get('/berita', 'showPosts')->name('posts');
            Route::get('/guru', 'showTeachers')->name('teachers');
            Route::get('/galeri', 'showGallery')->name('gallery');
            Route::get('/siswa', 'showStudents')->name('students');
            Route::get('/fasilitas', 'showFacilities')->name('facilities');
            Route::get('/ekstrakurikuler', 'showExtracurriculars')->name('extracurriculars');
            Route::get('/ppdb', 'showPpdbRegistrations')->name('ppdb_registrations');
            Route::get('/acara', 'showEvents')->name('events');
            Route::get('/kontak', 'showContact')->name('contact');
            Route::get('/ppdb', 'showPpdbRegistrations')->name('registration');
            Route::post('/ppdb', 'storePpdb')->name('registration.store');      // Mengirim Form

            // Homepage Sekolah (selalu di akhir group)
            Route::get('/', 'index')->name('school.homepage');
        });
    });
});