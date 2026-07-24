<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use App\Models\Absensi;

class SiswaController extends Controller
{
    /**
     * Menampilkan Dashboard khusus Siswa
     */
    public function dashboard()
    {
        $siswa = Auth::user(); // Pastikan guard/auth mengembalikan instance Siswa

        // 1. Hitung total kunjungan/absensi siswa
        $totalKunjungan = Absensi::where('siswa_id', $siswa->id)->count();

        // 2. Cek status absensi/kunjungan hari ini
        $presensiHariIni = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('created_at', now()->today())
            ->latest()
            ->first();

        $statusHariIni = 'belum'; // Default status
        if ($presensiHariIni) {
            if (is_null($presensiHariIni->waktu_keluar)) {
                $statusHariIni = 'di_dalam';
            } else {
                $statusHariIni = 'selesai';
            }
        }

        // 3. Ambil 5 riwayat absensi terbaru
        $riwayatTerbaru = Absensi::where('siswa_id', $siswa->id)
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'totalKunjungan',
            'statusHariIni',
            'riwayatTerbaru'
        ));
    }

    /**
     * Menampilkan Seluruh Riwayat Absensi Siswa
     */
    public function riwayat()
    {
        $siswa = Auth::user();

        // Ambil semua riwayat absensi dengan paginasi
        $riwayatList = Absensi::where('siswa_id', $siswa->id)
            ->latest()
            ->paginate(10);

        return view('siswa.riwayat', compact('siswa', 'riwayatList'));
    }

    /* =========================================================================
     * AKSI CRUD SISWA (DAPAT DIAKSES OLEH ADMIN / PETUGAS)
     * ========================================================================= */

    /**
     * Menampilkan Halaman Daftar Siswa
     */
    public function index(Request $request)
    {
        // Mengambil data siswa beserta relasi kelas dan jurusan
        $query = Siswa::with(['kelas', 'jurusan']);

        // Fitur Pencarian berdasarkan Nama atau NISN
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswaList = $query->latest()->paginate(10);

        return view('admin.siswa', compact('siswaList'));
    }

    /**
     * Menampilkan Form Tambah Siswa (Opsional jika pakai Halaman Terpisah)
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Menyimpan Data Siswa Baru ke Database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'nisn'       => 'required|numeric|unique:siswa,nisn',
            'nama'       => 'required|string|max:255',
            'kelas_id'   => 'required',
            'jurusan_id' => 'required',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nisn.required'       => 'NISN wajib diisi.',
            'nisn.unique'         => 'NISN ini sudah terdaftar.',
            'nama.required'       => 'Nama lengkap wajib diisi.',
            'kelas_id.required'   => 'Kelas wajib dipilih.',
            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'foto.image'          => 'File foto harus berupa gambar.',
            'foto.max'            => 'Ukuran foto maksimal 2MB.',
        ]);

        // 2. Upload Foto (jika ada)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa-foto', 'public');
        }

        // 3. Simpan Data ke Tabel 'siswa'
        $siswa = Siswa::create([
            'nisn'         => $request->nisn,
            'nama'         => $request->nama,
            'kelas_id'     => $request->kelas_id,
            'jurusan_id'   => $request->jurusan_id,
            'barcode_code' => $request->nisn, // Menggunakan NISN sebagai default barcode
            'foto'         => $fotoPath,
        ]);

        // 4. Redirect ke halaman generate barcode supaya admin bisa
        //    langsung melihat & mengunduh QR code siswa yang baru dibuat.
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
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Mengubah/Meng-update Data Siswa
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nisn'       => 'required|numeric|unique:siswa,nisn,' . $id,
            'nama'       => 'required|string|max:255',
            'kelas_id'   => 'required',
            'jurusan_id' => 'required',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle foto baru jika diunggah
        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $siswa->foto = $request->file('foto')->store('siswa-foto', 'public');
        }

        $siswa->nisn       = $request->nisn;
        $siswa->nama       = $request->nama;
        $siswa->kelas_id   = $request->kelas_id;
        $siswa->jurusan_id = $request->jurusan_id;
        $siswa->save();

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Menghapus Data Siswa
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus foto terkait jika ada
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }
}