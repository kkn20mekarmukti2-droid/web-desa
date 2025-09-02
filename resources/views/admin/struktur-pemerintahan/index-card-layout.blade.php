@extends('layout.admin-modern')
@section('title', 'Kelola Struktur Pemerintahan')
@section('content')

<div class="container-fluid">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">👥 Kelola Struktur Pemerintahan</h1>
                <p class="page-subtitle">Manajemen aparatur pemerintahan Desa Mekarmukti</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.struktur-pemerintahan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Aparatur
                </a>
                <a href="{{ route('strukturorganisasi') }}" class="btn btn-outline-primary" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    Lihat Halaman Publik
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-primary rounded">
                                <i class="fas fa-user-tie text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $strukturList->where('kategori', 'kepala_desa')->count() }}</h6>
                            <p class="text-muted mb-0 small">Kepala Desa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-success rounded">
                                <i class="fas fa-user-graduate text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $strukturList->where('kategori', 'sekretaris')->count() }}</h6>
                            <p class="text-muted mb-0 small">Sekretaris</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-warning rounded">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $strukturList->whereIn('kategori', ['kepala_urusan', 'kepala_seksi'])->count() }}</h6>
                            <p class="text-muted mb-0 small">Kasi & Kaur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-info rounded">
                                <i class="fas fa-map-marked-alt text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $strukturList->where('kategori', 'kepala_dusun')->count() }}</h6>
                            <p class="text-muted mb-0 small">Kepala Dusun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aparatur Cards -->
    <div class="card">
        <div class="card-body">
            @if($strukturList->count() > 0)
            <div class="row g-4">
                @foreach($strukturList as $struktur)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="aparatur-card">
                        <div class="aparatur-image">
                            @if($struktur->foto && file_exists(public_path($struktur->foto)))
                            <img src="{{ asset($struktur->foto) }}" alt="{{ $struktur->nama }}">
                            @else
                            <div class="no-image">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                        </div>
                        
                        <div class="aparatur-info">
                            <h5 class="aparatur-title">{{ $struktur->nama }}</h5>
                            <p class="aparatur-position">{{ $struktur->jabatan }}</p>
                            
                            <div class="aparatur-meta">
                                @switch($struktur->kategori)
                                    @case('kepala_desa')
                                        <span class="badge bg-primary-subtle text-primary">Kepala Desa</span>
                                        @break
                                    @case('sekretaris')
                                        <span class="badge bg-success-subtle text-success">Sekretaris</span>
                                        @break
                                    @case('kepala_urusan')
                                        <span class="badge bg-warning-subtle text-warning">Kepala Urusan</span>
                                        @break
                                    @case('kepala_seksi')
                                        <span class="badge bg-info-subtle text-info">Kepala Seksi</span>
                                        @break
                                    @case('kepala_dusun')
                                        <span class="badge bg-secondary-subtle text-secondary">Kepala Dusun</span>
                                        @break
                                @endswitch
                                
                                @if($struktur->is_active)
                                    <span class="badge bg-success ms-1">Aktif</span>
                                @else
                                    <span class="badge bg-danger ms-1">Tidak Aktif</span>
                                @endif
                            </div>
                            
                            @if($struktur->pendidikan || $struktur->nip)
                            <div class="aparatur-details">
                                @if($struktur->pendidikan)
                                    <small class="text-muted d-block">{{ $struktur->pendidikan }}</small>
                                @endif
                                @if($struktur->nip)
                                    <small class="text-muted d-block">NIP: {{ $struktur->nip }}</small>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        <div class="aparatur-actions">
                            <a href="{{ route('admin.struktur-pemerintahan.show', $struktur->id) }}" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                    onclick="deleteAparatur({{ $struktur->id }}, '{{ $struktur->nama }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($strukturList->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $strukturList->links() }}
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="empty-state text-center py-5">
                <div class="empty-icon mb-3">
                    <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-muted">Belum Ada Aparatur Pemerintahan</h4>
                <p class="text-muted mb-4">Mulai tambahkan data aparatur pemerintahan Desa Mekarmukti</p>
                <a href="{{ route('admin.struktur-pemerintahan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Aparatur Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('styles')
<style>
/* Card Layout - Same structure as UMKM Products */
.aparatur-card {
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.aparatur-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

/* Image Section - Same as UMKM */
.aparatur-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.aparatur-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.aparatur-image .no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 2rem;
}

/* Info Section */
.aparatur-info {
    padding: 1rem;
    flex-grow: 1;
}

.aparatur-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
    font-size: 1.1rem;
}

.aparatur-position {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.aparatur-meta {
    margin-bottom: 0.75rem;
}

.aparatur-details {
    font-size: 0.85rem;
    color: var(--text-muted);
}

/* Actions */
.aparatur-actions {
    padding: 0 1rem 1rem;
    margin-top: auto;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.aparatur-actions .btn {
    flex: 1;
    min-width: 0;
}

/* Stats Cards */
.avatar-sm {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

/* Empty State */
.empty-state {
    min-height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.empty-icon {
    opacity: 0.5;
}

/* Badge Styling */
.badge {
    font-weight: 500;
    font-size: 0.75rem;
}

/* Responsive */
@media (max-width: 768px) {
    .aparatur-actions {
        flex-direction: column;
    }
    
    .aparatur-actions .btn {
        width: 100%;
    }
}
</style>
@endsection

@section('scripts')
<script>
function deleteAparatur(id, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus aparatur "${name}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('admin/struktur-pemerintahan') }}/${id}`;
        form.submit();
    }
}

// Success/Error Messages
@if(session('success'))
    alert('✅ {{ session('success') }}');
@endif

@if(session('error'))
    alert('❌ {{ session('error') }}');
@endif
</script>
@endsection
