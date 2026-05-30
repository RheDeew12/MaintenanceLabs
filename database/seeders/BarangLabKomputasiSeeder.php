<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangLabKomputasiSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Lab Komputasi [ID 13]
        $idLab = 14;

        // --- 1. PERANGKAT IT & TIK (Halaman 3, 6, 12) ---

        // PC Unit DELL INSPIRON 3670 (NUP 171-174)
        for ($nup = 171; $nup <= 174; $nup++) {
            $this->saveBarang($idLab, 'P.C Unit', 'DELL PC INSPIRON 3670', '3100102001', $nup, 'Elektronik', 2019);
        }

        // PC Unit LENOVO Core I5 (NUP 187-191)
        for ($nup = 187; $nup <= 191; $nup++) {
            $this->saveBarang($idLab, 'P.C Unit', 'LENOVO Core I5 4GB DDR3', '3100102001', $nup, 'Elektronik', 2015);
        }

        // PC Unit LENOVO Core I3 (NUP Campuran sesuai PDF)
        $nupLenovoI3 = [74, 78, 80, 81, 82, 83, 84, 89, 90, 91, 92];
        foreach ($nupLenovoI3 as $nup) {
            $this->saveBarang($idLab, 'P.C Unit', 'LENOVO Core I3', '3100102001', $nup, 'Elektronik', 2011);
        }

        // PC Unit LENOVO (NUP 95, 96, 107, 113, 121, 124)
        foreach ([95, 96] as $nup) $this->saveBarang($idLab, 'P.C Unit', 'LENOVO', '3100102001', $nup, 'Elektronik', 2011);
        foreach ([107, 113, 121, 124] as $nup) $this->saveBarang($idLab, 'P.C Unit', 'LENOVO', '3100102001', $nup, 'Elektronik', 2012);

        // PC Unit COMPAQ (NUP 71)
        $this->saveBarang($idLab, 'P.C Unit', 'COMPAQ 3321D', '3100102001', 71, 'Elektronik', 2011);

        // Wireless IP Camera / Webcam Logitech (NUP 1-7)
        for ($nup = 1; $nup <= 7; $nup++) {
            $this->saveBarang($idLab, 'Wireless IP Camera', 'Logitech C270 HD Webcam 720P', '3100204038', $nup, 'Elektronik', 2025);
        }

        // --- 2. MEBELAIR & FURNITUR (Halaman 4, 5, 10, 11) ---

        // Kursi Besi/Metal CHITOSE (NUP 1100-1129)
        for ($nup = 1100; $nup <= 1129; $nup++) {
            if ($nup == 1105) continue; // NUP 1105 tidak ada di daftar PDF
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', 2012);
        }

        // Meja Komputer (NUP 80-94) & Meja Pembimbing (NUP 95)
        for ($nup = 80; $nup <= 94; $nup++) {
            $this->saveBarang($idLab, 'Meja Komputer', 'Meja Komputer', '3050201009', $nup, 'Furnitur', 2020);
        }
        $this->saveBarang($idLab, 'Meja Komputer', 'Meja Pembimbing Komputer', '3050201009', 95, 'Furnitur', 2020);

        // Kursi Fiber DONATI & Indachi
        $this->saveBarang($idLab, 'Kursi Fiber Glas/Plastik', 'DONATI', '3050201020', 55, 'Furnitur', 2018);
        $this->saveBarang($idLab, 'Kursi Fiber Glas/Plastik', 'indachi fabric biru', '3050201020', 114, 'Furnitur', 2022);

        // Papan Gambar / Glassboard
        $this->saveBarang($idLab, 'Papan Gambar', 'Glassboard 200*120', '3050105061', 17, 'Furnitur', 2020);

        // --- 3. ELEKTRONIK & INTERIOR (Halaman 5, 6, 11, 12) ---

        // A.C. Split Panasonic (NUP 122-123)
        foreach ([122, 123] as $nup) {
            $this->saveBarang($idLab, 'A.C. Split', 'Panasonic', '3050204004', $nup, 'Elektronik', 2019);
        }

        // Sun Screen / Tirai Gulung (NUP 1-21)
        for ($nup = 1; $nup <= 21; $nup++) {
            $this->saveBarang($idLab, 'Sun Screen', 'Tirai Gulung', '3050206062', $nup, 'Lainnya', 2020);
        }

        // Vinyl Flooring (NUP 4-35)
        for ($nup = 4; $nup <= 35; $nup++) {
            $this->saveBarang($idLab, 'Alat Rumah Tangga Lainnya', 'Vinyl Flooring', '3050299999', $nup, 'Lainnya', 2020);
        }

        // Panel Dinding
        $this->saveBarang($idLab, 'Alat Rumah Tangga Lainnya', 'Panel Dinding Belakang Lab Komputer Kampus 1', '3050299999', 38, 'Lainnya', 2020);
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