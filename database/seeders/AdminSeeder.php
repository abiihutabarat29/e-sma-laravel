<?php

namespace Database\Seeders;

use App\Models\UsersCabdis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nik' => '1212121212121200',
                'nama' => 'Administrator',
                'nohp' => '082274884828',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 1,
                'status' => 1,
            ],
        ];
        UsersCabdis::insert($data);
    }
}
