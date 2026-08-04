<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoleksiBacaan extends Model
{
    use HasFactory;

    protected $table = 'koleksi_bacaan';

    protected $fillable = [
        'siswa_id',
        'volume_id',
        'judul_buku',
        'penulis',
        'cover_url',
        'reader_link',
        'kategori',
        'status',
        'halaman_terakhir',
        'total_halaman',
        'catatan',
    ];

    protected $casts = [
        'halaman_terakhir' => 'integer',
        'total_halaman'    => 'integer',
    ];

    // Status labels dalam Bahasa Indonesia
    const STATUS_LABELS = [
        'belum_dibaca'  => 'Belum Dibaca',
        'sedang_dibaca' => 'Sedang Dibaca',
        'selesai'       => 'Selesai',
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Accessor: Persentase baca (0-100)
    public function getPersentaseBacaAttribute(): int
    {
        if ($this->total_halaman <= 0) return 0;
        return (int) min(100, round(($this->halaman_terakhir / $this->total_halaman) * 100));
    }

    // Accessor: Label status dalam Bahasa Indonesia
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    // Accessor: Warna badge berdasarkan status
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'belum_dibaca'  => 'slate',
            'sedang_dibaca' => 'sky',
            'selesai'       => 'emerald',
            default         => 'slate',
        };
    }
}
