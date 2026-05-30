<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangLabPolimerSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Laboratorium Instrumentasi dan Polimer [ID 13]
        $idLab = 13;

        // --- 1. INSTRUMEN LABORATORIUM CANGGIH (Halaman 3, 4, 6, 7, 8) ---
        $instrumen = [
            ['nama' => 'Spectrophotometer', 'merk' => 'Lambda 25 Perkin Elmer UV Visibel', 'bmn' => '3080111138', 'nup' => 2, 'thn' => 2015],
            ['nama' => 'Mesin Scanning', 'merk' => 'DSC 4000 Perkin ELmer Differential Scanning Calorimeter', 'bmn' => '3080117023', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Thermogravimetri', 'merk' => 'Diamond TG/DTA Perkin Elmer', 'bmn' => '3080135037', 'nup' => 1, 'thn' => 2007],
            ['nama' => 'Atomic Absorption Spectrophotometer (AAS)', 'merk' => 'AAnalyst 200 Perkin Elmer', 'bmn' => '3080141017', 'nup' => 1, 'thn' => 2005],
            ['nama' => 'High Perfomance Liquid Chromatography (HPLC)', 'merk' => 'SHIMATZU,JAPAN', 'bmn' => '3080141122', 'nup' => 1, 'thn' => 2007],
            ['nama' => 'Uv-Vis Spectrophotometer', 'merk' => 'Lamda 25 Perkin Elmer', 'bmn' => '3080141299', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Gas Chromatograph Mass Spectrometer System (GCMSS)', 'merk' => 'Clarus 680 Perkin Elmer', 'bmn' => '3080146010', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Gas Chromatograph (GC)', 'merk' => 'GC-2014 SHIMADZU', 'bmn' => '3080146011', 'nup' => 1, 'thn' => 2006],
            ['nama' => 'FT-IR Spectrometer', 'merk' => 'Frontier Perkin Elmer', 'bmn' => '3080199999', 'nup' => 16, 'thn' => 2013],
            ['nama' => 'Monochrome Test Generator', 'merk' => '013', 'bmn' => '3030305016', 'nup' => 1, 'thn' => 2013],
        ];

        foreach ($instrumen as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], 'Alat Laboratorium', $val['thn']);
        }

        // --- 2. MEBELAIR & FURNITUR (Halaman 3, 5, 7) ---

        // Lemari Besi/Metal (Almari Arsip Brother)
        foreach ([44, 45] as $nup) {
            $this->saveBarang($idLab, 'Lemari Besi/Metal', 'BROTHER B 304 Almari Arsip', '3050104001', $nup, 'Furnitur', 2015);
        }
        // Lemari Penyimpanan Tabung Gas
        $this->saveBarang($idLab, 'Lemari Besi/Metal', 'Lemari Penyimpanan Tabung Gas', '3050104001', 49, 'Furnitur', 2022);

        // Locker Brother 6 Pintu (NUP 40-41)
        for ($nup = 40; $nup <= 41; $nup++) {
            $this->saveBarang($idLab, 'Locker', 'BROTHER 6 Pintu', '3050104015', $nup, 'Furnitur', 2015);
        }

        // Kursi Besi/Metal (CHITOSE)
        foreach ([337, 354, 355, 356] as $nup) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', 2005);
        }
        foreach ([462, 463] as $nup) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', 2007);
        }

        // Kursi Kayu (Kursi Praktek) NUP 734-738
        for ($nup = 734; $nup <= 738; $nup++) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 'Furnitur', 2015);
        }

        // --- 3. PERALATAN ELEKTRONIK & PENUNJANG (Halaman 3, 5, 6, 7, 8) ---

        // Lampu (PERKIN) NUP 1-10
        for ($nup = 1; $nup <= 10; $nup++) {
            $this->saveBarang($idLab, 'Lampu', 'PERKIN', '3050206017', $nup, 'Elektronik', 2013);
        }

        // Lampu Natrium (PERKIN) NUP 1-8
        for ($nup = 1; $nup <= 8; $nup++) {
            $this->saveBarang($idLab, 'Lampu Natrium', 'PERKIN', '3050206072', $nup, 'Elektronik', 2006);
        }

        // UPS Schneider (NUP 11-12)
        foreach ([11, 12] as $nup) {
            $this->saveBarang($idLab, 'Unit Power Supply', 'UPS Schneider', '3050204004', $nup, 'Elektronik', 2015);
        }

        // Printer EPSON
        $this->saveBarang($idLab, 'Printer', 'EPSON L365', '3100203003', 77, 'Elektronik', 2013);
        $this->saveBarang($idLab, 'Printer', 'EPSON L360', '3100203003', 78, 'Elektronik', 2013);
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