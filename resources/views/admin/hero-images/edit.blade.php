@extends('layout.admin-modern')
@section('title', 'Edit Gambar Hero')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">✏️ Edit Gambar Hero</h1>
            <p class="page-subtitle">Update gambar: {{ $heroImage->nama_gambar }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.hero-images.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.hero-images.update', $heroImage->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Nama Gambar -->
                    <div class="form-group mb-3">
                        <label for="nama_gambar" class="form-label">Nama Gambar <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="nama_gambar" 
                               id="nama_gambar" 
                               class="form-control @error('nama_gambar') is-invalid @enderror" 
                               value="{{ old('nama_gambar', $heroImage->nama_gambar) }}" 
                               placeholder="Masukkan nama gambar hero"
                               required>
                        @error('nama_gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" 
                                  id="deskripsi" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="3" 
                                  placeholder="Deskripsikan gambar (opsional)...">{{ old('deskripsi', $heroImage->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Urutan -->
                    <div class="form-group mb-3">
                        <label for="urutan" class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="urutan" 
                               id="urutan" 
                               class="form-control @error('urutan') is-invalid @enderror" 
                               value="{{ old('urutan', $heroImage->urutan) }}" 
                               min="1"
                               required>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            Urutan tampil dalam slideshow (1 = pertama)
                        </small>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div class="form-group mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   class="form-check-input" 
                                   value="1" 
                                   {{ old('is_active', $heroImage->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Aktifkan Gambar</strong>
                            </label>
                            <small class="form-text text-muted d-block">
                                Gambar aktif akan ditampilkan dalam slideshow
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Upload Gambar -->
                    <div class="form-group mb-3">
                        <label for="gambar" class="form-label">Gambar Hero</label>
                        <div class="upload-area" onclick="document.getElementById('gambar').click();">
                            @if($heroImage->gambar && file_exists(public_path($heroImage->gambar)))
                            <img src="{{ asset($heroImage->gambar) }}" id="preview" class="preview-image">
                            @elseif($heroImage->gambar && file_exists(public_path('storage/' . $heroImage->gambar)))
                            <img src="{{ asset('storage/' . $heroImage->gambar) }}" id="preview" class="preview-image">
                            @else
                            <div class="upload-content">
                                <i class="fas fa-camera mb-2"></i>
                                <p class="mb-1">Klik untuk upload gambar</p>
                                <small class="text-muted">JPG, PNG, GIF (Max: 2MB)</small>
                            </div>
                            <img id="preview" class="preview-image" style="display: none;">
                            @endif
                            
                            @if($heroImage->gambar)
                            <div class="upload-overlay">
                                <i class="fas fa-camera"></i>
                                <p>Klik untuk ganti gambar</p>
                            </div>
                            @endif
                        </div>
                        <input type="file" 
                               name="gambar" 
                               id="gambar" 
                               class="form-control d-none @error('gambar') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this)">
                        @error('gambar')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Image Info -->
                    @if($heroImage->gambar)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <strong>Gambar Saat Ini:</strong><br>
                        <small>{{ basename($heroImage->gambar) }}</small>
                    </div>
                    @endif

                    <!-- Preview Info -->
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Tips:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Upload gambar baru untuk mengganti</li>
                            <li>Kosongkan jika tidak ingin mengganti</li>
                            <li>Resolusi optimal: 1920x1080px</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.hero-images.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Gambar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Styles -->
<style>
.upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-area:hover {
    border-color: var(--primary-color);
    background-color: rgba(var(--primary-color-rgb), 0.05);
}

.upload-area:hover .upload-overlay {
    opacity: 1;
}

.upload-content i {
    font-size: 2rem;
    color: var(--text-muted);
}

.preview-image {
    max-width: 100%;
    max-height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.upload-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 8px;
}

.upload-overlay i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--dark-color);
}

.alert ul {
    padding-left: 1.2rem;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>

<!-- JavaScript -->
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const uploadContent = document.querySelector('.upload-content');
            const uploadOverlay = document.querySelector('.upload-overlay');
            
            preview.src = e.target.result;
            preview.style.display = 'block';
            
            if (uploadContent) {
                uploadContent.style.display = 'none';
            }
            
            if (uploadOverlay) {
                uploadOverlay.style.display = 'none';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
