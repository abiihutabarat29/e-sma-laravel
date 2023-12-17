<?php

namespace Database\Seeders;

use App\Models\TahunPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tahun' => '2023/2024',
                'status' => 1,
            ],
            [
                'tahun' => '2024/2025',
                'status' => 0,
            ],
            [
                'tahun' => '2025/2026',
                'status' => 0,
            ],
        ];
        TahunPelajaran::insert($data);
    }
}
