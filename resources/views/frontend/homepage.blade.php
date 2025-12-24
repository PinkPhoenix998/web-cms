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
                    <div class="flex items-center">
                        <a href="{{ route('school.homepage', $school->slug) }}" class="text-lg font-extrabold text-indigo-600 hover:text-indigo-700 transition duration-300">
                            {{ $school->name }}
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
                                @php
                                    $principalPhoto = $school->profile?->principal_photo_url ?? $school->profile?->principal_photo ?? null;
                                @endphp
                                @if($principalPhoto)
                                    <img src="{{ asset('storage/' . $principalPhoto) }}"
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

            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center mb-6">
                    <i class="fas fa-newspaper text-3xl text-indigo-600 mr-3"></i>
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
                <div class="flex items-center space-x-3">
                    <label class="text-sm text-gray-600">Tampilkan:</label>
                    <select id="dashboardTypeFilter" class="border rounded-md px-3 py-2 text-sm">
                        <option value="guru">Guru</option>
                        <option value="murid">Murid</option>
                    </select>
                </div>
            </div>

            <!-- Numeric summary cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Guru</p>
                        <p class="text-2xl font-extrabold text-blue-600">{{ $teachers->count() ?? 0 }}</p>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Siswa</p>
                        <p class="text-2xl font-extrabold text-purple-600">{{ $students->count() ?? 0 }}</p>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-school"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Kelas</p>
                        <p class="text-2xl font-extrabold text-emerald-600">{{ $students->pluck('class')->unique()->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Filters area for teacher/student dashboards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="text-sm text-gray-600">Filter Mata Pelajaran</label>
                    <select id="subjectFilter" class="w-full border rounded-md px-3 py-2 text-sm">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($teachers->pluck('position')->unique()->filter()->values() as $position)
                            <option value="{{ $position }}">{{ $position }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Filter Kelas</label>
                    <select id="classFilter" class="w-full border rounded-md px-3 py-2 text-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($teachers->pluck('class')->unique()->filter()->values() as $class)
                            <option value="{{ $class }}">{{ $class }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Teacher Dashboard -->
            <div id="teacherDashboard">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Distribusi Mata Pelajaran (Guru)</h5>
                        <canvas id="subjectChart" height="160"></canvas>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Distribusi per Kelas (Guru)</h5>
                        <canvas id="classChart" height="160"></canvas>
                    </div>
                </div>
            </div>

            <!-- Student Dashboard (hidden by default JS will toggle) -->
            <div id="studentDashboard" class="hidden mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Distribusi Siswa per Kelas</h5>
                        <canvas id="studentChart" height="160"></canvas>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Distribusi Nilai</h5>
                        <canvas id="gradeChart" height="160"></canvas>
                    </div>
                </div>
            </div>

            <!-- Additional student filters used by JS -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Filter Kelas (Siswa)</label>
                    <select id="studentClassFilter" class="w-full border rounded-md px-3 py-2 text-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($students->pluck('class')->unique()->filter()->values() as $sc)
                            <option value="{{ $sc }}">{{ $sc }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Filter Tingkatan (Siswa)</label>
                    <select id="studentGradeFilter" class="w-full border rounded-md px-3 py-2 text-sm">
                        <option value="">Semua Tingkatan</option>
                        <option value="sd">SD</option>
                        <option value="smp">SMP</option>
                        <option value="sma">SMA</option>
                    </select>
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
        // Dashboard filtering and chart functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dashboardTypeFilter = document.getElementById('dashboardTypeFilter');
            const teacherDashboard = document.getElementById('teacherDashboard');
            const studentDashboard = document.getElementById('studentDashboard');
            const subjectFilter = document.getElementById('subjectFilter');
            const classFilter = document.getElementById('classFilter');
            const studentClassFilter = document.getElementById('studentClassFilter');
            const studentGradeFilter = document.getElementById('studentGradeFilter');

            let subjectChart, studentChart, gradeChart, classChart;

            // Initialize teacher dashboard
            function initTeacherDashboard() {
                // Get raw data from blade
                const rawTeachers = @json($teachers);
                console.log('=== TEACHER DASHBOARD DEBUG ===');
                console.log('Raw $teachers count:', rawTeachers ? rawTeachers.length : 0);
                
                // Filter active teachers if needed
                let teachersData = Array.isArray(rawTeachers) ? rawTeachers : [];

                // Subject distribution data
                const subjectCounts = {};
                const classCounts = {};
                
                teachersData.forEach((teacher, idx) => {
                    if (teacher.position) {
                        subjectCounts[teacher.position] = (subjectCounts[teacher.position] || 0) + 1;
                    }
                    if (teacher.class) {
                        classCounts[teacher.class] = (classCounts[teacher.class] || 0) + 1;
                    }
                });
                
                console.log('Subject counts:', subjectCounts);
                console.log('Class counts:', classCounts);

                // Render charts with all data
                renderTeacherCharts(subjectCounts, classCounts, teachersData);
            }

            // Render teacher charts
            function renderTeacherCharts(subjectCounts, classCounts, allTeachers) {
                const subjectLabels = Object.keys(subjectCounts).length > 0 ? Object.keys(subjectCounts) : ['Tidak ada data'];
                const subjectData = Object.keys(subjectCounts).length > 0 ? Object.values(subjectCounts) : [0];
                const classLabels = Object.keys(classCounts).length > 0 ? Object.keys(classCounts).sort() : ['Tidak ada data'];
                const classData = Object.keys(classCounts).length > 0 ? classLabels.map(label => classCounts[label]) : [0];

                console.log('Final chart data:', { subjectLabels, subjectData, classLabels, classData });

                // Create subject chart
                const subjectCtx = document.getElementById('subjectChart');
                if (subjectCtx) {
                    const subjectCtxContext = subjectCtx.getContext('2d');
                    if (subjectChart) subjectChart.destroy();
                    subjectChart = new Chart(subjectCtxContext, {
                        type: 'bar',
                        data: {
                            labels: subjectLabels,
                            datasets: [{
                                label: 'Jumlah Guru',
                                data: subjectData,
                                backgroundColor: '#10B981',
                                borderColor: '#059669',
                                borderWidth: 1,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: { font: { size: 12 } }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                    console.log('✓ Subject chart created');
                }

                // Create class chart
                const classCtx = document.getElementById('classChart');
                if (classCtx) {
                    const classCtxContext = classCtx.getContext('2d');
                    if (classChart) classChart.destroy();
                    classChart = new Chart(classCtxContext, {
                        type: 'bar',
                        data: {
                            labels: classLabels,
                            datasets: [{
                                label: 'Jumlah Guru',
                                data: classData,
                                backgroundColor: '#F59E0B',
                                borderColor: '#D97706',
                                borderWidth: 1,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: { font: { size: 12 } }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                    console.log('✓ Class chart created');
                }
            }

            // Filter and update teacher dashboard
            function filterTeacherDashboard() {
                const selectedSubject = subjectFilter ? subjectFilter.value : '';
                const selectedClass = classFilter ? classFilter.value : '';
                console.log('🔄 Filtering teachers:', { selectedSubject, selectedClass });
                
                const rawTeachers = @json($teachers ?? []);
                let filteredTeachers = Array.isArray(rawTeachers) ? [...rawTeachers] : [];
                console.log('Starting with teachers count:', filteredTeachers.length);
                
                // Apply filters
                if (selectedSubject) {
                    console.log('Filtering by position:', selectedSubject);
                    filteredTeachers = filteredTeachers.filter(t => {
                        const match = t.position === selectedSubject;
                        return match;
                    });
                }
                if (selectedClass) {
                    console.log('Filtering by class:', selectedClass);
                    filteredTeachers = filteredTeachers.filter(t => {
                        const match = t.class === selectedClass;
                        return match;
                    });
                }
                
                console.log('✓ Filtered teachers count:', filteredTeachers.length);
                
                // Recalculate counts
                const subjectCounts = {};
                const classCounts = {};
                
                filteredTeachers.forEach(teacher => {
                    if (teacher.position) {
                        subjectCounts[teacher.position] = (subjectCounts[teacher.position] || 0) + 1;
                    }
                    if (teacher.class) {
                        classCounts[teacher.class] = (classCounts[teacher.class] || 0) + 1;
                    }
                });
                
                console.log('Recalculated counts:', { subjectCounts, classCounts });
                
                // Re-render charts
                renderTeacherCharts(subjectCounts, classCounts, filteredTeachers);
            }

            // Initialize student dashboard
            function initStudentDashboard() {
                // Get real data from the students collection
                const studentsData = @json($students ?? []);
                renderStudentCharts(studentsData);
            }

            // Render student charts
            function renderStudentCharts(allStudents) {
                // Student distribution by class
                const classCounts = {};
                allStudents.forEach(student => {
                    if (student.class) {
                        classCounts[student.class] = (classCounts[student.class] || 0) + 1;
                    }
                });
                const studentLabels = Object.keys(classCounts).sort();
                const studentData = studentLabels.map(label => classCounts[label]);

                // Create student chart
                const studentCtx = document.getElementById('studentChart');
                if (studentCtx) {
                    const studentCtxContext = studentCtx.getContext('2d');
                    if (studentChart) studentChart.destroy();
                    studentChart = new Chart(studentCtxContext, {
                        type: 'bar',
                        data: {
                            labels: studentLabels,
                            datasets: [{
                                label: 'Jumlah Siswa',
                                data: studentData,
                                backgroundColor: '#8B5CF6',
                                borderColor: '#7C3AED',
                                borderWidth: 1,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: { font: { size: 12 } }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                }

                // Grade distribution - sample grades based on average scores
                const gradeRanges = {
                    'A (90-100)': 0,
                    'B (80-89)': 0,
                    'C (70-79)': 0,
                    'D (60-69)': 0,
                    'E (<60)': 0
                };
                
                allStudents.forEach(student => {
                    const score = student.average_score || 0;
                    if (score >= 90) gradeRanges['A (90-100)']++;
                    else if (score >= 80) gradeRanges['B (80-89)']++;
                    else if (score >= 70) gradeRanges['C (70-79)']++;
                    else if (score >= 60) gradeRanges['D (60-69)']++;
                    else gradeRanges['E (<60)']++;
                });

                const gradeLabels = Object.keys(gradeRanges);
                const gradeData = Object.values(gradeRanges);

                // Create grade chart
                const gradeCtx = document.getElementById('gradeChart');
                if (gradeCtx) {
                    const gradeCtxContext = gradeCtx.getContext('2d');
                    if (gradeChart) gradeChart.destroy();
                    gradeChart = new Chart(gradeCtxContext, {
                        type: 'doughnut',
                        data: {
                            labels: gradeLabels,
                            datasets: [{
                                label: 'Distribusi Nilai',
                                data: gradeData,
                                backgroundColor: [
                                    '#10B981',
                                    '#3B82F6',
                                    '#F59E0B',
                                    '#EF4444',
                                    '#6B7280'
                                ],
                                borderColor: '#ffffff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: { font: { size: 11 } }
                                }
                            }
                        }
                    });
                }
            }

            // Filter student dashboard
            function filterStudentDashboard() {
                const selectedClass = studentClassFilter.value;
                const selectedGrade = studentGradeFilter.value;
                console.log('Student Filtering:', { selectedClass, selectedGrade });
                
                const rawStudents = @json($students ?? []);
                let filteredStudents = Array.isArray(rawStudents) ? rawStudents : [];
                
                // Apply filters
                if (selectedClass) {
                    filteredStudents = filteredStudents.filter(s => s.class === selectedClass);
                }
                
                if (selectedGrade) {
                    filteredStudents = filteredStudents.filter(s => {
                        const score = s.average_score || 0;
                        switch(selectedGrade) {
                            case 'sd': return score >= 0 && score <= 6; // Contoh untuk SD
                            case 'smp': return score >= 7 && score <= 9;
                            case 'sma': return score >= 10;
                            default: return true;
                        }
                    });
                }
                
                console.log('Filtered students:', filteredStudents);
                renderStudentCharts(filteredStudents);
            }

            // Switch dashboard function
            function switchDashboard(dashboardType) {
                if (dashboardType === 'guru') {
                    teacherDashboard.classList.remove('hidden');
                    studentDashboard.classList.add('hidden');
                    if (!subjectChart || !classChart) {
                        initTeacherDashboard();
                    }
                } else if (dashboardType === 'murid') {
                    teacherDashboard.classList.add('hidden');
                    studentDashboard.classList.remove('hidden');
                    if (!studentChart || !gradeChart) {
                        initStudentDashboard();
                    }
                }
            }

            // Initialize with teacher dashboard
            initTeacherDashboard();

            // Dashboard type filter event listener
            dashboardTypeFilter.addEventListener('change', function() {
                switchDashboard(this.value);
            });

            // Teacher dashboard filtering - attach event listeners
            if (subjectFilter) {
                console.log('✓ Subject filter found, attaching listener');
                subjectFilter.addEventListener('change', function(e) {
                    console.log('Subject filter changed to:', e.target.value);
                    filterTeacherDashboard();
                });
            } else {
                console.error('❌ Subject filter not found');
            }
            
            if (classFilter) {
                console.log('✓ Class filter found, attaching listener');
                classFilter.addEventListener('change', function(e) {
                    console.log('Class filter changed to:', e.target.value);
                    filterTeacherDashboard();
                });
            } else {
                console.error('❌ Class filter not found');
            }

            // Student dashboard filtering
            if (studentClassFilter) {
                console.log('✓ Student class filter found, attaching listener');
                studentClassFilter.addEventListener('change', function(e) {
                    console.log('Student class filter changed to:', e.target.value);
                    filterStudentDashboard();
                });
            } else {
                console.error('❌ Student class filter not found');
            }
        });
    </script>

    <!-- Hero Carousel JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroSlides = document.querySelectorAll('.hero-slide');

            let currentHeroSlide = 0;
            let heroSlideInterval;

            // Initialize hero carousel
            function initHeroCarousel() {
                if (heroSlides.length === 0) return;

                // Show first slide
                showHeroSlide(0);

                // Auto-play carousel
                startHeroAutoPlay();
            }

            // Show specific hero slide
            function showHeroSlide(index) {
                // Remove active class from all slides
                heroSlides.forEach(slide => slide.classList.remove('active'));

                // Add active class to current slide
                heroSlides[index].classList.add('active');
                currentHeroSlide = index;
            }

            // Change hero slide
            function changeHeroSlide() {
                currentHeroSlide = (currentHeroSlide + 1) % heroSlides.length;
                showHeroSlide(currentHeroSlide);
            }

            // Auto-play functions for hero
            function startHeroAutoPlay() {
                heroSlideInterval = setInterval(() => {
                    changeHeroSlide();
                }, 4000); // Change slide every 4 seconds
            }

            function stopHeroAutoPlay() {
                clearInterval(heroSlideInterval);
            }

            // Initialize hero carousel
            initHeroCarousel();
        });
    </script>

    <!-- Carousel JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carouselContainer = document.querySelector('.carousel-container');
            const carouselSlides = document.querySelectorAll('.carousel-slide');
            const carouselPrev = document.querySelector('.carousel-prev');
            const carouselNext = document.querySelector('.carousel-next');
            const carouselIndicators = document.querySelectorAll('.carousel-indicator');

            let currentSlide = 0;
            let slideInterval;

            // Initialize carousel
            function initCarousel() {
                if (carouselSlides.length === 0) return;

                // Show first slide
                showSlide(0);

                // Auto-play carousel
                startAutoPlay();

                // Add event listeners
                if (carouselPrev) {
                    carouselPrev.addEventListener('click', () => {
                        changeSlide(-1);
                        resetAutoPlay();
                    });
                }

                if (carouselNext) {
                    carouselNext.addEventListener('click', () => {
                        changeSlide(1);
                        resetAutoPlay();
                    });
                }

                // Indicator click events
                carouselIndicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => {
                        showSlide(index);
                        resetAutoPlay();
                    });
                });

                // Pause on hover
                carouselContainer.addEventListener('mouseenter', stopAutoPlay);
                carouselContainer.addEventListener('mouseleave', startAutoPlay);
            }

            // Show specific slide
            function showSlide(index) {
                // Hide all slides
                carouselSlides.forEach(slide => {
                    slide.classList.remove('active');
                });

                // Update indicators
                carouselIndicators.forEach((indicator, i) => {
                    indicator.classList.toggle('active', i === index);
                });

                // Show current slide
                carouselSlides[index].classList.add('active');
                currentSlide = index;
            }

            // Change slide
            function changeSlide(direction) {
                const newIndex = (currentSlide + direction + carouselSlides.length) % carouselSlides.length;
                showSlide(newIndex);
            }

            // Auto-play functions
            function startAutoPlay() {
                slideInterval = setInterval(() => {
                    changeSlide(1);
                }, 5000); // Change slide every 5 seconds
            }

            function stopAutoPlay() {
                clearInterval(slideInterval);
            }

            function resetAutoPlay() {
                stopAutoPlay();
                startAutoPlay();
            }

            // Initialize carousel
            initCarousel();
        });
    </script>

</body>
</html>
