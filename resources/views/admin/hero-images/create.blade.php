@extends('layout.admin-modern')
@section('title', 'Tambah Gambar Hero')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">➕ Tambah Gambar Hero</h1>
            <p class="page-subtitle">Tambahkan gambar baru untuk slideshow halaman utama</p>
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
        <form action="{{ route('admin.hero-images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Nama Gambar -->
                    <div class="form-group mb-3">
                        <label for="nama_gambar" class="form-label">Nama Gambar <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="nama_gambar" 
                               id="nama_gambar" 
                               class="form-control @error('nama_gambar') is-invalid @enderror" 
                               value="{{ old('nama_gambar') }}" 
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
                                  placeholder="Deskripsikan gambar (opsional)...">{{ old('deskripsi') }}</textarea>
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
                               value="{{ old('urutan', 1) }}" 
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
                                   {{ old('is_active', true) ? 'checked' : '' }}>
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
                        <label for="gambar" class="form-label">Gambar Hero <span class="text-danger">*</span></label>
                        <div class="upload-area" onclick="document.getElementById('gambar').click();">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt mb-2"></i>
                                <p class="mb-1">Klik untuk upload gambar</p>
                                <small class="text-muted">JPG, PNG, GIF (Max: 2MB)</small>
                            </div>
                            <img id="preview" class="preview-image" style="display: none;">
                        </div>
                        <input type="file" 
                               name="gambar" 
                               id="gambar" 
                               class="form-control d-none @error('gambar') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this)"
                               required>
                        @error('gambar')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Preview Info -->
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Tips:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Resolusi optimal: 1920x1080px</li>
                            <li>Format landscape untuk hasil terbaik</li>
                            <li>Pastikan gambar berkualitas tinggi</li>
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
                    Simpan Gambar
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
            
            preview.src = e.target.result;
            preview.style.display = 'block';
            uploadContent.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto generate slug-like name
document.getElementById('nama_gambar').addEventListener('blur', function() {
    const value = this.value.toLowerCase()
        .replace(/[^a-z0-9\s]/g, '')
        .replace(/\s+/g, ' ')
        .trim();
    
    if (value) {
        this.value = value.split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }
});
</script>

@endsection
