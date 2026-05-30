<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Password default disamakan untuk semua akun
        $defaultPassword = Hash::make('123456');

        $userData = [
            // --- GLOBAL ADMIN & MANAGEMENT ---
            ['name' => 'SuperAdmin', 'email' => 'Superadmin@politeknikATK.ac.id', 'role' => 'Super Admin', 'password' => $defaultPassword],
            ['name' => 'TimPemelihara', 'email' => 'Timpemelihara@politeknikATK.ac.id', 'role' => 'Tim Pemelihara', 'password' => $defaultPassword],
            ['name' => 'PembantuDirektur1', 'email' => 'PembantuDirektur1@politeknikATK.ac.id', 'role' => 'Pembantu Direktur 1', 'password' => $defaultPassword],
            ['name' => 'PembantuDirektur2', 'email' => 'PembantuDirektur2@politeknikATK.ac.id', 'role' => 'Pembantu Direktur 2', 'password' => $defaultPassword],

            // --- KEPALA PROGRAM STUDI (KAPRODI) ---
            ['name' => 'KaProdi TPK', 'email' => 'kaprodi.tpk@politeknikATK.ac.id', 'role' => 'Kaprodi', 'prodi_id' => 1, 'password' => $defaultPassword],
            ['name' => 'KaProdi TPPK', 'email' => 'kaprodi.tppk@politeknikATK.ac.id', 'role' => 'Kaprodi', 'prodi_id' => 2, 'password' => $defaultPassword],
            ['name' => 'KaProdi TPKP', 'email' => 'kaprodi.tpkp@politeknikATK.ac.id', 'role' => 'Kaprodi', 'prodi_id' => 3, 'password' => $defaultPassword],

            // --- 17 KEPALA LAB / ADMIN UNIT (Sesuai Struktur Unit Management) ---
            // TPK (prodi_id: 1)
            ['name' => 'Admin Lab Kimia Terapan', 'email' => 'lab.kimia@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 1, 'prodi_id' => 1, 'password' => $defaultPassword],
            ['name' => 'Admin Lab Limbah & UPAL', 'email' => 'lab.limbah@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 2, 'prodi_id' => 1, 'password' => $defaultPassword],
            ['name' => 'Admin Lab Mikrobiologi', 'email' => 'lab.mikro@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 3, 'prodi_id' => 1, 'password' => $defaultPassword],
            ['name' => 'Admin WS Beam House', 'email' => 'ws.tanning@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 4, 'prodi_id' => 1, 'password' => $defaultPassword],
            ['name' => 'Admin WS Finishing', 'email' => 'ws.finishing@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 5, 'prodi_id' => 1, 'password' => $defaultPassword],

            // TPPK (prodi_id: 2)
            ['name' => 'Admin Lab Desain', 'email' => 'lab.desain@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 6, 'prodi_id' => 2, 'password' => $defaultPassword],
            ['name' => 'Admin WS Acuan', 'email' => 'ws.acuan@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 7, 'prodi_id' => 2, 'password' => $defaultPassword],
            ['name' => 'Admin WS Upper Shoes', 'email' => 'ws.upper@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 8, 'prodi_id' => 2, 'password' => $defaultPassword],
            ['name' => 'Admin WS Bottom Shoes', 'email' => 'ws.bottom@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 9, 'prodi_id' => 2, 'password' => $defaultPassword],
            ['name' => 'Admin WS Busana', 'email' => 'ws.busana@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 10, 'prodi_id' => 2, 'password' => $defaultPassword],
            ['name' => 'Admin WS Jahit', 'email' => 'ws.jahit@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 11, 'prodi_id' => 2, 'password' => $defaultPassword],
            ['name' => 'Admin WS Produk Kulit', 'email' => 'ws.produk@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 12, 'prodi_id' => 2, 'password' => $defaultPassword],

            // TPKP (prodi_id: 3)
            ['name' => 'Admin Lab Polimer', 'email' => 'lab.polimer@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 13, 'prodi_id' => 3, 'password' => $defaultPassword],
            ['name' => 'Admin Lab Komputasi', 'email' => 'lab.komputasi@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 14, 'prodi_id' => 3, 'password' => $defaultPassword],
            ['name' => 'Admin Lab Pengujian', 'email' => 'lab.pengujian@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 15, 'prodi_id' => 3, 'password' => $defaultPassword],
            ['name' => 'Admin WS Karet', 'email' => 'ws.karet@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 16, 'prodi_id' => 3, 'password' => $defaultPassword],
            ['name' => 'Admin WS Plastik', 'email' => 'ws.plastik@politeknikATK.ac.id', 'role' => 'Kepala Lab', 'lab_id' => 17, 'prodi_id' => 3, 'password' => $defaultPassword],
        ];

        foreach ($userData as $val) {
            User::updateOrCreate(
                ['email' => $val['email']], 
                $val
            );
        }
    }
}