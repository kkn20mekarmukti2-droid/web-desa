@extends('layout.admin-modern')
@section('title', 'Edit Produk UMKM')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">✏️ Edit Produk UMKM</h1>
            <p class="page-subtitle">Update informasi produk: {{ $produk->nama_produk }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.produk-umkm.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.produk-umkm.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Nama Produk -->
                    <div class="form-group mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="nama_produk" 
                               id="nama_produk" 
                               class="form-control @error('nama_produk') is-invalid @enderror" 
                               value="{{ old('nama_produk', $produk->nama_produk) }}" 
                               placeholder="Masukkan nama produk UMKM"
                               required>
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Produk <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" 
                                  id="deskripsi" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="4" 
                                  placeholder="Deskripsikan produk UMKM secara detail..."
                                  required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="form-group mb-3">
                        <label for="nomor_telepon" class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fab fa-whatsapp text-success"></i>
                            </span>
                            <input type="text" 
                                   name="nomor_telepon" 
                                   id="nomor_telepon" 
                                   class="form-control @error('nomor_telepon') is-invalid @enderror" 
                                   value="{{ old('nomor_telepon', $produk->nomor_telepon) }}" 
                                   placeholder="Contoh: 6281234567890 (dengan kode negara)"
                                   required>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            Format: 62 + nomor HP (tanpa 0 di awal). Contoh: 6281234567890
                        </small>
                        @error('nomor_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Upload Gambar -->
                    <div class="form-group mb-3">
                        <label for="gambar" class="form-label">Gambar Produk</label>
                        <div class="upload-area" onclick="document.getElementById('gambar').click();">
                            @if($produk->gambar && file_exists(public_path($produk->gambar)))
                            <img src="{{ asset($produk->gambar) }}" id="preview" class="preview-image">
                            @elseif($produk->gambar && file_exists(public_path('storage/' . $produk->gambar)))
                            <img src="{{ asset('storage/' . $produk->gambar) }}" id="preview" class="preview-image">
                            @else
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt mb-2"></i>
                                <p class="mb-1">Klik untuk upload gambar</p>
                                <small class="text-muted">JPG, PNG, GIF (Max: 2MB)</small>
                            </div>
                            <img id="preview" class="preview-image" style="display: none;">
                            @endif
                            
                            @if($produk->gambar)
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
                    @if($produk->gambar)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <strong>Gambar Saat Ini:</strong><br>
                        <small>{{ basename($produk->gambar) }}</small>
                    </div>
                    @endif

                    <!-- Preview Info -->
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Tips:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Upload gambar baru untuk mengganti</li>
                            <li>Kosongkan jika tidak ingin mengganti</li>
                            <li>Ukuran optimal: 800x600px</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.produk-umkm.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Produk
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

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const nomorTelepon = document.getElementById('nomor_telepon').value;
    
    // Check if phone number starts with 62
    if (nomorTelepon && !nomorTelepon.startsWith('62')) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Format Nomor Tidak Valid!',
            text: 'Nomor WhatsApp harus dimulai dengan 62 (kode negara Indonesia)',
            confirmButtonText: 'OK'
        });
        return false;
    }
});
</script>

@endsection
