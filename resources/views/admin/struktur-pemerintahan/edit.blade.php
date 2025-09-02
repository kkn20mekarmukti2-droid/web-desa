@extends('layout.admin-modern')
@section('title', 'Edit Struktur Pemerintahan')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">✏️ Edit Aparatur</h1>
            <p class="page-subtitle">Update informasi: {{ $struktur->nama }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.struktur-pemerintahan.update', $struktur->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Nama -->
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="nama" 
                               id="nama" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $struktur->nama) }}" 
                               placeholder="Masukkan nama lengkap aparatur"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jabatan -->
                    <div class="form-group mb-3">
                        <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="jabatan" 
                               id="jabatan" 
                               class="form-control @error('jabatan') is-invalid @enderror" 
                               value="{{ old('jabatan', $struktur->jabatan) }}" 
                               placeholder="Masukkan jabatan aparatur"
                               required>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div class="form-group mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" 
                               name="nip" 
                               id="nip" 
                               class="form-control @error('nip') is-invalid @enderror" 
                               value="{{ old('nip', $struktur->nip) }}" 
                               placeholder="Masukkan NIP (jika ada)">
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="form-group mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" 
                                id="kategori" 
                                class="form-control @error('kategori') is-invalid @enderror" 
                                required>
                            <option value="">Pilih Kategori</option>
                            <option value="kepala_desa" {{ old('kategori', $struktur->kategori) == 'kepala_desa' ? 'selected' : '' }}>
                                Kepala Desa
                            </option>
                            <option value="sekretaris" {{ old('kategori', $struktur->kategori) == 'sekretaris' ? 'selected' : '' }}>
                                Sekretaris
                            </option>
                            <option value="kepala_urusan" {{ old('kategori', $struktur->kategori) == 'kepala_urusan' ? 'selected' : '' }}>
                                Kepala Urusan
                            </option>
                            <option value="kepala_seksi" {{ old('kategori', $struktur->kategori) == 'kepala_seksi' ? 'selected' : '' }}>
                                Kepala Seksi
                            </option>
                            <option value="kepala_dusun" {{ old('kategori', $struktur->kategori) == 'kepala_dusun' ? 'selected' : '' }}>
                                Kepala Dusun
                            </option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pendidikan -->
                    <div class="form-group mb-3">
                        <label for="pendidikan" class="form-label">Pendidikan</label>
                        <input type="text" 
                               name="pendidikan" 
                               id="pendidikan" 
                               class="form-control @error('pendidikan') is-invalid @enderror" 
                               value="{{ old('pendidikan', $struktur->pendidikan) }}" 
                               placeholder="Contoh: S1 Administrasi Publik">
                        @error('pendidikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Urutan -->
                    <div class="form-group mb-3">
                        <label for="urutan" class="form-label">Urutan <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="urutan" 
                               id="urutan" 
                               class="form-control @error('urutan') is-invalid @enderror" 
                               value="{{ old('urutan', $struktur->urutan) }}" 
                               min="1"
                               placeholder="Urutan tampil dalam struktur"
                               required>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            Urutan tampil dalam struktur organisasi
                        </small>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Upload Foto -->
                    <div class="form-group mb-3">
                        <label for="foto" class="form-label">Foto Aparatur</label>
                        <div class="upload-area" onclick="document.getElementById('foto').click();">
                            @if($struktur->foto && file_exists(public_path($struktur->foto)))
                            <img src="{{ asset($struktur->foto) }}" id="preview" class="preview-image">
                            @elseif($struktur->foto && file_exists(public_path('storage/' . $struktur->foto)))
                            <img src="{{ asset('storage/' . $struktur->foto) }}" id="preview" class="preview-image">
                            @else
                            <div class="upload-content">
                                <i class="fas fa-camera mb-2"></i>
                                <p class="mb-1">Klik untuk upload foto</p>
                                <small class="text-muted">JPG, PNG (Max: 2MB)</small>
                            </div>
                            <img id="preview" class="preview-image" style="display: none;">
                            @endif
                            
                            @if($struktur->foto)
                            <div class="upload-overlay">
                                <i class="fas fa-camera"></i>
                                <p>Klik untuk ganti foto</p>
                            </div>
                            @endif
                        </div>
                        <input type="file" 
                               name="foto" 
                               id="foto" 
                               class="form-control d-none @error('foto') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this)">
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Image Info -->
                    @if($struktur->foto)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <strong>Foto Saat Ini:</strong><br>
                        <small>{{ basename($struktur->foto) }}</small>
                    </div>
                    @endif

                    <!-- Preview Info -->
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Tips:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Upload foto baru untuk mengganti</li>
                            <li>Kosongkan jika tidak ingin mengganti</li>
                            <li>Foto formal dengan latar rapi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Data
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
</script>

@endsection
