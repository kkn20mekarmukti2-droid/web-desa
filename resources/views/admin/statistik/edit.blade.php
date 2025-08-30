@extends('layout.admin-modern')

@section('title', 'Edit Data Statistik')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">✏️ Edit Data Statistik</h1>
            <p class="page-subtitle">Edit data statistik "{{ $statistik->label }}" untuk kategori {{ $kategoriOptions[$statistik->kategori] }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.statistik.index', ['kategori' => $statistik->kategori]) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="content-card">
    <div class="card-header">
        <h3 class="card-title">
            @switch($statistik->kategori)
                @case('jenis_kelamin')
                    <i class="fas fa-users text-primary me-2"></i>
                    @break
                @case('agama')
                    <i class="fas fa-pray text-primary me-2"></i>
                    @break
                @case('pekerjaan')
                    <i class="fas fa-briefcase text-primary me-2"></i>
                    @break
                @case('kk')
                    <i class="fas fa-home text-primary me-2"></i>
                    @break
                @case('rt_rw')
                    <i class="fas fa-map-marked-alt text-primary me-2"></i>
                    @break
                @case('pendidikan')
                    <i class="fas fa-graduation-cap text-primary me-2"></i>
                    @break
                @case('kesehatan')
                    <i class="fas fa-heartbeat text-primary me-2"></i>
                    @break
                @case('siswa')
                    <i class="fas fa-user-graduate text-primary me-2"></i>
                    @break
                @case('klub')
                    <i class="fas fa-users-cog text-primary me-2"></i>
                    @break
                @case('kesenian')
                    <i class="fas fa-palette text-primary me-2"></i>
                    @break
                @case('sumberair')
                    <i class="fas fa-tint text-primary me-2"></i>
                    @break
                @default
                    <i class="fas fa-chart-bar text-primary me-2"></i>
            @endswitch
            Edit Data {{ $kategoriOptions[$statistik->kategori] }}
        </h3>
        <p class="card-subtitle">Update informasi data statistik yang diperlukan</p>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.statistik.update', $statistik->id) }}" method="POST" class="modern-form">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Kategori Field -->
                <div class="col-md-6 mb-4">
                    <label for="kategori" class="form-label required">
                        <i class="fas fa-tag me-1"></i>Kategori Data
                    </label>
                    <select class="form-select modern-select @error('kategori') is-invalid @enderror" 
                            id="kategori" 
                            name="kategori" 
                            required>
                        @foreach($kategoriOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('kategori', $statistik->kategori) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Pilih kategori yang sesuai untuk data ini</small>
                </div>

                <!-- Current Category Display -->
                <div class="col-md-6 mb-4">
                    <label class="form-label">
                        <i class="fas fa-info-circle me-1"></i>Kategori Saat Ini
                    </label>
                    <div class="form-control-static">
                        <div class="category-display">
                            <div class="category-icon current">
                                @switch($statistik->kategori)
                                    @case('jenis_kelamin')
                                        <i class="fas fa-users"></i>
                                        @break
                                    @case('agama')
                                        <i class="fas fa-pray"></i>
                                        @break
                                    @case('pekerjaan')
                                        <i class="fas fa-briefcase"></i>
                                        @break
                                    @case('kk')
                                        <i class="fas fa-home"></i>
                                        @break
                                    @case('rt_rw')
                                        <i class="fas fa-map-marked-alt"></i>
                                        @break
                                    @case('pendidikan')
                                        <i class="fas fa-graduation-cap"></i>
                                        @break
                                    @case('kesehatan')
                                        <i class="fas fa-heartbeat"></i>
                                        @break
                                    @case('siswa')
                                        <i class="fas fa-user-graduate"></i>
                                        @break
                                    @case('klub')
                                        <i class="fas fa-users-cog"></i>
                                        @break
                                    @case('kesenian')
                                        <i class="fas fa-palette"></i>
                                        @break
                                    @case('sumberair')
                                        <i class="fas fa-tint"></i>
                                        @break
                                    @default
                                        <i class="fas fa-chart-bar"></i>
                                @endswitch
                            </div>
                            <span class="category-name">{{ $kategoriOptions[$statistik->kategori] }}</span>
                        </div>
                    </div>
                    <small class="form-text">Kategori data yang sedang digunakan</small>
                </div>
            </div>

            <div class="row">
                <!-- Label Field -->
                <div class="col-md-6 mb-4">
                    <label for="label" class="form-label required">
                        <i class="fas fa-tag me-1"></i>Label/Nama Data
                    </label>
                    <input type="text" 
                           class="form-control modern-input @error('label') is-invalid @enderror" 
                           id="label" 
                           name="label" 
                           value="{{ old('label', $statistik->label) }}" 
                           placeholder="Contoh: Laki-laki, Islam, Petani, dll"
                           required>
                    @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Nama atau label untuk data statistik ini</small>
                </div>

                <!-- Jumlah Field -->
                <div class="col-md-6 mb-4">
                    <label for="jumlah" class="form-label required">
                        <i class="fas fa-calculator me-1"></i>Jumlah
                    </label>
                    <div class="input-group">
                        <input type="number" 
                               class="form-control modern-input @error('jumlah') is-invalid @enderror" 
                               id="jumlah" 
                               name="jumlah" 
                               value="{{ old('jumlah', $statistik->jumlah) }}" 
                               min="0" 
                               placeholder="0"
                               required>
                        <span class="input-group-text">orang</span>
                    </div>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Jumlah penduduk untuk kategori ini</small>
                </div>
            </div>

            <!-- Deskripsi Field -->
            <div class="mb-4">
                <label for="deskripsi" class="form-label">
                    <i class="fas fa-align-left me-1"></i>Deskripsi
                    <span class="text-muted">(Opsional)</span>
                </label>
                <textarea class="form-control modern-input @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" 
                          name="deskripsi" 
                          rows="4" 
                          placeholder="Tambahkan deskripsi atau informasi tambahan tentang data ini...">{{ old('deskripsi', $statistik->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Informasi tambahan tentang data statistik (opsional)</small>
            </div>

            <!-- Data Info -->
            <div class="data-info-box mb-4">
                <div class="info-row">
                    <span class="info-label">
                        <i class="fas fa-calendar me-2"></i>Dibuat pada
                    </span>
                    <span class="info-value">{{ $statistik->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">
                        <i class="fas fa-edit me-2"></i>Terakhir diubah
                    </span>
                    <span class="info-value">{{ $statistik->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Update Data
                </button>
                <a href="{{ route('admin.statistik.index', ['kategori' => $statistik->kategori]) }}" 
                   class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="button" 
                        class="btn btn-danger btn-lg ms-auto" 
                        onclick="deleteData('{{ $statistik->id }}', '{{ $statistik->label }}')">
                    <i class="fas fa-trash me-2"></i>Hapus Data
                </button>
            </div>
        </form>
        
        <!-- Hidden delete form -->
        <form id="delete-form" action="{{ route('admin.statistik.destroy', $statistik->id) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<!-- Info Card -->
<div class="content-card mt-4">
    <div class="info-box info-box-warning">
        <div class="info-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="info-content">
            <h5>Perhatian Saat Mengedit Data</h5>
            <ul class="info-list">
                <li><strong>Konsistensi:</strong> Pastikan perubahan data konsisten dengan data lainnya</li>
                <li><strong>Akurasi:</strong> Verifikasi kembali kebenaran data sebelum menyimpan</li>
                <li><strong>Kategori:</strong> Hati-hati saat mengubah kategori, dapat mempengaruhi tampilan chart</li>
                <li><strong>Backup:</strong> Data lama akan ditimpa, pastikan sudah yakin dengan perubahan</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-control-static {
    padding: 0.75rem;
    background: var(--light-color);
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.category-display {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.category-display .category-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: rgba(102, 126, 234, 0.1);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.category-display .category-icon.current {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.category-display .category-name {
    font-weight: 600;
    color: var(--dark-color);
}

.modern-form .form-label.required::after {
    content: " *";
    color: var(--danger-color);
    font-weight: bold;
}

.modern-input {
    border-radius: 8px;
    border: 1px solid var(--border-color);
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.modern-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.modern-select {
    border-radius: 8px;
    border: 1px solid var(--border-color);
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
}

.form-text {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

.data-info-box {
    background: rgba(59, 130, 246, 0.05);
    border: 1px solid rgba(59, 130, 246, 0.1);
    border-radius: 8px;
    padding: 1rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.info-row:not(:last-child) {
    border-bottom: 1px solid rgba(59, 130, 246, 0.1);
}

.info-label {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.info-value {
    font-weight: 500;
    color: var(--dark-color);
}

.form-actions {
    display: flex;
    gap: 1rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
    margin-top: 2rem;
    align-items: center;
}

.input-group-text {
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-left: none;
    color: var(--text-muted);
}

.info-box {
    display: flex;
    align-items: flex-start;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid;
}

.info-box-warning {
    background: rgba(245, 158, 11, 0.05);
    border-left-color: var(--warning-color);
}

.info-box-warning .info-icon {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning-color);
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.info-content h5 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
}

.info-list {
    margin: 0;
    padding-left: 1.25rem;
    color: var(--text-muted);
}

.info-list li {
    margin-bottom: 0.25rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteData(id, label) {
    Swal.fire({
        title: 'Hapus Data?',
        text: `Yakin ingin menghapus data "${label}"? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.modern-form');
    const labelInput = document.getElementById('label');
    const jumlahInput = document.getElementById('jumlah');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate label
        if (!labelInput.value.trim()) {
            isValid = false;
            labelInput.classList.add('is-invalid');
        } else {
            labelInput.classList.remove('is-invalid');
        }
        
        // Validate jumlah
        if (!jumlahInput.value || jumlahInput.value < 0) {
            isValid = false;
            jumlahInput.classList.add('is-invalid');
        } else {
            jumlahInput.classList.remove('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Form Tidak Valid',
                text: 'Mohon lengkapi semua field yang diperlukan dengan benar.'
            });
        }
    });
    
    // Real-time validation
    labelInput.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });
    
    jumlahInput.addEventListener('input', function() {
        if (this.value >= 0) {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endpush
