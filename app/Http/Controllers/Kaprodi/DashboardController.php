<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Laboratorium;
use App\Models\MaintenanceRequest;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * DASHBOARD UTAMA KAPRODI & ADMIN RUMAH TANGGA
     * UPDATE: Penambahan logika pemisahan View untuk Unit Umum.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $prodi_id = $user->prodi_id;
        
        // 1. Ambil pilihan Lab KHUSUS untuk Prodi ini (Untuk Dropdown Filter)
        $laboratoriums = Laboratorium::where('prodi_id', $prodi_id)
            ->orderBy('nama_lab', 'asc')
            ->get();

        // 2. Query untuk Daftar Request Pemeliharaan (Maintenance Requests)
        $query = MaintenanceRequest::with(['barang', 'lab.prodi', 'user'])
            ->whereHas('lab', function($q) use ($prodi_id) {
                $q->where('prodi_id', $prodi_id);
            });

        // Terapkan Filter Pencarian/Dropdown
        if ($request->filled('lab_id')) {
            $query->where('id_lab', $request->lab_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(), 
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        // 3. Statistik Terintegrasi (Sinkronisasi Maintenance & Inventory)
        $stats = [
            // Statistik Alur Kerja (Maintenance Flow)
            'total'          => (clone $query)->count(),
            'pending'        => (clone $query)->where('status', 'pending_kaprodi')->count(),
            'on_progress'    => (clone $query)->whereIn('status', ['repairing', 'checking_technical', 'pending_pudir2'])->count(),
            'closed'         => (clone $query)->where('status', 'closed')->count(),

            // Statistik Kesehatan Aset (Inventory Condition - Sinkronisasi Normal/Baik)
            'alat_siap' => Barang::whereHas('lab', function($q) use ($prodi_id) {
                            $q->where('prodi_id', $prodi_id);
                        })->whereIn('status_kondisi', ['Baik', 'Normal'])->count(),
            
            'alat_rusak' => Barang::whereHas('lab', function($q) use ($prodi_id) {
                            $q->where('prodi_id', $prodi_id);
                        })->whereIn('status_kondisi', ['Rusak', 'Rusak Ringan', 'Rusak Berat'])->count(),
            
            'perlu_perbaikan' => Barang::whereHas('lab', function($q) use ($prodi_id) {
                            $q->where('prodi_id', $prodi_id);
                        })->where('status_kondisi', 'Perlu Perbaikan')->count(),
        ];

        // 4. Ambil data alat untuk kebutuhan modal/search di view
        $barangs = Barang::whereHas('lab', function($q) use ($prodi_id) {
            $q->where('prodi_id', $prodi_id);
        })->orderBy('nama_barang', 'asc')->get();

        $requests = $query->latest()->paginate(10)->withQueryString();

        // --- UPDATE: LOGIKA PEMISAH VIEW ---
        // Jika user adalah Admin Rumah Tangga (Unit Umum), arahkan ke view khusus
        if ($user->email == 'rumahtangga@politeknikatk.ac.id' || ($user->prodi && $user->prodi->nama_prodi == 'Umum')) {
            return view('admin.rumahtangga.dashboard', compact('stats', 'laboratoriums', 'requests', 'barangs'));
        }

        // Default ke View Kaprodi
        return view('kaprodi.dashboard', compact('stats', 'laboratoriums', 'requests', 'barangs'));
    }

    /**
     * INVENTORY ALAT PER PRODI (Master Data)
     */
    public function inventory()
    {
        $user = Auth::user();
        
        $equipment = Barang::whereHas('lab', function($q) use ($user) {
            $q->where('prodi_id', $user->prodi_id);
        })->with(['lab'])->orderBy('nama_barang', 'asc')->get();
            
        return view('kaprodi.inventory', compact('equipment'));
    }

    /**
     * MONITORING JADWAL KALIBRASI
     */
    public function calibration()
    {
        $user = Auth::user();
        
        $needs_calibration = Barang::whereHas('lab', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            })
            ->whereNotNull('next_calibration')
            ->orderBy('next_calibration', 'asc')
            ->get();

        return view('kaprodi.calibration', compact('needs_calibration'));
    }

    /**
     * LAPORAN BIAYA (Analitik Keuangan Maintenance)
     */
    public function costReport()
    {
        $user = Auth::user();
        $prodi_id = $user->prodi_id;
        $validStatuses = ['repairing', 'waiting_verification', 'ready_to_close', 'closed'];

        $totalBiaya = MaintenanceRequest::whereHas('lab', function($q) use ($prodi_id) {
                $q->where('prodi_id', $prodi_id);
            })
            ->whereIn('status', $validStatuses)
            ->sum('estimated_cost');

        $biayaPerLab = MaintenanceRequest::whereIn('maintenance_requests.status', $validStatuses)
            ->join('laboratoriums', 'maintenance_requests.id_lab', '=', 'laboratoriums.id')
            ->where('laboratoriums.prodi_id', $prodi_id)
            ->select('laboratoriums.nama_lab as lab_name', DB::raw('SUM(maintenance_requests.estimated_cost) as total'))
            ->groupBy('laboratoriums.nama_lab', 'laboratoriums.id')
            ->get();

        $monthlyTotals = [];
        $monthLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->translatedFormat('F');

            $total = MaintenanceRequest::whereHas('lab', function($q) use ($prodi_id) {
                    $q->where('prodi_id', $prodi_id);
                })
                ->whereIn('status', $validStatuses)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('estimated_cost');

            $monthlyTotals[] = $total;
        }

        return view('kaprodi.cost_report', [
            'totalBiaya' => $totalBiaya,
            'biayaPerLab' => $biayaPerLab,
            'monthlyTotals' => $monthlyTotals,
            'monthLabels' => $monthLabels
        ]);
    }

    /**
     * RIWAYAT SERVIS PER ALAT (Detailed History)
     */
    public function equipmentHistory($id)
    {
        $item = Barang::with(['maintenanceRequests' => function($q) {
            $q->with(['lab', 'user'])->latest();
        }])->findOrFail($id);

        return view('kaprodi.equipment_history', compact('item'));
    }
}