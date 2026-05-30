<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangJahitSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Jahit [ID 11]
        $idLab = 11;

        $barangs = [
            // --- MESIN JAHIT INDUSTRI (Halaman 1 & 2) ---
            // JUKI DDL-8100 e (NUP 95 - 102) - Tahun 2012
            ...$this->generateRange($idLab, 'Mesin Jahit Kulit', 'JUKI DDL-8100 e', '3030101016', 95, 102, 2012),
            
            // JUKI DDL-8700L (NUP 103 - 112) - Tahun 2012
            ...$this->generateRange($idLab, 'Mesin Jahit Kulit', 'JUKI DDL-8700L', '3030101016', 103, 112, 2012),
            
            // JUKI DDL-8100E / DU (NUP 113, 114, 117, 120) - Tahun 2013
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL-8100E', 'bmn' => '3030101016', 'nup' => 113, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL-8100E', 'bmn' => '3030101016', 'nup' => 114, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL-8100E', 'bmn' => '3030101016', 'nup' => 117, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DU 1181N', 'bmn' => '3030101016', 'nup' => 120, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'KINGS HC810', 'bmn' => '3030101016', 'nup' => 125, 'thn' => 2013],

            // Golden Wheel CS 5100HI (NUP 51, 52, 53) - Tahun 2013
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI,GoldenWheel', 'bmn' => '3050206022', 'nup' => 51, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI,GoldenWheel', 'bmn' => '3050206022', 'nup' => 52, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI,GoldenWheel', 'bmn' => '3050206022', 'nup' => 53, 'thn' => 2013],

            // --- MESIN SESER & PERALATAN LAIN ---
            ['nama' => 'Mesin Seser', 'merk' => 'LEOPARD TB 801', 'bmn' => '3080137015', 'nup' => 4, 'thn' => 2004],
            ['nama' => 'Mesin Seser', 'merk' => 'M.SESET,CS747,GoldenWheel', 'bmn' => '3080137015', 'nup' => 13, 'thn' => 2013],
            ['nama' => 'Papan Gambar', 'merk' => 'PAPAN TULIS KACA', 'bmn' => '3050105061', 'nup' => 8, 'thn' => 2016],

            // --- MEBELAIR (MEJA & KURSI) ---
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 222, 'thn' => 2013],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 223, 'thn' => 2013],
            ['nama' => 'Meja Kerja', 'merk' => 'Meja Praktek', 'bmn' => '3080156081', 'nup' => 21, 'thn' => 2015],
            ['nama' => 'Meja Kerja', 'merk' => 'Meja Praktek', 'bmn' => '3080156081', 'nup' => 22, 'thn' => 2015],
            
            ['nama' => 'Kursi Besi/Metal', 'merk' => 'CHITOSE', 'bmn' => '3050201003', 'nup' => 161, 'thn' => 2005],
            ['nama' => 'Kursi Besi/Metal', 'merk' => 'CHITOSE', 'bmn' => '3050201003', 'nup' => 163, 'thn' => 2005],
            ['nama' => 'Kursi Besi/Metal', 'merk' => '-', 'bmn' => '3050201003', 'nup' => 812, 'thn' => 2010],
            ['nama' => 'Kursi Besi/Metal', 'merk' => '-', 'bmn' => '3050201003', 'nup' => 813, 'thn' => 2010],
            ['nama' => 'Kursi Fiber Glas/Plastik', 'merk' => 'INDASHI D 235', 'bmn' => '3050201020', 'nup' => 40, 'thn' => 2015],

            // Kursi Kayu (NUP 442 - 473) - Tahun 2013
            ...$this->generateRange($idLab, 'Kursi Kayu', '-', '3050201004', 442, 463, 2013),
            ...$this->generateRange($idLab, 'Kursi Kayu', '-', '3050201004', 466, 473, 2013),

            // --- ELEKTRONIK ---
            ['nama' => 'Kipas Angin', 'merk' => 'Cosmos Wall Fan 160WFO', 'bmn' => '3050204006', 'nup' => 55, 'thn' => 2024],
            ['nama' => 'Kipas Angin', 'merk' => 'Cosmos Wall Fan 160WFO', 'bmn' => '3050204006', 'nup' => 56, 'thn' => 2024],
            ['nama' => 'Exhause Fan', 'merk' => 'Exhaust Fan Panasonic TGU 25', 'bmn' => '3050204007', 'nup' => 21, 'thn' => 2023],
            ['nama' => 'Exhause Fan', 'merk' => 'Exhaust Fan Panasonic TGU 25', 'bmn' => '3050204007', 'nup' => 22, 'thn' => 2023],
        ];

        foreach ($barangs as $val) {
            Barang::updateOrCreate(
                ['kode_bmn' => $val['bmn'] . '.' . $val['nup']],
                [
                    'id_lab' => $idLab,
                    'nama_barang' => $val['nama'],
                    'merk_tipe' => $val['merk'],
                    'kategori' => $this->getKat($val['bmn']),
                    'tahun_perolehan' => $val['thn'],
                    'status_kondisi' => 'Baik',
                    'klasifikasi_fungsi' => 'Pendidikan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function generateRange($idLab, $nama, $merk, $bmn, $start, $end, $thn)
    {
        $items = [];
        for ($i = $start; $i <= $end; $i++) {
            $items[] = ['nama' => $nama, 'merk' => $merk, 'bmn' => $bmn, 'nup' => $i, 'thn' => $thn];
        }
        return $items;
    }

    private function getKat($bmn)
    {
        if (str_starts_with($bmn, '303') || str_starts_with($bmn, '308')) return 'Alat Laboratorium';
        if (str_starts_with($bmn, '3050204')) return 'Elektronik';
        return 'Furnitur';
    }
}