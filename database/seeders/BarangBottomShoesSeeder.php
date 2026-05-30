<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangBottomShoesSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Alas Kaki / Bawahan Sepatu [ID 9]
        $idLab = 9;

        $barangs = [
            // --- MESIN PRODUKSI & PERALATAN TEKNIS (Halaman 1, 2, 4) ---
            ['nama' => 'Mesin Jahit (Cangklong)', 'merk' => 'GOLDEN WHEEL CS-810', 'bmn' => '3030101017', 'nup' => '2', 'thn' => 2004],
            ['nama' => 'Mesin Pengepres Kulit', 'merk' => 'Mesin Stamoing/EmbosManual', 'bmn' => '3030210999', 'nup' => '32', 'thn' => 2013],
            ['nama' => 'Peralatan Tukang Kulit Lainnya (Cutting Dies)', 'merk' => 'Cutting Dies', 'bmn' => '3030210999', 'nup' => '33', 'thn' => 2021],
            ['nama' => 'Peralatan Tukang Kulit Lainnya (Cutting Dies)', 'merk' => 'Cutting Dies', 'bmn' => '3030210999', 'nup' => '34', 'thn' => 2021],
            ['nama' => 'Peralatan Tukang Kulit Lainnya (Cutting Dies)', 'merk' => 'Cutting Dies', 'bmn' => '3030210999', 'nup' => '35', 'thn' => 2021],
            ['nama' => 'Oven (Alat Laboratorium Umum)', 'merk' => 'NEW SEAZEN', 'bmn' => '3080111005', 'nup' => '5', 'thn' => 2009],
            ['nama' => 'Mesin Molding Vulkanisasi', 'merk' => '-', 'bmn' => '3080137009', 'nup' => '1', 'thn' => 2005],
            ['nama' => 'Mesin Pengaktif Lem', 'merk' => '-', 'bmn' => '3080137013', 'nup' => '1', 'thn' => 2005],
            ['nama' => 'Hydrolic Oven Camant Lasting', 'merk' => 'YIN HONG', 'bmn' => '3080137018', 'nup' => '1', 'thn' => 2003],
            ['nama' => 'Hydrolic Oven Camant Lasting', 'merk' => 'HWACHANG', 'bmn' => '3080137018', 'nup' => '2', 'thn' => 2004],
            ['nama' => 'Mesin Split', 'merk' => 'TATECH', 'bmn' => '3080137019', 'nup' => '1', 'thn' => 2004],
            ['nama' => 'Mesin Potong Kulit', 'merk' => 'F-45', 'bmn' => '3080137021', 'nup' => '1', 'thn' => 2004],
            ['nama' => 'Mesin Potong Kulit', 'merk' => '(MESIN POTONG MANUAL)', 'bmn' => '3080137021', 'nup' => '4', 'thn' => 2017],
            ['nama' => 'Mesin Pemanas', 'merk' => 'TF-EF 156 A', 'bmn' => '3080137022', 'nup' => '1', 'thn' => 2004],
            ['nama' => 'Alat Press Sol Listrik', 'merk' => 'SP12', 'bmn' => '3080137024', 'nup' => '1', 'thn' => 1995],
            ['nama' => 'Alat Press Sol Listrik', 'merk' => 'IKIP', 'bmn' => '3080137024', 'nup' => '2', 'thn' => 1995],
            ['nama' => 'Alat Press Sol Listrik', 'merk' => 'DH16/95 SYSTEEM', 'bmn' => '3080137024', 'nup' => '3', 'thn' => 1997],
            ['nama' => 'Mesin Press Sol', 'merk' => 'Mesin Press Sepatu,LZ605,LI', 'bmn' => '3080137033', 'nup' => '1', 'thn' => 2013],
            ['nama' => 'Mesin Press Sol', 'merk' => 'Mesin Press Sepatu,LZ605,LI', 'bmn' => '3080137033', 'nup' => '2', 'thn' => 2013],
            ['nama' => 'Mesin Open Sepatu', 'merk' => 'Mesin Oven Sepatu,CUSTOM,LI', 'bmn' => '3080137042', 'nup' => '2', 'thn' => 2013],
            ['nama' => 'Leather Finishing Machine', 'merk' => 'LeatherIroningMachine,LZ280', 'bmn' => '3080137045', 'nup' => '2', 'thn' => 2013],
            ['nama' => 'Hydrolic Ironing Embossing Press', 'merk' => 'TATECH 77', 'bmn' => '3080137046', 'nup' => '1', 'thn' => 2004],
            ['nama' => 'Mesin Grending Acuan', 'merk' => 'Msn PngkasarGrinding,CUSTOM', 'bmn' => '3080137062', 'nup' => '1', 'thn' => 2013],
            ['nama' => 'Mesin Grending Acuan', 'merk' => 'Msn PngkasarGrinding,CUSTOM', 'bmn' => '3080137062', 'nup' => '2', 'thn' => 2013],
            ['nama' => 'Alat Pelubang Mata Ayam', 'merk' => 'TF-TI 77', 'bmn' => '3080138017', 'nup' => '1', 'thn' => 2004],
            ['nama' => 'Alat Pelubang Mata Ayam', 'merk' => '-', 'bmn' => '3080138017', 'nup' => '5', 'thn' => 2006],
            ['nama' => 'Alat Pelubang Mata Ayam', 'merk' => '-', 'bmn' => '3080138017', 'nup' => '6', 'thn' => 2006],
            ['nama' => 'Brushing Machine', 'merk' => 'TYPE:RCLX-318', 'bmn' => '3170124003', 'nup' => '1', 'thn' => 2006],

            // --- MEBELAIR & PERALATAN RUANGAN (Halaman 1, 2, 3, 4) ---
            ['nama' => 'Lemari Kayu', 'merk' => '-', 'bmn' => '3050104002', 'nup' => '9', 'thn' => 1998],
            ['nama' => 'Lemari Kayu', 'merk' => '-', 'bmn' => '3050104002', 'nup' => '10', 'thn' => 1998],
            ['nama' => 'Rak Kayu', 'merk' => 'Kayu Jati 119x48x152', 'bmn' => '3050104004', 'nup' => '16', 'thn' => 2015],
            ['nama' => 'Filing Cabinet Besi', 'merk' => 'DAICHI', 'bmn' => '3050104005', 'nup' => '14', 'thn' => 1981],
            ['nama' => 'Buffet', 'merk' => '-', 'bmn' => '3050104013', 'nup' => '18', 'thn' => 1985],
            ['nama' => 'Locker', 'merk' => 'DATAFILE', 'bmn' => '3050104015', 'nup' => '16', 'thn' => 2007],
            ['nama' => 'Locker', 'merk' => 'BROTHER', 'bmn' => '3050104015', 'nup' => '22', 'thn' => 2009],
            ['nama' => 'Locker', 'merk' => 'BROTHER', 'bmn' => '3050104015', 'nup' => '23', 'thn' => 2009],
            ['nama' => 'Locker', 'merk' => 'BROTHER', 'bmn' => '3050104015', 'nup' => '24', 'thn' => 2009],
            ['nama' => 'White Board', 'merk' => '-', 'bmn' => '3050105010', 'nup' => '36', 'thn' => 2012],
            ['nama' => 'Kursi Besi/Metal', 'merk' => 'CHITOSE', 'bmn' => '3050201003', 'nup' => '328', 'thn' => 2005],
            
            // Kipas Angin REGENCY (NUP 61, 62, 63)
            ['nama' => 'Kipas Angin', 'merk' => 'Kipas Angin Tornado Wall Fan 18" REGENCY TW', 'bmn' => '3050204006', 'nup' => '61', 'thn' => 2025],
            ['nama' => 'Kipas Angin', 'merk' => 'Kipas Angin Tornado Wall Fan 18" REGENCY TW', 'bmn' => '3050204006', 'nup' => '62', 'thn' => 2025],
            ['nama' => 'Kipas Angin', 'merk' => 'Kipas Angin Tornado Wall Fan 18" REGENCY TW', 'bmn' => '3050204006', 'nup' => '63', 'thn' => 2025],
        ];

        foreach ($barangs as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], 'Alat Laboratorium', $val['thn']);
        }

        // --- DATA MASSAL MEJA KERJA KAYU (NUP 170-172, 216-217) ---
        foreach ([170, 171, 172, 216, 217] as $nup) {
            $this->saveBarang($idLab, 'Meja Kerja Kayu', '-', '3050201002', $nup, 'Furnitur', 2013);
        }

        // --- DATA MASSAL KURSI KAYU / PRAKTEK (NUP 489 s/d 516) ---
        for ($nup = 489; $nup <= 516; $nup++) {
            if ($nup == 504) continue; // NUP 504 tidak ada di PDF
            $merk = in_array($nup, [500, 503, 506, 507, 508, 509, 510, 511, 512, 513, 514, 515, 516]) ? 'Kursi Praktek' : '-';
            $this->saveBarang($idLab, 'Kursi Kayu', $merk, '3050201004', $nup, 'Furnitur', 2015);
        }

        // --- DATA MASSAL MEJA PRAKTEK (Halaman 2: NUP 8-39 Campuran) ---
        foreach ([8, 9, 34, 35, 36, 37, 38, 39] as $nup) {
            $this->saveBarang($idLab, 'Meja Kerja (Alat Laboratorium Lainnya)', 'Meja Praktek', '3080156081', $nup, 'Alat Laboratorium', 2013);
        }
    }

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