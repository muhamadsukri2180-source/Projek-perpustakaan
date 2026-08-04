<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku Digital - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

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

    <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold flex items-center justify-between">
                <span><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Kelola Buku Digital</h1>
                <p class="text-slate-500 text-sm">Daftar seluruh buku digital yang tersedia.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-max">
                <button onclick="openModalTambah()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-blue-200 flex items-center justify-center gap-2 transition w-max">
                    <i class="fa-solid fa-plus"></i> Tambah Buku Baru
                </button>

                {{-- Tombol navigasi ke halaman Google Books --}}
                <a href="{{ Route::has('admin.google-books') ? route('admin.google-books') : '#' }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-200 flex items-center justify-center gap-2 transition w-max">
                    <i class="fa-solid fa-globe"></i> Google Books
                </a>
            </div>
        </div>

        <div class="mb-6">
            <form action="{{ Route::has('admin.buku') ? route('admin.buku') : '#' }}" method="GET" class="flex gap-2">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul, penulis, atau kategori..." 
                       class="w-full max-w-md px-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-slate-700 transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bukuDigitals as $buku)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between p-4">
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
                                <button onclick="openModalBaca('{{ asset('storage/' . $buku->file_pdf) }}', '{{ addslashes($buku->judul_buku) }}')" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-lg flex items-center gap-2 transform translate-y-2 group-hover:translate-y-0 transition-all">
                                    <i class="fa-solid fa-book-open"></i> Baca Sekarang
                                </button>
                            </div>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base line-clamp-1">{{ $buku->judul_buku }}</h3>
                        <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-user-pen mr-1"></i>{{ $buku->penulis ?? 'Tidak Diketahui' }}</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <button onclick="openModalBaca('{{ asset('storage/' . $buku->file_pdf) }}', '{{ addslashes($buku->judul_buku) }}')" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-file-pdf"></i> Baca PDF
                        </button>

                        <div class="flex items-center gap-3">
                            <button type="button"
                                data-id="{{ $buku->id }}"
                                data-judul="{{ $buku->judul_buku }}"
                                data-penulis="{{ $buku->penulis }}"
                                data-kategori="{{ $buku->kategori }}"
                                onclick="openModalEdit(this)" 
                                class="text-xs font-semibold text-amber-600 hover:text-amber-700 flex items-center gap-1">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>

                            <form action="{{ Route::has('admin.buku.destroy') ? route('admin.buku.destroy', $buku->id) : url('/admin/buku/' . $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700 flex items-center gap-1">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-100 text-slate-400">
                    <i class="fa-solid fa-book-open text-4xl mb-3"></i>
                    <p class="text-sm">Belum ada buku digital yang ditambahkan.</p>
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
                <h3 class="font-bold text-lg text-slate-800">Tambah Buku Baru</h3>
                <button onclick="closeModalTambah()" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ Route::has('admin.buku.store') ? route('admin.buku.store') : url('/admin/buku') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Buku *</label>
                    <input type="text" name="judul_buku" required class="w-full px-3 py-2 border rounded-xl text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Penulis</label>
                        <input type="text" name="penulis" class="w-full px-3 py-2 border rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori *</label>
                        <input type="text" name="kategori" value="Umum" required class="w-full px-3 py-2 border rounded-xl text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Cover (Gambar)</label>
                    <input type="file" name="cover" accept="image/*" class="w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">File PDF *</label>
                    <input type="file" name="file_pdf" accept="application/pdf" required class="w-full text-xs">
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t">
                    <button type="button" onclick="closeModalTambah()" class="px-4 py-2 text-xs font-semibold text-slate-600">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-slate-800">Edit Buku</h3>
                <button onclick="closeModalEdit()" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form id="formEdit" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Buku *</label>
                    <input type="text" id="edit_judul_buku" name="judul_buku" required class="w-full px-3 py-2 border rounded-xl text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Penulis</label>
                        <input type="text" id="edit_penulis" name="penulis" class="w-full px-3 py-2 border rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori *</label>
                        <input type="text" id="edit_kategori" name="kategori" required class="w-full px-3 py-2 border rounded-xl text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Ganti Cover (Opsional)</label>
                    <input type="file" name="cover" accept="image/*" class="w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Ganti PDF (Opsional)</label>
                    <input type="file" name="file_pdf" accept="application/pdf" class="w-full text-xs">
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t">
                    <button type="button" onclick="closeModalEdit()" class="px-4 py-2 text-xs font-semibold text-slate-600">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-xl text-xs font-semibold">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalBaca" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md hidden z-50 flex items-center justify-center p-2 sm:p-6">
        <div class="bg-white rounded-2xl w-full max-w-5xl h-[90vh] flex flex-col shadow-2xl overflow-hidden">
            <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
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
        // Modal Tambah
        function openModalTambah() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }
        function closeModalTambah() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        // Modal Edit
        function openModalEdit(button) {
            const id = button.dataset.id;
            const judul = button.dataset.judul;
            const penulis = button.dataset.penulis;
            const kategori = button.dataset.kategori;

            document.getElementById('formEdit').action = '/admin/buku/' + id;
            
            document.getElementById('edit_judul_buku').value = judul;
            document.getElementById('edit_penulis').value = penulis || '';
            document.getElementById('edit_kategori').value = kategori;

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