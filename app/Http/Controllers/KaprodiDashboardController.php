<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium;
use App\Models\MaintenanceRequest;
use App\Models\Barang; // Import model Barang baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaprodiDashboardController extends Controller
{
    /**
     * DASHBOARD KAPRODI (Update Unit Management & Master Barang)
     */
    public function index(Request $request) 
    {
        $user = Auth::user();
        $prodiId = $user->prodi_id;

        // Validasi akses: Memastikan user memiliki prodi_id
        if (!$prodiId) {
            return redirect()->back()->with('error', 'Akun Anda tidak terhubung dengan Program Studi manapun.');
        }

        /**
         * REVISI BASE QUERY:
         * Menggunakan relasi 'lab' secara langsung dari MaintenanceRequest.
         * Ini akan memfilter data sesuai prodi TPK, TPPK, atau TPKP.
         */
        $baseQuery = MaintenanceRequest::whereHas('lab', function($query) use ($prodiId) {
            $query->where('prodi_id', $prodiId);
        });

        // Filter tambahan jika user memilih Unit/Lab spesifik
        if ($request->filled('lab_id')) {
            $baseQuery->where('id_lab', $request->lab_id);
        }

        /**
         * HITUNG KPI (Sesuai alur persetujuan terbaru)
         * Menggunakan clone agar query dasar tidak terganggu.
         */
        $stats = [
            'totalPengajuan'   => (clone $baseQuery)->count(),
            'menungguVerifikasi' => (clone $baseQuery)->where('status', 'pending_kaprodi')->count(),
            'sedangDikerjakan' => (clone $baseQuery)->where('status', 'repairing')->count(),
            'selesai'          => (clone $baseQuery)->where('status', 'closed')->count(),
        ];

        /**
         * DATA TABEL RIWAYAT:
         * Menggunakan eager loading 'barang' (Master Barang) dan 'lab' (Lokasi Unit).
         */
        $maintenances = $baseQuery->with(['barang', 'lab', 'user'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Ambil daftar unit kerja (17 Laboratorium/Workshop) sesuai Prodi Kaprodi
        $labs = Laboratorium::where('prodi_id', $prodiId)
            ->orderBy('nama_lab', 'asc')
            ->get();

        return view('dashboard.kaprodi', array_merge($stats, [
            'maintenances' => $maintenances,
            'labs' => $labs
        ]));
    }
}