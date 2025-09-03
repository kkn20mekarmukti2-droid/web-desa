@extends('layout.admin-modern')

@section('title', 'Edit Majalah')

@section('content')
<div class="main-content">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">📚 Edit Majalah: {{ $majalah->judul }}</h1>
            <p class="page-subtitle">Perbarui informasi dan halaman majalah</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.majalah.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('admin.majalah.show', $majalah->id) }}" class="btn btn-info">
                <i class="fas fa-eye me-2"></i>Lihat Detail
            </a>
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Terdapat kesalahan:</strong>
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <!-- Left Column - Magazine Info -->
            <div class="col-lg-4">
                <div class="data-card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-edit me-2"></i>Edit Informasi
                        </h2>
                        <p class="card-subtitle">Perbarui data umum majalah</p>
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ route('admin.majalah.update', $majalah->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Judul Majalah -->
                            <div class="mb-4">
                                <label for="judul" class="form-label fw-semibold">
                                    <i class="fas fa-heading text-primary me-2"></i>Judul Majalah *
                                </label>
                                <input type="text" 
                                       name="judul" 
                                       id="judul"
                                       class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                                       value="{{ old('judul', $majalah->judul) }}"
                                       required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-semibold">
                                    <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                                </label>
                                <textarea name="deskripsi" 
                                          id="deskripsi"
                                          class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                                          rows="4">{{ old('deskripsi', $majalah->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Terbit -->
                            <div class="mb-4">
                                <label for="tanggal_terbit" class="form-label fw-semibold">
                                    <i class="fas fa-calendar text-success me-2"></i>Tanggal Terbit *
                                </label>
                                <input type="date" 
                                       name="tanggal_terbit" 
                                       id="tanggal_terbit"
                                       class="form-control {{ $errors->has('tanggal_terbit') ? 'is-invalid' : '' }}"
                                       value="{{ old('tanggal_terbit', $majalah->tanggal_terbit->format('Y-m-d')) }}"
                                       required>
                                @error('tanggal_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="is_active" 
                                           id="is_active"
                                           value="1"
                                           {{ old('is_active', $majalah->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">
                                        <i class="fas fa-eye text-warning me-2"></i>Publikasikan Majalah
                                    </label>
                                </div>
                            </div>

                            <!-- Current Cover -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-image text-danger me-2"></i>Cover Saat Ini
                                </label>
                                <div class="current-cover mb-3">
                                    <img src="{{ asset('storage/' . $majalah->cover_image) }}" 
                                         alt="Current Cover" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px; max-height: 250px;">
                                </div>
                            </div>

                            <!-- New Cover -->
                            <div class="mb-4">
                                <label for="cover_image" class="form-label fw-semibold">
                                    <i class="fas fa-upload text-danger me-2"></i>Ganti Cover
                                </label>
                                <input type="file" 
                                       name="cover_image" 
                                       id="cover_image"
                                       class="form-control {{ $errors->has('cover_image') ? 'is-invalid' : '' }}"
                                       accept="image/jpeg,image/png,image/jpg">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti cover</small>
                                
                                <!-- New Cover Preview -->
                                <div id="newCoverPreview" class="mt-3" style="display: none;">
                                    <label class="form-label text-success">Cover Baru:</label>
                                    <img id="newCoverImg" src="" alt="New Cover Preview" class="img-thumbnail" style="max-width: 200px; max-height: 250px;">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column - Pages Management -->
            <div class="col-lg-8">
                <div class="data-card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-file-image me-2"></i>Kelola Halaman
                        </h2>
                        <p class="card-subtitle">{{ $majalah->pages->count() }} halaman tersedia</p>
                    </div>
                    
                    <div class="card-body">
                        @if($majalah->pages->count() > 0)
                        <div class="row" id="pagesContainer">
                            @foreach($majalah->pages->sortBy('page_number') as $page)
                            <div class="col-md-3 col-sm-4 col-6 mb-4" data-page-id="{{ $page->id }}">
                                <div class="page-card">
                                    <div class="page-image-container">
                                        <img src="{{ asset('storage/' . $page->image_path) }}" 
                                             alt="Page {{ $page->page_number }}"
                                             class="page-image">
                                        <div class="page-overlay">
                                            <div class="page-actions">
                                                <button type="button" 
                                                        class="btn btn-sm btn-warning edit-page-btn"
                                                        data-page-id="{{ $page->id }}"
                                                        data-title="{{ $page->title }}"
                                                        data-description="{{ $page->description }}"
                                                        title="Edit Halaman">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger delete-page-btn"
                                                        data-page-id="{{ $page->id }}"
                                                        data-page-number="{{ $page->page_number }}"
                                                        title="Hapus Halaman">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page-info">
                                        <div class="page-number">Halaman {{ $page->page_number }}</div>
                                        @if($page->title)
                                            <div class="page-title">{{ $page->title }}</div>
                                        @endif
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
                        </div>
                        @endif

                        <!-- Add New Pages -->
                        <div class="mt-4">
                            <h5><i class="fas fa-plus-circle me-2"></i>Tambah Halaman Baru</h5>
                            <div class="upload-area-small" onclick="document.getElementById('newPages').click()">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Klik untuk upload halaman baru</span>
                            </div>
                            <input type="file" 
                                   id="newPages"
                                   class="d-none"
                                   accept="image/jpeg,image/png,image/jpg"
                                   multiple>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Page Modal -->
<div class="modal fade" id="editPageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Halaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPageForm">
                <div class="modal-body">
                    <input type="hidden" id="editPageId">
                    
                    <div class="mb-3">
                        <label for="pageTitle" class="form-label">Judul Halaman</label>
                        <input type="text" class="form-control" id="pageTitle" placeholder="Opsional">
                    </div>
                    
                    <div class="mb-3">
                        <label for="pageDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="pageDescription" rows="3" placeholder="Opsional"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="pageImage" class="form-label">Ganti Gambar</label>
                        <input type="file" class="form-control" id="pageImage" accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Page Modal -->
<div class="modal fade" id="deletePageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <strong>Halaman <span id="deletePageNumber"></span></strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Halaman yang dihapus tidak dapat dikembalikan!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePage">Hapus Halaman</button>
            </div>
        </div>
    </div>
</div>

<style>
.page-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.page-card:hover {
    transform: translateY(-4px);
}

.page-image-container {
    position: relative;
    overflow: hidden;
}

.page-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.page-overlay {
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

.page-card:hover .page-overlay {
    opacity: 1;
}

.page-actions {
    display: flex;
    gap: 8px;
}

.page-info {
    padding: 12px;
    background: white;
}

.page-number {
    font-weight: bold;
    color: #495057;
    font-size: 0.9rem;
}

.page-title {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 4px;
}

.upload-area-small {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-area-small:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.current-cover img {
    border: 3px solid #28a745;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newCoverInput = document.getElementById('cover_image');
    
    // New cover preview
    newCoverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('newCoverPreview').style.display = 'block';
                document.getElementById('newCoverImg').src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('newCoverPreview').style.display = 'none';
        }
    });

    // Edit page handlers
    document.querySelectorAll('.edit-page-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const pageId = this.dataset.pageId;
            const title = this.dataset.title || '';
            const description = this.dataset.description || '';
            
            document.getElementById('editPageId').value = pageId;
            document.getElementById('pageTitle').value = title;
            document.getElementById('pageDescription').value = description;
            
            new bootstrap.Modal(document.getElementById('editPageModal')).show();
        });
    });

    // Delete page handlers
    let deletePageId = null;
    document.querySelectorAll('.delete-page-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            deletePageId = this.dataset.pageId;
            document.getElementById('deletePageNumber').textContent = this.dataset.pageNumber;
            new bootstrap.Modal(document.getElementById('deletePageModal')).show();
        });
    });

    // Edit page form submission
    document.getElementById('editPageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const pageId = document.getElementById('editPageId').value;
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('title', document.getElementById('pageTitle').value);
        formData.append('description', document.getElementById('pageDescription').value);
        
        const imageFile = document.getElementById('pageImage').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        fetch(`/admin/majalah/page/${pageId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan: ' + data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat menyimpan perubahan');
        });
    });

    // Confirm delete page
    document.getElementById('confirmDeletePage').addEventListener('click', function() {
        if (deletePageId) {
            fetch(`/admin/majalah/page/${deletePageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan saat menghapus halaman');
            });
        }
    });
});
</script>
@endsection
