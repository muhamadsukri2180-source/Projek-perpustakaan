<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi & Statistik - Perpustakaan Digital</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ activeTab: 'data-absensi', selectedSiswa: null, modalDetail: false }">

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
                    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ Route::has('admin.siswa') ? route('admin.siswa') : '#' }}" class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Data Siswa
                    </a>
                    <a href="{{ Route::has('admin.petugas.index') ? route('admin.petugas.index') : '#' }}" 
                        class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('admin.petugas*') ? 'bg-white/20 font-bold text-white' : '' }}">
                         <i class="fa-solid fa-user-tie mr-1.5 text-xs"></i> Kelola Petugas
                    </a>
                    <a href="{{ Route::has('admin.presensi') ? route('admin.presensi') : '#' }}" class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/20 backdrop-blur-sm transition">
                        <i class="fa-solid fa-clipboard-user mr-1.5 text-xs"></i> Presensi
                    </a>
                     <a href="{{ Route::has('admin.laporan') ? route('admin.laporan') : '#' }}" 
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

    <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">
        
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-200">
                        <i class="fa-solid fa-clipboard-user text-lg"></i>
                    </div>
                    Presensi & Analisis Statistik
                </h1>
                <p class="text-slate-500 mt-1 text-sm font-medium">Kelola data absensi harian, riwayat kunjungan, dan grafik data siswa.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-200/80 mb-6 overflow-x-auto flex gap-2">
            <button @click="activeTab = 'data-absensi'" :class="activeTab === 'data-absensi' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-list-check"></i> Data Absensi
            </button>
            <button @click="activeTab = 'riwayat-absensi'" :class="activeTab === 'riwayat-absensi' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Absensi
            </button>
            
            <div class="h-6 w-[1px] bg-slate-200 my-auto mx-1"></div>

            <button @click="activeTab = 'stat-pengunjung'" :class="activeTab === 'stat-pengunjung' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-chart-line"></i> Statistik Pengunjung
            </button>
            <button @click="activeTab = 'stat-kelas'" :class="activeTab === 'stat-kelas' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-school"></i> Statistik Per Kelas
            </button>
            <button @click="activeTab = 'stat-jurusan'" :class="activeTab === 'stat-jurusan' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-graduation-cap"></i> Statistik Per Jurusan
            </button>
        </div>

        <div class="space-y-6">

            <div x-show="activeTab === 'data-absensi'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Data Absensi Hari Ini</h2>
                        <p class="text-xs text-slate-400">Siswa yang melakukan tap barcode hari ini</p>
                    </div>
                    <input type="text" placeholder="Cari NISN / Nama..." class="px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 outline-none w-full sm:w-64">
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="py-3 px-4">Siswa</th>
                                <th class="py-3 px-4">Kelas / Jurusan</th>
                                <th class="py-3 px-4">Jam Masuk</th>
                                <th class="py-3 px-4">Jam Keluar</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-semibold text-slate-800">Ahmad Rizky<br><span class="text-xs font-normal text-slate-400">NISN: 005123456</span></td>
                                <td class="py-3 px-4">XII RPL 1</td>
                                <td class="py-3 px-4 text-blue-600 font-medium">07:30 WIB</td>
                                <td class="py-3 px-4 text-slate-400 italic">Belum Keluar</td>
                                <td class="py-3 px-4 text-center"><span class="bg-amber-50 text-amber-600 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-bold">Di Perpus</span></td>
                                <td class="py-3 px-4 text-center">
                                    <button @click="modalDetail = true; selectedSiswa = 'Ahmad Rizky'" class="px-3 py-1 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg text-xs font-semibold transition">
                                        <i class="fa-solid fa-eye mr-1"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="activeTab === 'riwayat-absensi'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Riwayat Keseluruhan Absensi</h2>
                        <p class="text-xs text-slate-400">Arsip data histori kedatangan siswa di perpustakaan</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="date" class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs outline-none">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-blue-700">Filter</button>
                    </div>
                </div>
                <div class="text-slate-400 text-xs text-center py-10 border-2 border-dashed border-slate-100 rounded-xl">
                    <i class="fa-solid fa-clock-rotate-left text-3xl mb-2 text-slate-300 block"></i>
                    Gunakan filter tanggal di atas untuk menampilkan riwayat pencatatan lama.
                </div>
            </div>

            <div x-show="activeTab === 'stat-pengunjung'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-1">Statistik Pengunjung Mingguan</h2>
                <p class="text-xs text-slate-400 mb-4">Grafik Tren Kedatangan Harian</p>
                <div class="h-72">
                    <canvas id="chartPengunjung"></canvas>
                </div>
            </div>

            <div x-show="activeTab === 'stat-kelas'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-1">Statistik Pengunjung Per Kelas</h2>
                <p class="text-xs text-slate-400 mb-4">Perbandingan keaktifan siswa berkunjung antar kelas</p>
                <div class="h-72">
                    <canvas id="chartKelas"></canvas>
                </div>
            </div>

            <div x-show="activeTab === 'stat-jurusan'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-1">Statistik Pengunjung Per Jurusan</h2>
                <p class="text-xs text-slate-400 mb-4">Persentase kunjungan perpustakaan berdasarkan kompetensi keahlian</p>
                <div class="h-72 max-w-md mx-auto">
                    <canvas id="chartJurusan"></canvas>
                </div>
            </div>

        </div>
    </main>

    <div x-show="modalDetail" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100" @click.away="modalDetail = false">
            <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                <h3 class="font-extrabold text-slate-800 text-base">Detail Absensi Siswa</h3>
                <button @click="modalDetail = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-1 border-b border-slate-50"><span class="text-slate-400">Nama Siswa:</span><span class="font-bold text-slate-700" x-text="selectedSiswa"></span></div>
                <div class="flex justify-between py-1 border-b border-slate-50"><span class="text-slate-400">NISN:</span><span class="font-bold text-slate-700">005123456</span></div>
                <div class="flex justify-between py-1 border-b border-slate-50"><span class="text-slate-400">Kelas / Jurusan:</span><span class="font-bold text-slate-700">XII RPL 1</span></div>
                <div class="flex justify-between py-1 border-b border-slate-50"><span class="text-slate-400">Waktu Tap Masuk:</span><span class="font-bold text-blue-600">07:30:12 WIB</span></div>
                <div class="flex justify-between py-1"><span class="text-slate-400">Waktu Tap Keluar:</span><span class="font-bold text-amber-600">- (Masih di lokasi)</span></div>
            </div>
            <button @click="modalDetail = false" class="w-full mt-6 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2 rounded-xl font-bold text-xs">Tutup</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Chart 1: Pengunjung
            new Chart(document.getElementById('chartPengunjung'), {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                    datasets: [{ label: 'Pengunjung', data: [32, 45, 60, 25, 50], borderColor: '#2563eb', tension: 0.3, fill: false }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Chart 2: Per Kelas
            new Chart(document.getElementById('chartKelas'), {
                type: 'bar',
                data: {
                    labels: ['Kelas X', 'Kelas XI', 'Kelas XII'],
                    datasets: [{ label: 'Total Siswa', data: [120, 95, 140], backgroundColor: '#3b82f6' }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Chart 3: Per Jurusan
            new Chart(document.getElementById('chartJurusan'), {
                type: 'doughnut',
                data: {
                    labels: ['RPL', 'TKJ', 'DMM', 'AKL'],
                    datasets: [{ data: [40, 25, 20, 15], backgroundColor: ['#2563eb', '#06b6d4', '#f59e0b', '#10b981'] }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
</body>
</html>