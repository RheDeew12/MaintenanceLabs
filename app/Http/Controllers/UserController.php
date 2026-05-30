<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi; 
use App\Models\Laboratorium; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna dengan data pendukung dari tabel laboratoriums.
     */
    public function index(Request $request) 
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10);

        // Ambil data pendukung langsung dari tabel laboratoriums
        $laboratoriums = Laboratorium::all(); 
        $prodis = Prodi::all(); 

        return view('admin.users.index', compact('users', 'laboratoriums', 'prodis'));
    }

    /**
     * Menyimpan pengguna baru.
     * UPDATE: Penambahan logika pencarian prodi_id otomatis untuk Kepala Lab.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            // Validasi prodi_id wajib jika Kaprodi, lab_id wajib jika Kepala Lab
            'prodi_id' => $request->role === 'Kaprodi' ? 'required|integer' : 'nullable',
            'lab_id' => $request->role === 'Kepala Lab' ? 'required|integer' : 'nullable'
        ]);

        $prodi_id = $request->prodi_id;

        // FIX: Jika role adalah Kepala Lab, ambil prodi_id dari relasi Laboratoriumnya
        if ($request->role === 'Kepala Lab' && $request->filled('lab_id')) {
            $lab = Laboratorium::find($request->lab_id);
            if ($lab) {
                $prodi_id = $lab->prodi_id;
            }
        }

        // Fallback untuk role yang tidak terikat prodi spesifik agar tidak NULL (misal Super Admin)
        if (is_null($prodi_id)) {
            $prodi_id = 1; // Sesuaikan dengan ID default prodi di DB Anda
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'prodi_id' => $prodi_id,
            'lab_id' => $request->role === 'Kepala Lab' ? $request->lab_id : null, 
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Memperbarui data pengguna.
     * UPDATE: Penambahan sinkronisasi prodi_id saat update lab_id.
     */
    public function update(Request $request, $id) 
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'prodi_id' => $request->role === 'Kaprodi' ? 'required' : 'nullable',
        ]);

        $updateData = $request->only(['name', 'email', 'role']);

        // Logika penentuan Lab dan Prodi untuk menghindari error NULL pada database
        if ($request->role === 'Kepala Lab') {
            $updateData['lab_id'] = $request->lab_id;
            
            // FIX: Sinkronkan kembali prodi_id jika lab diubah
            $lab = Laboratorium::find($request->lab_id);
            $updateData['prodi_id'] = $lab ? $lab->prodi_id : ($request->prodi_id ?? $user->prodi_id);
            
        } elseif ($request->role === 'Kaprodi') {
            $updateData['prodi_id'] = $request->prodi_id;
            $updateData['lab_id'] = null;
        } else {
            // Untuk Super Admin, Pudir, dll (tetap jaga agar prodi_id tidak NULL)
            $updateData['lab_id'] = null;
            $updateData['prodi_id'] = $request->prodi_id ?? $user->prodi_id ?? 1;
        }

        $user->update($updateData);
        
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy($id) 
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}