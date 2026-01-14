@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white">Laporan Realisasi & Biaya</h2>
        <button class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tren Biaya Perbaikan ({{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <canvas id="costChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Total Pengeluaran Prodi</h6>
                </div>
                <div class="card-body">
                    <h2 class="text-primary fw-bold">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</h2>
                    <p class="text-muted">Total biaya dari tiket yang telah selesai.</p>
                    <hr>
                    
                    @foreach($biayaPerLab as $lab)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya {{ $lab->lab_name }}</span>
                        <span class="fw-bold">Rp {{ number_format($lab->total, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('costChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Biaya Perbaikan (IDR)',
                // Dinamis: Data dari Controller
                data: {!! json_encode($monthlyTotals) !!},
                borderColor: '#3b82f6',
                tension: 0.3,
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection