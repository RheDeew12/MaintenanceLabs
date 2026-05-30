@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f1f5f9; min-height: 100vh;">
    
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-5 d-print-none">
        <div>
            <h2 class="fw-extrabold text-slate-800 mb-1" style="letter-spacing: -0.5px;">Laporan Keseluruhan Aset</h2>
            <p class="text-slate-500 small mb-0">Master data inventaris seluruh unit laboratorium Politeknik ATK Yogyakarta.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold transition-all hover-lift" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>

    {{-- Laporan Header (Hanya Muncul Saat Print) --}}
    <div class="d-none d-print-block mb-4 text-center">
        <h3 class="fw-bold">REKAPITULASI SELURUH ASET LABORATORIUM</h3>
        <h5 class="text-uppercase">POLITEKNIK ATK YOGYAKARTA</h5>
        <hr style="border-top: 2px solid #000;">
    </div>

    {{-- Filter Panel --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 d-print-none">
        <div class="card-body p-4">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="small fw-bold text-slate-400 text-uppercase">Cari Aset</label>
                    <input type="text" name="search" class="form-control rounded-3 border-2" placeholder="Nama / Kode BMN..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-slate-400 text-uppercase">Program Studi</label>
                    <select name="prodi_id" class="form-select rounded-3 border-2">
                        <option value="">Semua Prodi</option>
                        @foreach($prodis as $p)
                            <option value="{{ $p->id }}" {{ request('prodi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-slate-400 text-uppercase">Kondisi</label>
                    <select name="status_kondisi" class="form-select rounded-3 border-2">
                        <option value="">Semua Kondisi</option>
                        <option value="Normal" {{ request('status_kondisi') == 'Normal' ? 'selected' : '' }}>Siap Pakai</option>
                        <option value="Rusak" {{ request('status_kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak / Afkir</option>
                        <option value="Maintenance" {{ request('status_kondisi') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-indigo w-100 rounded-3 fw-bold">Filter</button>
                    <a href="{{ url()->current() }}" class="btn btn-light border w-100 rounded-3 fw-bold">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Asset Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-top">
                        <tr class="text-slate-400 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                            <th class="ps-4 py-3 border-0">No</th>
                            <th class="border-0">Identitas Alat</th>
                            <th class="border-0 text-center">Unit & Prodi</th>
                            <th class="border-0 text-center">Tahun</th>
                            <th class="border-0 text-center">Kondisi</th>
                            <th class="text-center pe-4 border-0 d-print-none">History</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($assets as $index => $asset)
                        <tr>
                            <td class="ps-4 text-slate-400 small">{{ $assets->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-slate-800">{{ $asset->nama_barang }}</div>
                                <div class="text-slate-400 small font-monospace" style="font-size: 10px;">{{ $asset->kode_bmn ?? '-' }}</div>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold text-slate-700 small">{{ $asset->lab->nama_lab ?? '-' }}</div>
                                <div class="badge bg-indigo-100 text-indigo-600 rounded-pill" style="font-size: 9px;">
                                    {{ $asset->lab->prodi->nama_prodi ?? '-' }}
                                </div>
                            </td>
                            <td class="text-center small text-slate-600">{{ $asset->tahun_perolehan }}</td>
                            <td class="text-center">
                                @php
                                $st = match($asset->status_kondisi) {
                                        'Normal', 'Baik' => ['c' => '#10b981', 'l' => 'SIAP PAKAI'], 
                                        'Rusak' => ['c' => '#ef4444', 'l' => 'RUSAK'],
                                        default => ['c' => '#f59e0b', 'l' => 'MAINTENANCE']
                                    };
                                @endphp
                                <span class="badge px-3 py-1 rounded-pill fw-bold" style="background: {{ $st['c'] }}15; color: {{ $st['c'] }}; border: 1px solid {{ $st['c'] }}30; font-size: 9px;">
                                    {{ $st['l'] }}
                                </span>
                            </td>
                            <td class="text-center pe-4 d-print-none">
                                <a href="{{ route('kaprodi.equipment.history', $asset->id) }}" class="btn btn-white border rounded-3 p-1 px-2 shadow-sm transition-all hover-lift">
                                    <i class="bi bi-clock-history text-primary small"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-slate-400 small">Data aset tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white p-4 border-0 d-print-none">
            {{ $assets->links() }}
        </div>
    </div>
</div>

<style>
    .fw-extrabold { font-weight: 800; }
    .text-slate-800 { color: #1e293b; }
    .text-slate-400 { color: #94a3b8; }
    .bg-slate-50 { background-color: #f8fafc; }
    .btn-indigo { background-color: #4f46e5; color: white; }
    .btn-indigo:hover { background-color: #4338ca; color: white; }
    @media print {
        .d-print-none, .sidebar, .navbar { display: none !important; }
        body { background: white !important; }
        .card { border: 1px solid #ddd !important; box-shadow: none !important; }
        .container-fluid { padding: 0 !important; }
    }
</style>
@endsection