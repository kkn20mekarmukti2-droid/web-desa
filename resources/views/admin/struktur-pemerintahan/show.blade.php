@extends('layout.admin-modern')
@section('title', 'Detail Aparatur')
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
                    <li class="breadcrumb-item active">{{ $struktur->nama }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-1">👤 Detail Aparatur</h2>
                    <p class="text-muted mb-0">Informasi lengkap {{ $struktur->nama }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <!-- Simple Photo Display -->
                    <div class="profile-photo-large mb-3">
                        @if($struktur->foto && file_exists(public_path($struktur->foto)))
                            <img src="{{ asset($struktur->foto) }}" 
                                 alt="{{ $struktur->nama }}" 
                                 class="profile-photo-img">
                        @else
                            <div class="profile-photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>

                    <h4 class="fw-bold mb-1">{{ $struktur->nama }}</h4>
                    <p class="text-primary mb-2">{{ $struktur->jabatan }}</p>
                    
                    @if($struktur->nip)
                        <p class="text-muted small mb-3">NIP: {{ $struktur->nip }}</p>
                    @endif

                    <!-- Status Badge -->
                    @if($struktur->is_active)
                        <span class="badge bg-success mb-3">
                            <i class="fas fa-check me-1"></i>Status Aktif
                        </span>
                    @else
                        <span class="badge bg-danger mb-3">
                            <i class="fas fa-times me-1"></i>Tidak Aktif
                        </span>
                    @endif

                    <!-- Quick Actions -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit Data
                        </a>
                        <button type="button" class="btn btn-outline-danger" 
                                onclick="confirmDelete({{ $struktur->id }}, '{{ $struktur->nama }}')">
                            <i class="fas fa-trash me-1"></i>Hapus Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Cards -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">📋 Informasi Dasar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-bold">KATEGORI</label>
                                <div>
                                    @switch($struktur->kategori)
                                        @case('kepala_desa')
                                            <span class="badge bg-primary-subtle text-primary">Kepala Desa</span>
                                            @break
                                        @case('sekretaris')
                                            <span class="badge bg-success-subtle text-success">Sekretaris</span>
                                            @break
                                        @case('kepala_urusan')
                                            <span class="badge bg-warning-subtle text-warning">Kepala Urusan</span>
                                            @break
                                        @case('kepala_seksi')
                                            <span class="badge bg-info-subtle text-info">Kepala Seksi</span>
                                            @break
                                        @case('kepala_dusun')
                                            <span class="badge bg-secondary-subtle text-secondary">Kepala Dusun</span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-bold">URUTAN</label>
                                <div class="fw-bold">{{ $struktur->urutan }}</div>
                            </div>
                        </div>
                    </div>

                    @if($struktur->pendidikan)
                    <div class="info-item mb-3">
                        <label class="text-muted small fw-bold">PENDIDIKAN</label>
                        <div class="fw-bold">{{ $struktur->pendidikan }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">📞 Informasi Kontak</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($struktur->alamat)
                        <div class="col-12">
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-bold">ALAMAT</label>
                                <div>{{ $struktur->alamat }}</div>
                            </div>
                        </div>
                        @endif

                        @if($struktur->telepon)
                        <div class="col-sm-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-bold">TELEPON</label>
                                <div>
                                    <a href="tel:{{ $struktur->telepon }}" class="text-decoration-none">
                                        <i class="fas fa-phone me-1 text-success"></i>{{ $struktur->telepon }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($struktur->email)
                        <div class="col-sm-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-bold">EMAIL</label>
                                <div>
                                    <a href="mailto:{{ $struktur->email }}" class="text-decoration-none">
                                        <i class="fas fa-envelope me-1 text-primary"></i>{{ $struktur->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if(!$struktur->alamat && !$struktur->telepon && !$struktur->email)
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Informasi kontak belum tersedia
                    </div>
                    @endif
                </div>
            </div>

            <!-- System Information -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">⚙️ Informasi Sistem</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-bold">DIBUAT</label>
                                <div>{{ $struktur->created_at ? $struktur->created_at->format('d M Y H:i') : 'Tidak tersedia' }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-bold">DIPERBARUI</label>
                                <div>{{ $struktur->updated_at ? $struktur->updated_at->format('d M Y H:i') : 'Tidak tersedia' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('styles')
<style>
/* Optimized Photo Styling - Similar to UMKM products */
.profile-photo-large {
    width: 120px;
    height: 120px;
    margin: 0 auto;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #dee2e6;
    background: #f8f9fa;
}

.profile-photo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.profile-photo-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 2rem;
}

/* Info Items */
.info-item label {
    display: block;
    margin-bottom: 0.25rem;
    letter-spacing: 0.5px;
}

/* Badge Styling */
.badge {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
}

/* Card Enhancements */
.card-header {
    border-bottom: 1px solid #dee2e6;
}
</style>
@endsection

@section('scripts')
<script>
// Delete Confirmation
function confirmDelete(id, nama) {
    if (confirm(`Hapus ${nama} dari struktur pemerintahan?\n\nData yang dihapus tidak dapat dikembalikan.`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/struktur-pemerintahan/${id}`;
        form.submit();
    }
}

// Success/Error Messages
@if(session('success'))
    alert('✅ {{ session('success') }}');
@endif

@if(session('error'))
    alert('❌ {{ session('error') }}');
@endif
</script>
@endsection
