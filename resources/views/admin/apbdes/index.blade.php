@extends('admin.layout.admin-modern')

@section('title', 'Kelola APBDes')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">📊 Kelola APBDes</h1>
            <p class="text-muted">Kelola dokumen transparansi anggaran desa</p>
        </div>
        <a href="{{ route('admin.apbdes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah APBDes
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total APBDes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $apbdes->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $apbdes->where('is_active', true)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Non-Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $apbdes->where('is_active', false)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tahun Terbaru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $apbdes->max('tahun') ?? 'N/A' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- APBDes Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar APBDes</h6>
        </div>
        <div class="card-body">
            @if($apbdes->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum Ada Data APBDes</h5>
                    <p class="text-muted">Mulai dengan menambahkan dokumen APBDes pertama</p>
                    <a href="{{ route('admin.apbdes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah APBDes
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="apbdesTable">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Gambar</th>
                                <th width="25%">Judul</th>
                                <th width="15%">Tahun</th>
                                <th width="15%">Status</th>
                                <th width="15%">Tanggal</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($apbdes as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img 
                                        src="{{ asset('storage/' . $item->image_path) }}" 
                                        alt="{{ $item->title }}"
                                        class="img-thumbnail"
                                        style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;"
                                        onclick="showImagePreview('{{ asset('storage/' . $item->image_path) }}', '{{ $item->title }}')"
                                    >
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $item->title }}</div>
                                    @if($item->description)
                                        <small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $item->tahun }}</span>
                                </td>
                                <td>
                                    <button 
                                        class="btn btn-sm {{ $item->is_active ? 'btn-success' : 'btn-secondary' }}"
                                        onclick="toggleStatus({{ $item->id }}, {{ $item->is_active ? 'false' : 'true' }})"
                                    >
                                        <i class="fas {{ $item->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </td>
                                <td>
                                    <small>{{ $item->created_at->format('d M Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.apbdes.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }}, '{{ $item->title }}')" title="Hapus">
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

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalTitle">Preview Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-warning fa-3x"></i>
                </div>
                <p class="text-center">Apakah Anda yakin ingin menghapus APBDes ini?</p>
                <p class="text-center fw-bold" id="deleteItemName"></p>
                <p class="text-center text-muted"><small>Data yang dihapus tidak dapat dikembalikan!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#apbdesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 10,
        "order": [[ 5, "desc" ]]
    });
});

function showImagePreview(imageSrc, title) {
    $('#previewImage').attr('src', imageSrc);
    $('#previewModalTitle').text(title);
    $('#imagePreviewModal').modal('show');
}

function toggleStatus(id, newStatus) {
    if (confirm('Apakah Anda yakin ingin mengubah status APBDes ini?')) {
        fetch(`/admin/apbdes/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                is_active: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan saat mengubah status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status');
        });
    }
}

function confirmDelete(id, title) {
    $('#deleteItemName').text(title);
    $('#deleteForm').attr('action', `/admin/apbdes/${id}`);
    $('#deleteModal').modal('show');
}
</script>
@endpush
