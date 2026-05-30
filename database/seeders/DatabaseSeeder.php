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
        /**
         * PENTING: Urutan pemanggilan harus sesuai dengan dependensi Foreign Key.
         * 1. LaboratoriumSeeder: Mengisi ID 1-17 agar tersedia di tabel laboratoriums.
         * 2. DummyUsersSeeder: Membuat user yang merujuk ke ID lab tersebut.
         */
    $this->call([
            ProdiSeeder::class,        // Jalankan Pertama
            LaboratoriumSeeder::class, // Jalankan Kedua
            DummyUsersSeeder::class,   // Jalankan Ketiga
            BarangSeeder::class,
        ]);
    }
}