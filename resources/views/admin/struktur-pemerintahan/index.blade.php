@extends('layout.admin-modern')
@section('title', 'Kelola Struktur Pemerintahan')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👥 Struktur Pemerintahan</h1>
            <p class="page-subtitle">Kelola hierarki aparatur pemerintahan desa</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.struktur-pemerintahan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Aparatur
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card bg-gradient-primary">
            <div class="stats-number">{{ $strukturList->where('kategori', 'kepala_desa')->count() }}</div>
            <div class="stats-label">Kepala Desa</div>
            <div class="stats-icon"><i class="fas fa-user-tie"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-gradient-success">
            <div class="stats-number">{{ $strukturList->where('kategori', 'sekretaris')->count() }}</div>
            <div class="stats-label">Sekretaris</div>
            <div class="stats-icon"><i class="fas fa-user-graduate"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-gradient-warning">
            <div class="stats-number">{{ $strukturList->where('kategori', 'kepala_urusan')->count() + $strukturList->where('kategori', 'kepala_seksi')->count() }}</div>
            <div class="stats-label">Kasi & Kaur</div>
            <div class="stats-icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-gradient-info">
            <div class="stats-number">{{ $strukturList->where('kategori', 'kepala_dusun')->count() }}</div>
            <div class="stats-label">Kepala Dusun</div>
            <div class="stats-icon"><i class="fas fa-map-marked-alt"></i></div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="table-container">
    <div class="table-header">
        <h3 class="table-title">Daftar Aparatur</h3>
        <div class="table-actions">
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Cari aparatur..." id="searchInput">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" id="strukturTable">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Kategori</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($strukturList as $struktur)
                <tr>
                    <td>
                        <div class="user-avatar">
                            @if($struktur->foto && file_exists(public_path($struktur->foto)))
                            <img src="{{ asset($struktur->foto) }}" alt="{{ $struktur->nama }}" class="avatar-img">
                            @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="user-info">
                            <div class="user-name">{{ $struktur->nama }}</div>
                            @if($struktur->pendidikan)
                            <div class="user-meta">{{ $struktur->pendidikan }}</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-outline-primary">{{ $struktur->jabatan }}</span>
                    </td>
                    <td>
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
                    </td>
                    <td>
                        <span class="text-center">{{ $struktur->urutan }}</span>
                    </td>
                    <td>
                        @if($struktur->is_active)
                        <span class="status-badge status-active">
                            <i class="fas fa-check-circle"></i> Aktif
                        </span>
                        @else
                        <span class="status-badge status-inactive">
                            <i class="fas fa-times-circle"></i> Tidak Aktif
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.struktur-pemerintahan.show', $struktur->id) }}" 
                               class="btn btn-sm btn-outline-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" 
                               class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    onclick="deleteStructure({{ $struktur->id }}, '{{ $struktur->nama }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-users text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">Belum ada data struktur pemerintahan</h5>
                            <p class="text-muted">Klik tombol "Tambah Aparatur" untuk menambahkan data</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($strukturList->hasPages())
    <div class="table-footer">
        {{ $strukturList->links() }}
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('styles')
<style>
.stats-card {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 1.5rem;
    border-radius: 12px;
    position: relative;
    overflow: hidden;
    margin-bottom: 1rem;
}

.bg-gradient-success { background: linear-gradient(135deg, #10b981, #059669) !important; }
.bg-gradient-warning { background: linear-gradient(135deg, #f59e0b, #d97706) !important; }
.bg-gradient-info { background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important; }

.stats-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.stats-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

.stats-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 2rem;
    opacity: 0.3;
}

.user-avatar {
    width: 50px;
    height: 50px;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: var(--border-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
}

.user-info .user-name {
    font-weight: 500;
    color: var(--dark-color);
}

.user-info .user-meta {
    font-size: 0.75rem;
    color: var(--text-muted);
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

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
}

.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-inactive {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.action-buttons {
    display: flex;
    gap: 0.25rem;
}

.search-box {
    position: relative;
}

.search-box i {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
}
</style>
@endsection

@section('scripts')
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#strukturTable tbody tr');
    
    rows.forEach(row => {
        const nama = row.cells[1].textContent.toLowerCase();
        const jabatan = row.cells[2].textContent.toLowerCase();
        
        if (nama.includes(searchTerm) || jabatan.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

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
