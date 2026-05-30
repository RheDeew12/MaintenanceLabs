<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\Barang;
use App\Models\Laboratorium;
use App\Models\Prodi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * FUNGSI HELPER: Filter maintenance otomatis berdasarkan Role.
     * UPDATE: Penambahan eager loading lab.prodi agar pengecekan unit "Umum" lancar.
     */
    private function getMaintenanceData()
    {
        $user = Auth::user();
        $query = MaintenanceRequest::with(['barang.lab', 'user', 'lab.prodi']);

        // Role-Based Access Control (RBAC)
        if ($user->role == 'Kaprodi') {
            $query->whereHas('lab', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            });
        }
        
        if ($user->role == 'Kepala Lab') {
            $query->where('id_lab', $user->lab_id);
        }

        return $query->latest()->paginate(10);
    }

    /**
     * FUNGSI HELPER: Ambil data semua aset dengan filter.
     */
    private function getTotalAssetsData(Request $request)
    {
        $query = Barang::with(['lab.prodi']);

        if ($request->filled('prodi_id')) {
            $query->whereHas('lab', function($q) use ($request) {
                $q->where('prodi_id', $request->prodi_id);
            });
        }

        if ($request->filled('status_kondisi')) {
            $query->where('status_kondisi', $request->status_kondisi);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_bmn', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(20)->withQueryString();
    }

    /**
     * DASHBOARD DEFAULT (Super Admin / Tim Pemelihara)
     */
    public function index()
    {
        $maintenances = $this->getMaintenanceData();
        $barangs = Barang::all(); 
        $labs = Laboratorium::all(); 
        return view('dashboard', compact('maintenances', 'barangs', 'labs'));
    }

    /**
     * DASHBOARD KEPALA LAB
     */
    public function KaLab()
    {
        $user = Auth::user();
        $maintenances = $this->getMaintenanceData();
        $barangs = Barang::where('id_lab', $user->lab_id)->get();
        $labs = Laboratorium::where('id', $user->lab_id)->get(); 
        return view('dashboard', compact('maintenances', 'barangs', 'labs'));
    }

    public function TimPemelihara()
    {
        return $this->index();
    }

    /**
     * DASHBOARD PEMBANTU DIREKTUR 1 (BIDANG AKADEMIK)
     */
    public function PembantuDirektur1(Request $request)
    {
        $menu = $request->route()->defaults['menu'] ?? 'index';

        switch ($menu) {
            case 'index':
                // UPDATE: Pudir 1 tidak boleh melihat ajuan dari unit "Umum" (Bypass)
                $approvalQueue = MaintenanceRequest::with(['barang.lab', 'user', 'lab.prodi'])
                                    ->where('status', 'pending_pudir1')
                                    ->whereHas('lab.prodi', function($q) {
                                        $q->where('nama_prodi', '!=', 'Umum');
                                    })
                                    ->latest()->paginate(10);
                
                return view('dashboard', [
                    'maintenances' => $approvalQueue,
                    'barangs' => Barang::all(),
                    'labs' => Laboratorium::all(),
                    'title' => 'Verifikasi Akademik (Pudir 1)'
                ]);
            
            case 'readiness':
                $readiness = Laboratorium::withCount([
                    'barangs as total_alat',
                    'barangs as alat_siap' => function($q) { 
                        $q->whereIn('status_kondisi', ['Normal', 'Baik']); 
                    }
                ])->get();
                return view('admin.pudir1.readiness', compact('readiness'));
            
            case 'high_impact':
                $highImpact = MaintenanceRequest::with(['barang.lab', 'user', 'lab'])
                    ->whereHas('barang', function($q) {
                        $q->where('kategori', 'Alat Laboratorium');
                    })
                    ->whereIn('status', ['repairing', 'checking_technical', 'pending_pudir1'])
                    ->paginate(10);
                return view('admin.pudir1.high_impact', compact('highImpact'));
            
            case 'calibration':
                $terkalibrasi = Barang::where('next_calibration', '>', now())->count();
                $expired = Barang::where('next_calibration', '<=', now())->count();
                $upcoming = Barang::with('lab')->whereBetween('next_calibration', [now(), now()->addDays(30)])->get();
                return view('admin.pudir1.calibration', compact('terkalibrasi', 'expired', 'upcoming'));
            
            case 'downtime':
                $downtime = MaintenanceRequest::with(['barang', 'lab'])->where('status', 'repairing')->orderBy('updated_at', 'asc')->paginate(10);
                return view('admin.pudir1.downtime', compact('downtime'));

            case 'total_assets':
                $assets = $this->getTotalAssetsData($request);
                $prodis = Prodi::all();
                return view('admin.pudir_shared.total_assets', compact('assets', 'prodis'));

            default:
                return redirect()->route('pudir1.index');
        }
    }

    /**
     * DASHBOARD PEMBANTU DIREKTUR 2 (BIDANG KEUANGAN & ASET)
     */
    public function PembantuDirektur2(Request $request)
    {
        $menu = $request->route()->defaults['menu'] ?? 'index';

        switch ($menu) {
            case 'index':
                $approvalQueue = MaintenanceRequest::where('status', 'pending_pudir2')->latest()->paginate(10);
                $totalRealisasi = MaintenanceRequest::where('status', 'closed')->sum('estimated_cost');
                return view('admin.pudir2.index', compact('approvalQueue', 'totalRealisasi'));

            case 'approval':
                $approvalQueue = MaintenanceRequest::with(['barang.lab', 'user', 'lab.prodi'])
                                    ->where('status', 'pending_pudir2')
                                    ->latest()
                                    ->paginate(10);

                // FIX: Menambahkan variabel history agar tidak error di Blade
                $history = MaintenanceRequest::with(['barang.lab', 'user', 'lab.prodi'])
                                    ->whereIn('status', ['repairing', 'waiting_verification', 'ready_to_close', 'closed', 'rejected'])
                                    // Kita hapus whereNotNull('pudir2_note') agar data lama tetap muncul meski tanpa catatan
                                    ->latest('updated_at')
                                    ->take(50)
                                    ->get();

                return view('admin.pudir2.approval', compact('approvalQueue', 'history'));

            case 'budget':
                $completedMaintenance = MaintenanceRequest::with(['barang.lab', 'user', 'lab'])
                                            ->whereIn('status', ['repairing', 'waiting_verification', 'closed'])
                                            ->whereNotNull('estimated_cost')->latest('updated_at')->get(); 
                return view('admin.pudir2.budget', compact('completedMaintenance'));

            case 'assets':
                $query = Barang::with('lab')->whereRaw('(YEAR(CURDATE()) - tahun_perolehan) > 10');

                if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        $q->where('nama_barang', 'like', "%{$search}%")
                          ->orWhere('kode_bmn', 'like', "%{$search}%");
                    });
                }

                if ($request->filled('lab_id')) {
                    $query->where('id_lab', $request->lab_id);
                }

                $sort = $request->sort_age == 'asc' ? 'asc' : 'desc';
                $assetHealth = $query->orderBy('tahun_perolehan', $sort)->get();
                $labs = Laboratorium::all(); 

                return view('admin.pudir2.assets', compact('assetHealth', 'labs'));
                
            case 'vendor':
                $vendorRepairs = MaintenanceRequest::with(['barang', 'lab'])->where('repair_type', 'External')->latest()->paginate(10);
                return view('admin.pudir2.vendor', compact('vendorRepairs'));

            case 'total_assets':
                $assets = $this->getTotalAssetsData($request);
                $prodis = Prodi::all();
                return view('admin.pudir_shared.total_assets', compact('assets', 'prodis'));

            default:
                return redirect()->route('pudir2.index');
        }
    }

    /**
     * FITUR SUPER ADMIN: Hapus Tiket & Reset Status Barang
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $req = MaintenanceRequest::with('barang')->findOrFail($id);
        
        if ($user->role !== 'Super Admin' && $req->status !== 'pending_kaprodi') {
            return back()->with('error', 'Hanya Super Admin yang dapat membatalkan tiket di tahap ini.');
        }
        
        return DB::transaction(function () use ($req) {
            if ($req->foto_kerusakan) {
                Storage::disk('public')->delete($req->foto_kerusakan);
            }

            if ($req->barang) {
                $req->barang->update(['status_kondisi' => 'Normal']);
            }

            $req->delete();
            return back()->with('success', 'Tiket maintenance berhasil dihapus.');
        });
    }
}