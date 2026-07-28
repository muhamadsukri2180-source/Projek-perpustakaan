<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan',
    ];

    /**
     * Relasi ke Model Kelas (Satu Jurusan memiliki banyak Kelas)
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }

    /**
     * Relasi ke Model Siswa (Satu Jurusan memiliki banyak Siswa)
     * Ditambahkan 'siswas' agar cocok dengan $chartJurusan = Jurusan::withCount('siswas')
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'jurusan_id');
    }
}