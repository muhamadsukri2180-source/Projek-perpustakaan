<?php

namespace App\Http\Controllers;

use App\Models\BukuDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BukuDigitalController extends Controller
{
    /**
     * READ: Menampilkan daftar buku digital.
     * Mengarahkan Tampilan (View) secara otomatis berdasarkan Role User:
     * - Siswa  => view('siswa.buku')
     * - Admin / Petugas => view('admin.buku')
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

        // Ambil data user yang sedang login
        $user = Auth::user();

        // JIKA USER ADALAH SISWA
        if ($user->role === 'siswa') {
            // Mengambil relasi data siswa (jika tabel users berelasi ke tabel siswas)
            $siswa = $user->siswa ?? $user;

            return view('siswa.buku', compact('bukuDigitals', 'siswa'));
        }

        // JIKA USER ADALAH ADMIN ATAU PETUGAS
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

        // Cek jika ada cover baru yang diunggah
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $buku->cover = $request->file('cover')->store('buku-cover', 'public');
        }

        // Cek jika ada file PDF baru yang diunggah
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

        // Hapus file cover dari storage jika ada
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        // Hapus file PDF dari storage jika ada
        if ($buku->file_pdf && Storage::disk('public')->exists($buku->file_pdf)) {
            Storage::disk('public')->delete($buku->file_pdf);
        }

        $buku->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Helper Function untuk otorisasi keamanan role Admin & Petugas
     */
    private function authorizeAdminOrPetugas()
    {
        $role = Auth::user()->role;
        
        if (!in_array($role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }
    }
}