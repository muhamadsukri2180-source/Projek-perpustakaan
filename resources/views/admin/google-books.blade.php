<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Perpustakaan Digital - Admin Perpustakaan</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    animation: {
                        'gradient': 'gradient 8s linear infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        gradient: {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .animated-gradient {
            background: linear-gradient(90deg, #1e3a8a, #2563eb, #3b82f6, #0284c7);
            background-size: 300% 300%;
            animation: gradient 8s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .tab-active {
            border-bottom: 2px solid #2563eb;
            color: #2563eb;
            font-weight: 600;
        }
        .tab-inactive {
            color: #64748b;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Hide scrollbar for cleaner look in modals/iframes */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Navbar Admin -->
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
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.dashboard*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-chart-pie text-xs"></i> Dashboard
                    </a>

                    <a href="{{ Route::has('admin.siswa.index') ? route('admin.siswa.index') : (Route::has('admin.siswa') ? route('admin.siswa') : '#') }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.siswa*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-users text-xs"></i> Data Siswa
                    </a>
                    
                    <a href="{{ Route::has('admin.buku') ? route('admin.buku') : '#' }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.buku*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-book-open text-xs"></i> Buku Digital
                    </a>

                    <a href="{{ Route::has('admin.petugas.index') ? route('admin.petugas.index') : '#' }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.petugas*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-user-tie text-xs"></i> Kelola Petugas
                    </a>

                    <a href="{{ Route::has('admin.presensi') ? route('admin.presensi') : '#' }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.presensi*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-clipboard-user text-xs"></i> Presensi
                    </a>

                    <a href="{{ Route::has('admin.laporan.harian') ? route('admin.laporan.harian') : (Route::has('admin.laporan') ? route('admin.laporan') : '#') }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.laporan*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-file-lines text-xs"></i> Laporan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight">Admin</span>
                        <span class="text-[10px] text-blue-200 capitalize">Administrator</span>
                    </div>

                    <a href="{{ Route::has('admin.profile') ? route('admin.profile') : '#' }}" 
                       title="Lihat Profil Admin" 
                       class="w-9 h-9 rounded-full bg-white text-blue-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:ring-white hover:scale-105 active:scale-95 transition-all duration-200 group">
                        <span class="group-hover:text-blue-700">A</span>
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

    <!-- Main Content -->
    <main class="flex-grow p-4 sm:p-6 lg:p-8 w-full max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 flex items-center gap-3">
                <i class="fa-brands fa-google text-blue-600"></i> Jelajahi Buku Digital
            </h1>
            <p class="text-slate-500 mt-2">Cari jutaan buku dari Perpustakaan Digital dan tambahkan ke koleksi perpustakaan Anda.</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex border-b border-slate-200 mb-6 w-full">
            <button onclick="switchTab('search')" id="tab-search" class="tab-active pb-3 px-4 text-sm focus:outline-none transition-colors duration-200 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i> Cari Buku Online
            </button>
            <button onclick="switchTab('saved')" id="tab-saved" class="tab-inactive pb-3 px-4 text-sm hover:text-blue-600 focus:outline-none transition-colors duration-200 flex items-center gap-2">
                <i class="fa-solid fa-bookmark"></i> Koleksi Tersimpan
            </button>
        </div>

        <!-- TAB 1: SEARCH SECTION -->
        <div id="section-search" class="block">
            <!-- Search Bar -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6">
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-slate-400"></i>
                    </div>
                    <input type="text" id="searchInput"
                        class="block w-full pl-11 pr-32 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-inner"
                        placeholder="Cari judul buku, penulis, atau topik..."
                        onkeypress="if(event.key === 'Enter') searchBooks()">
                    <div class="absolute inset-y-0 right-1.5 flex items-center">
                        <button onclick="searchBooks()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center gap-2">
                            <span>Cari</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden py-12 flex-col items-center justify-center text-slate-500">
                <i class="fa-solid fa-circle-notch fa-spin text-4xl text-blue-500 mb-4"></i>
                <p>Mencari buku...</p>
            </div>

            <!-- Empty / Initial State -->
            <div id="emptySearchState" class="py-16 flex flex-col items-center justify-center text-center bg-white rounded-2xl border border-slate-100 shadow-sm border-dashed">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-brands fa-google text-3xl text-blue-500"></i>
                </div>
                <h3 class="text-lg font-semibold text-slate-700 mb-1">Mulai Pencarian</h3>
                <p class="text-slate-500 text-sm max-w-md">Ketik judul buku, nama penulis, atau topik di kotak pencarian di atas untuk menemukan buku dari Perpustakaan Digital.</p>
            </div>

            <!-- Search Results Grid -->
            <div id="searchResults" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                <!-- Results will be injected here via JS -->
            </div>
        </div>

        <!-- TAB 2: SAVED BOOKS SECTION -->
        <div id="section-saved" class="hidden">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-2">Koleksi Buku dari Perpustakaan Digital</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($savedBooks ?? [] as $book)
                        <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-200 hover:shadow-md transition-shadow group flex flex-col h-full">
                            <div class="h-48 overflow-hidden bg-slate-200 relative flex items-center justify-center">
                                @if($book->cover_url)
                                    <img src="{{ $book->cover_url }}" alt="Cover {{ $book->judul_buku }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <i class="fa-solid fa-image text-4xl text-slate-400"></i>
                                @endif
                                <div class="absolute top-3 left-3 bg-blue-600/90 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-md shadow-sm">
                                    {{ $book->kategori ?? 'Umum' }}
                                </div>
                            </div>
                            <div class="p-4 flex-grow flex flex-col">
                                <h3 class="font-bold text-slate-800 text-base mb-1 line-clamp-2" title="{{ $book->judul_buku }}">{{ $book->judul_buku }}</h3>
                                <p class="text-sm text-slate-500 mb-3"><i class="fa-solid fa-pen-nib text-xs mr-1 opacity-70"></i> {{ $book->penulis ?? 'Penulis tidak diketahui' }}</p>

                                <div class="mt-auto pt-4 flex gap-2">
                                    <button onclick="openReader('{{ $book->google_volume_id }}', '{{ addslashes($book->judul_buku) }}', '{{ $book->reader_url }}')" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2 shadow-sm">
                                        <i class="fa-solid fa-book-open"></i> Baca
                                    </button>

                                    <form method="POST" action="{{ url('/admin/google-books/'.$book->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini dari koleksi?');" class="flex-none">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 py-2 px-3 rounded-lg text-sm font-medium transition-colors flex items-center justify-center border border-red-200 shadow-sm h-full" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                            <div class="w-16 h-16 bg-slate-200 rounded-full flex items-center justify-center mb-3">
                                <i class="fa-solid fa-bookmark text-2xl text-slate-400"></i>
                            </div>
                            <h3 class="text-base font-medium text-slate-700 mb-1">Koleksi Kosong</h3>
                            <p class="text-slate-500 text-sm">Belum ada buku dari Perpustakaan Digital yang disimpan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- Toast Notification System -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

    <!-- Google Books Embedded Reader Modal -->
    <div id="readerModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-md flex-col">
        <!-- Reader Header -->
        <div class="bg-white shadow-md border-b border-slate-200 px-4 py-3 flex items-center justify-between z-10 shrink-0">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 shrink-0">
                    <i class="fa-brands fa-google"></i>
                </div>
                <div class="truncate">
                    <h3 id="readerTitle" class="font-bold text-slate-800 truncate">Judul Buku</h3>
                    <p class="text-xs text-slate-500"> Perpustakaan Digital Preview</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a id="readerExternalLink" href="#" target="_blank" class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors hidden sm:flex items-center gap-2 border border-blue-200">
                    Buka di Tab Baru <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
                <button onclick="closeReader()" class="w-10 h-10 rounded-full hover:bg-slate-100 text-slate-500 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Reader Body - iframe container -->
        <div class="flex-grow w-full relative bg-slate-100">
            <!-- Loading indicator for iframe -->
            <div id="readerLoading" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-100 z-0">
                <i class="fa-solid fa-circle-notch fa-spin text-4xl text-blue-500 mb-4"></i>
                <p class="text-slate-500 font-medium">Memuat penampil buku...</p>
                <p class="text-slate-400 text-sm mt-2 max-w-md text-center px-4">Beberapa buku mungkin membatasi pratinjau. Jika tidak muncul, gunakan tombol 'Buka di Tab Baru' di atas.</p>
            </div>

            <iframe id="readerFrame" class="absolute inset-0 w-full h-full border-0 z-10 opacity-0 transition-opacity duration-500" onload="this.style.opacity='1'" src="" allowfullscreen></iframe>
        </div>
    </div>

    <!-- JavaScript Vanilla -->
    <script>
        // Global variables
        const CSRF_TOKEN = '{{ csrf_token() }}';

        // Tab Switching Logic
        function switchTab(tabId) {
            // Update UI tabs
            if (tabId === 'search') {
                document.getElementById('tab-search').className = 'tab-active pb-3 px-4 text-sm focus:outline-none transition-colors duration-200 flex items-center gap-2';
                document.getElementById('tab-saved').className = 'tab-inactive pb-3 px-4 text-sm hover:text-blue-600 focus:outline-none transition-colors duration-200 flex items-center gap-2';

                document.getElementById('section-search').classList.remove('hidden');
                document.getElementById('section-search').classList.add('block');
                document.getElementById('section-saved').classList.add('hidden');
                document.getElementById('section-saved').classList.remove('block');
            } else {
                document.getElementById('tab-saved').className = 'tab-active pb-3 px-4 text-sm focus:outline-none transition-colors duration-200 flex items-center gap-2';
                document.getElementById('tab-search').className = 'tab-inactive pb-3 px-4 text-sm hover:text-blue-600 focus:outline-none transition-colors duration-200 flex items-center gap-2';

                document.getElementById('section-saved').classList.remove('hidden');
                document.getElementById('section-saved').classList.add('block');
                document.getElementById('section-search').classList.add('hidden');
                document.getElementById('section-search').classList.remove('block');
            }
        }

        // ============================================================
        // FIX UTAMA:
        // Controller (GoogleBooksController@search) mengirim JSON dengan
        // struktur: { success, total_items, books: [ {volume_id, title,
        // author_text, cover_url, ...} ] }
        // BUKAN struktur mentah Google API { items: [ {id, volumeInfo:{}} ] }.
        // Sebelumnya kode di sini membaca "data.items" yang selalu undefined,
        // sehingga pencarian selalu terlihat "tidak ditemukan" padahal API
        // sebenarnya berhasil. Di bawah ini sudah disesuaikan dengan format
        // asli yang dikirim controller.
        // ============================================================

        // Search Books via AJAX
        function searchBooks() {
            const query = document.getElementById('searchInput').value.trim();

            if (!query) {
                showToast('Masukkan kata kunci pencarian terlebih dahulu', 'warning');
                return;
            }

            // UI State updates
            document.getElementById('emptySearchState').classList.add('hidden');
            document.getElementById('searchResults').classList.add('hidden');
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('loadingState').classList.add('flex');

            // API endpoint url
            const url = `{{ Route::has('admin.google-books.search') ? route('admin.google-books.search') : '/admin/google-books/search' }}?q=${encodeURIComponent(query)}`;

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, ok: response.ok, data })))
            .then(({ ok, data }) => {
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('loadingState').classList.remove('flex');

                // Response controller: { success, total_items, books: [...] }
                if (ok && data.success && Array.isArray(data.books) && data.books.length > 0) {
                    renderResults(data.books);
                } else {
                    document.getElementById('searchResults').classList.add('hidden');
                    document.getElementById('emptySearchState').classList.remove('hidden');
                    document.getElementById('emptySearchState').innerHTML = `
                        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-magnifying-glass-minus text-2xl text-red-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-700 mb-1">Buku tidak ditemukan</h3>
                        <p class="text-slate-500 text-sm">${data.message || 'Coba gunakan kata kunci lain untuk pencarian Anda.'}</p>
                    `;
                }
            })
            .catch(error => {
                console.error('Error fetching Google Books:', error);
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('loadingState').classList.remove('flex');

                document.getElementById('emptySearchState').classList.remove('hidden');
                document.getElementById('emptySearchState').innerHTML = `
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-triangle-exclamation text-2xl text-red-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-700 mb-1">Terjadi Kesalahan</h3>
                    <p class="text-slate-500 text-sm">Gagal mengambil data dari server. Silakan coba lagi nanti.</p>
                `;

                showToast('Gagal melakukan pencarian', 'error');
            });
        }

        // Render Search Results
        // book di sini mengikuti struktur dari controller:
        // { volume_id, title, authors, author_text, publisher, published_date,
        //   description, short_desc, categories, page_count, cover_url,
        //   preview_link, reader_link, embeddable, viewability, info_link }
        function renderResults(books) {
            const container = document.getElementById('searchResults');
            container.innerHTML = '';

            books.forEach(book => {
                const volumeId   = book.volume_id;
                const title      = book.title || 'Tanpa Judul';
                const author     = book.author_text || 'Penulis tidak diketahui';
                const shortDesc  = book.short_desc || 'Tidak ada deskripsi tersedia.';
                const pageCount  = book.page_count ? `${book.page_count} halaman` : '-';
                const category   = (Array.isArray(book.categories) && book.categories.length > 0) ? book.categories[0] : 'Umum';
                const coverUrl   = book.cover_url || '';
                const readerLink = book.reader_link || book.preview_link || '';

                // Escape quotes for JS inline functions
                const safeTitle    = title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const safeAuthor   = author.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const safeCategory = category.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const safeCover    = coverUrl.replace(/'/g, "\\'");
                const safeReader   = readerLink.replace(/'/g, "\\'");

                const cardHtml = `
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition-shadow group flex flex-col h-full">
                        <div class="h-48 overflow-hidden bg-slate-100 relative flex items-center justify-center border-b border-slate-100">
                            ${coverUrl ?
                                `<img src="${coverUrl}" alt="Cover" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">` :
                                `<i class="fa-solid fa-book-open text-4xl text-slate-300"></i>`
                            }
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-slate-700 text-xs font-bold px-2.5 py-1 rounded-md shadow-sm border border-slate-200">
                                ${category}
                            </div>
                        </div>
                        <div class="p-5 flex-grow flex flex-col">
                            <h3 class="font-bold text-slate-800 text-lg mb-1 line-clamp-2 leading-tight" title="${title}">${title}</h3>
                            <p class="text-sm text-slate-500 font-medium mb-3"><i class="fa-solid fa-pen-nib text-xs mr-1 opacity-70"></i> ${author}</p>

                            <p class="text-xs text-slate-600 line-clamp-2 mb-4 leading-relaxed">${shortDesc}</p>

                            <div class="flex items-center text-xs text-slate-400 mb-4 mt-auto">
                                <i class="fa-regular fa-file-lines mr-1.5"></i> ${pageCount}
                            </div>

                            <div class="grid grid-cols-2 gap-2 mt-auto">
                                <button onclick="openReader('${volumeId}', '${safeTitle}', '${safeReader}')" class="bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white py-2 px-3 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2 border border-emerald-200 hover:border-emerald-600 shadow-sm">
                                    <i class="fa-solid fa-book-open"></i> Baca
                                </button>
                                <button onclick="saveBook('${volumeId}', '${safeTitle}', '${safeAuthor}', '${safeCategory}', '${safeCover}', '${safeReader}')" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    <i class="fa-solid fa-bookmark"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                container.insertAdjacentHTML('beforeend', cardHtml);
            });

            container.classList.remove('hidden');
        }

        // Save Book via AJAX
        function saveBook(volumeId, title, author, category, coverUrl, readerLink) {
            // Unescape single quotes that were escaped for JS execution
            const unescapedTitle  = title.replace(/\\'/g, "'");
            const unescapedAuthor = author.replace(/\\'/g, "'");
            const unescapedCover  = coverUrl.replace(/\\'/g, "'");
            const unescapedReader = readerLink.replace(/\\'/g, "'");

            const formData = new FormData();
            formData.append('_token', CSRF_TOKEN);
            formData.append('google_volume_id', volumeId);
            formData.append('judul_buku', unescapedTitle);
            formData.append('penulis', unescapedAuthor);
            formData.append('kategori', category);
            formData.append('cover_url', unescapedCover);
            formData.append('reader_url', unescapedReader);

            // Route resmi untuk simpan: admin.google-books.store -> POST /admin/google-books/simpan
            const url = `{{ Route::has('admin.google-books.store') ? route('admin.google-books.store') : '/admin/google-books/simpan' }}`;

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json().then(data => ({ ok: response.ok, status: response.status, data })))
            .then(({ ok, status, data }) => {
                if (ok && data.success) {
                    showToast(data.message || 'Buku berhasil disimpan ke koleksi!', 'success');
                } else if (status === 409) {
                    // Buku sudah ada di koleksi
                    showToast(data.message || 'Buku ini sudah ada di koleksi perpustakaan.', 'warning');
                } else {
                    showToast(data.message || 'Gagal menyimpan buku', 'error');
                }
            })
            .catch(error => {
                console.error('Error saving book:', error);
                showToast('Terjadi kesalahan saat menyimpan buku', 'error');
            });
        }

        // Reader Modal Functions
        function openReader(volumeId, title, readerLink) {
            const modal   = document.getElementById('readerModal');
            const iframe  = document.getElementById('readerFrame');
            const titleEl = document.getElementById('readerTitle');
            const extLink = document.getElementById('readerExternalLink');

            // Set Modal Details
            titleEl.textContent = title.replace(/\\'/g, "'");

            if (readerLink) {
                extLink.href = readerLink;
                extLink.classList.remove('hidden');
            } else {
                extLink.classList.add('hidden');
            }

            // Set iframe src (using Google Books Embed)
            iframe.style.opacity = '0';
            iframe.src = `https://books.google.com/books?id=${volumeId}&lpg=PP1&pg=PP1&output=embed`;

            // Show modal
            document.body.classList.add('overflow-hidden'); // prevent background scrolling
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeReader() {
            const modal  = document.getElementById('readerModal');
            const iframe = document.getElementById('readerFrame');

            // Clear iframe source to stop loading
            iframe.src = '';

            // Hide modal
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden'); // restore background scrolling
        }

        // Simple Toast Notification System
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');

            let icon = '';
            let bgColor = '';
            let textColor = '';

            if (type === 'success') {
                icon = '<i class="fa-solid fa-circle-check"></i>';
                bgColor = 'bg-white';
                textColor = 'text-emerald-600';
            } else if (type === 'error') {
                icon = '<i class="fa-solid fa-circle-xmark"></i>';
                bgColor = 'bg-white';
                textColor = 'text-red-600';
            } else {
                icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                bgColor = 'bg-white';
                textColor = 'text-amber-500';
            }

            const toastId = 'toast-' + Math.random().toString(36).substr(2, 9);

            const toastHtml = `
                <div id="${toastId}" class="flex items-center gap-3 ${bgColor} border border-slate-200 shadow-lg rounded-xl px-4 py-3 min-w-[280px] transform transition-all duration-300 translate-y-10 opacity-0">
                    <div class="${textColor} text-xl flex-shrink-0">
                        ${icon}
                    </div>
                    <div class="flex-grow text-sm font-medium text-slate-700">
                        ${message}
                    </div>
                    <button onclick="document.getElementById('${toastId}').remove()" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', toastHtml);

            const toastElement = document.getElementById(toastId);

            // Animate in
            setTimeout(() => {
                toastElement.classList.remove('translate-y-10', 'opacity-0');
                toastElement.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // Auto remove after 3 seconds
            setTimeout(() => {
                toastElement.classList.remove('translate-y-0', 'opacity-100');
                toastElement.classList.add('translate-y-10', 'opacity-0');

                setTimeout(() => {
                    toastElement.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>