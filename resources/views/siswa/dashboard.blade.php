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
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/30 backdrop-blur-md transition">
                        <i class="fa-solid fa-house mr-1.5 text-xs"></i> Dashboard
                    </a>

                    <a href="{{ Route::has('siswa.riwayat') ? route('siswa.riwayat') : '#' }}"
                       class="px-4 py-2 rounded-xl text-white/90 hover:bg-white/10 hover:text-white transition">
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

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
                <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
            </div>
        @endif

        <div class="mb-8 bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-sky-200/50 flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative overflow-hidden">
            <div class="relative z-10">
                <span class="bg-white/20 text-sky-100 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-semibold border border-white/20 mb-3 inline-block">
                    <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat Datang, {{ $siswa->nama ?? $siswa->name ?? 'Siswa' }}! 👋
                </h1>
                <p class="text-sky-100 mt-2 text-sm max-w-xl leading-relaxed">
                    Tunjukkan Kartu Digital atau pindai Barcode/QR Code Anda kepada petugas perpustakaan saat melakukan presensi masuk dan keluar.
                </p>
            </div>

            <i class="fa-solid fa-id-card text-white/10 text-9xl absolute -right-4 -bottom-8 pointer-events-none"></i>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between items-center text-center">
                <div class="w-full border-b border-slate-100 pb-4 mb-4 flex justify-between items-center">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kartu Anggota Digital</h2>
                    <span class="text-xs bg-emerald-50 text-emerald-600 font-bold px-2.5 py-0.5 rounded-full border border-emerald-100 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                    </span>
                </div>

                <div class="relative mb-3">
                    <div class="w-24 h-24 rounded-2xl bg-sky-50 border-2 border-sky-100 p-1 shadow-sm overflow-hidden flex items-center justify-center">
                        @if($siswa->foto ?? false)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="w-full h-full object-cover rounded-xl">
                        @else
                            <div class="w-full h-full bg-sky-500 text-white font-extrabold text-3xl flex items-center justify-center rounded-xl">
                                {{ strtoupper(substr($siswa->nama ?? $siswa->name ?? 'S', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-bold text-slate-800 text-base">{{ $siswa->nama ?? $siswa->name ?? 'Nama Siswa' }}</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        {{ $siswa->kelas->nama_kelas ?? '-' }} &bull; {{ $siswa->jurusan->nama_jurusan ?? '-' }}
                    </p>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl w-full flex flex-col items-center justify-center my-2 shadow-inner">
                    <div class="w-36 h-36 bg-white p-2 rounded-xl shadow-sm border border-slate-200 flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $siswa->nisn ?? '12345678' }}"
                             alt="QR Code NISN" class="w-full h-full object-contain">
                    </div>
                    <p class="mt-3 font-mono text-xs font-bold text-slate-700 tracking-wider bg-white px-3 py-1 rounded-lg border border-slate-200">
                        NISN: {{ $siswa->nisn ?? '-' }}
                    </p>
                </div>

                <p class="text-[11px] text-slate-400 mt-2">
                    Arahkan QR Code ke mesin pemindai perpustakaan untuk mencatat kehadiran.
                </p>
            </div>

            <div class="lg:col-span-2 space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kunjungan</p>
                            <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ number_format($totalKunjungan ?? 0) }}</h3>
                            <span class="text-xs text-sky-600 font-semibold bg-sky-50 px-2.5 py-1 rounded-md mt-3 inline-block">Kali Berkunjung</span>
                        </div>
                        <div class="w-14 h-14 bg-sky-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-sky-200 text-2xl">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Hari Ini</p>
                            @if(($statusHariIni ?? null) === 'di_perpus')
                                <h3 class="text-lg font-extrabold text-amber-500 mt-2">Di Dalam Ruangan</h3>
                            @elseif(($statusHariIni ?? null) === 'selesai')
                                <h3 class="text-lg font-extrabold text-emerald-600 mt-2">Sudah Keluar</h3>
                                <span class="text-xs text-emerald-600 font-semibold bg-emerald-50 px-2.5 py-1 rounded-md mt-3 inline-block">Kunjungan Selesai</span>
                            @else
                                <h3 class="text-lg font-extrabold text-slate-400 mt-2">Belum Berkunjung</h3>
                                <span class="text-xs text-slate-500 font-semibold bg-slate-100 px-2.5 py-1 rounded-md mt-3 inline-block">Hari Ini</span>
                            @endif
                        </div>
                        <div class="w-14 h-14 bg-indigo-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 text-2xl">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                    </div>

                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                        <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left text-sky-500"></i> Kunjungan Terakhir Anda
                        </h4>
                        <a href="{{ Route::has('siswa.riwayat') ? route('siswa.riwayat') : '#' }}" class="text-xs text-sky-600 font-bold hover:underline">Lihat Semua</a>
                    </div>

                    <div class="space-y-3">
                        @forelse (($riwayatTerakhir ?? []) as $riwayat)
                            <div class="p-3 bg-slate-50 rounded-xl flex items-center justify-between border border-slate-100 text-xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($riwayat->tanggal)->translatedFormat('l, d F Y') }}</p>
                                        <p class="text-slate-400 text-[10px]">
                                            Masuk: {{ $riwayat->waktu_masuk ? \Carbon\Carbon::parse($riwayat->waktu_masuk)->format('H:i') : '-' }} WIB
                                        </p>
                                    </div>
                                </div>
                                @if ($riwayat->waktu_keluar)
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-md font-semibold text-[10px]">
                                        Keluar: {{ \Carbon\Carbon::parse($riwayat->waktu_keluar)->format('H:i') }} WIB
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-600 rounded-md font-semibold text-[10px]">
                                        Belum Keluar
                                    </span>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-6 text-slate-400 text-xs">
                                <i class="fa-solid fa-inbox text-2xl mb-2 text-slate-300"></i>
                                <p>Belum ada riwayat presensi kunjungan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gradient-to-r from-slate-800 to-slate-900 text-white rounded-2xl p-6 shadow-md flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-amber-400 text-xl flex-shrink-0 mt-1">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-white">Tata Tertib Perpustakaan</h4>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                            Jaga ketenangan selama berada di ruang perpustakaan, rapikan buku yang telah selesai dibaca, dan pastikan melakukan scan presensi keluar sebelum meninggalkan ruangan.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-auto">
        <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
    </footer>

</body>
</html>