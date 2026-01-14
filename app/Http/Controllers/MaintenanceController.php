<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Equipment;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    /**
     * Menampilkan daftar transaksi perbaikan dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $maintenances = MaintenanceRequest::with(['equipment.lab', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('issue_description', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhereHas('equipment', function ($eq) use ($search) {
                          $eq->where('nama_alat', 'like', "%{$search}%")
                            ->orWhere('kode_aset', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $equipments = Equipment::all();
        $labs = Laboratorium::all();

        return view('dashboard', compact('maintenances', 'equipments', 'labs'));
    }

    /**
     * MENYIMPAN PENGAJUAN BARU (STORE)
     */
    public function store(Request $request) 
    {
        // 1. Validasi Utama
        $request->validate([
            'equipment_id' => 'required',
            'id_lab' => 'required|exists:laboratoriums,id',
            'issue_description' => 'required|string|min:10',
            'damage_level' => 'required|in:Ringan,Sedang,Berat',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        return DB::transaction(function () use ($request) {
            $equipment_id = null;

            // 2. Logika Alat Manual (Alat Baru)
            if ($request->equipment_id === 'manual') {
                $request->validate([
                    'manual_name' => 'required|string|max:255',
                    'manual_code' => 'required|string|unique:equipment,kode_aset',
                    'manual_merk' => 'required|string',
                    'id_kategori' => 'required',
                    'klasifikasi_fungsi' => 'required|in:Pendidikan,Non-Pendidikan', // Validasi klasifikasi
                    'tahun_perolehan' => 'required|digits:4|integer|min:1900|max:'.date('Y'),
                    'foto_alat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                ]);

                $fotoPath = $request->hasFile('foto_alat') 
                    ? $request->file('foto_alat')->store('assets/alat', 'public') 
                    : null;

                $equipment = Equipment::create([
                    'nama_alat' => $request->manual_name,
                    'kode_aset' => $request->manual_code,
                    'merk' => $request->manual_merk,
                    'id_kategori' => $request->id_kategori,
                    'klasifikasi_fungsi' => $request->klasifikasi_fungsi,
                    'tahun_perolehan' => $request->tahun_perolehan,
                    'status_kondisi' => 'Rusak Ringan',
                    'id_lab' => $request->id_lab,
                    'foto_alat' => $fotoPath
                ]);
                $equipment_id = $equipment->id;
            } else {
                $equipment_id = $request->equipment_id;
                
                // Update lokasi fisik alat di master data
                Equipment::findOrFail($equipment_id)->update([
                    'status_kondisi' => 'Rusak Ringan',
                    'id_lab' => $request->id_lab
                ]);
            }

            $fotoKerusakan = $request->hasFile('foto_kerusakan') 
                ? $request->file('foto_kerusakan')->store('assets/maintenance/issues', 'public') 
                : null;

            // 3. Simpan Request Maintenance
            MaintenanceRequest::create([
                'user_id' => Auth::id(),
                'equipment_id' => $equipment_id,
                'id_lab' => $request->id_lab,
                'issue_description' => $request->issue_description,
                'damage_level' => $request->damage_level,
                'status' => 'pending_kaprodi',
                'request_date' => now(),
                'foto_kerusakan' => $fotoKerusakan 
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Pengajuan berhasil dikirim.');
        });
    }

    /**
     * Alur Persetujuan Bertingkat (Lengkap Tanpa Dikurangi)
     */
    public function approveKaprodi($id) 
    {
        $req = MaintenanceRequest::where('status', 'pending_kaprodi')->findOrFail($id);
        $req->update(['status' => 'pending_pudir1']);
        return redirect()->route('dashboard')->with('success', 'Disetujui Kaprodi. Menunggu Pudir 1.');
    }

    public function approvePudir1($id) 
    {
        $req = MaintenanceRequest::where('status', 'pending_pudir1')->findOrFail($id);
        $req->update(['status' => 'checking_technical']);
        return redirect()->route('dashboard')->with('success', 'Disetujui Pudir 1. Menunggu pengecekan teknis.');
    }

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
        
        return redirect()->route('dashboard')->with('success', 'Rekomendasi teknis diperbarui.');
    }

    public function approvePudir2($id) 
    {
        return DB::transaction(function () use ($id) {
            $req = MaintenanceRequest::where('status', 'pending_pudir2')->findOrFail($id);
            $req->update(['status' => 'repairing']); 
            
            if ($req->equipment) {
                $req->equipment->update(['status_kondisi' => 'Perbaikan']); 
            }
            return redirect()->route('dashboard')->with('success', 'Anggaran disetujui. Proses perbaikan dimulai.');
        });
    }

    public function finishWork($id) 
    {
        $req = MaintenanceRequest::where('status', 'repairing')->findOrFail($id);
        $req->update(['status' => 'waiting_verification']);
        return redirect()->route('dashboard')->with('success', 'Pekerjaan selesai. Menunggu verifikasi.');
    }

    public function verifyWork($id) 
    {
        $req = MaintenanceRequest::where('status', 'waiting_verification')->findOrFail($id);
        $req->update(['status' => 'ready_to_close']);
        return redirect()->route('dashboard')->with('success', 'Terverifikasi. Siap ditutup tiketnya.');
    }

    public function closeTicket($id) 
    {
        return DB::transaction(function () use ($id) {
            $req = MaintenanceRequest::where('status', 'ready_to_close')->findOrFail($id);
            $req->update(['status' => 'closed']);
            
            if ($req->equipment) {
                $req->equipment->update(['status_kondisi' => 'Normal']);
            }
            return redirect()->route('dashboard')->with('success', 'Tiket ditutup. Alat kembali Normal.');
        });
    }

    public function destroy($id)
    {
        $req = MaintenanceRequest::findOrFail($id);
        if ($req->status !== 'pending_kaprodi') {
            return back()->with('error', 'Hanya pengajuan awal yang bisa dihapus.');
        }
        
        return DB::transaction(function () use ($req) {
            if ($req->foto_kerusakan) {
                Storage::disk('public')->delete($req->foto_kerusakan);
            }
            if ($req->equipment) {
                $req->equipment->update(['status_kondisi' => 'Normal']);
            }
            $req->delete();
            return back()->with('success', 'Pengajuan dihapus.');
        });
    }

    public function print($id)
    {
        $item = MaintenanceRequest::with(['equipment.lab', 'user'])->findOrFail($id);
        return view('admin.maintenance.print', compact('item'));
    }
}