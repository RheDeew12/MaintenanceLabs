<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangLabKimiaSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Laboratorium Kimia [ID 1]
        $idLab = 1;

        // --- 1. PERALATAN LABORATORIUM SPESIFIK (Halaman 1-2, 4, 6, 8) ---
        $peralatanLab = [
            ['nama' => 'Mufle Furnace', 'merk' => 'THEMOLYNE 48000 Furnace', 'bmn' => '3080110131', 'nup' => 1, 'thn' => 2006],
            ['nama' => 'Water Bath', 'merk' => 'MEMMERT', 'bmn' => '3080111002', 'nup' => 7, 'thn' => 2015],
            ['nama' => 'Oven (Alat Lab Umum)', 'merk' => 'BINDER', 'bmn' => '3080111005', 'nup' => 4, 'thn' => 2004],
            ['nama' => 'Oven (Alat Lab Umum)', 'merk' => 'Oven Lab Kimia', 'bmn' => '3080111005', 'nup' => 7, 'thn' => 2013],
            ['nama' => 'Timbangan/Neraca', 'merk' => 'AND', 'bmn' => '3080111023', 'nup' => 4, 'thn' => 2004],
            ['nama' => 'Furnace', 'merk' => 'THERMOLYNE 62700 Furnace', 'bmn' => '3080111059', 'nup' => 2, 'thn' => 2005],
            ['nama' => 'Kyldahl Apparatus', 'merk' => '-', 'bmn' => '3080113024', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Lemari Asam', 'merk' => 'LEMARI ASAM GALVANIS', 'bmn' => '3080117016', 'nup' => 5, 'thn' => 2015],
            ['nama' => 'Meja Kerja Stainless', 'merk' => 'instrumen 2 susun laci ss', 'bmn' => '3080118026', 'nup' => 1, 'thn' => 2022],
            ['nama' => 'Osmometer', 'merk' => 'PRECISION 5002', 'bmn' => '3080155017', 'nup' => 1, 'thn' => 2004],
            ['nama' => 'Timbangan Elektronik', 'merk' => 'Timbangan bahan kimia (Digital coffe Scale IL-500A)', 'bmn' => '3080101009', 'nup' => 3, 'thn' => 2023],
        ];

        foreach ($peralatanLab as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], 'Alat Laboratorium', $val['thn']);
        }

        // Magnetic Stirer & Rod With Hot Plate (NUP Campuran)
        $nupStirer = [6, 7, 12, 13, 14, 15, 16, 17];
        foreach ($nupStirer as $nup) {
            $thn = ($nup == 6) ? 2011 : (($nup == 7) ? 2012 : 2013);
            $this->saveBarang($idLab, 'Magnetic Stirer & Rod With Hot Plate', 'CIMAREC', '30801112010', $nup, 'Alat Laboratorium', $thn);
        }

        // --- 2. MEBELAIR & FURNITUR (Halaman 1, 3, 5, 7) ---

        // Lemari Kayu & Rak (BMN 3050104002/4)
        $this->saveBarang($idLab, 'Lemari Kayu', '-', '3050104002', 5, 'Furnitur', 1983);
        $this->saveBarang($idLab, 'Lemari Kayu', '-', '3050104002', 22, 'Furnitur', 2011);
        $this->saveBarang($idLab, 'Rak Kayu', 'Kayu Jati 119x48x152', '3050104004', 15, 'Furnitur', 2015);

        // Buffet (NUP 10, 11, 37, 39)
        foreach ([10, 11] as $nup) $this->saveBarang($idLab, 'Buffet', '-', '3050104013', $nup, 'Furnitur', 1980);
        foreach ([37, 39] as $nup) $this->saveBarang($idLab, 'Buffet', '-', '3050104013', $nup, 'Furnitur', 1997);

        // Locker (NUP 12, 14, 15 - DATAFILE) & (NUP 38, 39 - BROTHER)
        foreach ([12, 14, 15] as $nup) $this->saveBarang($idLab, 'Locker', 'DATAFILE', '3050104015', $nup, 'Furnitur', 2007);
        foreach ([38, 39] as $nup) $this->saveBarang($idLab, 'Locker', 'BROTHER 6 Pintu', '3050104015', $nup, 'Furnitur', 2015);

        // Kursi Besi/Metal (CHITOSE)
        foreach ([348, 349, 350, 351] as $nup) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', 2005);
        }

        // Kursi Kayu (Kursi Praktek) NUP 767 - 784
        for ($nup = 767; $nup <= 784; $nup++) {
            if ($nup == 772 || $nup == 783) continue;
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 'Furnitur', 2015);
        }

        // --- 3. ELEKTRONIK & TIK (Halaman 3, 5, 7, 8) ---
        
        // Lemari Es & AC
        $this->saveBarang($idLab, 'Lemari Es', 'SHARP', '3050204001', 3, 'Elektronik', 2001);
        $this->saveBarang($idLab, 'A.C. Split', 'SHARP', '3050204004', 75, 'Elektronik', 2013);

        // Kipas Angin Gantung (Panasonic)
        foreach ([35, 40] as $nup) {
            $this->saveBarang($idLab, 'Kipas Angin', 'PANASONIC', '3050204006', $nup, 'Elektronik', 2015);
        }

        // Printer (TIK)
        $this->saveBarang($idLab, 'Printer', 'Epson L365', '3100203003', 104, 'Elektronik', 2016);
    }

    /**
     * Helper untuk menyimpan data barang menggunakan updateOrCreate
     */
    private function saveBarang($idLab, $nama, $merk, $bmn, $nup, $kat, $thn)
    {
        Barang::updateOrCreate(
            ['kode_bmn' => $bmn . '.' . $nup],
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