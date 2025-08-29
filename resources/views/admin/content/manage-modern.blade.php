@extends('layout.admin-modern')

@section('title', 'Kelola Konten')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">📰 Kelola Konten</h1>
            <p class="page-subtitle">Tambah, edit, dan kelola semua artikel website desa dengan interface yang modern dan mudah digunakan</p>
        </div>
        <div class="page-actions">
            <button onclick="openCategoryModal()" class="btn btn-outline-primary">
                <i class="fas fa-tag"></i>
                Kelola Kategori
            </button>
            <a href="{{ route('addartikel') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Artikel
            </a>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="stats-grid mb-4">
    <div class="stats-card">
        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="stats-value">{{ $artikel->count() }}</div>
        <div class="stats-label">Total Artikel</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-success bg-opacity-10 text-success">
            <i class="fas fa-eye"></i>
        </div>
        <div class="stats-value">{{ $artikel->where('status', 1)->count() }}</div>
        <div class="stats-label">Published</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stats-value">{{ $artikel->where('status', 0)->count() }}</div>
        <div class="stats-label">Draft</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-info bg-opacity-10 text-info">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stats-value">{{ $kategori->count() }}</div>
        <div class="stats-label">Kategori</div>
    </div>
</div>

<!-- Articles List -->
<div class="card fade-in-up">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            Daftar Artikel
        </h5>
        <div class="d-flex gap-2">
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Cari artikel..." id="searchInput">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @forelse ($artikel as $item)
        <div class="article-item border-bottom p-4 position-relative" data-article-title="{{ strtolower($item->judul) }}">
            <div class="row align-items-center">
                <!-- Thumbnail -->
                <div class="col-md-2 mb-3 mb-md-0">
                    <div class="position-relative">
                        @if (strpos($item->sampul, 'youtube'))
                            <div class="ratio ratio-16x9 bg-dark rounded overflow-hidden">
                                <iframe src="{{ $item->sampul }}" 
                                    title="YouTube video player" 
                                    class="w-100 h-100"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">
                                    <i class="fab fa-youtube"></i>
                                </span>
                            </div>
                        @else
                            <div class="ratio ratio-16x9 bg-light rounded overflow-hidden">
                                <img src="{{ asset('img/' . $item->sampul) }}" 
                                    alt="{{ $item->judul }}" 
                                    class="w-100 h-100 object-fit-cover">
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Content -->
                <div class="col-md-7 mb-3 mb-md-0">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <a href="{{ route('preview', ['id' => $item->id]) }}" 
                           class="text-decoration-none" target="_blank">
                            <h5 class="fw-bold text-dark hover-primary mb-2 line-clamp-2">
                                {{ $item->judul }}
                            </h5>
                        </a>
                    </div>
                    
                    <p class="text-muted mb-3 line-clamp-2">
                        {{ $item->header }}
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3 text-sm">
                        <span class="d-flex align-items-center text-muted">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ date('d M Y, H:i', strtotime($item->created_at)) }}
                        </span>
                        
                        @if ($item->kategori != '')
                        <span class="d-flex align-items-center">
                            <i class="fas fa-tag me-2 text-primary"></i>
                            <span class="badge badge-primary">{{ $item->getKategori->judul }}</span>
                        </span>
                        @else
                        <span class="d-flex align-items-center">
                            <i class="fas fa-tag me-2 text-warning"></i>
                            <span class="badge badge-warning">No Category</span>
                        </span>
                        @endif
                        
                        <span class="d-flex align-items-center">
                            <i class="fas fa-{{ $item->status ? 'eye' : 'eye-slash' }} me-2 text-{{ $item->status ? 'success' : 'warning' }}"></i>
                            <span class="badge badge-{{ $item->status ? 'success' : 'warning' }}">
                                {{ $item->status ? 'Published' : 'Draft' }}
                            </span>
                        </span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="col-md-3 text-end">
                    <div class="d-flex flex-column gap-2">
                        <!-- Status Toggle -->
                        <div class="d-flex align-items-center justify-content-end">
                            <form action="{{ route('ubahstatus') }}" method="POST" id="statusForm{{ $item->id }}" class="me-3">
                                @csrf
                                <input type="hidden" value="{{ $item->id }}" name="id">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" value="1" 
                                        name="status" id="status{{ $item->id }}"
                                        onchange="toggleStatus({{ $item->id }})"
                                        @if ($item->status) checked @endif>
                                    <label class="form-check-label text-muted small" for="status{{ $item->id }}">
                                        {{ $item->status ? 'Online' : 'Draft' }}
                                    </label>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="btn-group btn-group-sm">
                            <button onclick="sendNotification({{ $item->id }})" 
                                class="btn btn-outline-primary" 
                                title="Kirim Notifikasi"
                                id="notifBtn{{ $item->id }}">
                                <i class="fas fa-bell"></i>
                            </button>
                            
                            <a href="{{ route('preview', ['id' => $item->id]) }}" 
                                class="btn btn-outline-info"
                                title="Preview Artikel" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <a href="{{ route('artikel.edit', ['id'=>$item->id]) }}" 
                                class="btn btn-outline-warning"
                                title="Edit Artikel">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button onclick="deleteArticle({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                class="btn btn-outline-danger"
                                title="Hapus Artikel">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-newspaper fa-4x text-muted opacity-50"></i>
            </div>
            <h4 class="text-muted mb-2">Belum ada artikel</h4>
            <p class="text-muted mb-4">Mulai menambahkan artikel pertama untuk website desa Anda</p>
            <a href="{{ route('addartikel') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Buat Artikel Pertama
            </a>
        </div>
        @endforelse
    </div>
    
    @if($artikel->count() > 10)
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Menampilkan {{ $artikel->count() }} artikel</span>
            <!-- Add pagination if needed -->
        </div>
    </div>
    @endif
