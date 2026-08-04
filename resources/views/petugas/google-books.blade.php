<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Books - Panel Petugas</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards',
                        'slide-in-right': 'slideInRight 0.4s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideInRight: {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
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
            height: 8px;
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

        /* Horizontal scrolling carousels for recommendations */
        .genre-scroll {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 0.75rem;
            -webkit-overflow-scrolling: touch;
        }
        .genre-scroll::-webkit-scrollbar {
            height: 6px;
        }
        .genre-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .genre-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .genre-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .book-card-carousel {
            min-width: 220px;
            max-width: 220px;
            flex-shrink: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .book-card-carousel:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        }

        .genre-chip {
            transition: all 0.3s ease;
        }
        .genre-chip.active {
            background: linear-gradient(135deg, #047857, #10b981);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(4, 120, 87, 0.35);
        }
        .genre-chip:not(.active):hover {
            background: #ecfdf5;
            border-color: #a7f3d0;
            color: #047857;
        }

        .scroll-btn {
            transition: all 0.2s ease;
        }
        .scroll-btn:hover {
            transform: scale(1.1);
        }
        .scroll-btn:active {
            transform: scale(0.95);
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton-shimmer {
            background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
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
                            placeholder="Cari judul buku, penulis, atau topik..." required minlength="2">
                        <button type="submit" 
                            class="absolute right-2 top-2 bottom-2 bg-petugas-600 hover:bg-petugas-700 text-white font-medium px-6 rounded-lg transition-colors shadow-sm flex items-center gap-2">
                            <span>Cari</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Loading Indicator for Search -->
            <div id="search-loading" class="hidden py-12 flex flex-col items-center justify-center">
                <div class="w-12 h-12 border-4 border-petugas-200 border-t-petugas-600 rounded-full animate-spin mb-4"></div>
                <p class="text-slate-500 font-medium">Mencari buku di Google Books...</p>
            </div>

            <!-- ============================================ -->
            <!-- RECOMMENDATIONS AREA (Server-Side Rendered)  -->
            <!-- ============================================ -->
            <div id="recommendationsArea">

                @php
                $genreMeta = [
                    'fiction'   => ['label' => 'Fiksi Populer',      'icon' => 'fa-book-open',  'iconBg' => 'bg-rose-100 text-rose-600',     'chip_icon' => 'fa-book-open',  'chip_label' => 'Fiksi'],
                    'science'   => ['label' => 'Sains & Teknologi',  'icon' => 'fa-flask',      'iconBg' => 'bg-cyan-100 text-cyan-600',     'chip_icon' => 'fa-flask',      'chip_label' => 'Sains & Teknologi'],
                    'history'   => ['label' => 'Sejarah',            'icon' => 'fa-landmark',   'iconBg' => 'bg-amber-100 text-amber-600',   'chip_icon' => 'fa-landmark',   'chip_label' => 'Sejarah'],
                    'art'       => ['label' => 'Seni & Desain',      'icon' => 'fa-palette',    'iconBg' => 'bg-violet-100 text-violet-600', 'chip_icon' => 'fa-palette',    'chip_label' => 'Seni & Desain'],
                    'business'  => ['label' => 'Bisnis & Ekonomi',   'icon' => 'fa-briefcase',  'iconBg' => 'bg-emerald-100 text-emerald-600','chip_icon' => 'fa-briefcase', 'chip_label' => 'Bisnis'],
                    'self-help' => ['label' => 'Pengembangan Diri',  'icon' => 'fa-brain',      'iconBg' => 'bg-sky-100 text-sky-600',       'chip_icon' => 'fa-brain',      'chip_label' => 'Pengembangan Diri'],
                ];
                $availableGenres = array_keys($recommendations ?? []);
                @endphp

                <!-- Genre Chips / Pills -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                            <i class="fa-solid fa-compass text-petugas-600"></i> Rekomendasi Genre
                        </h2>
                    </div>
                    <div class="flex flex-wrap gap-2" id="genreChips">
                        <button onclick="filterGenre('all')" class="genre-chip active px-4 py-2 rounded-full text-xs font-bold border border-slate-200 bg-white text-slate-600 flex items-center gap-2" data-genre="all">
                            <i class="fa-solid fa-layer-group"></i> Semua Genre
                        </button>
                        @foreach($availableGenres as $gKey)
                        @php $gMeta = $genreMeta[$gKey] ?? ['chip_icon'=>'fa-book','chip_label'=>$gKey]; @endphp
                        <button onclick="filterGenre('{{ $gKey }}')" class="genre-chip px-4 py-2 rounded-full text-xs font-bold border border-slate-200 bg-white text-slate-600 flex items-center gap-2" data-genre="{{ $gKey }}">
                            <i class="fa-solid {{ $gMeta['chip_icon'] }}"></i> {{ $gMeta['chip_label'] }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Genre Sections - Server-side rendered -->
                @if(!empty($recommendations))
                <div id="genreSections" class="space-y-6">
                    @foreach($recommendations as $genreKey => $books)
                    @php
                        $meta = $genreMeta[$genreKey] ?? ['label'=>$genreKey,'icon'=>'fa-book','iconBg'=>'bg-slate-100 text-slate-600'];
                        $sectionId = 'genre-section-' . $genreKey;
                    @endphp
                    <div id="{{ $sectionId }}" class="genre-section bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" data-genre="{{ $genreKey }}">
                        <div class="p-4 sm:p-5 pb-2 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg {{ $meta['iconBg'] }} flex items-center justify-center text-sm">
                                    <i class="fa-solid {{ $meta['icon'] }}"></i>
                                </div>
                                <h3 class="font-bold text-slate-800 text-sm">{{ $meta['label'] }}</h3>
                            </div>
                            <div class="flex items-center gap-1">
                                <button onclick="scrollGenre('{{ $sectionId }}', 'left')" class="scroll-btn w-7 h-7 rounded-lg bg-slate-100 hover:bg-petugas-50 text-slate-500 hover:text-petugas-600 flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                                </button>
                                <button onclick="scrollGenre('{{ $sectionId }}', 'right')" class="scroll-btn w-7 h-7 rounded-lg bg-slate-100 hover:bg-petugas-50 text-slate-500 hover:text-petugas-600 flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                        <div class="px-4 sm:px-5 pb-4">
                            <div class="genre-scroll" id="scroll-{{ $sectionId }}">
                                @foreach($books as $book)
                                @php
                                    $volId    = $book['volume_id'];
                                    $jsTitle  = addslashes($book['title']);
                                    $jsAuthor = addslashes($book['author_text']);
                                    $jsCat    = addslashes($book['category']);
                                    $jsCover  = addslashes($book['cover_url'] ?? '');
                                    $jsReader = addslashes($book['reader_link'] ?? '');
                                @endphp
                                <div class="book-card-carousel bg-white rounded-xl overflow-hidden border border-slate-200 flex flex-col">
                                    <div class="h-44 bg-slate-100 overflow-hidden relative flex items-center justify-center cursor-pointer"
                                         onclick="openReader('{{ $volId }}', '{{ $jsTitle }}', '{{ $jsReader }}')">
                                        @if(!empty($book['cover_url']))
                                            <img src="{{ $book['cover_url'] }}" alt="Cover" class="h-full w-full object-cover" loading="lazy">
                                        @else
                                            <i class="fa-solid fa-book text-3xl text-slate-300"></i>
                                        @endif
                                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm text-slate-700 text-[10px] font-bold px-2 py-0.5 rounded shadow-sm border border-slate-200">
                                            {{ Str::limit($book['category'], 12) }}
                                        </div>
                                    </div>
                                    <div class="p-3.5 flex-grow flex flex-col">
                                        <h4 class="font-bold text-slate-800 text-sm mb-1 line-clamp-2 leading-tight">{{ e($book['title']) }}</h4>
                                        <p class="text-[11px] text-slate-500 font-medium truncate mb-3"><i class="fa-solid fa-pen-nib text-[9px] mr-1"></i> {{ e($book['author_text']) }}</p>
                                        <div class="grid grid-cols-2 gap-1.5 mt-auto">
                                            <button onclick="openReader('{{ $volId }}', '{{ $jsTitle }}', '{{ $jsReader }}')" class="bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white py-1.5 px-2 rounded-lg text-xs font-semibold transition-colors flex items-center justify-center gap-1 border border-emerald-100 shadow-sm">
                                                <i class="fa-solid fa-book-open text-[10px]"></i> Baca
                                            </button>
                                            <button onclick="saveBook('{{ $volId }}', '{{ $jsTitle }}', '{{ $jsAuthor }}', '{{ $jsCat }}', '{{ $jsCover }}', '{{ $jsReader }}')" class="bg-petugas-600 hover:bg-petugas-700 text-white py-1.5 px-2 rounded-lg text-xs font-semibold transition-colors flex items-center justify-center gap-1 shadow-sm">
                                                <i class="fa-solid fa-bookmark text-[10px]"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-10 text-center">
                    <i class="fa-solid fa-book-open text-4xl text-slate-300 mb-3"></i>
                    <p class="text-slate-500 font-medium">Rekomendasi buku tidak tersedia saat ini.</p>
                    <p class="text-slate-400 text-sm mt-1">Coba cari buku menggunakan kolom pencarian di atas.</p>
                </div>
                @endif
            </div>

            <!-- ============================================ -->
            <!-- SEARCH RESULTS AREA                          -->
            <!-- ============================================ -->
            <div id="searchResultsArea" class="hidden">
                <div class="mb-4 flex items-center justify-between">
                    <button onclick="backToRecommendations()" class="flex items-center gap-2 text-sm font-semibold text-petugas-600 hover:text-petugas-700 transition-colors group">
                        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                        Kembali ke Rekomendasi
                    </button>
                    <span id="searchResultCount" class="text-sm text-slate-500"></span>
                </div>

                <!-- Search Results Grid -->
                <div id="search-results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Results will be injected here via JS -->
                </div>
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
            search: "{{ Route::has('petugas.google-books.search') ? route('petugas.google-books.search', [], false) : '/petugas/google-books/search' }}",
            store: "{{ Route::has('petugas.google-books.store') ? route('petugas.google-books.store', [], false) : '/petugas/google-books' }}",
            delete: "/petugas/google-books",
            recs: "{{ Route::has('petugas.google-books.recommendations') ? route('petugas.google-books.recommendations', [], false) : '/petugas/google-books/recommendations' }}"
        };

        const GENRES = [
            { key: 'fiction',   label: 'Fiksi Populer',       icon: 'fa-book-open',  gradient: 'from-rose-500 to-pink-600',    iconBg: 'bg-rose-100 text-rose-600' },
            { key: 'science',   label: 'Sains & Teknologi',   icon: 'fa-flask',      gradient: 'from-cyan-500 to-blue-600',    iconBg: 'bg-cyan-100 text-cyan-600' },
            { key: 'history',   label: 'Sejarah',             icon: 'fa-landmark',   gradient: 'from-amber-500 to-orange-600', iconBg: 'bg-amber-100 text-amber-600' },
            { key: 'art',       label: 'Seni & Desain',       icon: 'fa-palette',    gradient: 'from-violet-500 to-purple-600',iconBg: 'bg-violet-100 text-violet-600' },
            { key: 'business',  label: 'Bisnis & Ekonomi',    icon: 'fa-briefcase',  gradient: 'from-emerald-500 to-green-600',iconBg: 'bg-emerald-100 text-emerald-600' },
            { key: 'self-help', label: 'Pengembangan Diri',   icon: 'fa-brain',      gradient: 'from-sky-500 to-indigo-600',   iconBg: 'bg-sky-100 text-sky-600' },
        ];

        const genreCache = {};

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

        // ============================================================
        // RECOMMENDATIONS SYSTEM
        // ============================================================
        async function loadAllRecommendations() {
            const loading = document.getElementById('recsLoading');
            const sections = document.getElementById('genreSections');

            loading.classList.remove('hidden');
            sections.innerHTML = '';

            for (let i = 0; i < GENRES.length; i++) {
                const genre = GENRES[i];
                await loadGenreRecommendation(genre, i);
            }

            loading.classList.add('hidden');
        }

        async function loadGenreRecommendation(genre, index) {
            if (genreCache[genre.key]) {
                renderGenreSection(genre, genreCache[genre.key], index);
                return;
            }

            try {
                const url = new URL(routes.recs, window.location.origin);
                url.searchParams.append('genre', genre.key);

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success && Array.isArray(data.books) && data.books.length > 0) {
                    genreCache[genre.key] = data.books;
                    renderGenreSection(genre, data.books, index);
                }
            } catch (error) {
                console.error(`Failed to load genre ${genre.key}:`, error);
            }
        }

        function renderGenreSection(genre, books, index) {
            const sectionId = `genre-section-${genre.key}`;
            
            let cardsHTML = '';
            books.forEach((book, cardIndex) => {
                const coverImage = book.cover_url || '';
                const safeTitle = (book.title || 'Tanpa Judul').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const author = book.author_text || 'Penulis tidak diketahui';
                const safeAuthor = author.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const category = (Array.isArray(book.categories) && book.categories.length > 0) ? book.categories[0] : 'Umum';
                const safeCategory = category.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const safeCover = coverImage.replace(/'/g, "\\'");
                const readerLink = book.reader_link || book.preview_link || '';
                const safeReader = readerLink.replace(/'/g, "\\'");

                cardsHTML += `
                    <div class="book-card-carousel bg-white rounded-xl overflow-hidden border border-slate-200 flex flex-col opacity-0 animate-slide-in-right" style="animation-delay: ${cardIndex * 0.05}s">
                        <div class="h-44 bg-slate-100 overflow-hidden relative flex items-center justify-center cursor-pointer" onclick="openReader('${book.volume_id}', '${safeTitle}', '${safeReader}')">
                            ${coverImage ? `<img src="${coverImage}" alt="Cover" class="h-full w-full object-cover">` : `<i class="fa-solid fa-book text-3xl text-slate-300"></i>`}
                            <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm text-slate-700 text-[10px] font-bold px-2 py-0.5 rounded shadow-sm border border-slate-200">
                                ${category.split(' ')[0]}
                            </div>
                        </div>
                        <div class="p-3.5 flex-grow flex flex-col">
                            <h4 class="font-bold text-slate-800 text-sm mb-1 line-clamp-2 leading-tight" title="${book.title}">${book.title}</h4>
                            <p class="text-[11px] text-slate-500 font-medium truncate mb-3"><i class="fa-solid fa-pen-nib text-[9px] mr-1 opacity-70"></i> ${author}</p>
                            
                            <div class="grid grid-cols-2 gap-1.5 mt-auto">
                                <button onclick="openReader('${book.volume_id}', '${safeTitle}', '${safeReader}')" class="bg-petugas-50 hover:bg-petugas-600 text-petugas-700 hover:text-white py-1.5 px-2 rounded-lg text-xs font-semibold transition-colors flex items-center justify-center gap-1 border border-petugas-100 hover:border-petugas-600 shadow-sm">
                                    <i class="fa-solid fa-book-open-reader text-[10px]"></i> Baca
                                </button>
                                <button onclick="saveBook('${book.volume_id}', '${safeTitle}', '${safeAuthor}', '${safeCategory}', '${safeCover}', '${safeReader}')" class="bg-petugas-600 hover:bg-petugas-700 text-white py-1.5 px-2 rounded-lg text-xs font-semibold transition-colors flex items-center justify-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-bookmark text-[10px]"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            const sectionHTML = `
                <div id="${sectionId}" class="genre-section bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden animate-slide-up" data-genre="${genre.key}" style="animation-delay: ${index * 0.08}s">
                    <div class="p-4 sm:p-5 pb-2 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg ${genre.iconBg} flex items-center justify-center text-sm">
                                <i class="fa-solid ${genre.icon}"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">${genre.label}</h3>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button onclick="scrollGenre('${sectionId}', 'left')" class="scroll-btn w-7 h-7 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            </button>
                            <button onclick="scrollGenre('${sectionId}', 'right')" class="scroll-btn w-7 h-7 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                    <div class="px-4 sm:px-5 pb-4">
                        <div class="genre-scroll" id="scroll-${sectionId}">
                            ${cardsHTML}
                        </div>
                    </div>
                </div>
            `;

            sections.insertAdjacentHTML('beforeend', sectionHTML);
        }

        function scrollGenre(sectionId, direction) {
            const scrollContainer = document.getElementById(`scroll-${sectionId}`);
            if (!scrollContainer) return;
            const scrollAmount = 400;
            scrollContainer.scrollBy({
                left: direction === 'right' ? scrollAmount : -scrollAmount,
                behavior: 'smooth'
            });
        }

        function filterGenre(genreKey) {
            document.querySelectorAll('.genre-chip').forEach(chip => {
                if (chip.dataset.genre === genreKey) {
                    chip.classList.add('active');
                } else {
                    chip.classList.remove('active');
                }
            });

            document.querySelectorAll('.genre-section').forEach(section => {
                if (genreKey === 'all' || section.dataset.genre === genreKey) {
                    section.style.display = '';
                    section.classList.add('animate-fade-in');
                } else {
                    section.style.display = 'none';
                    section.classList.remove('animate-fade-in');
                }
            });
        }

        function backToRecommendations() {
            document.getElementById('searchResultsArea').classList.add('hidden');
            document.getElementById('recommendationsArea').classList.remove('hidden');
            document.getElementById('search-input').value = '';
            document.getElementById('searchResultCount').textContent = '';
        }

        // --- SEARCH GOOGLE BOOKS ---
        async function searchBooks(event) {
            event.preventDefault();
            const query = document.getElementById('search-input').value.trim();
            if (!query || query.length < 2) {
                showToast('Kata kunci minimal 2 karakter.', 'error');
                return;
            }

            document.getElementById('recommendationsArea').classList.add('hidden');
            document.getElementById('searchResultsArea').classList.remove('hidden');

            const resultsContainer = document.getElementById('search-results');
            const loadingIndicator = document.getElementById('search-loading');

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
                    document.getElementById('searchResultCount').textContent = `${data.books.length} buku ditemukan untuk "${query}"`;
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

        document.addEventListener('DOMContentLoaded', () => {
            loadAllRecommendations();
        });
    </script>
</body>
</html>