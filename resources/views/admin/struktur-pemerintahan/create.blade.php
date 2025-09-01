@extends('layout.admin-modern')
@section('title', 'Tambah Struktur Pemerintahan')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👥 Tambah Aparatur</h1>
            <p class="page-subtitle">Menambahkan data aparatur pemerintahan desa</p>
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
<div class="form-container">
    <div class="form-header">
        <h3 class="form-title">Data Aparatur</h3>
        <p class="form-subtitle">Lengkapi informasi aparatur pemerintahan</p>
    </div>

    <form action="{{ route('admin.struktur-pemerintahan.store') }}" method="POST" enctype="multipart/form-data" id="strukturForm">
        @csrf
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <div class="form-section">
                    <h5 class="form-section-title">Informasi Dasar</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-label required">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
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
                            <div class="form-group">
                                <label for="jabatan" class="form-label required">Jabatan</label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                                       id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                                @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori" class="form-label required">Kategori</label>
                                <select class="form-control @error('kategori') is-invalid @enderror" 
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
                            <div class="form-group">
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
                            <div class="form-group">
                                <label for="urutan" class="form-label required">Urutan</label>
                                <input type="number" class="form-control @error('urutan') is-invalid @enderror" 
                                       id="urutan" name="urutan" value="{{ old('urutan', 1) }}" required min="1">
                                <small class="form-text text-muted">Urutan tampil dalam struktur organisasi</small>
                                @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h5 class="form-section-title">Informasi Detail</h5>
                    
                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="2" 
                                  placeholder="Alamat tempat tinggal">{{ old('alamat') }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
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
                            <div class="form-group">
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

                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                   value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Status Aktif
                            </label>
                            <small class="form-text text-muted d-block">Aparatur aktif akan ditampilkan di halaman publik</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Photo Upload -->
            <div class="col-lg-4">
                <div class="form-section">
                    <h5 class="form-section-title">Foto Aparatur</h5>
                    
                    <div class="photo-upload-area">
                        <div class="photo-preview" id="photoPreview">
                            <div class="photo-placeholder">
                                <i class="fas fa-camera"></i>
                                <p>Pilih Foto</p>
                                <small>JPG, PNG max 2MB</small>
                            </div>
                        </div>
                        
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" name="foto" accept="image/*" style="display: none;">
                        
                        <div class="photo-actions">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('foto').click();">
                                <i class="fas fa-upload"></i> Pilih File
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="removePhoto" style="display: none;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                        
                        @error('foto')
                        <div class="text-danger mt-2 small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="upload-guidelines">
                        <h6>Panduan Foto:</h6>
                        <ul>
                            <li>Resolusi minimal 300x300px</li>
                            <li>Format JPG atau PNG</li>
                            <li>Ukuran maksimal 2MB</li>
                            <li>Foto formal dengan latar belakang rapi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-footer">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back();">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
                <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('styles')
<style>
.photo-upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    transition: border-color 0.3s;
}

.photo-upload-area:hover {
    border-color: var(--primary-color);
}

.photo-preview {
    width: 200px;
    height: 200px;
    margin: 0 auto 1rem;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.photo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--bg-light);
    color: var(--text-muted);
}

.photo-placeholder i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.upload-guidelines {
    background: var(--bg-light);
    padding: 1rem;
    border-radius: 6px;
    margin-top: 1rem;
}

.upload-guidelines h6 {
    margin-bottom: 0.5rem;
    color: var(--dark-color);
}

.upload-guidelines ul {
    margin: 0;
    padding-left: 1rem;
    font-size: 0.875rem;
    color: var(--text-muted);
}

.upload-guidelines li {
    margin-bottom: 0.25rem;
}

.form-section {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    margin-bottom: 1.5rem;
}

.form-section-title {
    margin-bottom: 1rem;
    color: var(--dark-color);
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 0.5rem;
}

.required::after {
    content: ' *';
    color: #dc2626;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>
@endsection

@section('scripts')
<script>
// Photo upload preview
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('photoPreview');
    const removeBtn = document.getElementById('removePhoto');
    
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            this.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar (JPG, PNG)');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            removeBtn.style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
    }
});

// Remove photo
document.getElementById('removePhoto').addEventListener('click', function() {
    document.getElementById('foto').value = '';
    document.getElementById('photoPreview').innerHTML = `
        <div class="photo-placeholder">
            <i class="fas fa-camera"></i>
            <p>Pilih Foto</p>
            <small>JPG, PNG max 2MB</small>
        </div>
    `;
    this.style.display = 'none';
});

// Auto-suggest urutan based on kategori
document.getElementById('kategori').addEventListener('change', function() {
    const kategori = this.value;
    const urutanInput = document.getElementById('urutan');
    
    // Set suggested order based on category
    const orderSuggestion = {
        'kepala_desa': 1,
        'sekretaris': 2,
        'kepala_urusan': 3,
        'kepala_seksi': 4,
        'kepala_dusun': 5
    };
    
    if (orderSuggestion[kategori] && !urutanInput.value) {
        urutanInput.value = orderSuggestion[kategori];
    }
});

// Form validation
document.getElementById('strukturForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});

// Auto-format phone number
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
