<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - Perpustakaan Digital</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

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
<body class="bg-slate-50 text-slate-800 antialiased">

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
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ Route::has('admin.siswa.index') ? route('admin.siswa.index') : (Route::has('admin.siswa') ? route('admin.siswa') : '#') }}" 
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Data Siswa
                    </a>
                    <a href="{{ Route::has('admin.petugas.index') ? route('admin.petugas.index') : '#' }}" 
                        class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('admin.petugas*') ? 'bg-white/20 font-bold text-white' : '' }}">
                         <i class="fa-solid fa-user-tie mr-1.5 text-xs"></i> Kelola Petugas
                    </a>
                    <a href="{{ Route::has('admin.presensi') ? route('admin.presensi') : '#' }}" 
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-clipboard-user mr-1.5 text-xs"></i> Presensi
                    </a>
                    <a href="{{ Route::has('admin.laporan') ? route('admin.laporan') : (Route::has('admin.laporan.index') ? route('admin.laporan.index') : '#') }}" 
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-file-lines mr-1.5 text-xs"></i> Laporan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight">{{ $admin->nama ?? 'Admin' }}</span>
                    </div>
                    <a href="{{ Route::has('admin.profile') ? route('admin.profile') : '#' }}" 
                       class="w-9 h-9 rounded-full bg-white text-blue-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:scale-105 transition">
                        {{ substr($admin->nama ?? 'A', 0, 1) }}
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col justify-between">
        
        <main class="p-4 sm:p-6 lg:p-8 max-w-5xl mx-auto w-full">

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-8 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col sm:flex-row items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-extrabold text-2xl flex items-center justify-center shadow-lg shadow-blue-200 shrink-0">
                    {{ substr($admin->nama ?? 'A', 0, 1) }}
                </div>
                <div class="text-center sm:text-left flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                            {{ $admin->nama ?? 'Administrator' }}
                        </h1>
                        <span class="self-center sm:self-auto px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[11px] font-bold border border-blue-200">
                            Super Admin
                        </span>
                    </div>
                    <p class="text-slate-500 mt-1 text-xs font-medium">
                        {{ $admin->email ?? 'admin@perpustakaan.sch.id' }}
                    </p>
                    <p class="text-slate-400 mt-0.5 text-[11px]">
                        Terdaftar sejak {{ isset($admin->created_at) ? $admin->created_at->format('d M Y') : 'Januari 2026' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1 space-y-4">
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 px-2">
                            Menu Pengaturan
                        </h3>
                        <div class="space-y-1">
                            <a href="#informasi-akun" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                                <i class="fa-solid fa-user-gear text-sm"></i> Detail Profil
                            </a>
                            <a href="#keamanan" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                                <i class="fa-solid fa-key text-sm"></i> Keamanan & Password
                            </a>
                        </div>
                    </div>

                    <div class="bg-blue-600 rounded-2xl p-5 text-white shadow-md shadow-blue-200">
                        <i class="fa-solid fa-shield-halved text-2xl text-blue-200 mb-2"></i>
                        <h4 class="text-sm font-bold">Akses Administrator</h4>
                        <p class="text-[11px] text-blue-100 mt-1 leading-relaxed">
                            Sebagai admin, Anda memiliki hak akses penuh untuk mengelola master data siswa, kelas, presensi, serta laporan kunjungan.
                        </p>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">

                    <div id="informasi-akun" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h2 class="text-base font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                            <i class="fa-solid fa-user-pen text-blue-600"></i> Informasi Profil
                        </h2>

                        <form action="{{ Route::has('admin.profile.update') ? route('admin.profile.update') : '#' }}" method="POST" class="mt-4 space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $admin->nama ?? 'Admin Perpus') }}" required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $admin->email ?? 'admin@perpustakaan.sch.id') }}" required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="telepon" value="{{ old('telepon', $admin->telepon ?? '081234567890') }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            </div>

                            <div class="pt-2 text-right">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-blue-200 transition">
                                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="keamanan" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h2 class="text-base font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                            <i class="fa-solid fa-lock text-amber-500"></i> Ubah Kata Sandi
                        </h2>

                        <form action="{{ Route::has('admin.profile.password') ? route('admin.profile.password') : '#' }}" method="POST" class="mt-4 space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Password Saat Ini</label>
                                <input type="password" name="current_password" required placeholder="••••••••"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Password Baru</label>
                                <input type="password" name="password" required placeholder="Minimal 8 karakter"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" required placeholder="Ulangi password baru"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            </div>

                            <div class="pt-2 text-right">
                                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-amber-200 transition">
                                    <i class="fa-solid fa-shield-cat mr-1"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-8">
            <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
        </footer>

    </div>

</body>
</html>