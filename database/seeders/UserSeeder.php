<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'sekolah_id' => 0,
                'nik' => 202020202020202020,
                'nama' => 'Admin',
                'nohp' => '082274884828',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 1,
                'status' => 1,
            ],
        ];
        User::insert($data);
    }
}
