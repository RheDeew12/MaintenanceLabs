<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangUpperShoesSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Alas Kaki (Upper Shoes) [ID 8]
        $idLab = 8;

        // --- 1. PERALATAN PRODUKSI & MESIN JAHIT SPESIFIK (Halaman 1, 5, 12, 13) ---
        $peralatanProduksi = [
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'Golden Wheel CSL-1810', 'bmn' => '3030101016', 'nup' => 61, 'thn' => 2005],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'GOLDEN WHEEL/CS-8810', 'bmn' => '3030101016', 'nup' => 65, 'thn' => 2008],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'GOLDEN WHEEL/CS-8820', 'bmn' => '3030101016', 'nup' => 67, 'thn' => 2008],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'GOLDEN WHEEL/CS-8820', 'bmn' => '3030101016', 'nup' => 68, 'thn' => 2008],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI PLH-981 POSBED', 'bmn' => '3030101016', 'nup' => 88, 'thn' => 2011],
            ['nama' => 'Mesin Embos', 'merk' => 'Mesin Embos, LZ90, LITZHOU', 'bmn' => '3030210999', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Mesin Lipat Kain', 'merk' => 'LIZHOU Leather Strip Cutting Machine', 'bmn' => '3080134059', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Mesin Lipat Kain', 'merk' => 'LIZHOU Leather Strip Cutting Machine', 'bmn' => '3080134059', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Mesin Lipat Kain', 'merk' => 'RCBD-291', 'bmn' => '3080134059', 'nup' => 3, 'thn' => 2013],
            ['nama' => 'Mesin Seser', 'merk' => 'Yakumo NLS-7506', 'bmn' => '3080137015', 'nup' => 3, 'thn' => 2013],
            ['nama' => 'Mesin Seser', 'merk' => 'LEOPARD TB 801', 'bmn' => '3080137015', 'nup' => 5, 'thn' => 2013],
            ['nama' => 'Mesin Seser', 'merk' => 'GOLDEN WHEEL/CS-747', 'bmn' => '3080137015', 'nup' => 7, 'thn' => 2013],
            ['nama' => 'Mesin Seser', 'merk' => 'TAKING TK-801', 'bmn' => '3080137015', 'nup' => 8, 'thn' => 2013],
            ['nama' => 'Mesin Seser', 'merk' => 'TAKING TK-801', 'bmn' => '3080137015', 'nup' => 9, 'thn' => 2013],
        ];

        foreach ($peralatanProduksi as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], 'Alat Laboratorium', $val['thn']);
        }

        // Matras Emboss Logo (NUP 7-12)
        foreach (range(7, 12) as $nup) {
            $this->saveBarang($idLab, 'Matras Emboss Logo', '-', '3030210999', $nup, 'Alat Laboratorium', 2013);
        }

        // Mesin Jahit CS 8810, GoldenWheel (NUP 24-48)
        foreach (range(24, 48) as $nup) {
            $this->saveBarang($idLab, 'Mesin Jahit', 'CS 8810, GoldenWheel', '3050206022', $nup, 'Alat Laboratorium', 2013);
        }

        // Mesin Jahit CS 5100HI, GoldenWheel (NUP 71-74)
        foreach (range(71, 74) as $nup) {
            $this->saveBarang($idLab, 'Mesin Jahit', 'CS 5100HI, GoldenWheel', '3050206022', $nup, 'Alat Laboratorium', 2013);
        }

        // --- 2. MEBELAIR & FURNITUR (Halaman 5, 8, 9, 10, 11, 13) ---
        $this->saveBarang($idLab, 'Lemari Kayu', '-', '3050104002', 8, 'Furnitur', 1998);
        $this->saveBarang($idLab, 'Rak Besi', '-', '3050104003', 8, 'Furnitur', 1999);
        $this->saveBarang($idLab, 'Buffet', '-', '3050104013', 8, 'Furnitur', 1973);
        $this->saveBarang($idLab, 'White Board', '-', '3050105010', 27, 'Furnitur', 2011);

        // Meja Kerja Kayu
        foreach ([43, 44, 45] as $nup) $this->saveBarang($idLab, 'Meja Kerja Kayu', '-', '3050201002', $nup, 'Furnitur', 1986);
        $this->saveBarang($idLab, 'Meja Kerja Kayu', '-', '3050201002', 173, 'Furnitur', 2013);

        // Kursi Besi/Metal (CHITOSE)
        foreach ([243, 244, 245, 246] as $nup) $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', 2005);
        foreach ([385, 386, 387] as $nup) $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', 2007);

        // Kursi Kayu (Kursi Praktek) - NUP 517 s/d 607 (Total 91 Unit) [cite: 5, 11, 13]
        for ($nup = 517; $nup <= 607; $nup++) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 'Furnitur', 2015);
        }

        // Meja Kerja (Alat Laboratorium Lainnya)
        foreach (range(40, 49) as $nup) $this->saveBarang($idLab, 'Meja Kerja', 'Meja Praktek', '3080156081', $nup, 'Alat Laboratorium', 2013);
        foreach ([68, 69, 70] as $nup) $this->saveBarang($idLab, 'Meja Kerja', 'Meja Praktik Upper', '3080156081', $nup, 'Alat Laboratorium', 2013);

        // --- 3. ELEKTRONIK & TIK (Halaman 5, 8, 11, 12, 13) ---
        $this->saveBarang($idLab, 'LCD Projector/Infocus', 'EPSON LCD Low End 3600', '3050105048', 45, 'Elektronik', 2019);
        $this->saveBarang($idLab, 'A.C. Split', 'Panasonic CS/CU-PN18WKJ', '3050204004', 130, 'Elektronik', 2021);
        $this->saveBarang($idLab, 'P.C Unit', 'LENOVO', '3100102001', 141, 'Elektronik', 2011);
        $this->saveBarang($idLab, 'Printer', 'Epson L365', '3100203003', 111, 'Elektronik', 2016);
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