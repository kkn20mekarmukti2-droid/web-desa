@extends('layout.app')

@section('title', 'Majalah Desa')

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Section -->
    <section class="hero-section bg-gradient-primary py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 text-white fw-bold mb-3">
                        📚 Majalah Desa {{ config('app.village_name', 'Desa Kami') }}
                    </h1>
                    <p class="lead text-white-75 mb-4">
                        Temukan informasi terkini, berita, dan cerita inspiratif dari desa kami 
                        dalam format majalah digital yang interaktif.
                    </p>
                    <div class="hero-stats">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-item text-white">
                                    <h3 class="fw-bold">{{ $totalMajalah }}</h3>
                                    <small>Edisi</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item text-white">
                                    <h3 class="fw-bold">{{ $totalHalaman }}</h3>
                                    <small>Halaman</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item text-white">
                                    <h3 class="fw-bold">2024</h3>
                                    <small>Terbaru</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-image">
                        <i class="fas fa-book-open fa-10x text-white opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Magazine Grid Section -->
    <section class="magazines-section py-5">
        <div class="container">
            @if($majalah->count() > 0)
            <div class="section-header text-center mb-5">
                <h2 class="section-title">Koleksi Majalah Kami</h2>
                <p class="section-subtitle">Klik pada cover majalah untuk membaca secara interaktif</p>
            </div>

            <div class="row">
                @foreach($majalah as $magazine)
                <div class="col-lg-4 col-md-6 mb-4" id="majalah-{{ $magazine->id }}">
                    <div class="magazine-card h-100">
                        <div class="magazine-cover-wrapper">
                            @if($magazine->cover_image && file_exists(public_path($magazine->cover_image)))
                                <img src="{{ asset($magazine->cover_image) }}" 
                                     alt="Cover {{ $magazine->judul }}"
                                     class="magazine-cover-image">
                            @else
                                <div class="magazine-cover-image d-flex align-items-center justify-content-center" 
                                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <div class="text-center text-white">
                                        <i class="fas fa-book fa-3x mb-3"></i>
                                        <h6>{{ $magazine->judul }}</h6>
                                    </div>
                                </div>
                            @endif
                            <div class="magazine-overlay">
                                <button class="btn btn-primary btn-read" 
                                        onclick="openMagazine({{ $magazine->id }})">
                                    <i class="fas fa-book-open me-2"></i>Baca Sekarang
                                </button>
                            </div>
                            <div class="magazine-badge">
                                <span class="badge bg-success">{{ $magazine->total_pages }} Halaman</span>
                            </div>
                        </div>
                        <div class="magazine-info">
                            <h5 class="magazine-title">{{ $magazine->judul }}</h5>
                            <p class="magazine-description">{{ Str::limit($magazine->deskripsi, 100) }}</p>
                            <div class="magazine-meta">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $magazine->tanggal_terbit->format('d F Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state text-center py-5">
                <i class="fas fa-book fa-5x text-muted mb-4"></i>
                <h3>Belum Ada Majalah</h3>
                <p class="text-muted">Majalah desa sedang dalam persiapan. Silakan kembali lagi nanti.</p>
            </div>
            @endif
        </div>
    </section>
</div>

<!-- Magazine Reader Modal -->
<div class="modal fade" id="magazineModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="magazineTitle">Majalah Desa</h5>
                <div class="reader-controls">
                    <button type="button" class="btn btn-outline-light btn-sm me-2" id="prevPage">
                        <i class="fas fa-chevron-left"></i> Sebelumnya
                    </button>
                    <span class="page-indicator" id="pageIndicator">1 / 10</span>
                    <button type="button" class="btn btn-outline-light btn-sm ms-2" id="nextPage">
                        Selanjutnya <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-dark d-flex align-items-center justify-content-center">
                <div class="flipbook-container">
                    <div id="flipbook" class="flipbook">
                        <!-- Pages will be loaded here -->
                    </div>
                </div>
                
                <!-- Loading State -->
                <div id="loadingMagazine" class="text-center text-white">
                    <div class="spinner-border text-light mb-3" role="status"></div>
                    <p>Memuat majalah...</p>
                </div>
            </div>
            <div class="modal-footer bg-dark border-0">
                <div class="reader-info text-white-50">
                    <small>Gunakan tombol navigasi atau klik pada sudut halaman untuk membalik halaman</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="rgba(255,255,255,.1)"/><stop offset="100%" stop-color="rgba(255,255,255,0)"/></radialGradient></defs><circle fill="url(%23a)" cx="10" cy="10" r="10"/><circle fill="url(%23a)" cx="90" cy="5" r="5"/><circle fill="url(%23a)" cx="70" cy="15" r="7"/><circle fill="url(%23a)" cx="30" cy="5" r="3"/></svg>') repeat;
    opacity: 0.1;
}

