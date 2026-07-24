<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'no_hp',
        'user_id', // Opsional: Jika terhubung ke tabel users
    ];

    /**
     * Relasi ke Model User (Belongs To) - Jika mengintegrasikan dengan login Laravel
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}