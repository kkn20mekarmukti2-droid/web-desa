@extends('layout.admin-modern')
@section('title', 'Produk UMKM')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">🏪 Kelola Produk UMKM</h1>
            <p class="page-subtitle">Manajemen produk unggulan UMKM Desa Mekarmukti</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.produk-umkm.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Produk
            </a>
            <a href="{{ route('potensidesa') }}" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                Lihat Halaman Publik
            </a>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="card">
    <div class="card-body">
        @if($produkList->count() > 0)
        <div class="row g-4">
            @foreach($produkList as $produk)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="product-card">
                    <div class="product-image">
                        @if($produk->gambar && file_exists(public_path($produk->gambar)))
                        <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama_produk }}">
                        @elseif($produk->gambar && file_exists(public_path('storage/' . $produk->gambar)))
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}">
                        @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                        </div>
                        @endif
                    </div>
                    
                    <div class="product-info">
                        <h5 class="product-title">{{ $produk->nama_produk }}</h5>
                        <p class="product-description">{{ Str::limit($produk->deskripsi, 80) }}</p>
                        
                        @if($produk->harga)
                        <div class="product-price mb-2">
                            <div class="d-flex align-items-center justify-content-between bg-light rounded p-2">
                                <small class="text-muted">
                                    <i class="fas fa-tags text-success me-1"></i>
                                    Harga
                                </small>
                                <div>
                                    <span class="fw-bold text-success">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    <small class="text-muted">/{{ $produk->satuan }}</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="product-contact">
                            <i class="fab fa-whatsapp text-success"></i>
                            <span>{{ $produk->nomor_telepon }}</span>
                        </div>
                    </div>
                    
                    <div class="product-actions">
                        <div class="btn-group w-100">
                            <a href="{{ route('admin.produk-umkm.show', $produk->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.produk-umkm.edit', $produk->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteProduct({{ $produk->id }}, '{{ $produk->nama_produk }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                        <a href="https://wa.me/{{ $produk->nomor_telepon }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($produk->nama_produk) }}%20dari%20UMKM%20Desa%20Mekarmukti" 
                           target="_blank" class="btn btn-success btn-sm w-100 mt-2">
                            <i class="fab fa-whatsapp"></i> Hubungi Penjual
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($produkList->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $produkList->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="empty-state text-center py-5">
            <div class="empty-icon mb-3">
                <i class="fas fa-store text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted">Belum Ada Produk UMKM</h4>
            <p class="text-muted mb-4">Mulai tambahkan produk unggulan UMKM Desa Mekarmukti</p>
            <a href="{{ route('admin.produk-umkm.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Produk Pertama
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

<!-- Custom Styles -->
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
</style>

<!-- JavaScript -->
<script>
function deleteProduct(id, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus produk "${name}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('admin/produk-umkm') }}/${id}`;
        form.submit();
    }
}

// Success/Error Messages
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 3000
    });
@endif
</script>

@endsection
