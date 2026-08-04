<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BukuDigital extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_buku',
        'penulis',
        'kategori',
        'tahun_terbit',
        'cover',
        'file_pdf',
        'jumlah_dibaca',
        // Kolom baru untuk integrasi Google Books
        'google_volume_id',  // ID Volume dari Google Books API
        'cover_url',         // URL cover buku dari Google Books
        'reader_url',        // URL preview/reader dari Google Books
        'sumber',            // Penanda sumber: 'lokal' atau 'google_books'
    ];

    // Accessor URL Cover (mendukung cover lokal & Google Books)
    public function getCoverUrlAttribute()
    {
        // Jika ada cover_url dari Google Books, gunakan itu
        if ($this->attributes['cover_url'] ?? null) {
            return $this->attributes['cover_url'];
        }
        // Jika ada cover lokal (upload)
        if ($this->cover && Storage::disk('public')->exists($this->cover)) {
            return asset('storage/' . $this->cover);
        }
        return 'https://via.placeholder.com/400x600?text=No+Cover';
    }

    // Accessor URL PDF
    public function getPdfUrlAttribute()
    {
        return asset('storage/' . $this->file_pdf);
    }

    /**
     * Accessor: Cek apakah buku ini berasal dari Google Books.
     * Penggunaan: $buku->is_google_book (return true/false)
     */
    public function getIsGoogleBookAttribute()
    {
        return $this->sumber === 'google_books';
    }
}