<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangProdukKulitSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Produk Kulit [ID Lab 12]
        $idLab = 12;

        $items = [
            // --- 1. MESIN JAHIT KULIT (BMN 3030101016) ---
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'GOLDEN WHEEL/CS-8810', 'bmn' => '3030101016', 'nup' => 64, 'thn' => 2008],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'GOLDEN WHEEL/CS-335 BH', 'bmn' => '3030101016', 'nup' => 69, 'thn' => 2008],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'GOLDEN WHEEL/CS-335 BH', 'bmn' => '3030101016', 'nup' => 71, 'thn' => 2008],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DU-1181N', 'bmn' => '3030101016', 'nup' => 78, 'thn' => 2010],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DU-1181N', 'bmn' => '3030101016', 'nup' => 79, 'thn' => 2010],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DU-1181N', 'bmn' => '3030101016', 'nup' => 80, 'thn' => 2010],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DU-1181N', 'bmn' => '3030101016', 'nup' => 81, 'thn' => 2010],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DU-1181 N', 'bmn' => '3030101016', 'nup' => 93, 'thn' => 2012],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL-8100 e', 'bmn' => '3030101016', 'nup' => 94, 'thn' => 2012],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'KINGS HC810 POSBED', 'bmn' => '3030101016', 'nup' => 124, 'thn' => 2013],

            // --- 2. PERALATAN PRODUKSI LAINNYA ---
            ['nama' => 'Peralatan Tukang Kulit Lainnya', 'merk' => 'Mesin Embos,LZ90,LITZHOU', 'bmn' => '3030210999', 'nup' => 3, 'thn' => 2013],
            ['nama' => 'Mesin Laminating', 'merk' => 'LIZHOU LZ 280', 'bmn' => '3050105044', 'nup' => 1, 'thn' => 2012],
            ['nama' => 'Mesin Seser', 'merk' => 'TAKING TK-801', 'bmn' => '3080137015', 'nup' => 10, 'thn' => 2012],
            ['nama' => 'Mesin Potong Kulit', 'merk' => 'TAKING', 'bmn' => '3080137021', 'nup' => 2, 'thn' => 1992],
            ['nama' => 'Alat Pelubang Mata Ayam', 'merk' => '-', 'bmn' => '3080138017', 'nup' => 2, 'thn' => 2006],

            // --- 3. MESIN JAHIT GOLDEN WHEEL (BMN 3050206022) ---
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 8810,GoldenWheel', 'bmn' => '3050206022', 'nup' => 3, 'thn' => 2013],
            ...$this->generateItems($idLab, 'Mesin Jahit', 'CS 5100HI,GoldenWheel', '3050206022', [56, 57, 58, 61, 64, 65, 67, 69], 2013),
            ...$this->generateItems($idLab, 'Mesin Jahit', 'Golden Wheel CS 5100HI', '3050206022', [59, 60], 2013),
            ...$this->generateItems($idLab, 'Mesin Jahit', 'CS 5100HI,GoldenWheel', '3050206022', range(83, 92), 2013),

            // --- 4. MEBELAIR & FURNITUR ---
            ['nama' => 'Lemari Besi/Metal', 'merk' => 'Lemari Besi Penyimpanan', 'bmn' => '3050104001', 'nup' => 53, 'thn' => 2016],
            ['nama' => 'Lemari Kayu', 'merk' => '-', 'bmn' => '3050104002', 'nup' => 7, 'thn' => 1998],
            ['nama' => 'Lemari Kayu', 'merk' => '-', 'bmn' => '3050104002', 'nup' => 11, 'thn' => 1999],
            ['nama' => 'Filing Cabinet Kayu', 'merk' => '-', 'bmn' => '3050104006', 'nup' => 1, 'thn' => 1983],
            ['nama' => 'Buffet', 'merk' => '-', 'bmn' => '3050104013', 'nup' => 33, 'thn' => 1987],
            ['nama' => 'White Board', 'merk' => '-', 'bmn' => '3050105010', 'nup' => 21, 'thn' => 2010],
            ['nama' => 'Meja Komputer', 'merk' => 'GRACE', 'bmn' => '3050201009', 'nup' => 61, 'thn' => 2013],
            ['nama' => 'Meja Resepsionis', 'merk' => '-', 'bmn' => '3050201014', 'nup' => 3, 'thn' => 2009],

            // Meja Kerja Kayu
            ...$this->generateItems($idLab, 'Meja Kerja Kayu', '-', '3050201002', range(54, 58), 1996),
            ...$this->generateItems($idLab, 'Meja Kerja Kayu', '-', '3050201002', range(62, 65), 1997),
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 66, 'thn' => 1998],
            ...$this->generateItems($idLab, 'Meja Kerja Kayu', '-', '3050201002', [195, 197], 2013),
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 221, 'thn' => 2013],

            // Kursi
            ['nama' => 'Kursi Besi/Metal', 'merk' => 'CHITOSE', 'bmn' => '3050201003', 'nup' => 181, 'thn' => 2005],
            ...$this->generateItems($idLab, 'Kursi Besi/Metal', '-', '3050201003', [810, 811], 2010),
            ['nama' => 'Kursi Kayu', 'merk' => '-', 'bmn' => '3050201004', 'nup' => 367, 'thn' => 2011],
            ...$this->generateItems($idLab, 'Kursi Kayu', '-', '3050201004', range(434, 441), 2013),

            // --- 5. ELEKTRONIK & TIK ---
            ['nama' => 'A.C. Split', 'merk' => 'AC Split Standart 2PK Panasonic', 'bmn' => '3050204004', 'nup' => 134, 'thn' => 2024],
            ['nama' => 'Printer', 'merk' => 'CANON', 'bmn' => '3100203003', 'nup' => 45, 'thn' => 2010],
        ];

        foreach ($items as $item) {
            Barang::updateOrCreate(
                ['kode_bmn' => $item['bmn'] . '.' . $item['nup']],
                [
                    'id_lab' => $idLab,
                    'nama_barang' => $item['nama'],
                    'merk_tipe' => $item['merk'],
                    'kategori' => $this->getKategori($item['bmn']),
                    'tahun_perolehan' => $item['thn'],
                    'status_kondisi' => 'Baik',
                    'klasifikasi_fungsi' => 'Pendidikan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function generateItems($idLab, $nama, $merk, $bmn, $nups, $thn)
    {
        $res = [];
        foreach ($nups as $nup) {
            $res[] = ['nama' => $nama, 'merk' => $merk, 'bmn' => $bmn, 'nup' => $nup, 'thn' => $thn];
        }
        return $res;
    }

    private function getKategori($bmn)
    {
        if (str_starts_with($bmn, '303') || str_starts_with($bmn, '308') || str_starts_with($bmn, '3050206')) {
            return 'Alat Laboratorium';
        }
        if (str_starts_with($bmn, '3050204') || str_starts_with($bmn, '310')) {
            return 'Elektronik';
        }
        return 'Furnitur';
    }
}