<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full text-center">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Perpustakaan</h1>
            <p class="text-gray-500 mt-2 text-sm">Pilih peran Anda untuk melanjutkan masuk ke sistem</p>
        </div>

        <div class="space-y-4">
            <a href="{{ route('login.role', 'siswa') }}" 
               class="w-full flex items-center justify-center px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition duration-200 shadow-md hover:shadow-lg">
                Masuk sebagai Siswa
            </a>

            <a href="{{ route('login.role', 'petugas') }}" 
               class="w-full flex items-center justify-center px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition duration-200 shadow-md hover:shadow-lg">
                Masuk sebagai Petugas
            </a>

            <a href="{{ route('login.role', 'admin') }}" 
               class="w-full flex items-center justify-center px-6 py-3.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl transition duration-200 shadow-md hover:shadow-lg">
                Masuk sebagai Admin
            </a>
        </div>
    </div>

</body>
</html>