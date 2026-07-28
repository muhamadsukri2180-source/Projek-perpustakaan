<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();

        // 1. Data Absensi Hari Ini
        $absensiHariIni = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->where('tanggal', $today)
            ->latest('waktu_masuk')
            ->get();

        // 2. Filter Riwayat Absensi
        $queryRiwayat = Absensi::with(['siswa.kelas', 'siswa.jurusan']);
        if ($request->filled('tanggal_filter')) {
            $queryRiwayat->where('tanggal', $request->tanggal_filter);
        } else {
            $queryRiwayat->where('tanggal', '<', $today);
        }
        $riwayatAbsensi = $queryRiwayat->latest('tanggal')->latest('waktu_masuk')->paginate(15);

        // 3. Data Statistik Pengunjung 7 Hari Terakhir
        $chartPengunjung = Absensi::select(DB::raw('DATE(tanggal) as date'), DB::raw('count(*) as total'))
            ->where('tanggal', '>=', Carbon::now()->subDays(6)->toDateString())
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('total', 'date')
            ->toArray();

        // 4. Data Statistik Per Kelas (Diubah dari 'siswas' ke 'siswa')
        $chartKelas = Kelas::withCount(['siswa as total_kunjungan' => function ($q) {
            $q->whereHas('absensis');
        }])->get();

        // 5. Data Statistik Per Jurusan (Diubah dari 'siswas' ke 'siswa')
        $chartJurusan = Jurusan::withCount(['siswa as total_kunjungan' => function ($q) {
            $q->whereHas('absensis');
        }])->get();

        return view('admin.presensi', compact(
            'absensiHariIni',
            'riwayatAbsensi',
            'chartPengunjung',
            'chartKelas',
            'chartJurusan'
        ));
    }

    // Endpoint Proses Scan Barcode (Ajax / Form Request)
    public function scanBarcode(Request $request)
    {
        $request->validate([
            'barcode_nisn' => 'required|string'
        ]);

        $siswa = Siswa::where('nisn', $request->barcode_nisn)->first();

        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan!'], 404);
        }

        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        // Cek apakah siswa sudah tap masuk hari ini dan belum keluar
        $absensiAktif = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->where('status', 'di_perpus')
            ->first();

        if ($absensiAktif) {
            // Jika sudah ada, jadikan ini Tap Keluar
            $absensiAktif->update([
                'waktu_keluar' => $currentTime,
                'status' => 'selesai'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absen Keluar Berhasil! Terima kasih, ' . $siswa->nama,
                'type' => 'keluar'
            ]);
        } else {
            // Jika belum ada, catat Tap Masuk
            Absensi::create([
                'siswa_id' => $siswa->id,
                'tanggal' => $today,
                'waktu_masuk' => $currentTime,
                'status' => 'di_perpus'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Selamat Datang, ' . $siswa->nama . '!',
                'type' => 'masuk'
            ]);
        }
    }
}