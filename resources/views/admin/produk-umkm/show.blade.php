@extends('layout.admin-modern')
@section('title', 'Detail Produk UMKM')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👁️ Detail Produk UMKM</h1>
            <p class="page-subtitle">Informasi lengkap: {{ $produk->nama_produk }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.produk-umkm.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.produk-umkm.edit', $produk->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Produk
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
                    @if($produk->gambar && file_exists(public_path($produk->gambar)))
                    <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="product-image">
                    @elseif($produk->gambar && file_exists(public_path('storage/' . $produk->gambar)))
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="product-image">
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
                        <h2 class="product-title">{{ $produk->nama_produk }}</h2>
                        <div class="product-badge">
                            <i class="fas fa-store"></i>
                            Produk UMKM Desa Mekarmukti
                        </div>
                    </div>

                    <!-- Price Information -->
                    @if($produk->harga)
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-tags text-success"></i>
                            Informasi Harga
                        </h5>
                        <div class="price-display bg-light rounded p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <span class="price-amount">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    <span class="price-unit text-muted">/{{ $produk->satuan }}</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i>
                                        Harga Tersedia
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-tags text-warning"></i>
                            Informasi Harga
                        </h5>
                        <div class="price-display bg-light rounded p-3">
                            <div class="text-center text-muted">
                                <i class="fas fa-phone text-primary"></i>
                                <span class="ms-2">Hubungi penjual untuk info harga</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Description -->
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-align-left text-primary"></i>
                            Deskripsi Produk
                        </h5>
                        <p class="detail-content">{{ $produk->deskripsi }}</p>
                    </div>

                    <!-- Contact Info -->
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fab fa-whatsapp text-success"></i>
                            Informasi Kontak
                        </h5>
                        <div class="contact-info">
                            <span class="phone-number">{{ $produk->nomor_telepon }}</span>
                            <a href="https://wa.me/{{ $produk->nomor_telepon }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($produk->nama_produk) }}%20dari%20UMKM%20Desa%20Mekarmukti{{ $produk->harga ? '%20dengan%20harga%20Rp%20' . number_format($produk->harga, 0, ',', '.') . '/' . $produk->satuan : '' }}" 
                               target="_blank" 
                               class="btn btn-success btn-sm ms-2">
                                <i class="fab fa-whatsapp"></i>
                                {{ $produk->harga ? 'Pesan Sekarang' : 'Chat Sekarang' }}
                            </a>
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
                                <strong>Dibuat:</strong> {{ $produk->created_at->format('d/m/Y H:i') }}
                            </small>
                            <small class="text-muted d-block">
                                <strong>Diperbarui:</strong> {{ $produk->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('admin.produk-umkm.edit', $produk->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Edit Produk
                        </a>
                        
                        <button type="button" class="btn btn-danger" onclick="deleteProduct({{ $produk->id }}, '{{ $produk->nama_produk }}')">
                            <i class="fas fa-trash"></i>
                            Hapus Produk
                        </button>
                        
                        <a href="https://wa.me/{{ $produk->nomor_telepon }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($produk->nama_produk) }}%20dari%20UMKM%20Desa%20Mekarmukti" 
                           target="_blank" 
                           class="btn btn-success">
                            <i class="fab fa-whatsapp"></i>
                            Hubungi Penjual
                        </a>
                        
                        <a href="{{ route('potensidesa') }}" target="_blank" class="btn btn-outline-info">
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
function deleteProduct(id, name) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus produk "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ url('admin/produk-umkm') }}/${id}`;
            form.submit();
        }
    });
}
</script>

@endsection
