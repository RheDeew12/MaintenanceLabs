@extends('layouts.admin')

@section('title', 'Dashboard Kaprodi')

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #f8fafc; min-height: 100vh;">
    
    {{-- A. Header & Info Prodi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard Monitoring Perawatan</h2>
            <p class="text-muted small mb-0">
                Program Studi: 
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 rounded-pill border border-primary border-opacity-25 shadow-none">
                    {{ Auth::user()->prodi->nama_prodi ?? 'Prodi N/A' }}
                </span>
            </p>
        </div>
        <div class="bg-white px-3 py-2 rounded-3 shadow-sm border small">
            <i class="bi bi-clock-history text-primary me-2"></i>
            <span class="fw-bold text-slate-600">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    {{-- B. Filter Data (Pusat Kendali) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-sliders me-2 text-primary"></i>Filter Unit & Waktu</h6>
            <form action="{{ url()->current() }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="small text-muted fw-bold text-uppercase mb-1" style="font-size: 10px;">Sub-Unit (Lab/Workshop)</label>
                    <select name="lab_id" class="form-select border-2 bg-light bg-opacity-50 rounded-3">
                        <option value="">Semua Unit Prodi</option>
                        @isset($labs)
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                                    {{ $lab->nama_lab }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted fw-bold text-uppercase mb-1" style="font-size: 10px;">Rentang Tanggal</label>
                    <div class="input-group border-0">
                        <input type="date" name="start_date" class="form-control border-2 bg-light bg-opacity-50 rounded-start-3" value="{{ request('start_date') }}">
                        <span class="input-group-text border-2 bg-light small">s/d</span>
                        <input type="date" name="end_date" class="form-control border-2 bg-light bg-opacity-50 rounded-end-3" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-bold text-uppercase mb-1" style="font-size: 10px;">Status Progres</label>
                    <select name="status" class="form-select border-2 bg-light bg-opacity-50 rounded-3">
                        <option value="">Semua Progres</option>
                        <option value="pending_kaprodi" {{ request('status') == 'pending_kaprodi' ? 'selected' : '' }}>Verifikasi Anda</option>
                        <option value="repairing" {{ request('status') == 'repairing' ? 'selected' : '' }}>Sedang Diperbaiki</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-none fw-bold py-2">Filter</button>
                    <a href="{{ url()->current() }}" class="btn btn-light border w-100 rounded-3 py-2 px-0"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- C. Widget Ringkasan (Menggunakan Variabel $stats yang Sinkron) --}}
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-primary border-4 h-100 transition-all hover-lift">
                <div class="card-body p-4">
                    <small class="text-muted d-block fw-bold text-uppercase mb-2" style="font-size: 10px; letter-spacing: 1px;">Total Pengajuan</small>
                    <h3 class="fw-extrabold mb-1 text-dark">{{ $stats['total_requests'] ?? 0 }}</h3>
                    <p class="mb-0 small text-primary"><i class="bi bi-file-earmark-text me-1"></i>Seluruh Tiket</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-warning border-4 h-100 transition-all hover-lift">
                <div class="card-body p-4">
                    <small class="text-muted d-block fw-bold text-uppercase mb-2" style="font-size: 10px; letter-spacing: 1px;">Butuh Approval</small>
                    <h3 class="fw-extrabold mb-1 text-warning">{{ $stats['pending'] ?? 0 }}</h3>
                    <p class="mb-0 small text-muted"><i class="bi bi-shield-lock me-1"></i>Verifikasi Kaprodi</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-info border-4 h-100 transition-all hover-lift">
                <div class="card-body p-4">
                    <small class="text-muted d-block fw-bold text-uppercase mb-2" style="font-size: 10px; letter-spacing: 1px;">Dalam Perbaikan</small>
                    <h3 class="fw-extrabold mb-1 text-info">{{ $stats['on_progress'] ?? 0 }}</h3>
                    <p class="mb-0 small text-muted"><i class="bi bi-gear-wide-connected me-1"></i>Sedang Dikerjakan</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-success border-4 h-100 transition-all hover-lift">
                <div class="card-body p-4">
                    <small class="text-muted d-block fw-bold text-uppercase mb-2" style="font-size: 10px; letter-spacing: 1px;">Aset Sehat</small>
                    <h3 class="fw-extrabold mb-1 text-success">{{ $stats['alat_siap'] ?? 0 }}</h3>
                    <p class="mb-0 small text-muted"><i class="bi bi-check-circle me-1"></i>Kondisi Normal/Baik</p>
                </div>
            </div>
        </div>
    </div>

    {{-- D. Tabel Riwayat --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">Log Aktivitas Pemeliharaan</h5>
            <span class="text-muted small">Real-time update sistem</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-subtle border-bottom">
                    <tr class="text-uppercase small fw-bold text-muted" style="font-size: 11px; letter-spacing: 1px;">
                        <th class="ps-4">Tiket</th>
                        <th>Informasi Aset</th>
                        <th>Sub-Unit Pengaju</th>
                        <th>Tgl Ajuan</th>
                        <th class="text-center">Kondisi</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($requests as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="text-primary fw-bold">#{{ $item->id }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->barang->nama_barang ?? 'Alat Tidak Diketahui' }}</div>
                            <div class="text-muted font-monospace small" style="font-size: 10px;">
                                BMN: {{ $item->barang->kode_bmn ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border-0 fw-medium px-2 py-1 rounded-2">
                                {{ $item->lab->nama_lab ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <div class="text-dark small">{{ $item->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td class="text-center">
                            @php
                                $damageColor = [
                                    'Ringan' => 'bg-success-subtle text-success',
                                    'Sedang' => 'bg-warning-subtle text-warning',
                                    'Berat'  => 'bg-danger-subtle text-danger',
                                ][$item->damage_level] ?? 'bg-light text-muted';
                            @endphp
                            <span class="badge {{ $damageColor }} px-2 py-1 rounded-2 fw-bold" style="font-size: 9px;">
                                {{ strtoupper($item->damage_level ?? 'Normal') }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusMap = [
                                    'pending_kaprodi' => ['c' => 'warning', 'l' => 'WAITING APPROVAL'],
                                    'repairing' => ['c' => 'info', 'l' => 'ON REPAIR'],
                                    'closed' => ['c' => 'success', 'l' => 'COMPLETED'],
                                    'rejected' => ['c' => 'danger', 'l' => 'REJECTED']
                                ];
                                $s = $statusMap[$item->status] ?? ['c' => 'secondary', 'l' => $item->status];
                            @endphp
                            <span class="badge bg-{{ $s['c'] }} text-white px-2 py-1 rounded-pill" style="font-size: 8px;">
                                {{ strtoupper($s['l']) }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                             <a href="{{ route('kaprodi.maintenance.show', $item->id) }}" class="btn btn-sm btn-white border rounded-3 shadow-sm px-2">
                                <i class="bi bi-eye-fill text-primary"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <p class="text-muted small">Tidak ada data pemeliharaan yang sesuai filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
        <div class="card-footer bg-white border-top py-3">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; transition: all 0.3s; }
    .transition-all { transition: all 0.3s ease; }
    .fw-extrabold { font-weight: 800; }
    .bg-success-subtle { background-color: #d1e7dd; color: #0f5132; }
    .bg-warning-subtle { background-color: #fff3cd; color: #664d03; }
    .bg-danger-subtle { background-color: #f8d7da; color: #842029; }
</style>
@endsection