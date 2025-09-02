@extends('layout.admin-modern')
@section('title', 'Kelola Gambar Hero')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">🖼️ Gambar Hero</h1>
            <p class="page-subtitle">Kelola gambar slideshow halaman utama</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.hero-images.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Gambar
            </a>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Products Grid -->
<div class="products-grid">
    @forelse($imageList as $image)
    <div class="product-card">
        <div class="product-image">
            @if($image->gambar && file_exists(public_path($image->gambar)))
                <img src="{{ asset($image->gambar) }}" alt="{{ $image->nama_gambar }}">
            @else
                <div class="no-image">
                    <i class="fas fa-image"></i>
                    <span>No Image</span>
                </div>
            @endif
            
            <div class="product-overlay">
                <div class="product-actions">
                    <a href="{{ route('admin.hero-images.show', $image->id) }}" class="btn-action btn-view" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.hero-images.edit', $image->id) }}" class="btn-action btn-edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.hero-images.destroy', $image->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus gambar {{ $image->nama_gambar }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="product-info">
            <h3 class="product-title">{{ $image->nama_gambar }}</h3>
            <div class="product-meta">
                <div class="product-detail">
                    <span class="detail-label">Urutan:</span>
                    <span class="detail-value">{{ $image->urutan }}</span>
                </div>
                <div class="product-detail">
                    <span class="detail-label">Status:</span>
                    <span class="status-badge {{ $image->is_active ? 'active' : 'inactive' }}">
                        {{ $image->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
            @if($image->deskripsi)
            <p class="product-description">{{ Str::limit($image->deskripsi, 80) }}</p>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-image"></i>
        </div>
        <h3>Belum Ada Gambar Hero</h3>
        <p>Tambahkan gambar untuk slideshow halaman utama</p>
        <a href="{{ route('admin.hero-images.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Gambar Pertama
        </a>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($imageList->hasPages())
<div class="pagination-wrapper">
    {{ $imageList->links() }}
</div>
@endif

@endsection

@section('styles')
<style>
/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f8fafc;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #9ca3af;
    background: linear-gradient(135deg, #f8fafc 0%, #e5e7eb 100%);
}

.no-image i {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: white;
    font-size: 1rem;
}

.btn-view {
    background: #3b82f6;
}

.btn-view:hover {
    background: #2563eb;
    color: white;
    transform: scale(1.1);
}

.btn-edit {
    background: #f59e0b;
}

.btn-edit:hover {
    background: #d97706;
    color: white;
    transform: scale(1.1);
}

.btn-delete {
    background: #ef4444;
}

.btn-delete:hover {
    background: #dc2626;
    transform: scale(1.1);
}

.product-info {
    padding: 1.25rem;
}

.product-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.product-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.product-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

.detail-value {
    font-size: 0.875rem;
    color: #1f2937;
    font-weight: 600;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
}

.status-badge.inactive {
    background: #fef2f2;
    color: #991b1b;
}

.product-description {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.5;
    margin: 0;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem 1rem;
    background: white;
    border-radius: 12px;
    border: 2px dashed #e5e7eb;
}

.empty-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }
    
    .product-actions {
        gap: 0.5rem;
    }
    
    .btn-action {
        width: 36px;
        height: 36px;
        font-size: 0.875rem;
    }
}

@media (max-width: 640px) {
    .products-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
