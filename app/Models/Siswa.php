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
        'nis',
        'nama',
        'kelas_id',
        'jurusan_id',
        'barcode_code',
        'foto',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }


    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }


    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}