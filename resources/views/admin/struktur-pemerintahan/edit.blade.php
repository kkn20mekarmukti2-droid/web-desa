@extends('layout.admin-modern')
@section('title', 'Edit Struktur Pemerintahan')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👥 Edit Aparatur</h1>
            <p class="page-subtitle">Mengubah data {{ $struktur->nama }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.struktur-pemerintahan.show', $struktur->id) }}" class="btn btn-outline-info">
                <i class="fas fa-eye"></i>
                Detail
            </a>
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
        <h3 class="form-title">Edit Data Aparatur</h3>
        <p class="form-subtitle">Perbarui informasi {{ $struktur->nama }}</p>
    </div>

    <form action="{{ route('admin.struktur-pemerintahan.update', $struktur->id) }}" method="POST" enctype="multipart/form-data" id="strukturForm">
        @csrf
        @method('PUT')
        
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
                                       id="nama" name="nama" value="{{ old('nama', $struktur->nama) }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                       id="nip" name="nip" value="{{ old('nip', $struktur->nip) }}">
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
                                       id="jabatan" name="jabatan" value="{{ old('jabatan', $struktur->jabatan) }}" required>
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <input type="text" class="form-control @error('pendidikan') is-invalid @enderror" 
                                       id="pendidikan" name="pendidikan" value="{{ old('pendidikan', $struktur->pendidikan) }}" 
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
                                       id="urutan" name="urutan" value="{{ old('urutan', $struktur->urutan) }}" required min="1">
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
                                  placeholder="Alamat tempat tinggal">{{ old('alamat', $struktur->alamat) }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                       id="telepon" name="telepon" value="{{ old('telepon', $struktur->telepon) }}"
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
                                       id="email" name="email" value="{{ old('email', $struktur->email) }}"
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
                                   value="1" {{ old('is_active', $struktur->is_active) ? 'checked' : '' }}>
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
                            @if($struktur->foto && file_exists(public_path($struktur->foto)))
                            <img src="{{ asset($struktur->foto) }}" alt="{{ $struktur->nama }}" class="current-photo">
                            @else
                            <div class="photo-placeholder">
                                <i class="fas fa-camera"></i>
                                <p>Pilih Foto</p>
                                <small>JPG, PNG max 2MB</small>
                            </div>
                            @endif
                        </div>
                        
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" name="foto" accept="image/*" style="display: none;">
                        
                        <div class="photo-actions">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('foto').click();">
                                <i class="fas fa-upload"></i> Ganti Foto
                            </button>
                            @if($struktur->foto && file_exists(public_path($struktur->foto)))
                            <button type="button" class="btn btn-outline-danger btn-sm" id="removeCurrentPhoto">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            @endif
                            <button type="button" class="btn btn-outline-danger btn-sm" id="removeNewPhoto" style="display: none;">
                                <i class="fas fa-trash"></i> Batal
                            </button>
                        </div>
                        
                        @error('foto')
                        <div class="text-danger mt-2 small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if($struktur->foto && file_exists(public_path($struktur->foto)))
                    <div class="current-photo-info">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Foto saat ini: {{ basename($struktur->foto) }}
                        </small>
                    </div>
                    @endif
                    
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

        <!-- Hidden field to track photo deletion -->
        <input type="hidden" name="remove_photo" id="removePhotoFlag" value="0">

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
                        <i class="fas fa-save"></i> Update Data
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
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #fafbfc 0%, #f8f9fa 100%);
}

.photo-upload-area:hover {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, #f0f7ff 0%, #e6f3ff 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
}

.photo-preview {
    width: 220px;
    height: 220px;
    margin: 0 auto 1rem;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid var(--border-color);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    background: white;
}

.photo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--bg-light) 0%, var(--border-color) 100%);
    color: var(--text-muted);
}

.photo-placeholder i {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    opacity: 0.7;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.photo-preview img:hover {
    transform: scale(1.02);
}

.photo-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.current-photo-info {
    margin-top: 0.5rem;
    text-align: center;
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
// Store original photo for restoration
const originalPhotoHtml = document.getElementById('photoPreview').innerHTML;

// Photo upload preview
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('photoPreview');
    const removeNewBtn = document.getElementById('removeNewPhoto');
    const removeCurrentBtn = document.getElementById('removeCurrentPhoto');
    
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
            removeNewBtn.style.display = 'inline-block';
            if (removeCurrentBtn) removeCurrentBtn.style.display = 'none';
            document.getElementById('removePhotoFlag').value = '0';
        };
        reader.readAsDataURL(file);
    }
});

// Remove new photo (restore current)
document.getElementById('removeNewPhoto').addEventListener('click', function() {
    document.getElementById('foto').value = '';
    document.getElementById('photoPreview').innerHTML = originalPhotoHtml;
    this.style.display = 'none';
    const removeCurrentBtn = document.getElementById('removeCurrentPhoto');
    if (removeCurrentBtn) removeCurrentBtn.style.display = 'inline-block';
    document.getElementById('removePhotoFlag').value = '0';
});

// Remove current photo
const removeCurrentBtn = document.getElementById('removeCurrentPhoto');
if (removeCurrentBtn) {
    removeCurrentBtn.addEventListener('click', function() {
        if (confirm('Hapus foto saat ini? Foto akan dihapus setelah data disimpan.')) {
            document.getElementById('photoPreview').innerHTML = `
                <div class="photo-placeholder">
                    <i class="fas fa-camera"></i>
                    <p>Pilih Foto</p>
                    <small>JPG, PNG max 2MB</small>
                </div>
            `;
            this.style.display = 'none';
            document.getElementById('removePhotoFlag').value = '1';
        }
    });
}

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
