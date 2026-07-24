<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    /**
     * Display Admin Dashboard.
     */
    public function dashboard()
    {
        $today = Carbon::today();

        // 1. Counter Ringkasan Data
        $totalSiswa = Siswa::count();
        $totalPetugas = Petugas::count();

        // Jumlah siswa yang masuk hari ini
        $pengunjungHariIni = Absensi::whereDate('created_at', $today)->count();

        // Jumlah siswa yang masih berada di perpustakaan
        $sedangDiPerpus = Absensi::whereDate('created_at', $today)
            ->whereNull('waktu_keluar')
            ->count();

        // 2. Data Absensi Terbaru (5 Transaksi Terakhir)
        $absensiTerbaru = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Data Grafik Kunjungan 7 Hari Terakhir (Senin - Minggu)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $grafikData = Absensi::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'tanggal')
            ->toArray();

        $chartData = [];
        for ($date = $startOfWeek->clone(); $date->lte($endOfWeek); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $chartData[] = $grafikData[$formattedDate] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalPetugas',
            'pengunjungHariIni',
            'sedangDiPerpus',
            'absensiTerbaru',
            'chartData'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA: SISWA
    |--------------------------------------------------------------------------
    */

    public function siswaIndex(Request $request)
    {
        $query = Siswa::with(['kelas', 'jurusan']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswaList = $query->latest()->paginate(10);
        $kelasList = Kelas::all();
        $jurusanList = Jurusan::all();

        return view('admin.siswa', compact('siswaList', 'kelasList', 'jurusanList'));
    }

    public function siswaCreate()
    {
        $kelasList = Kelas::all();
        $jurusanList = Jurusan::all();

        return view('admin.siswa-create', compact('kelasList', 'jurusanList'));
    }

    public function siswaStore(Request $request)
    {
        $validatedData = $request->validate([
            'nisn'          => 'required|unique:siswas,nisn',
            'nama'          => 'required|string|max:255',
            'kelas_id'      => 'required|exists:kelas,id',
            'jurusan_id'    => 'required|exists:jurusans,id',
            'jenis_kelamin' => 'nullable|in:L,P',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa = Siswa::create($validatedData);

        // Setelah siswa berhasil ditambahkan, arahkan ke halaman
        // generate barcode supaya admin bisa langsung melihat & unduh QR-nya.
        return redirect()
            ->route('admin.barcode.generate', ['id' => $siswa->id])
            ->with('success', 'Data siswa berhasil ditambahkan. Silakan unduh barcode siswa.');
    }

    public function siswaShow($id)
    {
        $siswa = Siswa::with(['kelas', 'jurusan', 'absensis'])->findOrFail($id);

        return view('admin.siswa-show', compact('siswa'));
    }

    public function siswaEdit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelasList = Kelas::all();
        $jurusanList = Jurusan::all();

        return view('admin.siswa-edit', compact('siswa', 'kelasList', 'jurusanList'));
    }

    public function siswaUpdate(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validatedData = $request->validate([
            'nisn'          => 'required|unique:siswas,nisn,' . $id,
            'nama'          => 'required|string|max:255',
            'kelas_id'      => 'required|exists:kelas,id',
            'jurusan_id'    => 'required|exists:jurusans,id',
            'jenis_kelamin' => 'nullable|in:L,P',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($validatedData);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function siswaDestroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA: KELAS, JURUSAN & BARCODE
    |--------------------------------------------------------------------------
    */

    public function kelasIndex()
    {
        $kelasList = Kelas::withCount('siswas')->get();
        return view('admin.kelas', compact('kelasList'));
    }

    public function jurusanIndex()
    {
        $jurusanList = Jurusan::withCount('siswas')->get();
        return view('admin.jurusan', compact('jurusanList'));
    }

    public function barcodeGenerate(Request $request)
    {
        $siswaSelected = null;
        $qrCode = null;

        if ($request->has('id')) {
            $siswaSelected = Siswa::with(['kelas', 'jurusan'])->find($request->id);

            if ($siswaSelected) {
                // QR berisi NISN siswa, dipakai untuk scan presensi / login.
                $qrCode = QrCode::format('svg')
                    ->size(300)
                    ->margin(1)
                    ->generate($siswaSelected->nisn);
            }
        }

        $siswaList = Siswa::select('id', 'nama', 'nisn')->get();

        return view('admin.barcode-generate', compact('siswaSelected', 'siswaList', 'qrCode'));
    }

    /**
     * Unduh barcode/QR code siswa dalam format SVG.
     */
    public function barcodeDownload($id)
    {
        $siswa = Siswa::findOrFail($id);

        $qrImage = QrCode::format('svg')
            ->size(500)
            ->margin(1)
            ->generate($siswa->nisn);

        $filename = 'barcode-' . $siswa->nisn . '.svg';

        return response($qrImage)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA PETUGAS (DI DALAM ADMIN CONTROLLER)
    |--------------------------------------------------------------------------
    */

    public function petugasIndex()
    {
        $petugasList = Petugas::latest()->get();
        return view('admin.petugas', compact('petugasList'));
    }

    public function petugasStore(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:petugas,email',
            'password' => 'required|string|min:6',
        ]);

        Petugas::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function petugasDestroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus!');
    }

    /*
    |--------------------------------------------------------------------------
    | FITUR PRESENSI & SCANNER BARCODE
    |--------------------------------------------------------------------------
    */

    public function presensiIndex()
    {
        $today = Carbon::today();

        $absensiHariIni = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        $riwayatAbsensi = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->latest()
            ->paginate(15);

        return view('admin.presensi', compact('absensiHariIni', 'riwayatAbsensi'));
    }

    public function presensiScan(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|exists:siswas,nisn',
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();
        $today = Carbon::today();

        $absensiAktif = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('created_at', $today)
            ->whereNull('waktu_keluar')
            ->first();

        if ($absensiAktif) {
            $absensiAktif->update([
                'waktu_keluar' => Carbon::now()
            ]);

            return redirect()->back()->with('success', 'Absen Keluar Berhasil! Terima kasih, ' . $siswa->nama);
        } else {
            Absensi::create([
                'siswa_id'    => $siswa->id,
                'waktu_masuk' => Carbon::now()
            ]);

            return redirect()->back()->with('success', 'Absen Masuk Berhasil! Selamat datang, ' . $siswa->nama);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | REKAP LAPORAN (HARIAN, MINGGUAN, BULANAN, TAHUNAN)
    |--------------------------------------------------------------------------
    */

    public function laporanIndex()
    {
        return view('admin.laporan');
    }

    public function laporanHarian(Request $request)
    {
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());

        $laporanHarian = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->whereDate('created_at', $tanggal)
            ->get();

        return view('admin.laporan', compact('laporanHarian', 'tanggal'));
    }

    public function laporanMingguan(Request $request)
    {
        $tahun = $request->get('tahun', Carbon::now()->year);
        $minggu = $request->get('minggu', Carbon::now()->weekOfYear);

        $laporanMingguan = Absensi::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('count(*) as total')
            )
            ->whereYear('created_at', $tahun)
            ->where(DB::raw('WEEK(created_at, 1)'), $minggu)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        return view('admin.laporan', compact('laporanMingguan', 'tahun', 'minggu'));
    }

    public function laporanBulanan(Request $request)
    {
        $bulanInput = $request->get('bulan', Carbon::now()->format('Y-m'));
        [$tahun, $bulan] = explode('-', $bulanInput);

        $laporanBulanan = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->get();

        return view('admin.laporan', compact('laporanBulanan', 'bulanInput'));
    }

    public function laporanTahunan(Request $request)
    {
        $tahun = $request->get('tahun', Carbon::now()->year);

        $laporanTahunan = Absensi::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('count(*) as total')
            )
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        return view('admin.laporan', compact('laporanTahunan', 'tahun'));
    }
    
    public function statistikPengunjung()
    {
        return view('admin.presensi');
    }

    /*
    |--------------------------------------------------------------------------
    | MANAJEMEN PROFIL ADMIN
    |--------------------------------------------------------------------------
    */

    public function profileIndex()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    public function profile()
    {
        return $this->profileIndex();
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function profilePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()->withErrors(['password_lama' => 'Password lama tidak sesuai!']);
        }

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}