.text-white-75 {
    color: rgba(255, 255, 255, 0.75);
}

.magazine-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.magazine-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 40px rgba(0,0,0,0.15);
}

.magazine-cover-wrapper {
    position: relative;
    overflow: hidden;
    height: 300px;
}

.magazine-cover-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.magazine-card:hover .magazine-cover-image {
    transform: scale(1.1);
}

.magazine-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.magazine-card:hover .magazine-overlay {
    opacity: 1;
}

.btn-read {
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.magazine-card:hover .btn-read {
    transform: translateY(0);
}

.magazine-badge {
    position: absolute;
    top: 15px;
    right: 15px;
}

.magazine-info {
    padding: 20px;
}

.magazine-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.magazine-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

/* Flipbook Styles */
.flipbook-container {
    width: 100%;
    height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.flipbook {
    width: 90%;
    height: 90%;
    margin: 0 auto;
}

.flipbook .page {
    background: white;
    color: #333;
    padding: 0;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.flipbook .page img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.reader-controls {
    display: flex;
    align-items: center;
    gap: 15px;
}

.page-indicator {
    background: rgba(255,255,255,0.2);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section {
        text-align: center;
    }
    
    .flipbook-container {
        height: 70vh;
    }
    
    .reader-controls {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

<!-- Turn.js Library -->
<script src="https://cdn.jsdelivr.net/npm/turn.js@3.0.2/turn.min.js"></script>

<script>
let currentMagazine = null;
let flipbook = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize magazine modal
    const magazineModal = new bootstrap.Modal(document.getElementById('magazineModal'));
    
    // Modal event listeners
    document.getElementById('magazineModal').addEventListener('hidden.bs.modal', function() {
        if (flipbook) {
            flipbook.turn('destroy');
            flipbook = null;
        }
        document.getElementById('flipbook').innerHTML = '';
        document.getElementById('loadingMagazine').style.display = 'block';
    });
});

function openMagazine(magazineId) {
    currentMagazine = magazineId;
    const modal = new bootstrap.Modal(document.getElementById('magazineModal'));
    
    // Show loading state
    document.getElementById('loadingMagazine').style.display = 'block';
    
    // Fetch magazine data
    fetch(`/api/majalah/${magazineId}/pages`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                setupFlipbook(data.magazine, data.pages);
                modal.show();
            } else {
                alert('Gagal memuat majalah');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat majalah');
        });
}

function setupFlipbook(magazine, pages) {
    // Set magazine title
    document.getElementById('magazineTitle').textContent = magazine.judul;
    
    // Clear and setup flipbook container
    const flipbookContainer = document.getElementById('flipbook');
    flipbookContainer.innerHTML = '';
    
    // Add pages to flipbook
    pages.forEach((page, index) => {
        const pageDiv = document.createElement('div');
        pageDiv.className = 'page';
        
        // Use direct public path instead of storage
        const imgSrc = `/${page.image_path}`;
        pageDiv.innerHTML = `
            <img src="${imgSrc}" 
                 alt="Halaman ${page.page_number}"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                 style="width: 100%; height: 100%; object-fit: contain;">
            <div style="display: none; width: 100%; height: 100%; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); align-items: center; justify-content: center; flex-direction: column;">
                <i class="fas fa-image text-gray-400" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h5 class="text-gray-600">Halaman ${page.page_number}</h5>
                <p class="text-gray-500">${page.title || 'Gambar tidak tersedia'}</p>
            </div>
        `;
        flipbookContainer.appendChild(pageDiv);
    });
    
    // Hide loading state
    document.getElementById('loadingMagazine').style.display = 'none';
    
    // Initialize Turn.js
    setTimeout(() => {
        flipbook = $('#flipbook').turn({
            width: 800,
            height: 600,
            autoCenter: true,
            acceleration: true,
            gradients: true,
            elevation: 50
        });
        
        // Update page indicator
        updatePageIndicator(1, pages.length);
        
        // Bind turn events
        flipbook.bind('turned', function(event, page, view) {
            updatePageIndicator(page, pages.length);
        });
        
        // Bind navigation buttons
        document.getElementById('prevPage').onclick = () => flipbook.turn('previous');
        document.getElementById('nextPage').onclick = () => flipbook.turn('next');
        
    }, 100);
}

function updatePageIndicator(currentPage, totalPages) {
    document.getElementById('pageIndicator').textContent = `${currentPage} / ${totalPages}`;
    
    // Update button states
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    
    prevBtn.disabled = currentPage <= 1;
    nextBtn.disabled = currentPage >= totalPages;
}
</script>
@endsection
