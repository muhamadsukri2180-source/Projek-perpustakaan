<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kunjungan - Perpustakaan Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .animated-gradient-light-blue {
            background: linear-gradient(-45deg, #0284c7, #38bdf8, #60a5fa, #3b82f6);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <nav class="animated-gradient-light-blue text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 text-white shadow-sm">
                        <i class="fa-solid fa-book-open text-lg"></i>
                    </div>
                    <span class="font-extrabold text-xl tracking-wide text-white drop-shadow-sm">
                        Perpustakaan
                    </span>
                </div>

                <div class="hidden md:flex items-center gap-2 font-medium text-sm">
                    <a href="{{ route('siswa.dashboard') }}"
                       class="px-4 py-2 rounded-xl text-white/90 hover:bg-white/10 hover:text-white transition">
                        <i class="fa-solid fa-house mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ Route::has('siswa.buku') ? route('siswa.buku') : '#' }}"
                       class="px-4 py-2 rounded-xl text-white/90 hover:bg-white/10 hover:text-white transition">
                        <i class="fa-solid fa-book mr-1.5 text-xs"></i> Buku Digital
                    </a>
                    <a href="{{ route('siswa.riwayat') }}"
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/30 backdrop-blur-md transition">
                        <i class="fa-solid fa-clock-rotate-left mr-1.5 text-xs"></i> Riwayat Kunjungan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight drop-shadow-sm">{{ $siswa->nama ?? $siswa->name ?? 'Siswa' }}</span>
                        <span class="text-[10px] text-sky-100 font-medium">Siswa Aktif</span>
                    </div>

                    <a href="{{ Route::has('siswa.profile') ? route('siswa.profile') : '#' }}" class="w-9 h-9 rounded-full bg-white text-sky-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/40 overflow-hidden">
                        @if($siswa->foto ?? false)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Profile" class="w-full h-full object-cover">
                        @else
                            <span>{{ strtoupper(substr($siswa->nama ?? $siswa->name ?? 'S', 0, 1)) }}</span>
                        @endif
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar" class="w-9 h-9 rounded-xl bg-red-500/20 hover:bg-red-500/40 text-white flex items-center justify-center text-sm border border-white/20 transition">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <main class="flex-grow p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-600 text-white flex items-center justify-center shadow-md shadow-sky-200">
                    <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                </div>
                Riwayat Kunjungan
            </h1>
            <p class="text-slate-500 mt-1 text-sm font-medium">Daftar lengkap presensi kunjungan Anda ke perpustakaan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-sky-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-sky-200 text-xl">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kunjungan</p>
                    <h3 class="text-xl font-extrabold text-slate-800">{{ number_format($totalKunjungan ?? 0) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 text-xl">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Bulan Ini</p>
                    <h3 class="text-xl font-extrabold text-slate-800">{{ number_format($totalBulanIni ?? 0) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 {{ ($sedangDiPerpus ?? false) ? 'bg-amber-500 shadow-amber-200' : 'bg-emerald-500 shadow-emerald-200' }} text-white rounded-2xl flex items-center justify-center shadow-lg text-xl">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Sekarang</p>
                    <h3 class="text-sm font-extrabold {{ ($sedangDiPerpus ?? false) ? 'text-amber-600' : 'text-emerald-600' }}">
                        {{ ($sedangDiPerpus ?? false) ? 'Di Dalam Ruangan' : 'Di Luar Ruangan' }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <form action="{{ route('siswa.riwayat') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6 border-b border-slate-100 pb-5">
                <div class="flex-1">
                    <label class="text-[11px] font-bold text-slate-400 uppercase mb-1 block">Filter Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div class="flex-1">
                    <label class="text-[11px] font-bold text-slate-400 uppercase mb-1 block">Filter Bulan</label>
                    <input type="month" name="bulan" value="{{ request('bulan') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-sky-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-sky-700 transition">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>
                    @if (request('tanggal') || request('bulan'))
                        <a href="{{ route('siswa.riwayat') }}" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold">
                        <tr>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Jam Masuk</th>
                            <th class="py-3 px-4">Jam Keluar</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($riwayatAbsensi as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-semibold text-slate-800">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}
                                </td>
                                <td class="py-3 px-4 text-sky-600 font-medium">
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
                                <td colspan="4" class="py-10 px-4 text-center text-slate-400 text-sm">
                                    <i class="fa-solid fa-inbox text-3xl mb-3 text-slate-300 block"></i>
                                    Tidak ada riwayat kunjungan yang cocok dengan filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($riwayatAbsensi instanceof \Illuminate\Contracts\Pagination\Paginator || $riwayatAbsensi instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-6">
                    {{ $riwayatAbsensi->links() }}
                </div>
            @endif
        </div>

    </main>

    <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-auto">
        <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
    </footer>

</body>
</html>