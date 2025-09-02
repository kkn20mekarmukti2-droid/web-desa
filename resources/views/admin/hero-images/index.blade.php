@extends('layout.admin-modern')
@section('title', 'Gambar Hero')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">🖼️ Kelola Gambar Hero</h1>
            <p class="page-subtitle">Manajemen gambar slideshow halaman utama</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.hero-images.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Gambar
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                Lihat Halaman Publik
            </a>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="card">
    <div class="card-body">
        @if($imageList->count() > 0)
        <div class="row g-4">
            @foreach($imageList as $image)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="product-card">
                    <div class="product-image">
                        @if($image->gambar && file_exists(public_path($image->gambar)))
                        <img src="{{ asset($image->gambar) }}" alt="{{ $image->nama_gambar }}">
                        @elseif($image->gambar && file_exists(public_path('storage/' . $image->gambar)))
                        <img src="{{ asset('storage/' . $image->gambar) }}" alt="{{ $image->nama_gambar }}">
                        @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                        </div>
                        @endif
                    </div>
                    
                    <div class="product-info">
                        <h5 class="product-title">{{ $image->nama_gambar }}</h5>
                        <p class="product-description">{{ Str::limit($image->deskripsi ?? 'Tidak ada deskripsi', 100) }}</p>
                        <div class="product-contact">
                            <i class="fas fa-sort-numeric-up text-primary"></i>
                            <span>Urutan: {{ $image->urutan }}</span>
                            <span class="badge {{ $image->is_active ? 'bg-success' : 'bg-danger' }} ms-2">
                                {{ $image->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="product-actions">
                        <div class="btn-group w-100">
                            <a href="{{ route('admin.hero-images.show', $image->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.hero-images.edit', $image->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteImage({{ $image->id }}, '{{ $image->nama_gambar }}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($imageList->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $imageList->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="empty-state text-center py-5">
            <div class="empty-icon mb-3">
                <i class="fas fa-images text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted">Belum Ada Gambar Hero</h4>
            <p class="text-muted mb-4">Mulai tambahkan gambar untuk slideshow halaman utama</p>
            <a href="{{ route('admin.hero-images.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Gambar Pertama
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
function deleteImage(id, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus gambar "${name}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('admin/hero-images') }}/${id}`;
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
