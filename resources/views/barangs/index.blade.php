@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background: #f8fafc; min-height: 100vh; color: #1e293b;">
    {{-- Header Section --}}
    <div class="row align-items-center mb-4 g-3">
        <div class="col-12 col-md-6">
            <h2 class="fw-bold mb-0 text-dark">Master Barang</h2>
            <p class="text-muted small mb-0">Kelola inventaris aset dan alat laboratorium</p>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                <i class="bi bi-plus-circle me-2"></i> Tambah Alat Baru
            </button>
        </div>
    </div>

    {{-- Stats Cards (Quick Overview) --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="bi bi-box-seam text-primary fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Total Aset</p>
                        <h5 class="fw-bold mb-0">{{ count($barangs) }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="bi bi-building text-info fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Total Lokasi</p>
                        <h5 class="fw-bold mb-0">{{ count($labs) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Search Section --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control bg-light border-0 px-3 py-2" placeholder="Cari Kode BMN atau Nama Alat...">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select id="filterLab" class="form-select bg-light border-0 py-2">
                        <option value="">Semua Lokasi</option>
                        @foreach($labs as $lab)
                            <option value="{{ $lab->nama_lab }}">{{ $lab->nama_lab }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select id="filterKategori" class="form-select bg-light border-0 py-2">
                        <option value="">Semua Kategori</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Alat Laboratorium">Alat Laboratorium</option>
                        <option value="Furnitur">Furnitur</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button id="resetFilter" class="btn btn-outline-secondary border-0 w-100 py-2 rounded-3">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-4 mb-4 d-flex align-items-center shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="barangTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-0 text-muted small text-uppercase fw-bold">Kode Aset</th>
                            <th class="py-3 border-0 text-muted small text-uppercase fw-bold">Detail Alat</th>
                            <th class="py-3 border-0 text-muted small text-uppercase fw-bold">Lokasi Unit</th>
                            <th class="py-3 border-0 text-muted small text-uppercase fw-bold text-center">Kategori</th>
                            <th class="py-3 border-0 text-muted small text-uppercase fw-bold text-end px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($barangs as $barang)
                        <tr class="align-middle barang-row">
                            <td class="px-4 py-3 fw-bold text-dark kode-bmn">{{ $barang->kode_bmn }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($barang->foto_identifikasi)
                                        <img src="{{ asset('uploads/barangs/' . $barang->foto_identifikasi) }}" class="rounded-3 me-3 border" style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark nama-barang">{{ $barang->nama_barang }}</div>
                                        <div class="text-muted extra-small" style="font-size: 0.7rem;">{{ $barang->merk_tipe ?? 'Tanpa Merk' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="nama-lab">
                                <span class="text-dark small fw-medium">
                                    <i class="bi bi-geo-alt text-danger me-1 small"></i>
                                    {{ $barang->lab->nama_lab ?? 'Tidak Ada Lokasi' }}
                                </span>
                            </td>
                            <td class="text-center kategori-val">
                                <span class="badge {{ $barang->kategori == 'Elektronik' ? 'bg-info' : 'bg-primary' }} bg-opacity-10 {{ $barang->kategori == 'Elektronik' ? 'text-info' : 'text-primary' }} rounded-pill px-3">
                                    {{ $barang->kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="text-end px-4">
                                <button class="btn btn-sm btn-light border text-primary rounded-pill px-3 me-1 hover-lift" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $barang->id }}">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </button>
                                <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light border text-danger rounded-pill px-3 hover-lift" onclick="return confirm('Hapus aset ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL EDIT TETAP SAMA SEPERTI SEBELUMNYA --}}
                        <div class="modal fade" id="modalEdit{{ $barang->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow-lg">
                                    <form action="{{ route('barangs.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-header border-bottom p-4">
                                            <h5 class="modal-title d-flex align-items-center fw-bold text-dark">
                                                <i class="bi bi-pencil-square me-2 text-primary"></i> Edit Detail Alat
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4 bg-light bg-opacity-50">
                                            <div class="mb-4">
                                                <label class="form-label text-muted small fw-bold text-uppercase">Lokasi Laboratorium</label>
                                                <select name="id_lab" class="form-select border-2 py-2 px-3 rounded-3" required>
                                                    @foreach($labs as $lab)
                                                        <option value="{{ $lab->id }}" {{ $barang->id_lab == $lab->id ? 'selected' : '' }}>{{ $lab->nama_lab }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label text-muted small fw-bold text-uppercase">Nama Alat</label>
                                                <input type="text" name="nama_barang" class="form-control border-2 py-2 px-3 rounded-3" value="{{ $barang->nama_barang }}" required>
                                            </div>
                                            <div class="row g-4 mb-4">
                                                <div class="col-md-6">
                                                    <label class="form-label text-muted small fw-bold text-uppercase">Merk/Tipe</label>
                                                    <input type="text" name="merk_tipe" class="form-control border-2 py-2 px-3 rounded-3" value="{{ $barang->merk_tipe }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-muted small fw-bold text-uppercase">Kode Aset (BMN)</label>
                                                    <input type="text" name="kode_bmn" class="form-control border-2 py-2 px-3 rounded-3" value="{{ $barang->kode_bmn }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top p-4">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-folder2-open fs-1 text-muted d-block mb-3"></i>
                                <span class="text-muted">Tidak ada data aset ditemukan.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH TETAP SAMA --}}
<div class="modal fade" id="modalTambahBarang" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <form action="{{ route('barangs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom p-4">
                    <h5 class="modal-title d-flex align-items-center fw-bold text-dark">
                        <i class="bi bi-plus-square-dotted me-2 text-primary"></i> DETAIL ALAT BARU
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light bg-opacity-50">
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Lokasi Penempatan Alat</label>
                        <select name="id_lab" class="form-select border-2 py-2 px-3 rounded-3 shadow-sm" required>
                            <option value="" selected disabled>-- Pilih Laboratorium/Workshop --</option>
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}">{{ $lab->nama_lab }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Nama Alat</label>
                        <input type="text" name="nama_barang" class="form-control border-2 py-2 px-3 rounded-3 shadow-sm" placeholder="Masukkan Nama Alat" required>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold text-uppercase">Merk/Tipe</label>
                            <input type="text" name="merk_tipe" class="form-control border-2 py-2 px-3 rounded-3 shadow-sm" placeholder="Contoh: Asus Vivobook">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold text-uppercase">Kode Aset (BMN)</label>
                            <input type="text" name="kode_bmn" class="form-control border-2 py-2 px-3 rounded-3 shadow-sm" placeholder="Masukkan Kode BMN" required>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold text-uppercase">Kategori</label>
                            <select name="kategori" class="form-select border-2 py-2 px-3 rounded-3 shadow-sm">
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Alat Laboratorium">Alat Laboratorium</option>
                                <option value="Furnitur">Furnitur</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold text-uppercase">Foto Identifikasi Alat</label>
                            <input type="file" name="foto_identifikasi" class="form-control border-2 py-2 px-3 rounded-3 shadow-sm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">Simpan Aset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }
    .hover-lift { transition: transform 0.2s ease; }
    .hover-lift:hover { transform: translateY(-2px); }
    .table thead th { font-size: 0.7rem; letter-spacing: 0.05em; }
    .extra-small { font-size: 0.75rem; }
    /* Efek transisi pencarian */
    .barang-row { transition: all 0.3s ease; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterLab = document.getElementById('filterLab');
        const filterKategori = document.getElementById('filterKategori');
        const resetBtn = document.getElementById('resetFilter');
        const rows = document.querySelectorAll('.barang-row');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const labText = filterLab.value.toLowerCase();
            const kategoriText = filterKategori.value.toLowerCase();

            rows.forEach(row => {
                const kode = row.querySelector('.kode-bmn').textContent.toLowerCase();
                const nama = row.querySelector('.nama-barang').textContent.toLowerCase();
                const lab = row.querySelector('.nama-lab').textContent.toLowerCase();
                const kategori = row.querySelector('.kategori-val').textContent.toLowerCase();

                const matchesSearch = kode.includes(searchText) || nama.includes(searchText);
                const matchesLab = lab.includes(labText);
                const matchesKategori = kategori.includes(kategoriText);

                if (matchesSearch && matchesLab && matchesKategori) {
                    row.style.display = "";
                    row.style.opacity = "1";
                } else {
                    row.style.display = "none";
                    row.style.opacity = "0";
                }
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterLab.addEventListener('change', filterTable);
        filterKategori.addEventListener('change', filterTable);

        resetBtn.addEventListener('click', function() {
            searchInput.value = "";
            filterLab.value = "";
            filterKategori.value = "";
            filterTable();
        });
    });
</script>
@endsection