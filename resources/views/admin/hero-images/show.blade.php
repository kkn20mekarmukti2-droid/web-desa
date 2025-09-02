@extends('layout.admin-modern')
@section('title', 'Detail Gambar Hero')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👁️ Detail Gambar Hero</h1>
            <p class="page-subtitle">{{ $heroImage->nama_gambar }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.hero-images.edit', $heroImage->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                Edit
            </a>
            <a href="{{ route('admin.hero-images.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Detail Content -->
<div class="row">
    <!-- Image Column -->
    <div class="col-md-5">
        <div class="image-container">
            @if($heroImage->gambar && file_exists(public_path($heroImage->gambar)))
                <img src="{{ asset($heroImage->gambar) }}" alt="{{ $heroImage->nama_gambar }}" class="hero-image">
            @elseif($heroImage->gambar && file_exists(public_path('storage/' . $heroImage->gambar)))
                <img src="{{ asset('storage/' . $heroImage->gambar) }}" alt="{{ $heroImage->nama_gambar }}" class="hero-image">
            @else
                <div class="no-image">
                    <i class="fas fa-image"></i>
                    <p>Gambar tidak ditemukan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Details Column -->
    <div class="col-md-7">
        <div class="details-card">
            <div class="detail-header">
                <h2>{{ $heroImage->nama_gambar }}</h2>
                <div class="status-badges">
                    <span class="status-badge {{ $heroImage->is_active ? 'active' : 'inactive' }}">
                        <i class="fas {{ $heroImage->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        {{ $heroImage->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <div class="detail-body">
                <div class="detail-group">
                    <div class="detail-label">
                        <i class="fas fa-sort-numeric-up"></i>
                        Urutan
                    </div>
                    <div class="detail-value">{{ $heroImage->urutan }}</div>
                </div>

                @if($heroImage->deskripsi)
                <div class="detail-group">
                    <div class="detail-label">
                        <i class="fas fa-align-left"></i>
                        Deskripsi
                    </div>
                    <div class="detail-value">{{ $heroImage->deskripsi }}</div>
                </div>
                @endif

                <div class="detail-group">
                    <div class="detail-label">
                        <i class="fas fa-calendar-plus"></i>
                        Ditambahkan
                    </div>
                    <div class="detail-value">
                        {{ $heroImage->created_at->format('d F Y, H:i') }} WIB
                        <small class="text-muted">({{ $heroImage->created_at->diffForHumans() }})</small>
                    </div>
                </div>

                @if($heroImage->updated_at != $heroImage->created_at)
                <div class="detail-group">
                    <div class="detail-label">
                        <i class="fas fa-calendar-edit"></i>
                        Terakhir Diupdate
                    </div>
                    <div class="detail-value">
                        {{ $heroImage->updated_at->format('d F Y, H:i') }} WIB
                        <small class="text-muted">({{ $heroImage->updated_at->diffForHumans() }})</small>
                    </div>
                </div>
                @endif

                @if($heroImage->gambar)
                <div class="detail-group">
                    <div class="detail-label">
                        <i class="fas fa-file-image"></i>
                        File Gambar
                    </div>
                    <div class="detail-value">
                        {{ basename($heroImage->gambar) }}
                        @if(file_exists(public_path($heroImage->gambar)))
                            <small class="text-success d-block">
                                <i class="fas fa-check-circle"></i> File tersedia
                                ({{ number_format(filesize(public_path($heroImage->gambar)) / 1024, 2) }} KB)
                            </small>
                        @else
                            <small class="text-danger d-block">
                                <i class="fas fa-exclamation-triangle"></i> File tidak ditemukan
                            </small>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('admin.hero-images.edit', $heroImage->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                    Edit Gambar
                </a>
                
                <form action="{{ route('admin.hero-images.destroy', $heroImage->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus gambar {{ $heroImage->nama_gambar }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
.image-container {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 1rem;
}

.hero-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 400px;
    background: #f8fafc;
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    color: #9ca3af;
}

.no-image i {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.details-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    height: fit-content;
}

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.detail-header h2 {
    color: #1f2937;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.status-badges {
    display: flex;
    gap: 0.5rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
}

.status-badge.inactive {
    background: #fef2f2;
    color: #991b1b;
}

.detail-body {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.detail-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.detail-label i {
    color: #6b7280;
    width: 16px;
}

.detail-value {
    color: #1f2937;
    font-size: 1rem;
    line-height: 1.5;
    margin-left: 1.5rem;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f3f4f6;
}

.action-buttons .btn {
    flex: 1;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .row {
        flex-direction: column-reverse;
    }
    
    .image-container {
        margin-top: 1rem;
        margin-bottom: 0;
    }
    
    .hero-image {
        height: 250px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        flex: none;
    }
    
    .detail-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .status-badges {
        width: 100%;
    }
}
</style>
@endsection
