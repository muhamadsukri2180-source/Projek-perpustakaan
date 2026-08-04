<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Digital - Perpustakaan Digital</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        sky: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    animation: {
                        'gradient-x': 'gradient-x 3s ease infinite',
                    },
                    keyframes: {
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS for Animated Gradient -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Siswa Blue Gradient */
        .animated-gradient-blue {
            background: linear-gradient(270deg, #0284c7, #38bdf8, #60a5fa, #3b82f6);
            background-size: 300% 300%;
            animation: gradient-x 6s ease infinite;
        }
        
        @keyframes gradient-x {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Loading Spinner */
        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #38bdf8;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Modal Transitions */
        .modal-enter {
            opacity: 0;
            transform: scale(0.95);
        }
        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 300ms, transform 300ms;
        }
        .modal-exit {
            opacity: 1;
            transform: scale(1);
        }
        .modal-exit-active {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 300ms, transform 300ms;
        }
    </style>
</head>
<body class="bg-slate-50 flex flex-col min-h-screen text-slate-800">

    <!-- Navbar: Sticky with Siswa Blue Gradient -->
    <nav class="sticky top-0 z-40 w-full animated-gradient-blue shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left: Logo & Brand -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm border border-white/30 text-white">
                        <i class="fa-solid fa-book-open text-lg"></i>
                    </div>
                    <span class="font-bold text-xl text-white tracking-tight">Perpustakaan</span>
                </div>
                
                <!-- Middle: Navigation Links -->
                <div class="hidden md:flex items-center space-x-2">
                    <!-- Dashboard -->
                    @if(Route::has('siswa.dashboard'))
                    <a href="{{ route('siswa.dashboard') }}" class="px-4 py-2 rounded-lg text-sm transition-all duration-200 text-white/90 hover:bg-white/10 hover:text-white">
                        <i class="fa-solid fa-house mr-2"></i> Dashboard
                    </a>
                    @endif
                    
                    <!-- Buku Digital -->
                    @if(Route::has('siswa.buku'))
                    <a href="{{ route('siswa.buku') }}" class="px-4 py-2 rounded-lg text-sm transition-all duration-200 text-white/90 hover:bg-white/10 hover:text-white">
                        <i class="fa-solid fa-book mr-2"></i> Buku Digital
                    </a>
                    @endif
                    
                    <!-- buku digita (Active) -->
                    @if(Route::has('siswa.google-books'))
                    <a href="{{ route('siswa.google-books') }}" class="px-4 py-2 rounded-lg text-sm transition-all duration-200 bg-white/20 text-white font-semibold shadow-sm border border-white/30 backdrop-blur-md">
                        <i class="fa-brands fa-google mr-2"></i> Buku Digital
                    </a>
                    @endif
                    
                    <!-- Riwayat Kunjungan -->
                    @if(Route::has('siswa.riwayat'))
                    <a href="{{ route('siswa.riwayat') }}" class="px-4 py-2 rounded-lg text-sm transition-all duration-200 text-white/90 hover:bg-white/10 hover:text-white">
                        <i class="fa-solid fa-clock-rotate-left mr-2"></i> Riwayat
                    </a>
                    @endif
                </div>
                
                <!-- Right: Profile & Logout -->
                <div class="flex items-center space-x-4">
                    <!-- User Info -->
                    <div class="hidden sm:flex items-center space-x-3 bg-white/10 px-3 py-1.5 rounded-full border border-white/20 backdrop-blur-sm">
                        @php
                            $studentName = $siswa->nama ?? $siswa->name ?? 'Siswa';
                            $initial = strtoupper(substr($studentName, 0, 1));
                        @endphp
                        
                        <div class="flex flex-col text-right">
                            <span class="text-xs font-semibold text-white">{{ $studentName }}</span>
                            <span class="text-[10px] text-white/80">Siswa</span>
                        </div>
                        
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sky-600 font-bold border-2 border-white/50 shadow-sm overflow-hidden">
                            @if(isset($siswa->foto) && $siswa->foto)
                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Profile" class="w-full h-full object-cover">
                            @else
                                {{ $initial }}
                            @endif
                        </div>
                    </div>
                    
                    <!-- Logout Button -->
                    @if(Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-9 h-9 rounded-xl bg-red-500/80 hover:bg-red-600 flex items-center justify-center text-white transition-all shadow-sm border border-red-400/50" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        
        <!-- Header Section -->
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Jelajahi Buku Digital Online</h1>
            <p class="text-slate-500">Cari dan baca ribuan koleksi buku digital langsung dari Buku Digital.</p>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
            <div class="relative max-w-3xl mx-auto">
                <input type="text" id="searchInput" 
                    class="w-full pl-12 pr-16 py-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                    placeholder="Cari judul buku, penulis, atau topik..."
                    onkeypress="if(event.key === 'Enter') performSearch()">
                
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </div>
                
                <button onclick="performSearch()" id="searchBtn"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-sky-500 hover:bg-sky-600 text-white p-2.5 rounded-lg transition-colors flex items-center justify-center min-w-[44px]">
                    <i class="fa-solid fa-arrow-right" id="searchIcon"></i>
                    <div class="loader hidden" id="searchLoader"></div>
                </button>
            </div>
        </div>

        <!-- Results Section -->
        <div id="resultsArea">
            <!-- Initial State / Empty State -->
            <div id="emptyState" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center flex flex-col items-center justify-center min-h-[300px]">
                <div class="w-20 h-20 bg-sky-50 text-sky-500 rounded-full flex items-center justify-center mb-4 text-3xl">
                    <i class="fa-solid fa-book-journal-whills"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700 mb-2">Mulai Pencarian</h3>
                <p class="text-slate-500 max-w-md">Ketik kata kunci pada kotak pencarian di atas untuk menemukan buku yang ingin Anda baca.</p>
            </div>

            <!-- Error State -->
            <div id="errorState" class="hidden bg-red-50 rounded-2xl shadow-sm border border-red-100 p-8 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-4 text-2xl">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <h3 class="text-lg font-bold text-red-700 mb-2">Terjadi Kesalahan</h3>
                <p class="text-red-600" id="errorMessage">Gagal memuat data buku. Silakan coba lagi.</p>
            </div>

            <!-- Loading Skeleton (Hidden by default) -->
            <div id="loadingSkeleton" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- 3 Skeleton Cards -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-5 flex flex-col h-full animate-pulse">
                    <div class="flex gap-4">
                        <div class="w-24 h-32 bg-slate-200 rounded-lg flex-shrink-0"></div>
                        <div class="flex-1 py-1">
                            <div class="h-4 bg-slate-200 rounded w-1/3 mb-4"></div>
                            <div class="h-5 bg-slate-200 rounded w-full mb-2"></div>
                            <div class="h-4 bg-slate-200 rounded w-2/3 mb-4"></div>
                            <div class="h-3 bg-slate-200 rounded w-1/4"></div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="h-10 bg-slate-200 rounded-lg w-full"></div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-5 flex flex-col h-full animate-pulse">
                    <div class="flex gap-4">
                        <div class="w-24 h-32 bg-slate-200 rounded-lg flex-shrink-0"></div>
                        <div class="flex-1 py-1">
                            <div class="h-4 bg-slate-200 rounded w-1/3 mb-4"></div>
                            <div class="h-5 bg-slate-200 rounded w-full mb-2"></div>
                            <div class="h-4 bg-slate-200 rounded w-2/3 mb-4"></div>
                            <div class="h-3 bg-slate-200 rounded w-1/4"></div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="h-10 bg-slate-200 rounded-lg w-full"></div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-5 hidden sm:flex flex-col h-full animate-pulse">
                    <div class="flex gap-4">
                        <div class="w-24 h-32 bg-slate-200 rounded-lg flex-shrink-0"></div>
                        <div class="flex-1 py-1">
                            <div class="h-4 bg-slate-200 rounded w-1/3 mb-4"></div>
                            <div class="h-5 bg-slate-200 rounded w-full mb-2"></div>
                            <div class="h-4 bg-slate-200 rounded w-2/3 mb-4"></div>
                            <div class="h-3 bg-slate-200 rounded w-1/4"></div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="h-10 bg-slate-200 rounded-lg w-full"></div>
                    </div>
                </div>
            </div>

            <!-- Results Grid -->
            <div id="resultsGrid" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Book Cards Will Be Rendered Here -->
            </div>
            
            <!-- No Results State -->
            <div id="noResultsState" class="hidden bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mb-4 text-3xl">
                    <i class="fa-solid fa-search-minus"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700 mb-2">Buku Tidak Ditemukan</h3>
                <p class="text-slate-500">Coba gunakan kata kunci lain untuk menemukan buku.</p>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-slate-500 font-medium">
                &copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-xs text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">
                    Versi 1.0.0
                </span>
            </div>
        </div>
    </footer>

    <!-- Google Books Reader Modal -->
    <div id="readerModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background overlay with blur -->
        <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="closeReader()"></div>

        <!-- Modal panel -->
        <div class="fixed inset-4 sm:inset-6 md:inset-10 z-10 flex flex-col bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-10 h-10 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                    <div class="truncate">
                        <h3 class="text-lg font-bold text-slate-800 truncate" id="readerTitle">Judul Buku</h3>
                        <p class="text-xs text-slate-500">Buku Digital Preview</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <a id="externalLinkBtn" href="#" target="_blank" class="hidden sm:flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-sm font-medium rounded-lg border border-slate-200 transition-colors">
                        <span>Buka di Google</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                    
                    <button type="button" onclick="closeReader()" class="w-10 h-10 flex items-center justify-center bg-slate-50 hover:bg-red-50 text-slate-500 hover:text-red-500 rounded-lg transition-colors border border-slate-200 hover:border-red-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body (Iframe) -->
            <div class="flex-1 bg-slate-100 relative">
                <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 z-0">
                    <div class="loader mb-4 border-slate-200 border-top-slate-400"></div>
                    <p>Memuat buku...</p>
                </div>
                <iframe id="readerFrame" src="" class="absolute inset-0 w-full h-full z-10 bg-white" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- JavaScript for Functionality -->
    <script>
        // API Route Configuration (using route names)
        const SEARCH_ROUTE = @json(route('siswa.google-books.search') ?? '/siswa/google-books/search');
        
        // DOM Elements
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        const searchIcon = document.getElementById('searchIcon');
        const searchLoader = document.getElementById('searchLoader');
        
        // Result Areas
        const emptyState = document.getElementById('emptyState');
        const loadingSkeleton = document.getElementById('loadingSkeleton');
        const resultsGrid = document.getElementById('resultsGrid');
        const noResultsState = document.getElementById('noResultsState');
        const errorState = document.getElementById('errorState');
        const errorMessage = document.getElementById('errorMessage');
        
        // Modal Elements
        const readerModal = document.getElementById('readerModal');
        const readerFrame = document.getElementById('readerFrame');
        const readerTitle = document.getElementById('readerTitle');
        const externalLinkBtn = document.getElementById('externalLinkBtn');

        // ============================================================
        // FIX UTAMA:
        // Controller (GoogleBooksController@search) mengirim JSON dengan
        // struktur: { success, total_items, books: [ {volume_id, title,
        // author_text, short_desc, cover_url, reader_link, ...} ] }
        // BUKAN { status: 'success', data: { items: [...] } } seperti yang
        // sebelumnya diharapkan di sini. Karena itu hasil pencarian tidak
        // pernah muncul walau API-nya berhasil. Sudah disesuaikan di bawah.
        // ============================================================

        /**
         * Perform search using fetch API
         */
        async function performSearch() {
            const query = searchInput.value.trim();
            if (!query) return;

            // Update UI for loading state
            setSearchLoading(true);
            hideAllStates();
            loadingSkeleton.classList.remove('hidden');
            
            try {
                // Determine URL (handles if route expects parameters or query string)
                const url = new URL(SEARCH_ROUTE, window.location.origin);
                url.searchParams.append('q', query);
                
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                
                // Hide skeleton
                loadingSkeleton.classList.add('hidden');
                
                // Response controller: { success, total_items, books: [...] }
                if (response.ok && data.success && Array.isArray(data.books) && data.books.length > 0) {
                    renderResults(data.books);
                } else if (response.ok && data.success) {
                    // success tapi hasil kosong
                    noResultsState.classList.remove('hidden');
                } else {
                    errorMessage.textContent = data.message || 'Gagal memuat data buku. Silakan coba lagi.';
                    errorState.classList.remove('hidden');
                }
                
            } catch (error) {
                console.error("Search Error:", error);
                loadingSkeleton.classList.add('hidden');
                errorMessage.textContent = "Gagal menghubungi server pencarian. Silakan periksa koneksi Anda.";
                errorState.classList.remove('hidden');
            } finally {
                setSearchLoading(false);
            }
        }
        
        /**
         * Toggle search button loading state
         */
        function setSearchLoading(isLoading) {
            if (isLoading) {
                searchIcon.classList.add('hidden');
                searchLoader.classList.remove('hidden');
                searchBtn.disabled = true;
                searchInput.disabled = true;
                searchBtn.classList.add('opacity-80', 'cursor-not-allowed');
            } else {
                searchIcon.classList.remove('hidden');
                searchLoader.classList.add('hidden');
                searchBtn.disabled = false;
                searchInput.disabled = false;
                searchBtn.classList.remove('opacity-80', 'cursor-not-allowed');
            }
        }
        
        /**
         * Hide all content states in the results area
         */
        function hideAllStates() {
            emptyState.classList.add('hidden');
            loadingSkeleton.classList.add('hidden');
            resultsGrid.classList.add('hidden');
            noResultsState.classList.add('hidden');
            errorState.classList.add('hidden');
        }

        /**
         * Render book cards into the grid
         * book mengikuti struktur dari controller:
         * { volume_id, title, authors, author_text, publisher, published_date,
         *   description, short_desc, categories, page_count, cover_url,
         *   preview_link, reader_link, embeddable, viewability, info_link }
         */
        function renderResults(books) {
            resultsGrid.innerHTML = '';
            
            books.forEach(book => {
                const volumeId = book.volume_id;
                
                // Extract Info with fallbacks
                const title = book.title || 'Tanpa Judul';
                const author = book.author_text || 'Penulis Tidak Diketahui';
                const shortDesc = book.short_desc || 'Tidak ada deskripsi tersedia.';
                const pageCount = book.page_count || 0;
                
                // Categories formatting
                let categoryBadge = '';
                if (Array.isArray(book.categories) && book.categories.length > 0) {
                    categoryBadge = `<span class="inline-block px-2.5 py-1 bg-sky-50 text-sky-600 text-[10px] font-bold rounded-full mb-2 uppercase tracking-wide border border-sky-100">${book.categories[0]}</span>`;
                }
                
                // Image & link handling (sudah diproses di controller: https, placeholder fallback)
                const coverImage = book.cover_url || 'https://via.placeholder.com/128x192.png?text=No+Cover';
                const readerLink = book.reader_link || book.preview_link || `https://books.google.co.id/books?id=${volumeId}`;
                
                const safeTitle = title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                
                // Construct Card HTML (READ ONLY - NO SAVE BUTTON)
                const cardHTML = `
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col group h-full">
                        <div class="p-5 flex gap-4 flex-grow">
                            <!-- Cover Image -->
                            <div class="w-24 h-32 bg-slate-100 rounded-lg flex-shrink-0 overflow-hidden shadow-sm border border-slate-200 relative group-hover:shadow-md transition-all">
                                <img src="${coverImage}" alt="Cover ${title}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fa-solid fa-book-open text-white"></i>
                                </div>
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 flex flex-col min-w-0">
                                ${categoryBadge}
                                <h3 class="text-base font-bold text-slate-800 leading-tight mb-1 line-clamp-2" title="${title}">
                                    ${title}
                                </h3>
                                <p class="text-xs text-sky-600 font-medium mb-2 truncate">
                                    <i class="fa-solid fa-pen-nib mr-1"></i> ${author}
                                </p>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-2 flex-grow">
                                    ${shortDesc}
                                </p>
                                <div class="flex items-center text-[11px] text-slate-400 mt-auto">
                                    <i class="fa-regular fa-file-lines mr-1.5"></i>
                                    ${pageCount} Halaman
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Area (READ ONLY) -->
                        <div class="px-5 py-4 border-t border-slate-50 bg-slate-50/50">
                            <button onclick="openReader('${volumeId}', '${safeTitle}', '${readerLink}')" 
                                class="w-full bg-sky-50 hover:bg-sky-500 text-sky-600 hover:text-white px-4 py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center justify-center shadow-sm border border-sky-100 hover:border-sky-500">
                                <i class="fa-solid fa-book-open-reader mr-2"></i> Baca Buku
                            </button>
                        </div>
                    </div>
                `;
                
                resultsGrid.insertAdjacentHTML('beforeend', cardHTML);
            });
            
            resultsGrid.classList.remove('hidden');
        }

        /**
         * Open Google Books embedded reader in modal
         */
        function openReader(volumeId, title, previewLink) {
            // Set modal info
            readerTitle.textContent = title.replace(/\\'/g, "'");
            externalLinkBtn.href = previewLink;
            
            // Set iframe src for embedded reader
            // This URL structure uses the embedded viewer format
            readerFrame.src = `https://books.google.com/books?id=${volumeId}&lpg=PP1&pg=PP1&output=embed`;
            
            // Show modal
            readerModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        /**
         * Close the reader modal
         */
        function closeReader() {
            readerModal.classList.add('hidden');
            readerFrame.src = ''; // Clear iframe to stop loading/playing
            document.body.style.overflow = ''; // Restore scrolling
        }
        
        // Listen for ESC key to close modal
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !readerModal.classList.contains('hidden')) {
                closeReader();
            }
        });
    </script>
</body>
</html>