<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangWorkshopBusanaSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Busana [ID 10]
        $idLab = 10;

        $barangs = [
            // --- MESIN JAHIT KULIT & INDUSTRI (Halaman 2, 3) ---
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL8300N', 'bmn' => '3030101016', 'nup' => 62, 'thn' => 2006],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL8300N', 'bmn' => '3030101016', 'nup' => 63, 'thn' => 2006],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL8100E', 'bmn' => '3030101016', 'nup' => 76, 'thn' => 2008],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL-8100E', 'bmn' => '3030101016', 'nup' => 115, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL-8100E', 'bmn' => '3030101016', 'nup' => 116, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DU 1181N', 'bmn' => '3030101016', 'nup' => 118, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DU 1181N', 'bmn' => '3030101016', 'nup' => 119, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL-8100E', 'bmn' => '3030101016', 'nup' => 121, 'thn' => 2013],
            ['nama' => 'Mesin Jahit Kulit', 'merk' => 'JUKI DDL8100E', 'bmn' => '3030101016', 'nup' => 122, 'thn' => 2013],
            
            // Mesin Jahit Golden Wheel (Halaman 2)
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI, GoldenWheel', 'bmn' => '3050206022', 'nup' => 75, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI, GoldenWheel', 'bmn' => '3050206022', 'nup' => 76, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI, GoldenWheel', 'bmn' => '3050206022', 'nup' => 77, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI, GoldenWheel', 'bmn' => '3050206022', 'nup' => 78, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI, GoldenWheel', 'bmn' => '3050206022', 'nup' => 79, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI, GoldenWheel', 'bmn' => '3050206022', 'nup' => 80, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI, GoldenWheel', 'bmn' => '3050206022', 'nup' => 81, 'thn' => 2013],
            ['nama' => 'Mesin Jahit', 'merk' => 'CS 5100HI, GoldenWheel', 'bmn' => '3050206022', 'nup' => 82, 'thn' => 2013],

            // Mesin Obras (Halaman 2)
            ['nama' => 'Mesin Obras', 'merk' => '-', 'bmn' => '3050206047', 'nup' => 1, 'thn' => 2005],
            ['nama' => 'Mesin Obras', 'merk' => 'YAMATO DC-1H', 'bmn' => '3050206047', 'nup' => 3, 'thn' => 2017],
            ['nama' => 'Mesin Obras', 'merk' => 'YAMATO DC-1H', 'bmn' => '3050206047', 'nup' => 4, 'thn' => 2017],
            ['nama' => 'Mesin Obras', 'merk' => 'YAMATO DC-1H', 'bmn' => '3050206047', 'nup' => 5, 'thn' => 2017],
            ['nama' => 'Mesin Obras', 'merk' => 'YAMATO DC-1H', 'bmn' => '3050206047', 'nup' => 6, 'thn' => 2017],

            // Peralatan Teknis Lainnya (Halaman 2)
            ['nama' => 'Alat Pelubang Mata Ayam', 'merk' => '-', 'bmn' => '3080138017', 'nup' => 3, 'thn' => 2006],
            ['nama' => 'Alat Pelubang Mata Ayam', 'merk' => '-', 'bmn' => '3080138017', 'nup' => 4, 'thn' => 2006],

            // --- MEBELAIR & RUANGAN (Halaman 2) ---
            ['nama' => 'Buffet', 'merk' => '-', 'bmn' => '3050104013', 'nup' => 20, 'thn' => 1990],
            ['nama' => 'Buffet', 'merk' => '-', 'bmn' => '3050104013', 'nup' => 40, 'thn' => 1999],
            ['nama' => 'Buffet', 'merk' => '-', 'bmn' => '3050104013', 'nup' => 42, 'thn' => 2002],
            ['nama' => 'Buffet', 'merk' => '-', 'bmn' => '3050104013', 'nup' => 43, 'thn' => 2002],
            ['nama' => 'Locker', 'merk' => 'BROTHER', 'bmn' => '3050104015', 'nup' => 25, 'thn' => 2011],
            ['nama' => 'Locker', 'merk' => 'BROTHER 6 Pintu', 'bmn' => '3050104015', 'nup' => 49, 'thn' => 2015],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 68, 'thn' => 2000],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 84, 'thn' => 2003],
            ['nama' => 'Meja Kerja Kayu', 'merk' => 'Kayu Jati Multiplek', 'bmn' => '3050201002', 'nup' => 244, 'thn' => 2015],
            ['nama' => 'Meja Komputer', 'merk' => 'GRACE', 'bmn' => '3050201009', 'nup' => 60, 'thn' => 2013],
            ['nama' => 'Meja Resepsionis', 'merk' => '-', 'bmn' => '3050201014', 'nup' => 1, 'thn' => 1999],
            ['nama' => 'Meja Setrika', 'merk' => 'Meja setrika workshop busana', 'bmn' => '3050201034', 'nup' => 1, 'thn' => 2024],
            ['nama' => 'Mesin Setrika Kulit', 'merk' => 'Philips EUH HD 1172', 'bmn' => '3080137002', 'nup' => 1, 'thn' => 2024],
            ['nama' => 'Mesin Setrika Kulit', 'merk' => 'Philips EUH HD 1172', 'bmn' => '3080137002', 'nup' => 2, 'thn' => 2024],

            // Meja Potong (Halaman 2)
            ['nama' => 'Meja Potong', 'merk' => '-', 'bmn' => '3050206050', 'nup' => 11, 'thn' => 2011],
            ['nama' => 'Meja Potong', 'merk' => '-', 'bmn' => '3050206050', 'nup' => 12, 'thn' => 2011],
            ['nama' => 'Meja Potong', 'merk' => '-', 'bmn' => '3050206050', 'nup' => 14, 'thn' => 2013],

            // --- ELEKTRONIK & TIK ---
            ['nama' => 'A.C. Split', 'merk' => 'AC Split Standart 2PK Panasonic', 'bmn' => '3050204004', 'nup' => 131, 'thn' => 2024],
            ['nama' => 'Printer', 'merk' => 'CANON', 'bmn' => '3100203003', 'nup' => 50, 'thn' => 2010],
            ['nama' => 'Printer', 'merk' => 'CANON E410', 'bmn' => '3100203003', 'nup' => 113, 'thn' => 2017],
        ];

        foreach ($barangs as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], $val['thn']);
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
                'kategori' => $this->getKat($bmn),
                'tahun_perolehan' => $thn,
                'status_kondisi' => 'Baik',
                'klasifikasi_fungsi' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function getKat($bmn)
    {
        if (str_starts_with($bmn, '303') || str_starts_with($bmn, '308')) return 'Alat Laboratorium';
        if (str_starts_with($bmn, '3050204') || str_starts_with($bmn, '310')) return 'Elektronik';
        return 'Furnitur';
    }
}