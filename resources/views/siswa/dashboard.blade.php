<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Perpustakaan Digital</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .animated-gradient-blue {
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

    <nav class="animated-gradient-blue text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 text-white shadow-inner">
                        <i class="fa-solid fa-book-open text-lg"></i>
                    </div>
                    <span class="font-extrabold text-xl tracking-wide text-white drop-shadow-sm">
                        Perpustakaan
                    </span>
                </div>

                <div class="hidden md:flex items-center gap-1 font-medium text-sm">
                    <a href="{{ route('siswa.dashboard') }}" 
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/20 backdrop-blur-sm transition">
                        <i class="fa-solid fa-house mr-1.5 text-xs"></i> Dashboard
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight">{{ auth()->user()->name ?? 'Siswa' }}</span>
                        <span class="text-[10px] text-blue-200">Siswa</span>
                    </div>

                    <div class="w-9 h-9 rounded-full bg-white text-blue-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30">
                        <span>{{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar" class="w-9 h-9 rounded-xl bg-red-500/20 hover:bg-red-500/40 text-white flex items-center justify-center text-sm transition">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col justify-between">
        
        <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">

            <div class="mb-8 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-blue-200/50 flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative overflow-hidden">
                <div class="relative z-10">
                    <span class="bg-white/20 text-blue-100 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-semibold border border-white/20 mb-3 inline-block">
                        <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Selamat Datang, {{ auth()->user()->name ?? 'Siswa' }}! 👋
                    </h1>
                    <p class="text-blue-100 mt-2 text-sm max-w-xl">
                        Tunjukkan Kartu / Barcode Anggota Anda kepada petugas perpustakaan saat masuk dan keluar ruangan.
                    </p>
                </div>

                <i class="fa-solid fa-book-bookmark text-white/10 text-9xl absolute -right-4 -bottom-6 pointer-events-none"></i>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between items-center text-center">
                    <div class="w-full border-b border-slate-100 pb-4 mb-4 flex justify-between items-center">
                        <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Kartu Anggota Digital</h2>
                        <span class="text-xs bg-emerald-50 text-emerald-600 font-bold px-2.5 py-0.5 rounded-full border border-emerald-100">Aktif</span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl w-full flex flex-col items-center justify-center my-2 shadow-inner">
                        <div class="w-36 h-36 bg-white p-2 rounded-xl shadow-sm border border-slate-200 flex items-center justify-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ auth()->user()->nisn ?? '12345678' }}" 
                                 alt="Barcode Siswa" class="w-full h-full object-contain">
                        </div>
                        <p class="mt-3 font-mono text-sm font-bold text-slate-700 tracking-widest">
                            {{ auth()->user()->nisn ?? 'NISN: 123456789' }}
                        </p>
                    </div>

                    <p class="text-xs text-slate-400 mt-2">
                        Tunjukkan kode QR ini ke alat pindaian (scanner) atau petugas perpustakaan.
                    </p>
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kunjungan Saya</p>
                            <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ number_format($totalKunjungan ?? 0) }}</h3>
                            <span class="text-xs text-blue-600 font-semibold bg-blue-50 px-2.5 py-1 rounded-md mt-3 inline-block">Kali Berkunjung</span>
                        </div>
                        <div class="w-14 h-14 bg-blue-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 text-2xl">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Kunjungan Hari Ini</p>
                            @if(isset($statusHariIni) && $statusHariIni == 'di_dalam')
                                <h3 class="text-xl font-extrabold text-amber-500 mt-2">Sedang Di Perpus</h3>
                                <span class="text-xs text-amber-600 font-semibold bg-amber-50 px-2.5 py-1 rounded-md mt-3 inline-block">Jangan Lupa Scan Keluar</span>
                            @elseif(isset($statusHariIni) && $statusHariIni == 'selesai')
                                <h3 class="text-xl font-extrabold text-emerald-600 mt-2">Sudah Keluar</h3>
                                <span class="text-xs text-emerald-600 font-semibold bg-emerald-50 px-2.5 py-1 rounded-md mt-3 inline-block">Kunjungan Selesai</span>
                            @else
                                <h3 class="text-xl font-extrabold text-slate-400 mt-2">Belum Berkunjung</h3>
                                <span class="text-xs text-slate-500 font-semibold bg-slate-100 px-2.5 py-1 rounded-md mt-3 inline-block">Hari Ini</span>
                            @endif
                        </div>
                        <div class="w-14 h-14 bg-indigo-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 text-2xl">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                    </div>

                    <div class="sm:col-span-2 bg-gradient-to-r from-slate-800 to-slate-900 text-white rounded-2xl p-6 shadow-md flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-amber-400 text-xl flex-shrink-0 mt-1">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-white">Tips Berkunjung ke Perpustakaan</h4>
                            <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                                Jaga ketenangan selama berada di ruang perpustakaan, kembalikan buku ke tempat semula setelah dibaca, dan pastikan melakukan presensi saat keluar.
                            </p>
                        </div>
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