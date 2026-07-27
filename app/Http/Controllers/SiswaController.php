<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Absensi;

class SiswaController extends Controller
{
    /**
     * Menampilkan Dashboard khusus Siswa
     */
    public function dashboard()
    {
        $siswa = Auth::guard('siswa')->user(); // FIX: eksplisit guard siswa

        $totalKunjungan = Absensi::where('siswa_id', $siswa->id)->count();

        $presensiHariIni = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('created_at', now()->today())
            ->latest()
            ->first();

        $statusHariIni = 'belum';
        if ($presensiHariIni) {
            if (is_null($presensiHariIni->waktu_keluar)) {
                $statusHariIni = 'di_dalam';
            } else {
                $statusHariIni = 'selesai';
            }
        }

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
        $siswa = Auth::guard('siswa')->user(); // FIX: eksplisit guard siswa

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

    /**
     * Menampilkan Form Tambah Siswa (Opsional jika pakai Halaman Terpisah)
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
        // FIX: tambahkan exists:kelas,id dan exists:jurusan,id
        // supaya kalau id tidak valid, muncul pesan validasi rapi
        // bukan error SQL foreign key mentah.
        $request->validate([
            'nisn'       => 'required|numeric|unique:siswa,nisn',
            'nama'       => 'required|string|max:255',
            'kelas_id'   => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusan,id',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nisn.required'       => 'NISN wajib diisi.',
            'nisn.numeric'        => 'NISN harus berupa angka.',
            'nisn.unique'         => 'NISN ini sudah terdaftar.',
            'nama.required'       => 'Nama lengkap wajib diisi.',
            'kelas_id.required'   => 'Kelas wajib dipilih.',
            'kelas_id.exists'     => 'Kelas yang dipilih tidak valid atau sudah tidak tersedia.',
            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'jurusan_id.exists'   => 'Jurusan yang dipilih tidak valid atau sudah tidak tersedia.',
            'foto.image'          => 'File foto harus berupa gambar.',
            'foto.max'            => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa-foto', 'public');
        }

        $siswa = Siswa::create([
            'nisn'         => $request->nisn,
            'nama'         => $request->nama,
            'kelas_id'     => $request->kelas_id,
            'jurusan_id'   => $request->jurusan_id,
            'barcode_code' => $request->nisn,
            'foto'         => $fotoPath,
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

        return view('admin.siswa.edit', compact('siswa', 'kelasList', 'jurusanList'));
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
            'kelas_id'   => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusan,id',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'kelas_id.exists'   => 'Kelas yang dipilih tidak valid atau sudah tidak tersedia.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid atau sudah tidak tersedia.',
        ]);

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

        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }
}