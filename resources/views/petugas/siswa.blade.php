<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Petugas Perpustakaan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .animated-gradient {
            background: linear-gradient(-45deg, #0f766e, #0d9488, #14b8a6, #0284c7);
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
                    <a href="{{ Route::has('petugas.dashboard') ? route('petugas.dashboard') : '#' }}" 
                       class="px-4 py-2 rounded-xl text-teal-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ Route::has('petugas.siswa.index') ? route('petugas.siswa.index') : (Route::has('petugas.siswa') ? route('petugas.siswa') : '#') }}" 
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/20 backdrop-blur-sm transition">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Data Siswa
                    </a>
                    <a href="{{ Route::has('petugas.presensi') ? route('petugas.presensi') : '#' }}" 
                       class="px-4 py-2 rounded-xl text-teal-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-clipboard-user mr-1.5 text-xs"></i> Presensi
                    </a>
                    <a href="{{ Route::has('petugas.laporan') ? route('petugas.laporan') : '#' }}" 
                       class="px-4 py-2 rounded-xl text-teal-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-file-lines mr-1.5 text-xs"></i> Laporan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight">Petugas</span>
                        <span class="text-[10px] text-teal-100 font-medium">Sesi Aktif</span>
                    </div>

                    <a href="{{ Route::has('petugas.profile') ? route('petugas.profile') : '#' }}" 
                       title="Lihat Profil Petugas" 
                       class="w-9 h-9 rounded-full bg-white text-teal-700 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:ring-white hover:scale-105 active:scale-95 transition-all duration-200 group">
                        <span class="group-hover:text-teal-800">P</span>
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col justify-between">
        
        <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">

            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-2xl flex items-center justify-between">
                    <span><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
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

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2.5">
                        Data Siswa
                    </h1>
                    <p class="text-slate-500 mt-0.5 text-xs font-medium">
                        Cari data siswa terdaftar, cetak barcode kartu pustaka, atau tambahkan siswa baru.
                    </p>
                </div>
                <button type="button" onclick="openModalTambah()" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Siswa</span>
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                
                <form action="{{ Route::has('petugas.siswa.index') ? route('petugas.siswa.index') : (Route::has('petugas.siswa') ? route('petugas.siswa') : '#') }}" method="GET" class="p-4 sm:p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="relative w-full md:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NISN..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition">
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-semibold transition">
                            <i class="fa-solid fa-filter mr-1"></i> Filter Data
                        </button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="py-3.5 px-6">Siswa</th>
                                <th class="py-3.5 px-6">NISN / NIS</th>
                                <th class="py-3.5 px-6">Kelas & Jurusan</th>
                                <th class="py-3.5 px-6">Jenis Kelamin</th>
                                <th class="py-3.5 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($siswaList ?? [] as $siswa)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs uppercase shadow-sm overflow-hidden">
                                        @if(isset($siswa->foto) && $siswa->foto)
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($siswa->nama ?? 'S', 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="leading-tight">{{ $siswa->nama }}</p>
                                        <span class="text-[11px] text-slate-400 font-normal">{{ $siswa->email ?? 'Siswa Perpus' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-700">
                                    <span class="font-mono text-xs bg-slate-100 px-2 py-0.5 rounded text-slate-600 border border-slate-200/60">
                                        {{ $siswa->nisn }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-teal-50 text-teal-700 px-2.5 py-1 rounded-md text-xs font-semibold border border-teal-100">
                                        {{ $siswa->kelas->nama_kelas ?? $siswa->kelas->nama ?? 'Kelas -' }} - {{ $siswa->jurusan->nama_jurusan ?? $siswa->jurusan->nama ?? $siswa->jurusan->kode_jurusan ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-700">
                                    {{ ($siswa->jenis_kelamin ?? 'L') == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ Route::has('petugas.siswa.show') ? route('petugas.siswa.show', $siswa->id) : '#' }}" 
                                           title="Detail Siswa"
                                           class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-teal-50 text-slate-600 hover:text-teal-600 flex items-center justify-center text-xs transition">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <a href="{{ Route::has('petugas.siswa.edit') ? route('petugas.siswa.edit', $siswa->id) : '#' }}" 
                                           title="Edit Data Siswa"
                                           class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 flex items-center justify-center text-xs transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <a href="{{ Route::has('petugas.barcode.generate') ? route('petugas.barcode.generate', ['id' => $siswa->id]) : '#' }}" 
                                           title="Generate & Cetak Barcode"
                                           class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 flex items-center justify-center text-xs transition">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                                    <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i>
                                    Belum ada data siswa ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($siswaList) && method_exists($siswaList, 'links'))
                <div class="p-4 border-t border-slate-100">
                    {{ $siswaList->links() }}
                </div>
                @endif

            </div>

        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-8">
            <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital - Panel Petugas.</p>
        </footer>

    </div>

    <div id="modalTambahSiswa" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white max-w-lg w-full rounded-2xl shadow-xl border border-slate-100 p-6 relative">
            
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Tambah Data Siswa</h3>
                    <p class="text-xs text-slate-400">Pendaftaran siswa baru perpustakaan.</p>
                </div>
                <button type="button" onclick="closeModalTambah()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ Route::has('petugas.siswa.store') ? route('petugas.siswa.store') : '#' }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">NISN / NIS <span class="text-rose-500">*</span></label>
                    <input type="text" name="nisn" required placeholder="Contoh: 0012345678" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required placeholder="Masukkan nama siswa" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas <span class="text-rose-500">*</span></label>
                        <select name="kelas_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="1">X</option>
                            <option value="2">XI</option>
                            <option value="3">XII</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Jurusan <span class="text-rose-500">*</span></label>
                        <select name="jurusan_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition">
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="1">RPL 1</option>
                            <option value="2">RPL 2</option>
                            <option value="3">BR 1</option>
                            <option value="4">BR 2</option>
                            <option value="5">MP</option>
                            <option value="6">AK 1</option>
                            <option value="7">AK 2</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition">
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Foto Siswa (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-600 hover:file:bg-teal-100">
                </div>

                <div class="pt-3 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeModalTambah()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-md transition">
                        Simpan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModalTambah() {
            document.getElementById('modalTambahSiswa').classList.remove('hidden');
        }
        function closeModalTambah() {
            document.getElementById('modalTambahSiswa').classList.add('hidden');
        }
        
        @if ($errors->any())
            openModalTambah();
        @endif
    </script>
</body>
</html>