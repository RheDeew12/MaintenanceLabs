@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f1f5f9; min-height: 100vh;">
    
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-extrabold text-slate-800 mb-1" style="letter-spacing: -0.5px;">Antrean Persetujuan Anggaran</h2>
            <p class="text-slate-500 small mb-0">Tinjau estimasi biaya perbaikan dan pantau riwayat keputusan Anda.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="bg-indigo-600 text-white px-4 py-2 rounded-4 shadow-sm d-flex align-items-center transition-all hover-lift">
                <i class="bi bi-wallet2 me-2"></i>
                <span class="small fw-bold">Total Antrean: {{ $approvalQueue->total() }}</span>
            </div>
        </div>
    </div>

    {{-- Tab Navigasi --}}
    <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill px-4 fw-bold shadow-sm" id="pills-queue-tab" data-bs-toggle="pill" data-bs-target="#pills-queue" type="button" role="tab">
                <i class="bi bi-hourglass-split me-2"></i>Antrean Aktif
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-4 fw-bold shadow-sm" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history" type="button" role="tab">
                <i class="bi bi-clock-history me-2"></i>Riwayat Keputusan
            </button>
        </li>
    </ul>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="tab-content" id="pills-tabContent">
        
        {{-- TAB 1: ANTREAN AKTIF --}}
        <div class="tab-pane fade show active" id="pills-queue" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="card-header bg-white p-4 border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold text-slate-800 mb-0">Daftar Tunggu Validasi</h5>
                        <span class="badge bg-slate-100 text-slate-600 rounded-pill px-3 py-2 border small fw-medium">
                            <i class="bi bi-funnel me-1"></i> Status: Pending Pudir 2
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-slate-50 border-top">
                                <tr class="text-slate-400 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                                    <th class="ps-4 py-3 border-0">Informasi Alat & Lokasi</th>
                                    <th class="border-0">Metode & Estimasi Biaya</th>
                                    <th class="border-0" style="width: 30%;">Rekomendasi Teknis</th>
                                    <th class="text-center pe-4 border-0">Keputusan</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @forelse($approvalQueue as $item)
                                <tr>
                                    <td class="ps-4 py-4">
                                        <div class="fw-bold text-slate-800">{{ $item->barang?->nama_barang ?? 'Unknown Asset' }}</div>
                                        <div class="text-slate-400 small d-flex align-items-center mt-1">
                                            <i class="bi bi-geo-alt-fill me-1 text-primary"></i>
                                            {{ $item->lab->nama_lab ?? ($item->barang?->lab?->nama_lab ?? 'Unit N/A') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-extrabold text-primary fs-5 mb-1">
                                            Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}
                                        </div>
                                        @php $isExternal = $item->repair_type == 'External'; @endphp
                                        <span class="badge rounded-pill fw-bold {{ $isExternal ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700' }}" style="font-size: 10px;">
                                            <i class="bi {{ $isExternal ? 'bi-truck' : 'bi-person-badge' }} me-1"></i>
                                            {{ strtoupper($item->repair_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="p-3 bg-light rounded-4 small text-slate-600 border-start border-primary border-4">
                                            <i class="bi bi-chat-left-quote-fill me-2 opacity-25"></i>
                                            {{ Str::limit($item->technical_recommendation ?? 'Tidak ada catatan teknis tambahan.', 100) }}
                                        </div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-success rounded-pill px-4 fw-bold small shadow-sm transition-all hover-lift" 
                                                    data-bs-toggle="modal" data-bs-target="#approveModal{{$item->id}}">
                                                <i class="bi bi-check-lg me-1"></i> Setuju
                                            </button>
                                            <button class="btn btn-outline-danger rounded-pill px-4 fw-bold small shadow-sm transition-all hover-lift" 
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal{{$item->id}}">
                                                <i class="bi bi-x-lg me-1"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL APPROVE --}}
                                <div class="modal fade" id="approveModal{{$item->id}}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <form action="{{ route('maintenance.approve.pudir2', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-0 p-4">
                                                    <h5 class="modal-title fw-extrabold text-slate-800">Konfirmasi Anggaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body px-4 py-0">
                                                    <div class="alert alert-info border-0 rounded-4 mb-4 small">
                                                        <i class="bi bi-info-circle-fill me-2"></i>
                                                        Anda menyetujui anggaran sebesar <strong>Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</strong>.
                                                    </div>
                                                    <label class="form-label small fw-bold text-slate-400 text-uppercase">Catatan Persetujuan (Opsional)</label>
                                                    <textarea name="approval_note" class="form-control rounded-4 border-2 p-3 shadow-none" rows="3" placeholder="Contoh: Gunakan dana sisa sarpras..."></textarea>
                                                </div>
                                                <div class="modal-footer border-0 p-4">
                                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow">Setujui & Proses</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- MODAL REJECT --}}
                                <div class="modal fade" id="rejectModal{{$item->id}}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <form action="{{ route('maintenance.reject', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-0 p-4">
                                                    <h5 class="modal-title fw-extrabold text-slate-800">Alasan Penolakan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body px-4 py-0">
                                                    <div class="bg-light p-3 rounded-4 mb-4">
                                                        <small class="text-muted d-block mb-1">Aset Terkait:</small>
                                                        <span class="fw-bold text-slate-700">{{ $item->barang?->nama_barang }}</span>
                                                    </div>
                                                    <label class="form-label small fw-bold text-slate-400 text-uppercase">Catatan Penolakan</label>
                                                    <textarea name="note" class="form-control rounded-4 border-2 p-3 shadow-none" rows="4" placeholder="Berikan alasan penolakan anggaran..." required></textarea>
                                                </div>
                                                <div class="modal-footer border-0 p-4">
                                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow">Kirim Penolakan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Tidak ada antrean persetujuan saat ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($approvalQueue->hasPages())
                <div class="card-footer bg-white border-top p-4">
                    {{ $approvalQueue->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>

        {{-- TAB 2: RIWAYAT KEPUTUSAN --}}
        <div class="tab-pane fade" id="pills-history" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-slate-50 border-top">
                                <tr class="text-slate-400 small fw-bold text-uppercase">
                                    <th class="ps-4 py-3 border-0">Waktu Proses</th>
                                    <th class="border-0">Informasi Alat</th>
                                    <th class="border-0">Status Akhir</th>
                                    <th class="border-0">Keputusan Anda (Pudir 2)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $h)
                                <tr>
                                    <td class="ps-4 py-4 small text-slate-500">
                                        @if($h->status == 'rejected')
                                            {{ $h->rejected_at ? $h->rejected_at->format('d/m/Y H:i') : $h->updated_at->format('d/m/Y H:i') }}
                                        @else
                                            {{ $h->approved_at_pudir2 ? $h->approved_at_pudir2->format('d/m/Y H:i') : $h->updated_at->format('d/m/Y H:i') }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-slate-800">{{ $h->barang?->nama_barang }}</div>
                                        <div class="text-muted small">Rp {{ number_format($h->estimated_cost, 0, ',', '.') }}</div>
                                    </td>
                                    <td>
                                        @if($h->status == 'rejected')
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">DITOLAK</span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">DISETUJUI</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="p-2 bg-light rounded-3 small text-slate-600 border-start border-3 {{ $h->status == 'rejected' ? 'border-danger' : 'border-success' }}">
                                            <div class="fw-bold mb-1 {{ $h->status == 'rejected' ? 'text-danger' : 'text-success' }}" style="font-size: 10px;">
                                                {{ $h->status == 'rejected' ? 'ALASAN PENOLAKAN:' : 'INSTRUKSI PERSETUJUAN:' }}
                                            </div>
                                            <span class="fst-italic">"{{ $h->pudir2_note ?? 'Tidak ada catatan tambahan.' }}"</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Belum ada riwayat keputusan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link { color: #64748b; background: #fff; border: 1px solid #e2e8f0; margin-right: 5px; }
    .nav-pills .nav-link.active { background-color: #4f46e5 !important; color: white; border-color: #4f46e5; }
    .fw-extrabold { font-weight: 800; }
    .text-slate-800 { color: #1e293b; }
    .text-slate-500 { color: #64748b; }
    .text-slate-400 { color: #94a3b8; }
    .bg-slate-50 { background-color: #f8fafc; }
    .hover-lift:hover { transform: translateY(-3px); }
    .transition-all { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
    .modal-content { animation: modalFadeUp 0.3s ease-out; }
    @keyframes modalFadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection