<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
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
        $riwayatAbsensi = $queryRiwayat->latest('tanggal')
            ->latest('waktu_masuk')
            ->paginate(15);

        // 3. Data Grafik Pengunjung (7 Hari Terakhir)
        $chartPengunjungRaw = Absensi::select(
                DB::raw('DATE(tanggal) as date'), 
                DB::raw('count(*) as total')
            )
            ->where('tanggal', '>=', Carbon::now()->subDays(6)->toDateString())
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $chartPengunjung = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labelDate = Carbon::now()->subDays($i)->format('d M');
            $chartPengunjung[$labelDate] = $chartPengunjungRaw[$date] ?? 0;
        }

        // 4. Hitung kunjungan per kelas (Disimpan dalam Array PHP biasa)
        $chartKelasRaw = Absensi::with('siswa.kelas')
            ->get()
            ->groupBy(function($item) {
                return $item->siswa->kelas->nama_kelas ?? 'Tanpa Kelas';
            });

        $chartKelas = [];
        foreach ($chartKelasRaw as $kelas => $items) {
            $chartKelas[$kelas] = $items->count();
        }

        // 5. Hitung kunjungan per jurusan (Disimpan dalam Array PHP biasa)
        $chartJurusanRaw = Absensi::with('siswa.jurusan')
            ->get()
            ->groupBy(function($item) {
                return $item->siswa->jurusan->nama_jurusan ?? 'Tanpa Jurusan';
            });

        $chartJurusan = [];
        foreach ($chartJurusanRaw as $jurusan => $items) {
            $chartJurusan[$jurusan] = $items->count();
        }

        return view('admin.presensi', compact(
            'absensiHariIni',
            'riwayatAbsensi',
            'chartPengunjung',
            'chartKelas',
            'chartJurusan'
        ));
    }

    public function scanBarcode(Request $request)
    {
        $request->validate([
            'barcode_nisn' => 'required|string'
        ]);

        $code = trim($request->barcode_nisn);

        // Cari berdasarkan NISN atau barcode_code
        $siswa = Siswa::where('nisn', $code)
            ->orWhere('barcode_code', $code)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false, 
                'message' => 'Siswa tidak ditemukan!'
            ], 404);
        }

        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $absensiAktif = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->where('status', 'di_perpus')
            ->first();

        if ($absensiAktif) {
            $absensiAktif->update([
                'waktu_keluar' => $currentTime,
                'status'       => 'selesai'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absen Keluar Berhasil! Terima kasih, ' . $siswa->nama,
                'type'    => 'keluar'
            ]);
        } else {
            Absensi::create([
                'siswa_id'    => $siswa->id,
                'tanggal'     => $today,
                'waktu_masuk' => $currentTime,
                'status'      => 'di_perpus'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Selamat Datang, ' . $siswa->nama . '!',
                'type'    => 'masuk'
            ]);
        }
    }
}