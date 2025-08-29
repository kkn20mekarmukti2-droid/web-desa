@extends('layout.admin-modern')

@section('title', 'Kelola Gallery')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">🖼️ Kelola Gallery</h1>
            <p class="page-subtitle">Kelola foto dan album gallery dengan interface yang modern dan user-friendly</p>
        </div>
        <div class="page-actions">
            <button onclick="openUploadModal()" class="btn btn-outline-primary">
                <i class="fas fa-images"></i>
                Upload Multiple
            </button>
            <button onclick="openUploadModal(true)" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Foto
            </button>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="stats-grid mb-4">
    <div class="stats-card">
        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-images"></i>
        </div>
        <div class="stats-value">{{ $gallery->count() }}</div>
        <div class="stats-label">Total Foto</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-success bg-opacity-10 text-success">
            <i class="fas fa-folder"></i>
        </div>
        <div class="stats-value">{{ $gallery->groupBy('album')->count() }}</div>
        <div class="stats-label">Album</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-info bg-opacity-10 text-info">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stats-value">{{ $gallery->where('created_at', '>=', now()->subDays(7))->count() }}</div>
        <div class="stats-label">Foto Minggu Ini</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
            <i class="fas fa-hdd"></i>
        </div>
        <div class="stats-value" id="storageUsed">Calculating...</div>
        <div class="stats-label">Storage Used</div>
    </div>
