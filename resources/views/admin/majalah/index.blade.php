@extends('layout.admin-modern')

@section('title', 'Kelola Majalah Desa')

@section('content')
<div class="main-content">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">📚 Kelola Majalah Desa</h1>
            <p class="page-subtitle">Manajemen majalah digital desa dengan fitur flip book interaktif</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.majalah.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Majalah Baru
            </a>
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Success Alert -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $majalah->count() }}</h3>
                            <p>Total Majalah</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $majalah->where('is_active', true)->count() }}</h3>
                            <p>Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-eye-slash"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $majalah->where('is_active', false)->count() }}</h3>
                            <p>Nonaktif</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-file-image"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $majalah->sum('total_pages') }}</h3>
                            <p>Total Halaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Majalah Table -->
        <div class="data-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-list me-2"></i>Daftar Majalah Desa
                </h2>
                <p class="card-subtitle">Kelola majalah digital dengan fitur interaktif untuk masyarakat</p>
            </div>

            <div class="card-body">
                @if($majalah->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-book-open empty-icon"></i>
                    <h3>Belum Ada Majalah</h3>
                    <p>Belum ada majalah yang dibuat. Mulai buat majalah pertama untuk menampilkan konten desa dalam format interaktif.</p>
                    
                    <div class="empty-tips">
                        <h5>💡 Tips Majalah Desa:</h5>
                        <ul>
                            <li>Siapkan gambar cover menarik dan berkualitas tinggi</li>
                            <li>Upload halaman dalam format JPG/PNG dengan resolusi yang baik</li>
                            <li>Urutkan halaman sesuai alur cerita yang logis</li>
                            <li>Gunakan majalah untuk showcase sejarah, UMKM, dan potensi desa</li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('admin.majalah.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Buat Majalah Pertama
                    </a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-header">
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Cover</th>
                                <th width="25%">Judul Majalah</th>
                                <th width="15%">Tanggal Terbit</th>
                                <th width="10%">Halaman</th>
                                <th width="10%">Status</th>
                                <th width="25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($majalah as $index => $item)
                            <tr>
                                <td><span class="badge bg-primary">{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="magazine-cover">
                                        @if($item->cover_image && file_exists(public_path($item->cover_image)))
                                            <img src="{{ asset($item->cover_image) }}" 
                                                 alt="Cover {{ $item->judul }}"
                                                 class="img-thumbnail"
                                                 style="width: 60px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="img-thumbnail d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <i class="fas fa-book text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="magazine-info">
                                        <strong>{{ $item->judul }}</strong>
                                        @if($item->deskripsi)
                                            <br><small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $item->tanggal_terbit->format('d M Y') }}</span>
                                    <br><small class="text-secondary">{{ $item->tanggal_terbit_formatted }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $item->total_pages }} halaman</span>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" 
                                               type="checkbox" 
                                               {{ $item->is_active ? 'checked' : '' }}
                                               data-id="{{ $item->id }}"
                                               data-url="{{ route('admin.majalah.toggle', $item->id) }}">
                                        <label class="form-check-label">
                                            <small class="text-{{ $item->is_active ? 'success' : 'muted' }}">
                                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </small>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.majalah.show', $item->id) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.majalah.edit', $item->id) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit Majalah">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('majalah.desa') }}#majalah-{{ $item->id }}" 
                                           class="btn btn-sm btn-outline-success" 
                                           title="Preview Public"
                                           target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger delete-btn" 
                                                data-id="{{ $item->id }}"
                                                data-title="{{ $item->judul }}"
                                                title="Hapus Majalah">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Majalah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus majalah <strong id="deleteTitle"></strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Peringatan:</strong> Semua halaman dan gambar terkait akan ikut terhapus secara permanen!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Hapus Majalah
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const url = this.dataset.url;
            
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const label = this.parentNode.querySelector('label small');
                    if (data.is_active) {
                        label.textContent = 'Aktif';
                        label.className = 'text-success';
                    } else {
                        label.textContent = 'Nonaktif';
                        label.className = 'text-muted';
                    }
                    
                    // Show toast notification
                    showToast(data.message, 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked; // Revert toggle
                showToast('Terjadi kesalahan saat mengubah status', 'error');
            });
        });
    });

    // Delete Magazine
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const title = this.dataset.title;
            
            document.getElementById('deleteTitle').textContent = title;
            document.getElementById('deleteForm').action = `/admin/majalah/${id}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});

function showToast(message, type) {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}
</script>

<style>
.magazine-cover img {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.magazine-cover img:hover {
    transform: scale(1.1);
}

.stat-card {
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.btn-group .btn {
    margin-right: 2px;
}
</style>
@endsection
