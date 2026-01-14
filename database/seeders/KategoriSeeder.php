<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_kategori')->insert([
            ['id' => 1, 'nama_kategori' => 'Mesin Berat', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama_kategori' => 'Alat Gelas', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama_kategori' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama_kategori' => 'Instrumen Presisi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nama_kategori' => 'Alat Peraga', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}