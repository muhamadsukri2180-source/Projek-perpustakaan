<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Digital - Perpustakaan Digital</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards',
                        'slide-in-right': 'slideInRight 0.4s ease-out forwards',
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
                        },
                        'fadeIn': {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        'slideUp': {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        'slideInRight': {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
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

        /* Horizontal Scroll Container */
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

        /* Book card in carousel */
        .book-card-carousel {
            min-width: 200px;
            max-width: 200px;
            flex-shrink: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .book-card-carousel:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        }

        /* Genre chip active */
        .genre-chip {
            transition: all 0.3s ease;
        }
        .genre-chip.active {
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        }
        .genre-chip:not(.active):hover {
            background: #f0f9ff;
            border-color: #7dd3fc;
            color: #0284c7;
        }

        /* Stagger animation for cards */
        .book-card-carousel:nth-child(1) { animation-delay: 0.05s; }
        .book-card-carousel:nth-child(2) { animation-delay: 0.1s; }
        .book-card-carousel:nth-child(3) { animation-delay: 0.15s; }
        .book-card-carousel:nth-child(4) { animation-delay: 0.2s; }
        .book-card-carousel:nth-child(5) { animation-delay: 0.25s; }
        .book-card-carousel:nth-child(6) { animation-delay: 0.3s; }
        .book-card-carousel:nth-child(7) { animation-delay: 0.35s; }
        .book-card-carousel:nth-child(8) { animation-delay: 0.4s; }

        /* Scroll button */
        .scroll-btn {
            transition: all 0.2s ease;
        }
        .scroll-btn:hover {
            transform: scale(1.1);
        }
        .scroll-btn:active {
            transform: scale(0.95);
        }

        /* Skeleton shimmer */
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    
                    <!-- Google Books (Active) -->
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
        
        <!-- Header Section with Gradient Banner -->
        <div class="mb-8 bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-sky-200/50 relative overflow-hidden">
            <div class="relative z-10">
                <span class="bg-white/20 text-sky-100 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-semibold border border-white/20 mb-3 inline-block">
                    <i class="fa-brands fa-google mr-1"></i> Google Books API
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">Jelajahi Buku Digital Online</h1>
                <p class="text-sky-100 text-sm max-w-xl leading-relaxed">
                    Cari dan baca ribuan koleksi buku digital dari berbagai genre langsung dari Google Books.
                </p>
            </div>
            <i class="fa-solid fa-book-open-reader text-white/10 text-9xl absolute -right-4 -bottom-8 pointer-events-none"></i>
        </div>
        <!-- Tabs -->
        <div class="bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200 inline-flex mb-8 w-full sm:w-auto">
            <button onclick="switchTab('explore')" id="tab-explore" class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all bg-sky-50 text-sky-700 shadow-sm border border-sky-100">
                <i class="fa-solid fa-compass mr-2"></i> Jelajahi Buku
            </button>
            <button onclick="switchTab('koleksi')" id="tab-koleksi" class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all text-slate-500 hover:text-slate-700 hover:bg-slate-50">
                <i class="fa-solid fa-bookmark mr-2"></i> Koleksi Bacaan
            </button>
        </div>

        <!-- ============================================ -->
        <!-- SECTION EXPLORE                              -->
        <!-- ============================================ -->
        <div id="section-explore">

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

        <!-- ============================================ -->
        <!-- RECOMMENDATIONS SECTION (Server-Side)        -->
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
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-compass text-sky-500"></i> Jelajahi Genre
                    </h2>
                </div>
                <div class="flex flex-wrap gap-2 sm:gap-3" id="genreChips">
                    <button onclick="filterGenre('all')" class="genre-chip active px-4 py-2 rounded-full text-sm font-semibold border border-slate-200 bg-white text-slate-600 flex items-center gap-2" data-genre="all">
                        <i class="fa-solid fa-layer-group text-xs"></i> Semua Genre
                    </button>
                    @foreach($availableGenres as $gKey)
                    @php $gMeta = $genreMeta[$gKey] ?? ['chip_icon'=>'fa-book','chip_label'=>$gKey]; @endphp
                    <button onclick="filterGenre('{{ $gKey }}')" class="genre-chip px-4 py-2 rounded-full text-sm font-semibold border border-slate-200 bg-white text-slate-600 flex items-center gap-2" data-genre="{{ $gKey }}">
                        <i class="fa-solid {{ $gMeta['chip_icon'] }} text-xs"></i> {{ $gMeta['chip_label'] }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Genre Sections - Server-side rendered -->
            @if(!empty($recommendations))
            <div id="genreSections" class="space-y-8">
                @foreach($recommendations as $genreKey => $books)
                @php
                    $meta = $genreMeta[$genreKey] ?? ['label'=>$genreKey,'icon'=>'fa-book','iconBg'=>'bg-slate-100 text-slate-600'];
                    $sectionId = 'genre-section-' . $genreKey;
                @endphp
                <div id="{{ $sectionId }}" class="genre-section bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" data-genre="{{ $genreKey }}">
                    <div class="p-4 sm:p-5 pb-2 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl {{ $meta['iconBg'] }} flex items-center justify-center">
                                <i class="fa-solid {{ $meta['icon'] }} text-sm"></i>
                            </div>
                            <h3 class="font-bold text-slate-800">{{ $meta['label'] }}</h3>
                        </div>
                        <div class="flex items-center gap-1">
                            <button onclick="scrollGenre('{{ $sectionId }}', 'left')" class="scroll-btn w-8 h-8 rounded-lg bg-slate-100 hover:bg-sky-50 text-slate-500 hover:text-sky-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <button onclick="scrollGenre('{{ $sectionId }}', 'right')" class="scroll-btn w-8 h-8 rounded-lg bg-slate-100 hover:bg-sky-50 text-slate-500 hover:text-sky-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <div class="px-4 sm:px-5 pb-5">
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
                                <div class="h-48 bg-slate-100 overflow-hidden relative flex items-center justify-center cursor-pointer"
                                     onclick="openReader('{{ $volId }}', '{{ $jsTitle }}', '{{ $jsReader }}')">
                                    @if(!empty($book['cover_url']))
                                        <img src="{{ $book['cover_url'] }}" alt="Cover" class="h-full w-full object-cover" loading="lazy">
                                    @else
                                        <i class="fa-solid fa-book text-4xl text-slate-300"></i>
                                    @endif
                                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm text-slate-700 text-[10px] font-bold px-2 py-0.5 rounded shadow-sm border border-slate-200">
                                        {{ Str::limit($book['category'], 12) }}
                                    </div>
                                </div>
                                <div class="p-3.5 flex-grow flex flex-col">
                                    <h4 class="font-bold text-slate-800 text-sm mb-1 line-clamp-2 leading-tight">{{ e($book['title']) }}</h4>
                                    <p class="text-[11px] text-slate-500 font-medium truncate mb-3"><i class="fa-solid fa-pen-nib text-[9px] mr-1"></i> {{ e($book['author_text']) }}</p>
                                    <div class="grid grid-cols-2 gap-1.5 mt-auto">
                                        <button onclick="openReader('{{ $volId }}', '{{ $jsTitle }}', '{{ $jsReader }}')" class="bg-sky-50 hover:bg-sky-500 text-sky-600 hover:text-white py-2 px-2 rounded-lg text-[10px] font-semibold transition-colors flex items-center justify-center gap-1 border border-sky-100 hover:border-sky-500 shadow-sm">
                                            <i class="fa-solid fa-book-open"></i> Baca
                                        </button>
                                        <button onclick="addToKoleksi('{{ $volId }}', '{{ $jsTitle }}', '{{ $jsAuthor }}', '{{ $jsCat }}', '{{ $jsCover }}', '{{ $jsReader }}', {{ $book['page_count'] ?? 0 }})" class="bg-slate-50 hover:bg-slate-200 text-slate-600 py-2 px-2 rounded-lg text-[10px] font-semibold transition-colors flex items-center justify-center gap-1 border border-slate-200 shadow-sm">
                                            <i class="fa-solid fa-plus"></i> Koleksi
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
        <!-- SEARCH RESULTS SECTION (Hidden by default)   -->
        <!-- ============================================ -->
        <div id="searchResultsArea" class="hidden">
            <!-- Back to Recommendations Button -->
            <div class="mb-4 flex items-center justify-between">
                <button onclick="backToRecommendations()" class="flex items-center gap-2 text-sm font-semibold text-sky-600 hover:text-sky-700 transition-colors group">
                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    Kembali ke Rekomendasi
                </button>
                <span id="searchResultCount" class="text-sm text-slate-500"></span>
            </div>

            <!-- Error State -->
            <div id="errorState" class="hidden bg-red-50 rounded-2xl shadow-sm border border-red-100 p-8 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-4 text-2xl">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <h3 class="text-lg font-bold text-red-700 mb-2">Terjadi Kesalahan</h3>
                <p class="text-red-600" id="errorMessage">Gagal memuat data buku. Silakan coba lagi.</p>
            </div>

            <!-- Loading Skeleton for Search -->
            <div id="loadingSkeleton" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
        </div> <!-- End of section-explore -->

        <!-- ============================================ -->
        <!-- SECTION KOLEKSI                              -->
        <!-- ============================================ -->
        <div id="section-koleksi" class="hidden">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-bookmark text-sky-500"></i> Koleksi Bacaan Saya
                </h2>
                <span class="text-sm text-slate-500">{{ isset($koleksiBacaan) ? $koleksiBacaan->count() : 0 }} Buku</span>
            </div>

            @if(isset($koleksiBacaan) && $koleksiBacaan->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($koleksiBacaan as $koleksi)
                        @php
                            $jsTitle = addslashes($koleksi->judul_buku);
                            $jsReader = addslashes($koleksi->reader_link ?? '');
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                            <div class="p-4 flex gap-4">
                                <!-- Cover -->
                                <div class="w-24 h-36 flex-shrink-0 bg-slate-100 rounded-lg overflow-hidden relative cursor-pointer" onclick="openReader('{{ $koleksi->volume_id }}', '{{ $jsTitle }}', '{{ $jsReader }}')">
                                    @if($koleksi->cover_url)
                                        <img src="{{ $koleksi->cover_url }}" alt="Cover {{ $koleksi->judul_buku }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fa-solid fa-book text-3xl text-slate-300"></i>
                                        </div>
                                    @endif
                                    @php
                                        $statusColors = [
                                            'belum_dibaca'  => '#64748b',
                                            'sedang_dibaca' => '#0ea5e9',
                                            'selesai'       => '#10b981',
                                        ];
                                        $badgeColor = $statusColors[$koleksi->status] ?? '#64748b';
                                    @endphp
                                    <div class="absolute top-0 right-0 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-bl-lg shadow-sm" style="background-color: {{ $badgeColor }}">
                                        {{ $koleksi->status_label }}
                                    </div>
                                </div>
                                
                                <!-- Info -->
                                <div class="flex-grow min-w-0 flex flex-col">
                                    <h3 class="text-sm font-bold text-slate-800 leading-tight mb-1 line-clamp-2" title="{{ $koleksi->judul_buku }}">{{ $koleksi->judul_buku }}</h3>
                                    <p class="text-xs text-slate-500 mb-2 truncate"><i class="fa-solid fa-pen-nib mr-1"></i>{{ $koleksi->penulis }}</p>
                                    
                                    <div class="mt-auto">
                                        <div class="flex justify-between items-end mb-1">
                                            <span class="text-[10px] text-slate-500 font-medium">Hal. {{ $koleksi->halaman_terakhir }} / {{ $koleksi->total_halaman > 0 ? $koleksi->total_halaman : '?' }}</span>
                                            <span class="text-[10px] font-bold" style="color: {{ $badgeColor }}">{{ $koleksi->persentase_baca }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-1.5 rounded-full transition-all duration-500" style="width: {{ $koleksi->persentase_baca }}%; background-color: {{ $badgeColor }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/50 flex flex-wrap gap-2">
                                <button onclick="openReader('{{ $koleksi->volume_id }}', '{{ $jsTitle }}', '{{ $jsReader }}')" class="flex-1 bg-sky-50 hover:bg-sky-500 text-sky-600 hover:text-white text-xs font-semibold py-2 px-2 rounded-lg transition-colors border border-sky-100 hover:border-sky-500 flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-book-open"></i> Baca
                                </button>
                                <button onclick="openUpdateModal({{ $koleksi->id }}, {{ $koleksi->halaman_terakhir }}, {{ $koleksi->total_halaman }})" class="flex-1 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 text-xs font-semibold py-2 px-2 rounded-lg transition-colors flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-pen"></i> Progres
                                </button>
                                <button onclick="deleteKoleksi({{ $koleksi->id }})" class="bg-white hover:bg-red-50 text-red-500 border border-slate-200 hover:border-red-200 text-xs py-2 px-3 rounded-lg transition-colors">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-100 border-dashed shadow-sm p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4 text-3xl">
                        <i class="fa-solid fa-bookmark"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700 mb-2">Koleksi Masih Kosong</h3>
                    <p class="text-slate-500 max-w-sm mb-6">Anda belum menambahkan buku ke koleksi bacaan. Jelajahi buku dan klik tombol "+ Koleksi".</p>
                    <button onclick="switchTab('explore')" class="bg-sky-500 hover:bg-sky-600 text-white px-6 py-2.5 rounded-xl font-medium transition-colors">
                        Mulai Jelajahi
                    </button>
                </div>
            @endif
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

    <!-- Update Progres Modal -->
    <div id="updateProgresModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="closeUpdateModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-sky-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fa-solid fa-book-open text-sky-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-slate-900" id="modal-title">Update Progres Membaca</h3>
                                <div class="mt-4">
                                    <form id="formUpdateProgres" onsubmit="submitUpdateProgres(event)">
                                        <input type="hidden" id="update_koleksi_id">
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-slate-700 mb-1">Halaman Terakhir Dibaca</label>
                                            <input type="number" id="update_halaman_terakhir" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Halaman Buku</label>
                                            <input type="number" id="update_total_halaman" min="1" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                                        </div>
                                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                            <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 sm:ml-3 sm:w-auto">Simpan Progres</button>
                                            <button type="button" onclick="closeUpdateModal()" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Functionality -->
    <script>
        // ============================================================
        // CONFIGURATION
        // ============================================================
        const SEARCH_ROUTE = "{{ route('siswa.google-books.search', [], false) }}";
        const RECS_ROUTE   = "{{ route('siswa.google-books.recommendations', [], false) }}";

        // Genre definitions with metadata for UI
        const GENRES = [
            { key: 'fiction',   label: 'Fiksi Populer',       icon: 'fa-book-open',  gradient: 'from-rose-500 to-pink-600',    iconBg: 'bg-rose-100 text-rose-600' },
            { key: 'science',   label: 'Sains & Teknologi',   icon: 'fa-flask',      gradient: 'from-cyan-500 to-blue-600',    iconBg: 'bg-cyan-100 text-cyan-600' },
            { key: 'history',   label: 'Sejarah',             icon: 'fa-landmark',   gradient: 'from-amber-500 to-orange-600', iconBg: 'bg-amber-100 text-amber-600' },
            { key: 'art',       label: 'Seni & Desain',       icon: 'fa-palette',    gradient: 'from-violet-500 to-purple-600',iconBg: 'bg-violet-100 text-violet-600' },
            { key: 'business',  label: 'Bisnis & Ekonomi',    icon: 'fa-briefcase',  gradient: 'from-emerald-500 to-green-600',iconBg: 'bg-emerald-100 text-emerald-600' },
            { key: 'self-help', label: 'Pengembangan Diri',   icon: 'fa-brain',      gradient: 'from-sky-500 to-indigo-600',   iconBg: 'bg-sky-100 text-sky-600' },
        ];

        // Cache loaded genres
        const genreCache = {};
        let activeGenreFilter = 'all';

        // ============================================================
        // DOM Elements
        // ============================================================
        const searchInput      = document.getElementById('searchInput');
        const searchBtn        = document.getElementById('searchBtn');
        const searchIcon       = document.getElementById('searchIcon');
        const searchLoader     = document.getElementById('searchLoader');

        // Recommendations Area
        const recommendationsArea = document.getElementById('recommendationsArea');
        const genreSections       = document.getElementById('genreSections');
        const recsLoading         = document.getElementById('recsLoading');

        // Search Results Area
        const searchResultsArea = document.getElementById('searchResultsArea');
        const loadingSkeleton   = document.getElementById('loadingSkeleton');
        const resultsGrid       = document.getElementById('resultsGrid');
        const noResultsState    = document.getElementById('noResultsState');
        const errorState        = document.getElementById('errorState');
        const errorMessage      = document.getElementById('errorMessage');
        const searchResultCount = document.getElementById('searchResultCount');

        // Modal Elements
        const readerModal       = document.getElementById('readerModal');
        const readerFrame       = document.getElementById('readerFrame');
        const readerTitle       = document.getElementById('readerTitle');
        const externalLinkBtn   = document.getElementById('externalLinkBtn');

        // ============================================================
        // RECOMMENDATIONS SYSTEM
        // ============================================================

        /**
         * Load all genre recommendations on page load
         */
        async function loadAllRecommendations() {
            recsLoading.classList.remove('hidden');
            genreSections.innerHTML = '';

            // Load genres sequentially to avoid rate-limiting
            for (let i = 0; i < GENRES.length; i++) {
                const genre = GENRES[i];
                await loadGenreRecommendation(genre, i);
            }

            recsLoading.classList.add('hidden');
        }

        /**
         * Load a single genre's recommendations from the API
         */
        async function loadGenreRecommendation(genre, index) {
            // Check cache first
            if (genreCache[genre.key]) {
                renderGenreSection(genre, genreCache[genre.key], index);
                return;
            }

            try {
                const url = new URL(RECS_ROUTE, window.location.origin);
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

        /**
         * Render a single genre section with horizontal carousel
         */
        function renderGenreSection(genre, books, index) {
            const sectionId = `genre-section-${genre.key}`;
            
            // Build book cards HTML
            let cardsHTML = '';
            books.forEach((book, cardIndex) => {
                const coverImage = book.cover_url || 'https://via.placeholder.com/128x192.png?text=No+Cover';
                const safeTitle = (book.title || 'Tanpa Judul').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const readerLink = book.reader_link || book.preview_link || `https://books.google.co.id/books?id=${book.volume_id}`;
                const author = book.author_text || 'Penulis Tidak Diketahui';

                cardsHTML += `
                    <div class="book-card-carousel bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col opacity-0 animate-slide-in-right" style="animation-delay: ${cardIndex * 0.06}s">
                        <!-- Cover -->
                        <div class="relative h-56 bg-slate-100 overflow-hidden group cursor-pointer" onclick="openReader('${book.volume_id}', '${safeTitle}', '${readerLink}')">
                            <img src="${coverImage}" alt="${book.title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                                <span class="bg-white/90 backdrop-blur-sm text-sky-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <i class="fa-solid fa-book-open-reader"></i> Baca
                                </span>
                            </div>
                        </div>
                        
                        <!-- Info -->
                        <div class="p-3.5 flex flex-col flex-grow">
                            <h4 class="text-sm font-bold text-slate-800 leading-tight mb-1 line-clamp-2" title="${book.title}">
                                ${book.title}
                            </h4>
                            <p class="text-[11px] text-slate-500 truncate mb-2">
                                <i class="fa-solid fa-pen-nib mr-1 text-slate-400"></i>${author}
                            </p>
                            <button onclick="openReader('${book.volume_id}', '${safeTitle}', '${readerLink}')" 
                                class="mt-auto w-full bg-sky-50 hover:bg-sky-500 text-sky-600 hover:text-white text-xs font-semibold py-2 rounded-lg transition-all duration-300 flex items-center justify-center gap-1.5 border border-sky-100 hover:border-sky-500">
                                <i class="fa-solid fa-book-open-reader"></i> Baca Buku
                            </button>
                        </div>
                    </div>
                `;
            });

            const sectionHTML = `
                <div id="${sectionId}" class="genre-section bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden animate-slide-up" data-genre="${genre.key}" style="animation-delay: ${index * 0.1}s">
                    <!-- Section Header -->
                    <div class="p-5 sm:p-6 pb-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl ${genre.iconBg} flex items-center justify-center text-lg">
                                <i class="fa-solid ${genre.icon}"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-base">${genre.label}</h3>
                                <p class="text-[11px] text-slate-400">${books.length} buku ditemukan</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button onclick="scrollGenre('${sectionId}', 'left')" class="scroll-btn w-8 h-8 rounded-lg bg-slate-100 hover:bg-sky-100 text-slate-500 hover:text-sky-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <button onclick="scrollGenre('${sectionId}', 'right')" class="scroll-btn w-8 h-8 rounded-lg bg-slate-100 hover:bg-sky-100 text-slate-500 hover:text-sky-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Horizontal Carousel -->
                    <div class="px-5 sm:px-6 pb-5 sm:pb-6">
                        <div class="genre-scroll" id="scroll-${sectionId}">
                            ${cardsHTML}
                        </div>
                    </div>
                </div>
            `;

            genreSections.insertAdjacentHTML('beforeend', sectionHTML);
        }

        /**
         * Scroll genre carousel left or right
         */
        function scrollGenre(sectionId, direction) {
            const scrollContainer = document.getElementById(`scroll-${sectionId}`);
            if (!scrollContainer) return;
            const scrollAmount = 440;
            scrollContainer.scrollBy({
                left: direction === 'right' ? scrollAmount : -scrollAmount,
                behavior: 'smooth'
            });
        }

        /**
         * Filter genres by clicking chips
         */
        function filterGenre(genreKey) {
            activeGenreFilter = genreKey;

            // Update chip styles
            document.querySelectorAll('.genre-chip').forEach(chip => {
                if (chip.dataset.genre === genreKey) {
                    chip.classList.add('active');
                } else {
                    chip.classList.remove('active');
                }
            });

            // Show/hide genre sections
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

        // ============================================================
        // SEARCH SYSTEM
        // ============================================================

        /**
         * Perform search using fetch API
         */
        async function performSearch() {
            const query = searchInput.value.trim();
            if (!query) return;

            // Switch to search results view
            recommendationsArea.classList.add('hidden');
            searchResultsArea.classList.remove('hidden');

            // Update UI for loading state
            setSearchLoading(true);
            hideAllSearchStates();
            loadingSkeleton.classList.remove('hidden');
            
            try {
                const url = new URL(SEARCH_ROUTE, window.location.origin);
                url.searchParams.append('q', query);
                
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                
                loadingSkeleton.classList.add('hidden');
                
                if (response.ok && data.success && Array.isArray(data.books) && data.books.length > 0) {
                    searchResultCount.textContent = `${data.books.length} buku ditemukan untuk "${query}"`;
                    renderSearchResults(data.books);
                } else if (response.ok && data.success) {
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
         * Back to recommendations view
         */
        function backToRecommendations() {
            searchResultsArea.classList.add('hidden');
            recommendationsArea.classList.remove('hidden');
            searchInput.value = '';
            searchResultCount.textContent = '';
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
         * Hide all content states in the search results area
         */
        function hideAllSearchStates() {
            loadingSkeleton.classList.add('hidden');
            resultsGrid.classList.add('hidden');
            noResultsState.classList.add('hidden');
            errorState.classList.add('hidden');
        }

        /**
         * Render book cards into the search results grid
         */
        function renderSearchResults(books) {
            resultsGrid.innerHTML = '';
            
            books.forEach(book => {
                const volumeId = book.volume_id;
                const title = book.title || 'Tanpa Judul';
                const author = book.author_text || 'Penulis Tidak Diketahui';
                const shortDesc = book.short_desc || 'Tidak ada deskripsi tersedia.';
                const pageCount = book.page_count || 0;
                
                let categoryBadge = '';
                if (Array.isArray(book.categories) && book.categories.length > 0) {
                    categoryBadge = `<span class="inline-block px-2.5 py-1 bg-sky-50 text-sky-600 text-[10px] font-bold rounded-full mb-2 uppercase tracking-wide border border-sky-100">${book.categories[0]}</span>`;
                }
                
                const coverImage = book.cover_url || 'https://via.placeholder.com/128x192.png?text=No+Cover';
                const readerLink = book.reader_link || book.preview_link || `https://books.google.co.id/books?id=${volumeId}`;
                
                const safeTitle = title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                
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
                        
                        <!-- Action Area -->
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

        // ============================================================
        // READER MODAL
        // ============================================================

        /**
         * Open Google Books embedded reader in modal
         */
        function openReader(volumeId, title, previewLink) {
            readerTitle.textContent = title.replace(/\\'/g, "'");
            externalLinkBtn.href = previewLink;
            readerFrame.src = `https://books.google.com/books?id=${volumeId}&lpg=PP1&pg=PP1&output=embed`;
            readerModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        /**
         * Close the reader modal
         */
        function closeReader() {
            readerModal.classList.add('hidden');
            readerFrame.src = '';
            document.body.style.overflow = '';
        }
        
        // Listen for ESC key to close modal
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !readerModal.classList.contains('hidden')) {
                closeReader();
            }
        });

        // ============================================================
        // TABS & KOLEKSI BACAAN
        // ============================================================
        function switchTab(tab) {
            const exploreTab = document.getElementById('tab-explore');
            const koleksiTab = document.getElementById('tab-koleksi');
            const sectionExplore = document.getElementById('section-explore');
            const sectionKoleksi = document.getElementById('section-koleksi');

            if (tab === 'explore') {
                // Active style for explore
                exploreTab.className = "flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all bg-sky-50 text-sky-700 shadow-sm border border-sky-100";
                // Inactive for koleksi
                koleksiTab.className = "flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all text-slate-500 hover:text-slate-700 hover:bg-slate-50";
                
                sectionExplore.classList.remove('hidden');
                sectionKoleksi.classList.add('hidden');
            } else {
                // Active style for koleksi
                koleksiTab.className = "flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all bg-sky-50 text-sky-700 shadow-sm border border-sky-100";
                // Inactive for explore
                exploreTab.className = "flex-1 sm:flex-none px-6 py-2.5 rounded-xl font-medium text-sm transition-all text-slate-500 hover:text-slate-700 hover:bg-slate-50";
                
                sectionExplore.classList.add('hidden');
                sectionKoleksi.classList.remove('hidden');
            }
        }

        async function addToKoleksi(volumeId, title, author, category, cover, reader, totalHalaman) {
            Swal.fire({
                title: 'Menambahkan...',
                text: 'Sedang menyimpan buku ke koleksi Anda',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('{{ route("siswa.koleksi-bacaan.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        volume_id: volumeId,
                        judul_buku: title,
                        penulis: author,
                        kategori: category,
                        cover_url: cover,
                        reader_link: reader,
                        total_halaman: totalHalaman
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Gagal menambahkan buku.'
                    });
                }
            } catch (error) {
                console.error('addToKoleksi error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Terjadi kesalahan sistem: ' + error.message
                });
            }
        }

        function deleteKoleksi(id) {
            Swal.fire({
                title: 'Hapus dari Koleksi?',
                text: "Progres membaca Anda untuk buku ini juga akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    executeDelete(id);
                }
            });
        }

        async function executeDelete(id) {
            try {
                const response = await fetch(`/siswa/koleksi-bacaan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal', data.message || 'Gagal menghapus buku.', 'error');
                }
            } catch (error) {
                console.error('deleteKoleksi error:', error);
                Swal.fire('Error!', 'Gagal menghapus buku dari koleksi: ' + error.message, 'error');
            }
        }

        // ============================================================
        // UPDATE PROGRES MODAL
        // ============================================================
        const updateProgresModal = document.getElementById('updateProgresModal');
        
        function openUpdateModal(id, halaman, total) {
            document.getElementById('update_koleksi_id').value = id;
            document.getElementById('update_halaman_terakhir').value = halaman;
            document.getElementById('update_total_halaman').value = total || 0;
            
            updateProgresModal.classList.remove('hidden');
        }

        function closeUpdateModal() {
            updateProgresModal.classList.add('hidden');
        }

        async function submitUpdateProgres(e) {
            e.preventDefault();
            
            const id = document.getElementById('update_koleksi_id').value;
            const halaman = document.getElementById('update_halaman_terakhir').value;
            const total = document.getElementById('update_total_halaman').value;
            
            Swal.fire({
                title: 'Menyimpan...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch(`/siswa/koleksi-bacaan/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        halaman_terakhir: halaman,
                        total_halaman: total
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal', data.message || 'Gagal menyimpan progres.', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
            }
        }

        // ============================================================
        // INIT: Load recommendations on page load
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            loadAllRecommendations();
        });
    </script>
</body>
</html>