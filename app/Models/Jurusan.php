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

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'jurusan_id');
    }

    // WAJIB ADA: Method ini yang dipanggil oleh Controller
    public function absensis()
    {
        return $this->hasManyThrough(Absensi::class, Siswa::class, 'jurusan_id', 'siswa_id');
    }
}