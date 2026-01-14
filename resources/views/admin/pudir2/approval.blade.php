@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1">Antrean Persetujuan Anggaran</h3>
            <p class="text-white-50 small mb-0">Tinjau dan setujui estimasi biaya perbaikan alat laboratorium</p>
        </div>
        <div class="bg-glass text-white px-3 py-2 rounded-pill small">
            <i class="fas fa-wallet me-2"></i> Total Antrean: {{ $approvalQueue->total() }}
        </div>
    </div>

    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Alat & Lokasi</th>
                            <th>Estimasi Biaya</th>
                            <th>Rekomendasi Teknisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approvalQueue as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->equipment->nama_alat }}</div>
                                <div class="badge bg-primary-subtle text-primary rounded-pill x-small">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $item->equipment->lab->nama_lab }}
                                </div>
                            </td>
                            <td>
                                {{-- Gunakan kolom yang sesuai di DB: estimated_cost atau estimasi_biaya --}}
                                <div class="text-dark fw-bold" style="font-size: 1.1rem;">
                                    Rp {{ number_format($item->estimated_cost ?? $item->estimasi_biaya, 0, ',', '.') }}
                                </div>
                                <small class="text-muted text-xs">Pagu Anggaran Terpakai: 15%</small>
                            </td>
                            <td>
                                <div class="p-2 bg-light rounded-3 small text-muted border-start border-primary border-3">
                                    <i class="fas fa-quote-left me-2 opacity-50"></i>
                                    {{ $item->catatan_teknisi ?? 'Perbaikan pihak luar diperlukan untuk penggantian suku cadang.' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('maintenance.approve.pudir2', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-check me-1"></i> Setujui
                                        </button>
                                    </form>
                                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal{{$item->id}}">
                                        <i class="fas fa-times me-1"></i> Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="rejectModal{{$item->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <form action="{{ route('maintenance.reject', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Alasan Penolakan Anggaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="small text-muted mb-3">Berikan alasan mengapa permohonan biaya untuk <strong>{{ $item->equipment->nama_alat }}</strong> ditolak.</p>
                                            <textarea name="reason" class="form-control rounded-3" rows="3" placeholder="Contoh: Anggaran dialihkan ke prioritas lain atau biaya terlalu tinggi..." required></textarea>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">Kirim Penolakan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="opacity-25 mb-3">
                                    <i class="fas fa-inbox fa-4x"></i>
                                </div>
                                <p class="text-muted">Tidak ada antrean persetujuan biaya saat ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($approvalQueue->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $approvalQueue->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .bg-glass { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    .x-small { font-size: 0.75rem; }
    .text-xs { font-size: 0.7rem; }
</style>
@endsection