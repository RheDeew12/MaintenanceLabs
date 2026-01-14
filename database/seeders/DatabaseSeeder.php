<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil seeder user agar data akun otomatis terisi
        $this->call([
            DummyUsersSeeder::class,
            // Anda bisa menambah EquipmentSeeder::class di sini nanti
        ]);
    }
}