<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUsersSeeder extends Seeder
{
    public function run(): void
    {
        $userData = [
            [
                'name'     => 'SuperAdmin',
                'email'    => 'Superadmin@gmail.com',
                'role'     => 'Super Admin',
                'password' => Hash::make('123456')
            ],
            [
                'name'     => 'KaLab',
                'email'    => 'Kepalalab@gmail.com',
                'role'     => 'Kepala Lab',
                'password' => Hash::make('123456')
            ],
            [
                'name'     => 'TimPemelihara',
                'email'    => 'Timpemelihara@gmail.com',
                'role'     => 'Tim Pemelihara',
                'password' => Hash::make('123456')
            ],
            [
                'name'     => 'KaProdi',
                'email'    => 'Kaprodi@gmail.com',
                'role'     => 'Kaprodi',
                'password' => Hash::make('123456')
            ],
            [
                'name'     => 'PembantuDirektur1',
                'email'    => 'PembantuDirektur1@gmail.com',
                'role'     => 'Pembantu Direktur 1',
                'password' => Hash::make('123456')
            ],
                        [
                'name'     => 'PembantuDirektur2',
                'email'    => 'PembantuDirektur2@gmail.com',
                'role'     => 'Pembantu Direktur 2',
                'password' => Hash::make('123456')
            ],
        ];

foreach($userData as $key => $val){
    // Cari user berdasarkan email. 
    // Jika ketemu, update datanya. Jika tidak, buat baru.
    User::updateOrCreate(
        ['email' => $val['email']], // Kolom kunci pencarian
        $val                        // Data yang diinput/diupdate
        );
        }
    }
}