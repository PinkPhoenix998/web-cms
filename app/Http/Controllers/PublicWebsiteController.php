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

        // Jika tidak ada school yang diidentifikasi, tampilkan landing page utama platform
        if (!$school) {
            return view('landing');
        }

        // Ambil 3 berita terbaru (contoh)
        $posts = Post::where('school_id', $school->id)
                      ->limit(3)
                      ->get();

        // Ambil data guru untuk dashboard
        $teachers = Teacher::where('school_id', $school->id)->get();
        \Log::info('Teachers query:', [
            'school_id' => $school->id,
            'count' => $teachers->count(),
            'data' => $teachers->toArray()
        ]);

        // Ambil data siswa untuk dashboard
        $students = \App\Models\Student::where('school_id', $school->id)->get();

        // Ambil data profil sekolah untuk informasi kontak
        $schoolProfile = $school->profile;

        // Ambil data fasilitas untuk hero image
        $facilities = Facilities::where('school_id', $school->id)->get();

        // Kirim data ke view homepage sekolah
        return view('frontend.homepage', compact('school', 'posts', 'teachers', 'students', 'schoolProfile', 'facilities'));
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

        $teachers = Teacher::where('school_id', $school->id)->get();
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
     * Tampilkan Daftar Pendaftaran PPDB.
     */
    public function showPpdbRegistrations(): View
    {
        $school = $this->getCurrentSchool();
        if (!$school) {
            return view('errors.tenant-not-found');
        }

        $ppdbRegistrations = \App\Models\PPDB_Registrations::where('school_id', $school->id)->get();
        return view('frontend.ppdb_registrations.index', compact('school', 'ppdbRegistrations'));
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
}