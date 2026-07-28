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
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ Route::has('admin.siswa.index') ? route('admin.siswa.index') : (Route::has('admin.siswa') ? route('admin.siswa') : '#') }}" 
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Data Siswa
                    </a>
                    <a href="{{ Route::has('admin.petugas.index') ? route('admin.petugas.index') : '#' }}" 
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
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

    <main class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto w-full flex-grow">

        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-200">
                        <i class="fa-solid fa-user-shield text-lg"></i>
                    </div>
                    Profil Admin
                </h1>
                <p class="text-slate-500 mt-1 text-sm font-medium">
                    Identitas akun serta kode otentikasi unik untuk akses login cepat.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                        <div class="relative shrink-0">
                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center font-extrabold text-3xl shadow-lg shadow-blue-200 border-2 border-white">
                                {{ strtoupper(substr($admin->nama ?? 'A', 0, 1)) }}
                            </div>
                            <span class="absolute -bottom-2 -right-2 bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm border border-white">
                                Aktif
                            </span>
                        </div>

                        <div class="text-center sm:text-left space-y-1">
                            <span class="text-[11px] font-extrabold tracking-wider text-blue-600 uppercase bg-blue-50 px-2.5 py-1 rounded-md border border-blue-100">
                                Super Administrator
                            </span>
                            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight pt-1">
                                {{ $admin->nama ?? 'Administrator' }}
                            </h3>
                            <p class="text-xs font-semibold text-slate-400">
                                Kode Login / Auth: <span class="text-slate-600 font-mono">{{ $admin->username ?? $admin->id_admin ?? 'ADM-001' }}</span>
                            </p>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="bg-blue-50/60 rounded-2xl p-4 border border-blue-100/80 flex items-start gap-3">
                        <i class="fa-solid fa-shield-halved text-blue-600 text-lg mt-0.5"></i>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">Hak Akses Utama</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                                Memiliki otoritas penuh atas pengelolaan master data siswa, petugas, presensi, serta pemantauan laporan sistem perpustakaan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 flex flex-col items-center justify-center p-6 bg-slate-50/60 rounded-2xl border border-slate-100/80 text-center space-y-5">
                    
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">
                            Barcode Login Admin
                        </span>
                        <p class="text-[11px] text-slate-400">
                            Pindai QR Code ini untuk melakukan autentikasi login cepat
                        </p>
                    </div>

                    <div class="p-4 bg-white border border-slate-200 rounded-2xl shadow-md inline-block transform hover:scale-105 transition duration-300">
                        @if(isset($qrCode))
                            {!! $qrCode !!}
                        @else
                            <div class="w-40 h-40 bg-slate-100 rounded-xl flex flex-col items-center justify-center text-slate-400 p-2">
                                <i class="fa-solid fa-qrcode text-5xl mb-2 text-slate-300"></i>
                                <span class="text-[10px] font-mono text-slate-500 break-all">
                                    {{ $admin->username ?? $admin->id_admin ?? 'ADM-001' }}
                                </span>
                            </div>
                        @endif
                    </div>

                    @if(Route::has('admin.profile.barcode.download'))
                        <a href="{{ route('admin.profile.barcode.download') }}" 
                           class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white px-5 py-3 rounded-xl text-xs font-bold shadow-md shadow-blue-200 transition duration-200">
                            <i class="fa-solid fa-download text-sm"></i> Unduh Barcode Login
                        </a>
                    @endif

                </div>

            </div>
        </div>

    </main>

    <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-8">
        <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
    </footer>

</body>
</html>