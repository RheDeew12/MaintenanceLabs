<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaboratoriumSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            // PRODI ID 1: TPK (Teknologi Pengolahan Kulit)
            ['nama_lab' => 'Lab Kimia Terapan', 'prodi_id' => 1],
            ['nama_lab' => 'Lab Limbah dan UPAL', 'prodi_id' => 1],
            ['nama_lab' => 'Lab Mikrobiologi dan Teknologi Enzim', 'prodi_id' => 1],
            ['nama_lab' => 'Workshop Beam House dan Tanning', 'prodi_id' => 1],
            ['nama_lab' => 'Workshop Pasca Tanning dan Finishing', 'prodi_id' => 1],

            // PRODI ID 2: TPPK (Teknologi Pengolahan Produk Kulit)
            ['nama_lab' => 'Lab Pengembangan Desain', 'prodi_id' => 2],
            ['nama_lab' => 'Workshop Acuan', 'prodi_id' => 2],
            ['nama_lab' => 'Workshop Alas Kaki (Upper Shoes)', 'prodi_id' => 2],
            ['nama_lab' => 'Workshop Alas Kaki (Bottom Shoes', 'prodi_id' => 2],
            ['nama_lab' => 'Workshop Busana', 'prodi_id' => 2],
            ['nama_lab' => 'Workshop Jahit', 'prodi_id' => 2],
            ['nama_lab' => 'Workshop Produk Kulit', 'prodi_id' => 2],

            // PRODI ID 3: TPKP (Teknologi Pengolahan Karet & Plastik)
            ['nama_lab' => 'Lab Instrumentasi dan Teknik Polimer', 'prodi_id' => 3],
            ['nama_lab' => 'Lab  Komputasi dan Optimisasi Sistem Industri', 'prodi_id' => 3],
            ['nama_lab' => 'Workshop Pengujian', 'prodi_id' => 3],
            ['nama_lab' => 'Workshop Karet ', 'prodi_id' => 3],
            ['nama_lab' => 'Workshop Plastik', 'prodi_id' => 3],
        ];

        foreach ($units as $unit) {
            DB::table('laboratoriums')->updateOrInsert(
                ['nama_lab' => $unit['nama_lab']], // Cek agar tidak duplikat
                ['prodi_id' => $unit['prodi_id'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}