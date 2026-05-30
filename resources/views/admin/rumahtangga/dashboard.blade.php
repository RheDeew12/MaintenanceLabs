@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f0f4f8; min-height: 100vh;">
    
    {{-- Header Khusus Rumah Tangga --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
        <div class="card-body p-4 text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">Pusat Kendali Rumah Tangga</h2>
                    <p class="opacity-75 mb-0">Manajemen Pemeliharaan Fasilitas Umum & Sarana Prasarana Kampus</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="badge bg-white text-success px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-shield-check me-1"></i> Verifikator Utama Umum
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Widget Statistik Khusus Sarpras --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success">
                            <i class="bi bi-building fs-4"></i>
                        </div>
                        <span class="text-muted small">Total Unit</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['total'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Fasilitas Terdaftar</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="p-2 bg-warning bg-opacity-10 rounded-3 text-warning">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                        <span class="text-muted small">Validasi</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['pending'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Butuh Persetujuan Anda</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="p-2 bg-info bg-opacity-10 rounded-3 text-info">
                            <i class="bi bi-tools fs-4"></i>
                        </div>
                        <span class="text-muted small">Perbaikan</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['on_progress'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Sedang Dikerjakan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="p-2 bg-primary bg-opacity-10 rounded-3 text-primary">
                            <i class="bi bi-check2-all fs-4"></i>
                        </div>
                        <span class="text-muted small">Selesai</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['closed'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Tiket Ditutup</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Monitoring Realisasi --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Monitoring Fasilitas Umum</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border rounded-pill px-3 dropdown-toggle" data-bs-toggle="dropdown">
                        Filter Status
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Semua</a></li>
                        <li><a class="dropdown-item" href="#">Pending</a></li>
                        <li><a class="dropdown-item" href="#">Repairing</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">ID Tiket</th>
                            <th>Fasilitas / Ruangan</th>
                            <th>Uraian Kerusakan</th>
                            <th>Status Alur</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $req->id }}</td>
                            <td>
                                <div class="fw-bold">{{ $req->barang->nama_barang }}</div>
                                <small class="text-muted">{{ $req->lab->nama_lab }}</small>
                            </td>
                            <td>
                                <span class="small text-truncate d-inline-block" style="max-width: 200px;">
                                    {{ $req->issue_description }}
                                </span>
                            </td>
                            <td>
                                @if($req->status == 'pending_kaprodi')
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">MENUNGGU ANDA</span>
                                @elseif($req->status == 'pending_pudir2')
                                    <span class="badge bg-info text-white px-3 rounded-pill">DI PUDIR 2 (KEUANGAN)</span>
                                @else
                                    <span class="badge bg-light text-muted px-3 rounded-pill">{{ strtoupper($req->status) }}</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                @if($req->status == 'pending_kaprodi')
                                    <form action="{{ route('maintenance.approve', $req->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                            Validasi <i class="bi bi-arrow-right-short"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">Belum ada pengajuan untuk unit Umum.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection