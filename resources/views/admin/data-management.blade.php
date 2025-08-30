@extends('layout.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-database-gear me-2"></i>Manajemen Data Desa</h2>
                <div class="btn-group">
                    <button class="btn btn-success" onclick="refreshAllData()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Refresh Data
                    </button>
                    <a href="{{ route('admin.village:populate-real-data') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Reset ke Data Default
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                @foreach($categories as $category)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi {{ getCategoryIcon($category->data) }} me-2"></i>
                                {{ ucfirst($category->data) }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <h4 class="text-primary mb-0">{{ $category->total_records }}</h4>
                                    <small class="text-muted">Kategori</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success mb-0">{{ number_format($category->total_population) }}</h4>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.data.show', $category->data) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil-square me-1"></i>Edit Data
                                </a>
                                <a href="{{ route('admin.data.export', $category->data) }}" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-download me-1"></i>Export CSV
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="bi bi-info-circle me-2"></i>Informasi Sistem</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>📊 Total Kategori Data: <span class="badge bg-primary">{{ $categories->count() }}</span></h6>
                                    <h6>📈 Total Records: <span class="badge bg-info">{{ $categories->sum('total_records') }}</span></h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>👥 Total Populasi: <span class="badge bg-success">{{ number_format($categories->sum('total_population')) }} jiwa</span></h6>
                                    <h6>🕒 Last Updated: <span class="badge bg-secondary">{{ now()->format('d M Y, H:i') }}</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function refreshAllData() {
    if(confirm('Refresh semua data statistik? Ini akan memperbarui cache data.')) {
        fetch('/getdatades?refresh=true', {method: 'POST'})
            .then(() => {
                alert('✅ Data berhasil di-refresh!');
                location.reload();
            });
    }
}
</script>

@php
function getCategoryIcon($category) {
    $icons = [
        'penduduk' => 'bi-people-fill',
        'kk' => 'bi-house-fill',
        'agama' => 'bi-heart-fill',
        'pendidikan' => 'bi-mortarboard-fill',
        'profesi' => 'bi-briefcase-fill',
        'kesehatan' => 'bi-plus-circle-fill',
        'siswa' => 'bi-book-fill',
        'klub' => 'bi-people',
        'kesenian' => 'bi-palette-fill',
        'sumberair' => 'bi-droplet-fill',
    ];
    return $icons[$category] ?? 'bi-bar-chart-fill';
}
@endphp
@endsection
