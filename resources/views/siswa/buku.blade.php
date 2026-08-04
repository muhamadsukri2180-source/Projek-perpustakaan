<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Digital - Perpustakaan Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .animated-gradient-blue {
            background: linear-gradient(-45deg, #0284c7, #38bdf8, #60a5fa, #3b82f6);
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
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <nav class="animated-gradient-blue text-white shadow-md sticky top-0 z-50">
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
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/30 backdrop-blur-md transition">
                        <i class="fa-solid fa-book mr-1.5 text-xs"></i> Buku Digital
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

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Katalog Buku Digital</h1>
                <p class="text-slate-500 text-sm">Temukan dan baca buku favoritmu secara digital kapan saja.</p>
            </div>

            {{-- Tombol navigasi ke halaman Google Books --}}
            <a href="{{ Route::has('siswa.google-books') ? route('siswa.google-books') : '#' }}" class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-sky-200 flex items-center gap-2 transition w-max">
                <i class="fa-solid fa-globe"></i> Jelajahi Google Books
            </a>
        </div>

        <div class="mb-6">
            <form action="{{ Route::has('siswa.buku') ? route('siswa.buku') : '#' }}" method="GET" class="flex gap-2">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul, penulis, atau kategori..." 
                       class="w-full max-w-md px-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-sm">
                <button type="submit" class="bg-sky-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-sky-700 transition shadow-sm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bukuDigitals as $buku)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition overflow-hidden flex flex-col justify-between p-4">
                    <div>
                        <div class="h-48 bg-slate-100 rounded-xl overflow-hidden mb-4 relative group">
                            @if($buku->cover)
                                <img src="{{ asset('storage/' . $buku->cover) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-book text-4xl"></i>
                                </div>
                            @endif
                            <span class="absolute top-2 right-2 bg-slate-900/70 text-white text-[10px] font-bold px-2 py-1 rounded-md backdrop-blur-sm z-10">
                                {{ $buku->kategori }}
                            </span>

                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button onclick="openModalBaca('{{ asset('storage/' . $buku->file_pdf) }}', '{{ addslashes($buku->judul_buku) }}')" class="bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-lg flex items-center gap-2 transform translate-y-2 group-hover:translate-y-0 transition-all">
                                    <i class="fa-solid fa-book-open"></i> Baca Sekarang
                                </button>
                            </div>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base line-clamp-1">{{ $buku->judul_buku }}</h3>
                        <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-user-pen mr-1"></i>{{ $buku->penulis ?? 'Tidak Diketahui' }}</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <button onclick="openModalBaca('{{ asset('storage/' . $buku->file_pdf) }}', '{{ addslashes($buku->judul_buku) }}')" class="w-full text-center text-xs font-bold text-sky-600 hover:text-sky-700 bg-sky-50 hover:bg-sky-100 py-2 rounded-xl flex items-center justify-center gap-1.5 transition">
                            <i class="fa-solid fa-file-pdf"></i> Baca PDF
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-100 text-slate-400 shadow-sm">
                    <i class="fa-solid fa-book-open text-4xl mb-3 text-slate-300"></i>
                    <p class="text-sm">Belum ada buku digital yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $bukuDigitals->links() }}
        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-auto">
        <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
    </footer>

    <div id="modalBaca" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md hidden z-50 flex items-center justify-center p-2 sm:p-6">
        <div class="bg-white rounded-2xl w-full max-w-5xl h-[90vh] flex flex-col shadow-2xl overflow-hidden">
            <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h3 id="baca_judul" class="font-extrabold text-base text-slate-800 line-clamp-1">Membaca Buku...</h3>
                </div>
                <div class="flex items-center gap-2">
                    <a id="download_pdf" href="#" download target="_blank" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-200 rounded-lg transition flex items-center gap-1">
                        <i class="fa-solid fa-download"></i> Unduh
                    </a>
                    <button onclick="closeModalBaca()" class="w-8 h-8 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center font-bold transition">
                        &times;
                    </button>
                </div>
            </div>
            <div class="flex-1 bg-slate-100">
                <iframe id="pdf_frame" src="" class="w-full h-full border-none"></iframe>
            </div>
        </div>
    </div>

    <script>
        function openModalBaca(pdfUrl, judul) {
            document.getElementById('baca_judul').innerText = judul;
            document.getElementById('pdf_frame').src = pdfUrl;
            document.getElementById('download_pdf').href = pdfUrl;
            document.getElementById('modalBaca').classList.remove('hidden');
        }
        
        function closeModalBaca() {
            document.getElementById('modalBaca').classList.add('hidden');
            document.getElementById('pdf_frame').src = ''; 
        }
    </script>
</body>
</html>