</div>

<!-- Category Management Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">
                    <i class="fas fa-tag me-2"></i>
                    Kelola Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Kategori Tersedia</h6>
                        <div class="list-group" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($kategori as $cat)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tag text-primary me-2"></i>
                                    <span class="fw-medium">{{ $cat->judul }}</span>
                                </div>
                                <form action="{{ route('kategori.delete', $cat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                        onclick="deleteCategory({{ $cat->id }}, '{{ addslashes($cat->judul) }}')"
                                        class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Tambah Kategori Baru</h6>
                        <form action="{{ route('kategori.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="kategoriName" class="form-label">Nama Kategori</label>
                                <input type="text" 
                                    class="form-control" 
                                    id="kategoriName"
                                    name="judul" 
                                    placeholder="Masukkan nama kategori..."
                                    required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Kategori
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Forms (Hidden) -->
@foreach ($artikel as $item)
<form id="deleteForm{{ $item->id }}" action="{{ route('artikel.delete', $item->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endforeach

@foreach ($kategori as $cat)
<form id="deleteCategoryForm{{ $cat->id }}" action="{{ route('kategori.delete', $cat->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endforeach

@endsection

@push('styles')
<style>
    .article-item {
        transition: all 0.3s ease;
    }
    
    .article-item:hover {
        background: rgba(102, 126, 234, 0.02);
    }
    
    .hover-primary:hover {
        color: var(--primary-color) !important;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .object-fit-cover {
        object-fit: cover;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 1px;
    }
    
    .text-sm {
        font-size: 0.875rem;
    }
    
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.25em;
    }
    
    .form-switch .form-check-input:checked {
        background-color: var(--success-color);
        border-color: var(--success-color);
    }
    
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
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
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const articles = document.querySelectorAll('.article-item');
        
        articles.forEach(article => {
            const title = article.getAttribute('data-article-title');
            if (title.includes(searchTerm)) {
                article.style.display = 'block';
                article.classList.add('fade-in-up');
            } else {
                article.style.display = 'none';
                article.classList.remove('fade-in-up');
            }
        });
        
        // Show/hide no results message
        const visibleArticles = document.querySelectorAll('.article-item[style="display: block"], .article-item:not([style])');
        if (searchTerm && visibleArticles.length === 0) {
            // Could add a "no results" message here
        }
    });

    // Category modal
    function openCategoryModal() {
        const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
        modal.show();
    }

    // Toggle status
    function toggleStatus(id) {
        const form = document.getElementById('statusForm' + id);
        const toggle = document.getElementById('status' + id);
        const label = toggle.nextElementSibling;
        
        // Show loading state
        toggle.disabled = true;
        label.textContent = 'Updating...';
        
        // Submit form
        form.submit();
    }

    // Send notification
    function sendNotification(id) {
        const button = document.getElementById('notifBtn' + id);
        const icon = button.querySelector('i');
        
        // Show loading state
        const originalClass = icon.className;
        icon.className = 'fas fa-spinner fa-spin';
        button.disabled = true;
        
        fetch('{{ route("notif.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            // Restore button
            icon.className = originalClass;
            button.disabled = false;
            
            if (data.success) {
                showToast('Berhasil mengirim notifikasi ke ' + data.success + ' subscriber', 'success');
                
                // Visual feedback
                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-success');
                setTimeout(() => {
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-primary');
                }, 2000);
            } else {
                showToast('Gagal mengirim notifikasi', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Restore button
            icon.className = originalClass;
            button.disabled = false;
            
            showToast('Terjadi kesalahan saat mengirim notifikasi', 'error');
        });
    }

    // Delete article
    function deleteArticle(id, title) {
        if (confirm(`Apakah Anda yakin ingin menghapus artikel "${title}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            showLoading();
            document.getElementById('deleteForm' + id).submit();
        }
    }

    // Delete category
    function deleteCategory(id, title) {
        if (confirm(`Apakah Anda yakin ingin menghapus kategori "${title}"?\n\nArtikel dengan kategori ini akan menjadi tanpa kategori.`)) {
            document.getElementById('deleteCategoryForm' + id).submit();
        }
    }

    // Add smooth animations to elements when they come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);

    // Observe all article items
    document.addEventListener('DOMContentLoaded', function() {
        const articles = document.querySelectorAll('.article-item');
        articles.forEach(article => {
            observer.observe(article);
        });
        
        // Auto-focus search input with keyboard shortcut
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                document.getElementById('searchInput').focus();
            }
        });
    });

    // Add tooltips to action buttons
    document.querySelectorAll('[title]').forEach(element => {
        element.setAttribute('data-bs-toggle', 'tooltip');
    });

    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush
