<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku Digital - Perpustakaan Petugas</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        /* Gradient Animation khusus Tema Hijau */
        .animated-gradient-green {
            background: linear-gradient(-45deg, #064e3b, #047857, #10b981, #059669);
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
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="animated-gradient-green text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 text-white shadow-inner">
                        <i class="fa-solid fa-book-bookmark text-lg"></i>
                    </div>
                    <div>
                        <span class="font-extrabold text-lg tracking-wide text-white drop-shadow-sm block leading-tight">
                            Perpustakaan
                        </span>
                        <span class="text-[10px] text-emerald-200 tracking-wider uppercase font-semibold">Panel Petugas</span>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-1 font-medium text-sm">
                    <a href="{{ Route::has('petugas.dashboard') ? route('petugas.dashboard') : '#' }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('petugas.dashboard*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-chart-pie text-xs"></i> Dashboard
                    </a>

                    <a href="{{ Route::has('petugas.siswa.index') ? route('petugas.siswa.index') : (Route::has('petugas.siswa') ? route('petugas.siswa') : '#') }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('petugas.siswa*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-users text-xs"></i> Data Siswa
                    </a>

                    <a href="{{ Route::has('petugas.buku') ? route('petugas.buku') : '#' }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('petugas.buku*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-book text-xs"></i> Buku Digital
                    </a>

                    <a href="{{ Route::has('petugas.presensi') ? route('petugas.presensi') : '#' }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('petugas.presensi*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-clipboard-user text-xs"></i> Presensi
                    </a>

                    <a href="{{ Route::has('petugas.laporan.harian') ? route('petugas.laporan.harian') : (Route::has('petugas.laporan') ? route('petugas.laporan') : '#') }}" 
                       class="px-4 py-2 rounded-xl transition duration-200 flex items-center gap-2 {{ request()->routeIs('petugas.laporan*') ? 'bg-white/20 text-white font-bold shadow-sm border border-white/20 backdrop-blur-sm' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-file-lines text-xs"></i> Laporan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight">{{ Auth::user()->name ?? 'Petugas Perpustakaan' }}</span>
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

    <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full flex-1">

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <span><i class="fa-solid fa-circle-check text-emerald-600 mr-2"></i>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-lg leading-none">&times;</button>
            </div>
        @endif

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Kelola Buku Digital</h1>
                <p class="text-slate-500 text-sm">Kelola dan publikasikan materi buku digital untuk siswa.</p>
            </div>
            
            <button onclick="openModalTambah()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-200/50 flex items-center gap-2 transition active:scale-95 w-max">
                <i class="fa-solid fa-plus"></i> Tambah Buku Baru
            </button>
        </div>

        <div class="mb-6">
            <form action="{{ Route::has('petugas.buku') ? route('petugas.buku') : '#' }}" method="GET" class="flex gap-2">
                <div class="relative w-full max-w-md">
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul, penulis, atau kategori..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                </div>
                <button type="submit" class="bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-800 transition shadow-sm">
                    Cari
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bukuDigitals as $buku)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between p-4">
                    <div>
                        <div class="h-48 bg-slate-100 rounded-xl overflow-hidden mb-4 relative group">
                            @if($buku->cover)
                                <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover {{ $buku->judul_buku }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                                    <i class="fa-solid fa-book-open text-4xl mb-2 text-slate-300"></i>
                                    <span class="text-xs">No Cover</span>
                                </div>
                            @endif
                            <span class="absolute top-2 right-2 bg-emerald-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-md backdrop-blur-sm z-10 shadow-sm">
                                {{ $buku->kategori }}
                            </span>

                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button onclick="openModalBaca('{{ asset('storage/' . $buku->file_pdf) }}', '{{ addslashes($buku->judul_buku) }}')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-lg flex items-center gap-2 transform translate-y-2 group-hover:translate-y-0 transition-all">
                                    <i class="fa-solid fa-book-open"></i> Baca Sekarang
                                </button>
                            </div>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base line-clamp-1" title="{{ $buku->judul_buku }}">{{ $buku->judul_buku }}</h3>
                        <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-user-pen mr-1 text-emerald-600"></i>{{ $buku->penulis ?? 'Penulis Tidak Diketahui' }}</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <button onclick="openModalBaca('{{ asset('storage/' . $buku->file_pdf) }}', '{{ addslashes($buku->judul_buku) }}')" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-file-pdf"></i> Preview PDF
                        </button>

                        <div class="flex items-center gap-3">
                            <button onclick='openModalEdit(@json($buku))' class="text-xs font-semibold text-amber-600 hover:text-amber-700 flex items-center gap-1 transition">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>

                            <form action="{{ route('petugas.buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700 flex items-center gap-1 transition">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-slate-100 text-slate-400">
                    <i class="fa-solid fa-book-bookmark text-5xl mb-3 text-slate-300"></i>
                    <p class="text-base font-semibold text-slate-600">Belum ada buku digital</p>
                    <p class="text-xs text-slate-400 mt-1">Klik tombol 'Tambah Buku Baru' di atas untuk mengunggah PDF.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $bukuDigitals->links() }}
        </div>
    </main>

    <div id="modalTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-emerald-600"></i> Tambah Buku Baru
                </h3>
                <button onclick="closeModalTambah()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>
            <form action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Judul Buku *</label>
                    <input type="text" name="judul_buku" required placeholder="Masukkan judul buku" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Penulis</label>
                        <input type="text" name="penulis" placeholder="Nama penulis" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kategori *</label>
                        <input type="text" name="kategori" value="Umum" required placeholder="Contoh: Sains, Novel" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Cover (Gambar)</label>
                    <input type="file" name="cover" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">File PDF *</label>
                    <input type="file" name="file_pdf" accept="application/pdf" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t">
                    <button type="button" onclick="closeModalTambah()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-600"></i> Edit Informasi Buku
                </h3>
                <button onclick="closeModalEdit()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>
            <form id="formEdit" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Judul Buku *</label>
                    <input type="text" id="edit_judul_buku" name="judul_buku" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Penulis</label>
                        <input type="text" id="edit_penulis" name="penulis" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kategori *</label>
                        <input type="text" id="edit_kategori" name="kategori" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Ganti Cover (Opsional)</label>
                    <input type="file" name="cover" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Ganti PDF (Opsional)</label>
                    <input type="file" name="file_pdf" accept="application/pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t">
                    <button type="button" onclick="closeModalEdit()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold transition">Update Buku</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalBaca" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md hidden z-50 flex items-center justify-center p-2 sm:p-6">
        <div class="bg-white rounded-2xl w-full max-w-5xl h-[90vh] flex flex-col shadow-2xl overflow-hidden">
            <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h3 id="baca_judul" class="font-extrabold text-base text-slate-800 line-clamp-1">Membaca Buku...</h3>
                </div>
                <div class="flex items-center gap-2">
                    <a id="download_pdf" href="#" download target="_blank" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-200 rounded-lg transition flex items-center gap-1">
                        <i class="fa-solid fa-download"></i> Unduh PDF
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
        // Modal Tambah
        function openModalTambah() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }
        function closeModalTambah() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        // Modal Edit (Khusus Route Petugas)
        function openModalEdit(buku) {
            const baseUrl = "{{ url('/petugas/buku') }}/";
            document.getElementById('formEdit').action = baseUrl + buku.id;
            document.getElementById('edit_judul_buku').value = buku.judul_buku;
            document.getElementById('edit_penulis').value = buku.penulis || '';
            document.getElementById('edit_kategori').value = buku.kategori;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
        function closeModalEdit() {
            document.getElementById('modalEdit').classList.add('hidden');
        }

        // Modal Baca PDF
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