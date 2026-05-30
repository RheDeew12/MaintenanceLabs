<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium; 
use App\Models\Prodi;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        // Ambil data langsung dari tabel laboratoriums
        $units = Laboratorium::with('prodi')->orderBy('prodi_id', 'asc')->get();
        
        // Ambil data prodi untuk dropdown di modal tambah
        $prodis = Prodi::all();

        return view('units.index', compact('units', 'prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prodi_id' => 'required|integer',
            'nama_lab' => 'required|string|max:255'
        ]);

        // Simpan langsung ke tabel laboratoriums
        Laboratorium::create([
            'prodi_id' => $request->prodi_id,
            'nama_lab' => $request->nama_lab,
        ]);

        return redirect()->route('units.index')->with('success', 'Data Laboratorium berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prodi_id' => 'required|integer',
            'nama_lab' => 'required|string|max:255'
        ]);

        $lab = Laboratorium::findOrFail($id);
        $lab->update($request->all());

        return redirect()->route('units.index')->with('success', 'Data Laboratorium berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lab = Laboratorium::findOrFail($id);
        $lab->delete();

        return redirect()->route('units.index')->with('success', 'Data Laboratorium berhasil dihapus.');
    }
}