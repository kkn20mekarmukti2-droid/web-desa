@extends('layout.admin-modern')

@section('title', 'Tambah Majalah Baru')

@section('content')
<div class="main-content">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">📚 Tambah Majalah Baru</h1>
            <p class="page-subtitle">Buat majalah digital interaktif untuk desa</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.majalah.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="content-wrapper">
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

        <form action="{{ route('admin.majalah.store') }}" method="POST" enctype="multipart/form-data" id="createMajalahForm">
            @csrf
            
            <div class="row">
                <!-- Left Column - Magazine Info -->
                <div class="col-lg-4">
                    <div class="data-card">
                        <div class="card-header">
                            <h2 class="card-title">
                                <i class="fas fa-info-circle me-2"></i>Informasi Majalah
                            </h2>
                            <p class="card-subtitle">Data umum majalah desa</p>
                        </div>
                        
                        <div class="card-body">
                            <!-- Judul Majalah -->
                            <div class="mb-4">
                                <label for="judul" class="form-label fw-semibold">
                                    <i class="fas fa-heading text-primary me-2"></i>Judul Majalah *
                                </label>
                                <input type="text" 
                                       name="judul" 
                                       id="judul"
                                       class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                                       value="{{ old('judul') }}"
                                       placeholder="Contoh: Majalah Desa Mekarmukti Edisi Januari 2025"
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
                                          rows="4"
                                          placeholder="Deskripsi singkat tentang isi majalah...">{{ old('deskripsi') }}</textarea>
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
                                       value="{{ old('tanggal_terbit', date('Y-m-d')) }}"
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
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">
                                        <i class="fas fa-eye text-warning me-2"></i>Publikasikan Majalah
                                    </label>
                                </div>
                                <small class="text-muted">Jika dicentang, majalah akan langsung tampil di website</small>
                            </div>

                            <!-- Cover Image -->
                            <div class="mb-4">
                                <label for="cover_image" class="form-label fw-semibold">
                                    <i class="fas fa-image text-danger me-2"></i>Cover Majalah *
                                </label>
                                <input type="file" 
                                       name="cover_image" 
                                       id="cover_image"
                                       class="form-control {{ $errors->has('cover_image') ? 'is-invalid' : '' }}"
                                       accept="image/jpeg,image/png,image/jpg"
                                       required>
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                
                                <!-- Cover Preview -->
                                <div id="coverPreview" class="mt-3" style="display: none;">
                                    <img id="coverImg" src="" alt="Cover Preview" class="img-thumbnail" style="max-width: 200px; max-height: 250px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Pages Upload -->
                <div class="col-lg-8">
                    <div class="data-card">
                        <div class="card-header">
                            <h2 class="card-title">
                                <i class="fas fa-file-image me-2"></i>Halaman Majalah
                            </h2>
                            <p class="card-subtitle">Upload halaman majalah secara berurutan</p>
                        </div>
                        
                        <div class="card-body">
                            <!-- File Upload Area -->
                            <div class="upload-area mb-4" id="uploadArea">
                                <div class="upload-zone" onclick="document.getElementById('pages').click()">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <h4>Upload Halaman Majalah</h4>
                                    <p>Klik di sini atau drag & drop multiple files</p>
                                    <small class="text-muted">Format: JPG, PNG. Maksimal 2MB per file</small>
                                </div>
                                <input type="file" 
                                       name="pages[]" 
                                       id="pages"
                                       class="d-none"
                                       accept="image/jpeg,image/png,image/jpg"
                                       multiple
                                       required>
                            </div>

                            <!-- Upload Progress -->
                            <div id="uploadProgress" class="mb-4" style="display: none;">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted">Mengunggah halaman...</small>
                            </div>

                            <!-- Pages Preview -->
                            <div id="pagesPreview" class="row"></div>

                            <!-- Tips -->
                            <div class="alert alert-info">
                                <i class="fas fa-lightbulb me-2"></i>
                                <strong>Tips Upload Halaman:</strong>
                                <ul class="mt-2 mb-0">
                                    <li>Upload halaman sesuai urutan (halaman 1, 2, 3, dst)</li>
                                    <li>Gunakan resolusi tinggi untuk kualitas terbaik</li>
                                    <li>Pastikan orientasi halaman seragam (portrait/landscape)</li>
                                    <li>File akan diurutkan sesuai nama file secara alfabetis</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.majalah.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-2"></i>Simpan Majalah
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.upload-zone {
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-zone:hover {
    background-color: #f8f9fa;
    border-color: #007bff;
}

.upload-icon {
    font-size: 3rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.upload-zone:hover .upload-icon {
    color: #007bff;
}

.page-preview {
    position: relative;
    margin-bottom: 1rem;
}

.page-preview img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.page-number {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: bold;
}

.remove-page {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-page:hover {
    background: #c82333;
}

.sortable-placeholder {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    height: 200px;
    border-radius: 8px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const coverInput = document.getElementById('cover_image');
    const pagesInput = document.getElementById('pages');
    const uploadArea = document.getElementById('uploadArea');
    const pagesPreview = document.getElementById('pagesPreview');
    const form = document.getElementById('createMajalahForm');
    
    let selectedFiles = [];

    // Cover preview
    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('coverPreview').style.display = 'block';
                document.getElementById('coverImg').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Pages upload handler
    pagesInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Drag & Drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#007bff';
        uploadArea.style.backgroundColor = '#f8f9fa';
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#dee2e6';
        uploadArea.style.backgroundColor = 'transparent';
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#dee2e6';
        uploadArea.style.backgroundColor = 'transparent';
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
        selectedFiles = Array.from(files);
        updatePagesPreview();
    }

    function updatePagesPreview() {
        pagesPreview.innerHTML = '';
        
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-sm-4 col-6';
                col.innerHTML = `
                    <div class="page-preview" data-index="${index}">
                        <img src="${e.target.result}" alt="Page ${index + 1}">
                        <div class="page-number">Hal. ${index + 1}</div>
                        <button type="button" class="remove-page" onclick="removePage(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                pagesPreview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });

        // Update file input
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        pagesInput.files = dataTransfer.files;
    }

    // Remove page function
    window.removePage = function(index) {
        selectedFiles.splice(index, 1);
        updatePagesPreview();
    };

    // Form submission
    form.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        
        // Show progress
        document.getElementById('uploadProgress').style.display = 'block';
        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            document.querySelector('.progress-bar').style.width = progress + '%';
            if (progress >= 100) {
                clearInterval(interval);
            }
        }, 200);
    });

    // Auto-resize textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
});
</script>
@endsection
