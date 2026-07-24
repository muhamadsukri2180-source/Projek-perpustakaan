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
     * Relasi ke Model Kelas (Has Many)
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }

    /**
     * Relasi ke Model Siswa (Has Many)
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'jurusan_id');
    }
}