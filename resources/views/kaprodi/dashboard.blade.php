@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">Dashboard Kaprodi</h2>
        <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">
            <i class="bi bi-person-badge me-1"></i> Prodi ID: {{ Auth::user()->prodi_id }}
        </span>
    </div>

    {{-- BAGIAN PESAN NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4 border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- FITUR FILTER (DISINKRONISASI DENGAN CONTROLLER) --}}
    <div class="card mb-4 shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('kaprodi.dashboard') }}" method="GET" class="row g-3">
                {{-- Filter Lab --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Pilihan Lab</label>
                    <select name="lab_id" class="form-select border-0 bg-light rounded-3 shadow-sm">
                        <option value="">Semua Lab Prodi</option>
                        @foreach($labs as $lab)
                            <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                                {{ $lab->nama_lab }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Tanggal --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase">Rentang Waktu</label>
                    <div class="input-group shadow-sm rounded-3 overflow-hidden">
                        <input type="date" name="start_date" class="form-control border-0 bg-light" value="{{ request('start_date') }}">
                        <span class="input-group-text border-0 bg-light text-muted small">s/d</span>
                        <input type="date" name="end_date" class="form-control border-0 bg-light" value="{{ request('end_date') }}">
                    </div>
                </div>

                {{-- Filter Status --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Status</label>
                    <select name="status" class="form-select border-0 bg-light rounded-3 shadow-sm">
                        <option value="">Semua Status</option>
                        <option value="pending_kaprodi" {{ request('status') == 'pending_kaprodi' ? 'selected' : '' }}>Menunggu Saya</option>
                        <option value="repairing" {{ request('status') == 'repairing' ? 'selected' : '' }}>Sedang Diperbaiki</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm py-2 fw-bold">
                        <i class="bi bi-filter me-1"></i> Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- WIDGET KPI (UPDATE: Mengganti 'approved' menjadi 'pending' sesuai Controller) --}}
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow border-0 rounded-4 transition-all hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex p-3 mb-2">
                        <i class="bi bi-collection-fill fs-4"></i>
                    </div>
                    <h6 class="opacity-75 small text-uppercase fw-bold mb-1">Total Pengajuan</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow border-0 rounded-4 transition-all hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-dark bg-opacity-10 rounded-circle d-inline-flex p-3 mb-2">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <h6 class="opacity-75 small text-uppercase fw-bold mb-1">Menunggu Saya</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['pending'] }}</h2> {{-- UPDATE DISINI --}}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow border-0 rounded-4 transition-all hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex p-3 mb-2">
                        <i class="bi bi-gear-wide-connected fs-4"></i>
                    </div>
                    <h6 class="opacity-75 small text-uppercase fw-bold mb-1">Proses Perbaikan</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['on_progress'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow border-0 rounded-4 transition-all hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex p-3 mb-2">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <h6 class="opacity-75 small text-uppercase fw-bold mb-1">Selesai (Closed)</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['closed'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DATA REALISASI --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-4 px-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Laporan Realisasi Maintenance</h5>
                <span class="text-muted small">Menampilkan data pengajuan terbaru di prodi Anda.</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr class="text-uppercase small fw-bold text-muted">
                            <th class="ps-4" width="50">No</th>
                            <th>Tanggal</th>
                            <th>Aset / Alat</th>
                            <th>Laboratorium</th>
                            <th>Status Tiket</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $key => $req)
                        <tr class="transition-all hover-bg-light">
                            <td class="ps-4 fw-medium text-muted">{{ $requests->firstItem() + $key }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $req->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $req->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <div class="fw-bold text-primary">{{ $req->equipment?->nama_alat ?? 'Alat Tidak Ditemukan' }}</div>
                                <div class="badge bg-light text-muted border py-1 px-2 mt-1" style="font-size: 10px;">
                                    <i class="bi bi-hash"></i>{{ $req->equipment?->kode_aset ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border border-opacity-25 p-2 d-inline-flex align-items-center">
                                    <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                    {{ $req->equipment?->lab?->nama_lab ?? 'Lab Belum Diatur' }}
                                </span>
                            </td>
                            <td>
                                {{-- BADGE STATUS UNTUK WORKFLOW DINAMIS --}}
                                @if($req->status == 'pending_kaprodi')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-shield-exclamation me-1"></i> Menunggu Kaprodi
                                    </span>
                                @elseif(in_array($req->status, ['pending_pudir1', 'pending_pudir2']))
                                    <span class="badge bg-info text-white px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-hourglass-split me-1"></i> Verifikasi Atasan
                                    </span>
                                @elseif($req->status == 'repairing')
                                    <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-tools me-1"></i> Proses Perbaikan
                                    </span>
                                @elseif($req->status == 'closed')
                                    <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-check-all me-1"></i> Selesai
                                    </span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm">
                                        {{ str_replace('_', ' ', strtoupper($req->status)) }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                @include('layouts.actions', ['item' => $req])
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                <span class="fst-italic">Belum ada data pengajuan untuk prodi ini dalam kriteria filter tersebut.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-top">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .hover-lift:hover { transform: translateY(-3px); transition: all 0.3s ease; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .hover-bg-light:hover { background-color: rgba(0,0,0,0.02); }
</style>
@endsection