<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Petugas - Perpustakaan Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

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
                    <a href="{{ Route::has('admin.siswa') ? route('admin.siswa') : '#' }}"
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Data Siswa
                    </a>
                    <a href="{{ Route::has('admin.petugas.index') ? route('admin.petugas.index') : '#' }}"
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/20 backdrop-blur-sm transition">
                         <i class="fa-solid fa-user-tie mr-1.5 text-xs"></i> Kelola Petugas
                    </a>
                    <a href="{{ Route::has('admin.presensi') ? route('admin.presensi') : '#' }}"
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-clipboard-user mr-1.5 text-xs"></i> Presensi
                    </a>
                    <a href="{{ Route::has('admin.laporan.harian') ? route('admin.laporan.harian') : '#' }}"
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-file-lines mr-1.5 text-xs"></i> Laporan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight">Admin</span>
                    </div>

                    <a href="{{ Route::has('admin.profile') ? route('admin.profile') : '#' }}"
                       title="Lihat Profil Admin"
                       class="w-9 h-9 rounded-full bg-white text-blue-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:ring-white hover:scale-105 active:scale-95 transition-all duration-200 group">
                        <span class="group-hover:text-blue-700">A</span>
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col justify-between">

        <main class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto w-full">

            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-200">
                            <i class="fa-solid fa-qrcode text-lg"></i>
                        </div>
                        Barcode Petugas
                    </h1>
                    <p class="text-slate-500 mt-1 text-sm font-medium">
                        Kode QR unik petugas untuk masuk ke halaman presensi perpustakaan.
                    </p>
                </div>

                <div>
                    <a href="{{ route('admin.petugas.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Kelola Petugas
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-6">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-user-check text-blue-600"></i>
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Pilih Data Petugas</h2>
                </div>

                <form action="{{ route('admin.petugas.barcode.generate') }}" method="GET">
                    <div class="relative">
                        <select name="id" id="id" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm font-medium rounded-xl p-3.5 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition cursor-pointer appearance-none" onchange="this.form.submit()">
                            <option value="">-- Pilih Nama atau NIK Petugas --</option>
                            @foreach($petugasList as $p)
                                <option value="{{ $p->id }}" {{ request('id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} (NIK: {{ $p->nik }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </form>
            </div>

            @if($petugasSelected && $qrCode)
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-100 text-center space-y-6">

                    <div class="space-y-3">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-base mx-auto shadow-sm">
                            {{ substr($petugasSelected->nama, 0, 2) }}
                        </div>

                        <div>
                            <h3 class="text-xl font-extrabold text-slate-800">{{ $petugasSelected->nama }}</h3>
                            <p class="text-xs text-slate-400 font-semibold mt-0.5">NIK: {{ $petugasSelected->nik }}</p>
                        </div>

                        <div class="flex items-center justify-center gap-2 pt-1">
                            <span class="text-[11px] text-blue-600 font-semibold bg-blue-50 border border-blue-100 px-3 py-1 rounded-lg">
                                <i class="fa-solid fa-user-tie mr-1"></i> Petugas Perpustakaan
                            </span>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="p-4 bg-white border border-slate-200 rounded-2xl shadow-md inline-block">
                            {!! $qrCode !!}
                        </div>
                        <span class="text-[11px] font-medium text-slate-400">
                            Arahkan kode QR ini ke pemindai kamera untuk masuk ke halaman petugas
                        </span>
                    </div>

                    <div class="pt-2 flex items-center justify-center gap-3">
                        <a href="{{ route('admin.petugas.barcode.download', $petugasSelected->id) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-xs font-semibold shadow-md shadow-blue-200 transition duration-200">
                            <i class="fa-solid fa-download"></i> Unduh Barcode (SVG)
                        </a>
                        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-6 py-2.5 rounded-xl text-xs font-semibold shadow-sm transition duration-200">
                            <i class="fa-solid fa-print"></i> Cetak
                        </button>
                    </div>

                </div>
            @endif

        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-8">
            <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
        </footer>

    </div>

</body>
</html>