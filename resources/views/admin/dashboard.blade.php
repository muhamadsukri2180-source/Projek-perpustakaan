<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpustakaan Digital</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Animasi Latar Belakang Gradasi Navbar */
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
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/20 backdrop-blur-sm transition">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ Route::has('admin.siswa') ? route('admin.siswa') : '#' }}" 
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
                    <a href="{{ Route::has('admin.laporan') ? route('admin.laporan.harian') : '#' }}" 
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
                <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar" class="w-9 h-9 rounded-xl text-white flex items-center justify-center text-sm ">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>

            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col justify-between">
        
        <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">

            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-200">
                            <i class="fa-solid fa-book-open-reader text-lg"></i>
                        </div>
                        Dashboard Admin
                    </h1>
                    <p class="text-slate-500 mt-1 text-sm font-medium">
                        Selamat datang kembali di Sistem Presensi & Pengunjung Perpustakaan Digital.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl font-semibold text-xs flex items-center gap-2 shadow-sm">
                        <i class="fa-regular fa-calendar-check text-blue-600"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                    <a href="{{ Route::has('admin.barcode.generate') ? route('admin.barcode.generate') : '#' }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-md shadow-blue-200 transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-qrcode"></i> Generate Barcode
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                        <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalSiswa ?? 0) }}</h3>
                        <span class="text-[11px] text-blue-600 font-semibold bg-blue-50 px-2.5 py-0.5 rounded-md mt-2 inline-block">Terdaftar</span>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 text-xl">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pengunjung Hari Ini</p>
                        <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($pengunjungHariIni ?? 0) }}</h3>
                        <span class="text-[11px] text-emerald-600 font-semibold bg-emerald-50 px-2.5 py-0.5 rounded-md mt-2 inline-block">Masuk Hari Ini</span>
                    </div>
                    <div class="w-12 h-12 bg-teal-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-teal-200 text-xl">
                        <i class="fa-solid fa-person-walking-arrow-right"></i>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang di Perpus</p>
                        <h3 class="text-2xl font-extrabold text-amber-600 mt-1">{{ number_format($sedangDiPerpus ?? 0) }}</h3>
                        <span class="text-[11px] text-amber-600 font-semibold bg-amber-50 px-2.5 py-0.5 rounded-md mt-2 inline-block">Belum Absen Keluar</span>
                    </div>
                    <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 text-xl">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Petugas</p>
                        <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalPetugas ?? 0) }}</h3>
                        <span class="text-[11px] text-indigo-600 font-semibold bg-indigo-50 px-2.5 py-0.5 rounded-md mt-2 inline-block">Pengelola</span>
                    </div>
                    <div class="w-12 h-12 bg-indigo-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 text-xl">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Grafik Kunjungan Mingguan</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Statistik tren kedatangan siswa 7 hari terakhir</p>
                        </div>
                        <span class="text-xs bg-blue-50 border border-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-ping"></span> Real-time
                        </span>
                    </div>
                    <div class="h-64 relative">
                        <canvas id="visitorChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800 mb-1">Aksi Cepat</h2>
                        <p class="text-xs text-slate-400 mb-4">Navigasi pintas menu utama</p>
                        
                        <div class="space-y-3">
                            <a href="{{ Route::has('admin.siswa.create') ? route('admin.siswa.create') : '#' }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-200 transition group">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 group-hover:text-blue-700">Tambah Data Siswa</span>
                                </div>
                                <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-blue-600"></i>
                            </a>

                            <a href="{{ Route::has('admin.laporan.harian') ? route('admin.laporan.harian') : '#' }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-200 transition group">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm font-bold group-hover:bg-emerald-600 group-hover:text-white transition">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 group-hover:text-blue-700">Cetak Laporan Harian</span>
                                </div>
                                <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-blue-600"></i>
                            </a>

                            <a href="{{ Route::has('admin.statistik.pengunjung') ? route('admin.statistik.pengunjung') : '#' }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-200 transition group">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-sm font-bold group-hover:bg-amber-600 group-hover:text-white transition">
                                        <i class="fa-solid fa-chart-line"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 group-hover:text-blue-700">Detail Statistik</span>
                                </div>
                                <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-blue-600"></i>
                            </a>
                        </div>
                    </div>

                    <div class="mt-6 p-4 rounded-xl bg-gradient-to-r from-blue-600 to-sky-500 text-white shadow-md shadow-blue-100">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-info text-2xl opacity-90"></i>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider">Informasi System</h4>
                                <p class="text-[11px] opacity-90 leading-tight mt-0.5">Pastikan koneksi barcode scanner stabil sebelum jam istirahat sekolah.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Aktivitas Kunjungan Terbaru</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar presensi siswa yang baru saja melakukan tap barcode</p>
                    </div>
                    <a href="{{ Route::has('absensi.index') ? route('absensi.index') : '#' }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                        Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="py-3.5 px-6">Siswa</th>
                                <th class="py-3.5 px-6">Kelas & Jurusan</th>
                                <th class="py-3.5 px-6">Waktu Masuk</th>
                                <th class="py-3.5 px-6">Waktu Keluar</th>
                                <th class="py-3.5 px-6 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($absensiTerbaru ?? [] as $data)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                        {{ substr($data->siswa->nama ?? 'S', 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="leading-tight">{{ $data->siswa->nama ?? '-' }}</p>
                                        <span class="text-[11px] text-slate-400 font-normal">NISN: {{ $data->siswa->nisn ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-xs font-medium border border-slate-200/60">
                                        {{ $data->siswa->kelas->nama_kelas ?? '-' }} - {{ $data->siswa->jurusan->kode_jurusan ?? '' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-700">
                                    <i class="fa-regular fa-clock text-blue-500 mr-1.5"></i>
                                    {{ $data->waktu_masuk ? \Carbon\Carbon::parse($data->waktu_masuk)->format('H:i') : '-' }} WIB
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-700">
                                    @if($data->waktu_keluar)
                                        <i class="fa-regular fa-clock text-slate-400 mr-1.5"></i>
                                        {{ \Carbon\Carbon::parse($data->waktu_keluar)->format('H:i') }} WIB
                                    @else
                                        <span class="text-slate-400 font-normal italic">- Belum Keluar -</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($data->waktu_keluar)
                                        <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1 rounded-full text-xs font-semibold animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Di Dalam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                    <i class="fa-solid fa-inbox text-4xl mb-3 text-slate-300 block"></i>
                                    Belum ada aktivitas kunjungan hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-8">
            <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
        </footer>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('visitorChart').getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.35)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

            const chartDataFromController = @json($chartData ?? array_fill(0, 7, 0));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Jumlah Pengunjung',
                        data: chartDataFromController,
                        borderColor: '#2563eb',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { 
                                precision: 0,
                                color: '#94a3b8', 
                                font: { family: 'Plus Jakarta Sans' } 
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans' } }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>