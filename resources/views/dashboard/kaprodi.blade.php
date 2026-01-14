@extends('layouts.admin')

@section('title', 'Dashboard Kaprodi')

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- A. Filter Data (Pusat Kendali) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-sliders me-2"></i>Pusat Kendali Filter</h6>
            <form action="{{ route('dashboard') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="small text-muted fw-semibold">Pilihan Lab</label>
                    <select name="lab_id" class="form-select border-0 bg-light rounded-3">
                        <option value="">Semua Lab Prodi</option>
                        @foreach($labs as $lab)
                            <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                                {{ $lab->nama_lab }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted fw-semibold">Rentang Waktu</label>
                    <div class="input-group">
                        <input type="date" name="start_date" class="form-control border-0 bg-light rounded-start-3" value="{{ request('start_date') }}">
                        <span class="input-group-text border-0 bg-light small">s/d</span>
                        <input type="date" name="end_date" class="form-control border-0 bg-light rounded-end-3" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-semibold">Status Tiket</label>
                    <select name="status" class="form-select border-0 bg-light rounded-3">
                        <option value="">Semua Status</option>
                        <option value="pending_kaprodi">Menunggu Persetujuan Anda</option>
                        <option value="repairing">Sedang Diperbaiki</option>
                        <option value="closed">Selesai (Closed)</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- B. Widget Ringkasan (KPI) --}}
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100 transition-all hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-white bg-opacity-25 rounded-3 p-2 text-white"><i class="bi bi-file-earmark-plus fs-4"></i></div>
                        <span class="badge bg-white bg-opacity-25 rounded-pill small">Pending</span>
                    </div>
                    <h3 class="fw-extrabold mb-1">{{ $totalPengajuan }}</h3>
                    <p class="mb-0 small opacity-75">Menunggu Persetujuan Kaprodi</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark h-100 transition-all hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-dark bg-opacity-10 rounded-3 p-2 text-dark"><i class="bi bi-shield-lock fs-4"></i></div>
                        <span class="badge bg-dark bg-opacity-10 rounded-pill small">Proses Anggaran</span>
                    </div>
                    <h3 class="fw-extrabold mb-1">{{ $disetujui }}</h3>
                    <p class="mb-0 small opacity-75">Tiket di Tahap Pudir 2</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-info text-white h-100 transition-all hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-white bg-opacity-25 rounded-3 p-2 text-white"><i class="bi bi-wrench-adjustable fs-4"></i></div>
                        <span class="badge bg-white bg-opacity-25 rounded-pill small">Pengerjaan</span>
                    </div>
                    <h3 class="fw-extrabold mb-1">{{ $sedangDikerjakan }}</h3>
                    <p class="mb-0 small opacity-75">Sedang Dalam Perbaikan</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100 transition-all hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-white bg-opacity-25 rounded-3 p-2 text-white"><i class="bi bi-check-circle fs-4"></i></div>
                        <span class="badge bg-white bg-opacity-25 rounded-pill small">Normal</span>
                    </div>
                    <h3 class="fw-extrabold mb-1">{{ $selesai }}</h3>
                    <p class="mb-0 small opacity-75">Tiket Berhasil Ditutup</p>
                </div>
            </div>
        </div>
    </div>

    {{-- C. Tabel Riwayat (Data Riil dari Ka. Lab) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-4 px-4">
            <h5 class="fw-bold mb-0 text-dark">Daftar Pengajuan Perawatan</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-subtle border-bottom">
                    <tr class="text-uppercase small fw-bold text-muted">
                        <th class="ps-4">ID Tiket</th>
                        <th>Alat & Kode BMN</th>
                        <th>Lab Pengaju</th>
                        <th>Tgl Ajuan</th>
                        <th>Urgensi</th>
                        <th>Status Progres</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="text-primary fw-bold">#{{ $item->id_tiket ?? 'TIC-'.$item->id }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->equipment->nama_alat ?? 'N/A' }}</div>
                            <small class="text-muted font-monospace">{{ $item->equipment->kode_aset ?? 'N/A' }}</small>
                        </td>
                        <td><span class="small fw-medium">{{ $item->equipment->lab->nama_lab ?? 'N/A' }}</span></td>
                        <td><span class="small">{{ $item->created_at->format('d/m/Y') }}</span></td>
                        <td>
                            @php
                                $urgencyMap = [
                                    'Low'    => ['label' => 'RINGAN', 'class' => 'bg-success-subtle text-success'],
                                    'Medium' => ['label' => 'SEDANG', 'class' => 'bg-warning-subtle text-warning'],
                                    'High'   => ['label' => 'BERAT',  'class' => 'bg-danger-subtle text-danger'],
                                ];
                                $urg = $urgencyMap[$item->urgency] ?? ['label' => 'UMUM', 'class' => 'bg-light text-muted'];
                            @endphp
                            <span class="badge {{ $urg['class'] }} border px-2 py-1 rounded-2 fw-bold" style="font-size: 10px;">
                                {{ $urg['label'] }}
                            </span>
                        </td>
                        <td>
                            <span class="badge border rounded-pill px-3 py-2 small bg-light text-dark">
                                {{ str_replace('_', ' ', strtoupper($item->status)) }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            @include('layouts.actions')
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada pengajuan untuk Prodi ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .transition-all { transition: all 0.3s ease; }
    .fw-extrabold { font-weight: 800; }
</style>
@endsection