<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SISWA
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $siswa = Auth::guard('siswa')->user();
        $today = Carbon::today()->toDateString();

        $totalKunjungan = Absensi::where('siswa_id', $siswa->id)->count();

        $absensiHariIni = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->latest('waktu_masuk')
            ->first();

        // null = belum berkunjung hari ini, 'di_perpus' = masih di dalam, 'selesai' = sudah keluar
        $statusHariIni = $absensiHariIni->status ?? null;

        $riwayatTerakhir = Absensi::where('siswa_id', $siswa->id)
            ->latest('tanggal')
            ->latest('waktu_masuk')
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'siswa', 'totalKunjungan', 'statusHariIni', 'riwayatTerakhir'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT KUNJUNGAN SISWA
    |--------------------------------------------------------------------------
    */

    public function riwayatIndex(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        $query = Absensi::where('siswa_id', $siswa->id);

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            [$tahunFilter, $bulanFilter] = explode('-', $request->bulan);
            $query->whereYear('tanggal', $tahunFilter)->whereMonth('tanggal', $bulanFilter);
        }

        $riwayatAbsensi = $query->orderByDesc('tanggal')
            ->orderByDesc('waktu_masuk')
            ->paginate(10)
            ->withQueryString();

        $totalKunjungan = Absensi::where('siswa_id', $siswa->id)->count();

        $totalBulanIni = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        $sedangDiPerpus = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', Carbon::today()->toDateString())
            ->where('status', 'di_perpus')
            ->exists();

        return view('siswa.riwayat', compact(
            'siswa', 'riwayatAbsensi', 'totalKunjungan', 'totalBulanIni', 'sedangDiPerpus'
        ));
    }

    // Alias agar kompatibel dengan route lama yang memanggil riwayat()
    public function riwayat(Request $request)
    {
        return $this->riwayatIndex($request);
    }

    /*
    |--------------------------------------------------------------------------
    | PROFIL SISWA
    |--------------------------------------------------------------------------
    */

    public function profileIndex()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.profile', compact('siswa'));
    }

    // Alias agar kompatibel dengan route lama yang memanggil profile()
    public function profile()
    {
        return $this->profileIndex();
    }

    public function profileUpdate(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpeg, png, jpg, atau webp.',
            'foto.max'   => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $siswa->foto = $request->file('foto')->store('siswa', 'public');
            $siswa->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function profilePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_lama.required'  => 'Password lama wajib diisi.',
            'password_baru.required'  => 'Password baru wajib diisi.',
            'password_baru.min'       => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $siswa = Auth::guard('siswa')->user();

        if (!Hash::check($request->password_lama, $siswa->password)) {
            return redirect()->back()->withErrors(['password_lama' => 'Password lama tidak sesuai!']);
        }

        $siswa->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }

    /* =========================================================================
     * AKSI CRUD SISWA (DAPAT DIAKSES OLEH ADMIN / PETUGAS)
     * ========================================================================= */

    /**
     * Menampilkan Halaman Daftar Siswa (Filter Kelas, Jurusan, dan Pencarian)
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'jurusan']);

        // 1. Filter Berdasarkan Pencarian (Nama / NISN / NIS)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // 2. Filter Berdasarkan Kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // 3. Filter Berdasarkan Jurusan
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Mengambil data dengan pagination & membawa query string
        $siswaList = $query->latest()->paginate(10)->withQueryString();

        // Data opsi dropdown
        $kelasList = Kelas::all();
        $jurusanList = Jurusan::all();

        return view('admin.siswa', compact('siswaList', 'kelasList', 'jurusanList'));
    }

    /**
     * Menampilkan Form Tambah Siswa
     */
    public function create()
    {
        $kelasList = Kelas::all();
        $jurusanList = Jurusan::all();

        return view('admin.siswa.create', compact('kelasList', 'jurusanList'));
    }

    /**
     * Menyimpan Data Siswa Baru ke Database
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nisn'          => 'required|numeric|unique:siswa,nisn',
            'nis'           => 'required|numeric|unique:siswa,nis',
            'nama'          => 'required|string|max:255',
            'kelas_id'      => 'required|exists:kelas,id',
            'jurusan_id'    => 'required|exists:jurusan,id',
            'jenis_kelamin' => 'required|in:L,P',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.numeric'           => 'NISN harus berupa angka.',
            'nisn.unique'            => 'NISN ini sudah terdaftar.',
            'nis.required'           => 'NIS wajib diisi.',
            'nis.numeric'            => 'NIS harus berupa angka.',
            'nis.unique'             => 'NIS ini sudah terdaftar.',
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'kelas_id.required'      => 'Kelas wajib dipilih.',
            'kelas_id.exists'        => 'Kelas yang dipilih tidak valid atau sudah tidak tersedia.',
            'jurusan_id.required'    => 'Jurusan wajib dipilih.',
            'jurusan_id.exists'      => 'Jurusan yang dipilih tidak valid atau sudah tidak tersedia.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'foto.image'             => 'File foto harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa-foto', 'public');
        }

        $siswa = Siswa::create([
            'nisn'          => $request->nisn,
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'kelas_id'      => $request->kelas_id,
            'jurusan_id'    => $request->jurusan_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'barcode_code'  => $request->nisn,
            'foto'          => $fotoPath,
        ]);

        return redirect()
            ->route('admin.barcode.generate', ['id' => $siswa->id])
            ->with('success', 'Data siswa berhasil ditambahkan. Silakan unduh barcode siswa.');
    }

    /**
     * Menampilkan Detail Siswa
     */
    public function show($id)
    {
        $siswa = Siswa::with(['kelas', 'jurusan'])->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Menampilkan Form Edit Siswa
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelasList = Kelas::all();
        $jurusanList = Jurusan::all();

        return view('admin.edit', compact('siswa', 'kelasList', 'jurusanList'));
    }

    /**
     * Mengubah/Meng-update Data Siswa
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validatedData = $request->validate([
            'nisn'          => 'required|numeric|unique:siswa,nisn,' . $id,
            'nis'           => 'required|numeric|unique:siswa,nis,' . $id,
            'nama'          => 'required|string|max:255',
            'kelas_id'      => 'required|exists:kelas,id',
            'jurusan_id'    => 'required|exists:jurusan,id',
            'jenis_kelamin' => 'required|in:L,P',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.numeric'           => 'NISN harus berupa angka.',
            'nisn.unique'            => 'NISN ini sudah terdaftar.',
            'nis.required'           => 'NIS wajib diisi.',
            'nis.numeric'            => 'NIS harus berupa angka.',
            'nis.unique'             => 'NIS ini sudah terdaftar.',
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'kelas_id.required'      => 'Kelas wajib dipilih.',
            'kelas_id.exists'        => 'Kelas yang dipilih tidak valid atau sudah tidak tersedia.',
            'jurusan_id.required'    => 'Jurusan wajib dipilih.',
            'jurusan_id.exists'      => 'Jurusan yang dipilih tidak valid atau sudah tidak tersedia.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'foto.image'             => 'File foto harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $siswa->foto = $request->file('foto')->store('siswa-foto', 'public');
        }

        $siswa->nisn          = $request->nisn;
        $siswa->nis           = $request->nis;
        $siswa->nama          = $request->nama;
        $siswa->kelas_id      = $request->kelas_id;
        $siswa->jurusan_id    = $request->jurusan_id;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->save();

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Menghapus Data Siswa
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }
}