</div>

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari foto..." id="searchInput">
                </div>
            </div>
            
            <div class="col-md-3 mb-3 mb-md-0">
                <select class="form-select" id="albumFilter">
                    <option value="">Semua Album</option>
                    @foreach($gallery->groupBy('album') as $album => $photos)
                        <option value="{{ $album }}">{{ $album ?: 'No Album' }} ({{ $photos->count() }})</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2 mb-3 mb-md-0">
                <select class="form-select" id="sortBy">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="name">Nama A-Z</option>
                    <option value="size">Ukuran</option>
                </select>
            </div>
            
            <div class="col-md-3 text-end">
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-secondary" onclick="setViewMode('grid')" id="gridViewBtn">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="btn btn-outline-secondary active" onclick="setViewMode('list')" id="listViewBtn">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Content -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
            <i class="fas fa-photo-video me-2"></i>
            Gallery Photos
        </h5>
        <div class="d-flex align-items-center gap-3">
            <small class="text-muted" id="photoCount">{{ $gallery->count() }} foto</small>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-cog"></i>
                    Actions
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="selectAll()">Select All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="deselectAll()">Deselect All</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteSelected()">Delete Selected</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div id="galleryContainer" class="gallery-list">
            @forelse ($gallery as $item)
            <div class="gallery-item" 
                 data-album="{{ strtolower($item->album ?: 'no album') }}"
                 data-name="{{ strtolower($item->judul) }}"
                 data-date="{{ $item->created_at }}"
                 data-size="{{ $item->file_size ?? 0 }}">
                
                <div class="gallery-item-content">
                    <!-- Selection Checkbox -->
                    <div class="gallery-select">
                        <input type="checkbox" class="form-check-input gallery-checkbox" value="{{ $item->id }}">
                    </div>
                    
                    <!-- Image Thumbnail -->
                    <div class="gallery-thumbnail">
                        <div class="image-container">
                            <img src="{{ asset('gallery/' . $item->gambar) }}" 
                                 alt="{{ $item->judul }}"
                                 class="gallery-image"
                                 onclick="openImageModal('{{ asset('gallery/' . $item->gambar) }}', '{{ $item->judul }}')">
                            <div class="image-overlay">
                                <button class="btn btn-light btn-sm" onclick="openImageModal('{{ asset('gallery/' . $item->gambar) }}', '{{ $item->judul }}')">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image Info -->
                    <div class="gallery-info">
                        <div class="gallery-details">
                            <h6 class="gallery-title mb-1">{{ $item->judul }}</h6>
                            <div class="gallery-meta">
                                <span class="badge badge-primary mb-2">{{ $item->album ?: 'No Album' }}</span>
                                <div class="d-flex flex-wrap gap-2 text-sm text-muted">
                                    <span>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $item->created_at->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-file-image me-1"></i>
                                        {{ strtoupper(pathinfo($item->gambar, PATHINFO_EXTENSION)) }}
                                    </span>
                                    @if(isset($item->file_size))
                                    <span>
                                        <i class="fas fa-weight me-1"></i>
                                        {{ $item->file_size > 1024 ? round($item->file_size/1024, 1).'MB' : $item->file_size.'KB' }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="gallery-actions">
                            <div class="btn-group btn-group-sm">
                                <button onclick="editGalleryItem({{ $item->id }}, '{{ addslashes($item->judul) }}', '{{ $item->album }}')"
                                    class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <button onclick="downloadImage('{{ asset('gallery/' . $item->gambar) }}', '{{ $item->judul }}')"
                                    class="btn btn-outline-info" title="Download">
                                    <i class="fas fa-download"></i>
                                </button>
                                
                                <button onclick="deleteGalleryItem({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                    class="btn btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-images fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-muted mb-2">Gallery masih kosong</h4>
                <p class="text-muted mb-4">Mulai upload foto pertama untuk gallery website desa Anda</p>
                <button onclick="openUploadModal(true)" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Upload Foto Pertama
                </button>
            </div>
            @endforelse
        </div>
        
        <!-- No Results -->
        <div id="noResults" class="text-center py-5" style="display: none;">
            <div class="mb-4">
                <i class="fas fa-search fa-4x text-muted opacity-50"></i>
            </div>
            <h4 class="text-muted mb-2">Tidak ada foto yang cocok</h4>
            <p class="text-muted">Coba gunakan kata kunci atau filter yang berbeda</p>
        </div>
    </div>
    
    @if($gallery->count() > 0)
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">
                <span id="visibleCount">{{ $gallery->count() }}</span> dari {{ $gallery->count() }} foto
            </span>
            <div class="d-flex align-items-center gap-2">
                <small class="text-muted">Storage:</small>
                <div class="progress" style="width: 100px; height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%"></div>
                </div>
                <small class="text-muted">25%</small>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">
                    <i class="fas fa-cloud-upload-alt me-2"></i>
                    Upload Foto Gallery
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadForm" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- File Upload Area -->
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                    <h5 class="mb-2">Drop files here or click to upload</h5>
                                    <p class="text-muted mb-3">Support: JPG, JPEG, PNG, GIF (Max: 5MB per file)</p>
                                    <input type="file" id="fileInput" name="photos[]" multiple accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                                        Choose Files
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Preview Area -->
                            <div id="previewArea" class="preview-area mt-3" style="display: none;">
                                <h6 class="fw-bold mb-3">Preview Upload:</h6>
                                <div id="previewContainer" class="preview-container"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Album Selection -->
                            <div class="mb-3">
                                <label for="albumSelect" class="form-label">Album</label>
                                <select class="form-select" id="albumSelect" name="album">
                                    <option value="">Pilih Album</option>
                                    @foreach($gallery->groupBy('album') as $album => $photos)
                                        @if($album)
                                        <option value="{{ $album }}">{{ $album }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- New Album -->
                            <div class="mb-3">
                                <label for="newAlbum" class="form-label">Atau Buat Album Baru</label>
                                <input type="text" class="form-control" id="newAlbum" name="new_album" placeholder="Nama album baru...">
                            </div>
                            
                            <!-- Upload Settings -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="autoResize" name="auto_resize" checked>
                                    <label class="form-check-label" for="autoResize">
                                        Auto resize gambar besar
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="generateThumbnail" name="generate_thumbnail" checked>
                                    <label class="form-check-label" for="generateThumbnail">
                                        Generate thumbnail
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="uploadBtn">
                        <i class="fas fa-upload me-2"></i>
                        Upload Photos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Edit Foto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Judul Foto</label>
                        <input type="text" class="form-control" id="editTitle" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAlbum" class="form-label">Album</label>
                        <input type="text" class="form-control" id="editAlbum" name="album">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Hidden Delete Forms -->
@foreach ($gallery as $item)
<form id="deleteForm{{ $item->id }}" action="{{ route('gallery.delete', $item->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endforeach

@endsection

@push('styles')
<style>
    /* Gallery Grid/List Styles */
    .gallery-list .gallery-item {
        border-bottom: 1px solid #eee;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .gallery-list .gallery-item:hover {
        background: rgba(102, 126, 234, 0.02);
    }
    
    .gallery-item-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .gallery-select {
        flex-shrink: 0;
    }
    
    .gallery-thumbnail {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
    }
    
    .image-container {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
    }
    
    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .image-container:hover .gallery-image {
        transform: scale(1.05);
    }
    
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .image-container:hover .image-overlay {
        opacity: 1;
    }
    
    .gallery-info {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .gallery-title {
        color: #333;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }
    
    .gallery-meta .text-sm {
        font-size: 0.875rem;
    }
    
    .gallery-actions .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 1px;
    }
    
    /* Grid View Styles */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }
    
    .gallery-grid .gallery-item {
        border: 1px solid #eee;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
    }
    
    .gallery-grid .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .gallery-grid .gallery-item-content {
        flex-direction: column;
        align-items: stretch;
        gap: 0;
    }
    
    .gallery-grid .gallery-thumbnail {
        width: 100%;
        height: 200px;
    }
    
    .gallery-grid .gallery-select {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
    }
    
    .gallery-grid .gallery-info {
        padding: 1rem;
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }
    
    /* Upload Area Styles */
    .upload-area {
        border: 2px dashed #ddd;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    
    .upload-area:hover, .upload-area.dragover {
        border-color: var(--primary-color);
        background: rgba(102, 126, 234, 0.05);
    }
    
    .upload-area.dragover {
        transform: scale(1.02);
    }
    
    /* Preview Area Styles */
    .preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        max-height: 300px;
        overflow-y: auto;
    }
    
    .preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #eee;
    }
    
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .preview-item .remove-preview {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Animations */
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .gallery-item-content {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }
        
        .gallery-info {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }
        
        .gallery-actions {
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let currentViewMode = 'list';
    let selectedFiles = [];

    // View Mode Toggle
    function setViewMode(mode) {
        currentViewMode = mode;
        const container = document.getElementById('galleryContainer');
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');
        
        if (mode === 'grid') {
            container.className = 'gallery-grid';
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        } else {
            container.className = 'gallery-list';
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
        }
    }

    // Search and Filter Functions
    document.getElementById('searchInput').addEventListener('input', function() {
        filterGallery();
    });

    document.getElementById('albumFilter').addEventListener('change', function() {
        filterGallery();
    });

    document.getElementById('sortBy').addEventListener('change', function() {
        sortGallery();
    });

    function filterGallery() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const albumFilter = document.getElementById('albumFilter').value.toLowerCase();
        const items = document.querySelectorAll('.gallery-item');
        let visibleCount = 0;

        items.forEach(item => {
            const name = item.dataset.name;
            const album = item.dataset.album;
            
            const matchesSearch = !searchTerm || name.includes(searchTerm);
            const matchesAlbum = !albumFilter || album === albumFilter;

            if (matchesSearch && matchesAlbum) {
                item.style.display = 'block';
                item.classList.add('fade-in-up');
                visibleCount++;
            } else {
                item.style.display = 'none';
                item.classList.remove('fade-in-up');
            }
        });

        // Update counts
        document.getElementById('visibleCount').textContent = visibleCount;
        document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
    }

    function sortGallery() {
        const sortBy = document.getElementById('sortBy').value;
        const container = document.getElementById('galleryContainer');
        const items = Array.from(container.children);

        items.sort((a, b) => {
            switch (sortBy) {
                case 'newest':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'oldest':
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'size':
                    return parseInt(b.dataset.size) - parseInt(a.dataset.size);
                default:
                    return 0;
            }
        });

        // Re-append sorted items
        items.forEach(item => container.appendChild(item));
    }

    // Selection Functions
    function selectAll() {
        const checkboxes = document.querySelectorAll('.gallery-checkbox');
        checkboxes.forEach(cb => cb.checked = true);
        updateSelectionCount();
    }

    function deselectAll() {
        const checkboxes = document.querySelectorAll('.gallery-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        updateSelectionCount();
    }

    function updateSelectionCount() {
        const selected = document.querySelectorAll('.gallery-checkbox:checked').length;
        // Update UI to show selection count
    }

    function deleteSelected() {
        const selected = Array.from(document.querySelectorAll('.gallery-checkbox:checked'))
                             .map(cb => cb.value);
        
        if (selected.length === 0) {
            showToast('Pilih foto yang ingin dihapus terlebih dahulu', 'warning');
            return;
        }

        if (confirm(`Apakah Anda yakin ingin menghapus ${selected.length} foto yang dipilih?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            showLoading();
            // Submit form for bulk delete
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("gallery.bulk-delete") }}';
            form.innerHTML = `
                @csrf
                @method('DELETE')
                <input type="hidden" name="ids" value="${selected.join(',')}" />
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Modal Functions
    function openUploadModal(single = false) {
        const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        document.getElementById('fileInput').multiple = !single;
        modal.show();
    }

    function openImageModal(src, title) {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        document.getElementById('previewImage').src = src;
        document.getElementById('imageModalLabel').textContent = title;
        modal.show();
    }

    function editGalleryItem(id, title, album) {
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        document.getElementById('editForm').action = `/admin/gallery/${id}`;
        document.getElementById('editTitle').value = title;
        document.getElementById('editAlbum').value = album || '';
        modal.show();
    }

    function deleteGalleryItem(id, title) {
        if (confirm(`Apakah Anda yakin ingin menghapus foto "${title}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            showLoading();
            document.getElementById('deleteForm' + id).submit();
        }
    }

    function downloadImage(url, filename) {
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // File Upload Functions
    document.getElementById('fileInput').addEventListener('change', function(e) {
        selectedFiles = Array.from(e.target.files);
        showPreview();
    });

    // Drag and Drop
    const uploadArea = document.getElementById('uploadArea');

    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
        selectedFiles = files;
        
        // Update file input
        const dt = new DataTransfer();
        files.forEach(file => dt.items.add(file));
        document.getElementById('fileInput').files = dt.files;
        
        showPreview();
    });

    function showPreview() {
        const previewArea = document.getElementById('previewArea');
        const previewContainer = document.getElementById('previewContainer');
        
        if (selectedFiles.length === 0) {
            previewArea.style.display = 'none';
            return;
        }

        previewArea.style.display = 'block';
        previewContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}">
                    <button type="button" class="remove-preview" onclick="removePreview(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }

    function removePreview(index) {
        selectedFiles.splice(index, 1);
        
        // Update file input
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        document.getElementById('fileInput').files = dt.files;
        
        showPreview();
    }

    // Form Submission
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            showToast('Pilih file yang ingin diupload terlebih dahulu', 'warning');
            return;
        }

        const uploadBtn = document.getElementById('uploadBtn');
        uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';
        uploadBtn.disabled = true;
        
        showLoading();
    });

    // Calculate Storage Used
    function calculateStorageUsed() {
        // This would typically be done server-side
        const storageElement = document.getElementById('storageUsed');
        let totalSize = 0;
        
        // Calculate based on visible gallery items
        document.querySelectorAll('.gallery-item').forEach(item => {
            const size = parseInt(item.dataset.size) || 0;
            totalSize += size;
        });
        
        if (totalSize > 1024 * 1024) {
            storageElement.textContent = (totalSize / (1024 * 1024)).toFixed(1) + ' GB';
        } else if (totalSize > 1024) {
            storageElement.textContent = (totalSize / 1024).toFixed(1) + ' MB';
        } else {
            storageElement.textContent = totalSize + ' KB';
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            tooltipTriggerEl.setAttribute('data-bs-toggle', 'tooltip');
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Calculate initial storage
        setTimeout(calculateStorageUsed, 100);

        // Add event listeners for checkboxes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('gallery-checkbox')) {
                updateSelectionCount();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey) {
                switch (e.key) {
                    case 'f':
                        e.preventDefault();
                        document.getElementById('searchInput').focus();
                        break;
                    case 'a':
                        e.preventDefault();
                        selectAll();
                        break;
                    case 'u':
                        e.preventDefault();
                        openUploadModal(true);
                        break;
                }
            }
        });
    });
</script>
@endpush
