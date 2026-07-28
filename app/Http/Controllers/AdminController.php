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
        $today = Carbon::today()->toDateString();

        $totalSiswa = Siswa::count();
        $totalPetugas = Petugas::count();

        $pengunjungHariIni = Absensi::where('tanggal', $today)->count();

        $sedangDiPerpus = Absensi::where('tanggal', $today)
            ->where('status', 'di_perpus')
            ->count();

        $absensiTerbaru = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->latest()
            ->take(5)
            ->get();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $grafikData = Absensi::select(
                DB::raw('DATE(tanggal) as tgl'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->pluck('total', 'tgl')
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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
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
            'nisn'          => 'required|string|max:50|unique:siswa,nisn',
            'nis'           => 'required|string|max:50|unique:siswa,nis',
            'nama'          => 'required|string|max:255',
            'kelas_id'      => 'required|integer|exists:kelas,id',
            'jurusan_id'    => 'required|integer|exists:jurusan,id',
            'jenis_kelamin' => 'required|in:L,P',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.unique'            => 'NISN sudah terdaftar.',
            'nis.required'           => 'NIS wajib diisi.',
            'nis.unique'             => 'NIS sudah terdaftar.',
            'nama.required'          => 'Nama siswa wajib diisi.',
            'kelas_id.required'      => 'Kelas wajib dipilih.',
            'kelas_id.exists'        => 'Kelas yang dipilih tidak valid.',
            'jurusan_id.required'    => 'Jurusan wajib dipilih.',
            'jurusan_id.exists'      => 'Jurusan yang dipilih tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'foto.image'             => 'File foto harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpeg, png, jpg, atau webp.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
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
            'nis'           => 'required|string|max:50|unique:siswa,nis,' . $id,
            'nama'          => 'required|string|max:255',
            'kelas_id'      => 'required|integer|exists:kelas,id',
            'jurusan_id'    => 'required|integer|exists:jurusan,id',
            'jenis_kelamin' => 'required|in:L,P',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.unique'            => 'NISN sudah terdaftar.',
            'nis.required'           => 'NIS wajib diisi.',
            'nis.unique'             => 'NIS sudah terdaftar.',
            'nama.required'          => 'Nama siswa wajib diisi.',
            'kelas_id.required'      => 'Kelas wajib dipilih.',
            'kelas_id.exists'        => 'Kelas yang dipilih tidak valid.',
            'jurusan_id.required'    => 'Jurusan wajib dipilih.',
            'jurusan_id.exists'      => 'Jurusan yang dipilih tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'foto.image'             => 'File foto harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpeg, png, jpg, atau webp.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
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

        $siswaList = Siswa::select('id', 'nama', 'nisn', 'nis')->get();

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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama.required' => 'Nama petugas wajib diisi.',
            'nik.required'  => 'NIK wajib diisi.',
            'nik.unique'    => 'NIK ini sudah terdaftar.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('petugas-foto', 'public');
        }

        $petugas = Petugas::create([
            'nama'         => $request->nama,
            'nik'          => $request->nik,
            'barcode_code' => 'PTG-' . strtoupper(uniqid()),
            'foto'         => $fotoPath,
        ]);

        return redirect()
            ->route('admin.petugas.barcode.generate', ['id' => $petugas->id])
            ->with('success', 'Petugas berhasil ditambahkan! Silakan unduh barcode petugas.');
    }

    public function petugasEdit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('admin.petugas-edit', compact('petugas'));
    }

    public function petugasUpdate(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nik'  => 'required|string|max:50|unique:petugas,nik,' . $id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama.required' => 'Nama petugas wajib diisi.',
            'nik.required'  => 'NIK wajib diisi.',
            'nik.unique'    => 'NIK ini sudah digunakan.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($petugas->foto && Storage::disk('public')->exists($petugas->foto)) {
                Storage::disk('public')->delete($petugas->foto);
            }
            $petugas->foto = $request->file('foto')->store('petugas-foto', 'public');
        }

        $petugas->nama = $request->nama;
        $petugas->nik  = $request->nik;
        $petugas->save();

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil diperbarui!');
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

        if ($petugas->foto && Storage::disk('public')->exists($petugas->foto)) {
            Storage::disk('public')->delete($petugas->foto);
        }

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
        $today = Carbon::today()->toDateString();

        $absensiHariIni = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->where('tanggal', $today)
            ->latest('waktu_masuk')
            ->get();

        $riwayatAbsensi = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->latest('tanggal')
            ->latest('waktu_masuk')
            ->paginate(15);

        return view('admin.presensi', compact('absensiHariIni', 'riwayatAbsensi'));
    }

    public function presensiScan(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|exists:siswa,nisn',
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $absensiAktif = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->where('status', 'di_perpus')
            ->first();

        if ($absensiAktif) {
            $absensiAktif->update([
                'waktu_keluar' => $currentTime,
                'status'       => 'selesai',
            ]);

            return redirect()->back()->with('success', 'Absen Keluar Berhasil! Terima kasih, ' . $siswa->nama);
        }

        Absensi::create([
            'siswa_id'    => $siswa->id,
            'tanggal'     => $today,
            'waktu_masuk' => $currentTime,
            'status'      => 'di_perpus',
        ]);

        return redirect()->back()->with('success', 'Absen Masuk Berhasil! Selamat datang, ' . $siswa->nama);
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN KUNJUNGAN (berdasarkan data presensi hasil scan barcode)
    |--------------------------------------------------------------------------
    | Satu halaman menampilkan 4 tab (harian/mingguan/bulanan/tahunan)
    | sekaligus. Semua form filter pada tab manapun mengarah ke method ini
    | (laporanIndex), sehingga keempat tab selalu terisi data yang relevan
    | tanpa saling menimpa filter satu sama lain.
    |--------------------------------------------------------------------------
    */

    public function laporanIndex(Request $request)
    {
        // ==================== LAPORAN HARIAN ====================
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());

        $laporanHarian = Absensi::with(['siswa.kelas', 'siswa.jurusan'])
            ->where('tanggal', $tanggal)
            ->orderBy('waktu_masuk')
            ->get();

        $totalHarian = $laporanHarian->count();

        // ==================== LAPORAN MINGGUAN ====================
        // Input type="week" mengirim format "2026-W30"
        if ($request->filled('minggu') && str_contains($request->minggu, '-W')) {
            [$tahunMingguInput, $noMingguInput] = explode('-W', $request->minggu);
            $awalMinggu = Carbon::now()->setISODate((int) $tahunMingguInput, (int) $noMingguInput)->startOfWeek();
        } else {
            $awalMinggu = Carbon::now()->startOfWeek();
        }
        $akhirMinggu = $awalMinggu->copy()->endOfWeek();

        $dataMingguan = Absensi::select(
                DB::raw('tanggal'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('tanggal', [$awalMinggu->toDateString(), $akhirMinggu->toDateString()])
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $laporanMingguan = [];
        for ($d = $awalMinggu->copy(); $d->lte($akhirMinggu); $d->addDay()) {
            $laporanMingguan[] = [
                'hari'    => $d->translatedFormat('l'),
                'tanggal' => $d->translatedFormat('d F Y'),
                'total'   => (int) ($dataMingguan[$d->toDateString()] ?? 0),
            ];
        }
        $totalMingguan = array_sum(array_column($laporanMingguan, 'total'));

        // ==================== LAPORAN BULANAN (rekap per minggu) ====================
        $bulanInput = $request->get('bulan', Carbon::now()->format('Y-m'));
        [$tahunBulan, $bulanAngka] = array_pad(explode('-', $bulanInput), 2, Carbon::now()->format('m'));

        $awalBulan = Carbon::createFromDate((int) $tahunBulan, (int) $bulanAngka, 1)->startOfMonth();
        $akhirBulan = $awalBulan->copy()->endOfMonth();

        $laporanBulanan = [];
        $mingguKe = 1;
        $cursor = $awalBulan->copy();

        while ($cursor->lte($akhirBulan)) {
            $mulaiPotong = $cursor->copy();
            $selesaiPotong = $cursor->copy()->endOfWeek();

            if ($selesaiPotong->gt($akhirBulan)) {
                $selesaiPotong = $akhirBulan->copy();
            }

            $totalMinggu = Absensi::whereBetween('tanggal', [
                $mulaiPotong->toDateString(),
                $selesaiPotong->toDateString(),
            ])->count();

            $laporanBulanan[] = [
                'minggu_ke' => $mingguKe,
                'rentang'   => $mulaiPotong->translatedFormat('d M Y') . ' - ' . $selesaiPotong->translatedFormat('d M Y'),
                'total'     => $totalMinggu,
            ];

            $mingguKe++;
            $cursor = $selesaiPotong->copy()->addDay();
        }
        $totalBulanan = array_sum(array_column($laporanBulanan, 'total'));

        // ==================== LAPORAN TAHUNAN ====================
        $tahun = $request->get('tahun', Carbon::now()->year);

        $dataTahunan = Absensi::select(
                DB::raw('MONTH(tanggal) as bulan_angka'),
                DB::raw('count(*) as total')
            )
            ->whereYear('tanggal', $tahun)
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->pluck('total', 'bulan_angka');

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $laporanTahunan = [];
        foreach ($namaBulan as $angka => $nama) {
            $laporanTahunan[] = [
                'bulan' => $nama,
                'total' => (int) ($dataTahunan[$angka] ?? 0),
            ];
        }
        $totalTahunan = array_sum(array_column($laporanTahunan, 'total'));

        // Daftar tahun yang tersedia untuk dropdown (berdasarkan data yang ada)
        $tahunTersedia = Absensi::selectRaw('DISTINCT YEAR(tanggal) as tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        if ($tahunTersedia->isEmpty()) {
            $tahunTersedia = collect([Carbon::now()->year]);
        }

        return view('admin.laporan', compact(
            'tanggal', 'laporanHarian', 'totalHarian',
            'awalMinggu', 'akhirMinggu', 'laporanMingguan', 'totalMingguan',
            'bulanInput', 'laporanBulanan', 'totalBulanan',
            'tahun', 'laporanTahunan', 'totalTahunan', 'tahunTersedia'
        ));
    }

    /**
     * Alias supaya route lama (admin.laporan.harian / .mingguan / .bulanan / .tahunan)
     * tetap berfungsi dan menampilkan halaman laporan lengkap yang sama,
     * dengan tab yang relevan otomatis terisi sesuai filter yang dikirim.
     */
    public function laporanHarian(Request $request)
    {
        return $this->laporanIndex($request);
    }

    public function laporanMingguan(Request $request)
    {
        return $this->laporanIndex($request);
    }

    public function laporanBulanan(Request $request)
    {
        return $this->laporanIndex($request);
    }

    public function laporanTahunan(Request $request)
    {
        return $this->laporanIndex($request);
    }

    public function statistikPengunjung()
    {
        return view('admin.presensi');
    }

    /*
    |--------------------------------------------------------------------------
    | PROFIL ADMIN
    |--------------------------------------------------------------------------
    */

    public function profileIndex()
{
    $admin = Auth::user();

    // Kalau admin belum punya barcode_code, generate otomatis sekali
    if (empty($admin->barcode_code)) {
        $admin->barcode_code = 'ADM-' . strtoupper(uniqid());
        $admin->save();
    }

    $qrCode = QrCode::format('svg')
        ->size(300)
        ->margin(1)
        ->generate($admin->barcode_code);

    return view('admin.profile', compact('admin', 'qrCode'));
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
    // AdminController.php
public function profileBarcodeDownload()
{
    $admin = Auth::user();

    $qrImage = QrCode::format('svg')
        ->size(500)
        ->margin(1)
        ->generate($admin->barcode_code);

    $filename = 'barcode-admin-' . $admin->barcode_code . '.svg';

    return response($qrImage)
        ->header('Content-Type', 'image/svg+xml')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
}
}