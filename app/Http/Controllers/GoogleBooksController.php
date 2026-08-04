<?php

namespace App\Http\Controllers;

use App\Models\BukuDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GoogleBooksController extends Controller
{
    private function getAuthUser()
    {
        if (Auth::guard('web')->check()) return Auth::guard('web')->user();
        if (Auth::guard('petugas')->check()) return Auth::guard('petugas')->user();
        if (Auth::guard('siswa')->check()) return Auth::guard('siswa')->user();
        return null;
    }

    private function getGuardPrefix()
    {
        if (Auth::guard('web')->check()) return 'admin';
        if (Auth::guard('petugas')->check()) return 'petugas';
        if (Auth::guard('siswa')->check()) return 'siswa';
        return 'admin';
    }

    private function authorizeAdminOrPetugas()
    {
        $isAdmin   = Auth::guard('web')->check();
        $isPetugas = Auth::guard('petugas')->check();

        if (!$isAdmin && !$isPetugas) {
            abort(403, 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }
    }

    public function index()
    {
        $user = $this->getAuthUser();
        $guardPrefix = $this->getGuardPrefix();

        $savedBooks = BukuDigital::where('sumber', 'google_books')
            ->latest()
            ->get();

        $viewData = compact('savedBooks');

        if ($guardPrefix === 'siswa') {
            $viewData['siswa'] = $user;
        }

        return view("{$guardPrefix}.google-books", $viewData);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $query = $request->input('q');

        try {
            // API Key langsung dipasang & ditrim
            $apiKey = 'AIzaSyCbOQnFCPUmAe2PLtvVZymYVpjzteETphU';

            $params = [
                'q'          => $query,
                'maxResults' => 18,
                'printType'  => 'books',
                'key'        => $apiKey,
            ];

            // Request ke Google Books API
            $response = Http::withOptions([
                'verify' => false, // Bypass SSL issue di local
            ])->timeout(15)->get('https://www.googleapis.com/books/v1/volumes', $params);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil data dari Google Books API (Status: ' . $response->status() . ').',
                    'books'   => [],
                ], $response->status());
            }

            $data  = $response->json();
            $books = [];

            // Memproses data item buku dari Google
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $volumeInfo = $item['volumeInfo'] ?? [];
                    $accessInfo = $item['accessInfo'] ?? [];

                    // Penanganan Gambar Cover (Mendukung berbagai ukuran dari Google API)
                    $imageLinks = $volumeInfo['imageLinks'] ?? [];
                    $coverUrl   = $imageLinks['thumbnail'] 
                               ?? $imageLinks['smallThumbnail'] 
                               ?? $imageLinks['medium'] 
                               ?? $imageLinks['large'] 
                               ?? null;

                    if ($coverUrl) {
                        $coverUrl = str_replace('http://', 'https://', $coverUrl);
                    } else {
                        // Placeholder jika buku tidak memiliki cover dari Google
                        $coverUrl = 'https://via.placeholder.com/128x192.png?text=No+Cover';
                    }

                    $previewLink = $volumeInfo['previewLink'] ?? null;
                    $readerLink  = $accessInfo['webReaderLink'] ?? $previewLink;

                    $books[] = [
                        'volume_id'      => $item['id'],
                        'title'          => $volumeInfo['title'] ?? 'Judul Tidak Tersedia',
                        'authors'        => $volumeInfo['authors'] ?? ['Penulis Tidak Diketahui'],
                        'author_text'    => implode(', ', $volumeInfo['authors'] ?? ['Penulis Tidak Diketahui']),
                        'publisher'      => $volumeInfo['publisher'] ?? '-',
                        'published_date' => $volumeInfo['publishedDate'] ?? '-',
                        'description'    => $volumeInfo['description'] ?? 'Tidak ada deskripsi.',
                        'short_desc'     => \Illuminate\Support\Str::limit(strip_tags($volumeInfo['description'] ?? 'Tidak ada deskripsi.'), 120),
                        'categories'     => $volumeInfo['categories'] ?? ['Umum'],
                        'page_count'     => $volumeInfo['pageCount'] ?? 0,
                        'cover_url'      => $coverUrl,
                        'preview_link'   => $previewLink,
                        'reader_link'    => $readerLink,
                        'embeddable'     => $accessInfo['embeddable'] ?? false,
                        'viewability'    => $accessInfo['viewability'] ?? 'NO_PAGES',
                        'info_link'      => $volumeInfo['infoLink'] ?? null,
                    ];
                }
            }

            return response()->json([
                'success'     => true,
                'total_items' => $data['totalItems'] ?? 0,
                'books'       => $books,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
                'books'   => [],
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $this->authorizeAdminOrPetugas();

        $request->validate([
            'google_volume_id' => 'required|string|max:50',
            'judul_buku'       => 'required|string|max:255',
            'penulis'          => 'nullable|string|max:255',
            'kategori'         => 'nullable|string|max:100',
            'cover_url'        => 'nullable|url|max:500',
            'reader_url'       => 'nullable|string|max:500',
        ]);

        $existing = BukuDigital::where('google_volume_id', $request->google_volume_id)->first();
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Buku ini sudah ada di koleksi perpustakaan.',
            ], 409);
        }

        $buku = BukuDigital::create([
            'google_volume_id' => $request->google_volume_id,
            'judul_buku'       => $request->judul_buku,
            'penulis'          => $request->penulis ?? 'Tidak Diketahui',
            'kategori'         => $request->kategori ?? 'Umum',
            'cover_url'        => $request->cover_url,
            'reader_url'       => $request->reader_url,
            'sumber'           => 'google_books',
            'file_pdf'         => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil disimpan ke koleksi perpustakaan!',
            'data'    => $buku,
        ], 201);
    }

    public function destroy($id)
    {
        $this->authorizeAdminOrPetugas();

        $buku = BukuDigital::where('id', $id)
            ->where('sumber', 'google_books')
            ->firstOrFail();

        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus dari koleksi.',
        ]);
    }
}