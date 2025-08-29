@extends('layout.admin-modern')

@section('title', 'Kelola RT/RW')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">🏘️ Kelola RT/RW</h1>
            <p class="page-subtitle">Kelola data pengurus RT dan RW dengan sistem manajemen yang terstruktur</p>
        </div>
        <div class="page-actions">
            <button onclick="openAddRWModal()" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i>
                Tambah RW
            </button>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="stats-grid mb-4">
    <div class="stats-card">
        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-home"></i>
        </div>
        <div class="stats-value">{{ $rw->count() }}</div>
        <div class="stats-label">Total RW</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-success bg-opacity-10 text-success">
            <i class="fas fa-building"></i>
        </div>
        <div class="stats-value">{{ $rt->count() }}</div>
        <div class="stats-label">Total RT</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-info bg-opacity-10 text-info">
            <i class="fas fa-users"></i>
        </div>
        <div class="stats-value">{{ $rw->whereNotNull('nama')->count() }}</div>
        <div class="stats-label">RW dengan Ketua</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stats-value">{{ $rt->whereNotNull('nama')->count() }}</div>
        <div class="stats-label">RT dengan Ketua</div>
    </div>
</div>

<!-- RW Management -->
<div class="row">
    @foreach($rw as $rwItem)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 fade-in-up">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    <i class="fas fa-home text-primary me-2"></i>
                    RW {{ $rwItem->rw }}
                </h5>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="editRW({{ $rwItem->id }}, '{{ $rwItem->rw }}', '{{ $rwItem->nama }}', '{{ $rwItem->kontak }}')">
                            <i class="fas fa-edit me-2"></i>Edit RW
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="addRTToRW({{ $rwItem->id }}, '{{ $rwItem->rw }}')">
                            <i class="fas fa-plus me-2"></i>Tambah RT
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteRW({{ $rwItem->id }}, '{{ $rwItem->rw }}')">
                            <i class="fas fa-trash me-2"></i>Hapus RW
                        </a></li>
                    </ul>
                </div>
            </div>
            
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="fas fa-user me-2"></i>
                        <span><strong>Ketua:</strong> {{ $rwItem->nama ?: 'Belum diisi' }}</span>
                    </div>
                    @if($rwItem->kontak)
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <span>{{ $rwItem->kontak }}</span>
                    </div>
                    @endif
                </div>
                
                <!-- RT List -->
                <h6 class="fw-bold mb-3">Daftar RT:</h6>
                @php
                    $rwRTs = $rt->where('rw', $rwItem->rw);
                @endphp
                
                @if($rwRTs->count() > 0)
                <div class="rt-list">
                    @foreach($rwRTs as $rtItem)
                    <div class="rt-item d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-building text-info me-2"></i>
                            <div>
                                <span class="fw-medium">RT {{ $rtItem->rt }}</span>
                                <small class="text-muted d-block">{{ $rtItem->nama ?: 'Belum ada ketua' }}</small>
                                @if($rtItem->kontak)
                                <small class="text-muted d-block">{{ $rtItem->kontak }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <button onclick="editRT({{ $rtItem->id }}, '{{ $rtItem->rt }}', '{{ $rtItem->nama }}', '{{ $rtItem->kontak }}')" 
                                class="btn btn-outline-warning" title="Edit RT">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteRT({{ $rtItem->id }}, '{{ $rtItem->rt }}')" 
                                class="btn btn-outline-danger" title="Hapus RT">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-building fa-2x mb-2 opacity-50"></i>
                    <p class="mb-2">Belum ada RT</p>
                    <button onclick="addRTToRW({{ $rwItem->id }}, '{{ $rwItem->rw }}')" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> Tambah RT Pertama
                    </button>
                </div>
                @endif
            </div>
            
            <div class="card-footer bg-light">
                <small class="text-muted">
                    Total RT: {{ $rwRTs->count() }} | 
                    RT dengan Ketua: {{ $rwRTs->whereNotNull('nama')->count() }}
                </small>
            </div>
        </div>
    </div>
    @endforeach
    
    @if($rw->count() == 0)
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-home fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-muted mb-2">Belum ada data RW</h4>
                <p class="text-muted mb-4">Mulai tambahkan RW pertama untuk mengelola pengurus RW di desa</p>
                <button onclick="openAddRWModal()" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah RW Pertama
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Add RW Modal -->
<div class="modal fade" id="addRWModal" tabindex="-1" aria-labelledby="addRWModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRWModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    Tambah RW Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addRWForm" action="{{ route('rw.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomorRW" class="form-label">Nomor RW</label>
                        <input type="number" class="form-control" id="nomorRW" name="nomor_rw" required placeholder="Contoh: 1">
                    </div>
                    <div class="mb-3">
                        <label for="namaRW" class="form-label">Nama Ketua RW</label>
                        <input type="text" class="form-control" id="namaRW" name="nama" required placeholder="Nama lengkap ketua RW">
                    </div>
                    <div class="mb-3">
                        <label for="kontakRW" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="kontakRW" name="kontak" placeholder="Nomor telepon/WhatsApp">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Simpan RW
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add RT Modal -->
<div class="modal fade" id="addRTModal" tabindex="-1" aria-labelledby="addRTModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRTModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    Tambah RT ke <span id="targetRW"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addRTForm" action="{{ route('rt.store') }}" method="POST">
                @csrf
                <input type="hidden" id="rwId" name="rw_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomorRT" class="form-label">Nomor RT</label>
                        <input type="number" class="form-control" id="nomorRT" name="nomor_rt" required placeholder="Contoh: 1">
                    </div>
                    <div class="mb-3">
                        <label for="namaRT" class="form-label">Nama Ketua RT</label>
                        <input type="text" class="form-control" id="namaRT" name="nama" required placeholder="Nama lengkap ketua RT">
                    </div>
                    <div class="mb-3">
                        <label for="kontakRT" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="kontakRT" name="kontak" placeholder="Nomor telepon/WhatsApp">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Simpan RT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit RW Modal -->
<div class="modal fade" id="editRWModal" tabindex="-1" aria-labelledby="editRWModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRWModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Edit RW
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRWForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNomorRW" class="form-label">Nomor RW</label>
                        <input type="number" class="form-control" id="editNomorRW" name="nomor_rw" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNamaRW" class="form-label">Nama Ketua RW</label>
                        <input type="text" class="form-control" id="editNamaRW" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKontakRW" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="editKontakRW" name="kontak">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Update RW
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit RT Modal -->
<div class="modal fade" id="editRTModal" tabindex="-1" aria-labelledby="editRTModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRTModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Edit RT
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRTForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNomorRT" class="form-label">Nomor RT</label>
                        <input type="number" class="form-control" id="editNomorRT" name="nomor_rt" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNamaRT" class="form-label">Nama Ketua RT</label>
                        <input type="text" class="form-control" id="editNamaRT" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKontakRT" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="editKontakRT" name="kontak">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Update RT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden Delete Forms -->
@foreach($rw as $rwItem)
<form id="deleteRWForm{{ $rwItem->id }}" action="{{ route('rw.delete', $rwItem->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endforeach

@foreach($rt as $rtItem)
<form id="deleteRTForm{{ $rtItem->id }}" action="{{ route('rt.delete', $rtItem->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endforeach

@endsection

@push('styles')
<style>
    .rt-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .rt-item:hover {
        background-color: rgba(102, 126, 234, 0.1) !important;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function openAddRWModal() {
        const modal = new bootstrap.Modal(document.getElementById('addRWModal'));
        document.getElementById('addRWForm').reset();
        modal.show();
    }

    function addRTToRW(rwId, nomorRW) {
        const modal = new bootstrap.Modal(document.getElementById('addRTModal'));
        document.getElementById('rwId').value = rwId;
        document.getElementById('targetRW').textContent = `RW ${nomorRW}`;
        document.getElementById('addRTForm').reset();
        modal.show();
    }

    function editRW(id, nomor, nama, kontak) {
        const modal = new bootstrap.Modal(document.getElementById('editRWModal'));
        document.getElementById('editRWForm').action = `/admin/rw/update/${id}`;
        document.getElementById('editNomorRW').value = nomor;
        document.getElementById('editNamaRW').value = nama || '';
        document.getElementById('editKontakRW').value = kontak || '';
        modal.show();
    }

    function editRT(id, nomor, nama, kontak) {
        const modal = new bootstrap.Modal(document.getElementById('editRTModal'));
        document.getElementById('editRTForm').action = `/admin/rt/update/${id}`;
        document.getElementById('editNomorRT').value = nomor;
        document.getElementById('editNamaRT').value = nama || '';
        document.getElementById('editKontakRT').value = kontak || '';
        modal.show();
    }

    function deleteRW(id, nomor) {
        if (confirm(`Apakah Anda yakin ingin menghapus RW ${nomor}?\n\nSemua RT di dalam RW ini juga akan terhapus.`)) {
            showLoading();
            document.getElementById('deleteRWForm' + id).submit();
        }
    }

    function deleteRT(id, nomor) {
        if (confirm(`Apakah Anda yakin ingin menghapus RT ${nomor}?`)) {
            showLoading();
            document.getElementById('deleteRTForm' + id).submit();
        }
    }

    // Form submissions with loading
    document.getElementById('addRWForm').addEventListener('submit', function() {
        showLoading();
    });

    document.getElementById('addRTForm').addEventListener('submit', function() {
        showLoading();
    });

    document.getElementById('editRWForm').addEventListener('submit', function() {
        showLoading();
    });

    document.getElementById('editRTForm').addEventListener('submit', function() {
        showLoading();
    });
</script>
@endpush
