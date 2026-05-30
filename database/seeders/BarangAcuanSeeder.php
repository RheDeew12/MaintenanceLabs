<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangAcuanSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Ruang Workshop Acuan [ID 7]
        $idLab = 7;

        // --- 1. PERALATAN PRODUKSI & LAB (Halaman 1-2) ---
        
        // Ragum / Catok (Tanggem) NUP 1 - 5
        for ($nup = 1; $nup <= 5; $nup++) {
            $this->saveBarang($idLab, 'Ragum /Catok', 'Tanggem', '3040106020', $nup, 'Alat Laboratorium', 2015);
        }

        // Band Saw Machine (WIPRO JDD200 14")
        $this->saveBarang($idLab, 'Band Saw Machine', 'WIPRO JDD200 14"', '3080130017', 1, 'Alat Laboratorium', 2017);

        // Meja Kerja / Meja Praktik Upper
        $this->saveBarang($idLab, 'Meja Kerja (Alat Laboratorium)', 'Meja Praktik Upper', '3080156081', 67, 'Alat Laboratorium', 2015);

        // --- 2. MEBELAIR & FURNITUR (Halaman 1-2) ---
        
        // White Board
        $this->saveBarang($idLab, 'White Board', '-', '3050105010', 33, 'Furnitur', 2012);

        // Meja Kerja Kayu NUP 180 - 183
        for ($nup = 180; $nup <= 183; $nup++) {
            $this->saveBarang($idLab, 'Meja Kerja Kayu', '-', '3050201002', $nup, 'Furnitur', 2013);
        }

        // Kursi Besi/Metal (CHITOSE) NUP 743 - 746
        for ($nup = 743; $nup <= 746; $nup++) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', 2010);
        }

        // Kursi Kayu (Kursi Praktek) - NUP spesifik sesuai daftar di PDF
        $nupKursiKayu = [677, 678, 679, 680, 681, 682, 683, 684, 685, 686, 687, 688, 689, 690, 691, 693, 694, 695, 696, 697, 698, 699, 701];
        foreach ($nupKursiKayu as $nup) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 'Furnitur', 2015);
        }

        // --- 3. PERALATAN ELEKTRONIK (Halaman 1-2) ---
        
        // A.C. Split Panasonic 2PK (2015)
        $this->saveBarang($idLab, 'A.C. Split', 'Panasonic 2PK', '3050204004', 107, 'Elektronik', 2015);
        
        // A.C. Split Panasonic (2019)
        $this->saveBarang($idLab, 'A.C. Split', 'Panasonic', '3050204004', 116, 'Elektronik', 2019);

        // Water Filter
        $this->saveBarang($idLab, 'Water Filter', '-', '3050206033', 3, 'Elektronik', 2021);
    }

    /**
     * Helper untuk menyimpan data barang menggunakan updateOrCreate
     */
    private function saveBarang($idLab, $nama, $merk, $bmn, $nup, $kat, $thn)
    {
        Barang::updateOrCreate(
            ['kode_bmn' => $bmn . '.' . $nup], // Identitas unik: Kode BMN + NUP
            [
                'id_lab' => $idLab,
                'nama_barang' => $nama,
                'merk_tipe' => $merk,
                'kategori' => $kat,
                'tahun_perolehan' => $thn,
                'status_kondisi' => 'Baik',
                'klasifikasi_fungsi' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}