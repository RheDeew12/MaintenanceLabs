@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <h3 class="fw-bold text-dark mb-1">Unit Management</h3>
            <p class="text-muted small mb-0">Manajemen data Laboratorium & Workshop langsung dari database utama.</p>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-md-end align-items-center gap-3">
            <div class="search-box">
                <input type="text" id="unitSearch" class="form-control rounded-pill px-3" placeholder="Cari laboratorium...">
            </div>
            <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="bi bi-plus-lg me-2"></i>Tambah Laboratorium
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="unitTable">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3 text-center" style="width: 70px;">No</th>
                            <th>Nama Laboratorium / Workshop</th>
                            <th class="text-center">Program Studi</th>
                            <th class="pe-4 text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $index => $lab)
                        <tr>
                            <td class="ps-4 text-center text-muted small">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $lab->nama_lab }}</div>
                                <div class="text-muted" style="font-size: 11px;">Created: {{ $lab->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-primary border rounded-pill px-3 py-2 fw-semibold">
                                    {{ $lab->prodi->nama_prodi ?? 'Prodi ID: '.$lab->prodi_id }}
                                </span>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Edit dengan data-id untuk JavaScript --}}
                                    <button type="button" 
                                        class="btn btn-sm btn-outline-info rounded-pill px-3 btn-edit"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal"
                                        data-id="{{ $lab->id }}"
                                        data-nama="{{ $lab->nama_lab }}"
                                        data-prodi="{{ $lab->prodi_id }}">
                                        Edit
                                    </button>

                                    {{-- Route Destroy disesuaikan dengan web.php: /units/{id}/delete --}}
                                    <form action="{{ route('units.destroy', $lab->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus lab ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">Tidak ada data laboratorium.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="tambahModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('units.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Laboratorium / Ruang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Pilih Program Studi / Unit Kerja</label>
                        <select name="prodi_id" class="form-select rounded-3" required>
                            <option value="">-- Pilih Prodi --</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Nama Laboratorium / Workshop</label>
                        <input type="text" name="nama_lab" class="form-control rounded-3" placeholder="Contoh: Lab Kimia Terapan" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center pb-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            {{-- Form ID digunakan untuk manipulasi URL via JS --}}
            <form id="editForm" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                @method('PUT') {{-- Wajib untuk route PUT di web.php --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Laboratorium</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Pilih Program Studi / Unit Kerja</label>
                        <select name="prodi_id" id="edit_prodi_id" class="form-select rounded-3" required>
                            <option value="">-- Pilih Prodi --</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Nama Laboratorium / Workshop</label>
                        <input type="text" name="nama_lab" id="edit_nama_lab" class="form-control rounded-3" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center pb-4">
                    <button type="submit" class="btn btn-info text-white rounded-pill px-5 shadow">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .table-responsive { min-height: 200px; }
    #unitTable thead th { font-size: 11px; letter-spacing: 0.8px; }
    .search-box .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15); border-color: #3b82f6; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika Modal Edit
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const prodiId = button.getAttribute('data-prodi');

                const form = editModal.querySelector('#editForm');
                const inputNama = editModal.querySelector('#edit_nama_lab');
                const selectProdi = editModal.querySelector('#edit_prodi_id');

                /** * PENYESUAIAN URL:
                 * Berdasarkan web.php Anda: Route::put('/{id}/update', ...) dengan prefix 'units'
                 * URL yang benar adalah /units/{id}/update
                 */
                form.action = `/units/${id}/update`; 
                
                inputNama.value = nama;
                selectProdi.value = prodiId;
            });
        }

        // Pencarian Tabel
        const searchInput = document.getElementById('unitSearch');
        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                const rows = document.querySelectorAll('#unitTable tbody tr');
                rows.forEach(row => {
                    row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
                });
            });
        }
    });
</script>
@endsection