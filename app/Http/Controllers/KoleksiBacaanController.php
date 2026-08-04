<?php

namespace App\Http\Controllers;

use App\Models\KoleksiBacaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiBacaanController extends Controller
{
    /**
     * Ambil siswa yang sedang login. Abort 403 jika bukan siswa.
     */
    private function getSiswa()
    {
        $siswa = Auth::guard('siswa')->user();
        if (!$siswa) {
            abort(403, 'Hanya siswa yang dapat mengakses koleksi bacaan pribadi.');
        }
        return $siswa;
    }

    /**
     * POST /siswa/koleksi-bacaan
     * Tambahkan buku ke koleksi bacaan pribadi siswa.
     */
    public function store(Request $request)
    {
        $siswa = $this->getSiswa();

        $validated = $request->validate([
            'volume_id'    => 'required|string|max:100',
            'judul_buku'   => 'required|string|max:300',
            'penulis'      => 'nullable|string|max:255',
            'cover_url'    => 'nullable|string|max:500',
            'reader_link'  => 'nullable|string|max:500',
            'kategori'     => 'nullable|string|max:100',
            'total_halaman'=> 'nullable|integer|min:0',
        ]);

        // Cek apakah buku sudah ada di koleksi siswa ini
        $exists = KoleksiBacaan::where('siswa_id', $siswa->id)
            ->where('volume_id', $validated['volume_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Buku ini sudah ada di koleksi bacaan kamu.',
            ], 409);
        }

        $koleksi = KoleksiBacaan::create([
            'siswa_id'      => $siswa->id,
            'volume_id'     => $validated['volume_id'],
            'judul_buku'    => $validated['judul_buku'],
            'penulis'       => $validated['penulis'] ?? 'Penulis Tidak Diketahui',
            'cover_url'     => $validated['cover_url'] ?? null,
            'reader_link'   => $validated['reader_link'] ?? null,
            'kategori'      => $validated['kategori'] ?? 'Umum',
            'total_halaman' => $validated['total_halaman'] ?? 0,
            'status'        => 'belum_dibaca',
            'halaman_terakhir' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan ke koleksi bacaan kamu!',
            'data'    => $koleksi,
        ], 201);
    }

    /**
     * PUT /siswa/koleksi-bacaan/{id}
     * Update progres membaca (halaman, total, status, catatan).
     */
    public function update(Request $request, $id)
    {
        $siswa = $this->getSiswa();

        $koleksi = KoleksiBacaan::where('id', $id)
            ->where('siswa_id', $siswa->id)
            ->firstOrFail();

        $validated = $request->validate([
            'halaman_terakhir' => 'nullable|integer|min:0',
            'total_halaman'    => 'nullable|integer|min:0',
            'status'           => 'nullable|in:belum_dibaca,sedang_dibaca,selesai',
            'catatan'          => 'nullable|string|max:1000',
        ]);

        // Auto-update status berdasarkan halaman
        $halaman = $validated['halaman_terakhir'] ?? $koleksi->halaman_terakhir;
        $total   = $validated['total_halaman']    ?? $koleksi->total_halaman;

        // Jika status tidak dikirim eksplisit, tentukan otomatis dari halaman
        if (!isset($validated['status'])) {
            if ($halaman <= 0) {
                $validated['status'] = 'belum_dibaca';
            } elseif ($total > 0 && $halaman >= $total) {
                $validated['status'] = 'selesai';
            } else {
                $validated['status'] = 'sedang_dibaca';
            }
        }

        // Jika status selesai, set halaman ke total_halaman (jika ada)
        if ($validated['status'] === 'selesai' && $total > 0) {
            $validated['halaman_terakhir'] = $total;
        }

        $koleksi->update(array_filter($validated, fn($v) => $v !== null));

        // Reload model untuk dapat accessor terbaru
        $koleksi->refresh();

        return response()->json([
            'success'          => true,
            'message'          => 'Progres membaca berhasil diperbarui!',
            'status'           => $koleksi->status,
            'status_label'     => $koleksi->status_label,
            'halaman_terakhir' => $koleksi->halaman_terakhir,
            'total_halaman'    => $koleksi->total_halaman,
            'persentase'       => $koleksi->persentase_baca,
        ]);
    }

    /**
     * DELETE /siswa/koleksi-bacaan/{id}
     * Hapus buku dari koleksi bacaan pribadi siswa.
     */
    public function destroy($id)
    {
        $siswa = $this->getSiswa();

        $koleksi = KoleksiBacaan::where('id', $id)
            ->where('siswa_id', $siswa->id)
            ->firstOrFail();

        $koleksi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus dari koleksi bacaan.',
        ]);
    }
}
