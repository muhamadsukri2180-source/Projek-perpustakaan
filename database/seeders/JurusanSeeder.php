<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_jurusan' => 'RPL 1', 'kode_jurusan' => 'RPL1'],
            ['nama_jurusan' => 'RPL 2', 'kode_jurusan' => 'RPL2'],
            ['nama_jurusan' => 'AKL 1', 'kode_jurusan' => 'AKL1'],
            ['nama_jurusan' => 'AKL 2', 'kode_jurusan' => 'AKL2'],
            ['nama_jurusan' => 'BR 1',  'kode_jurusan' => 'BR1'],
            ['nama_jurusan' => 'BR 2',  'kode_jurusan' => 'BR2'],
            ['nama_jurusan' => 'MP',   'kode_jurusan' => 'MP'],
        ];

        foreach ($data as $item) {
            Jurusan::firstOrCreate(
                ['kode_jurusan' => $item['kode_jurusan']],
                $item
            );
        }
    }
}