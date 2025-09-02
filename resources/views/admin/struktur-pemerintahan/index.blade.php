@extends('layout.admin-modern')
@section('title', 'Struktur Pemerintahan')
@section('content')

<!-- Page Header -->
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
            <a href="{{ route('pemerintahan') }}" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                Lihat Halaman Publik
            </a>
        </div>
    </div>
</div>

<!-- Aparatur Grid -->
<div class="card">
    <div class="card-body">
        @if($strukturList->count() > 0)
        <div class="row g-4">
            @foreach($strukturList as $struktur)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="product-card">
                    <div class="product-image">
                        @if($struktur->foto && file_exists(public_path($struktur->foto)))
                        <img src="{{ asset($struktur->foto) }}" alt="{{ $struktur->nama }}">
                        @else
                        <div class="no-image">
                            <i class="fas fa-user"></i>
                        </div>
                        @endif
                    </div>
                    
                    <div class="product-info">
                        <h5 class="product-title">{{ $struktur->nama }}</h5>
                        <p class="product-description">{{ $struktur->jabatan }}</p>
                        <div class="product-contact">
                            @switch($struktur->kategori)
                                @case('kepala_desa')
                                    <span class="badge bg-primary">Kepala Desa</span>
                                    @break
                                @case('sekretaris')
                                    <span class="badge bg-success">Sekretaris</span>
                                    @break
                                @case('kepala_urusan')
                                    <span class="badge bg-warning">Kepala Urusan</span>
                                    @break
                                @case('kepala_seksi')
                                    <span class="badge bg-info">Kepala Seksi</span>
                                    @break
                                @case('kepala_dusun')
                                    <span class="badge bg-secondary">Kepala Dusun</span>
                                    @break
                            @endswitch
                            
                            @if($struktur->is_active)
                                <span class="badge bg-success ms-1">Aktif</span>
                            @else
                                <span class="badge bg-danger ms-1">Tidak Aktif</span>
                            @endif
                        </div>
                        
                        @if($struktur->pendidikan || $struktur->nip)
                        <div class="mt-2">
                            @if($struktur->pendidikan)
                                <small class="text-muted d-block">{{ $struktur->pendidikan }}</small>
                            @endif
                            @if($struktur->nip)
                                <small class="text-muted d-block">NIP: {{ $struktur->nip }}</small>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    <div class="product-actions">
                        <div class="btn-group w-100">
                            <a href="{{ route('admin.struktur-pemerintahan.show', $struktur->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteAparatur({{ $struktur->id }}, '{{ $struktur->nama }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
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

<!-- Delete Confirmation Modal -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Custom Styles - EXACT COPY FROM UMKM -->
<style>
.product-card {
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.product-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-image .no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 2rem;
}

.product-info {
    padding: 1rem;
    flex-grow: 1;
}

.product-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
    font-size: 1.1rem;
}

.product-description {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.product-contact {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.product-actions {
    padding: 0 1rem 1rem;
    margin-top: auto;
}

.empty-state {
    min-height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.empty-icon {
    opacity: 0.5;
}

/* Badge styling */
.badge {
    font-size: 0.75rem;
    font-weight: 500;
}
</style>

<!-- JavaScript -->
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
