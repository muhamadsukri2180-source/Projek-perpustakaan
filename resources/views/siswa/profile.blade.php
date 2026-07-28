<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Perpustakaan Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen" x-data="{ tab: 'info' }">

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

                    <a href="{{ Route::has('siswa.riwayat') ? route('siswa.riwayat') : '#' }}"
                       class="px-4 py-2 rounded-xl text-white/90 hover:bg-white/10 hover:text-white transition">
                        <i class="fa-solid fa-clock-rotate-left mr-1.5 text-xs"></i> Riwayat Kunjungan
                    </a>

                    <a href="{{ route('siswa.profile') }}"
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/30 backdrop-blur-md transition">
                        <i class="fa-solid fa-id-card mr-1.5 text-xs"></i> Profil Saya
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight drop-shadow-sm">{{ $siswa->nama ?? $siswa->name ?? 'Siswa' }}</span>
                        <span class="text-[10px] text-sky-100 font-medium">Siswa Aktif</span>
                    </div>

                    <div class="w-9 h-9 rounded-full bg-white text-sky-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/40 overflow-hidden">
                        @if($siswa->foto ?? false)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Profile" class="w-full h-full object-cover">
                        @else
                            <span>{{ strtoupper(substr($siswa->nama ?? $siswa->name ?? 'S', 0, 1)) }}</span>
                        @endif
                    </div>

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

    <main class="flex-grow p-4 sm:p-6 lg:p-8 max-w-5xl mx-auto w-full">

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-600 text-white flex items-center justify-center shadow-md shadow-sky-200">
                    <i class="fa-solid fa-id-card text-lg"></i>
                </div>
                Profil Saya
            </h1>
            <p class="text-slate-500 mt-1 text-sm font-medium">Kelola informasi akun dan keamanan Anda.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
                <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-4 py-3 rounded-xl">
                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KARTU IDENTITAS --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col items-center text-center">
                <div class="w-28 h-28 rounded-2xl bg-sky-50 border-2 border-sky-100 p-1 shadow-sm overflow-hidden flex items-center justify-center mb-4">
                    @if($siswa->foto ?? false)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="w-full h-full object-cover rounded-xl">
                    @else
                        <div class="w-full h-full bg-sky-500 text-white font-extrabold text-4xl flex items-center justify-center rounded-xl">
                            {{ strtoupper(substr($siswa->nama ?? $siswa->name ?? 'S', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h3 class="font-bold text-slate-800 text-lg">{{ $siswa->nama ?? $siswa->name ?? '-' }}</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    {{ $siswa->kelas->nama_kelas ?? '-' }} &bull; {{ $siswa->jurusan->nama_jurusan ?? '-' }}
                </p>

                <span class="mt-3 text-xs bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full border border-emerald-100 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Anggota Aktif
                </span>

                <div class="w-full mt-6 pt-5 border-t border-slate-100 text-left space-y-3 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-semibold">NISN</span>
                        <span class="font-bold text-slate-700">{{ $siswa->nisn ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-semibold">NIS</span>
                        <span class="font-bold text-slate-700">{{ $siswa->nis ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-semibold">Jenis Kelamin</span>
                        <span class="font-bold text-slate-700">{{ ($siswa->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : (($siswa->jenis_kelamin ?? '') === 'P' ? 'Perempuan' : '-') }}</span>
                    </div>
                </div>
            </div>

            {{-- PENGATURAN --}}
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-200/80 flex gap-2">
                    <button @click="tab = 'info'" :class="tab === 'info' ? 'bg-sky-600 text-white shadow-md shadow-sky-200' : 'text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2">
                        <i class="fa-solid fa-image"></i> Foto Profil
                    </button>
                    <button @click="tab = 'password'" :class="tab === 'password' ? 'bg-sky-600 text-white shadow-md shadow-sky-200' : 'text-slate-600 hover:bg-slate-100'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2">
                        <i class="fa-solid fa-lock"></i> Ganti Password
                    </button>
                </div>

                {{-- FORM FOTO --}}
                <div x-show="tab === 'info'" x-cloak class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 mb-1">Perbarui Foto Profil</h2>
                    <p class="text-xs text-slate-400 mb-5">Foto ini akan tampil di kartu anggota digital & navbar Anda.</p>

                    <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="text-xs font-bold text-slate-500 mb-2 block">Pilih Foto Baru</label>
                            <input type="file" name="foto" accept="image/*"
                                   class="w-full text-xs text-slate-600 border border-slate-200 rounded-xl px-3 py-2.5 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-sky-50 file:text-sky-700 file:text-xs file:font-semibold hover:file:bg-sky-100">
                            <p class="text-[11px] text-slate-400 mt-1.5">Format JPG, PNG, atau WEBP. Ukuran maksimal 2MB.</p>
                        </div>

                        <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-sky-200 transition">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Foto
                        </button>
                    </form>
                </div>

                {{-- FORM PASSWORD --}}
                <div x-show="tab === 'password'" x-cloak class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 mb-1">Ganti Password</h2>
                    <p class="text-xs text-slate-400 mb-5">Gunakan password yang kuat dan tidak digunakan di akun lain.</p>

                    <form action="{{ route('siswa.profile.password') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="text-xs font-bold text-slate-500 mb-1.5 block">Password Lama</label>
                            <input type="password" name="password_lama" required
                                   class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-slate-500 mb-1.5 block">Password Baru</label>
                            <input type="password" name="password_baru" required minlength="8"
                                   class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-slate-500 mb-1.5 block">Konfirmasi Password Baru</label>
                            <input type="password" name="password_baru_confirmation" required minlength="8"
                                   class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-sky-200 transition">
                            <i class="fa-solid fa-key mr-1.5"></i> Ubah Password
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </main>

    <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-auto">
        <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
    </footer>

</body>
</html>