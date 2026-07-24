<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kunjungan - Perpustakaan Digital</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ activeTab: 'harian' }">

    <nav class="animated-gradient text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 text-white shadow-inner">
                        <i class="fa-solid fa-book-bookmark text-lg"></i>
                    </div>
                    <span class="font-extrabold text-xl tracking-wide text-white">Perpustakaan</span>
                </div>

                <div class="hidden md:flex items-center gap-1 font-medium text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.siswa') }}" class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Data Siswa
                    </a>
                    <a href="{{ Route::has('admin.petugas.index') ? route('admin.petugas.index') : '#' }}" 
                        class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('admin.petugas*') ? 'bg-white/20 font-bold text-white' : '' }}">
                         <i class="fa-solid fa-user-tie mr-1.5 text-xs"></i> Kelola Petugas
                    </a>
                    <a href="{{ route('admin.presensi') }}" class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-clipboard-user mr-1.5 text-xs"></i> Presensi
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/20 backdrop-blur-sm transition">
                        <i class="fa-solid fa-file-invoice mr-1.5 text-xs"></i> Laporan
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

    <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">
        
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-200">
                        <i class="fa-solid fa-file-lines text-lg"></i>
                    </div>
                    Laporan Kunjungan
                </h1>
                <p class="text-slate-500 mt-1 text-sm font-medium">Rekapitulasi dan laporan riwayat presensi pengunjung perpustakaan.</p>
            </div>

            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-print"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-200/80 mb-6 flex overflow-x-auto gap-2">
            <button @click="activeTab = 'harian'" :class="activeTab === 'harian' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-calendar-day"></i> Laporan Harian
            </button>
            <button @click="activeTab = 'mingguan'" :class="activeTab === 'mingguan' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-calendar-week"></i> Laporan Mingguan
            </button>
            <button @click="activeTab = 'bulanan'" :class="activeTab === 'bulanan' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-calendar-days"></i> Laporan Bulanan
            </button>
            <button @click="activeTab = 'tahunan'" :class="activeTab === 'tahunan' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-calendar"></i> Laporan Tahunan
            </button>
        </div>

        <div class="space-y-6">

            <div x-show="activeTab === 'harian'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form action="{{ route('admin.laporan.harian') }}" method="GET" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Kunjungan Harian</h2>
                        <p class="text-xs text-slate-400">Pilih tanggal untuk melihat data presensi harian</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-blue-700">Filter</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Siswa</th>
                                <th class="py-3 px-4">Kelas & Jurusan</th>
                                <th class="py-3 px-4">Jam Masuk</th>
                                <th class="py-3 px-4">Jam Keluar</th>
                                <th class="py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-medium">1</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Ahmad Rizky<br><span class="text-xs font-normal text-slate-400">005123456</span></td>
                                <td class="py-3 px-4">XII RPL 1</td>
                                <td class="py-3 px-4 text-blue-600 font-medium">07:30 WIB</td>
                                <td class="py-3 px-4 text-emerald-600 font-medium">08:15 WIB</td>
                                <td class="py-3 px-4 text-center"><span class="bg-emerald-50 text-emerald-600 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-bold">Selesai</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="activeTab === 'mingguan'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form action="{{ route('admin.laporan.mingguan') }}" method="GET" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Kunjungan Mingguan</h2>
                        <p class="text-xs text-slate-400">Pilih rentang minggu untuk rekapitulasi data</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="week" name="minggu" class="px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-blue-700">Filter</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="py-3 px-4">Hari</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4 text-center">Total Pengunjung</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-semibold text-slate-800">Senin</td>
                                <td class="py-3 px-4">20 Juli 2026</td>
                                <td class="py-3 px-4 text-center font-bold text-blue-600">45 Siswa</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-semibold text-slate-800">Selasa</td>
                                <td class="py-3 px-4">21 Juli 2026</td>
                                <td class="py-3 px-4 text-center font-bold text-blue-600">52 Siswa</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="activeTab === 'bulanan'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form action="{{ route('admin.laporan.bulanan') }}" method="GET" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Kunjungan Bulanan</h2>
                        <p class="text-xs text-slate-400">Pilih bulan dan tahun laporan</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="month" name="bulan" value="{{ date('Y-m') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-blue-700">Filter</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="py-3 px-4">Minggu Ke-</th>
                                <th class="py-3 px-4">Rentang Tanggal</th>
                                <th class="py-3 px-4 text-center">Total Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-semibold text-slate-800">Minggu 1</td>
                                <td class="py-3 px-4">01 - 07 Juli 2026</td>
                                <td class="py-3 px-4 text-center font-bold text-blue-600">210 Siswa</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="activeTab === 'tahunan'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form action="{{ route('admin.laporan.tahunan') }}" method="GET" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Kunjungan Tahunan</h2>
                        <p class="text-xs text-slate-400">Pilih tahun rekapitulasi data</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <select name="tahun" class="px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-blue-700">Filter</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="py-3 px-4">Bulan</th>
                                <th class="py-3 px-4 text-center">Total Kunjungan Siswa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-semibold text-slate-800">Januari</td>
                                <td class="py-3 px-4 text-center font-bold text-blue-600">850 Siswa</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-semibold text-slate-800">Februari</td>
                                <td class="py-3 px-4 text-center font-bold text-blue-600">920 Siswa</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>