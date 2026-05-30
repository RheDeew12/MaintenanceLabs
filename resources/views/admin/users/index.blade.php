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
                    <th>UNIT / PRODI</th>
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
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill small text-uppercase">
                            {{-- UPDATE: Tampilan Label Khusus Admin Rumah Tangga --}}
                            @if($user->email == 'rumahtangga@politeknikatk.ac.id')
                                Admin Rumah Tangga
                            @else
                                {{ $user->role }}
                            @endif
                        </span>
                    </td>
                    <td>
                        @if($user->role == 'Kepala Lab')
                            <small class="text-muted d-block">Lab:</small>
                            <span class="fw-medium text-dark">{{ $user->laboratorium->nama_lab ?? '-' }}</span>
                        @elseif($user->role == 'Kaprodi')
                            {{-- UPDATE: Pembeda Label Prodi/Umum --}}
                            <small class="text-muted d-block">{{ $user->prodi?->nama_prodi == 'Umum' ? 'Unit Kerja:' : 'Prodi:' }}</small>
                            <span class="fw-medium text-dark">{{ $user->prodi->nama_prodi ?? '-' }}</span>
                        @else
                            <span class="text-muted italic small">-</span>
                        @endif
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

                {{-- MODAL EDIT USER --}}
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
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Role / Jabatan</label>
                                        <select name="role" class="form-select bg-light border-0 role-select-edit" data-id="{{ $user->id }}" required>
                                            <option value="Super Admin" {{ $user->role == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="Kepala Lab" {{ $user->role == 'Kepala Lab' ? 'selected' : '' }}>Kepala Lab</option>
                                            <option value="Tim Pemelihara" {{ $user->role == 'Tim Pemelihara' ? 'selected' : '' }}>Tim Pemelihara</option>
                                            <option value="Kaprodi" {{ $user->role == 'Kaprodi' ? 'selected' : '' }}>Kaprodi / Admin Rumah Tangga</option>
                                            <option value="Pembantu Direktur 1" {{ $user->role == 'Pembantu Direktur 1' ? 'selected' : '' }}>Pembantu Direktur 1</option>
                                            <option value="Pembantu Direktur 2" {{ $user->role == 'Pembantu Direktur 2' ? 'selected' : '' }}>Pembantu Direktur 2</option>
                                        </select>
                                    </div>

                                    {{-- Section Lab (Edit) --}}
                                    <div id="sectionLabEdit{{ $user->id }}" class="mb-3 {{ $user->role == 'Kepala Lab' ? '' : 'd-none' }}">
                                        <label class="form-label small fw-bold text-primary">Nama Lab / Workshop</label>
                                        <select name="lab_id" class="form-select border-primary-subtle bg-light">
                                            <option value="">-- Pilih Lab/Workshop --</option>
                                            @foreach($laboratoriums as $lab)
                                                <option value="{{ $lab->id }}" {{ $user->lab_id == $lab->id ? 'selected' : '' }}>{{ $lab->nama_lab }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Section Prodi (Edit) --}}
                                    <div id="sectionProdiEdit{{ $user->id }}" class="mb-3 {{ $user->role == 'Kaprodi' ? '' : 'd-none' }}">
                                        <label class="form-label small fw-bold text-primary">Nama Prodi / Unit Kerja</label>
                                        <select name="prodi_id" class="form-select border-primary-subtle bg-light">
                                            <option value="">-- Pilih Prodi/Unit --</option>
                                            @foreach($prodis as $prodi)
                                                <option value="{{ $prodi->id }}" {{ $user->prodi_id == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">* Pilih "Umum" untuk Admin Rumah Tangga</small>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0">
                                    <button type="submit" class="btn btn-warning w-100 py-2 rounded-3 fw-bold shadow-sm">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
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
    <div class="modal-dialog modal-dialog-centered">
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
                        <input type="text" name="name" class="form-control bg-light border-0" required placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control bg-light border-0" required placeholder="nama@email.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control bg-light border-0" required placeholder="******">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role / Jabatan</label>
                        <select name="role" id="roleTambah" class="form-select bg-light border-0" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Kepala Lab">Kepala Lab</option>
                            <option value="Tim Pemelihara">Tim Pemelihara</option>
                            <option value="Kaprodi">Admin Rumah Tangga</option>
                            <option value="Pembantu Direktur 1">Pembantu Direktur 1</option>
                            <option value="Pembantu Direktur 2">Pembantu Direktur 2</option>
                        </select>
                    </div>

                    {{-- Input Dinamis Lab (Tambah) --}}
                    <div id="sectionLabTambah" class="mb-3 d-none p-3 rounded-3 bg-primary-subtle border border-primary-subtle">
                        <label class="form-label small fw-bold text-primary">Nama Lab / Workshop</label>
                        <select name="lab_id" class="form-select border-0 shadow-sm">
                            <option value="">-- Pilih Lab/Workshop --</option>
                            @foreach($laboratoriums as $lab)
                                <option value="{{ $lab->id }}">{{ $lab->nama_lab }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-2">Daftar lab sinkron dengan Unit Management</small>
                    </div>

                    {{-- Input Dinamis Prodi (Tambah) --}}
                    <div id="sectionProdiTambah" class="mb-3 d-none p-3 rounded-3 bg-primary-subtle border border-primary-subtle">
                        <label class="form-label small fw-bold text-primary">Nama Prodi / Unit Kerja</label>
                        <select name="prodi_id" class="form-select border-0 shadow-sm">
                            <option value="">-- Pilih Prodi / Unit --</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-2">Pilih "Umum" untuk Admin Rumah Tangga</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Logika untuk Modal Tambah
    const roleTambah = document.getElementById('roleTambah');
    const sectionLabTambah = document.getElementById('sectionLabTambah');
    const sectionProdiTambah = document.getElementById('sectionProdiTambah');

    roleTambah.addEventListener('change', function() {
        sectionLabTambah.classList.add('d-none');
        sectionProdiTambah.classList.add('d-none');
        
        if (this.value === 'Kepala Lab') {
            sectionLabTambah.classList.remove('d-none');
        } else if (this.value === 'Kaprodi') {
            sectionProdiTambah.classList.remove('d-none');
        }
    });

    // Logika untuk Modal Edit (Looping)
    const editRoleSelectors = document.querySelectorAll('.role-select-edit');
    editRoleSelectors.forEach(select => {
        select.addEventListener('change', function() {
            const userId = this.getAttribute('data-id');
            const sectionLabEdit = document.getElementById('sectionLabEdit' + userId);
            const sectionProdiEdit = document.getElementById('sectionProdiEdit' + userId);

            sectionLabEdit.classList.add('d-none');
            sectionProdiEdit.classList.add('d-none');

            if (this.value === 'Kepala Lab') {
                sectionLabEdit.classList.remove('d-none');
            } else if (this.value === 'Kaprodi') {
                sectionProdiEdit.classList.remove('d-none');
            }
        });
    });
});
</script>
@endsection