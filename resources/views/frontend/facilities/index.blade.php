<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fasilitas Sekolah - {{ $school->name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-blue-100 min-h-screen">

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
                        <a href="{{ route('school.homepage', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
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
                        <a href="{{ route('facilities', $school->slug) }}" class="border-b-2 border-indigo-500 text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
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

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-600 text-white py-20 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full -mr-48 -mt-48 opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-600 rounded-full -ml-32 -mb-32 opacity-20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="inline-block bg-blue-500 bg-opacity-50 px-4 py-2 rounded-full mb-4">
                <span class="text-sm font-semibold">INFRASTRUKTUR SEKOLAH</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4">
                Fasilitas Sekolah
            </h1>
            <p class="text-xl text-blue-100">Sarana dan prasarana lengkap untuk mendukung pembelajaran di {{ $school->name }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <!-- Facilities List -->
        <div>
            <div class="flex items-center mb-10">
                <i class="fas fa-tools text-3xl text-blue-600 mr-3"></i>
                <h3 class="text-3xl font-bold text-gray-800">Daftar Fasilitas</h3>
            </div>

            @if ($facilities->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($facilities as $facility)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 group">
                            <!-- Image Section -->
                            <div class="relative h-56 bg-gradient-to-br from-blue-400 to-indigo-500 overflow-hidden flex items-center justify-center">
                                @if($facility->photo_url)
                                    <img src="{{ asset('storage/' . $facility->photo_url) }}" alt="{{ $facility->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black opacity-20"></div>
                                @endif
                                <div class="w-full h-full bg-gradient-to-br from-blue-300 to-indigo-400 flex items-center justify-center {{ $facility->photo_url ? 'hidden' : '' }}">
                                    <i class="fas fa-building text-6xl text-white opacity-50"></i>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-7">
                                <h4 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition">
                                    {{ $facility->name }}
                                </h4>
                                <p class="text-gray-600 mb-4 leading-relaxed text-sm line-clamp-3">
                                    {{ Str::limit(strip_tags($facility->description), 100) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Statistics -->
                <div class="mt-16 bg-white rounded-2xl shadow-xl p-10">
                    <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center flex items-center justify-center">
                        <i class="fas fa-chart-bar mr-3 text-blue-600"></i>Statistik Fasilitas
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl text-center border-2 border-blue-200">
                            <div class="text-5xl font-extrabold text-blue-600 mb-3">{{ $facilities->count() }}</div>
                            <div class="text-gray-700 font-medium">Total Fasilitas</div>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 rounded-xl text-center border-2 border-indigo-200">
                            <div class="text-5xl font-extrabold text-indigo-600 mb-3">{{ $facilities->pluck('type')->unique()->count() }}</div>
                            <div class="text-gray-700 font-medium">Jenis Fasilitas</div>
                        </div>
                        <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-8 rounded-xl text-center border-2 border-cyan-200">
                            <div class="text-5xl font-extrabold text-cyan-600 mb-3">{{ $facilities->whereNotNull('photo_url')->count() }}</div>
                            <div class="text-gray-700 font-medium">Dengan Foto</div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="bg-white rounded-2xl shadow-xl p-16 max-w-md mx-auto">
                        <div class="bg-blue-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-building text-5xl text-blue-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data Fasilitas</h3>
                        <p class="text-gray-600 mb-8">Data fasilitas belum tersedia untuk sekolah ini.</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-lg transition duration-300 font-semibold">
                            <i class="fas fa-plus mr-2"></i> Tambah Fasilitas
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-gray-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold text-white mb-3 flex items-center">
                            {{ $school->name }}
                    </h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Portal informasi resmi yang menyediakan berita, data guru dan siswa, serta fasilitas sekolah.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('school.homepage', $school->slug) }}" class="text-gray-400 hover:text-blue-400 transition">Beranda</a></li>
                        <li><a href="{{ route('posts', $school->slug) }}" class="text-gray-400 hover:text-blue-400 transition">Berita</a></li>
                        <li><a href="{{ route('teachers', $school->slug) }}" class="text-gray-400 hover:text-blue-400 transition">Guru</a></li>
                        <li><a href="{{ route('gallery', $school->slug) }}" class="text-gray-400 hover:text-blue-400 transition">Galeri</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-gray-700 mb-6">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} <span class="text-blue-400 font-semibold">{{ $school->name }}</span> | CMS Sekolah Kita | Powered by Laravel & Filament</p>
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

</body>
</html>
