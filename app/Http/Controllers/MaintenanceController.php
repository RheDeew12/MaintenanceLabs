<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Barang; 
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    /**
     * Menampilkan daftar transaksi perbaikan dengan FILTER OTOMATIS BERDASARKAN ROLE.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $search = $request->input('search');

        $query = MaintenanceRequest::with(['barang.lab', 'user', 'lab.prodi']);

        // 1. FILTERING KEAMANAN DATA (RBAC)
        if ($user->role == 'Kepala Lab') {
            $query->where('id_lab', $user->lab_id);
        } elseif ($user->role == 'Kaprodi') {
            $query->whereHas('lab', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            });
        }

        // 2. FITUR PENCARIAN (Global Search)
        $query->when($search, function ($q) use ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('issue_description', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('barang', function ($b) use ($search) {
                        $b->where('nama_barang', 'like', "%{$search}%")
                          ->orWhere('kode_bmn', 'like', "%{$search}%");
                    });
            });
        });

        $maintenances = $query->latest()->paginate(10)->withQueryString();

        $barangs = ($user->role == 'Kepala Lab') 
            ? Barang::where('id_lab', $user->lab_id)->get() 
            : Barang::all();
            
        $labs = Laboratorium::all();

        return view('dashboard', compact('maintenances', 'barangs', 'labs'));
    }

    /**
     * MENYIMPAN PENGAJUAN BARU (STORE)
     */
    public function store(Request $request) 
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'issue_description' => 'required|string|min:10',
            'damage_level' => 'required|in:Ringan,Sedang,Berat',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        return DB::transaction(function () use ($request, $user) {
            $barang = Barang::findOrFail($request->barang_id);
            
            $fotoKerusakan = null;
            if ($request->hasFile('foto_kerusakan')) {
                $fotoKerusakan = $request->file('foto_kerusakan')->store('assets/maintenance/issues', 'public');
            }

            $maintenance = MaintenanceRequest::create([
                'user_id' => $user->id,
                'barang_id' => $request->barang_id,
                'id_lab' => $user->lab_id, 
                'issue_description' => $request->issue_description,
                'damage_level' => $request->damage_level,
                'status' => 'pending_kaprodi',
                'request_date' => now(),
                'foto_kerusakan' => $fotoKerusakan 
            ]);

            $barang->update(['status_kondisi' => 'Perlu Perbaikan']);

            $maintenance->load('lab');
            $namaLab = $maintenance->lab?->nama_lab ?? 'Unit Kerja';
            
            return redirect()->route('dashboard')->with('success', "Pengajuan berhasil dikirim untuk unit {$namaLab}");
        });
    }

    /**
     * TAHAP 1: Persetujuan KaProdi / Admin Rumah Tangga
     */
    public function approveKaprodi($id) 
    {
        $currentUser = Auth::user();
        $req = MaintenanceRequest::with(['barang', 'lab.prodi'])->where('status', 'pending_kaprodi')->findOrFail($id);
        
        if ($req->lab?->prodi?->nama_prodi == 'Umum' || $currentUser->email == 'rumahtangga@politeknikatk.ac.id') {
            $nextStatus = 'checking_technical'; 
            $msg = 'Disetujui Admin Rumah Tangga. Meneruskan ke Tim Teknis (Skip Pudir 1).';
        } else {
            // Perbaikan Logika: Jika barang bukan Alat Lab (misal: Furniture/AC), skip Pudir 1
            if ($req->barang->kategori == 'Alat Laboratorium') {
                $nextStatus = 'pending_pudir1'; 
                $msg = 'Disetujui Kaprodi. Menunggu persetujuan Pudir 1 (Akademik).';
            } else {
                $nextStatus = 'checking_technical'; 
                $msg = 'Disetujui Kaprodi. Meneruskan ke Tim Teknis (Skip Pudir 1).';
            }
        }

        $req->update(['status' => $nextStatus]);
        return redirect()->route('dashboard')->with('success', $msg);
    }

    /**
     * TAHAP 2: Persetujuan Pudir 1 (Akademik)
     */
    public function approvePudir1($id) 
    {
        $req = MaintenanceRequest::where('status', 'pending_pudir1')->findOrFail($id);
        $req->update(['status' => 'checking_technical']);
        return redirect()->route('dashboard')->with('success', 'Disetujui Pudir 1. Menunggu pengecekan teknis.');
    }

    /**
     * TAHAP 3: Update Rekomendasi Teknis (Tim Pemelihara)
     */
    public function updateTechnical(Request $request, $id) 
    {
        $request->validate([
            'recommendation' => 'required|string',
            'type' => 'required|in:Internal,External',
            'cost' => 'required|numeric|min:0'
        ]);

        $req = MaintenanceRequest::where('status', 'checking_technical')->findOrFail($id);
        
        $req->update([
            'technical_recommendation' => $request->recommendation,
            'repair_type' => $request->type, 
            'estimated_cost' => $request->cost,
            'status' => 'pending_pudir2' 
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Rekomendasi teknis diperbarui. Menunggu persetujuan anggaran (Pudir 2).');
    }

    /**
     * TAHAP 4: Persetujuan Pudir 2 (Keuangan/Anggaran)
     */
    public function approvePudir2(Request $request, $id) 
    {
        $req = MaintenanceRequest::where('status', 'pending_pudir2')->findOrFail($id);
        
        // PENTING: Pastikan catatan tidak NULL agar muncul di query Riwayat (whereNotNull)
        $req->update([
            'status' => 'repairing',
            'pudir2_note' => $request->approval_note ?? 'Anggaran disetujui sesuai estimasi.',
            'approved_at_pudir2' => now(),
        ]); 
        
        return redirect()->route('dashboard')->with('success', 'Anggaran disetujui. Proses perbaikan dimulai.');
    }

    /**
     * FITUR PENOLAKAN (REJECT) OLEH PUDIR 2
     */
    public function reject(Request $request, $id)
    {
        $request->validate(['note' => 'required|string']);

        $req = MaintenanceRequest::with('barang')->where('status', 'pending_pudir2')->findOrFail($id);
        
        return DB::transaction(function () use ($req, $request) {
            $req->update([
                'status' => 'rejected',
                'pudir2_note' => $request->note,
                'rejected_at' => now()
            ]);

            if ($req->barang) {
                // Kembalikan status ke Normal jika ditolak
                $req->barang->update(['status_kondisi' => 'Normal']);
            }

            return redirect()->route('dashboard')->with('success', 'Pengajuan anggaran telah ditolak.');
        });
    }

    /**
     * TAHAP 5 - 7: Penyelesaian, Verifikasi & Closing
     */
    public function finishWork($id) 
    {
        $req = MaintenanceRequest::where('status', 'repairing')->findOrFail($id);
        $req->update(['status' => 'waiting_verification']);
        return redirect()->route('dashboard')->with('success', 'Pekerjaan selesai. Menunggu verifikasi unit.');
    }

    public function verifyWork($id) 
    {
        $req = MaintenanceRequest::where('status', 'waiting_verification')->findOrFail($id);
        $req->update(['status' => 'ready_to_close']);
        return redirect()->route('dashboard')->with('success', 'Hasil perbaikan terverifikasi.');
    }

    public function closeTicket($id) 
    {
        $req = MaintenanceRequest::with('barang')->where('status', 'ready_to_close')->findOrFail($id);
        
        return DB::transaction(function () use ($req) {
            $req->update(['status' => 'closed']);
            $req->barang->update(['status_kondisi' => 'Normal']);
            
            return redirect()->route('dashboard')->with('success', 'Tiket ditutup. Kondisi aset kembali Normal.');
        });
    }

    /**
     * MENGHAPUS / CANCEL PENGAJUAN
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $req = MaintenanceRequest::with('barang')->findOrFail($id);
        
        // Proteksi: Super Admin bisa hapus semua, User biasa hanya bisa cancel jika masih pending awal
        if ($user->role !== 'Super Admin' && $req->status !== 'pending_kaprodi') {
            return back()->with('error', 'Anda tidak memiliki otoritas untuk membatalkan tiket di tahap ini.');
        }
        
        return DB::transaction(function () use ($req) {
            if ($req->foto_kerusakan && Storage::disk('public')->exists($req->foto_kerusakan)) {
                Storage::disk('public')->delete($req->foto_kerusakan);
            }

            if ($req->barang) {
                $req->barang->update(['status_kondisi' => 'Normal']);
            }

            $req->delete();
            return back()->with('success', 'Tiket berhasil dihapus/dibatalkan.');
        });
    }

    public function print($id)
    {
        $item = MaintenanceRequest::with(['barang.lab', 'user', 'lab'])->findOrFail($id);
        return view('admin.maintenance.print', compact('item'));
    }
}