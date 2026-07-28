<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel di migration (absensis)
    protected $table = 'absensis'; 

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status',        // Wajib ditambahkan agar fitur scan & update status berjalan
        'keterangan',    // Tetap disimpan jika nanti ingin digunakan
    ];

    /**
     * Relasi ke Model Siswa (Belongs To)
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}