<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna dengan fitur pencarian dan paginasi.
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

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menyimpan pengguna baru ke database.
     * UPDATE: Menambahkan prodi_id otomatis jika tidak diisi.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'prodi_id' => 'nullable|integer' // Validasi opsional untuk prodi_id
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            // PERBAIKAN: Jika input prodi_id kosong, otomatis set ke 1
            'prodi_id' => $request->prodi_id ?? 1, 
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, $id) 
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'prodi_id' => 'nullable|integer'
        ]);

        // Gunakan request->all() atau sebutkan prodi_id agar bisa diperbarui
        $user->update($request->only(['name', 'email', 'role', 'prodi_id']));
        
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna (dengan proteksi diri sendiri).
     */
    public function destroy($id) 
    {
        $user = User::findOrFail($id);
        
        if ($user->is(Auth::user())) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}