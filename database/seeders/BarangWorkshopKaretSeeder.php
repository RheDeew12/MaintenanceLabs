<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangWorkshopKaretSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Karet [ID 16]
        $idLab = 16;

        $barangs = [
            // --- ALAT UJI & LABORATORIUM (Halaman 1, 4, 5, 6) ---
            ['nama' => 'Hardnes Tester', 'merk' => 'Shore A Durometer', 'bmn' => '3030308016', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Hardnes Tester', 'merk' => 'Shore C Durometer', 'bmn' => '3030308016', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Hardnes Tester', 'merk' => 'Shore D Durometer', 'bmn' => '3030308016', 'nup' => 3, 'thn' => 2013],
            ['nama' => 'Alat Penghancur Plastik', 'merk' => '(CRUSHER PLASTIK) Pisau Baja Rangka UNP 66', 'bmn' => '3050105085', 'nup' => 1, 'thn' => 2017],
            ['nama' => 'Oven (Alat Laboratorium Umum)', 'merk' => 'Oven Vulkanisasi', 'bmn' => '3080111005', 'nup' => 8, 'thn' => 2019],
            ['nama' => 'Timbangan/Neraca', 'merk' => 'Neraca Analitik Newtech 3000 x 0,01', 'bmn' => '3080111023', 'nup' => 7, 'thn' => 2024],
            ['nama' => 'Timbangan/Neraca', 'merk' => 'Neraca Analitik Newtech 3000 x 0,01', 'bmn' => '3080111023', 'nup' => 8, 'thn' => 2024],
            ['nama' => 'Moulding Machine', 'merk' => 'NEW SEAZEN', 'bmn' => '3080125002', 'nup' => 1, 'thn' => 2009],
            ['nama' => 'Moulding Machine', 'merk' => '-', 'bmn' => '3080125002', 'nup' => 3, 'thn' => 2013],
            ['nama' => 'Mesin Two Roll Mill', 'merk' => 'GOTECH', 'bmn' => '3080137050', 'nup' => 1, 'thn' => 2009],
            ['nama' => 'Mesin Two Roll Mill', 'merk' => '-', 'bmn' => '3080137050', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Deal Tickness Gauge', 'merk' => 'Mitutoyo 0,01mm', 'bmn' => '3080138029', 'nup' => 6, 'thn' => 2013],
            ['nama' => 'Alat Laboratorium Uji (Rheometer)', 'merk' => 'Rheometer GOTECH GT-M2000', 'bmn' => '3080138999', 'nup' => 1, 'thn' => 2009],
            ['nama' => 'Alat Laboratorium Lainnya', 'merk' => 'REAKTOR PIROLISI 20kg', 'bmn' => '3080138999', 'nup' => 8, 'thn' => 2017],
            ['nama' => 'Calender', 'merk' => 'Mesin Calendering YADONG', 'bmn' => '3080140015', 'nup' => 1, 'thn' => 2009],
            ['nama' => 'Cutting Machine', 'merk' => 'YADONG', 'bmn' => '3080145033', 'nup' => 1, 'thn' => 2009],
            ['nama' => 'Alat Pengolah Air Limbah', 'merk' => '(UNIT DEMINERALISASI) 5000L', 'bmn' => '3080156017', 'nup' => 1, 'thn' => 2017],
            ['nama' => 'Ball Mill', 'merk' => 'Mesin Penggiling', 'bmn' => '3080203079', 'nup' => 1, 'thn' => 2019],

            // --- MEBELAIR (Halaman 1, 4, 5, 6) ---
            ['nama' => 'Lemari Besi/Metal', 'merk' => 'BROTHER', 'bmn' => '3050104001', 'nup' => 29, 'thn' => 2011],
            ['nama' => 'Lemari Kayu', 'merk' => '-', 'bmn' => '3050104002', 'nup' => 15, 'thn' => 2011],
            ['nama' => 'Lemari Kayu', 'merk' => '-', 'bmn' => '3050104002', 'nup' => 19, 'thn' => 2011],
            ['nama' => 'Filing Cabinet Besi', 'merk' => 'BROTHER', 'bmn' => '3050104005', 'nup' => 36, 'thn' => 1997],
            ['nama' => 'Locker', 'merk' => 'DATAFILE', 'bmn' => '3050104015', 'nup' => 10, 'thn' => 2007],
            ['nama' => 'Locker', 'merk' => 'BROTHER 6 Pintu', 'bmn' => '3050104015', 'nup' => 26, 'thn' => 2015],
            ['nama' => 'Locker', 'merk' => 'BROTHER 6 Pintu', 'bmn' => '3050104015', 'nup' => 27, 'thn' => 2015],
            ['nama' => 'Locker', 'merk' => 'BROTHER 6 Pintu', 'bmn' => '3050104015', 'nup' => 28, 'thn' => 2015],
            ['nama' => 'White Board', 'merk' => '-', 'bmn' => '3050105010', 'nup' => 42, 'thn' => 2013],
            ['nama' => 'Tabung Pemadam Api', 'merk' => 'apar', 'bmn' => '3050105001', 'nup' => 11, 'thn' => 2021],

            // Meja Kerja
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 134, 'thn' => 2009],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 136, 'thn' => 2009],
            ['nama' => 'Meja Kerja Kayu', 'merk' => 'EXPO MP-120 Laci 1/2 biro', 'bmn' => '3050201002', 'nup' => 312, 'thn' => 2017],
            ['nama' => 'Meja Kerja Kayu', 'merk' => 'EXPO MP-120 Laci 1/2 biro', 'bmn' => '3050201002', 'nup' => 313, 'thn' => 2017],
            ['nama' => 'Meja Kerja', 'merk' => 'Meja Praktek', 'bmn' => '3080156081', 'nup' => 23, 'thn' => 2015],
            ['nama' => 'Meja Kerja', 'merk' => 'Meja Praktek', 'bmn' => '3080156081', 'nup' => 24, 'thn' => 2015],

            // --- ELEKTRONIK & TIK (Halaman 5, 6) ---
            ['nama' => 'A.C. Split', 'merk' => 'PANASONIC', 'bmn' => '3050204004', 'nup' => 47, 'thn' => 2012],
            ['nama' => 'A.C. Split', 'merk' => 'PANASONIC', 'bmn' => '3050204004', 'nup' => 49, 'thn' => 2012],
            ['nama' => 'Kipas Angin', 'merk' => 'Maspion Besi 16"', 'bmn' => '3050204006', 'nup' => 48, 'thn' => 2023],
            ['nama' => 'Kipas Angin', 'merk' => 'Maspion Besi 16"', 'bmn' => '3050204006', 'nup' => 49, 'thn' => 2023],
            ['nama' => 'Mixer', 'merk' => 'Mixer Comp EHM-9090 TURBO', 'bmn' => '3050205019', 'nup' => 2, 'thn' => 2024],
            ['nama' => 'Mixer', 'merk' => 'Mixer Comp EHM-9090 TURBO', 'bmn' => '3050205019', 'nup' => 3, 'thn' => 2024],
            ['nama' => 'P.C Unit', 'merk' => 'COMPAQ', 'bmn' => '3100102001', 'nup' => 94, 'thn' => 2011],
            ['nama' => 'Printer', 'merk' => 'Epson L365', 'bmn' => '3100203003', 'nup' => 96, 'thn' => 2016],
            ['nama' => 'Boiler', 'merk' => 'Boiler', 'bmn' => '3130301010', 'nup' => 1, 'thn' => 2010],
        ];

        foreach ($barangs as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], $val['thn']);
        }

        // --- KURSI BESI/METAL CHITOSE & FUTURA (Massal) ---
        // Chitose NUP 265, 268, 269, 275-278, 377-379 (Tahun 2005-2007)
        $chitoseNups = [265, 268, 269, 275, 276, 277, 278, 377, 378, 379];
        foreach ($chitoseNups as $nup) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 2005);
        }
        // Futura 747 NUP 1463 - 1480 (Halaman 2, Tanggal 3/30/2015)
        for ($nup = 1463; $nup <= 1480; $nup++) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'FUTURA 747', '3050201003', $nup, 2015);
        }

        // --- KURSI KAYU PRAKTEK (Massal NUP 708 - 716) (Halaman 2) ---
        for ($nup = 708; $nup <= 716; $nup++) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 2015);
        }
    }

    private function saveBarang($idLab, $nama, $merk, $bmn, $nup, $thn)
    {
        Barang::updateOrCreate(
            ['kode_bmn' => $bmn . '.' . $nup],
            [
                'id_lab' => $idLab,
                'nama_barang' => $nama,
                'merk_tipe' => $merk,
                'kategori' => $this->getKategori($bmn),
                'tahun_perolehan' => $thn,
                'status_kondisi' => 'Baik',
                'klasifikasi_fungsi' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function getKategori($bmn)
    {
        if (str_starts_with($bmn, '303') || str_starts_with($bmn, '308')) return 'Alat Laboratorium';
        if (str_starts_with($bmn, '3050204') || str_starts_with($bmn, '310')) return 'Elektronik';
        return 'Furnitur';
    }
}