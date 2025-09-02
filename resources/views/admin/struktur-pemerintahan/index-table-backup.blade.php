@extends('layout.admin-modern')
@section('title', 'Kelola Struktur Pemerintahan')
@section('content')

<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-1">👥 Struktur Pemerintahan</h2>
                    <p class="text-muted mb-0">Kelola data aparatur pemerintahan desa</p>
                </div>
                <div>
                    <a href="{{ route('admin.struktur-pemerintahan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Aparatur
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-primary rounded">
                                <i class="fas fa-user-tie text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $strukturList->where('kategori', 'kepala_desa')->count() }}</h6>
                            <p class="text-muted mb-0 small">Kepala Desa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-success rounded">
                                <i class="fas fa-user-graduate text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $strukturList->where('kategori', 'sekretaris')->count() }}</h6>
                            <p class="text-muted mb-0 small">Sekretaris</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-warning rounded">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $strukturList->whereIn('kategori', ['kepala_urusan', 'kepala_seksi'])->count() }}</h6>
                            <p class="text-muted mb-0 small">Kasi & Kaur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-info rounded">
                                <i class="fas fa-map-marked-alt text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $strukturList->where('kategori', 'kepala_dusun')->count() }}</h6>
                            <p class="text-muted mb-0 small">Kepala Dusun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">Daftar Aparatur</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text border-0 bg-light">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" 
                               placeholder="Cari aparatur..." id="searchBox">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4">Aparatur</th>
                            <th class="border-0">Jabatan</th>
                            <th class="border-0">Kategori</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Urutan</th>
                            <th class="border-0 pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="aparaturTable">
                        @forelse($strukturList as $struktur)
                        <tr class="searchable-row">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <!-- Photo dengan frame sederhana tapi jelas -->
                                    <div class="profile-photo me-3">
                                        @if($struktur->foto && file_exists(public_path($struktur->foto)))
                                            <img src="{{ asset($struktur->foto) }}" 
                                                 alt="{{ $struktur->nama }}" 
                                                 class="profile-img">
                                        @else
                                            <div class="profile-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $struktur->nama }}</h6>
                                        @if($struktur->pendidikan)
                                            <small class="text-muted">{{ $struktur->pendidikan }}</small>
                                        @endif
                                        @if($struktur->nip)
                                            <br><small class="text-muted">NIP: {{ $struktur->nip }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="fw-medium">{{ $struktur->jabatan }}</span>
                            </td>
                            <td class="py-3">
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
                            </td>
                            <td class="py-3">
                                @if($struktur->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="badge bg-light text-dark">{{ $struktur->urutan }}</span>
                            </td>
                            <td class="pe-4 py-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.struktur-pemerintahan.show', $struktur->id) }}" 
                                       class="btn btn-outline-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.struktur-pemerintahan.edit', $struktur->id) }}" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $struktur->id }}, '{{ $struktur->nama }}')" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-center">
                                    <i class="fas fa-users text-muted mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="text-muted">Belum ada data struktur pemerintahan</h6>
                                    <small class="text-muted">Klik "Tambah Aparatur" untuk menambahkan data baru</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($strukturList->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $strukturList->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('styles')
<style>
/* Photo Styling - Smaller, consistent like UMKM products */
.profile-photo {
    width: 40px;
    height: 40px;
    border-radius: 6px;
    overflow: hidden;
    border: 1px solid #dee2e6;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.profile-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.profile-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 0.8rem;
}

/* Stats Cards */
.avatar-sm {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

/* Table Enhancements */
.table > :not(caption) > * > * {
    padding: 0.75rem 0.75rem;
    border-bottom-width: 1px;
}

.table-hover > tbody > tr:hover > * {
    background-color: rgba(13, 110, 253, 0.04);
}

/* Badge Styling */
.badge {
    font-weight: 500;
    font-size: 0.75rem;
}

/* Search Enhancement */
#searchBox {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

#searchBox:focus {
    background-color: #fff;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .profile-photo {
        width: 36px;
        height: 36px;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Simple Search Function
document.getElementById('searchBox').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.searchable-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

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
