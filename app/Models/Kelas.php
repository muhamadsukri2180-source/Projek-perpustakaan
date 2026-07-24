<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'jurusan_id',
    ];

    /**
     * Relasi ke Model Jurusan (Belongs To)
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Relasi ke Model Siswa (Has Many)
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}