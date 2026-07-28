<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Petugas - Perpustakaan Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ Route::has('admin.siswa') ? route('admin.siswa') : '#' }}"
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Data Siswa
                    </a>
                    <a href="{{ Route::has('admin.petugas.index') ? route('admin.petugas.index') : '#' }}"
                       class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/20 backdrop-blur-sm transition">
                         <i class="fa-solid fa-user-tie mr-1.5 text-xs"></i> Kelola Petugas
                    </a>
                    <a href="{{ Route::has('admin.presensi') ? route('admin.presensi') : '#' }}"
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-clipboard-user mr-1.5 text-xs"></i> Presensi
                    </a>
                    <a href="{{ Route::has('admin.laporan.harian') ? route('admin.laporan.harian') : '#' }}"
                       class="px-4 py-2 rounded-xl text-blue-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-file-lines mr-1.5 text-xs"></i> Laporan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight">Admin</span>
                    </div>

                    <a href="{{ Route::has('admin.profile') ? route('admin.profile') : '#' }}"
                       title="Lihat Profil Admin"
                       class="w-9 h-9 rounded-full bg-white text-blue-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:ring-white hover:scale-105 active:scale-95 transition-all duration-200 group">
                        <span class="group-hover:text-blue-700">A</span>
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col justify-between">

        <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">

            @if(session('success'))
            <div id="alertSuccess" class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('alertSuccess').remove()" class="text-emerald-500 hover:text-emerald-700 font-bold text-lg px-2">
                    &times;
                </button>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                    <h4 class="font-bold text-sm">Terjadi Kesalahan:</h4>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-200">
                            <i class="fa-solid fa-user-shield text-lg"></i>
                        </div>
                        Kelola Data Petugas
                    </h1>
                    <p class="text-slate-500 mt-1 text-sm font-medium">
                        Manajemen data petugas perpustakaan beserta barcode presensinya.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-semibold shadow-md shadow-blue-200 transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Petugas Baru
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Petugas</p>
                        <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ count($petugasList ?? []) }}</h3>
                        <span class="text-[11px] text-blue-600 font-semibold bg-blue-50 px-2.5 py-0.5 rounded-md mt-2 inline-block">Terdaftar</span>
                    </div>
                    <div class="w-12 h-12 bg-indigo-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 text-xl">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Akun</p>
                        <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">Aktif</h3>
                        <span class="text-[11px] text-emerald-600 font-semibold bg-emerald-50 px-2.5 py-0.5 rounded-md mt-2 inline-block">Siap Bertugas</span>
                    </div>
                    <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 text-xl">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Akses Masuk</p>
                        <h3 class="text-2xl font-extrabold text-slate-800 mt-1">Barcode</h3>
                        <span class="text-[11px] text-amber-600 font-semibold bg-amber-50 px-2.5 py-0.5 rounded-md mt-2 inline-block">Scan NIK</span>
                    </div>
                    <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 text-xl">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Daftar Petugas Perpustakaan</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Kelola data & barcode akses petugas</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="py-3.5 px-6">Nama Petugas</th>
                                <th class="py-3.5 px-6">NIK</th>
                                <th class="py-3.5 px-6">Tanggal Terdaftar</th>
                                <th class="py-3.5 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($petugasList ?? [] as $petugas)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs uppercase shadow-sm overflow-hidden shrink-0 border border-slate-200">
                                        @if(!empty($petugas->foto))
                                            <img src="{{ asset('storage/' . $petugas->foto) }}" alt="{{ $petugas->nama }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($petugas->nama ?? 'P', 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="leading-tight">{{ $petugas->nama ?? '-' }}</p>
                                        <span class="text-[11px] text-slate-400 font-normal">Petugas Perpustakaan</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-700">
                                    <i class="fa-solid fa-id-card text-slate-400 mr-1.5"></i>
                                    {{ $petugas->nik ?? '-' }}
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-700">
                                    <i class="fa-regular fa-calendar text-slate-400 mr-1.5"></i>
                                    {{ $petugas->created_at ? $petugas->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.petugas.barcode.generate', ['id' => $petugas->id]) }}" class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center text-xs font-semibold" title="Lihat Barcode">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </a>

                                        <form action="{{ route('admin.petugas.destroy', $petugas->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition flex items-center justify-center text-xs font-semibold" title="Hapus Petugas">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400 font-medium">
                                    <i class="fa-solid fa-user-slash text-4xl mb-3 text-slate-300 block"></i>
                                    Belum ada data petugas yang terdaftar.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400 mt-8">
            <p>&copy; {{ date('Y') }} Sistem Presensi Perpustakaan Digital. All rights reserved.</p>
        </footer>

    </div>

    <div id="modalTambah" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-md mx-4 p-6 transform scale-95 transition-transform duration-300" id="modalCard">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-blue-600"></i> Tambah Petugas Baru
                </h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 font-bold text-xl px-2">
                    &times;
                </button>
            </div>

            <form action="{{ route('admin.petugas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Masukkan nama petugas" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">NIK</label>
                    <input type="text" name="nik" required placeholder="Masukkan NIK petugas" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Foto Petugas</label>
                    <div class="relative flex items-center">
                        <input type="file" name="foto" id="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 border border-slate-200 rounded-xl p-1 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition cursor-pointer">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-md shadow-blue-200 transition">
                        Simpan &amp; Buat Barcode
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalTambah');
        const modalCard = document.getElementById('modalCard');

        function openModal() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalCard.classList.remove('scale-95');
                modalCard.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modalCard.classList.remove('scale-100');
            modalCard.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>