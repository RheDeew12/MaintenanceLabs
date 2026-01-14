<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\Equipment;
use App\Models\Laboratorium;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Fungsi helper untuk mengambil data maintenance dasar dengan paginasi.
     */
    private function getMaintenanceData()
    {
        return MaintenanceRequest::with(['equipment.lab', 'user'])
            ->latest()
            ->paginate(10);
    }

    /**
     * Dashboard General
     */
    public function index()
    {
        $maintenances = $this->getMaintenanceData();
        $equipments = Equipment::all(); 
        $labs = Laboratorium::all(); // Tambahkan lab untuk dropdown global
        
        return view('dashboard', compact('maintenances', 'equipments', 'labs'));
    }

    /**
     * Role: Super Admin
     */
    public function SuperAdmin()
    {
        return view('dashboard', [
            'maintenances' => $this->getMaintenanceData(),
            'equipments' => Equipment::all(),
            'labs' => Laboratorium::all()
        ]);
    }

    /**
     * Role: Kepala Lab
     */
    public function KaLab()
    {
        $maintenances = $this->getMaintenanceData();
        $equipments = Equipment::all();
        $labs = Laboratorium::all(); 

        return view('dashboard', compact('maintenances', 'equipments', 'labs'));
    }

    /**
     * Role: Tim Pemelihara
     */
    public function TimPemelihara()
    {
        return view('dashboard', [
            'maintenances' => $this->getMaintenanceData(),
            'equipments' => Equipment::all(),
            'labs' => Laboratorium::all()
        ]);
    }

    /**
     * Role: Ketua Program Studi (KaProdi)
     */
    public function KaProdi()
    {
        return redirect()->route('kaprodi.dashboard');
    }

   /**
 * Role: Pembantu Direktur 1 (PD1) - Analisis Kesiapan KBM
 */
public function PembantuDirektur1(Request $request)
{
    $menu = $request->route()->defaults['menu'] ?? 'index';

    // Data Global yang dibutuhkan hampir di semua menu PD1
    $labs = Laboratorium::all();

    switch ($menu) {
        case 'index':
            $approvalQueue = MaintenanceRequest::with(['equipment.lab', 'user'])
                                ->where('status', 'pending_pudir1')
                                ->latest()
                                ->paginate(10);
            return view('dashboard', [
                'maintenances' => $approvalQueue,
                'equipments' => Equipment::all(),
                'labs' => $labs,
                'title' => 'Antrean Persetujuan Pudir 1'
            ]);
        
        case 'readiness':
            $readiness = Laboratorium::withCount([
                'equipment as total_alat',
                'equipment as alat_siap' => function($query) {
                    $query->where('status_kondisi', 'Normal');
                }
            ])->get();
            return view('admin.pudir1.readiness', compact('readiness'));
        
        case 'high_impact': // Sesuaikan dengan defaults di route
            $highImpact = MaintenanceRequest::with(['equipment.lab', 'user'])
                ->whereHas('equipment', function($q) {
                    $q->where('klasifikasi_fungsi', 'Pendidikan');
                })
                ->whereIn('status', ['repairing', 'checking_technical'])
                ->paginate(10);

            // PERBAIKAN: Mengarah ke file high_impact.blade.php
            return view('admin.pudir1.high_impact', [
                'highImpact' => $highImpact,
                'title' => 'Prioritas Praktikum (Alat Pendidikan)'
            ]);
        
        case 'downtime':
            $maintenanceData = MaintenanceRequest::with(['equipment.lab', 'user'])
                ->whereIn('status', ['repairing', 'checking_technical'])
                ->latest()
                ->paginate(10);

            // PERBAIKAN: Mengarah ke file downtime.blade.php
            return view('admin.pudir1.downtime', [
                'downtime' => $maintenanceData,
                'title' => 'Analisis Downtime Pemeliharaan'
            ]);
        
        case 'calibration':
            $allEquipment = Equipment::all();
            
            // Logika Dinamis:
            // Terkalibrasi = Tanggal kalibrasi selanjutnya masih di masa depan
            // Kadaluarsa = Tanggal kalibrasi selanjutnya sudah terlewat
            $terkalibrasi = Equipment::where('next_calibration', '>', now())->count();
            $expired = Equipment::where('next_calibration', '<=', now())->count();
            
            // Ambil daftar alat yang mendekati masa expired (misal 30 hari lagi)
            $upcoming = Equipment::with('lab')
                        ->whereBetween('next_calibration', [now(), now()->addDays(30)])
                        ->get();

            return view('admin.pudir1.calibration', compact('terkalibrasi', 'expired', 'upcoming'));
        
        default:
            return redirect()->route('pudir1.index');
    }
}

/**
 * Role: Pembantu Direktur 2 (PD2) - Pengendalian Anggaran
 */
public function PembantuDirektur2(Request $request)
{
    $menu = $request->route()->defaults['menu'] ?? 'index';

    // 1. Antrean Persetujuan Anggaran (Dipakai di menu 'approval' dan 'index')
    $approvalQueue = MaintenanceRequest::with(['equipment.lab', 'user'])
        ->where('status', 'pending_pudir2') 
        ->latest()
        ->paginate(10);

    switch ($menu) {
        case 'approval':
            // PERBAIKAN: Mengarah ke view spesifik approval, bukan dashboard utama
            return view('admin.pudir2.approval', [
                'approvalQueue' => $approvalQueue,
                'title' => 'Antrean Persetujuan Anggaran (Pudir 2)'
            ]);

        case 'budget':
            $completedMaintenance = MaintenanceRequest::with(['equipment.lab', 'user'])
                ->whereIn('status', ['repairing', 'waiting_verification', 'ready_to_close', 'closed'])
                ->latest('updated_at')
                ->get(); 

            return view('admin.pudir2.budget', [
                'completedMaintenance' => $completedMaintenance,
                'title' => 'Laporan Realisasi Anggaran'
            ]);

        case 'assets':
            $assetHealth = Equipment::with('lab')       
                ->where('tahun_perolehan', '<', now()->year - 10)
                ->get();
            return view('admin.pudir2.assets', compact('assetHealth'));

        case 'vendor':
            // Ambil data yang dikerjakan oleh vendor (Pihak Luar)
            $vendorData = MaintenanceRequest::with(['equipment.lab', 'user'])
                ->whereIn('status', ['repairing', 'waiting_verification', 'ready_to_close', 'closed'])
                ->latest('updated_at')
                ->paginate(10);

            // PERBAIKAN: Mengarah ke view spesifik vendor
            return view('admin.pudir2.vendor', [
                'completedMaintenance' => $vendorData, 
                'title' => 'Analisis Performa Vendor'
            ]);

        case 'index':
        default:
            return view('admin.pudir2.index', [
                'approvalQueue' => $approvalQueue,
                'completedMaintenance' => MaintenanceRequest::whereIn('status', ['closed'])->get(),
                'title' => 'Dashboard Keuangan'
            ]);
    }
}
}