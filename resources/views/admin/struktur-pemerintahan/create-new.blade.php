@extends('layout.admin-modern')
@section('title', 'Tambah Aparatur')
@section('content')

<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="text-decoration-none">
                            <i class="fas fa-users me-1"></i>Struktur Pemerintahan
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Aparatur</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-1">➕ Tambah Aparatur</h2>
                    <p class="text-muted mb-0">Menambahkan data aparatur pemerintahan desa</p>
                </div>
                <div>
                    <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.struktur-pemerintahan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Basic Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">📋 Informasi Dasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                           id="nip" name="nip" value="{{ old('nip') }}">
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                                           id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('kategori') is-invalid @enderror" 
                                            id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="kepala_desa" {{ old('kategori') == 'kepala_desa' ? 'selected' : '' }}>
                                            Kepala Desa
                                        </option>
                                        <option value="sekretaris" {{ old('kategori') == 'sekretaris' ? 'selected' : '' }}>
                                            Sekretaris
                                        </option>
                                        <option value="kepala_urusan" {{ old('kategori') == 'kepala_urusan' ? 'selected' : '' }}>
                                            Kepala Urusan
                                        </option>
                                        <option value="kepala_seksi" {{ old('kategori') == 'kepala_seksi' ? 'selected' : '' }}>
                                            Kepala Seksi
                                        </option>
                                        <option value="kepala_dusun" {{ old('kategori') == 'kepala_dusun' ? 'selected' : '' }}>
                                            Kepala Dusun
                                        </option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pendidikan" class="form-label">Pendidikan</label>
                                    <input type="text" class="form-control @error('pendidikan') is-invalid @enderror" 
                                           id="pendidikan" name="pendidikan" value="{{ old('pendidikan') }}" 
                                           placeholder="S1 Administrasi Publik">
                                    @error('pendidikan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="urutan" class="form-label">Urutan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('urutan') is-invalid @enderror" 
                                           id="urutan" name="urutan" value="{{ old('urutan', 1) }}" required min="1">
                                    <div class="form-text">Urutan tampil dalam struktur organisasi</div>
                                    @error('urutan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">📞 Informasi Kontak</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="2">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                           id="telepon" name="telepon" value="{{ old('telepon') }}"
                                           placeholder="0812-3456-7890">
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}"
                                           placeholder="nama@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Status Aktif
                                </label>
                                <div class="form-text">Aparatur aktif akan ditampilkan di halaman publik</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Data
                    </button>
                    <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Photo Upload Section -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">📸 Foto Aparatur</h5>
                </div>
                <div class="card-body text-center">
                    <!-- Simple Photo Upload -->
                    <div class="upload-area mb-3" onclick="document.getElementById('foto').click();" style="cursor: pointer;">
                        <div class="upload-preview" id="uploadPreview">
                            <div class="upload-placeholder">
                                <i class="fas fa-camera text-muted mb-2" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0">Klik untuk pilih foto</p>
                                <small class="text-muted">JPG, PNG (Max: 2MB)</small>
                            </div>
                        </div>
                    </div>

                    <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                           id="foto" name="foto" accept="image/*" style="display: none;" form="createForm">

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                onclick="document.getElementById('foto').click();">
                            <i class="fas fa-upload me-1"></i>Pilih Foto
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                id="clearPhoto" style="display: none;" onclick="clearPhoto();">
                            <i class="fas fa-trash me-1"></i>Hapus Foto
                        </button>
                    </div>

                    @error('foto')
                        <div class="text-danger mt-2 small">{{ $message }}</div>
                    @enderror

                    <!-- Guidelines -->
                    <div class="mt-4">
                        <h6 class="small fw-bold">Panduan Foto:</h6>
                        <ul class="list-unstyled small text-muted">
                            <li>• Foto formal dengan latar rapi</li>
                            <li>• Resolusi minimal 300x300px</li>
                            <li>• Format JPG atau PNG</li>
                            <li>• Ukuran maksimal 2MB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
.upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 2rem 1rem;
    transition: border-color 0.3s;
}

.upload-area:hover {
    border-color: #0d6efd;
    background-color: #f8f9ff;
}

.upload-preview {
    width: 200px;
    height: 200px;
    margin: 0 auto;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-placeholder {
    text-align: center;
}

.upload-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Form Enhancements */
.form-label {
    font-weight: 500;
    color: #495057;
}

.form-control:focus,
.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.card-header {
    border-bottom: 1px solid #dee2e6;
}
</style>
@endsection

@section('scripts')
<script>
// Photo Upload Preview
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('uploadPreview');
    const clearBtn = document.getElementById('clearPhoto');
    
    if (file) {
        // Validate file size
        if (file.size > 2 * 1024 * 1024) {
            alert('❌ Ukuran file terlalu besar. Maksimal 2MB.');
            this.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.match('image.*')) {
            alert('❌ File harus berupa gambar (JPG/PNG)');
            this.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            clearBtn.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Clear Photo
function clearPhoto() {
    document.getElementById('foto').value = '';
    document.getElementById('uploadPreview').innerHTML = `
        <div class="upload-placeholder">
            <i class="fas fa-camera text-muted mb-2" style="font-size: 2rem;"></i>
            <p class="text-muted mb-0">Klik untuk pilih foto</p>
            <small class="text-muted">JPG, PNG (Max: 2MB)</small>
        </div>
    `;
    document.getElementById('clearPhoto').style.display = 'none';
}

// Auto format phone number
document.getElementById('telepon').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 0) {
        if (value.length <= 4) {
            value = value;
        } else if (value.length <= 8) {
            value = value.slice(0, 4) + '-' + value.slice(4);
        } else {
            value = value.slice(0, 4) + '-' + value.slice(4, 8) + '-' + value.slice(8, 12);
        }
        e.target.value = value;
    }
});
</script>
@endsection
