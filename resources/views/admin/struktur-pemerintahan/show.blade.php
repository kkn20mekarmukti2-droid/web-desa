@extends('layout.admin-modern')
@section('title', 'Detail Struktur Pemerintahan')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👥 Detail Aparatur</h1>
            <p class="page-subtitle">Informasi lengkap {{ $struktur->nama }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Data
            </a>
            <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Profile Card -->
    <div class="col-lg-4">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    @if($struktur->foto && file_exists(public_path($struktur->foto)))
                    <img src="{{ asset($struktur->foto) }}" alt="{{ $struktur->nama }}" class="avatar-image">
                    @else
                    <div class="avatar-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                    @endif
                    
                    <div class="profile-status">
                        @if($struktur->is_active)
                        <span class="status-badge status-active">
                            <i class="fas fa-check-circle"></i> Aktif
                        </span>
                        @else
                        <span class="status-badge status-inactive">
                            <i class="fas fa-times-circle"></i> Tidak Aktif
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="profile-info">
                    <h3 class="profile-name">{{ $struktur->nama }}</h3>
                    <p class="profile-position">{{ $struktur->jabatan }}</p>
                    @if($struktur->nip)
                    <p class="profile-nip">NIP: {{ $struktur->nip }}</p>
                    @endif
                </div>
            </div>

            <div class="profile-details">
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-layer-group"></i> Kategori
                    </div>
                    <div class="detail-value">
                        @switch($struktur->kategori)
                            @case('kepala_desa')
                                <span class="badge badge-primary">Kepala Desa</span>
                                @break
                            @case('sekretaris')
                                <span class="badge badge-success">Sekretaris</span>
                                @break
                            @case('kepala_urusan')
                                <span class="badge badge-warning">Kepala Urusan</span>
                                @break
                            @case('kepala_seksi')
                                <span class="badge badge-info">Kepala Seksi</span>
                                @break
                            @case('kepala_dusun')
                                <span class="badge badge-secondary">Kepala Dusun</span>
                                @break
                        @endswitch
                    </div>
                </div>

                @if($struktur->pendidikan)
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-graduation-cap"></i> Pendidikan
                    </div>
                    <div class="detail-value">{{ $struktur->pendidikan }}</div>
                </div>
                @endif

                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-sort"></i> Urutan
                    </div>
                    <div class="detail-value">{{ $struktur->urutan }}</div>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
                <button type="button" class="btn btn-outline-danger btn-block mt-2" 
                        onclick="deleteStructure({{ $struktur->id }}, '{{ $struktur->nama }}')">
                    <i class="fas fa-trash"></i> Hapus Data
                </button>
            </div>
        </div>
    </div>

    <!-- Detailed Information -->
    <div class="col-lg-8">
        <!-- Contact Information -->
        <div class="info-card">
            <div class="info-header">
                <h4 class="info-title">📞 Informasi Kontak</h4>
            </div>
            <div class="info-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt text-danger"></i> Alamat
                            </div>
                            <div class="info-value">
                                {{ $struktur->alamat ?? 'Tidak tersedia' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-phone text-success"></i> Telepon
                            </div>
                            <div class="info-value">
                                @if($struktur->telepon)
                                <a href="tel:{{ $struktur->telepon }}" class="text-decoration-none">
                                    {{ $struktur->telepon }}
                                </a>
                                @else
                                Tidak tersedia
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-envelope text-primary"></i> Email
                            </div>
                            <div class="info-value">
                                @if($struktur->email)
                                <a href="mailto:{{ $struktur->email }}" class="text-decoration-none">
                                    {{ $struktur->email }}
                                </a>
                                @else
                                Tidak tersedia
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="info-card">
            <div class="info-header">
                <h4 class="info-title">⚙️ Informasi Sistem</h4>
            </div>
            <div class="info-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-plus text-info"></i> Dibuat
                            </div>
                            <div class="info-value">
                                {{ $struktur->created_at ? $struktur->created_at->format('d M Y H:i') : 'Tidak tersedia' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-edit text-warning"></i> Diperbarui
                            </div>
                            <div class="info-value">
                                {{ $struktur->updated_at ? $struktur->updated_at->format('d M Y H:i') : 'Tidak tersedia' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="info-card">
            <div class="info-header">
                <h4 class="info-title">📊 Statistik Posisi</h4>
            </div>
            <div class="info-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-number">{{ $totalByCategory }}</div>
                            <div class="stat-label">Total {{ ucwords(str_replace('_', ' ', $struktur->kategori)) }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-number">{{ $totalActive }}</div>
                            <div class="stat-label">Total Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-number">{{ $struktur->urutan }}</div>
                            <div class="stat-label">Urutan dalam Struktur</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview in Public -->
        <div class="info-card">
            <div class="info-header">
                <h4 class="info-title">👁️ Pratinjau Publik</h4>
            </div>
            <div class="info-content">
                <div class="public-preview">
                    <div class="preview-card">
                        <div class="preview-avatar">
                            @if($struktur->foto && file_exists(public_path($struktur->foto)))
                            <img src="{{ asset($struktur->foto) }}" alt="{{ $struktur->nama }}">
                            @else
                            <div class="preview-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                        </div>
                        <div class="preview-info">
                            <h5 class="preview-name">{{ $struktur->nama }}</h5>
                            <p class="preview-position">{{ $struktur->jabatan }}</p>
                            @if($struktur->pendidikan)
                            <p class="preview-education">{{ $struktur->pendidikan }}</p>
                            @endif
                        </div>
                    </div>
                    <p class="preview-note">
                        <i class="fas fa-info-circle"></i>
                        Ini adalah tampilan bagaimana data akan muncul di halaman publik.
                    </p>
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

@endsection

@section('styles')
<style>
.profile-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.profile-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 2rem 1.5rem;
    text-align: center;
    position: relative;
}

.profile-avatar {
    margin-bottom: 1rem;
    position: relative;
}

.avatar-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 4px solid white;
    font-size: 2rem;
}

.profile-status {
    position: absolute;
    top: -10px;
    right: 50%;
    transform: translateX(50%);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-active {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.status-inactive {
    background: rgba(239, 68, 68, 0.9);
    color: white;
}

.profile-name {
    margin: 0 0 0.5rem 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.profile-position {
    margin: 0 0 0.25rem 0;
    font-size: 1rem;
    opacity: 0.9;
}

.profile-nip {
    margin: 0;
    font-size: 0.875rem;
    opacity: 0.8;
}

.profile-details {
    padding: 1.5rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 500;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-value {
    font-weight: 500;
    color: var(--dark-color);
}

.profile-actions {
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.info-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.info-header {
    background: var(--bg-light);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.info-title {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--dark-color);
}

.info-content {
    padding: 1.5rem;
}

.info-item {
    margin-bottom: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-value {
    font-size: 1rem;
    color: var(--dark-color);
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-primary { background: rgba(102, 126, 234, 0.1); color: var(--primary-color); }
.badge-success { background: rgba(16, 185, 129, 0.1); color: #059669; }
.badge-warning { background: rgba(245, 158, 11, 0.1); color: #d97706; }
.badge-info { background: rgba(59, 130, 246, 0.1); color: #1d4ed8; }
.badge-secondary { background: rgba(107, 114, 128, 0.1); color: #6b7280; }

.stat-box {
    text-align: center;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 8px;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: var(--primary-color);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.public-preview {
    text-align: center;
}

.preview-card {
    display: inline-block;
    background: var(--bg-light);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.preview-avatar {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
}

.preview-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.preview-placeholder {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 1.5rem;
}

.preview-name {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--dark-color);
}

.preview-position {
    font-size: 0.875rem;
    color: var(--primary-color);
    margin-bottom: 0.25rem;
}

.preview-education {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin: 0;
}

.preview-note {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
</style>
@endsection

@section('scripts')
<script>
// Delete confirmation
function deleteStructure(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus ${nama} dari struktur pemerintahan?\n\nData yang dihapus tidak dapat dikembalikan.`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/struktur-pemerintahan/${id}`;
        form.submit();
    }
}

// Success/Error alerts
@if(session('success'))
    toastr.success('{{ session('success') }}');
@endif

@if(session('error'))
    toastr.error('{{ session('error') }}');
@endif
</script>
@endsection
