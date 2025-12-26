<?php

namespace App\Http\Controllers;


use App\Models\School;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\Gallery;
use App\Models\Facilities;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicWebsiteController extends Controller
{
    /**
     * Dapatkan objek School saat ini dari Service Container dengan pengecekan aman.
     */
    protected function getCurrentSchool(): ?School
    {
        // SOLUSI: Cek apakah binding 'currentSchool' ada sebelum mencoba mengambilnya.
        if (app()->has('currentSchool')) {
            // Jika ada, ambil dan kembalikan sebagai objek School
            return app('currentSchool');
        }

        // Jika tidak ada (karena ini localhost atau domain utama), kembalikan NULL
        return null;
    }

    /**
     * Tampilkan Homepage Profil Sekolah atau Landing Page Platform.
     */
   public function index(): View
{
    $school = $this->getCurrentSchool();
    if (!$school) return view('landing');

    $posts = Post::where('school_id', $school->id)->limit(3)->get();
    
    // PERBAIKAN: Gunakan with('subject') untuk eager loading
    $teachers = Teacher::with('subject')->where('school_id', $school->id)->get();
    
    $students = \App\Models\Student::where('school_id', $school->id)->get();
    $subjects = \App\Models\Subject::where('school_id', $school->id)->get();
    $totalSubjects = $subjects->count();

    $extracurriculars = \App\Models\Extracurriculars::where('school_id', $school->id)->get();
    $totalEskul = $extracurriculars->count();

    $schoolProfile = $school->profile;
    $facilities = Facilities::where('school_id', $school->id)->get();

    return view('frontend.homepage', compact(
        'school', 'posts', 'teachers', 'students', 
        'schoolProfile', 'facilities', 'subjects', 'totalSubjects', 'totalEskul'
    ));
}

    /**
     * Tampilkan Daftar Berita.
     */
    public function showPosts(): View
    {
        $school = $this->getCurrentSchool();
        
        // Pastikan school ada sebelum mengambil data
        if (!$school) {
            return view('errors.tenant-not-found'); // Kita belum buat view ini, tapi ini lebih baik
        }

        $posts = Post::where('school_id', $school->id)->paginate(10);
        return view('frontend.posts.index', compact('school', 'posts'));
    }

    /**
     * Tampilkan Daftar Guru.
     */
    public function showTeachers(): View
    {
        $school = $this->getCurrentSchool();
        if (!$school) {
            return view('errors.tenant-not-found');
        }

        $teachers = Teacher::with('subject')->where('school_id', $school->id)->get();
        return view('frontend.teachers.index', compact('school', 'teachers'));
    }

    /**
     * Tampilkan Daftar Galeri.
     */
    public function showGallery(): View
    {
        $school = $this->getCurrentSchool();
        if (!$school) {
            return view('errors.tenant-not-found');
        }

        $galleries = Gallery::where('school_id', $school->id)->get();
        return view('frontend.gallery.index', compact('school', 'galleries'));
    }

    /**
     * Tampilkan Daftar Siswa.
     */
    public function showStudents(): View
    {
        $school = $this->getCurrentSchool();
        if (!$school) {
            return view('errors.tenant-not-found');
        }

        $students = \App\Models\Student::where('school_id', $school->id)->get();
        return view('frontend.students.index', compact('school', 'students'));
    }

    /**
     * Tampilkan Daftar Fasilitas.
     */
    public function showFacilities(): View
    {
        $school = $this->getCurrentSchool();
        if (!$school) {
            return view('errors.tenant-not-found');
        }

        $facilities = \App\Models\Facilities::where('school_id', $school->id)->get();
        return view('frontend.facilities.index', compact('school', 'facilities'));
    }

    /**
     * Tampilkan Daftar Ekstrakurikuler.
     */
    public function showExtracurriculars(): View
    {
        $school = $this->getCurrentSchool();
        if (!$school) {
            return view('errors.tenant-not-found');
        }

        $extracurriculars = \App\Models\Extracurriculars::where('school_id', $school->id)->get();
        return view('frontend.extracurriculars.index', compact('school', 'extracurriculars'));
    }

    /**
     * Tampilkan Daftar Acara.
     */
    public function showEvents(): View
    {
        $school = $this->getCurrentSchool();
        if (!$school) {
            return view('errors.tenant-not-found');
        }

        $events = \App\Models\Events::where('school_id', $school->id)->get();
        return view('frontend.events.index', compact('school', 'events'));
    }

    public function showPpdbRegistrations($schoolSlug)
    {
        // Mengambil data sekolah berdasarkan slug di URL
        $school = \App\Models\School::where('slug', $schoolSlug)->firstOrFail();

        // Pastikan file ini ada di: resources/views/frontend/ppdb/index.blade.php
        return view('frontend.ppdb.index', compact('school'));
    }
        
    public function storePpdb(Request $request, $schoolSlug)
{
    $school = \App\Models\School::where('slug', $schoolSlug)->firstOrFail();

    // 1. Tangkap SEMUA input dari form sekaligus
    $validatedData = $request->all();

    // 2. Tambahkan data sistem (School ID dan Status awal)
    $validatedData['school_id'] = $school->id;
    $validatedData['status']    = 'pending';

    // 3. Proses Upload File (Pastikan folder storage sudah di-link)
    if ($request->hasFile('photo_path')) {
        $validatedData['photo_path'] = $request->file('photo_path')->store('ppdb/photos', 'public');
    }
    if ($request->hasFile('family_card_path')) {
        $validatedData['family_card_path'] = $request->file('family_card_path')->store('ppdb/kk', 'public');
    }
    if ($request->hasFile('birth_cert_path')) {
        $validatedData['birth_cert_path'] = $request->file('birth_cert_path')->store('ppdb/akta', 'public');
    }

    // 4. Simpan ke Database
    \App\Models\Registration::create($validatedData);

    return redirect()->back()->with('success', 'Pendaftaran berhasil! Data Anda telah kami terima. Silakan tunggu informasi selanjutnya melalui nomor WhatsApp yang telah didaftarkan.');
}
}