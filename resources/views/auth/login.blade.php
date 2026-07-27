<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Presensi digital Perpustakaan SMK Negeri 17 Jakarta — cukup tempelkan kartu barcode ke kamera.">
    <title>Perpustakaan — Presensi Digital SMK Negeri 17 Jakarta</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        :root {
            --bg: #F5FAFF;
            --sky-50:  #EFF8FF;
            --sky-100: #E3F1FF;
            --sky-200: #CDE9FF;
            --blue-500:#2F80ED;
            --blue-600:#1D6FE0;
            --blue-700:#154FA8;
            --cyan-400:#38BDF8;
            --ink-900: #0B2545;
            --ink-700: #24405F;
            --muted:   #5E7B9E;
            --line:    #DCEAFB;
            --amber:   #F59E0B;
            --teal:    #0D9488;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--ink-900);
        }

        .mono { font-family: 'JetBrains Mono', monospace; }

        /* ---------- Hero blob background ---------- */
        .hero-bg {
            background: radial-gradient(60% 60% at 15% 10%, #DFF1FF 0%, transparent 60%),
                        radial-gradient(50% 50% at 90% 0%, #E6F7FF 0%, transparent 55%),
                        linear-gradient(180deg, #FBFEFF 0%, #F1F8FF 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before,
        .hero-bg::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            filter: blur(60px);
            z-index: 0;
        }
        .hero-bg::before {
            width: 420px; height: 420px;
            background: radial-gradient(circle, rgba(56,189,248,0.28), transparent 70%);
            top: -140px; right: -120px;
        }
        .hero-bg::after {
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(47,128,237,0.18), transparent 70%);
            bottom: -160px; left: -100px;
        }
        .hero-bg > * { position: relative; z-index: 1; }

        /* ---------- Scanner card ---------- */
        .scanner-shell {
            background: #FFFFFF;
            border: 1px solid var(--line);
            box-shadow: 0 20px 45px -20px rgba(21, 79, 168, 0.25);
        }

        #reader {
            width: 100% !important;
            height: 100% !important;
            background: var(--ink-900);
        }
        #reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }
        #reader__dashboard_section_csr,
        #reader__dashboard_section_swaplink,
        #reader__header_message,
        #reader__status_span {
            display: none !important;
        }

        /* Kamera dibuat persegi dan TIDAK ditimpa mask gelap — hanya bingkai tipis
           supaya seluruh area kamera tetap terlihat jelas oleh siswa */
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 420px;
            aspect-ratio: 1 / 1;
            margin: 0 auto;
            border-radius: 1.25rem;
            overflow: hidden;
            background: var(--ink-900);
        }

        .scan-target {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 74%;
            height: 74%;
            border-radius: 1rem;
            border: 2.5px solid rgba(255,255,255,0.55);
            pointer-events: none;
        }
        .corner {
            position: absolute;
            width: 24px; height: 24px;
            border-color: var(--cyan-400);
            border-style: solid;
        }
        .corner-tl { top: -2px; left: -2px; border-width: 4px 0 0 4px; border-top-left-radius: 10px; }
        .corner-tr { top: -2px; right: -2px; border-width: 4px 4px 0 0; border-top-right-radius: 10px; }
        .corner-bl { bottom: -2px; left: -2px; border-width: 0 0 4px 4px; border-bottom-left-radius: 10px; }
        .corner-br { bottom: -2px; right: -2px; border-width: 0 4px 4px 0; border-bottom-right-radius: 10px; }

        /* ---------- Barcode divider (signature motif) ---------- */
        .barcode-divider {
            height: 46px;
            background-image: repeating-linear-gradient(
                90deg,
                var(--blue-600) 0px, var(--blue-600) 2px,
                transparent 2px, transparent 6px,
                var(--blue-500) 6px, var(--blue-500) 7px,
                transparent 7px, transparent 12px,
                var(--cyan-400) 12px, var(--cyan-400) 15px,
                transparent 15px, transparent 20px,
                var(--blue-600) 20px, var(--blue-600) 21px,
                transparent 21px, transparent 27px
            );
            background-size: 27px 100%;
            opacity: 0.9;
        }

        /* ---------- Carousel "Tentang" ---------- */
        .carousel-track {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            border-radius: 1.5rem;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .carousel-track::-webkit-scrollbar { display: none; }
        .carousel-slide {
            flex: 0 0 100%;
            scroll-snap-align: center;
        }
        .carousel-dot {
            width: 7px; height: 7px; border-radius: 999px;
            background: var(--sky-200);
            transition: all .25s ease;
        }
        .carousel-dot.active {
            width: 20px;
            background: var(--blue-600);
        }
        .carousel-arrow {
            width: 40px; height: 40px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--line);
            box-shadow: 0 8px 20px -10px rgba(21,79,168,0.3);
            display: flex; align-items: center; justify-content: center;
            color: var(--blue-700);
            transition: transform .15s ease;
        }
        .carousel-arrow:hover { transform: scale(1.06); }

        /* ---------- Rak buku interaktif ---------- */
        .shelf-plank {
            background: linear-gradient(180deg, #1D6FE0 0%, #154FA8 100%);
            border-radius: 10px;
            box-shadow: 0 14px 20px -10px rgba(21,79,168,0.45);
        }
        .book-spine {
            cursor: pointer;
            border-radius: 4px 4px 2px 2px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 10px;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            color: rgba(255,255,255,0.92);
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.02em;
            transition: transform .18s ease, box-shadow .18s ease;
            box-shadow: inset -3px 0 6px rgba(0,0,0,0.12);
        }
        .book-spine:hover {
            transform: translateY(-10px);
            box-shadow: 0 14px 18px -10px rgba(11,37,69,0.4), inset -3px 0 6px rgba(0,0,0,0.12);
        }

        #bookModal {
            transition: opacity .2s ease;
        }
        #bookModal .modal-card {
            transition: transform .25s ease, opacity .25s ease;
        }

        /* ---------- Reveal-on-scroll ---------- */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .6s ease, transform .6s ease;
        }
        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal { opacity: 1; transform: none; transition: none; }
        }

        ::selection { background: var(--blue-500); color: #fff; }
    </style>
</head>
<body class="antialiased">

    <!-- ===================== HEADER ===================== -->
    <header class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b" style="border-color: var(--line);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg"
                         style="background: linear-gradient(135deg, var(--blue-500), var(--cyan-400)); box-shadow: 0 10px 25px -10px rgba(47,128,237,0.55);">
                        <i class="fa-solid fa-book-bookmark text-xl"></i>
                    </div>
                    <div>
                        <span class="font-black text-xl tracking-tight block" style="color: var(--ink-900);">
                            Perpustakaan
                        </span>
                        <span class="text-[11px] font-bold tracking-wider uppercase block" style="color: var(--blue-600);">
                            SMK Negeri 17 Jakarta
                        </span>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold" style="color: var(--ink-700);">
                    <a href="#scanner" class="hover:text-blue-600 transition">Presensi</a>
                    <a href="#tentang" class="hover:text-blue-600 transition">Tentang</a>
                    <a href="#rak-buku" class="hover:text-blue-600 transition">Rak Buku</a>
                    <a href="#galeri" class="hover:text-blue-600 transition">Galeri</a>
                </nav>

                <div class="hidden sm:flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold"></div>
                </div>

                <button id="btnMenuMobile" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl" style="border: 1px solid var(--line); color: var(--blue-700);">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <nav id="menuMobile" class="hidden md:hidden pb-4 flex flex-col gap-3 text-sm font-semibold" style="color: var(--ink-700);">
                <a href="#scanner">Presensi</a>
                <a href="#tentang">Tentang</a>
                <a href="#rak-buku">Rak Buku</a>
                <a href="#galeri">Galeri</a>
            </nav>
        </div>
    </header>

    <main>
        <!-- ===================== HERO + SCANNER ===================== -->
        <section id="scanner" class="hero-bg py-14 lg:py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto space-y-8">

                <div class="text-center space-y-3 reveal">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight" style="color: var(--ink-900);">
                        Scan Kartu Anggota Anda
                    </h1>
                    <p class="text-sm sm:text-base max-w-xl mx-auto font-medium leading-relaxed" style="color: var(--muted);">
                        Posisikan barcode kartu siswa tepat di dalam kotak. Sistem akan memandu jarak yang pas dan langsung mencatat kehadiranmu.
                    </p>
                </div>

                <div id="alertBox" class="hidden max-w-2xl mx-auto p-4 rounded-2xl text-xs font-semibold shadow-lg transition-all"></div>

                @if(session('success'))
                    <div class="max-w-2xl mx-auto p-4 rounded-2xl flex items-center gap-3 text-xs font-semibold"
                         style="background:#ECFDF5; border:1px solid #A7F3D0; color:#047857;">
                        <i class="fa-solid fa-circle-check text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="max-w-2xl mx-auto p-4 rounded-2xl flex items-center gap-3 text-xs font-semibold"
                         style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C;">
                        <i class="fa-solid fa-circle-exclamation text-base"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div class="max-w-md mx-auto reveal">
                    <div class="scanner-shell p-4 sm:p-5 rounded-3xl">

                        <div class="camera-container">
                            <div id="reader"></div>

                            <div class="scan-target">
                                <div class="corner corner-tl"></div>
                                <div class="corner corner-tr"></div>
                                <div class="corner corner-bl"></div>
                                <div class="corner corner-br"></div>
                            </div>
                        </div>

                        <div class="mt-4 px-4 py-3 rounded-2xl flex flex-col items-center text-center gap-1"
                             style="background: var(--sky-50); border: 1px solid var(--line);">
                            <div id="scanStatus" class="text-xs font-bold flex items-center gap-2.5" style="color: var(--blue-700);">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                                </span>
                                Kamera aktif, silakan dekatkan kartu...
                            </div>
                            <div id="scanHint" class="text-[11px] font-medium" style="color: var(--muted);">
                                Posisikan barcode di dalam kotak
                            </div>

                            <button type="button" id="btnRestartCamera"
                                class="hidden mt-2 px-4 py-1.5 rounded-xl text-white text-xs font-bold transition shadow-md flex items-center gap-1.5"
                                style="background: var(--blue-600);">
                                <i class="fa-solid fa-rotate-right"></i> Coba Lagi
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- ===================== TENTANG (carousel + teks) ===================== -->
        <section id="tentang" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
            <div class="text-center max-w-2xl mx-auto space-y-3 reveal">
                <span class="text-xs font-bold tracking-widest uppercase" style="color: var(--blue-600);">Tentang</span>
                <h2 class="text-2xl sm:text-3xl font-black" style="color: var(--ink-900);">Perpustakaan SMK Negeri 17 Jakarta</h2>
            </div>

            <div class="grid lg:grid-cols-12 gap-8 items-center mt-12 reveal">
                <!-- Carousel -->
                <div class="lg:col-span-7 relative">
                    <div id="carouselTrack" class="carousel-track rounded-3xl" style="border: 1px solid var(--line);">
                        <div class="carousel-slide">
                            <img src="https://images.unsplash.com/photo-1600420870295-5e00aac0be39?w=1000&q=80&auto=format&fit=crop" class="w-full h-72 sm:h-96 object-cover" alt="Gedung perpustakaan modern">
                        </div>
                        <div class="carousel-slide">
                            <img src="https://images.unsplash.com/photo-1501503069356-3c6b82a17d89?w=1000&q=80&auto=format&fit=crop" class="w-full h-72 sm:h-96 object-cover" alt="Siswa membaca bersama">
                        </div>
                        <div class="carousel-slide">
                            <img src="https://images.unsplash.com/photo-1741707596397-efaae09503b5?w=1000&q=80&auto=format&fit=crop" class="w-full h-72 sm:h-96 object-cover" alt="Siswa belajar di ruang baca">
                        </div>
                        <div class="carousel-slide">
                            <img src="https://images.unsplash.com/photo-1514513452089-17f8a9771ee8?w=1000&q=80&auto=format&fit=crop" class="w-full h-72 sm:h-96 object-cover" alt="Aktivitas di dalam perpustakaan">
                        </div>
                        <div class="carousel-slide">
                            <img src="https://images.unsplash.com/photo-1700145872464-4beb41df93a3?w=1000&q=80&auto=format&fit=crop" class="w-full h-72 sm:h-96 object-cover" alt="Ruang baca dengan kursi">
                        </div>
                    </div>

                    <button id="carouselPrev" class="carousel-arrow absolute left-3 top-1/2 -translate-y-1/2"><i class="fa-solid fa-chevron-left"></i></button>
                    <button id="carouselNext" class="carousel-arrow absolute right-3 top-1/2 -translate-y-1/2"><i class="fa-solid fa-chevron-right"></i></button>

                    <div id="carouselDots" class="flex items-center justify-center gap-2 mt-4"></div>
                </div>

                <!-- Teks -->
                <div class="lg:col-span-5 space-y-4">
                    <p class="text-xs sm:text-sm leading-relaxed" style="color: var(--ink-700);">
                        Perpustakaan SMK Negeri 17 Jakarta hadir sebagai ruang belajar dan literasi digital bagi seluruh siswa. Koleksi buku disusun rapi, ruang baca nyaman, dan kini presensi kunjungan dilakukan secara digital lewat pemindaian barcode kartu anggota.
                    </p>
                    <p class="text-xs sm:text-sm leading-relaxed" style="color: var(--ink-700);">
                        Dengan sistem ini, data kunjungan tercatat akurat dan pengelola dapat memantau tingkat keaktifan membaca siswa dari waktu ke waktu.
                    </p>
                    <div class="pt-2 grid grid-cols-2 gap-4">
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== RAK BUKU INTERAKTIF ===================== -->
        <section id="rak-buku" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto" style="background: var(--sky-50);">
            <div class="text-center max-w-2xl mx-auto space-y-3 reveal">
                <span class="text-xs font-bold tracking-widest uppercase" style="color: var(--blue-600);">Rak Buku</span>
                <h2 class="text-2xl sm:text-3xl font-black" style="color: var(--ink-900);">Klik Buku untuk Melihat Detailnya</h2>
                <p class="text-xs sm:text-sm leading-relaxed" style="color: var(--muted);">
                    Sebagian koleksi yang tersedia di perpustakaan. Sentuh salah satu buku untuk membaca sinopsis singkatnya.
                </p>
            </div>

            <div class="mt-12 reveal">
                <div id="rakBuku" class="flex items-end justify-center gap-1.5 sm:gap-2 flex-wrap px-2 pb-3"></div>
                <div class="shelf-plank h-4 max-w-5xl mx-auto"></div>
            </div>
        </section>

        <!-- Modal detail buku -->
        <div id="bookModal" class="hidden fixed inset-0 z-[60] items-center justify-center p-4" style="background: rgba(11,37,69,0.55);">
            <div class="modal-card bg-white rounded-3xl max-w-md w-full p-6 relative" style="border: 1px solid var(--line);">
                <button id="bookModalClose" class="absolute top-4 right-4 w-8 h-8 rounded-full flex items-center justify-center" style="background: var(--sky-100); color: var(--blue-700);">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <span id="bookModalBadge" class="inline-block text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full mb-3" style="background: var(--sky-100); color: var(--blue-700);"></span>
                <h3 id="bookModalTitle" class="text-lg font-black mb-1" style="color: var(--ink-900);"></h3>
                <p id="bookModalAuthor" class="text-xs font-semibold mb-4" style="color: var(--muted);"></p>
                <p id="bookModalDesc" class="text-xs leading-relaxed" style="color: var(--ink-700);"></p>
            </div>
        </div>

        <!-- ===================== GALERI ===================== -->
        <section id="galeri" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
            <div class="text-center max-w-2xl mx-auto space-y-3 reveal">
                <span class="text-xs font-bold tracking-widest uppercase" style="color: var(--blue-600);">Galeri</span>
                <h2 class="text-2xl sm:text-3xl font-black" style="color: var(--ink-900);">Suasana Perpustakaan</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-12 reveal">
                <img src="https://images.unsplash.com/photo-1568667256549-094345857637?w=700&q=80&auto=format&fit=crop" alt="Rak buku kayu" class="w-full h-48 object-cover rounded-3xl" style="border: 1px solid var(--line);">
                <img src="https://images.unsplash.com/photo-1526243741027-444d633d7365?w=700&q=80&auto=format&fit=crop" alt="Tumpukan buku" class="w-full h-48 object-cover rounded-3xl" style="border: 1px solid var(--line);">
                <img src="https://images.unsplash.com/photo-1620342217727-32395770ea17?w=700&q=80&auto=format&fit=crop" alt="Rak buku coklat" class="w-full h-48 object-cover rounded-3xl" style="border: 1px solid var(--line);">
                <img src="https://images.unsplash.com/photo-1593173945705-d6451ed5909a?w=700&q=80&auto=format&fit=crop" alt="Rak buku putih" class="w-full h-48 object-cover rounded-3xl" style="border: 1px solid var(--line);">
                <img src="https://images.unsplash.com/photo-1627340067228-14a5222671a3?w=700&q=80&auto=format&fit=crop" alt="Buku di rak putih" class="w-full h-48 object-cover rounded-3xl" style="border: 1px solid var(--line);">
                <img src="https://images.unsplash.com/photo-1607423730403-b7fc1eb83ce0?w=700&q=80&auto=format&fit=crop" alt="Buku di rak coklat" class="w-full h-48 object-cover rounded-3xl" style="border: 1px solid var(--line);">
            </div>
        </section>

        <!-- ===================== MOTIVASI MEMBACA ===================== -->
        <section class="pb-16 sm:pb-24 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
            <div class="text-center max-w-2xl mx-auto space-y-3 reveal">
                <span class="text-xs font-bold tracking-widest uppercase" style="color: var(--blue-600);">Motivasi</span>
                <h2 class="text-2xl sm:text-3xl font-black" style="color: var(--ink-900);">Semangat Membaca Setiap Hari</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mt-12">
                <div class="p-6 rounded-3xl bg-white reveal" style="border: 1px solid var(--line);">
                    <i class="fa-solid fa-quote-left text-lg mb-4" style="color: var(--blue-500);"></i>
                    <p class="text-sm font-semibold leading-relaxed" style="color: var(--ink-900);">
                        "Satu buku, satu pena, satu anak, dan satu guru dapat mengubah dunia."
                    </p>
                    <p class="mt-3 text-[11px] font-bold" style="color: var(--muted);">— Malala Yousafzai</p>
                </div>
                <div class="p-6 rounded-3xl bg-white reveal" style="border: 1px solid var(--line);">
                    <i class="fa-solid fa-quote-left text-lg mb-4" style="color: var(--cyan-400);"></i>
                    <p class="text-sm font-semibold leading-relaxed" style="color: var(--ink-900);">
                        "Membaca adalah jendela dunia, dan teknologi adalah kunci untuk mempermudah jalannya."
                    </p>
                    <p class="mt-3 text-[11px] font-bold" style="color: var(--muted);">— Perpustakaan Digital School System</p>
                </div>
                <div class="p-6 rounded-3xl bg-white reveal" style="border: 1px solid var(--line);">
                    <i class="fa-solid fa-quote-left text-lg mb-4" style="color: var(--teal);"></i>
                    <p class="text-sm font-semibold leading-relaxed" style="color: var(--ink-900);">
                        "Orang yang tidak membaca hanya hidup satu kali. Orang yang membaca hidup ribuan kali."
                    </p>
                    <p class="mt-3 text-[11px] font-bold" style="color: var(--muted);">— Pepatah Literasi</p>
                </div>
            </div>
        </section>

    </main>

    <footer class="border-t py-8 text-center text-xs" style="border-color: var(--line); color: var(--muted);">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital — SMK Negeri 17 Jakarta.</p>
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-code"></i> Versi 3.1</span>
                <span>&bull;</span>
                <span><i class="fa-solid fa-circle-check text-emerald-500"></i> Server Online</span>
            </div>
        </div>
    </footer>

    <script>
        /* =========================================================
           MENU MOBILE
        ========================================================= */
        document.getElementById('btnMenuMobile').addEventListener('click', function () {
            document.getElementById('menuMobile').classList.toggle('hidden');
        });
        document.querySelectorAll('#menuMobile a').forEach(a => {
            a.addEventListener('click', () => document.getElementById('menuMobile').classList.add('hidden'));
        });

        /* =========================================================
           ALERT
        ========================================================= */
        function tampilkanAlert(pesan, tipe) {
            const box = document.getElementById('alertBox');
            box.classList.remove('hidden');
            box.style.background = tipe === 'success' ? '#ECFDF5' : '#FEF2F2';
            box.style.border = tipe === 'success' ? '1px solid #A7F3D0' : '1px solid #FECACA';
            box.style.color = tipe === 'success' ? '#047857' : '#B91C1C';
            box.innerHTML = `<div class="flex items-center gap-2"><i class="fa-solid ${tipe === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'} text-base"></i><span>${pesan}</span></div>`;
            box.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        /* =========================================================
           KAMERA / SCANNER BARCODE
        ========================================================= */
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const URL_LOGIN_SCAN = '{{ route("login.scan") }}';

        let html5QrCode = null;
        let sedangMemproses = false;
        let kodeTerakhir = null;
        let waktuTerakhir = 0;
        let hintInterval = null;

        const daftarHint = [
            'Posisikan barcode di dalam kotak',
            'Pastikan pencahayaan cukup terang',
            'Kode terlalu jauh? Dekatkan sedikit kartunya',
            'Tahan kartu agar tidak goyang',
            'Kode buram? Coba sedikit majukan kartu'
        ];
        let indexHint = 0;

        function mulaiSiklusHint() {
            hentikanSiklusHint();
            indexHint = 0;
            document.getElementById('scanHint').textContent = daftarHint[0];
            hintInterval = setInterval(() => {
                indexHint = (indexHint + 1) % daftarHint.length;
                document.getElementById('scanHint').textContent = daftarHint[indexHint];
            }, 2800);
        }
        function hentikanSiklusHint() {
            if (hintInterval) clearInterval(hintInterval);
            hintInterval = null;
        }

        /**
         * Kamera dikonfigurasi untuk kecepatan baca maksimal:
         * - fps tinggi (24) supaya frame dianalisis lebih sering
         * - kotak pemindai persegi tanpa mask gelap, kamera tetap terlihat penuh
         * - useBarCodeDetectorIfSupported memakai BarcodeDetector native browser jika tersedia
         */
        function mulaiKamera() {
            html5QrCode = new Html5Qrcode("reader", {
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.QR_CODE,
                    Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.CODE_39,
                    Html5QrcodeSupportedFormats.CODE_93,
                    Html5QrcodeSupportedFormats.EAN_13,
                    Html5QrcodeSupportedFormats.EAN_8,
                    Html5QrcodeSupportedFormats.UPC_A,
                    Html5QrcodeSupportedFormats.UPC_E,
                    Html5QrcodeSupportedFormats.ITF,
                    Html5QrcodeSupportedFormats.CODABAR,
                ],
                experimentalFeatures: { useBarCodeDetectorIfSupported: true },
                verbose: false
            });

            const config = {
                fps: 24,
                qrbox: { width: 230, height: 230 },
                aspectRatio: 1,
                disableFlip: false,
            };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                () => {}
            ).then(() => {
                mulaiSiklusHint();
            }).catch(() => {
                html5QrCode.start(
                    { facingMode: "user" },
                    config,
                    onScanSuccess,
                    () => {}
                ).then(() => {
                    mulaiSiklusHint();
                }).catch(() => {
                    document.getElementById('scanStatus').innerHTML =
                        '<span class="text-rose-500 flex items-center gap-1.5"><i class="fa-solid fa-video-slash"></i> Kamera tidak dapat diakses atau izin ditolak</span>';
                    document.getElementById('scanHint').textContent = 'Periksa izin kamera pada browser Anda';
                    document.getElementById('btnRestartCamera').classList.remove('hidden');
                });
            });
        }

        function onScanSuccess(decodedText) {
            const sekarang = Date.now();

            if (sedangMemproses) return;
            if (decodedText === kodeTerakhir && (sekarang - waktuTerakhir) < 4000) return;

            kodeTerakhir = decodedText;
            waktuTerakhir = sekarang;
            sedangMemproses = true;
            hentikanSiklusHint();

            if (navigator.vibrate) { try { navigator.vibrate(60); } catch (e) {} }

            document.getElementById('scanStatus').innerHTML =
                '<span style="color:#1D6FE0;" class="flex items-center gap-2"><i class="fa-solid fa-spinner fa-spin"></i> Memverifikasi data barcode...</span>';
            document.getElementById('scanHint').innerHTML =
                '<span style="color:#059669; font-weight:700;"><i class="fa-solid fa-check"></i> Posisi pas! Barcode terbaca</span>';

            const controller = new AbortController();
            const batasWaktu = setTimeout(() => controller.abort(), 6000);

            fetch(URL_LOGIN_SCAN, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ code: decodedText }),
                signal: controller.signal,
                cache: 'no-store',
                keepalive: true,
            })
            .then(res => res.json())
            .then(data => {
                clearTimeout(batasWaktu);
                if (data.success) {
                    document.getElementById('scanStatus').innerHTML =
                        '<span class="text-emerald-500 flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> Berhasil! Mengalihkan...</span>';
                    if (html5QrCode) { try { html5QrCode.pause(true); } catch (e) {} }
                    window.location.href = data.redirect;
                } else {
                    tampilkanAlert(data.message || 'Barcode tidak terdaftar atau tidak valid.', 'error');
                    resetStatusScan();
                }
            })
            .catch(err => {
                clearTimeout(batasWaktu);
                const pesan = err.name === 'AbortError'
                    ? 'Koneksi lambat, silakan coba lagi.'
                    : 'Terjadi kesalahan jaringan, silakan coba beberapa saat lagi.';
                tampilkanAlert(pesan, 'error');
                resetStatusScan();
            });
        }

        function resetStatusScan() {
            sedangMemproses = false;
            document.getElementById('scanStatus').innerHTML = `
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                </span>
                Kamera aktif, silakan dekatkan kartu...`;
            mulaiSiklusHint();
        }

        document.getElementById('btnRestartCamera').addEventListener('click', function () {
            this.classList.add('hidden');
            resetStatusScan();
            mulaiKamera();
        });

        window.addEventListener('load', mulaiKamera);

        (function () {
            const track = document.getElementById('carouselTrack');
            const slides = track.querySelectorAll('.carousel-slide');
            const dotsWrap = document.getElementById('carouselDots');
            const prevBtn = document.getElementById('carouselPrev');
            const nextBtn = document.getElementById('carouselNext');

            slides.forEach((_, i) => {
                const dot = document.createElement('button');
                dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
                dot.addEventListener('click', () => goToSlide(i));
                dotsWrap.appendChild(dot);
            });

            function goToSlide(i) {
                track.scrollTo({ left: track.clientWidth * i, behavior: 'smooth' });
            }

            function updateDots() {
                const index = Math.round(track.scrollLeft / track.clientWidth);
                dotsWrap.querySelectorAll('.carousel-dot').forEach((d, i) => {
                    d.classList.toggle('active', i === index);
                });
            }

            let scrollTimeout;
            track.addEventListener('scroll', () => {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(updateDots, 80);
            });

            prevBtn.addEventListener('click', () => {
                const index = Math.max(0, Math.round(track.scrollLeft / track.clientWidth) - 1);
                goToSlide(index);
            });
            nextBtn.addEventListener('click', () => {
                const index = Math.min(slides.length - 1, Math.round(track.scrollLeft / track.clientWidth) + 1);
                goToSlide(index);
            });
        })();

        /* =========================================================
           RAK BUKU INTERAKTIF
        ========================================================= */
        (function () {
            const dataBuku = [
                { judul: 'Laskar Pelangi', penulis: 'Andrea Hirata', kategori: 'Fiksi', warna: '#1D6FE0', desc: 'Kisah persahabatan anak-anak Belitung yang berjuang meraih pendidikan di tengah keterbatasan.' },
                { judul: 'Bumi Manusia', penulis: 'Pramoedya Ananta Toer', kategori: 'Sejarah', warna: '#154FA8', desc: 'Novel yang menggambarkan pergolakan sosial dan cinta pada masa kolonial di Hindia Belanda.' },
                { judul: 'Negeri 5 Menara', penulis: 'Ahmad Fuadi', kategori: 'Fiksi', warna: '#0D9488', desc: 'Perjalanan enam santri mengejar mimpi dari pondok pesantren hingga ke berbagai penjuru dunia.' },
                { judul: 'Sapiens', penulis: 'Yuval Noah Harari', kategori: 'Non-Fiksi', warna: '#2F80ED', desc: 'Menelusuri perjalanan panjang manusia dari zaman purba hingga era modern.' },
                { judul: 'Filosofi Teras', penulis: 'Henry Manampiring', kategori: 'Pengembangan Diri', warna: '#38BDF8', desc: 'Pengantar filsafat Stoa yang relevan untuk mengelola emosi di kehidupan sehari-hari.' },
                { judul: 'Cantik Itu Luka', penulis: 'Eka Kurniawan', kategori: 'Fiksi', warna: '#0B2545', desc: 'Kisah magis realis tentang empat generasi perempuan di sebuah kota kecil.' },
                { judul: 'Atomic Habits', penulis: 'James Clear', kategori: 'Pengembangan Diri', warna: '#F59E0B', desc: 'Panduan praktis membangun kebiasaan kecil yang berdampak besar bagi kehidupan.' },
                { judul: 'Ronggeng Dukuh Paruk', penulis: 'Ahmad Tohari', kategori: 'Fiksi', warna: '#1D6FE0', desc: 'Potret budaya dan pergulatan hidup seorang penari ronggeng di pedesaan Jawa.' },
                { judul: 'Sains Populer', penulis: 'Tim Editor', kategori: 'Sains', warna: '#0D9488', desc: 'Kumpulan artikel ringan yang mengupas fenomena sains dalam kehidupan sehari-hari.' },
                { judul: 'Perahu Kertas', penulis: 'Dee Lestari', kategori: 'Fiksi', warna: '#154FA8', desc: 'Kisah perjalanan cinta dan mimpi dua anak muda yang penuh warna.' },
                { judul: 'Matematika Dasar', penulis: 'Tim Editor', kategori: 'Pelajaran', warna: '#2F80ED', desc: 'Buku referensi konsep matematika dasar untuk siswa SMK.' },
                { judul: 'Sejarah Nusantara', penulis: 'Tim Editor', kategori: 'Sejarah', warna: '#38BDF8', desc: 'Rangkuman perjalanan sejarah Nusantara dari masa kerajaan hingga kemerdekaan.' },
            ];

            const rak = document.getElementById('rakBuku');
            const tinggiVariasi = [92, 104, 88, 110, 96, 100, 90, 106, 94, 102, 88, 98];
            const lebarVariasi  = [26, 24, 28, 22, 27, 25, 29, 23, 26, 24, 28, 25];

            dataBuku.forEach((buku, i) => {
                const el = document.createElement('div');
                el.className = 'book-spine';
                el.style.height = tinggiVariasi[i % tinggiVariasi.length] + 'px';
                el.style.width = lebarVariasi[i % lebarVariasi.length] + 'px';
                el.style.background = buku.warna;
                el.textContent = buku.judul;
                el.setAttribute('data-index', i);
                el.addEventListener('click', () => bukaModalBuku(i));
                rak.appendChild(el);
            });

            const modal = document.getElementById('bookModal');

            function bukaModalBuku(i) {
                const buku = dataBuku[i];
                document.getElementById('bookModalBadge').textContent = buku.kategori;
                document.getElementById('bookModalTitle').textContent = buku.judul;
                document.getElementById('bookModalAuthor').textContent = 'oleh ' + buku.penulis;
                document.getElementById('bookModalDesc').textContent = buku.desc;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function tutupModalBuku() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.getElementById('bookModalClose').addEventListener('click', tutupModalBuku);
            modal.addEventListener('click', (e) => { if (e.target === modal) tutupModalBuku(); });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') tutupModalBuku(); });
        })();
        document.addEventListener('DOMContentLoaded', function () {
            const elemen = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) {
                elemen.forEach(el => el.classList.add('is-visible'));
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            elemen.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>