<?php

namespace Database\Seeders;

use App\Models\ProfileCabdis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileCabdisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'users_cabdis_id' => '1',
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'nik' => '1212121212121200',
                'nohp' => '082274884828',
            ],
        ];
        ProfileCabdis::insert($data);
    }
}
