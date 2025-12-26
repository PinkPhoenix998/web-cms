<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PPDB | {{ $school->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">

    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="bg-gray-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-3">
                    <div class="flex items-center">
                        <a href="{{ route('school.homepage', $school->slug) }}" class="text-lg font-extrabold text-indigo-600 hover:text-indigo-700 transition duration-300">
                            {{ $school->name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
                        <a href="{{ route('gallery', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-images mr-1"></i>Galeri
                        </a>
                        <a href="{{ route('facilities', $school->slug) }}" class="border-b-2 border-transparent text-gray-700 hover:border-indigo-500 hover:text-indigo-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150">
                            <i class="fas fa-building mr-1"></i>Fasilitas
                        </a>
                        
                        <a href="{{ route('registration', $school->slug) }}" class="border-b-2 border-indigo-500 text-indigo-600 px-1 pt-1 text-sm font-medium"><i class="fas fa-edit mr-1"></i>PPDB</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-16 text-center">
        <h1 class="text-4xl font-extrabold uppercase">Formulir PPDB Online</h1>
        <p class="mt-2 text-indigo-100">Lengkapi seluruh data di bawah ini untuk mendaftar di {{ $school->name }}</p>
    </div>

    <div class="max-w-5xl mx-auto px-4 pb-20 -mt-10">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('registration.store', $school->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
                @csrf

                <section>
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-indigo-600"></i> I. DATA PENDAFTARAN
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2">Jenis Pendaftaran *</label>
                            <select name="registration_type" class="w-full border rounded-xl p-3 bg-gray-50" required>
                                <option value="Siswa Baru">Siswa Baru</option>
                                <option value="Pindahan">Pindahan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Jalur Pendaftaran *</label>
                            <select name="registration_path" class="w-full border rounded-xl p-3 bg-gray-50" required>
                                <option value="Zonasi">Umum</option>
                                <option value="Prestasi">Prestasi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">NIK / No. KITAS *</label>
                            <input type="text" name="nik_kitas" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Nama Sekolah Asal *</label>
                            <input type="text" name="origin_school" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                    </div>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2 flex items-center">
                        <i class="fas fa-user mr-2 text-indigo-600"></i> II. DATA PRIBADI SISWA
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-2">Nama Lengkap *</label>
                            <input type="text" name="full_name" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">NISN*</label>
                            <input type="text" name="nisn" class="w-full border-2 border-indigo-200 rounded-xl p-3 bg-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Jenis Kelamin *</label>
                            <select name="gender" class="w-full border rounded-xl p-3 bg-gray-50" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Tempat Lahir *</label>
                            <input type="text" name="birth_place" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Tanggal Lahir *</label>
                            <input type="date" name="birth_date" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Agama *</label>
                            <input type="text" name="religion" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Kewarganegaraan *</label>
                            <input type="text" name="nationality" value="Indonesia" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-2">Alamat Lengkap *</label>
                            <textarea name="address" rows="2" class="w-full border rounded-xl p-3 bg-gray-50" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Desa/Kelurahan *</label>
                            <input type="text" name="village" placeholder="Desa/Kelurahan *" class="w-full border rounded-xl p-3 bg-gray-50" required></div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Kecamatan *</label>
                            <input type="text" name="district" placeholder="Kecamatan *" class="w-full border rounded-xl p-3 bg-gray-50" required></div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Kabupaten/Kota *</label>
                            <input type="text" name="city" placeholder="Kabupaten/Kota *" class="w-full border rounded-xl p-3 bg-gray-50" required></div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Kode Pos *</label>
                            <input type="text" name="postal_code" placeholder="Kode Pos *" class="w-full border rounded-xl p-3 bg-gray-50" required></div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Tempat Tinggal *</label>
                            <select name="residence_type" class="w-full border rounded-xl p-3 bg-gray-50" required>
                                <option value="Bersama Orang Tua">Bersama Orang Tua</option>
                                <option value="Wali">Wali</option>
                                <option value="Wali">Asrama</option>
                                <option value="Wali">Panti Asuhan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Anak Ke Berapa *</label>
                            <input type="number" name="child_order" placeholder="Anak Ke- *" class="w-full border rounded-xl p-3 bg-gray-50" required></div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Jumlah Saudara Kandung *</label>
                            <input type="number" name="siblings_count" placeholder="Jumlah Saudara *" class="w-full border rounded-xl p-3 bg-gray-50" required></div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Memiliki KIP? *</label>
                            <select name="has_kip" class="w-full border rounded-xl p-3 bg-gray-50" required>
                                <option value="0">Tidak Memiliki KIP</option>
                                <option value="1">Memiliki KIP</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2 flex items-center">
                        <i class="fas fa-users mr-2 text-indigo-600"></i> III. DATA ORANG TUA
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="font-bold text-indigo-600">Data Ayah Kandung</label>
                            <input type="text" name="father_name" placeholder="Nama Ayah *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                            <input type="text" name="father_nik" placeholder="NIK Ayah *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                            <input type="text" name="father_job" placeholder="Pekerjaan Ayah *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                            <input type="text" name="father_income" placeholder="Penghasilan Ayah *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                        <div class="space-y-4">
                            <label class="font-bold text-pink-600">Data Ibu Kandung</label>
                            <input type="text" name="mother_name" placeholder="Nama Ibu *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                            <input type="text" name="mother_nik" placeholder="NIK Ibu *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                            <input type="text" name="mother_job" placeholder="Pekerjaan Ibu *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                            <input type="text" name="mother_income" placeholder="Penghasilan Ibu *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        </div>
                    </div>

                </section>
                <section>
                        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-indigo-600"></i> IV. KONTAK
                    </h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <input type="text" name="phone_number" placeholder="No. Handphone / WA *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                        <input type="email" name="email" placeholder="Email Aktif *" class="w-full border rounded-xl p-3 bg-gray-50" required>
                    </div>
                </section>
                
                <section>
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2 flex items-center">
                        <i class="fas fa-upload mr-2 text-indigo-600"></i> V. UNGGAH DOKUMEN
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div><label class="text-xs font-bold uppercase">Pas Foto *</label><input type="file" name="photo_path" required class="text-xs"></div>
                        <div><label class="text-xs font-bold uppercase">Kartu Keluarga *</label><input type="file" name="family_card_path" required class="text-xs"></div>
                        <div><label class="text-xs font-bold uppercase">Akta Lahir *</label><input type="file" name="birth_cert_path" required class="text-xs"></div>
                    </div>
                </section>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-5 rounded-2xl shadow-xl transition transform hover:scale-[1.01]">
                    KIRIM PENDAFTARAN SEKARANG
                </button>
            </form>
        </div>
    </div>
</body>
</html>