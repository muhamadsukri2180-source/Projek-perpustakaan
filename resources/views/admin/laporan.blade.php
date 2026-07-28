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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased"
      x-data="{ activeTab: '{{ request()->routeIs('admin.laporan.mingguan') ? 'mingguan' : (request()->routeIs('admin.laporan.bulanan') ? 'bulanan' : (request()->routeIs('admin.laporan.tahunan') ? 'tahunan' : 'harian')) }}' }">

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
                        <span class="text-xs font-bold leading-tight">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>

                    <a href="{{ Route::has('admin.profile') ? route('admin.profile') : '#' }}"
                       title="Lihat Profil Admin"
                       class="w-9 h-9 rounded-full bg-white text-blue-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:ring-white hover:scale-105 active:scale-95 transition-all duration-200 group">
                        <span class="group-hover:text-blue-700">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">

        @if (session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
                <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
            </div>
        @endif

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

            {{-- ==================== TAB HARIAN ==================== --}}
            <div x-show="activeTab === 'harian'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form action="{{ route('admin.laporan.harian') }}" method="GET" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Kunjungan Harian</h2>
                        <p class="text-xs text-slate-400">
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                            &bull; Total: <span class="font-bold text-blue-600">{{ $totalHarian }} Kunjungan</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="date" name="tanggal" value="{{ $tanggal }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-blue-500">
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
                            @forelse ($laporanHarian as $index => $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-4 font-medium">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-semibold text-slate-800">
                                        {{ $item->siswa->nama ?? '-' }}<br>
                                        <span class="text-xs font-normal text-slate-400">{{ $item->siswa->nisn ?? '-' }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $item->siswa->kelas->nama_kelas ?? '-' }} / {{ $item->siswa->jurusan->nama_jurusan ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-blue-600 font-medium">
                                        {{ $item->waktu_masuk ? \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') . ' WIB' : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-emerald-600 font-medium">
                                        {{ $item->waktu_keluar ? \Carbon\Carbon::parse($item->waktu_keluar)->format('H:i') . ' WIB' : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if ($item->status === 'selesai')
                                            <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-bold">Selesai</span>
                                        @else
                                            <span class="bg-amber-50 text-amber-600 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-bold">Di Perpus</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 px-4 text-center text-slate-400 text-sm">
                                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                                        Tidak ada data kunjungan pada tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ==================== TAB MINGGUAN ==================== --}}
            <div x-show="activeTab === 'mingguan'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form action="{{ route('admin.laporan.mingguan') }}" method="GET" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Kunjungan Mingguan</h2>
                        <p class="text-xs text-slate-400">
                            {{ $awalMinggu->translatedFormat('d F Y') }} - {{ $akhirMinggu->translatedFormat('d F Y') }}
                            &bull; Total: <span class="font-bold text-blue-600">{{ $totalMingguan }} Kunjungan</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="week" name="minggu" value="{{ $awalMinggu->format('o-\WW') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-blue-500">
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
                            @forelse ($laporanMingguan as $row)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-4 font-semibold text-slate-800">{{ $row['hari'] }}</td>
                                    <td class="py-3 px-4">{{ $row['tanggal'] }}</td>
                                    <td class="py-3 px-4 text-center font-bold text-blue-600">{{ $row['total'] }} Siswa</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 px-4 text-center text-slate-400 text-sm">
                                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                                        Tidak ada data kunjungan pada minggu ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ==================== TAB BULANAN ==================== --}}
            <div x-show="activeTab === 'bulanan'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form action="{{ route('admin.laporan.bulanan') }}" method="GET" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Kunjungan Bulanan</h2>
                        <p class="text-xs text-slate-400">
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $bulanInput)->translatedFormat('F Y') }}
                            &bull; Total: <span class="font-bold text-blue-600">{{ $totalBulanan }} Kunjungan</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="month" name="bulan" value="{{ $bulanInput }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-blue-500">
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
                            @forelse ($laporanBulanan as $row)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-4 font-semibold text-slate-800">Minggu {{ $row['minggu_ke'] }}</td>
                                    <td class="py-3 px-4">{{ $row['rentang'] }}</td>
                                    <td class="py-3 px-4 text-center font-bold text-blue-600">{{ $row['total'] }} Siswa</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 px-4 text-center text-slate-400 text-sm">
                                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                                        Tidak ada data kunjungan pada bulan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ==================== TAB TAHUNAN ==================== --}}
            <div x-show="activeTab === 'tahunan'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form action="{{ route('admin.laporan.tahunan') }}" method="GET" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Kunjungan Tahunan</h2>
                        <p class="text-xs text-slate-400">
                            Tahun {{ $tahun }}
                            &bull; Total: <span class="font-bold text-blue-600">{{ $totalTahunan }} Kunjungan</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <select name="tahun" class="px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach ($tahunTersedia as $th)
                                <option value="{{ $th }}" {{ (string) $th === (string) $tahun ? 'selected' : '' }}>{{ $th }}</option>
                            @endforeach
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
                            @forelse ($laporanTahunan as $row)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-4 font-semibold text-slate-800">{{ $row['bulan'] }}</td>
                                    <td class="py-3 px-4 text-center font-bold text-blue-600">{{ $row['total'] }} Siswa</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-8 px-4 text-center text-slate-400 text-sm">
                                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                                        Tidak ada data kunjungan pada tahun ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>