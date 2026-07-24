<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa - Perpustakaan Digital</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="max-w-lg w-full bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        
        <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Tambah Data Siswa</h1>
                <p class="text-xs text-slate-400">Isi formulir berikut untuk menambahkan siswa baru.</p>
            </div>
            <a href="{{ route('admin.siswa') }}" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-xs transition">
                <i class="fa-solid fa-xmark"></i>
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-600">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">NISN / NIS <span class="text-rose-500">*</span></label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="Contoh: 0012345678" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama siswa" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas <span class="text-rose-500">*</span></label>
                    <select name="kelas_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelases ?? [] as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas ?? $kelas->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jurusan <span class="text-rose-500">*</span></label>
                    <select name="jurusan_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusans ?? [] as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan ?? $jurusan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Foto Siswa (Opsional)</label>
                <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
            </div>

            <div class="pt-3 flex items-center justify-end gap-2">
                <a href="{{ route('admin.siswa') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md transition">
                    Simpan Data
                </button>
            </div>
        </form>

    </div>

</body>
</html>