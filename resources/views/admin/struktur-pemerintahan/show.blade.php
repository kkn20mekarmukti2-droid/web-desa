@extends('layout.admin-modern')
@section('title', 'Detail Aparatur Pemerintahan')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👁️ Detail Aparatur Pemerintahan</h1>
            <p class="page-subtitle">Informasi lengkap: {{ $struktur->nama }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Aparatur
            </a>
        </div>
    </div>
</div>

<!-- Aparatur Detail Card -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <!-- Aparatur Photo -->
            <div class="col-md-5">
                <div class="product-image-container">
                    @if($struktur->foto && file_exists(public_path($struktur->foto)))
                    <img src="{{ asset($struktur->foto) }}" alt="{{ $struktur->nama }}" class="product-image">
                    @else
                    <div class="no-image">
                        <i class="fas fa-user"></i>
                        <p>Tidak ada foto</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Aparatur Info -->
            <div class="col-md-7">
                <div class="product-details">
                    <!-- Aparatur Name -->
                    <div class="detail-group mb-4">
                        <h2 class="product-title">{{ $struktur->nama }}</h2>
                        <div class="product-badge">
                            <i class="fas fa-user-tie"></i>
                            Aparatur Pemerintahan Desa Mekarmukti
                        </div>
                    </div>

                    <!-- Position & Category -->
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-briefcase text-primary"></i>
                            Jabatan & Kategori
                        </h5>
                        <p class="detail-content mb-2"><strong>{{ $struktur->jabatan }}</strong></p>
                        <div>
                            @switch($struktur->kategori)
                                @case('kepala_desa')
                                    <span class="badge bg-primary">Kepala Desa</span>
                                    @break
                                @case('sekretaris')
                                    <span class="badge bg-success">Sekretaris</span>
                                    @break
                                @case('kepala_urusan')
                                    <span class="badge bg-warning">Kepala Urusan</span>
                                    @break
                                @case('kepala_seksi')
                                    <span class="badge bg-info">Kepala Seksi</span>
                                    @break
                                @case('kepala_dusun')
                                    <span class="badge bg-secondary">Kepala Dusun</span>
                                    @break
                            @endswitch
                            
                            @if($struktur->is_active)
                                <span class="badge bg-success ms-1">Aktif</span>
                            @else
                                <span class="badge bg-danger ms-1">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-id-card text-success"></i>
                            Informasi Personal
                        </h5>
                        <div class="contact-info">
                            @if($struktur->nip)
                                <p class="detail-content mb-2"><strong>NIP:</strong> <span class="phone-number">{{ $struktur->nip }}</span></p>
                            @endif
                            @if($struktur->pendidikan)
                                <p class="detail-content mb-2"><strong>Pendidikan:</strong> {{ $struktur->pendidikan }}</p>
                            @endif
                            @if($struktur->alamat)
                                <p class="detail-content mb-2"><strong>Alamat:</strong> {{ $struktur->alamat }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Info -->
                    @if($struktur->telepon || $struktur->email)
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-phone text-info"></i>
                            Informasi Kontak
                        </h5>
                        <div class="contact-info">
                            @if($struktur->telepon)
                                <p class="detail-content mb-2">
                                    <strong>Telepon:</strong> 
                                    <span class="phone-number">{{ $struktur->telepon }}</span>
                                    <a href="tel:{{ $struktur->telepon }}" class="btn btn-success btn-sm ms-2">
                                        <i class="fas fa-phone"></i>
                                        Hubungi
                                    </a>
                                </p>
                            @endif
                            @if($struktur->email)
                                <p class="detail-content mb-2">
                                    <strong>Email:</strong> 
                                    <a href="mailto:{{ $struktur->email }}" class="text-primary">{{ $struktur->email }}</a>
                                </p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="detail-group mb-4">
                        <h5 class="detail-label">
                            <i class="fas fa-clock text-info"></i>
                            Informasi Sistem
                        </h5>
                        <div class="timestamps">
                            <small class="text-muted d-block">
                                <strong>Dibuat:</strong> {{ $struktur->created_at ? $struktur->created_at->format('d/m/Y H:i') : 'Tidak tersedia' }}
                            </small>
                            <small class="text-muted d-block">
                                <strong>Diperbarui:</strong> {{ $struktur->updated_at ? $struktur->updated_at->format('d/m/Y H:i') : 'Tidak tersedia' }}
                            </small>
                            <small class="text-muted d-block">
                                <strong>Urutan:</strong> {{ $struktur->urutan }}
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Edit Aparatur
                        </a>
                        
                        <button type="button" class="btn btn-danger" onclick="deleteAparatur({{ $struktur->id }}, '{{ $struktur->nama }}')">
                            <i class="fas fa-trash"></i>
                            Hapus Aparatur
                        </button>
                        
                        @if($struktur->telepon)
                        <a href="tel:{{ $struktur->telepon }}" class="btn btn-success">
                            <i class="fas fa-phone"></i>
                            Hubungi Telepon
                        </a>
                        @endif
                        
                        <a href="{{ route('pemerintahan') }}" target="_blank" class="btn btn-outline-info">
                            <i class="fas fa-external-link-alt"></i>
                            Lihat di Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Custom Styles - EXACT COPY FROM UMKM -->
<style>
.product-image-container {
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    text-align: center;
    color: #6c757d;
}

.no-image i {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.product-details {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.product-badge {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    display: inline-block;
}

.detail-group {
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 1rem;
}

.detail-group:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.detail-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-content {
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 0;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.phone-number {
    font-family: monospace;
    background: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 600;
}

.action-buttons {
    margin-top: auto;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.timestamps small {
    line-height: 1.4;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
    }
}
</style>

<!-- JavaScript -->
<script>
function deleteAparatur(id, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus aparatur "${name}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('admin/struktur-pemerintahan') }}/${id}`;
        form.submit();
    }
}
</script>

@endsection
