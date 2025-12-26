<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri | {{ $school->name }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 to-pink-100 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <!-- Top Bar: Logo & Social Media -->
        <div class="bg-gray-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-3">
                    <!-- School Name -->
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

        <!-- Bottom Bar: Navigation Menu -->
        <div class="bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('school.homepage', $school->slug) }}" class="text-gray-700 hover:text-indigo-600 px-1 pt-1 text-sm font-medium"><i class="fas fa-home mr-1"></i>Beranda</a>

                        <a href="{{ route('posts', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-newspaper mr-1"></i>Berita
                        </a>
                        <a href="{{ route('teachers', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-users mr-1"></i>Guru
                        </a>
                         <a href="{{ route('gallery', $school->slug) }}" class="border-b-2 border-indigo-500 text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
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

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 text-white py-20 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500 rounded-full -mr-48 -mt-48 opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-pink-600 rounded-full -ml-32 -mb-32 opacity-20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="inline-block bg-purple-500 bg-opacity-50 px-4 py-2 rounded-full mb-4">
                <span class="text-sm font-semibold">DOKUMENTASI VISUAL</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Galeri Sekolah</h1>
            <p class="text-xl text-purple-100">Momen berharga dari {{ $school->name }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if ($galleries->count() > 0)
            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="filter-btn active px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-full hover:from-purple-700 hover:to-purple-800 transition duration-300 font-semibold shadow-lg" data-filter="all">
                    <i class="fas fa-th-large mr-2"></i>Semua
                </button>
                <button class="filter-btn px-6 py-3 bg-gray-200 text-gray-700 rounded-full hover:bg-purple-600 hover:text-white transition duration-300 font-semibold" data-filter="image">
                    <i class="fas fa-image mr-2"></i>Foto
                </button>
                <button class="filter-btn px-6 py-3 bg-gray-200 text-gray-700 rounded-full hover:bg-purple-600 hover:text-white transition duration-300 font-semibold" data-filter="video">
                    <i class="fas fa-video mr-2"></i>Video
                </button>
            </div>

            <!-- Gallery Grid -->
            <div class="gallery-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
              @foreach ($galleries as $item)
                <div class="gallery-item {{ $item->type }} bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 group">
                    <div class="relative h-64 bg-gray-200 overflow-hidden">
                        @if ($item->type === 'image')
                            {{-- Logika untuk menangani Array Gambar --}}
                            @php
                                // Pastikan kita mendapatkan array, baik dari cast model atau decode manual
                                $images = is_array($item->file_path) ? $item->file_path : json_decode($item->file_path, true);
                                // Ambil gambar pertama sebagai cover
                                $coverImage = $images[0] ?? null;
                            @endphp

                            @if($coverImage)
                                <img src="{{ asset('storage/' . $coverImage) }}"
                                    alt="{{ $item->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                    onerror="this.onerror=null; this.src='https://placehold.co/400x300/cccccc/333333?text=Gambar+Tidak+Ditemukan';">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
                                <i class="fas fa-search text-white text-4xl opacity-0 group-hover:opacity-100 transition duration-300"></i>
                            </div>
                        @else
                            <iframe src="{{ $item->file_path }}"
                                    class="w-full h-full"
                                    frameborder="0"
                                    allowfullscreen
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            </iframe>
                            <div class="w-full h-full bg-gray-300 flex items-center justify-center hidden">
                                <i class="fas fa-video text-5xl text-gray-500"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-purple-600 transition">
                            {{ $item->title }}
                        </h3>
                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                            {{ $item->caption }}
                        </p>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                           <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                {{ $item->type === 'image' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                                <i class="fas {{ $item->type === 'image' ? 'fa-image' : 'fa-video' }} mr-1"></i>
                                {{ ucfirst($item->type) }} 
                                
                                {{-- Cek apakah $images benar-benar array sebelum dihitung --}}
                                @if($item->type === 'image' && is_array($images) && count($images) > 1)
                                    <span class="ml-1">({{ count($images) }} Foto)</span>
                                @endif
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-2xl shadow-xl p-10">
                <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center flex items-center justify-center">
                    <i class="fas fa-chart-bar mr-3 text-purple-600"></i>Statistik Galeri
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-xl text-center border-2 border-purple-200">
                        <div class="text-5xl font-extrabold text-purple-600 mb-3">{{ $galleries->count() }}</div>
                        <div class="text-gray-700 font-medium">Total Konten</div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl text-center border-2 border-blue-200">
                        <div class="text-5xl font-extrabold text-blue-600 mb-3">{{ $galleries->where('type', 'image')->count() }}</div>
                        <div class="text-gray-700 font-medium">Total Foto</div>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-8 rounded-xl text-center border-2 border-red-200">
                        <div class="text-5xl font-extrabold text-red-600 mb-3">{{ $galleries->where('type', 'video')->count() }}</div>
                        <div class="text-gray-700 font-medium">Total Video</div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="bg-white rounded-2xl shadow-xl p-16 max-w-md mx-auto">
                    <div class="bg-purple-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-images text-5xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Galeri Kosong</h3>
                    <p class="text-gray-600 mb-8">Belum ada konten galeri untuk sekolah ini.</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 shadow-lg transition duration-300 font-semibold">
                        <i class="fas fa-plus mr-2"></i> Tambah Konten
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-gray-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold text-white mb-3 flex items-center">
                            {{ $school->name }}
                    </h3>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Hubungi Kami</h4>
                    <div class="space-y-2 text-sm">
                        @if($school->profile?->contact_phone)
                            <p><i class="fas fa-phone text-purple-400 mr-2"></i> {{ $school->profile->contact_phone }}</p>
                        @endif
                        @if($school->profile?->contact_email)
                            <p><i class="fas fa-envelope text-purple-400 mr-2"></i> {{ $school->profile->contact_email }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <hr class="border-gray-700 mb-6">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} <span class="text-purple-400 font-semibold">{{ $school->name }}</span> | CMS Sekolah Kita | Powered by Laravel & Filament</p>
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

    <script>
        // Gallery filtering functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-gradient-to-r', 'from-purple-600', 'to-purple-700', 'text-white', 'shadow-lg');
                        btn.classList.add('bg-gray-200', 'text-gray-700');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'bg-gradient-to-r', 'from-purple-600', 'to-purple-700', 'text-white', 'shadow-lg');
                    this.classList.remove('bg-gray-200', 'text-gray-700');

                    const filterValue = this.getAttribute('data-filter');

                    galleryItems.forEach(item => {
                        if (filterValue === 'all') {
                            item.style.display = 'block';
                        } else {
                            if (item.classList.contains(filterValue)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        }
                    });
                });
            });
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .aspect-w-4 { position: relative; padding-bottom: 75%; }
        .aspect-w-16 { position: relative; padding-bottom: 56.25%; }
        .aspect-w-4 > *, .aspect-w-16 > * {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
    </style>
</body>
</html>
