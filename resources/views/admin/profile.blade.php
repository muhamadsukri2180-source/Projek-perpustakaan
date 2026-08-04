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
<body class="bg-slate-50/50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

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

    <main class="p-4 sm:p-6 lg:p-8 max-w-5xl mx-auto w-full flex-grow">

        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-200">
                        <i class="fa-solid fa-user-shield text-lg"></i>
                    </div>
                    Profil Akun Administrator
                </h1>
                <p class="text-slate-500 mt-1 text-sm font-medium">
                    Kelola otentikasi identitas akun dan QR Code akses login cepat.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 overflow-hidden relative">
            
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                
                <div class="lg:col-span-7 space-y-6">
                    
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                        <div class="relative shrink-0">
                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white flex items-center justify-center font-extrabold text-3xl shadow-xl shadow-blue-200 border-2 border-white">
                                {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="absolute -bottom-2 -right-2 bg-emerald-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-sm border-2 border-white flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Aktif
                            </span>
                        </div>

                        <div class="text-center sm:text-left space-y-2">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-extrabold tracking-wider text-blue-600 uppercase bg-blue-50 px-3 py-1 rounded-lg border border-blue-100">
                                <i class="fa-solid fa-crown text-amber-500 text-xs"></i> Super Administrator
                            </span>
                            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">
                                {{ $admin->name ?? 'Administrator Perpustakaan' }}
                            </h3>
                            <div class="space-y-1 pt-1">
                                <p class="text-xs font-medium text-slate-500 flex items-center justify-center sm:justify-start gap-2">
                                    <i class="fa-solid fa-envelope text-slate-400 w-4"></i>
                                    <span class="text-slate-700 font-semibold">{{ $admin->email ?? 'admin@perpus.sch.id' }}</span>
                                </p>
                                <p class="text-xs font-medium text-slate-500 flex items-center justify-center sm:justify-start gap-2">
                                    <i class="fa-solid fa-key text-slate-400 w-4"></i>
                                    Kode Auth: <span class="text-slate-800 font-mono font-bold bg-slate-100 px-2 py-0.5 rounded text-[11px]">{{ $admin->barcode_code ?? 'ADM-001' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="bg-gradient-to-br from-slate-50 to-blue-50/30 rounded-2xl p-4 border border-slate-100 flex items-start gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved text-base"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">Otoritas & Hak Akses Utama</h4>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Memiliki otoritas penuh atas pengelolaan master data siswa, petugas, presensi, serta pemantauan laporan sistem perpustakaan digital secara menyeluruh.
                            </p>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-5 flex flex-col items-center justify-center p-6 bg-slate-50/80 rounded-2xl border border-slate-200/60 text-center space-y-5">
                    
                    <div class="space-y-1">
                        <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider block">
                            QR Code Auth Login
                        </span>
                        <p class="text-[11px] text-slate-400">
                            Gunakan scanner untuk melakukan presensi/otentikasi login cepat
                        </p>
                    </div>

                    <div class="p-4 bg-white border border-slate-200 rounded-2xl shadow-md inline-block transform hover:scale-105 transition duration-300">
                        @if(isset($qrCode))
                            {!! $qrCode !!}
                        @else
                            <div class="w-40 h-40 bg-slate-50 rounded-xl flex flex-col items-center justify-center text-slate-400 p-2 border border-dashed border-slate-200">
                                <i class="fa-solid fa-qrcode text-6xl mb-2 text-slate-300"></i>
                                <span class="text-[10px] font-mono text-slate-600 font-bold bg-slate-200/60 px-2 py-0.5 rounded">
                                    {{ $admin->barcode_code ?? 'ADM-001' }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="w-full pt-1">
                        @if(Route::has('admin.profile.barcode.download'))
                            <a href="{{ route('admin.profile.barcode.download') }}" 
                               class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-lg shadow-emerald-200 hover:shadow-emerald-300 hover:-translate-y-0.5 transition-all duration-200">
                                <i class="fa-solid fa-download text-sm"></i>
                                Unduh QR Code / Barcode
                            </a>
                        @else
                            <a href="#" 
                               onclick="alert('Fitur download sedang disiapkan!'); return false;"
                               class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-lg shadow-emerald-200 hover:shadow-emerald-300 hover:-translate-y-0.5 transition-all duration-200">
                                <i class="fa-solid fa-download text-sm"></i>
                                Unduh QR Code / Barcode
                            </a>
                        @endif
                    </div>

                </div>

            </div>
        </div>

    </main>

    <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-8">
        <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
    </footer>

</body>
</html>