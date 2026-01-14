@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h2 class="text-white mb-4">Preventive Maintenance (Kalibrasi)</h2>

    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Monitoring Masa Kalibrasi Alat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Alat</th>
                            <th>Lab</th>
                            <th>Kalibrasi Terakhir</th>
                            <th>Jadwal Selanjutnya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($needs_calibration as $index => $item)
                        @php
                            // Logika Dinamis (Asumsi ada kolom last_calibration di tabel equipment)
                            // Jika kolom belum ada, ini menggunakan nilai dummy yang bisa Anda sesuaikan
                            $lastCal = $item->last_calibration ? \Carbon\Carbon::parse($item->last_calibration) : now()->subYear();
                            $nextCal = $lastCal->copy()->addYear();
                            $isOverdue = now()->gt($nextCal);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $item->nama_alat }}</strong></td>
                            <td>{{ $item->lab->nama_lab ?? '-' }}</td>
                            <td>{{ $lastCal->format('d/m/Y') }}</td>
                            <td>{{ $nextCal->format('d/m/Y') }}</td>
                            <td>
                                @if($isOverdue)
                                    <span class="badge bg-danger p-2">
                                        <i class="bi bi-exclamation-triangle me-1"></i> Segera Kalibrasi
                                    </span>
                                @else
                                    <span class="badge bg-success p-2">
                                        <i class="bi bi-check-circle me-1"></i> Terkalibrasi
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('maintenance.create', ['equipment_id' => $item->id]) }}" 
                                   class="btn btn-sm {{ $isOverdue ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Buat Pengajuan
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Semua alat dalam kondisi "Aman" (Ter-kalibrasi).</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection