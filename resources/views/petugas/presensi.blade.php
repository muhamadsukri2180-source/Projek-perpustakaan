<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Presensi & Statistik - Petugas Perpustakaan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .animated-gradient {
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
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ activeTab: 'data-absensi', selectedSiswa: null, modalDetail: false, modalScan: false, searchHariIni: '' }">

    <nav class="animated-gradient text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 text-white shadow-inner">
                        <i class="fa-solid fa-book-bookmark text-lg"></i>
                    </div>
                    <span class="font-extrabold text-xl tracking-wide text-white">Perpustakaan </span>
                </div>

                <div class="hidden md:flex items-center gap-1 font-medium text-sm">
                    <a href="{{ Route::has('petugas.dashboard') ? route('petugas.dashboard') : '#' }}" class="px-4 py-2 rounded-xl text-emerald-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ Route::has('petugas.siswa.index') ? route('petugas.siswa.index') : '#' }}" class="px-4 py-2 rounded-xl text-emerald-100 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Data Siswa
                    </a>
                    <a href="{{ Route::has('petugas.presensi') ? route('petugas.presensi') : '#' }}" class="px-4 py-2 rounded-xl bg-white/20 text-white font-semibold shadow-sm border border-white/20 backdrop-blur-sm transition">
                        <i class="fa-solid fa-clipboard-user mr-1.5 text-xs"></i> Presensi
                    </a>
                     <a href="{{ Route::has('petugas.laporan') ? route('petugas.laporan') : '#' }}"
                       class="px-4 py-2 rounded-xl text-emerald-100 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('petugas.laporan*') ? 'bg-white/20 font-bold text-white' : '' }}">
                        <i class="fa-solid fa-file-lines mr-1.5 text-xs"></i> Laporan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold leading-tight">{{ auth()->user()->name ?? 'Petugas' }}</span>
                    </div>

                    <a href="{{ route('petugas.profile') }}" 
                       title="Lihat Profil Petugas" 
                       class="w-9 h-9 rounded-full bg-white text-emerald-600 font-bold flex items-center justify-center text-sm shadow-md ring-2 ring-white/30 hover:ring-white hover:scale-105 active:scale-95 transition-all duration-200 group">
                        <span class="group-hover:text-emerald-700">{{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}</span>
                    </a>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar" class="w-9 h-9 rounded-xl text-white flex items-center justify-center text-sm ">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
            </div>
        </div>
    </nav>

    <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md shadow-emerald-200">
                        <i class="fa-solid fa-clipboard-user text-lg"></i>
                    </div>
                    Presensi & Analisis Statistik
                </h1>
                <p class="text-slate-500 mt-1 text-sm font-medium">Data harian di-reset otomatis setiap jam 00:00 WIB.</p>
            </div>

            <button @click="modalScan = true; setTimeout(() => $refs.scanInput.focus(), 200)" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-teal-200 transition flex items-center gap-2">
                <i class="fa-solid fa-barcode text-base"></i> Scan Barcode Masuk / Keluar
            </button>
        </div>

        <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-200/80 mb-6 overflow-x-auto flex gap-2">
            <button @click="activeTab = 'data-absensi'" :class="activeTab === 'data-absensi' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-list-check"></i> Data Absensi Hari Ini
            </button>
            <button @click="activeTab = 'riwayat-absensi'" :class="activeTab === 'riwayat-absensi' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Absensi
            </button>

            <div class="h-6 w-[1px] bg-slate-200 my-auto mx-1"></div>

            <button @click="activeTab = 'stat-pengunjung'" :class="activeTab === 'stat-pengunjung' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-chart-line"></i> Grafik Pengunjung
            </button>
            <button @click="activeTab = 'stat-kelas'" :class="activeTab === 'stat-kelas' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-school"></i> Per Kelas
            </button>
            <button @click="activeTab = 'stat-jurusan'" :class="activeTab === 'stat-jurusan' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-graduation-cap"></i> Per Jurusan
            </button>
        </div>

        <div class="space-y-6">

            <div x-show="activeTab === 'data-absensi'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Presensi Hari Ini ({{ \Carbon\Carbon::now()->translatedFormat('d F Y') }})</h2>
                        <p class="text-xs text-slate-400">Total Pengunjung Hari Ini: {{ count($absensiHariIni) }} Siswa</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="py-3 px-4">Siswa</th>
                                <th class="py-3 px-4">Kelas / Jurusan</th>
                                <th class="py-3 px-4">Jam Masuk</th>
                                <th class="py-3 px-4">Jam Keluar</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($absensiHariIni as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-semibold text-slate-800">
                                    {{ $item->siswa->nama ?? 'Siswa Tidak Ditemukan' }}<br>
                                    <span class="text-xs font-normal text-slate-400">NISN: {{ $item->siswa->nisn ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    {{ $item->siswa->kelas->nama_kelas ?? '-' }} - {{ $item->siswa->jurusan->nama_jurusan ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-emerald-600 font-medium">{{ $item->waktu_masuk }} WIB</td>
                                <td class="py-3 px-4 text-slate-500 italic">
                                    {{ $item->waktu_keluar ? $item->waktu_keluar . ' WIB' : 'Belum Keluar' }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($item->status == 'di_perpus')
                                        <span class="bg-amber-50 text-amber-600 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-bold">Di Perpus</span>
                                    @else
                                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-bold">Selesai</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <button @click="modalDetail = true; selectedSiswa = {{ json_encode($item) }}" class="px-3 py-1 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-lg text-xs font-semibold transition">
                                        <i class="fa-solid fa-eye mr-1"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400 text-xs font-medium">
                                    Belum ada siswa yang presensi hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="activeTab === 'riwayat-absensi'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <form method="GET" action="{{ route('petugas.presensi') }}" class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Riwayat Keseluruhan Absensi</h2>
                        <p class="text-xs text-slate-400">Arsip pencatatan histori presensi siswa</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="date" name="tanggal_filter" value="{{ request('tanggal_filter') }}" class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs outline-none">
                        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-emerald-700">Filter</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Siswa</th>
                                <th class="py-3 px-4">Kelas & Jurusan</th>
                                <th class="py-3 px-4">Waktu Masuk / Keluar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($riwayatAbsensi as $history)
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-700">{{ \Carbon\Carbon::parse($history->tanggal)->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">{{ $history->siswa->nama ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $history->siswa->kelas->nama_kelas ?? '' }} - {{ $history->siswa->jurusan->nama_jurusan ?? '' }}</td>
                                <td class="py-3 px-4 text-xs">{{ $history->waktu_masuk }} - {{ $history->waktu_keluar ?? 'Selesai' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-6 text-slate-400 text-xs">Data riwayat tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $riwayatAbsensi->links() }}</div>
            </div>

            <div x-show="activeTab === 'stat-pengunjung'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-1">Statistik Pengunjung (7 Hari Terakhir)</h2>
                <div class="h-72"><canvas id="chartPengunjung"></canvas></div>
            </div>

            <div x-show="activeTab === 'stat-kelas'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-1">Statistik Kunjungan Per Kelas</h2>
                <div class="h-72"><canvas id="chartKelas"></canvas></div>
            </div>

            <div x-show="activeTab === 'stat-jurusan'" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-1">Statistik Kunjungan Per Jurusan</h2>
                <div class="h-72 max-w-md mx-auto"><canvas id="chartJurusan"></canvas></div>
            </div>

        </div>
    </main>

    <div x-show="modalScan" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100" @click.away="modalScan = false">
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 class="font-extrabold text-slate-800 text-base">Scan Tap Barcode NISN</h3>
                <button @click="modalScan = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="formScanBarcode" onsubmit="event.preventDefault(); submitBarcode();">
                <div class="text-center py-4">
                    <i class="fa-solid fa-barcode text-6xl text-emerald-600 animate-pulse mb-3 block"></i>
                    <p class="text-xs text-slate-500 mb-4">Arahkan Scanner atau ketik NISN lalu tekan ENTER</p>
                    <input type="text" x-ref="scanInput" id="barcode_input" autocomplete="off" placeholder="Scan Barcode NISN..." class="w-full px-4 py-3 rounded-xl border border-emerald-400 focus:ring-4 focus:ring-emerald-100 outline-none text-center font-bold text-lg">
                </div>
            </form>
            <div id="scanAlert" class="mt-2 text-center text-xs font-bold hidden"></div>
        </div>
    </div>

    <div x-show="modalDetail" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100" @click.away="modalDetail = false">
            <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                <h3 class="font-extrabold text-slate-800 text-base">Detail Absensi Siswa</h3>
                <button @click="modalDetail = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <template x-if="selectedSiswa">
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-1 border-b"><span class="text-slate-400">Nama Siswa:</span><span class="font-bold text-slate-700" x-text="selectedSiswa.siswa ? selectedSiswa.siswa.nama : '-'"></span></div>
                    <div class="flex justify-between py-1 border-b"><span class="text-slate-400">NISN:</span><span class="font-bold text-slate-700" x-text="selectedSiswa.siswa ? selectedSiswa.siswa.nisn : '-'"></span></div>
                    <div class="flex justify-between py-1 border-b"><span class="text-slate-400">Waktu Tap Masuk:</span><span class="font-bold text-emerald-600" x-text="selectedSiswa.waktu_masuk + ' WIB'"></span></div>
                    <div class="flex justify-between py-1 border-b"><span class="text-slate-400">Waktu Tap Keluar:</span><span class="font-bold text-amber-600" x-text="selectedSiswa.waktu_keluar ? selectedSiswa.waktu_keluar + ' WIB' : 'Belum Keluar'"></span></div>
                </div>
            </template>
            <button @click="modalDetail = false" class="w-full mt-6 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2 rounded-xl font-bold text-xs">Tutup</button>
        </div>
    </div>

    <script>
        function submitBarcode() {
            const barcodeVal = document.getElementById('barcode_input').value;
            const alertDiv = document.getElementById('scanAlert');

            if(!barcodeVal) return;
            .then(res => res.json())
            .then(data => {
                alertDiv.classList.remove('hidden', 'text-red-600', 'text-emerald-600');
                if(data.success) {
                    alertDiv.classList.add('text-emerald-600');
                    alertDiv.innerText = data.message;
                    document.getElementById('barcode_input').value = '';
                    setTimeout(() => { location.reload(); }, 1200);
                } else {
                    alertDiv.classList.add('text-red-600');
                    alertDiv.innerText = data.message;
                    document.getElementById('barcode_input').value = '';
                }
            })
            .catch(err => console.error(err));
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Data Grafik dari Controller
            const dataPengunjung = @json(array_values($chartPengunjung ?? []));
            const labelsPengunjung = @json(array_keys($chartPengunjung ?? []));

            const labelsKelas = @json(($chartKelas ?? collect())->pluck('nama_kelas'));
            const dataKelas = @json(($chartKelas ?? collect())->pluck('total_kunjungan'));

            const labelsJurusan = @json(($chartJurusan ?? collect())->pluck('nama_jurusan'));
            const dataJurusan = @json(($chartJurusan ?? collect())->pluck('total_kunjungan'));

            // Chart 1: Pengunjung
            new Chart(document.getElementById('chartPengunjung'), {
                type: 'line',
                data: {
                    labels: labelsPengunjung,
                    datasets: [{ label: 'Total Pengunjung', data: dataPengunjung, borderColor: '#059669', backgroundColor: 'rgba(5, 150, 105, 0.1)', tension: 0.3, fill: true }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Chart 2: Per Kelas
            new Chart(document.getElementById('chartKelas'), {
                type: 'bar',
                data: {
                    labels: labelsKelas,
                    datasets: [{ label: 'Jumlah Kunjungan', data: dataKelas, backgroundColor: '#10b981' }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Chart 3: Per Jurusan
            new Chart(document.getElementById('chartJurusan'), {
                type: 'doughnut',
                data: {
                    labels: labelsJurusan,
                    datasets: [{ data: dataJurusan, backgroundColor: ['#059669', '#10b981', '#14b8a6', '#84cc16', '#22c55e'] }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
</body>
</html>