<?php

namespace Database\Seeders;

use App\Models\KategoriMapel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori' => 'WAJIB',
            ],
            [
                'kategori' => 'PAI (Kemenag)',
            ],
            [
                'kategori' => 'PERMINATAN AKADEMIK',
            ],
            [
                'kategori' => 'AKADEMIK KEJURUAN',
            ],
            [
                'kategori' => 'LINTAS MINAT',
            ],
            [
                'kategori' => 'MULOK',
            ],
        ];
        KategoriMapel::insert($data);
    }
}
