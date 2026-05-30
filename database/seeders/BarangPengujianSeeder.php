<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangPengujianSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi seluruh barang ke Workshop Pengujian (ID 15)
        $idLabPengujian = 15; 

        $barangs = [
            // --- PERALATAN MESIN & IT (Hal 1-2, 4, 14-16) ---
            ['nama' => 'Mesin Bor', 'merk' => 'custom', 'bmn' => '3030101005', 'nup' => '28', 'kat' => 'Alat Laboratorium', 'thn' => 2022],
            ['nama' => 'A.C. Split', 'merk' => 'Panasonic CS/CU-PN18WKJ', 'bmn' => '3050204004', 'nup' => '118', 'kat' => 'Elektronik', 'thn' => 2019],
            ['nama' => 'A.C. Split', 'merk' => 'Panasonic CS/CU-PN18WKJ', 'bmn' => '3050204004', 'nup' => '136', 'kat' => 'Elektronik', 'thn' => 2024],
            ['nama' => 'Timbangan Elektronik', 'merk' => 'QUATRO TYPE MAC. 15KG', 'bmn' => '3080101009', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2017],
            ['nama' => 'Timbangan Elektronik', 'merk' => 'OHAUS PR224/E', 'bmn' => '3080101009', 'nup' => '5', 'kat' => 'Alat Laboratorium', 'thn' => 2024],

            // --- INSTRUMEN PENGUJIAN FISIS (Hal 4, 6, 14-16) ---
            ['nama' => 'Alat Penguji Kekerasan (Hardness Tester)', 'merk' => 'Shore D Durometer', 'bmn' => '3080110035', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2017],
            ['nama' => 'Alat Penguji Kekerasan (Hardness Tester)', 'merk' => 'Shore D Durometer', 'bmn' => '3080110035', 'nup' => '2', 'kat' => 'Alat Laboratorium', 'thn' => 2017],
            ['nama' => 'Thickness Tester For Metal', 'merk' => 'Das 0,1 mm', 'bmn' => '3080110068', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2007],
            ['nama' => 'Dry Oven', 'merk' => 'drying oven custom', 'bmn' => '3080111100', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2022],
            ['nama' => 'Alat Pengukur Tebal', 'merk' => 'Thickness Gauge Mitutoyo 547-301', 'bmn' => '308011107', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2024],
            ['nama' => 'Ticknes Tester', 'merk' => 'Schopper', 'bmn' => '3080132001', 'nup' => '2', 'kat' => 'Alat Laboratorium', 'thn' => 2017],
            ['nama' => 'Ticknes Tester', 'merk' => 'Schopper', 'bmn' => '3080132001', 'nup' => '3', 'kat' => 'Alat Laboratorium', 'thn' => 2017],
            ['nama' => 'Flammeability Tester', 'merk' => '45 Degree Automatic GT-C32 GESTER', 'bmn' => '3080135049', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2005],
            ['nama' => 'Mesin Potong Kulit', 'merk' => 'GESTER Press Manual', 'bmn' => '3080137021', 'nup' => '5', 'kat' => 'Alat Laboratorium', 'thn' => 2005],
            ['nama' => 'Tensile Strength Tester', 'merk' => 'Universal Testing JTM UTC20Kn', 'bmn' => '3080138001', 'nup' => '3', 'kat' => 'Alat Laboratorium', 'thn' => 2017],
            ['nama' => 'Deal Tickness Gauge', 'merk' => 'Das 0,1 mm', 'bmn' => '3080138029', 'nup' => '5', 'kat' => 'Alat Laboratorium', 'thn' => 2024],
            ['nama' => 'Weather Station', 'merk' => 'Wireless HP3001 Misol', 'bmn' => '3080138031', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2013],
            ['nama' => 'Alat Laboratorium Uji Kulit/Karet/Plastik', 'merk' => 'Softness Tester ST300', 'bmn' => '3080138999', 'nup' => '9', 'kat' => 'Alat Laboratorium', 'thn' => 2013],
            ['nama' => 'Abration Tester', 'merk' => 'GT-KB03 GESTER CHINA', 'bmn' => '3080156999', 'nup' => '25', 'kat' => 'Alat Laboratorium', 'thn' => 2013],
            ['nama' => 'Temperature Tester', 'merk' => 'Leather Shrinkage GT-KC23 GESTER', 'bmn' => '3080805001', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2017],

            // --- FURNITUR & MEBELAIR (Hal 1, 3-5, 15-16) ---
            ['nama' => 'Lemari Besi/Metal', 'merk' => 'BROTHER B 304', 'bmn' => '3050104001', 'nup' => '46', 'kat' => 'Furnitur', 'thn' => 2015],
            ['nama' => 'Lemari Kayu', 'merk' => 'kayu jati 6 tingkat', 'bmn' => '3050104002', 'nup' => '41', 'kat' => 'Furnitur', 'thn' => 2022],
            ['nama' => 'Meja Kerja Kayu', 'merk' => 'MEJA DOSEN', 'bmn' => '3050201002', 'nup' => '292', 'kat' => 'Furnitur', 'thn' => 2016],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '2 laci', 'bmn' => '3050201002', 'nup' => '366', 'kat' => 'Furnitur', 'thn' => 2022],
            ['nama' => 'Kursi Fiber Glas/Plastik', 'merk' => 'indachi fabric biru', 'bmn' => '3050201020', 'nup' => '103', 'kat' => 'Furnitur', 'thn' => 2022],
        ];

        foreach ($barangs as $val) {
            $kodeUnik = $val['bmn'] . '.' . $val['nup'];

            Barang::updateOrCreate(
                ['kode_bmn' => $kodeUnik], 
                [
                    'id_lab' => $idLabPengujian,
                    'nama_barang' => $val['nama'],
                    'merk_tipe' => $val['merk'],
                    'kategori' => $val['kat'],
                    'tahun_perolehan' => $val['thn'],
                    'status_kondisi' => 'Baik', 
                    'klasifikasi_fungsi' => 'Pendidikan',
                ]
            );
        }

        // --- SEEDING KURSI BESI/METAL CHITOSE NUP 352-461 (Hal 1, 3, 15) ---
        $nupChitose = [352, 353, 417, 459, 460, 461];
        foreach ($nupChitose as $nup) {
            Barang::updateOrCreate(
                ['kode_bmn' => '3050201003.' . $nup],
                [
                    'id_lab' => $idLabPengujian,
                    'nama_barang' => 'Kursi Besi/Metal',
                    'merk_tipe' => 'CHITOSE',
                    'kategori' => 'Furnitur',
                    'tahun_perolehan' => 2013,
                    'status_kondisi' => 'Baik',
                    'klasifikasi_fungsi' => 'Pendidikan',
                ]
            );
        }

        // --- SEEDING KURSI KAYU PRAKTEK NUP 739-766 (Hal 1-2, 3-4, 15-16) ---
        for ($nup = 739; $nup <= 766; $nup++) {
            Barang::updateOrCreate(
                ['kode_bmn' => '3050201004.' . $nup],
                [
                    'id_lab' => $idLabPengujian,
                    'nama_barang' => 'Kursi Kayu',
                    'merk_tipe' => 'Kursi Praktek',
                    'kategori' => 'Furnitur',
                    'tahun_perolehan' => 2015,
                    'status_kondisi' => 'Baik',
                    'klasifikasi_fungsi' => 'Pendidikan',
                ]
            );
        }

        // --- SEEDING MEJA PRAKTEK (ALAT LAB LAINNYA) NUP 7-66 (Hal 2, 4, 8) ---
        $nupMeja = [7, 30, 31, 32, 33, 65, 66];
        foreach ($nupMeja as $nup) {
            Barang::updateOrCreate(
                ['kode_bmn' => '3080156081.' . $nup],
                [
                    'id_lab' => $idLabPengujian,
                    'nama_barang' => 'Meja Kerja (Alat Laboratorium Lainnya)',
                    'merk_tipe' => ($nup >= 65) ? 'Meja Praktik Fisis' : 'Meja Praktek',
                    'kategori' => 'Alat Laboratorium',
                    'tahun_perolehan' => 2015,
                    'status_kondisi' => 'Baik',
                    'klasifikasi_fungsi' => 'Pendidikan',
                ]
            );
        }
    }
}