<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if(!isset($role) || $role === 'siswa')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    @endif

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .animated-gradient {
            background: linear-gradient(-45deg, #1e3a8a, #2563eb, #3b82f6, #0284c7);
            background-size: 400% 400%;
            animation: gradientMove 8s ease infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ================= KAMERA ================= */
        #reader { width: 100% !important; height: 100% !important; background: #0f172a; }
        #reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }
        #reader__dashboard_section_csr,
        #reader__dashboard_section_swaplink,
        #reader__header_message,
        #reader__status_span { display: none !important; }

        .camera-box {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            border-radius: 1.25rem;
            overflow: hidden;
            background: #0f172a;
        }

        .scan-target {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 58%;
            aspect-ratio: 1 / 1;
            border: 3px solid rgba(96, 165, 250, 0.85);
            border-radius: 1rem;
            box-shadow: 0 0 0 9999px rgba(15, 23, 42, 0.45);
            overflow: hidden;
            pointer-events: none;
        }
        .scan-target::before,
        .scan-target::after,
        .scan-target > .corner-tl, .scan-target > .corner-br {
            content: '';
        }
        .scan-line {
            position: absolute;
            left: 6%;
            right: 6%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #93c5fd, transparent);
            animation: scanMove 2.2s ease-in-out infinite;
        }
        @keyframes scanMove {
            0%   { top: 8%; }
            50%  { top: 88%; }
            100% { top: 8%; }
        }

        /* ================= TABS ================= */
        .tab-active { background: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); }

        /* ================= DEKORASI BUKU (ABOUT SECTION) ================= */
        .book-illustration { position: relative; width: 100%; max-width: 220px; margin: 0 auto; }
        .book-illustration svg { width: 100%; height: auto; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <div class="min-h-screen flex flex-col">

        <nav class="animated-gradient text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center gap-3 h-16">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 text-white shadow-inner">
                        <i class="fa-solid fa-book-bookmark text-lg"></i>
                    </div>
                    <span class="font-extrabold text-xl tracking-wide text-white drop-shadow-sm">
                        Perpustakaan Digital
                    </span>
                </div>
            </div>
        </nav>

        <main class="flex-1 flex flex-col items-center justify-center p-4 sm:p-6 lg:p-10 gap-10">

            <div class="w-full max-w-4xl">

                <div id="alertBox" class="hidden mb-4 p-4 rounded-2xl text-xs font-semibold"></div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-2xl">
                        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold rounded-2xl">
                        <i class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold rounded-2xl">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

                    @if(isset($role))
                        {{-- ================================================== --}}
                        {{-- MODE: HALAMAN LOGIN KHUSUS 1 ROLE (/login/{role})   --}}
                        {{-- ================================================== --}}

                        <div class="p-6 sm:p-8 pb-2">
                            <a href="{{ route('portal') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-blue-600 transition mb-4">
                                <i class="fa-solid fa-arrow-left"></i> Kembali ke Portal
                            </a>

                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                                    <i class="fa-solid {{ $role === 'admin' ? 'fa-user-shield' : ($role === 'petugas' ? 'fa-user-tie' : 'fa-user-graduate') }}"></i>
                                </div>
                                <div>
                                    <h1 class="text-lg font-extrabold text-slate-800">Login {{ ucfirst($role) }}</h1>
                                    <p class="text-xs text-slate-400">
                                        @if($role === 'siswa')
                                            Arahkan barcode kartu siswa ke kamera
                                        @else
                                            Masukkan email & password Anda
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($role === 'siswa')
                            <div class="px-6 sm:px-8 pb-8 max-w-md mx-auto text-center">
                                <div class="camera-box border-4 border-blue-100 shadow-inner">
                                    <div id="reader"></div>
                                    <div class="scan-target">
                                        <div class="scan-line"></div>
                                    </div>
                                </div>

                                <div id="scanStatus" class="mt-3 text-xs font-semibold text-blue-600 flex items-center justify-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                    Kamera aktif, menunggu barcode...
                                </div>

                                <button type="button" id="btnRestartCamera" class="hidden mt-3 text-xs font-semibold text-blue-600 hover:text-blue-700 underline">
                                    <i class="fa-solid fa-rotate-right mr-1"></i> Coba lagi
                                </button>
                            </div>
                        @else
                            <div class="px-6 sm:px-8 pb-8 max-w-sm mx-auto">
                                <form action="{{ route('login.perform', ['role' => $role]) }}" method="POST" class="space-y-3">
                                    @csrf

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                                        <div class="relative">
                                            <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email"
                                                   class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                                        <div class="relative">
                                            <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            <input type="password" name="password" required placeholder="Masukkan password"
                                                   class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                        </div>
                                    </div>

                                    <label class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500/20">
                                        Ingat saya
                                    </label>

                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-xs font-bold shadow-md transition flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                        Masuk sebagai {{ ucfirst($role) }}
                                    </button>
                                </form>
                            </div>
                        @endif

                    @else
                        {{-- ================================================== --}}
                        {{-- MODE: PORTAL UTAMA ('/') - 2 Kolom: Kamera | Manual --}}
                        {{-- ================================================== --}}

                        <div class="grid md:grid-cols-2">

                            <!-- Kolom Kiri: Scan Kamera -->
                            <div class="p-6 sm:p-8 bg-gradient-to-b from-blue-50 to-white flex flex-col">
                                <h1 class="text-lg font-extrabold text-slate-800 text-center">Scan Barcode Siswa</h1>
                                <p class="text-xs text-slate-500 mt-1 mb-5 text-center">
                                    Arahkan barcode kartu siswa ke kamera untuk masuk otomatis
                                </p>

                                <div class="camera-box border-4 border-blue-100 shadow-inner">
                                    <div id="reader"></div>
                                    <div class="scan-target">
                                        <div class="scan-line"></div>
                                    </div>
                                </div>

                                <div id="scanStatus" class="mt-3 text-xs font-semibold text-blue-600 flex items-center justify-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                    Kamera aktif, menunggu barcode...
                                </div>

                                <button type="button" id="btnRestartCamera" class="hidden mt-3 text-xs font-semibold text-blue-600 hover:text-blue-700 underline mx-auto">
                                    <i class="fa-solid fa-rotate-right mr-1"></i> Coba lagi
                                </button>
                            </div>

                            <!-- Kolom Kanan: Login Manual -->
                            <div class="p-6 sm:p-8 border-t md:border-t-0 md:border-l border-slate-100 flex flex-col justify-center">
                                <p class="text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4">
                                    Login Manual Staff
                                </p>

                                <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-2xl mb-5">
                                    <button type="button" onclick="pindahTab('admin')" id="tabBtn-admin" class="tab-btn tab-active py-2 rounded-xl text-xs font-bold transition">
                                        <i class="fa-solid fa-user-shield mr-1"></i> Admin
                                    </button>
                                    <button type="button" onclick="pindahTab('petugas')" id="tabBtn-petugas" class="tab-btn py-2 rounded-xl text-xs font-bold text-slate-500 transition">
                                        <i class="fa-solid fa-user-tie mr-1"></i> Petugas
                                    </button>
                                </div>

                                @foreach(['admin', 'petugas'] as $r)
                                <form id="form-{{ $r }}"
                                      action="{{ route('login.perform', ['role' => $r]) }}"
                                      method="POST"
                                      class="role-form {{ $r !== 'admin' ? 'hidden' : '' }} space-y-3">
                                    @csrf

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                                        <div class="relative">
                                            <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            <input type="email" name="email" required placeholder="Masukkan email"
                                                   class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                                        <div class="relative">
                                            <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            <input type="password" name="password" required placeholder="Masukkan password"
                                                   class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-xs font-bold shadow-md transition flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                        Masuk sebagai {{ ucfirst($r) }}
                                    </button>
                                </form>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- ================================================== -->
            <!-- SECTION: TENTANG PERPUSTAKAAN (ABOUT) + ILUSTRASI BUKU -->
            <!-- ================================================== -->
            <div class="w-full max-w-4xl">
                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                    <div class="grid md:grid-cols-2 items-center">

                        <!-- Ilustrasi Buku -->
                        <div class="animated-gradient p-8 sm:p-10 flex items-center justify-center">
                            <div class="book-illustration">
                                <svg viewBox="0 0 220 180" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Buku bawah -->
                                    <g>
                                        <path d="M20 130 L20 40 Q20 30 30 28 L100 20 L100 145 L30 152 Q20 150 20 130 Z" fill="#ffffff" opacity="0.95"/>
                                        <path d="M200 130 L200 40 Q200 30 190 28 L120 20 L120 145 L190 152 Q200 150 200 130 Z" fill="#ffffff" opacity="0.95"/>
                                        <path d="M100 20 L120 20 L120 145 L100 145 Z" fill="#dbeafe"/>
                                        <line x1="35" y1="45" x2="90" y2="40" stroke="#93c5fd" stroke-width="2.5" stroke-linecap="round"/>
                                        <line x1="35" y1="60" x2="90" y2="55" stroke="#bfdbfe" stroke-width="2.5" stroke-linecap="round"/>
                                        <line x1="35" y1="75" x2="90" y2="70" stroke="#bfdbfe" stroke-width="2.5" stroke-linecap="round"/>
                                        <line x1="130" y1="40" x2="185" y2="45" stroke="#93c5fd" stroke-width="2.5" stroke-linecap="round"/>
                                        <line x1="130" y1="55" x2="185" y2="60" stroke="#bfdbfe" stroke-width="2.5" stroke-linecap="round"/>
                                        <line x1="130" y1="70" x2="185" y2="75" stroke="#bfdbfe" stroke-width="2.5" stroke-linecap="round"/>
                                    </g>
                                    <!-- Tumpukan buku bawah -->
                                    <rect x="30" y="155" width="160" height="10" rx="3" fill="#1e40af" opacity="0.85"/>
                                    <rect x="45" y="167" width="130" height="8" rx="3" fill="#2563eb" opacity="0.7"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Teks About -->
                        <div class="p-8 sm:p-10">
                            <h2 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-blue-600"></i>
                                Tentang Perpustakaan Digital
                            </h2>
                            <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                                Sistem presensi Perpustakaan Digital membantu sekolah mencatat kunjungan siswa secara
                                otomatis melalui scan barcode, sekaligus memudahkan admin dan petugas dalam mengelola
                                data siswa, laporan kunjungan, dan koleksi perpustakaan.
                            </p>

                            <div class="grid grid-cols-2 gap-3 mt-6">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-qrcode text-xs"></i>
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium leading-snug">
                                        Presensi cepat cukup scan barcode kartu siswa
                                    </p>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-chart-line text-xs"></i>
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium leading-snug">
                                        Laporan kunjungan harian, mingguan, hingga tahunan
                                    </p>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-shield-halved text-xs"></i>
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium leading-snug">
                                        Akses berbeda untuk Admin, Petugas, dan Siswa
                                    </p>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-book-open text-xs"></i>
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium leading-snug">
                                        Data siswa & koleksi tercatat rapi dan real-time
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <p class="text-center text-[11px] text-slate-400">
                &copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital
            </p>

        </main>
    </div>

    @if(!isset($role) || $role === 'siswa')
    <script>
        function pindahTab(role) {
            document.querySelectorAll('.role-form').forEach(f => f.classList.add('hidden'));
            document.getElementById('form-' + role).classList.remove('hidden');
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('tab-active');
                b.classList.add('text-slate-500');
            });
            const activeBtn = document.getElementById('tabBtn-' + role);
            if (activeBtn) {
                activeBtn.classList.add('tab-active');
                activeBtn.classList.remove('text-slate-500');
            }
        }

        function tampilkanAlert(pesan, tipe) {
            const box = document.getElementById('alertBox');
            box.classList.remove('hidden', 'bg-emerald-50', 'border-emerald-200', 'text-emerald-700', 'bg-rose-50', 'border-rose-200', 'text-rose-700');
            if (tipe === 'success') {
                box.classList.add('bg-emerald-50', 'border', 'border-emerald-200', 'text-emerald-700');
            } else {
                box.classList.add('bg-rose-50', 'border', 'border-rose-200', 'text-rose-700');
            }
            box.innerHTML = `<span><i class="fa-solid ${tipe === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'} mr-2"></i>${pesan}</span>`;
            box.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        const CSRF_TOKEN = '{{ csrf_token() }}';
        const URL_LOGIN_SCAN = '{{ route("login.scan") }}';

        let html5QrCode = null;
        let sedangMemproses = false;

        function mulaiKamera() {
            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 10, qrbox: { width: 220, height: 220 } };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                () => {}
            ).catch(() => {
                html5QrCode.start(
                    { facingMode: "user" },
                    config,
                    onScanSuccess,
                    () => {}
                ).catch(() => {
                    document.getElementById('scanStatus').innerHTML =
                        '<span class="text-rose-500"><i class="fa-solid fa-video-slash mr-1"></i> Kamera tidak dapat diakses</span>';
                    document.getElementById('btnRestartCamera').classList.remove('hidden');
                });
            });
        }

        function onScanSuccess(decodedText) {
            if (sedangMemproses) return;
            sedangMemproses = true;

            document.getElementById('scanStatus').innerHTML =
                '<span class="text-blue-600"><i class="fa-solid fa-spinner fa-spin mr-1"></i> Memverifikasi barcode...</span>';

            fetch(URL_LOGIN_SCAN, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ code: decodedText })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('scanStatus').innerHTML =
                        '<span class="text-emerald-600"><i class="fa-solid fa-circle-check mr-1"></i> Berhasil! Mengalihkan...</span>';
                    window.location.href = data.redirect;
                } else {
                    tampilkanAlert(data.message || 'Barcode tidak dikenali.', 'error');
                    resetStatusScan();
                }
            })
            .catch(() => {
                tampilkanAlert('Terjadi kesalahan koneksi, silakan coba lagi.', 'error');
                resetStatusScan();
            });
        }

        function resetStatusScan() {
            sedangMemproses = false;
            document.getElementById('scanStatus').innerHTML =
                '<span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse inline-block mr-1"></span> Kamera aktif, menunggu barcode...';
        }

        document.getElementById('btnRestartCamera').addEventListener('click', function () {
            this.classList.add('hidden');
            resetStatusScan();
            mulaiKamera();
        });

        window.addEventListener('load', mulaiKamera);
    </script>
    @endif
</body>
</html>