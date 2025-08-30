@extends('layout.admin-modern')

@section('title', 'Tambah Data Statistik')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">➕ Tambah Data Statistik</h1>
            <p class="page-subtitle">Tambahkan data statistik baru untuk kategori {{ $kategoriOptions[$kategori] }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.statistik.index', ['kategori' => $kategori]) }}" class="btn btn-outline-primary">
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
            @switch($kategori)
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
            Form Data {{ $kategoriOptions[$kategori] }}
        </h3>
        <p class="card-subtitle">Lengkapi form dibawah untuk menambahkan data statistik baru</p>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.statistik.store') }}" method="POST" class="modern-form">
            @csrf
            
            <!-- Hidden Kategori Field -->
            <input type="hidden" name="kategori" value="{{ $kategori }}">
            
            <div class="row">
                <!-- Kategori Display (Read-only) -->
                <div class="col-md-6 mb-4">
                    <label class="form-label required">
                        <i class="fas fa-tag me-1"></i>Kategori Data
                    </label>
                    <div class="form-control-static">
                        <div class="category-display">
                            <div class="category-icon">
                                @switch($kategori)
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
                            <span class="category-name">{{ $kategoriOptions[$kategori] }}</span>
                        </div>
                    </div>
                    <small class="form-text">Kategori yang dipilih untuk data statistik ini</small>
                </div>

                <!-- Change Category -->
                <div class="col-md-6 mb-4">
                    <label class="form-label">
                        <i class="fas fa-exchange-alt me-1"></i>Ganti Kategori
                    </label>
                    <select class="form-select modern-select" onchange="changeCategory(this.value)">
                        @foreach($kategoriOptions as $key => $label)
                            <option value="{{ $key }}" {{ $kategori == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text">Pilih kategori lain jika diperlukan</small>
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
                           value="{{ old('label') }}" 
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
                               value="{{ old('jumlah') }}" 
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
                          placeholder="Tambahkan deskripsi atau informasi tambahan tentang data ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Informasi tambahan tentang data statistik (opsional)</small>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
                <a href="{{ route('admin.statistik.index', ['kategori' => $kategori]) }}" 
                   class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Helper Card -->
<div class="content-card mt-4">
    <div class="info-box info-box-success">
        <div class="info-icon">
            <i class="fas fa-lightbulb"></i>
        </div>
        <div class="info-content">
            <h5>Tips Pengisian Data</h5>
            <ul class="info-list">
                <li><strong>Label:</strong> Gunakan nama yang jelas dan mudah dipahami</li>
                <li><strong>Jumlah:</strong> Pastikan angka yang dimasukkan akurat dan terbaru</li>
                <li><strong>Deskripsi:</strong> Tambahkan informasi tambahan jika diperlukan</li>
                <li><strong>Kategori:</strong> Pilih kategori yang sesuai dengan data yang akan ditambahkan</li>
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

.form-actions {
    display: flex;
    gap: 1rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
    margin-top: 2rem;
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

.info-box-success {
    background: rgba(16, 185, 129, 0.05);
    border-left-color: var(--success-color);
}

.info-box-success .info-icon {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
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
function changeCategory(newKategori) {
    if (newKategori !== '{{ $kategori }}') {
        window.location.href = `{{ route('admin.statistik.create') }}?kategori=${newKategori}`;
    }
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
