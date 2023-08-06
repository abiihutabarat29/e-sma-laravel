<?php

namespace Database\Seeders;

use App\Models\ProfileCabdis;
use App\Models\UsersCabdis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileCabdisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user cabdis dengan ID 1
        $userCabdis = UsersCabdis::find(1);

        if ($userCabdis) {
            ProfileCabdis::create([
                'users_cabdis_id' => $userCabdis->id,
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'nik' => '1212121212121200',
                'nohp' => '082274884828',
            ]);
        }
    }
}
