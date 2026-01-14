@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h5 class="fw-bold mb-0"><i class="bi bi-people-fill me-2 text-primary"></i>Manajemen Pengguna</h5>
        <small class="text-muted">Kelola hak akses pengguna sistem pemeliharaan</small>
    </div>
    
    <div class="d-flex flex-column flex-sm-row gap-2">
        <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-0" 
                       placeholder="Cari nama atau email..." value="{{ request('search') }}" style="width: 200px;">
                <button type="submit" class="btn btn-white border-0 bg-white text-primary fw-bold">Cari</button>
            </div>
            @if(request('search'))
                <a href="{{ route('users.index') }}" class="btn btn-light rounded-pill shadow-sm"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>

        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah User
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="card p-4 shadow-sm border-0 rounded-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="bg-light">
                <tr class="text-muted small">
                    <th>NAMA PENGGUNA</th>
                    <th>EMAIL</th>
                    <th>ROLE / HAK AKSES</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                        <small class="text-muted">ID: #{{ $user->id }}</small>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill small">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-light border rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}">
                            <i class="bi bi-pencil-square text-warning"></i> Edit
                        </button>
                        
                        @if(Auth::id() != $user->id)
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light border rounded-pill px-3" onclick="return confirm('Hapus user ini?')">
                                <i class="bi bi-trash3 text-danger"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>

                {{-- MODAL EDIT USER (Ditempatkan di dalam loop agar ID sesuai) --}}
                <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header bg-warning text-dark border-0">
                                    <h5 class="modal-title fw-bold">Edit Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control bg-light border-0" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Email</label>
                                        <input type="email" name="email" class="form-control bg-light border-0" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                                        <input type="password" name="password" class="form-control bg-light border-0">
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label small fw-bold">Role / Jabatan</label>
                                        <select name="role" class="form-select bg-light border-0" required>
                                            <option value="Super Admin" {{ $user->role == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="Kepala Lab" {{ $user->role == 'Kepala Lab' ? 'selected' : '' }}>Kepala Lab</option>
                                            <option value="Tim Pemelihara" {{ $user->role == 'Tim Pemelihara' ? 'selected' : '' }}>Tim Pemelihara</option>
                                            <option value="Kaprodi" {{ $user->role == 'Kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0">
                                    <button type="submit" class="btn btn-warning w-100 py-2 rounded-3 fw-bold">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-search fs-1 d-block mb-3 opacity-25"></i>
                        Data pengguna tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->appends(['search' => request('search')])->links() }}
    </div>
</div>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Role / Jabatan</label>
                        <select name="role" class="form-select bg-light border-0" required>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Kepala Lab">Kepala Lab</option>
                            <option value="Tim Pemelihara">Tim Pemelihara</option>
                            <option value="Kaprodi">Kaprodi</option>
                            <option value="Pembantu Direktur 1">Pembantu Direktur 1</option>
                            <option value="Pembantu Direktur 2">Pembantu Direktur 2</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection