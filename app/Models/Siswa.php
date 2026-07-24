<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nama',
        'kelas_id',
        'jurusan_id',
        'barcode_code',
        'foto',
    ];

    /**
     * Relasi ke Model Kelas (Belongs To)
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke Model Jurusan (Belongs To)
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Relasi ke Model Absensi (Has Many)
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}