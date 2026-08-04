<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa - Panel Admin Perpustakaan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Animasi Latar Belakang Gradasi Navbar Admin */
        .animated-gradient {
            background: linear-gradient(-45deg, #1e3a8a, #2563eb, #3b82f6, #0284c7);
            background-size: 400% 400%;
            animation: gradientMove 8s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

        <nav class="animated-gradient text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 text-white shadow-inner">
                    <i class="fa-solid fa-book-bookmark text-lg"></i>
                </div>
                <span class="font-extrabold text-xl tracking-wide text-white drop-shadow-sm">
                    Perpustakaan
                </span>
            </div>

            <div class="hidden md:flex items-center gap-1 font-medium text-sm">
                <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" 
                   class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.dashboard*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <i class="fa-solid fa-chart-pie text-xs"></i> Dashboard
                </a>

                <a href="{{ Route::has('admin.siswa.index') ? route('admin.siswa.index') : (Route::has('admin.siswa') ? route('admin.siswa') : '#') }}" 
                   class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.siswa*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <i class="fa-solid fa-users text-xs"></i> Data Siswa
                </a>
                
                 <a href="{{ Route::has('admin.buku') ? route('admin.buku') : (Route::has('admin.buku') ? route('admin.buku') : '#') }}" 
                   class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.buku*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <i class="fa-solid fa-book-open text-xs"></i> Buku Digital
                </a>

                <a href="{{ Route::has('admin.petugas.index') ? route('admin.petugas.index') : '#' }}" 
                   class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.petugas*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <i class="fa-solid fa-user-tie text-xs"></i> Kelola Petugas
                </a>

                <a href="{{ Route::has('admin.presensi') ? route('admin.presensi') : '#' }}" 
                   class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.presensi*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <i class="fa-solid fa-clipboard-user text-xs"></i> Presensi
                </a>

                <a href="{{ Route::has('admin.laporan.harian') ? route('admin.laporan.harian') : (Route::has('admin.laporan') ? route('admin.laporan') : '#') }}" 
                   class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.laporan*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <i class="fa-solid fa-file-lines text-xs"></i> Laporan
                </a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-xs font-bold leading-tight">Admin</span>
                    <span class="text-[10px] text-blue-200">Administrator</span>
                </div>

                <a href="{{ Route::has('admin.profile') ? route('admin.profile') : '#' }}" 
                   title="Lihat Profil Admin" 
                   class="w-9 h-9 rounded-full bg-white text-blue-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:ring-white hover:scale-105 active:scale-95 transition-all duration-200 group">
                    <span class="group-hover:text-blue-700">A</span>
                </a>

                <div class="h-5 w-[1px] bg-white/20 hidden sm:block"></div>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" title="Keluar" class="w-9 h-9 rounded-xl text-white/80 hover:text-white hover:bg-white/10 flex items-center justify-center text-sm transition">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>

    <main class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto w-full flex-grow">

        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-200">
                        <i class="fa-solid fa-user-pen text-lg"></i>
                    </div>
                    Edit Data Siswa
                </h1>
                <p class="text-slate-500 mt-1 text-sm font-medium">
                    Panel Admin untuk memperbarui profil dan identitas siswa secara lengkap.
                </p>
            </div>

            <div>
                <a href="{{ Route::has('admin.siswa.index') ? route('admin.siswa.index') : (Route::has('admin.siswa') ? route('admin.siswa') : '#') }}" 
                   class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2.5 rounded-xl text-xs font-semibold shadow-sm transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Siswa
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium space-y-1 shadow-sm">
                <div class="flex items-center gap-2 font-bold text-rose-800 mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                    <span>Terdapat kesalahan pada isian form:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
            <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-100 space-y-4">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Foto Profil Siswa
                    </label>

                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <div class="shrink-0 relative">
                            <img id="foto-preview" 
                                 src="{{ $siswa->foto && Storage::disk('public')->exists($siswa->foto) ? asset('storage/' . $siswa->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&background=2563eb&color=fff&size=128' }}" 
                                 alt="Foto Profil Siswa" 
                                 class="w-24 h-24 object-cover rounded-2xl border-2 border-slate-200 shadow-sm">
                        </div>

                        <div class="space-y-2 text-center sm:text-left flex-grow">
                            <input type="file" name="foto" id="foto" accept="image/*" class="hidden" onchange="previewImage(event)">
                            
                            <label for="foto" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold cursor-pointer shadow-sm transition duration-200">
                                <i class="fa-solid fa-upload text-blue-600"></i> Unggah Foto Baru
                            </label>

                            <p class="text-[11px] text-slate-400 font-medium">
                                Format yang diizinkan: JPG, JPEG, PNG, WEBP. Maksimal ukuran file 2MB.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <div>
                        <label for="nisn" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            NISN <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}" required
                               class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl p-3.5 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition font-mono"
                               placeholder="Masukkan NISN">
                    </div>

                    <div>
                        <label for="nis" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            NIS <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" required
                               class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl p-3.5 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition font-mono"
                               placeholder="Masukkan NIS">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama) }}" required
                               class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl p-3.5 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition"
                               placeholder="Masukkan Nama Lengkap Siswa">
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kelas <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="kelas_id" id="kelas_id" required
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl p-3.5 pr-10 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition cursor-pointer appearance-none">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="jurusan_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Jurusan <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="jurusan_id" id="jurusan_id" required
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl p-3.5 pr-10 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition cursor-pointer appearance-none">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusanList as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $siswa->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Jenis Kelamin <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center gap-6 pt-1">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-sm font-semibold text-slate-700">
                                <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-slate-300">
                                <i class="fa-solid fa-mars text-blue-600"></i> Laki-laki
                            </label>

                            <label class="inline-flex items-center gap-2 cursor-pointer text-sm font-semibold text-slate-700">
                                <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'checked' : '' }}
                                       class="w-4 h-4 text-pink-600 focus:ring-pink-500 border-slate-300">
                                <i class="fa-solid fa-venus text-pink-500"></i> Perempuan
                            </label>
                        </div>
                    </div>

                </div>

                <hr class="border-slate-100 my-2">

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.siswa.index') }}" 
                       class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white px-6 py-3 rounded-xl text-xs font-bold shadow-md shadow-blue-200 transition duration-200">
                        <i class="fa-solid fa-floppy-disk text-sm"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </main>

    <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-8">
        <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital - Panel Admin. All rights reserved.</p>
    </footer>

    <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('foto-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>
</html>