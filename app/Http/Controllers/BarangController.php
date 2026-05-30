<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang dengan filter otomatis sesuai role.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Logika Filtering Data Barang
        if ($user->role == 'Kepala Lab') {
            // Kepala Lab hanya melihat barang di unit/lab miliknya
            $barangs = Barang::with('lab')
                ->where('id_lab', $user->lab_id)
                ->orderBy('nama_barang', 'asc')
                ->get();
            
            // Hanya mengambil data lab miliknya untuk pilihan dropdown
            $labs = Laboratorium::where('id', $user->lab_id)->get();
        } else {
            // Super Admin & Role lain melihat semua barang dan semua unit
            $barangs = Barang::with('lab')
                ->orderBy('nama_barang', 'asc')
                ->get();
            $labs = Laboratorium::orderBy('nama_lab', 'asc')->get();
        }

        return view('barangs.index', compact('barangs', 'labs'));
    }

    /**
     * Menyimpan aset baru ke dalam unit laboratorium tertentu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'id_lab' => 'required|exists:laboratoriums,id',
            'kode_bmn' => 'required|unique:barangs,kode_bmn',
            'foto_identifikasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Otomatisasi id_lab jika diinput oleh Kepala Lab untuk keamanan data
        if (Auth::user()->role == 'Kepala Lab') {
            $data['id_lab'] = Auth::user()->lab_id;
        }

        // Logika Upload Foto
        if ($request->hasFile('foto_identifikasi')) {
            $file = $request->file('foto_identifikasi');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/barangs'), $nama_file);
            $data['foto_identifikasi'] = $nama_file;
        }

        Barang::create($data);
        return redirect()->back()->with('success', 'Alat baru berhasil ditambahkan ke unit kerja.');
    }

    /**
     * Memperbarui data aset dan mengelola file foto identifikasi.
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        $request->validate([
            'nama_barang' => 'required',
            'id_lab' => 'required|exists:laboratoriums,id',
            'kode_bmn' => 'required|unique:barangs,kode_bmn,' . $id,
            'foto_identifikasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Logika Update Foto (Hapus foto lama jika ada upload baru)
        if ($request->hasFile('foto_identifikasi')) {
            if ($barang->foto_identifikasi && File::exists(public_path('uploads/barangs/' . $barang->foto_identifikasi))) {
                File::delete(public_path('uploads/barangs/' . $barang->foto_identifikasi));
            }

            $file = $request->file('foto_identifikasi');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/barangs'), $nama_file);
            $data['foto_identifikasi'] = $nama_file;
        }

        $barang->update($data);

        return redirect()->back()->with('success', 'Data alat berhasil diperbarui.');
    }

    /**
     * Menghapus aset dan file fotonya secara permanen.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->foto_identifikasi && File::exists(public_path('uploads/barangs/' . $barang->foto_identifikasi))) {
            File::delete(public_path('uploads/barangs/' . $barang->foto_identifikasi));
        }

        $barang->delete();

        return redirect()->back()->with('success', 'Barang dan foto berhasil dihapus.');
    }
}