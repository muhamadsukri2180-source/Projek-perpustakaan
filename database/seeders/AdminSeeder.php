<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Memastikan akun admin punya password yang sudah di-hash bcrypt dengan benar.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sekolah.com'], // kunci pencarian
            [
                'name'         => 'Admin Perpustakaan',
                'password'     => Hash::make('admin123'),
                'barcode_code' => 'ADM-' . strtoupper(uniqid()),
            ]
        );

        $this->command->info('Admin siap -> email: admin@sekolah.com | password: admin123');
    }
}