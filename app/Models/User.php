<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'barcode_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Pastikan password selalu ter-hash otomatis
     * setiap kali diisi/di-update (Laravel 10+/11).
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->barcode_code)) {
                $user->barcode_code = self::generateUniqueBarcode();
            }
        });
    }
    protected static function generateUniqueBarcode(): string
    {
        do {
            $code = 'ADM-' . strtoupper(Str::random(8));
        } while (self::where('barcode_code', $code)->exists());

        return $code;
    }
}