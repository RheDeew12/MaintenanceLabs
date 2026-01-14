<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Laboratorium;
use App\Models\MaintenanceRequest;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * DASHBOARD UTAMA KAPRODI
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Filter prodi_id melalui relasi equipment -> lab
        $query = MaintenanceRequest::whereHas('equipment.lab', function($q) use ($user) {
            $q->where('prodi_id', $user->prodi_id);
        });

        // Filter berdasarkan Lab jika dipilih
        if ($request->filled('lab_id')) {
            $query->whereHas('equipment', function($q) use ($request) {
                $q->where('id_lab', $request->lab_id); 
            });
        }

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan Range Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Statistik KPI: Menyesuaikan dengan workflow status terbaru Anda
        $stats = [
            'total'       => (clone $query)->count(),
            'pending'     => (clone $query)->where('status', 'pending_kaprodi')->count(),
            'on_progress' => (clone $query)->whereIn('status', ['repairing', 'checking_technical', 'pending_pudir2'])->count(),
            'closed'      => (clone $query)->where('status', 'closed')->count(),
        ];

        $labs = Laboratorium::where('prodi_id', $user->prodi_id)->get();

        // Eager loading lab dan kategori untuk performa dashboard
        $requests = $query->with(['equipment.lab', 'equipment.kategori', 'user'])->latest()->paginate(10);

        return view('kaprodi.dashboard', compact('stats', 'labs', 'requests'));
    }

    /**
     * INVENTORY ALAT PER PRODI
     */
    public function inventory()
    {
        $user = Auth::user();
        $equipment = Equipment::whereHas('lab', function($q) use ($user) {
            $q->where('prodi_id', $user->prodi_id);
        })->with(['lab', 'kategori'])->get();
            
        return view('kaprodi.inventory', compact('equipment'));
    }

    /**
     * LAPORAN BIAYA (REVISI: Mendeteksi biaya setelah disetujui Pudir 2)
     */
    public function costReport()
    {
        $user = Auth::user();
        
        // Status yang dianggap biayanya sudah "Realisasi" atau "Disetujui Anggarannya"
        $validStatuses = ['repairing', 'waiting_verification', 'ready_to_close', 'closed'];

        // 1. Total Biaya Realisasi (Berdasarkan anggaran yang sudah disetujui Pudir 2 keatas)
        $totalBiaya = MaintenanceRequest::whereHas('equipment.lab', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            })
            ->whereIn('status', $validStatuses)
            ->sum('estimated_cost');

        // 2. Biaya Per Lab (Data untuk Sidebar/Informasi tambahan)
        $biayaPerLab = MaintenanceRequest::whereIn('maintenance_requests.status', $validStatuses)
            ->join('equipment', 'maintenance_requests.equipment_id', '=', 'equipment.id')
            ->join('laboratoriums', 'equipment.id_lab', '=', 'laboratoriums.id')
            ->where('laboratoriums.prodi_id', $user->prodi_id)
            ->select('laboratoriums.nama_lab as lab_name', DB::raw('SUM(maintenance_requests.estimated_cost) as total'))
            ->groupBy('laboratoriums.nama_lab')
            ->get();

        // 3. Data Chart (Dinamis 6 Bulan Terakhir)
        $monthlyTotals = [];
        $monthLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->translatedFormat('M');

            $total = MaintenanceRequest::whereHas('equipment.lab', function($q) use ($user) {
                    $q->where('prodi_id', $user->prodi_id);
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
     * MONITORING KALIBRASI / KONDISI ALAT
     */
    public function calibration()
    {
        $user = Auth::user();
        
        $needs_calibration = Equipment::whereHas('lab', function($q) use ($user) {
            $q->where('prodi_id', $user->prodi_id);
        })
        ->with(['lab', 'kategori'])
        ->get();

        return view('kaprodi.calibration', compact('needs_calibration'));
    }

    /**
     * RIWAYAT SERVIS PER ALAT
     */
    public function equipmentHistory($id)
    {
        // Mencari alat dan memuat riwayat maintenance berserta user yang mengajukan
        $item = Equipment::with(['lab', 'kategori', 'maintenanceRequests.user' => function($q) {
            $q->latest();
        }])->findOrFail($id);

        return view('kaprodi.equipment_history', compact('item'));
    }
}