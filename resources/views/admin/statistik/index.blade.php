@extends('layout.admin-modern')

@section('title', 'Data Statistik')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">📊 Data Statistik</h1>
            <p class="page-subtitle">Kelola data statistik penduduk untuk chart di halaman utama website desa</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.statistik.create', ['kategori' => $kategori]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Data
            </a>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="stats-grid mb-4">
    <div class="stats-card">
        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-chart-pie"></i>
        </div>
        <div class="stats-value">{{ $statistik->count() }}</div>
        <div class="stats-label">Total Data {{ $kategoriOptions[$kategori] }}</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-success bg-opacity-10 text-success">
            <i class="fas fa-users"></i>
        </div>
        <div class="stats-value">{{ number_format($statistik->sum('jumlah')) }}</div>
        <div class="stats-label">Total Penduduk</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-info bg-opacity-10 text-info">
            <i class="fas fa-list"></i>
        </div>
        <div class="stats-value">{{ count($kategoriOptions) }}</div>
        <div class="stats-label">Kategori Tersedia</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
            <i class="fas fa-chart-bar"></i>
        </div>
        <div class="stats-value">{{ $statistik->max('jumlah') ?? 0 }}</div>
        <div class="stats-label">Tertinggi</div>
    </div>
</div>

<!-- Category Filter -->
<div class="content-card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter text-primary me-2"></i>
            Filter Kategori Data
        </h3>
        <p class="card-subtitle">Pilih kategori data statistik yang ingin ditampilkan</p>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($kategoriOptions as $key => $label)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('admin.statistik.index', ['kategori' => $key]) }}" 
                       class="category-filter-btn {{ $kategori == $key ? 'active' : '' }}">
                        <div class="category-icon">
                            @switch($key)
                                @case('jenis_kelamin')
                                    <i class="fas fa-users"></i>
                                    @break
                                @case('agama')
                                    <i class="fas fa-pray"></i>
                                    @break
                                @case('pekerjaan')
                                    <i class="fas fa-briefcase"></i>
                                    @break
                                @case('kk')
                                    <i class="fas fa-home"></i>
                                    @break
                                @case('rt_rw')
                                    <i class="fas fa-map-marked-alt"></i>
                                    @break
                                @case('pendidikan')
                                    <i class="fas fa-graduation-cap"></i>
                                    @break
                                @case('kesehatan')
                                    <i class="fas fa-heartbeat"></i>
                                    @break
                                @case('siswa')
                                    <i class="fas fa-user-graduate"></i>
                                    @break
                                @case('klub')
                                    <i class="fas fa-users-cog"></i>
                                    @break
                                @case('kesenian')
                                    <i class="fas fa-palette"></i>
                                    @break
                                @case('sumberair')
                                    <i class="fas fa-tint"></i>
                                    @break
                                @default
                                    <i class="fas fa-chart-bar"></i>
                            @endswitch
                        </div>
                        <div class="category-label">{{ $label }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Main Data Table -->
<div class="content-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="card-title">
                    @switch($kategori)
                        @case('jenis_kelamin')
                            <i class="fas fa-users text-primary me-2"></i>
                            @break
                        @case('agama')
                            <i class="fas fa-pray text-primary me-2"></i>
                            @break
                        @case('pekerjaan')
                            <i class="fas fa-briefcase text-primary me-2"></i>
                            @break
                        @case('kk')
                            <i class="fas fa-home text-primary me-2"></i>
                            @break
                        @case('rt_rw')
                            <i class="fas fa-map-marked-alt text-primary me-2"></i>
                            @break
                        @case('pendidikan')
                            <i class="fas fa-graduation-cap text-primary me-2"></i>
                            @break
                        @case('kesehatan')
                            <i class="fas fa-heartbeat text-primary me-2"></i>
                            @break
                        @case('siswa')
                            <i class="fas fa-user-graduate text-primary me-2"></i>
                            @break
                        @case('klub')
                            <i class="fas fa-users-cog text-primary me-2"></i>
                            @break
                        @case('kesenian')
                            <i class="fas fa-palette text-primary me-2"></i>
                            @break
                        @case('sumberair')
                            <i class="fas fa-tint text-primary me-2"></i>
                            @break
                        @default
                            <i class="fas fa-chart-bar text-primary me-2"></i>
                    @endswitch
                    Data {{ $kategoriOptions[$kategori] }}
                </h3>
                <p class="card-subtitle">Manage data untuk kategori {{ strtolower($kategoriOptions[$kategori]) }}</p>
            </div>
            <div class="badge bg-primary">{{ $statistik->count() }} data</div>
        </div>
    </div>
    
    <div class="card-body">
        @if($statistik->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover modern-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="30%">
                                <i class="fas fa-tag me-1"></i>Label
                            </th>
                            <th width="20%">
                                <i class="fas fa-calculator me-1"></i>Jumlah
                            </th>
                            <th width="30%">
                                <i class="fas fa-sticky-note me-1"></i>Deskripsi
                            </th>
                            <th width="15%" class="text-center">
                                <i class="fas fa-cogs me-1"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistik as $index => $item)
                            <tr>
                                <td class="text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="data-indicator bg-primary bg-opacity-10 text-primary me-3">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                        <strong>{{ $item->label }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success-soft text-success fs-6 fw-bold">
                                        {{ number_format($item->jumlah) }} orang
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ $item->deskripsi ? Str::limit($item->deskripsi, 50) : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.statistik.edit', $item->id) }}" 
                                           class="action-btn edit-btn" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="action-btn delete-btn" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Data"
                                                onclick="deleteData('{{ $item->id }}', '{{ $item->label }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Hidden delete form -->
                                    <form id="delete-form-{{ $item->id }}" 
                                          action="{{ route('admin.statistik.destroy', $item->id) }}" 
                                          method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-footer">
                        <tr>
                            <th colspan="2" class="text-start">Total {{ $kategoriOptions[$kategori] }}</th>
                            <th>
                                <span class="badge bg-primary fs-6 fw-bold">
                                    {{ number_format($statistik->sum('jumlah')) }} orang
                                </span>
                            </th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h4>Belum Ada Data</h4>
                <p>Belum ada data statistik untuk kategori <strong>{{ $kategoriOptions[$kategori] }}</strong>.</p>
                <a href="{{ route('admin.statistik.create', ['kategori' => $kategori]) }}" 
                   class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Data Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Info Box -->
<div class="content-card mt-4">
    <div class="info-box info-box-primary">
        <div class="info-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="info-content">
            <h5>Informasi Penting</h5>
            <ul class="info-list">
                <li>Data statistik ini akan ditampilkan pada chart di halaman utama website</li>
                <li>Pastikan data selalu update dan akurat sesuai kondisi terbaru</li>
                <li>Gunakan deskripsi untuk memberikan informasi tambahan yang dibutuhkan</li>
                <li>Total penduduk akan dihitung otomatis dari semua data yang tersedia</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.category-filter-btn {
    display: block;
    text-decoration: none;
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
    background: white;
    color: var(--dark-color);
}

.category-filter-btn:hover {
    text-decoration: none;
    color: var(--primary-color);
    border-color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.category-filter-btn.active {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-color: var(--primary-color);
    color: white;
}

.category-icon {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.category-label {
    font-weight: 500;
    font-size: 0.875rem;
}

.data-indicator {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
}

.edit-btn {
    background: var(--warning-color);
    color: white;
}

.edit-btn:hover {
    background: #f59e0b;
    color: white;
    text-decoration: none;
    transform: scale(1.1);
}

.delete-btn {
    background: var(--danger-color);
    color: white;
    cursor: pointer;
}

.delete-btn:hover {
    background: #dc2626;
    transform: scale(1.1);
}

.bg-success-soft {
    background: rgba(16, 185, 129, 0.1) !important;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.table-footer th {
    background: var(--light-color);
    font-weight: 600;
    border-top: 2px solid var(--border-color);
}

.info-box {
    display: flex;
    align-items: flex-start;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid;
}

.info-box-primary {
    background: rgba(59, 130, 246, 0.05);
    border-left-color: var(--info-color);
}

.info-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: rgba(59, 130, 246, 0.1);
    color: var(--info-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.info-content h5 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
}

.info-list {
    margin: 0;
    padding-left: 1.25rem;
    color: var(--text-muted);
}

.info-list li {
    margin-bottom: 0.25rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteData(id, label) {
    Swal.fire({
        title: 'Hapus Data?',
        text: `Yakin ingin menghapus data "${label}"? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
