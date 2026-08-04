<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Books - Panel Petugas</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind Config & Custom CSS -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        petugas: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .animated-gradient-green {
            background: linear-gradient(270deg, #064e3b, #047857, #10b981, #059669);
            background-size: 300% 300%;
            animation: gradient-animation-green 8s ease infinite;
        }

        @keyframes gradient-animation-green {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans text-slate-800">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="animated-gradient-green sticky top-0 z-40 shadow-lg border-b border-emerald-400/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm border border-white/30 shadow-inner">
                            <i class="fa-solid fa-book-bookmark text-white text-xl"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-white text-lg tracking-wide leading-tight">Perpustakaan</span>
                            <span class="text-emerald-100 text-xs font-medium">Panel Petugas</span>
                        </div>
                    </div>
                    
                    <div class="hidden md:ml-10 md:flex md:space-x-2">
                        @if(Route::has('petugas.dashboard'))
                        <a href="{{ route('petugas.dashboard') }}" class="text-emerald-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <i class="fa-solid fa-chart-line mr-1.5"></i> Dashboard
                        </a>
                        @endif

                        @if(Route::has('petugas.siswa.index'))
                        <a href="{{ route('petugas.siswa.index') }}" class="text-emerald-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <i class="fa-solid fa-users mr-1.5"></i> Data Siswa
                        </a>
                        @elseif(Route::has('petugas.siswa'))
                        <a href="{{ route('petugas.siswa') }}" class="text-emerald-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <i class="fa-solid fa-users mr-1.5"></i> Data Siswa
                        </a>
                        @endif

                        @if(Route::has('petugas.buku'))
                        <a href="{{ route('petugas.buku') }}" class="text-emerald-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <i class="fa-solid fa-book mr-1.5"></i> Buku Digital
                        </a>
                        @endif

                        <a href="#" class="bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm px-3 py-2 rounded-lg text-sm transition-all duration-200">
                            <i class="fa-brands fa-google mr-1.5"></i> Google Books
                        </a>

                        @if(Route::has('petugas.presensi'))
                        <a href="{{ route('petugas.presensi') }}" class="text-emerald-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <i class="fa-solid fa-clipboard-user mr-1.5"></i> Presensi
                        </a>
                        @endif

                        @if(Route::has('petugas.laporan.harian'))
                        <a href="{{ route('petugas.laporan.harian') }}" class="text-emerald-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <i class="fa-solid fa-file-invoice mr-1.5"></i> Laporan
                        </a>
                        @elseif(Route::has('petugas.laporan'))
                        <a href="{{ route('petugas.laporan') }}" class="text-emerald-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <i class="fa-solid fa-file-invoice mr-1.5"></i> Laporan
                        </a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight text-white">{{ Auth::user()->name ?? 'Petugas Perpustakaan' }}</span>
                        <span class="text-[10px] text-emerald-200">Petugas Active</span>
                    </div>

                    <a href="{{ Route::has('petugas.profile') ? route('petugas.profile') : '#' }}" 
                       title="Lihat Profil Petugas" 
                       class="w-9 h-9 rounded-full bg-white text-emerald-800 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:ring-white hover:scale-105 active:scale-95 transition-all duration-200 group">
                        <span class="group-hover:text-emerald-900">P</span>
                    </a>

                    <div class="h-5 w-[1px] bg-white/20 hidden sm:block"></div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar" class="w-9 h-9 rounded-xl text-white/80 hover:text-white hover:bg-white/10 flex items-center justify-center text-sm transition">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </nav>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="flex-grow py-8 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-center sm:text-left flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">
                    <i class="fa-brands fa-google text-petugas-600 mr-2"></i> Jelajahi Buku Digital
                </h1>
                <p class="text-slate-500 text-sm">
                    Cari, baca, dan simpan koleksi buku digital dari Google Books untuk perpustakaan Anda.
                </p>
            </div>
        </div>

        <div class="bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200 inline-flex mb-8 w-full sm:w-auto">
            <button onclick="switchTab('search')" id="tab-search" class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all bg-petugas-50 text-petugas-700 shadow-sm border border-petugas-100">
                <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari Buku Online
            </button>
            <button onclick="switchTab('saved')" id="tab-saved" class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all text-slate-500 hover:text-slate-700 hover:bg-slate-50">
                <i class="fa-solid fa-bookmark mr-2"></i> Koleksi Tersimpan
            </button>
        </div>

        <!-- ==================== SEARCH SECTION ==================== -->
        <div id="section-search">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
                <form id="search-form" onsubmit="searchBooks(event)" class="relative max-w-3xl mx-auto">
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-slate-400"></i>
                        </div>
                        <input type="text" id="search-input" name="q" 
                            class="block w-full pl-11 pr-32 py-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-petugas-500 focus:border-petugas-500 transition-all text-sm md:text-base"
                            placeholder="Ketik judul buku, penulis, atau ISBN..." required minlength="2">
                        <button type="submit" 
                            class="absolute right-2 top-2 bottom-2 bg-petugas-600 hover:bg-petugas-700 text-white font-medium px-6 rounded-lg transition-colors shadow-sm flex items-center gap-2">
                            <span>Cari</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                    <div class="mt-3 flex gap-2 justify-center text-xs text-slate-500">
                        <span class="bg-slate-100 px-2 py-1 rounded cursor-pointer hover:bg-slate-200" onclick="quickSearch('Teknologi')">Teknologi</span>
                        <span class="bg-slate-100 px-2 py-1 rounded cursor-pointer hover:bg-slate-200" onclick="quickSearch('Pendidikan')">Pendidikan</span>
                        <span class="bg-slate-100 px-2 py-1 rounded cursor-pointer hover:bg-slate-200" onclick="quickSearch('Sains')">Sains</span>
                        <span class="bg-slate-100 px-2 py-1 rounded cursor-pointer hover:bg-slate-200" onclick="quickSearch('Sejarah')">Sejarah</span>
                    </div>
                </form>
            </div>

            <div id="search-loading" class="hidden py-12 flex flex-col items-center justify-center">
                <div class="w-12 h-12 border-4 border-petugas-200 border-t-petugas-600 rounded-full animate-spin mb-4"></div>
                <p class="text-slate-500 font-medium">Mencari buku di Google Books...</p>
            </div>

            <div id="search-results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
            
            <div id="search-empty" class="py-16 flex flex-col items-center justify-center text-center bg-white rounded-2xl border border-slate-100 shadow-sm border-dashed">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-brands fa-google text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700 mb-1">Mulai Pencarian</h3>
                <p class="text-slate-500 max-w-sm text-sm">
                    Gunakan kolom pencarian di atas untuk menemukan jutaan buku gratis dan berbayar dari Google Books.
                </p>
            </div>
        </div>

        <!-- ==================== SAVED BOOKS SECTION ==================== -->
        <div id="section-saved" class="hidden">
            @if(isset($savedBooks) && count($savedBooks) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($savedBooks as $book)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow group relative p-4">
                        <div class="flex gap-4">
                            <div class="w-24 h-36 flex-shrink-0 bg-slate-100 rounded-lg overflow-hidden shadow-sm relative">
                                @if($book->cover_url)
                                    <img src="{{ $book->cover_url }}" alt="Cover {{ $book->judul_buku }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fa-solid fa-book-open text-3xl text-slate-300"></i>
                                    </div>
                                @endif
                                <div class="absolute top-0 right-0 bg-petugas-900/80 text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg backdrop-blur-sm">
                                    {{ $book->kategori ?? 'Umum' }}
                                </div>
                            </div>

                            <div class="flex-grow min-w-0">
                                <h3 class="text-base font-bold text-slate-800 leading-tight mb-1 truncate">{{ $book->judul_buku }}</h3>
                                <p class="text-xs font-medium text-petugas-600 mb-2 truncate">{{ $book->penulis ?? 'Penulis Tidak Diketahui' }}</p>
                                
                                <div class="mt-4 flex flex-col gap-2">
                                    <button onclick="openReader('{{ $book->google_volume_id }}', '{{ addslashes($book->judul_buku) }}', '{{ $book->reader_url }}')" 
                                        class="w-full bg-petugas-600 hover:bg-petugas-700 text-white text-xs font-medium py-2 px-3 rounded-lg transition-colors flex justify-center items-center gap-1.5">
                                        <i class="fa-solid fa-book-open-reader"></i> Baca Buku
                                    </button>
                                    <button onclick="deleteBook('{{ $book->id }}')" 
                                        class="w-full bg-white hover:bg-red-50 text-red-600 border border-red-200 hover:border-red-300 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex justify-center items-center gap-1.5">
                                        <i class="fa-solid fa-trash-can"></i> Hapus dari Koleksi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="py-16 flex flex-col items-center justify-center text-center bg-white rounded-2xl border border-slate-100 shadow-sm border-dashed">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-regular fa-bookmark text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Koleksi</h3>
                    <p class="text-slate-500 max-w-sm text-sm">
                        Anda belum menyimpan buku apapun ke dalam koleksi digital perpustakaan.
                    </p>
                    <button onclick="switchTab('search')" class="mt-4 text-petugas-600 font-medium text-sm hover:underline">
                        Mulai Cari Buku <i class="fa-solid fa-arrow-right text-xs ml-1"></i>
                    </button>
                </div>
            @endif
        </div>
        
    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} Absen Perpustakaan. All rights reserved.
            </p>
            <div class="flex items-center gap-4 text-sm text-slate-400">
                <span>Versi 1.0</span>
                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                <span>Panel Petugas</span>
            </div>
        </div>
    </footer>

    <!-- ==================== READER MODAL ==================== -->
    <div id="reader-modal" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-md" onclick="closeReader()"></div>
        
        <div class="absolute inset-4 md:inset-10 bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="reader-content">
            <div class="h-14 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 flex-shrink-0">
                <div class="flex items-center gap-3 truncate">
                    <div class="w-8 h-8 rounded-full bg-petugas-100 flex items-center justify-center">
                        <i class="fa-solid fa-book-open text-petugas-600 text-sm"></i>
                    </div>
                    <h3 id="reader-title" class="font-bold text-slate-800 truncate text-sm sm:text-base">Membaca Buku</h3>
                </div>
                
                <div class="flex items-center gap-2">
                    <a id="reader-external-link" href="#" target="_blank" 
                       class="hidden sm:flex text-xs font-medium text-petugas-600 hover:bg-petugas-50 px-3 py-1.5 rounded-lg transition-colors items-center gap-1.5 border border-petugas-200">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka di Google
                    </a>
                    <button onclick="closeReader()" class="w-8 h-8 rounded-full hover:bg-slate-100 text-slate-500 hover:text-red-500 transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex-grow bg-slate-100 relative w-full h-full">
                <div id="reader-loading" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-100 z-10">
                    <div class="w-10 h-10 border-3 border-petugas-200 border-t-petugas-600 rounded-full animate-spin mb-3"></div>
                    <span class="text-sm text-slate-500 font-medium">Memuat pratinjau buku...</span>
                </div>
                
                <div id="reader-blocked" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-100 z-0 hidden p-6 text-center">
                    <i class="fa-solid fa-triangle-exclamation text-4xl text-amber-500 mb-3"></i>
                    <h4 class="font-bold text-slate-700 text-lg mb-1">Pratinjau Tidak Tersedia</h4>
                    <p class="text-slate-500 text-sm mb-4 max-w-md">Buku ini mungkin dilindungi hak cipta atau penerbit tidak mengizinkan pratinjau (embed) di situs lain.</p>
                    <a id="reader-fallback-link" href="#" target="_blank" class="bg-petugas-600 hover:bg-petugas-700 text-white font-medium px-4 py-2 rounded-lg transition-colors text-sm shadow-sm inline-flex items-center gap-2">
                        Buka di Google Books <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>

                <iframe id="reader-iframe" class="w-full h-full border-0 absolute inset-0 z-20" src="" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- ==================== TOAST NOTIFICATION ==================== -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ==================== JAVASCRIPT ==================== -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const routes = {
            search: "{{ Route::has('petugas.google-books.search') ? route('petugas.google-books.search') : '/petugas/google-books/search' }}",
            store: "{{ Route::has('petugas.google-books.store') ? route('petugas.google-books.store') : '/petugas/google-books' }}",
            delete: "{{ url('/petugas/google-books') }}"
        };

        // --- TAB SWITCHING ---
        function switchTab(tabName) {
            const btnSearch = document.getElementById('tab-search');
            const btnSaved = document.getElementById('tab-saved');
            const secSearch = document.getElementById('section-search');
            const secSaved = document.getElementById('section-saved');

            if (tabName === 'search') {
                btnSearch.className = 'flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all bg-petugas-50 text-petugas-700 shadow-sm border border-petugas-100';
                btnSaved.className = 'flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all text-slate-500 hover:text-slate-700 hover:bg-slate-50 border border-transparent';
                secSearch.classList.remove('hidden');
                secSaved.classList.add('hidden');
            } else {
                btnSaved.className = 'flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all bg-petugas-50 text-petugas-700 shadow-sm border border-petugas-100';
                btnSearch.className = 'flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all text-slate-500 hover:text-slate-700 hover:bg-slate-50 border border-transparent';
                secSaved.classList.remove('hidden');
                secSearch.classList.add('hidden');
            }
        }

        function quickSearch(term) {
            document.getElementById('search-input').value = term;
            document.getElementById('search-form').requestSubmit();
        }

        // --- SEARCH GOOGLE BOOKS ---
        // FIX: backend mengirim { success, total_items, books }, bukan { items }
        async function searchBooks(event) {
            event.preventDefault();
            const query = document.getElementById('search-input').value.trim();
            if (!query || query.length < 2) {
                showToast('Kata kunci minimal 2 karakter.', 'error');
                return;
            }

            const resultsContainer = document.getElementById('search-results');
            const loadingIndicator = document.getElementById('search-loading');
            const emptyState = document.getElementById('search-empty');

            emptyState.classList.add('hidden');
            resultsContainer.innerHTML = '';
            loadingIndicator.classList.remove('hidden');

            try {
                const url = new URL(routes.search, window.location.origin);
                url.searchParams.append('q', query);

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();
                loadingIndicator.classList.add('hidden');

                if (!response.ok || data.success === false) {
                    resultsContainer.innerHTML = `
                        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-100 shadow-sm">
                            <i class="fa-solid fa-triangle-exclamation text-4xl text-amber-400 mb-3"></i>
                            <h3 class="text-lg font-bold text-slate-700">Gagal Mengambil Data</h3>
                            <p class="text-slate-500 text-sm">${data.message || 'Terjadi kesalahan saat menghubungi Google Books API.'}</p>
                        </div>
                    `;
                    showToast(data.message || 'Gagal mencari buku.', 'error');
                    return;
                }

                if (data.books && data.books.length > 0) {
                    renderResults(data.books);
                } else {
                    resultsContainer.innerHTML = `
                        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-100 shadow-sm">
                            <i class="fa-solid fa-magnifying-glass-minus text-4xl text-slate-300 mb-3"></i>
                            <h3 class="text-lg font-bold text-slate-700">Tidak ada hasil</h3>
                            <p class="text-slate-500 text-sm">Buku dengan kata kunci "${query}" tidak ditemukan.</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error fetching books:', error);
                loadingIndicator.classList.add('hidden');
                showToast('Gagal mencari buku. Silakan coba lagi.', 'error');
            }
        }

        // --- RENDER RESULTS ---
        // FIX: field disesuaikan dengan struktur yang dikembalikan controller
        // (volume_id, title, author_text, categories, page_count, short_desc, cover_url, preview_link, reader_link)
        function renderResults(books) {
            const container = document.getElementById('search-results');
            let html = '';

            books.forEach(book => {
                const id = book.volume_id;
                const title = book.title || 'Tanpa Judul';
                const authors = book.author_text || 'Penulis Tidak Diketahui';
                const description = book.short_desc || 'Tidak ada deskripsi tersedia.';
                const category = (book.categories && book.categories.length > 0) ? book.categories[0] : 'Umum';
                const pageCount = book.page_count ? `${book.page_count} Halaman` : '-';
                const cover = book.cover_url || '';
                const previewLink = book.preview_link || book.reader_link || '';

                const safeTitle = title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const safeAuthors = authors.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const safeCategory = category.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const safeCover = cover;
                const safePreview = previewLink;

                html += `
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow group">
                        <div class="p-4 flex gap-4 h-48">
                            <div class="w-24 flex-shrink-0 bg-slate-100 rounded-lg overflow-hidden relative shadow-sm h-full">
                                ${cover ? `<img src="${cover}" alt="Cover" class="w-full h-full object-cover">` : 
                                         `<div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-book-open text-3xl text-slate-300"></i></div>`}
                                <div class="absolute top-0 right-0 bg-petugas-900/80 text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg backdrop-blur-sm">
                                    ${category.split(' ')[0]}
                                </div>
                            </div>
                            
                            <div class="flex-grow min-w-0 flex flex-col">
                                <h3 class="text-base font-bold text-slate-800 leading-tight mb-1 line-clamp-2" title="${title}">${title}</h3>
                                <p class="text-xs font-medium text-petugas-600 mb-2 truncate" title="${authors}">${authors}</p>
                                <div class="text-[11px] text-slate-500 mb-2 flex items-center gap-1">
                                    <i class="fa-regular fa-file-lines"></i> ${pageCount}
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-3 mt-auto leading-relaxed">
                                    ${description}
                                </p>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 border-t border-slate-100 grid grid-cols-2 gap-2 mt-auto">
                            <button onclick="openReader('${id}', '${safeTitle}', '${safePreview}')" 
                                class="bg-petugas-600 hover:bg-petugas-700 text-white text-xs font-medium py-2 px-2 rounded-lg transition-colors flex justify-center items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-book-open-reader"></i> Baca
                            </button>
                            <button onclick="saveBook('${id}', '${safeTitle}', '${safeAuthors}', '${safeCategory}', '${safeCover}', '${safePreview}')" 
                                class="bg-white hover:bg-petugas-50 text-petugas-700 border border-petugas-200 text-xs font-medium py-2 px-2 rounded-lg transition-colors flex justify-center items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-bookmark"></i> Simpan
                            </button>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // --- READER MODAL ---
        const readerModal = document.getElementById('reader-modal');
        const readerIframe = document.getElementById('reader-iframe');
        const readerLoading = document.getElementById('reader-loading');
        
        function openReader(volumeId, title, previewLink) {
            document.getElementById('reader-title').textContent = title;
            document.getElementById('reader-external-link').href = previewLink;
            document.getElementById('reader-fallback-link').href = previewLink;
            
            const embedUrl = `https://books.google.com/books?id=${volumeId}&lpg=PP1&pg=PP1&output=embed`;
            
            readerModal.classList.remove('hidden');
            setTimeout(() => {
                readerModal.classList.remove('opacity-0');
                document.getElementById('reader-content').classList.remove('scale-95');
                document.getElementById('reader-content').classList.add('scale-100');
            }, 10);

            readerLoading.style.display = 'flex';
            
            readerIframe.onload = function() {
                readerLoading.style.display = 'none';
            };

            readerIframe.src = embedUrl;
            document.body.style.overflow = 'hidden';
        }

        function closeReader() {
            readerModal.classList.add('opacity-0');
            document.getElementById('reader-content').classList.remove('scale-100');
            document.getElementById('reader-content').classList.add('scale-95');
            
            setTimeout(() => {
                readerModal.classList.add('hidden');
                readerIframe.src = '';
                document.body.style.overflow = 'auto';
            }, 300);
        }

        // --- SAVE BOOK ---
        async function saveBook(volumeId, title, author, category, coverUrl, readerUrl) {
            try {
                const response = await fetch(routes.store, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        google_volume_id: volumeId,
                        judul_buku: title,
                        penulis: author,
                        kategori: category,
                        cover_url: coverUrl,
                        reader_url: readerUrl
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    showToast('Buku berhasil disimpan ke koleksi!', 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showToast(data.message || 'Gagal menyimpan buku.', 'error');
                }
            } catch (error) {
                console.error('Error saving book:', error);
                showToast('Terjadi kesalahan pada server.', 'error');
            }
        }

        // --- DELETE BOOK ---
        async function deleteBook(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus buku ini dari koleksi?')) return;

            try {
                const response = await fetch(`${routes.delete}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    showToast('Buku berhasil dihapus dari koleksi.', 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showToast(data.message || 'Gagal menghapus buku.', 'error');
                }
            } catch (error) {
                console.error('Error deleting book:', error);
                showToast('Terjadi kesalahan pada server.', 'error');
            }
        }

        // --- TOAST NOTIFICATIONS ---
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const bgColor = type === 'success' ? 'bg-emerald-500' : 'bg-red-500';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-circle-exclamation';

            toast.className = `${bgColor} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 transform translate-x-full transition-transform duration-300 z-50 text-sm font-medium`;
            toast.innerHTML = `
                <i class="fa-solid ${icon} text-lg"></i>
                <span>${message}</span>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 10);

            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>