@extends('layout.admin-modern')

@section('title', 'Detail Majalah')

@section('content')
<div class="main-content">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">📚 {{ $majalah->judul }}</h1>
            <p class="page-subtitle">
                Diterbitkan {{ $majalah->tanggal_terbit->format('d F Y') }} • 
                {{ $majalah->total_pages }} halaman •
                <span class="badge bg-{{ $majalah->is_active ? 'success' : 'secondary' }}">
                    {{ $majalah->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.majalah.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('admin.majalah.edit', $majalah->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('majalah.desa') }}#majalah-{{ $majalah->id }}" 
               class="btn btn-success" 
               target="_blank">
                <i class="fas fa-external-link-alt me-2"></i>Lihat Public
            </a>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="row">
            <!-- Left Column - Magazine Info -->
            <div class="col-lg-4">
                <div class="data-card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-info-circle me-2"></i>Informasi Majalah
                        </h2>
                    </div>
                    
                    <div class="card-body text-center">
                        <!-- Cover Image -->
                        <div class="magazine-cover mb-4">
                            <img src="{{ asset('storage/' . $majalah->cover_image) }}" 
                                 alt="Cover {{ $majalah->judul }}"
                                 class="img-fluid rounded shadow-lg"
                                 style="max-height: 400px;">
                        </div>

                        <!-- Magazine Stats -->
                        <div class="magazine-stats">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-primary">{{ $majalah->total_pages }}</h4>
                                        <small class="text-muted">Halaman</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-success">{{ $majalah->tanggal_terbit->format('M') }}</h4>
                                        <small class="text-muted">{{ $majalah->tanggal_terbit->format('Y') }}</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-{{ $majalah->is_active ? 'success' : 'danger' }}">
                                            <i class="fas fa-{{ $majalah->is_active ? 'eye' : 'eye-slash' }}"></i>
                                        </h4>
                                        <small class="text-muted">Status</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="quick-actions mt-4">
                            <div class="d-grid gap-2">
                                <button type="button" 
                                        class="btn btn-outline-primary toggle-status"
                                        data-id="{{ $majalah->id }}"
                                        data-status="{{ $majalah->is_active }}">
                                    <i class="fas fa-{{ $majalah->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                                    {{ $majalah->is_active ? 'Nonaktifkan' : 'Aktifkan' }} Majalah
                                </button>
                                <a href="{{ route('admin.majalah.edit', $majalah->id) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Majalah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                @if($majalah->deskripsi)
                <div class="data-card mt-4">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-align-left me-2"></i>Deskripsi
                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $majalah->deskripsi }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Pages -->
            <div class="col-lg-8">
                <div class="data-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="card-title">
                                <i class="fas fa-file-image me-2"></i>Halaman Majalah
                            </h2>
                            <p class="card-subtitle">Preview halaman dalam majalah</p>
                        </div>
                        <div class="view-toggle">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary active" id="gridView">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="listView">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        @if($majalah->pages->count() > 0)
                        <!-- Grid View -->
                        <div id="pagesGrid" class="pages-container">
                            <div class="row">
                                @foreach($majalah->pages->sortBy('page_number') as $page)
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="page-preview-card" data-page="{{ $page->page_number }}">
                                        <div class="page-image-wrapper">
                                            <img src="{{ asset('storage/' . $page->image_path) }}" 
                                                 alt="Page {{ $page->page_number }}"
                                                 class="page-preview-image"
                                                 onclick="openPageModal('{{ asset('storage/' . $page->image_path) }}', {{ $page->page_number }})">
                                            <div class="page-number-badge">{{ $page->page_number }}</div>
                                        </div>
                                        <div class="page-preview-info">
                                            <h6 class="page-title">
                                                {{ $page->title ?: 'Halaman ' . $page->page_number }}
                                            </h6>
                                            @if($page->description)
                                                <p class="page-description">{{ Str::limit($page->description, 60) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- List View -->
                        <div id="pagesList" class="pages-container" style="display: none;">
                            @foreach($majalah->pages->sortBy('page_number') as $page)
                            <div class="page-list-item mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ asset('storage/' . $page->image_path) }}" 
                                             alt="Page {{ $page->page_number }}"
                                             class="img-thumbnail page-list-thumb"
                                             onclick="openPageModal('{{ asset('storage/' . $page->image_path) }}', {{ $page->page_number }})">
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="mb-1">{{ $page->title ?: 'Halaman ' . $page->page_number }}</h6>
                                        @if($page->description)
                                            <p class="text-muted mb-1 small">{{ $page->description }}</p>
                                        @endif
                                        <small class="text-muted">
                                            Halaman {{ $page->page_number }} • 
                                            Diupload {{ $page->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <span class="badge bg-primary">Hal. {{ $page->page_number }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="empty-state">
                            <i class="fas fa-file-image empty-icon"></i>
                            <h4>Belum Ada Halaman</h4>
                            <p>Belum ada halaman yang diupload untuk majalah ini.</p>
                            <a href="{{ route('admin.majalah.edit', $majalah->id) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Halaman
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Modal -->
<div class="modal fade" id="pageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pageModalTitle">Halaman 1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="pageModalImage" src="" alt="Page" class="img-fluid rounded">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="downloadPage">
                    <i class="fas fa-download me-2"></i>Download
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.magazine-cover img {
    transition: transform 0.3s ease;
}

.magazine-cover img:hover {
    transform: scale(1.05);
}

.stat-item h4 {
    margin-bottom: 0;
    font-weight: bold;
}

.page-preview-card {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

.page-preview-card:hover {
    border-color: #007bff;
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.page-image-wrapper {
    position: relative;
    overflow: hidden;
}

.page-preview-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.page-preview-card:hover .page-preview-image {
    transform: scale(1.1);
}

.page-number-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: bold;
}

.page-preview-info {
    padding: 15px;
    background: white;
}

.page-title {
    margin-bottom: 8px;
    font-weight: 600;
    color: #495057;
}

.page-description {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0;
}

.page-list-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: background-color 0.2s ease;
}

.page-list-item:hover {
    background: #e9ecef;
}

.page-list-thumb {
    width: 80px;
    height: 100px;
    object-fit: cover;
    cursor: pointer;
}

.view-toggle .btn.active {
    background-color: #007bff;
    color: white;
}

.quick-actions .btn {
    border-radius: 8px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    const pagesGrid = document.getElementById('pagesGrid');
    const pagesList = document.getElementById('pagesList');

    gridViewBtn.addEventListener('click', function() {
        pagesGrid.style.display = 'block';
        pagesList.style.display = 'none';
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
    });

    listViewBtn.addEventListener('click', function() {
        pagesGrid.style.display = 'none';
        pagesList.style.display = 'block';
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
    });

    // Toggle status
    document.querySelector('.toggle-status')?.addEventListener('click', function() {
        const id = this.dataset.id;
        const currentStatus = this.dataset.status === '1';
        
        fetch(`/admin/majalah/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan saat mengubah status');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat mengubah status');
        });
    });
});

// Open page modal
function openPageModal(imageSrc, pageNumber) {
    document.getElementById('pageModalTitle').textContent = `Halaman ${pageNumber}`;
    document.getElementById('pageModalImage').src = imageSrc;
    
    // Set download link
    document.getElementById('downloadPage').onclick = function() {
        const link = document.createElement('a');
        link.href = imageSrc;
        link.download = `halaman-${pageNumber}.jpg`;
        link.click();
    };
    
    new bootstrap.Modal(document.getElementById('pageModal')).show();
}
</script>
@endsection
