<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangFinishingPascaTanningSeeder extends Seeder
{
    public function run(): void
    {
        // ID 5 = Workshop Finishing Pasca Tanning [cite: 1, 17]
        $idLabFinishing = 5;

        $barangs = [
            // --- DATA HASIL EKSTRAKSI PDF (Halaman 1) ---
            [
                'nama' => 'Mesin Kompresor', 
                'merk' => '-', 
                'bmn' => '3030101018', 
                'nup' => '5', 
                'kat' => 'Alat Laboratorium', 
                'thn' => 2012
            ], 
            [
                'nama' => 'Mesin Kompresor', 
                'merk' => '-', 
                'bmn' => '3030101018', 
                'nup' => '6', 
                'kat' => 'Alat Laboratorium', 
                'thn' => 2012
            ], 
            [
                'nama' => 'Rak Besi', 
                'merk' => '-', 
                'bmn' => '3050104003', 
                'nup' => '21', 
                'kat' => 'Furnitur', 
                'thn' => 2015
            ], 
            [
                'nama' => 'Rak Kayu', 
                'merk' => 'Rak Kulit', 
                'bmn' => '3050104004', 
                'nup' => '10', 
                'kat' => 'Furnitur', 
                'thn' => 2015
            ], 
            [
                'nama' => 'Tabung Pemadam Api', 
                'merk' => 'MINIMAX', 
                'bmn' => '3050105001', 
                'nup' => '2', 
                'kat' => 'Alat Laboratorium', 
                'thn' => 1996
            ], 
            [
                'nama' => 'White Board', 
                'merk' => '-', 
                'bmn' => '3050105010', 
                'nup' => '35', 
                'kat' => 'Furnitur', 
                'thn' => 2012
            ], 
            [
                'nama' => 'Kursi Besi/Metal', 
                'merk' => 'CHITOSE', 
                'bmn' => '3050201003', 
                'nup' => '419', 
                'kat' => 'Furnitur', 
                'thn' => 2007
            ], 
            [
                'nama' => 'Kipas Angin', 
                'merk' => 'regency ST-20', 
                'bmn' => '3050204006', 
                'nup' => '45', 
                'kat' => 'Elektronik', 
                'thn' => 2022
            ], 
            [
                'nama' => 'Exhause Fan', 
                'merk' => 'panasonic/FV-40 FAU', 
                'bmn' => '3050204007', 
                'nup' => '18', 
                'kat' => 'Elektronik', 
                'thn' => 2022
            ], 
            [
                'nama' => 'Exhause Fan', 
                'merk' => 'panasonic/FV-40 FAU', 
                'bmn' => '3050204007', 
                'nup' => '19', 
                'kat' => 'Elektronik', 
                'thn' => 2022
            ], 
            [
                'nama' => 'Meja Pentang Kayu', 
                'merk' => 'Meja Pentang Kayu', 
                'bmn' => '3080113052', 
                'nup' => '8', 
                'kat' => 'Alat Laboratorium', 
                'thn' => 2013
            ], 
            [
                'nama' => 'Meja Pentang Kayu', 
                'merk' => 'Meja Pentang Kayu', 
                'bmn' => '3080113052', 
                'nup' => '9', 
                'kat' => 'Alat Laboratorium', 
                'thn' => 2013
            ], 
        ];

        foreach ($barangs as $val) {
            // Menggabungkan BMN dan NUP sebagai identitas unik [17]
            $kodeUnik = $val['bmn'] . '.' . $val['nup'];

            Barang::updateOrCreate(
                ['kode_bmn' => $kodeUnik], 
                [
                    'id_lab' => $idLabFinishing,
                    'nama_barang' => $val['nama'],
                    'merk_tipe' => $val['merk'],
                    'kategori' => $val['kat'],
                    'tahun_perolehan' => $val['thn'],
                    'status_kondisi' => 'Baik', 
                    'klasifikasi_fungsi' => 'Pendidikan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}