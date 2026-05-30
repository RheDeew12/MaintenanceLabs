@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8fafc; min-height: 100vh;">
    
    {{-- Header Dashboard --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard Monitoring Kaprodi</h2>
            <p class="text-muted small mb-0">
                Pemantauan realisasi maintenance alat di lingkungan 
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 rounded-pill">
                    ID Prodi: {{ Auth::user()->prodi_id }}
                </span>
            </p>
        </div>
        <div class="bg-white px-3 py-2 rounded-3 shadow-sm border small d-none d-md-block">
            <i class="bi bi-calendar3 text-primary me-2"></i>
            <span class="fw-bold text-slate-600">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    {{-- Notifikasi System --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4 border-0 p-3" role="alert" style="background: #ecfdf5;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                <div class="text-success fw-medium">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter Panel --}}
    <div class="card mb-4 shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('kaprodi.dashboard') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted text-uppercase" style="font-size: 10px;">Filter Unit Lab</label>
                    <select name="lab_id" class="form-select border-2 rounded-3 shadow-none">
                        <option value="">Semua Lab Prodi</option>
                        @isset($laboratoriums)
                            @foreach($laboratoriums as $lab)
                                <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                                    {{ $lab->nama_lab }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase" style="font-size: 10px;">Rentang Waktu Pengajuan</label>
                    <div class="input-group">
                        <input type="date" name="start_date" class="form-control border-2 rounded-start-3 shadow-none" value="{{ request('start_date') }}">
                        <span class="input-group-text border-2 bg-light text-muted small">s/d</span>
                        <input type="date" name="end_date" class="form-control border-2 rounded-end-3 shadow-none" value="{{ request('end_date') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted text-uppercase" style="font-size: 10px;">Status Tiket</label>
                    <select name="status" class="form-select border-2 rounded-3 shadow-none">
                        <option value="">Semua Status</option>
                        <option value="pending_kaprodi" {{ request('status') == 'pending_kaprodi' ? 'selected' : '' }}>Verifikasi Anda</option>
                        <option value="repairing" {{ request('status') == 'repairing' ? 'selected' : '' }}>Proses Perbaikan</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Selesai (Closed)</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm py-2 fw-bold transition-all hover-lift">
                        Filter
                    </button>
                    <a href="{{ route('kaprodi.dashboard') }}" class="btn btn-light border rounded-3 py-2 px-3 transition-all hover-lift">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Widget Statistik KPI --}}
    <div class="row mb-4 g-3">
        @php
            $statsData = [
                ['label' => 'Total Ajuan', 'val' => $stats['total'] ?? 0, 'bg' => 'primary', 'icon' => 'bi-collection-fill'],
                ['label' => 'Menunggu Saya', 'val' => $stats['pending'] ?? 0, 'bg' => 'warning', 'icon' => 'bi-shield-exclamation'],
                ['label' => 'Dalam Perbaikan', 'val' => $stats['on_progress'] ?? 0, 'bg' => 'info', 'icon' => 'bi-gear-wide-connected'],
                ['label' => 'Unit Normal', 'val' => $stats['alat_siap'] ?? 0, 'bg' => 'success', 'icon' => 'bi-check-circle-fill'],
            ];
        @endphp
        @foreach($statsData as $kpi)
        <div class="col-md-3">
            <div class="card bg-{{ $kpi['bg'] }} text-{{ $kpi['bg'] == 'warning' ? 'dark' : 'white' }} shadow-sm border-0 rounded-4 transition-all hover-lift h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-white bg-opacity-25 rounded-3 p-2">
                            <i class="bi {{ $kpi['icon'] }} fs-4"></i>
                        </div>
                        <h2 class="fw-bold mb-0">{{ $kpi['val'] }}</h2>
                    </div>
                    <h6 class="opacity-75 small text-uppercase fw-bold mb-0" style="letter-spacing: 0.5px;">{{ $kpi['label'] }}</h6>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel Realisasi --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">Laporan Realisasi Maintenance</h5>
            <span class="text-muted small">Update: {{ now()->format('H:i') }} WIB</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase small fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.8px;">
                            <th class="ps-4 py-3">No</th>
                            <th>Tanggal Ajuan</th>
                            <th>Aset / Alat & BMN</th>
                            <th>Unit Kerja (Lab)</th>
                            <th>Status Progress</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($requests as $key => $req)
                        <tr>
                            <td class="ps-4 fw-medium text-muted">
                                {{ $requests instanceof \Illuminate\Pagination\LengthAwarePaginator ? $requests->firstItem() + $key : $loop->iteration }}
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $req->created_at->format('d/m/Y') }}</div>
                                <div class="text-muted" style="font-size: 10px;">Pukul {{ $req->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary">{{ $req->barang?->nama_barang ?? 'Alat Tidak Diketahui' }}</div>
                                <div class="badge bg-light text-muted border py-1 px-2 mt-1 font-monospace shadow-none" style="font-size: 9px; font-weight: 500;">
                                    <i class="bi bi-hash"></i>{{ $req->barang?->kode_bmn ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border p-2 fw-medium rounded-2">
                                    <i class="bi bi-geo-alt-fill text-danger me-1 small"></i>
                                    {{ $req->lab?->nama_lab ?? 'Lab N/A' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusConfig = [
                                        'pending_kaprodi' => ['color' => 'warning', 'icon' => 'bi-shield-exclamation', 'label' => 'Menunggu Verifikasi'],
                                        'repairing' => ['color' => 'info', 'icon' => 'bi-tools', 'label' => 'Dalam Perbaikan'],
                                        'closed' => ['color' => 'success', 'icon' => 'bi-check-all', 'label' => 'Selesai'],
                                        'rejected' => ['color' => 'danger', 'icon' => 'bi-x-circle', 'label' => 'Ditolak']
                                    ];
                                    $st = $statusConfig[$req->status] ?? ['color' => 'secondary', 'icon' => 'bi-info-circle', 'label' => $req->status];
                                @endphp
                                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} fw-bold" style="font-size: 9px; border: 1px solid rgba(var(--bs-{{ $st['color'] }}-rgb), 0.2);">
                                    <i class="{{ $st['icon'] }} me-1"></i> {{ strtoupper($st['label']) }}
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                {{-- UPDATE: Gunakan Modal Detail daripada Route yang Tidak Ada --}}
                                <button type="button" class="btn btn-sm btn-white border rounded-3 shadow-sm px-2 transition-all hover-lift" 
                                        data-bs-toggle="modal" data-bs-target="#modalDetailKaprodi{{ $req->id }}" title="Lihat Detail">
                                    <i class="bi bi-eye-fill text-primary"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="opacity-25 mb-3">
                                    <i class="bi bi-clipboard-x fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-slate-800 mb-1">Data Kosong</h6>
                                <p class="text-muted small">Tidak ada pengajuan pemeliharaan yang sesuai filter Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($requests instanceof \Illuminate\Pagination\LengthAwarePaginator && $requests->hasPages())
                <div class="p-4 border-top bg-light bg-opacity-10">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL DETAIL OVERLAY (Looping untuk setiap tiket) --}}
@foreach($requests as $req)
<div class="modal fade" id="modalDetailKaprodi{{ $req->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white border-0 p-4">
                <h5 class="modal-title fw-bold">Detail Pengajuan Maintenance</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-4">
                    <div class="col-md-5">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-2">Foto Kerusakan</label>
                        @if($req->foto_kerusakan)
                            <img src="{{ asset('storage/' . $req->foto_kerusakan) }}" class="img-fluid rounded-4 border shadow-sm w-100" style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="bg-white border rounded-4 d-flex flex-column align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                                <span class="text-muted small">Tidak ada lampiran foto</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <div class="bg-white p-3 rounded-4 shadow-sm border mb-3">
                            <h6 class="fw-bold text-primary mb-1">{{ $req->barang?->nama_barang }}</h6>
                            <span class="text-muted small">BMN: {{ $req->barang?->kode_bmn }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Deskripsi Kerusakan</label>
                            <div class="bg-white p-3 rounded-3 border small italic text-slate-700">
                                "{{ $req->issue_description }}"
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="text-muted small fw-bold text-uppercase d-block mb-1">Level Kerusakan</label>
                                <span class="badge bg-{{ $req->damage_level == 'Berat' ? 'danger' : ($req->damage_level == 'Sedang' ? 'warning' : 'info') }} rounded-pill">
                                    {{ $req->damage_level }}
                                </span>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small fw-bold text-uppercase d-block mb-1">Unit Kerja</label>
                                <span class="fw-bold small text-dark">{{ $req->lab?->nama_lab }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-0 p-4 pt-0">
                @if($req->status == 'pending_kaprodi')
                    <form action="{{ route('maintenance.approve', $req->id) }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 rounded-3 py-2 fw-bold">
                            <i class="bi bi-check-lg me-2"></i> Setujui Pengajuan Sekarang
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-light w-100 rounded-3 border fw-bold" data-bs-dismiss="modal">Tutup</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .transition-all { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
    .table thead th { border-bottom: none; }
    .btn-white { background: white; }
    .font-monospace { font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; }
</style>
@endsection