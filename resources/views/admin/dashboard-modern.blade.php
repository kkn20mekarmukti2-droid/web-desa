@extends('layout.admin-modern')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">📊 Dashboard Admin</h1>
            <p class="page-subtitle">Selamat datang di panel admin Desa Mekarmukti - Kelola konten website dengan mudah dan efisien</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('addartikel') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Artikel
            </a>
            <a href="/data-statistik" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                Lihat Website
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
        <div class="stats-value" id="totalArtikel">{{ $artikel->count() ?? 0 }}</div>
        <div class="stats-label">Total Artikel</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-success bg-opacity-10 text-success">
            <i class="fas fa-eye"></i>
        </div>
        <div class="stats-value" id="artikelPublish">{{ $artikel->where('status', 1)->count() ?? 0 }}</div>
        <div class="stats-label">Artikel Published</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stats-value" id="artikelDraft">{{ $artikel->where('status', 0)->count() ?? 0 }}</div>
        <div class="stats-label">Draft Articles</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-info bg-opacity-10 text-info">
            <i class="fas fa-images"></i>
        </div>
        <div class="stats-value" id="totalGallery">{{ $gallery->count() ?? 0 }}</div>
        <div class="stats-label">Gallery Items</div>
    </div>
    
    @if(Auth::user()->role == 0)
    <div class="stats-card">
        <div class="stats-icon bg-purple bg-opacity-10 text-purple">
            <i class="fas fa-users"></i>
        </div>
        <div class="stats-value" id="totalUsers">{{ $users->count() ?? 0 }}</div>
        <div class="stats-label">Total Users</div>
    </div>
    @endif
</div>

<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-8">
        <div class="card fade-in-up">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    <i class="fas fa-rocket me-2 text-primary"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('addartikel') }}" class="btn btn-outline-primary w-100 p-3 h-100 d-flex flex-column justify-content-center">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <strong>Buat Artikel Baru</strong>
                            <small class="text-muted mt-1">Tambah berita atau informasi terbaru</small>
                        </a>
                    </div>
                    
                    <div class="col-md-6">
                        <a href="{{ route('gallery.index') }}" class="btn btn-outline-success w-100 p-3 h-100 d-flex flex-column justify-content-center">
                            <i class="fas fa-image fa-2x mb-2"></i>
                            <strong>Kelola Gallery</strong>
                            <small class="text-muted mt-1">Upload dan atur foto kegiatan desa</small>
                        </a>
                    </div>
                    
                    <div class="col-md-6">
                        <a href="{{ route('admin.statistik.index') }}" class="btn btn-outline-warning w-100 p-3 h-100 d-flex flex-column justify-content-center">
                            <i class="fas fa-chart-pie fa-2x mb-2"></i>
                            <strong>Data Statistik</strong>
                            <small class="text-muted mt-1">Kelola data penduduk dan demografi</small>
                        </a>
                    </div>
                    
                    @if(Auth::user()->role == 0)
                    <div class="col-md-6">
                        <a href="{{ route('akun.manage') }}" class="btn btn-outline-info w-100 p-3 h-100 d-flex flex-column justify-content-center">
                            <i class="fas fa-user-cog fa-2x mb-2"></i>
                            <strong>Manage Users</strong>
                            <small class="text-muted mt-1">Kelola akun admin dan user</small>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- System Info -->
    <div class="col-lg-4">
        <div class="card fade-in-up">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    System Info
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted">Website Status</span>
                    <span class="badge badge-success">
                        <i class="fas fa-circle me-1"></i>
                        Online
                    </span>
                </div>
                
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted">Last Updated</span>
                    <span class="fw-medium">{{ date('d M Y') }}</span>
                </div>
                
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted">Admin Role</span>
                    <span class="badge {{ Auth::user()->role == 0 ? 'badge-primary' : 'badge-success' }}">
                        {{ Auth::user()->role == 0 ? 'Super Admin' : 'Admin' }}
                    </span>
                </div>
                
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">Server Time</span>
                    <span class="fw-medium" id="serverTime">{{ date('H:i:s') }}</span>
                </div>
                
                <hr class="my-3">
                
                <div class="text-center">
                    <a href="/data-statistik" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i>
                        Lihat Website
                    </a>
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm ms-2">
                        <i class="fas fa-sign-out-alt me-1"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Articles -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card fade-in-up">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    <i class="fas fa-newspaper me-2 text-primary"></i>
                    Artikel Terbaru
                </h5>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($artikel && $artikel->count() > 0)
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Artikel</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artikel->take(5) as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if(strpos($item->sampul, 'youtube'))
                                                <div class="bg-danger rounded" style="width: 50px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fab fa-youtube text-white"></i>
                                                </div>
                                            @else
                                                <img src="{{ asset('img/' . $item->sampul) }}" alt="{{ $item->judul }}" 
                                                     class="rounded object-cover" style="width: 50px; height: 35px;">
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ Str::limit($item->judul, 50) }}</h6>
                                            <small class="text-muted">{{ Str::limit($item->header, 60) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($item->kategori)
                                        <span class="badge badge-primary">{{ $item->getKategori->judul ?? 'Uncategorized' }}</span>
                                    @else
                                        <span class="badge badge-warning">No Category</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status)
                                        <span class="badge badge-success">
                                            <i class="fas fa-eye me-1"></i>
                                            Published
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock me-1"></i>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-medium">{{ date('d M Y', strtotime($item->created_at)) }}</span>
                                    <br>
                                    <small class="text-muted">{{ date('H:i', strtotime($item->created_at)) }}</small>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('preview', ['id' => $item->id]) }}" class="btn btn-outline-info btn-sm" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('artikel.edit', ['id'=>$item->id]) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada artikel</h5>
                    <p class="text-muted mb-3">Mulai dengan membuat artikel pertama Anda</p>
                    <a href="{{ route('addartikel') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Buat Artikel Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Welcome Modal for First Time Users -->
