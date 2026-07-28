<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas'; // Sesuaikan dengan nama tabel kelas Anda jika beda

    protected $fillable = [
        'nama_kelas',
        'jurusan_id',
    ];

    /**
     * Relasi balik ke Jurusan
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Relasi ke Model Siswa (Harus ada agar withCount('siswa') di controller berfungsi)
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}