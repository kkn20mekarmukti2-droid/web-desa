@extends('layout.admin-modern')
@section('title', 'Detail Gambar Hero')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👁️ Detail Gambar Hero</h1>
            <p class="page-subtitle">Informasi lengkap: {{ $image->nama_gambar }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.hero-images.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.hero-images.edit', $image->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Gambar
            </a>
        </div>
    </div>
</div>

<!-- Product Detail Card -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-5">
                <div class="product-image-container">
                    @if($image->gambar && file_exists(public_path($image->gambar)))
                    <img src="{{ asset($image->gambar) }}" alt="{{ $image->nama_gambar }}" class="product-image">
                    @elseif($image->gambar && file_exists(public_path('storage/' . $image->gambar)))
                    <img src="{{ asset('storage/' . $image->gambar) }}" alt="{{ $image->nama_gambar }}" class="product-image">
                    @else
                    <div class="no-image">
                        <i class="fas fa-image"></i>
                        <p>Tidak ada gambar</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-md-7">
                <div class="product-details">
                    <!-- Product Name -->
                    <div class="detail-group mb-4">
                        <h2 class="product-title">{{ $image->nama_gambar }}</h2>
                        <div class="product-badge">
                            <i class="fas fa-images"></i>
                            Gambar Slideshow Hero
                        </div>
                    </div>

                    <!-- Description -->
                    @if($image->deskripsi)
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-align-left text-primary"></i>
                            Deskripsi Gambar
                        </h5>
                        <p class="detail-content">{{ $image->deskripsi }}</p>
                    </div>
                    @endif

                    <!-- Order Info -->
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-sort-numeric-up text-success"></i>
                            Informasi Tampil
                        </h5>
                        <div class="contact-info">
                            <span class="phone-number">Urutan: {{ $image->urutan }}</span>
                            <span class="badge {{ $image->is_active ? 'bg-success' : 'bg-danger' }} ms-2">
                                {{ $image->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-clock text-info"></i>
                            Informasi Sistem
                        </h5>
                        <div class="timestamps">
                            <small class="text-muted d-block">
                                <strong>Dibuat:</strong> {{ $image->created_at->format('d/m/Y H:i') }}
                            </small>
                            <small class="text-muted d-block">
                                <strong>Diperbarui:</strong> {{ $image->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('admin.hero-images.edit', $image->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Edit Gambar
                        </a>
                        
                        <button type="button" class="btn btn-danger" onclick="deleteImage({{ $image->id }}, '{{ $image->nama_gambar }}')">
                            <i class="fas fa-trash"></i>
                            Hapus Gambar
                        </button>
                        
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-info">
                            <i class="fas fa-external-link-alt"></i>
                            Lihat di Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Custom Styles -->
<style>
.product-image-container {
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    text-align: center;
    color: #6c757d;
}

.no-image i {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.product-details {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.product-badge {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    display: inline-block;
}

.detail-group {
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 1rem;
}

.detail-group:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.detail-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-content {
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 0;
}

.contact-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.phone-number {
    font-family: monospace;
    background: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 600;
}

.action-buttons {
    margin-top: auto;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.timestamps small {
    line-height: 1.4;
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
    }
}
</style>

<!-- JavaScript -->
<script>
function deleteImage(id, name) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus gambar "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ url('admin/hero-images') }}/${id}`;
            form.submit();
        }
    });
}
</script>

@endsection
