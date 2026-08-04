<?php

namespace App\Http\Controllers;

use App\Models\BukuDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BukuDigitalController extends Controller
{
    /**
     * Helper privat untuk mengambil data user terautentikasi 
     * Prioritas pengecekan: Admin (web) -> Petugas -> Siswa
     */
    private function getAuthUser()
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }
        if (Auth::guard('petugas')->check()) {
            return Auth::guard('petugas')->user();
        }
        if (Auth::guard('siswa')->check()) {
            return Auth::guard('siswa')->user();
        }
        return null;
    }

    /**
     * READ: Menampilkan daftar buku digital berdasarkan role user.
     */
    public function index(Request $request)
    {
        $query = BukuDigital::query();

        // Fitur Pencarian
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul_buku', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%")
                  ->orWhere('kategori', 'like', "%{$cari}%");
            });
        }

        // Pagination 9 data per halaman
        $bukuDigitals = $query->latest()->paginate(9);

        // Ambil data user aktif berdasarkan guard
        $user = $this->getAuthUser();

        // 1. JIKA USER ADALAH ADMIN (Guard Web)
        if (Auth::guard('web')->check() || ($user && isset($user->role) && $user->role === 'admin')) {
            return view('admin.buku', compact('bukuDigitals'));
        }

        // 2. JIKA USER ADALAH PETUGAS (Guard Petugas)
        if (Auth::guard('petugas')->check() || ($user && isset($user->role) && $user->role === 'petugas')) {
            return view('petugas.buku', compact('bukuDigitals'));
        }

        // 3. JIKA USER ADALAH SISWA (Guard Siswa)
        if (Auth::guard('siswa')->check() || ($user && isset($user->role) && $user->role === 'siswa')) {
            $siswa = $user;
            return view('siswa.buku', compact('bukuDigitals', 'siswa'));
        }

        // Default fallback (jika tidak terdeteksi)
        return view('admin.buku', compact('bukuDigitals'));
    }

    /**
     * CREATE: Menyimpan data buku baru (Hanya Admin & Petugas)
     */
    public function store(Request $request)
    {
        $this->authorizeAdminOrPetugas();

        $request->validate([
            'judul_buku'   => 'required|string|max:255',
            'penulis'      => 'nullable|string|max:255',
            'kategori'     => 'required|string|max:100',
            'tahun_terbit' => 'nullable|numeric|digits:4',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf'     => 'required|mimes:pdf|max:20480', // Max 20MB
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('buku-cover', 'public');
        }

        $pdfPath = $request->file('file_pdf')->store('buku-pdf', 'public');

        BukuDigital::create([
            'judul_buku'   => $request->judul_buku,
            'penulis'      => $request->penulis,
            'kategori'     => $request->kategori,
            'tahun_terbit' => $request->tahun_terbit,
            'cover'        => $coverPath,
            'file_pdf'     => $pdfPath,
        ]);

        return redirect()->back()->with('success', 'Buku digital berhasil ditambahkan!');
    }

    /**
     * UPDATE: Memperbarui data buku (Hanya Admin & Petugas)
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdminOrPetugas();

        $buku = BukuDigital::findOrFail($id);

        $request->validate([
            'judul_buku'   => 'required|string|max:255',
            'penulis'      => 'nullable|string|max:255',
            'kategori'     => 'required|string|max:100',
            'tahun_terbit' => 'nullable|numeric|digits:4',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf'     => 'nullable|mimes:pdf|max:20480',
        ]);

        // Cek jika ada cover baru
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $buku->cover = $request->file('cover')->store('buku-cover', 'public');
        }

        // Cek jika ada file PDF baru
        if ($request->hasFile('file_pdf')) {
            if ($buku->file_pdf && Storage::disk('public')->exists($buku->file_pdf)) {
                Storage::disk('public')->delete($buku->file_pdf);
            }
            $buku->file_pdf = $request->file('file_pdf')->store('buku-pdf', 'public');
        }

        $buku->update([
            'judul_buku'   => $request->judul_buku,
            'penulis'      => $request->penulis,
            'kategori'     => $request->kategori,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        return redirect()->back()->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus data buku (Hanya Admin & Petugas)
     */
    public function destroy($id)
    {
        $this->authorizeAdminOrPetugas();

        $buku = BukuDigital::findOrFail($id);

        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        if ($buku->file_pdf && Storage::disk('public')->exists($buku->file_pdf)) {
            Storage::disk('public')->delete($buku->file_pdf);
        }

        $buku->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Helper Function untuk otorisasi keamanan Admin & Petugas
     */
    private function authorizeAdminOrPetugas()
    {
        $isAdmin   = Auth::guard('web')->check();
        $isPetugas = Auth::guard('petugas')->check();

        if (!$isAdmin && !$isPetugas) {
            abort(403, 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }
    }
}