@if(session('first_login') || !session('welcome_shown') || request()->has('show_welcome'))
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 text-center">
                <div class="w-100">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-rocket fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h4 class="modal-title text-primary fw-bold" id="welcomeModalLabel">Selamat Datang! 🎉</h4>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close" onclick="closeWelcomeModal()"></button>
            </div>
            <div class="modal-body text-center">
                <h5 class="mb-3">Hai, {{ Auth::user()->name }}! 👋</h5>
                <p class="text-muted mb-4">
                    Welcome back! Panel admin Desa Mekarmukti sudah diperbarui dengan tampilan yang lebih fresh dan user-friendly.
                </p>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="border rounded-3 p-3 h-100">
                            <i class="fas fa-palette text-primary mb-2"></i>
                            <div class="small fw-medium">Design Modern</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded-3 p-3 h-100">
                            <i class="fas fa-mobile-alt text-success mb-2"></i>
                            <div class="small fw-medium">Mobile Friendly</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded-3 p-3 h-100">
                            <i class="fas fa-tachometer-alt text-warning mb-2"></i>
                            <div class="small fw-medium">Performa Cepat</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded-3 p-3 h-100">
                            <i class="fas fa-shield-alt text-info mb-2"></i>
                            <div class="small fw-medium">Aman & Stabil</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal" onclick="closeWelcomeModal()">
                    <i class="fas fa-check me-1"></i>
                    Oke, Siap!
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
    .text-purple {
        color: #8b5cf6 !important;
    }
    
    .bg-purple {
        background-color: #8b5cf6 !important;
    }
    
    .object-cover {
        object-fit: cover;
    }
    
    .stats-card {
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .btn:hover {
        transform: translateY(-2px);
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
    
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
    // Real-time clock
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('serverTime').textContent = timeString;
    }
    
    // Update time every second
    setInterval(updateTime, 1000);
    
    // Show welcome modal for first time users
    @if(session('first_login') || !session('welcome_shown') || request()->has('show_welcome'))
    let welcomeModalInstance;
    document.addEventListener('DOMContentLoaded', function() {
        const welcomeModalEl = document.getElementById('welcomeModal');
        welcomeModalInstance = new bootstrap.Modal(welcomeModalEl, {
            backdrop: 'static',
            keyboard: false
        });
        setTimeout(() => {
            welcomeModalInstance.show();
        }, 1000);
        
        // Mark welcome as shown
        sessionStorage.setItem('welcome_shown', 'true');
    });
    
    function closeWelcomeModal() {
        if (welcomeModalInstance) {
            welcomeModalInstance.hide();
        }
        // Also use Bootstrap's native method as backup
        const welcomeModalEl = document.getElementById('welcomeModal');
        if (welcomeModalEl) {
            const modalInstance = bootstrap.Modal.getInstance(welcomeModalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    }
    @endif
    
    // Add smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Add loading state to buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!this.disabled && this.href) {
                const icon = this.querySelector('i');
                if (icon) {
                    const originalClass = icon.className;
                    icon.className = 'fas fa-spinner fa-spin';
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 2000);
                }
            }
        });
    });
    
    // Add counter animation to stats
    function animateCounters() {
        const counters = document.querySelectorAll('.stats-value');
        
        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            const increment = target / 100;
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.textContent = target;
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current);
                }
            }, 20);
        });
    }
    
    // Trigger counter animation when page loads
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(animateCounters, 500);
    });
    
    // Add hover effects to cards
    document.querySelectorAll('.stats-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 1px 3px 0 rgba(0, 0, 0, 0.1)';
        });
    });
</script>
@endpush
