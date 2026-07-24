<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'nama',
        'nik',
        'email',
        'password',
        'barcode_code',
    ];

    protected $hidden = [
        'password',
    ];
}