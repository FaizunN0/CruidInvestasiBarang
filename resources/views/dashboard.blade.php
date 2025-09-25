@extends('layouts.app')

@section('content')
<div class="row g-4 mb-4">
    <!-- Card Jumlah Barang -->
    <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 h-100">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-box-seam fs-1 text-primary"></i>
                </div>
                <h5 class="fw-bold">Total Barang</h5>
                <h2 class="fw-bolder text-gradient">
                    {{ $jumlahBarang ?? 0 }}
                </h2>
                <p class="text-muted small">Jumlah barang tercatat di sistem</p>
            </div>
        </div>
    </div>

    <!-- Card Jumlah User -->
    <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 h-100">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-people fs-1 text-success"></i>
                </div>
                <h5 class="fw-bold">Total User</h5>
                <h2 class="fw-bolder text-gradient">
                    {{ $jumlahUser ?? 0 }}
                </h2>
                <p class="text-muted small">Jumlah akun terdaftar</p>
            </div>
        </div>
    </div>

    <!-- Card Role Login -->
    <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 h-100">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-person-badge fs-1 text-warning"></i>
                </div>
                <h5 class="fw-bold">Role Anda</h5>
                <h4 class="fw-bolder">
                    {{ ucfirst(auth()->user()->role) }}
                </h4>
                <p class="text-muted small">Akses sesuai role & permissions</p>
            </div>
        </div>
    </div>
</div>

<!-- Bagian Statistik & Info -->
<div class="card shadow-lg border-0 rounded-4 mb-4">
    <div class="card-header"
         style="background: linear-gradient(135deg,#7f00ff,#e100ff,#00c6ff); color:#fff;">
        <h5 class="mb-0"><i class="bi bi-graph-up"></i> Statistik & Aktivitas</h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <h6 class="fw-bold mb-3"><i class="bi bi-clock-history"></i> Aktivitas Terbaru</h6>
                <ul class="list-group list-group-flush small">
                    @forelse($aktivitas ?? [] as $act)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $act->deskripsi }}</span>
                            <span class="text-muted">{{ $act->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada aktivitas</li>
                    @endforelse
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart"></i> Statistik Barang</h6>
                <canvas id="chartBarang" height="150"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    const ctx = document.getElementById('chartBarang');
    if(ctx){
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($kategoriBarang ?? ['Barang']) !!},
                datasets: [{
                    data: {!! json_encode($jumlahPerKategori ?? [0]) !!},
                    backgroundColor: [
                        '#7f00ff','#e100ff','#00c6ff','#ffb300','#ff4d4d'
                    ],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.text-gradient {
    background: linear-gradient(135deg,#7f00ff,#e100ff,#00c6ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
@endpush
