@extends('layout.admin-modern')

@section('title', 'Tambah APBDes')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">📝 Tambah APBDes</h1>
            <p class="text-muted">Upload dokumen transparansi anggaran desa baru</p>
        </div>
        <a href="{{ route('admin.apbdes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus-circle me-2"></i>Form Tambah APBDes
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.apbdes.store') }}" method="POST" enctype="multipart/form-data" id="apbdesForm">
                        @csrf
                        
                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="fas fa-heading me-2 text-primary"></i>Judul APBDes
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                placeholder="Contoh: APBDes Desa Sukamaju Tahun 2024"
                                maxlength="255"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan judul yang jelas dan informatif</small>
                        </div>

                        <!-- Tahun -->
                        <div class="mb-4">
                            <label for="tahun" class="form-label fw-bold">
                                <i class="fas fa-calendar me-2 text-primary"></i>Tahun Anggaran
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('tahun') is-invalid @enderror" id="tahun" name="tahun" required>
                                <option value="">Pilih Tahun</option>
                                @for($year = date('Y') + 1; $year >= 2020; $year--)
                                    <option value="{{ $year }}" {{ old('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi
                            </label>
                            <textarea 
                                class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="4"
                                placeholder="Berikan deskripsi singkat tentang dokumen APBDes ini..."
                                maxlength="1000"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Opsional - Jelaskan detail atau catatan khusus</small>
                        </div>

                        <!-- Upload Gambar -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">
                                <i class="fas fa-image me-2 text-primary"></i>Upload Gambar APBDes
                                <span class="text-danger">*</span>
                            </label>
                            
                            <!-- Upload Area -->
                            <div class="upload-area border-2 border-dashed border-secondary rounded p-4 text-center" id="uploadArea">
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Pilih atau Drag & Drop Gambar</h5>
                                    <p class="text-muted mb-2">Klik untuk memilih file atau drag file ke area ini</p>
                                    <small class="text-muted">Format: JPG, JPEG, PNG | Maksimal: 5MB</small>
                                </div>
                                
                                <div id="imagePreview" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-fluid rounded mb-2" style="max-height: 300px;">
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="removeImage">
                                            <i class="fas fa-trash me-1"></i>Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <input 
                                type="file" 
                                class="form-control d-none @error('image') is-invalid @enderror" 
                                id="image" 
                                name="image" 
                                accept="image/jpeg,image/jpg,image/png"
                                required
                            >
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-toggle-on me-2 text-primary"></i>Status Publikasi
                            </label>
                            <div class="form-check form-switch">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    id="is_active" 
                                    name="is_active" 
                                    value="1"
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="is_active">
                                    <span id="statusLabel">Aktif (Tampil di Website)</span>
                                </label>
                            </div>
                            <small class="form-text text-muted">Centang untuk menampilkan di halaman transparansi</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-save me-2"></i>Simpan APBDes
                            </button>
                            <a href="{{ route('admin.apbdes.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Upload Area Click Handler
    $('#uploadArea').on('click', function() {
        $('#image').click();
    });

    // Prevent default drag behaviors
    $('#uploadArea').on('dragenter dragover dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Highlight upload area when dragging over
    $('#uploadArea').on('dragenter dragover', function(e) {
        $(this).addClass('border-primary bg-light');
    });

    $('#uploadArea').on('dragleave drop', function(e) {
        $(this).removeClass('border-primary bg-light');
    });

    // Handle dropped files
    $('#uploadArea').on('drop', function(e) {
        var files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#image')[0].files = files;
            handleFileSelect(files[0]);
        }
    });

    // Handle file input change
    $('#image').on('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });

    // Remove image handler
    $('#removeImage').on('click', function() {
        $('#image').val('');
        $('#imagePreview').hide();
        $('#uploadPlaceholder').show();
    });

    // Status toggle handler
    $('#is_active').on('change', function() {
        if (this.checked) {
            $('#statusLabel').text('Aktif (Tampil di Website)');
        } else {
            $('#statusLabel').text('Non-Aktif (Tidak Tampil)');
        }
    });

    // Form validation
    $('#apbdesForm').on('submit', function(e) {
        var isValid = true;
        var errorMessage = '';

        // Check image
        if (!$('#image')[0].files.length) {
            isValid = false;
            errorMessage = 'Gambar APBDes harus diupload';
        }

        // Check file size (5MB = 5 * 1024 * 1024 bytes)
        if ($('#image')[0].files.length && $('#image')[0].files[0].size > 5242880) {
            isValid = false;
            errorMessage = 'Ukuran file maksimal 5MB';
        }

        if (!isValid) {
            e.preventDefault();
            alert(errorMessage);
            return false;
        }
    });
});

function handleFileSelect(file) {
    // Validate file type
    var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG');
        $('#image').val('');
        return;
    }

    // Validate file size (5MB)
    if (file.size > 5242880) {
        alert('Ukuran file terlalu besar. Maksimal 5MB');
        $('#image').val('');
        return;
    }

    // Show preview
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#previewImg').attr('src', e.target.result);
        $('#uploadPlaceholder').hide();
        $('#imagePreview').show();
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
