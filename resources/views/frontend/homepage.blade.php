<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage {{ $school->name }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Hero Carousel Styles */
        .hero-carousel {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .hero-slides-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        .hero-slide.active {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-100 antialiased">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <!-- Top Bar: Logo, Contact Info & Social Media -->
        <div class="bg-gray-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-3">
                    <!-- Logo & School Name -->
                    <div class="flex items-center gap-3">
    <a href="{{ route('school.homepage', $school->slug) }}" class="flex items-center gap-3 group">
        @if($school->profile && $school->profile->logo_url)
            {{-- Menampilkan logo dari storage sekolah yang bersangkutan --}}
            <img src="{{ asset('storage/' . $school->profile->logo_url) }}" 
                 alt="Logo {{ $school->name }}" 
                 class="h-10 w-10 object-contain transition duration-300 group-hover:scale-110">
        @else
            {{-- Placeholder jika logo belum diunggah --}}
            <div class="h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-school text-indigo-600"></i>
            </div>
        @endif
        
        <span class="text-lg font-extrabold text-indigo-600 group-hover:text-indigo-700 transition duration-300">
            {{ $school->name }}
        </span>
    </a>
</div>

                    <!-- Social Media Icons -->
                    <div class="hidden md:flex items-center gap-3">
                            <a href="#" class="text-gray-600 hover:text-indigo-600 transition" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-indigo-600 transition" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-indigo-600 transition" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-indigo-600 transition" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar: Navigation Menu -->
        <div class="bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('school.homepage', $school->slug) }}" class="border-b-2 border-indigo-500 text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-home mr-1"></i>Beranda
                        </a>
                        <a href="{{ route('posts', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-newspaper mr-1"></i>Berita
                        </a>
                        <a href="{{ route('teachers', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-users mr-1"></i>Guru
                        </a>
                        <a href="{{ route('gallery', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-images mr-1"></i>Galeri
                        </a>
                        <a href="{{ route('facilities', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-building mr-1"></i>Fasilitas
                        </a>
                        <a href="{{ route('registration', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-edit mr-1"></i>PPDB
                        </a>
                    </div>

                    <div class="flex sm:items-center">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 px-4 py-2 rounded-lg shadow-sm transition duration-300 transform hover:scale-105">
                            <i class="fas fa-user-shield mr-1"></i> Login Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </nav>
    
    <!-- Hero Section with Full-Width Image -->
    <div class="relative w-full h-96 sm:h-[500px] md:h-[600px] bg-gradient-to-r from-indigo-600 to-purple-600 overflow-hidden">
        <!-- Background Image Carousel from Facilities -->
        <div class="absolute inset-0 w-full h-full">
            @if($facilities->count() > 0)
                @php
                    $facilitiesWithPhotos = $facilities->filter(function($facility) {
                        return !empty($facility->photo_url);
                    });
                @endphp
                @if($facilitiesWithPhotos->count() > 0)
                    <div class="hero-carousel relative w-full h-full overflow-hidden">
                        <div class="hero-slides-container">
                            @foreach($facilitiesWithPhotos as $index => $facility)
                            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $facility->photo_url) }}"
                                     alt="{{ $facility->name }}"
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div class="w-full h-full bg-gradient-to-r from-indigo-600 to-purple-600 hidden"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="w-full h-full bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800"></div>
                @endif
            @else
                <div class="w-full h-full bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800"></div>
            @endif
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-40"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 w-full h-full flex flex-col items-center justify-center text-white text-center px-4">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-2 drop-shadow-lg">{{ $school->name }}</h1>
            <p class="text-xl sm:text-2xl font-light text-gray-100 mb-8 max-w-2xl drop-shadow-md">{{ trim(strip_tags(html_entity_decode($school->profile?->vision ?? 'Membangun masa depan melalui pendidikan berkualitas'))) }}</p>
            <a href="#content" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg shadow-lg font-semibold transition duration-300 transform hover:scale-105">
                <span>Selengkapnya</span>
                <i class="fas fa-arrow-down ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Overlapping Content Panel -->
    <div class="relative -mt-20 sm:-mt-24 md:-mt-32 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                    <!-- Left Column: Kepala Sekolah Image & Name -->
                    <div class="p-8 md:p-10 flex flex-col items-center border-b md:border-b-0 md:border-r border-gray-200">
                        <div class="mb-6">
                            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center overflow-hidden shadow-lg border-4 border-indigo-100">
                                @if($school->profile && $school->profile->principal_photo_url)
                                    {{-- Pastikan mengarah ke subfolder principal-photos --}}
                                    <img src="{{ asset('storage/' . $school->profile->principal_photo_url) }}"
                                        alt="Kepala Sekolah"
                                        class="w-full h-full object-cover object-center"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <i class="fas fa-user text-5xl text-white hidden"></i>
                                @else
                                    <i class="fas fa-user text-5xl text-white"></i>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 text-center mb-2">
                            {{ $school->profile?->principal_name ?? 'Kepala Sekolah' }}
                        </h3>
                        <p class="text-indigo-600 font-semibold text-center mb-4">Kepala Sekolah</p>
                    </div>

                    <!-- Right Column: Principal Welcome Message (from SchoolProfile) -->
                    <div class="p-8 md:p-10 flex items-center">
                        <div class="w-full">
                            <h4 class="text-lg font-semibold text-gray-700 mb-3">Sambutan Kepala Sekolah</h4>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! $school->profile?->principal_welcome_message ?? $school->profile?->principal_message ?? '<p>Memimpin dengan visi mewujudkan sekolah yang unggul dan berkarakter.</p>' !!}
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" id="content">
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center mb-6">
            <i class="fas fa-bullseye text-3xl text-indigo-600 mr-3"></i>
            <h3 class="text-3xl font-bold text-gray-800">Visi & Misi</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-6 bg-indigo-50 rounded-xl border-l-4 border-indigo-500">
                <h4 class="text-xl font-bold text-indigo-700 mb-3 flex items-center">
                    <i class="fas fa-eye mr-2"></i>Visi
                </h4>
                <div class="text-gray-700 leading-relaxed italic prose max-w-none">
                    {!! $school->profile?->vision ?? 'Visi sekolah belum diatur.' !!}
                </div>
            </div>

            <div class="p-6 bg-purple-50 rounded-xl border-l-4 border-purple-500">
                <h4 class="text-xl font-bold text-purple-700 mb-3 flex items-center">
                    <i class="fas fa-tasks mr-2"></i>Misi
                </h4>
                <div class="text-gray-700 leading-relaxed prose max-w-none">
                    {!! $school->profile?->mission ?? 'Misi sekolah belum diatur.' !!}
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" id="content">

            <div class="lg:col-span-2 space-y-6">
              <div class="flex items-center mb-6 pt-4"> <i class="fas fa-newspaper text-3xl text-indigo-600 mr-3"></i>
            <h3 class="text-3xl font-bold text-gray-800">Berita Terbaru</h3>
        </div>
                
                @if ($posts->count() > 0)
                    @foreach ($posts as $post)
                        <div class="bg-white p-7 rounded-xl shadow-lg border border-gray-200 transition duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <h4 class="text-xl font-semibold text-indigo-600 mb-3">{{ $post->title }}</h4>
                            <p class="text-gray-600 mb-4 leading-relaxed">{{ Str::limit($post->content, 150) }}</p>
                            <div class="flex justify-between items-center text-sm text-gray-500 pt-3 border-t border-gray-200">
                                <small><i class="far fa-calendar-alt mr-1 text-indigo-500"></i>{{ $post->created_at->format('d M Y') }}</small>
                                <a href="{{ route('posts', $school->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition">Baca Selengkapnya →</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3 inline-block"></i>
                        <p class="text-gray-600 mb-2">Belum ada berita yang dipublikasikan</p>
                        <p class="mt-4"><a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Login ke Admin Panel</a> untuk membuat berita.</p>
                    </div>
                @endif
            </div>

            <!-- Contact sidebar removed per request -->
        </div>
        
    </div>

    <!-- Statistik Sekolah: dipindahkan ke bawah post dan menjadi kontainer sendiri -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-16" id="schoolStatistics">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <i class="fas fa-chart-area text-3xl text-indigo-600 mr-3"></i>
                <h3 class="text-2xl font-bold text-gray-800">Statistik Sekolah</h3>
            </div>
            {{-- <div class="flex items-center space-x-3">
                <label class="text-sm text-gray-600">Tampilkan:</label>
                <select id="dashboardTypeFilter" class="border rounded-md px-3 py-2 text-sm">
                    <option value="guru">Guru</option>
                    <option value="murid">Murid</option>
                </select>
            </div> --}}
        </div>

       <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
    <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white">
            <i class="fas fa-chalkboard-user"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Guru</p>
            <p class="text-2xl font-extrabold text-blue-600">{{ $teachers->count() }}</p>
        </div>
    </div>

    <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center text-white">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Peserta Didik</p>
            <p class="text-2xl font-extrabold text-purple-600">{{ $students->count() }}</p>
        </div>
    </div>

    <div class="p-4 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center text-white">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Mapel</p>
            <p class="text-2xl font-extrabold text-emerald-600">{{ $totalSubjects ?? 0 }}</p>
        </div>
    </div>

    <div class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center text-white">
            <i class="fas fa-trophy"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Eskul</p>
            <p class="text-2xl font-extrabold text-orange-600">{{ $totalEskul ?? 0 }}</p>
        </div>
    </div>
