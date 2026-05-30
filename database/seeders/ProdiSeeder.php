<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $prodis = [
            ['id' => 1, 'nama_prodi' => 'Teknologi Pengolahan Kulit (TPK)'],
            ['id' => 2, 'nama_prodi' => 'Teknologi Pengolahan Produk Kulit (TPPK)'],
            ['id' => 3, 'nama_prodi' => 'Teknologi Pengolahan Karet dan Plastik (TPKP)'],
        ];

        foreach ($prodis as $prodi) {
            DB::table('prodis')->updateOrInsert(['id' => $prodi['id']], $prodi);
        }
    }
}