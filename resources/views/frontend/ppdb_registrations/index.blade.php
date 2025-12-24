<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran PPDB - {{ $school->name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-blue-100 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('school.homepage', $school->slug) }}" class="text-xl font-extrabold text-indigo-600 hover:text-indigo-700 transition duration-300">
                        <i class="fas fa-school mr-2"></i>{{ $school->name }}
                    </a>
                </div>

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
                    <a href="{{ route('ppdb_registrations', $school->slug) }}" class="border-b-2 border-indigo-500 text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                        <i class="fas fa-user-plus mr-1"></i>PPDB
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 px-4 py-2 rounded-lg shadow-sm transition duration-300 transform hover:scale-105">
                        <i class="fas fa-user-shield mr-1"></i> Login Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <i class="fas fa-user-plus text-6xl mb-6 animate-bounce"></i>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4">
                Pendaftaran PPDB
            </h1>
            <h2 class="text-2xl md:text-3xl font-light mb-6">{{ $school->name }}</h2>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- PPDB Registrations List -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-list mr-2 text-blue-500"></i> Daftar Pendaftaran PPDB
            </h3>

            @if ($ppdbRegistrations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah Asal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak Orang Tua</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($ppdbRegistrations as $registration)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $registration->student_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registration->origin_school }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>{{ $registration->parent_phone }}</div>
                                        <div class="text-xs">{{ $registration->parent_email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($registration->status == 'approved') bg-green-100 text-green-800
                                            @elseif($registration->status == 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-gray-50 p-6 rounded-lg text-center">
                    <p class="text-gray-600">Belum ada data pendaftaran PPDB yang tersedia untuk sekolah ini.</p>
                    <p class="mt-3"><a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login ke Admin Panel</a> untuk mengelola pendaftaran PPDB.</p>
                </div>
            @endif
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm opacity-75">
                &copy; {{ date('Y') }} {{ $school->name }} | Powered by Laravel CMS
            </p>
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
