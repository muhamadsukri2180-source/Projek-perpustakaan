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

        $totalSiswa = Siswa::count();
        $totalPetugas = Petugas::count();

        $pengunjungHariIni = Absensi::whereDate('created_at', $today)->count();

        $sedangDiPerpus = Absensi::whereDate('created_at', $today)
            ->whereNull('waktu_keluar')
            ->count();

        $absensiTerbaru = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->latest()
            ->take(5)
            ->get();

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
            $query->where(function ($q) use ($search) {
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
        // Validasi disesuaikan agar tidak mengecek 'exists' di tabel database kelas/jurusan
        $validatedData = $request->validate([
            'nisn'          => 'required|string|max:50|unique:siswa,nisn',
            'nama'          => 'required|string|max:255',
            'kelas_id'      => 'required', // Menerima pilihan kelas tanpa cek database
            'jurusan_id'    => 'required', // Menerima pilihan jurusan tanpa cek database
            'jenis_kelamin' => 'nullable|in:L,P',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'kelas_id.required'   => 'Kelas wajib dipilih.',
            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'nisn.unique'         => 'NISN / NIS sudah terdaftar.',
        ]);

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa = Siswa::create($validatedData);

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
            'nisn'          => 'required|string|max:50|unique:siswa,nisn,' . $id,
            'nama'          => 'required|string|max:255',
            'kelas_id'      => 'required',
            'jurusan_id'    => 'required',
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
    | MASTER DATA: KELAS, JURUSAN & BARCODE SISWA
    |--------------------------------------------------------------------------
    */

    public function kelasIndex()
    {
        $kelasList = Kelas::withCount('siswa')->get();
        return view('admin.kelas', compact('kelasList'));
    }

    public function jurusanIndex()
    {
        $jurusanList = Jurusan::withCount('siswa')->get();
        return view('admin.jurusan', compact('jurusanList'));
    }

    public function barcodeGenerate(Request $request)
    {
        $siswaSelected = null;
        $qrCode = null;

        if ($request->has('id')) {
            $siswaSelected = Siswa::with(['kelas', 'jurusan'])->find($request->id);

            if ($siswaSelected) {
                $qrCode = QrCode::format('svg')
                    ->size(300)
                    ->margin(1)
                    ->generate($siswaSelected->nisn);
            }
        }

        $siswaList = Siswa::select('id', 'nama', 'nisn')->get();

        return view('admin.barcode-generate', compact('siswaSelected', 'siswaList', 'qrCode'));
    }

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
    | KELOLA PETUGAS
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
            'nama' => 'required|string|max:255',
            'nik'  => 'required|string|max:50|unique:petugas,nik',
        ]);

        $petugas = Petugas::create([
            'nama'         => $request->nama,
            'nik'          => $request->nik,
            'barcode_code' => 'PTG-' . strtoupper(uniqid()),
        ]);

        return redirect()
            ->route('admin.petugas.barcode.generate', ['id' => $petugas->id])
            ->with('success', 'Petugas berhasil ditambahkan! Silakan unduh barcode petugas.');
    }

    public function petugasBarcodeGenerate(Request $request)
    {
        $petugasSelected = null;
        $qrCode = null;

        if ($request->has('id')) {
            $petugasSelected = Petugas::find($request->id);

            if ($petugasSelected) {
                $qrCode = QrCode::format('svg')
                    ->size(300)
                    ->margin(1)
                    ->generate($petugasSelected->barcode_code);
            }
        }

        $petugasList = Petugas::select('id', 'nama', 'nik')->get();

        return view('admin.petugas-barcode', compact('petugasSelected', 'petugasList', 'qrCode'));
    }

    public function petugasBarcodeDownload($id)
    {
        $petugas = Petugas::findOrFail($id);

        $qrImage = QrCode::format('svg')
            ->size(500)
            ->margin(1)
            ->generate($petugas->barcode_code);

        $filename = 'barcode-petugas-' . $petugas->nik . '.svg';

        return response($qrImage)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function petugasDestroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus!');
    }

    /*
    |--------------------------------------------------------------------------
    | PRESENSI
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
            'nisn' => 'required|string|exists:siswa,nisn',
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();
        $today = Carbon::today();

        $absensiAktif = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('created_at', $today)
            ->whereNull('waktu_keluar')
            ->first();

        if ($absensiAktif) {
            $absensiAktif->update([
                'waktu_keluar' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Absen Keluar Berhasil! Terima kasih, ' . $siswa->nama);
        } else {
            Absensi::create([
                'siswa_id'    => $siswa->id,
                'waktu_masuk' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Absen Masuk Berhasil! Selamat datang, ' . $siswa->nama);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
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