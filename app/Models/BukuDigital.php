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
    ];

    // Accessor URL Cover
    public function getCoverUrlAttribute()
    {
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
}