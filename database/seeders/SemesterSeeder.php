<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'semester' => 'Ganjil',
                'nama_smt' => 'I (satu)',
                'status' => 1,
            ],
            [
                'semester' => 'Genap',
                'nama_smt' => 'II (dua)',
                'status' => 0,
            ],
        ];
        Semester::insert($data);
    }
}
