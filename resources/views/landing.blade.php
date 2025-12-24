<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Diambil dari .env jika ada, jika tidak, pakai 'CMS Padamu Negeri' --}}
    <title>{{ config('app.name', 'CMS Padamu Negeri') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS Tambahan untuk memastikan FULL PAGE dan CENTERING */
        html, body {
            height: 100%;
        }
        body {
            font-family: 'Inter', sans-serif;
            /* Enhanced gradient background with subtle pattern */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            /* Memastikan semua konten di tengah secara vertikal dan horizontal */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        /* Subtle background pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.05) 0%, transparent 50%);
            background-size: 400px 400px;
            animation: float 20s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-10px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }
        /* Wrapper Konten: Enhanced with better styling */
        .content-wrapper {
             width: 100%;
             max-width: 650px; /* Slightly increased for better layout */
             background: rgba(255, 255, 255, 0.98);
             backdrop-filter: blur(20px);
             border-radius: 24px;
             padding: 50px;
             box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.2);
             animation: fadeInUp 1s ease-out;
             position: relative;
             z-index: 1;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .btn-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-hover:hover::before {
            left: 100%;
        }
        .btn-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        .school-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }
        .school-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
            transition: left 0.6s;
        }
        .school-card:hover::before {
            left: 100%;
        }
        .school-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        /* Enhanced icon animation */
        .icon-pulse {
            animation: iconPulse 2s ease-in-out infinite;
        }
        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        /* Text gradient effect */
        .text-gradient {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="antialiased">

    <div class="content-wrapper">

        <div class="text-center mb-12">
            <div class="mb-6">
                <i class="fas fa-school text-6xl text-indigo-600 icon-pulse"></i>
            </div>
            <h1 class="text-5xl font-extrabold text-gradient mb-4 tracking-tight">
                CMS Padamu Negeri
            </h1>
            <h2 class="text-2xl font-semibold text-gray-600 mb-4">
                Platform Pembuatan Web Profil Sekolah
            </h2>
            <p class="text-lg text-gray-500 leading-relaxed">
                Domain utama platform Anda diakses. Kelola dan tampilkan profil sekolah dengan mudah dan profesional.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-12">
            <a href="{{ route('login') }}"
               class="btn-hover inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-semibold rounded-2xl shadow-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Login Admin
            </a>

            <a href="{{ route('register') }}"
               class="btn-hover inline-flex items-center justify-center px-8 py-4 border-2 border-indigo-600 text-lg font-semibold rounded-2xl text-indigo-600 bg-white hover:bg-indigo-50 transition duration-300 shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Daftar Sekolah Baru
            </a>
        </div>

        <?php $schools = \App\Models\School::all(); ?>
        @if ($schools->count() > 0)
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-center mb-6">
                    <i class="fas fa-list-ul text-indigo-600 mr-2"></i>
                    <p class="text-xl font-bold text-gray-700">
                        Sekolah Terdaftar (Uji Coba Tampilan Publik)
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-1 lg:grid-cols-2">
                    @foreach ($schools as $school)
                        <a href="{{ url('s/' . $school->slug) }}" class="school-card bg-white p-8 border border-gray-200 hover:border-indigo-300 block">
                            <div class="flex items-center">
                                <i class="fas fa-university text-indigo-500 mr-4 text-2xl"></i>
                                <span class="text-gray-800 font-semibold text-xl">{{ $school->name }}</span>
                                <i class="fas fa-external-link-alt ml-auto text-gray-400 text-lg"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</body>
</html>