</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- <div>
                <label class="text-sm text-gray-600">Filter Mata Pelajaran</label>
                <select id="subjectFilter" class="w-full border rounded-md px-3 py-2 text-sm">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm text-gray-600">Filter Gender</label>
                <select id="classFilter" class="w-full border rounded-md px-3 py-2 text-sm">
                    <option value="">Semua Gender</option>
                    @foreach($teachers->pluck('gender')->unique()->filter()->values() as $gender)
                        <option value="{{ $gender }}">{{ $gender }}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>

        <div id="teacherDashboard">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Filter Mata Pelajaran</label>
                        <select id="subjectFilter" class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Filter Gender</label>
                        <select id="genderFilter" class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50">
                            <option value="">Semua Gender</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <h5 class="text-sm font-bold text-gray-700 mb-4">Distribusi Mata Pelajaran (Guru)</h5>
                        <div class="h-[300px]"><canvas id="subjectChart"></canvas></div>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <h5 class="text-sm font-bold text-gray-700 mb-4">Distribusi Gender (Guru)</h5>
                        <div class="h-[300px]"><canvas id="genderChart"></canvas></div>
                    </div>
                </div>
            </div>

            <div id="studentDashboardSection" class="mt-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <label class="text-sm font-semibold text-gray-600">Filter Gender (Peserta Didik)</label>
            <select id="studentGenderFilter" class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50">
                <option value="">Semua Gender</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">Filter Kelas (Peserta Didik)</label>
            <select id="studentClassFilter" class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50">
                <option value="">Semua Kelas</option>
                @foreach($students->pluck('class')->unique()->filter()->values() as $class)
                    <option value="{{ $class }}">{{ $class }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h5 class="text-sm font-bold text-gray-700 mb-4">Distribusi Gender (Murid)</h5>
            <div class="h-[300px]">
                <canvas id="studentGenderChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h5 class="text-sm font-bold text-gray-700 mb-4">Distribusi Per Kelas (Murid)</h5>
            <div class="h-[300px]">
                <canvas id="studentClassChart"></canvas>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
    
    <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-gray-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold text-white mb-3 flex items-center">
                        <i class="fas fa-school text-indigo-400 mr-2"></i> {{ $school->name }}
                    </h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Portal informasi resmi yang menyediakan berita, data guru dan siswa, serta fasilitas sekolah.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition">Beranda</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition">Berita</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition">Guru</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition">Galeri</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-gray-700 mb-6">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} <span class="text-indigo-400 font-semibold">{{ $school->name }}</span> | CMS Sekolah Kita | Powered by Laravel & Filament</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Contact Overlay -->
    @if($school->profile && $school->profile->contact_phone)
        <div class="fixed bottom-6 right-6 z-50">
            <a href="https://wa.me/{{ '+62' . ltrim(preg_replace('/[^0-9]/', '', $school->profile->contact_phone), '0') }}"
               target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 group">
                <i class="fab fa-whatsapp text-2xl"></i>
                <div class="absolute right-full mr-3 bg-gray-800 text-white text-sm px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                    Hubungi Kami
                    <div class="absolute left-full top-1/2 transform -translate-y-1/2 border-4 border-transparent border-l-gray-800"></div>
                </div>
            </a>
        </div>
    @endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data Dasar dari Laravel
        const rawTeachers = @json($teachers);
        const rawStudents = @json($students);
        
        // Elemen Filter Guru
        const subjectFilter = document.getElementById('subjectFilter');
        const genderFilter = document.getElementById('genderFilter');

        // Elemen Filter Murid
        const studentClassFilter = document.getElementById('studentClassFilter');
        const studentGenderFilter = document.getElementById('studentGenderFilter');

        // Variabel Chart
        let subjectChart, genderChart, studentGenderChart, studentClassChart;

        // --- FUNGSI GRAFIK GURU (TETAP SAMA) ---
        function updateTeacherCharts() {
            const selectedSub = subjectFilter.value;
            const selectedGen = genderFilter.value;

            let filteredForSubject = rawTeachers.filter(t => selectedSub === '' || String(t.subject_id) === selectedSub);
            let filteredForGender = rawTeachers.filter(t => {
                const normalized = (t.gender === 'L' || t.gender === 'Laki-laki') ? 'Laki-laki' : 'Perempuan';
                return selectedGen === '' || normalized === selectedGen;
            });

            const subMap = {};
            const genMap = { 'Laki-laki': 0, 'Perempuan': 0 };

            filteredForSubject.forEach(t => {
                const subjectName = (t.subject && t.subject.name) ? t.subject.name : 'Tanpa Mapel';
                subMap[subjectName] = (subMap[subjectName] || 0) + 1;
            });

            filteredForGender.forEach(t => {
                if (t.gender === 'L' || t.gender === 'Laki-laki') genMap['Laki-laki']++;
                else if (t.gender === 'P' || t.gender === 'Perempuan') genMap['Perempuan']++;
            });

            renderTeacherCharts(subMap, genMap);
        }

        function renderTeacherCharts(subMap, genMap) {
            const ctxSub = document.getElementById('subjectChart').getContext('2d');
            if (subjectChart) subjectChart.destroy();
            subjectChart = new Chart(ctxSub, {
                type: 'bar',
                data: {
                    labels: Object.keys(subMap).length ? Object.keys(subMap) : ['Kosong'],
                    datasets: [{ label: 'Jumlah Guru', data: Object.values(subMap).length ? Object.values(subMap) : [0], backgroundColor: '#10B981', borderRadius: 6 }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            const ctxGen = document.getElementById('genderChart').getContext('2d');
            if (genderChart) genderChart.destroy();
            genderChart = new Chart(ctxGen, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(genMap),
                    datasets: [{ data: Object.values(genMap), backgroundColor: ['#3B82F6', '#F472B6'], borderWidth: 0 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });
        }

        // --- FUNGSI GRAFIK MURID (BARU & TERPISAH) ---
        function updateStudentCharts() {
    const selectedClass = studentClassFilter.value;
    const selectedGen = studentGenderFilter.value;

    // 1. Filter untuk Grafik Kelas (Independen)
    let filteredForClass = rawStudents.filter(s => {
        return selectedClass === '' || s.class === selectedClass;
    });

    // 2. Filter untuk Grafik Gender (Independen & Normalisasi)
    let filteredForGen = rawStudents.filter(s => {
        // Normalisasi data agar 'P' dibaca 'Perempuan' dan 'L' dibaca 'Laki-laki'
        const normalized = (s.gender === 'L' || s.gender === 'Laki-laki') ? 'Laki-laki' : 'Perempuan';
        return selectedGen === '' || normalized === selectedGen;
    });

    // Hitung ulang data Gender Murid
    const genMap = { 'Laki-laki': 0, 'Perempuan': 0 };
    filteredForGen.forEach(s => {
        if (s.gender === 'L' || s.gender === 'Laki-laki') genMap['Laki-laki']++;
        else if (s.gender === 'P' || s.gender === 'Perempuan') genMap['Perempuan']++;
    });

    // Hitung ulang data Kelas Murid
    const classMap = {};
    filteredForClass.forEach(s => {
        const className = s.class ? s.class : 'Tanpa Kelas';
        classMap[className] = (classMap[className] || 0) + 1;
    });

    // Render grafik dengan data terbaru
    renderStudentCharts(genMap, classMap);
}

        function renderStudentCharts(genMap, classMap) {
            // Render Gender Murid
            const ctxGen = document.getElementById('studentGenderChart').getContext('2d');
            if (studentGenderChart) studentGenderChart.destroy();
            studentGenderChart = new Chart(ctxGen, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(genMap),
                    datasets: [{ data: Object.values(genMap), backgroundColor: ['#6366F1', '#EC4899'], borderWidth: 0 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            // Render Kelas Murid
            const ctxClass = document.getElementById('studentClassChart').getContext('2d');
            if (studentClassChart) studentClassChart.destroy();
            studentClassChart = new Chart(ctxClass, {
                type: 'bar',
                data: {
                    labels: Object.keys(classMap).length ? Object.keys(classMap).sort() : ['Kosong'],
                    datasets: [{ label: 'Jumlah Murid', data: Object.values(classMap).length ? Object.values(classMap) : [0], backgroundColor: '#8B5CF6', borderRadius: 6 }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });
        }

        // Event Listeners
        subjectFilter.addEventListener('change', updateTeacherCharts);
        genderFilter.addEventListener('change', updateTeacherCharts);
        studentClassFilter.addEventListener('change', updateStudentCharts);
        studentGenderFilter.addEventListener('change', updateStudentCharts);

        // Load Awal
        updateTeacherCharts();
        updateStudentCharts();
    });
</script>
</body>
</html>
