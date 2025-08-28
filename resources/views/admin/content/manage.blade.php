@extends('layout.admin')

@section('content')
<style>
    /* Custom styles untuk tombol dan animasi */
    .notification-btn.active {
        background: linear-gradient(45deg, #3B82F6, #1D4ED8) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4) !important;
    }
    
    .notification-btn:hover {
        transform: scale(1.1) !important;
    }
    
    .toggle-status:checked + div {
        background: linear-gradient(45deg, #10B981, #059669) !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
    }
    
    .toggle-status:checked + div::after {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
    }
    
    /* Animasi untuk tombol tambah berita */
    .tambah-berita-btn {
        background: linear-gradient(45deg, #3B82F6, #1D4ED8);
        transition: all 0.3s ease;
    }
    
    .tambah-berita-btn:hover {
        background: linear-gradient(45deg, #1D4ED8, #1E40AF);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
    }
    
    /* Hover effect untuk cards */
    .article-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* Loading animation */
    @keyframes pulse-dot {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 1; }
    }
    
    .loading-dots::after {
        content: '...';
        animation: pulse-dot 1.5s infinite;
    }
</style>

<main class="flex-1 bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="px-6 py-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Kelola Konten</h1>
                        <p class="text-gray-600">Tambah, edit, dan kelola semua artikel website desa</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="flex flex-col sm:flex-row gap-3 justify-end">
                            <a href="{{ route('addartikel') }}" 
                                class="tambah-berita-btn inline-flex items-center justify-center px-6 py-3 text-white rounded-lg font-semibold shadow-lg transform transition-all duration-200">
                                <i class="fa-solid fa-newspaper mr-2"></i>
                                Tambah Berita
                            </a>
                            <button onclick="openModal()" 
                                class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-tag mr-2"></i>
                                Kelola Kategori
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="px-6 py-6">
        <div class="max-w-7xl mx-auto">
            <div class="space-y-5">
                @forelse ($artikel as $i)
                <div class="article-card bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <!-- Thumbnail Column -->
                        <div class="md:w-1/4 flex-shrink-0">
                            <div class="relative aspect-[4/3] w-full h-full overflow-hidden">
                                @if (strpos($i->sampul, 'youtube'))
                                    <iframe class="absolute inset-0 w-full h-full" 
                                        src="{{ $i->sampul }}" 
                                        title="YouTube video player" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                        referrerpolicy="strict-origin-when-cross-origin" 
                                        allowfullscreen>
                                    </iframe>
                                @else
                                    <img src="{{ asset('img/' . $i->sampul) }}" 
                                        alt="{{ $i->judul }}" 
                                        class="w-full h-full object-cover">
                                @endif
                            </div>
                        </div>
                        
                        <!-- Content Column -->
                        <div class="md:w-3/4 p-5">
                            <div class="flex flex-col h-full">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1 pr-4">
                                        <a href="{{ route('preview', ['id' => $i->id]) }}" class="block">
                                            <h2 class="text-lg font-bold text-gray-900 line-clamp-2 hover:text-[#F59E0B] transition-colors">
                                                {{ $i->judul }}
                                            </h2>
                                        </a>
                                        
                                        <div class="flex items-center flex-wrap mt-2 text-sm text-gray-500 space-x-4">
                                            <span class="flex items-center">
                                                <i class="fa-regular fa-calendar mr-1.5"></i>
                                                {{ date('d M Y', strtotime($i->created_at)) }}
                                            </span>
                                            
                                            @if ($i->kategori != '')
                                            <span class="flex items-center">
                                                <i class="fa-solid fa-tag mr-1.5"></i>
                                                {{ $i->getKategori->judul }}
                                            </span>
                                            @endif
                                            
                                            <span class="flex items-center">
                                                <i class="fa-regular fa-eye mr-1.5"></i>
                                                Status: 
                                                <span class="ml-1 {{ $i->status ? 'text-green-600' : 'text-gray-500' }}">
                                                    {{ $i->status ? 'Dipublikasikan' : 'Draft' }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex items-center space-x-1">
                                        <button onclick="notif({{ $i->id }})" 
                                            class="notification-btn p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all duration-200 transform hover:scale-110"
                                            title="Kirim Notifikasi"
                                            data-article-id="{{ $i->id }}">
                                            <i class="fa-solid fa-bell text-sm"></i>
                                        </button>
                                        
                                        <a href="{{ route('artikel.edit', ['id'=>$i->id]) }}" 
                                            class="p-2 text-gray-500 hover:text-[#F59E0B] hover:bg-orange-50 rounded-full transition-all duration-200 transform hover:scale-110"
                                            title="Edit Artikel">
                                            <i class="fa-regular fa-pen-to-square text-sm"></i>
                                        </a>
                                        
                                        <button type="button"
                                            onclick="deleteArtikel({{ $i->id }},'{{ $i->judul }}')" 
                                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-full transition-all duration-200 transform hover:scale-110"
                                            title="Hapus Artikel">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Article Summary -->
                                <div class="mb-4 flex-grow">
                                    <p class="text-gray-600 line-clamp-3">
                                        {{ $i->header }}
                                    </p>
                                </div>
                                
                                <!-- Footer Actions -->
                                <div class="flex justify-between items-center mt-auto pt-3 border-t border-gray-100">
                                    <a href="{{ route('preview', ['id' => $i->id]) }}" 
                                        class="text-sm text-[#F59E0B] hover:text-orange-700 font-medium flex items-center">
                                        Preview Artikel
                                        <i class="fa-solid fa-arrow-right ml-1.5"></i>
                                    </a>
                                    
                                    <form action="{{ route('ubahstatus') }}" method="POST" id="ubahstatusform{{ $i->id }}">
                                        @csrf
                                        <input type="hidden" value="{{ $i->id }}" name="id">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <span class="mr-3 text-sm font-medium {{ $i->status ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $i->status ? 'Publikasi' : 'Draft' }}
                                            </span>
                                            <div class="relative">
                                                <input type="checkbox" value="1" class="sr-only peer toggle-status"
                                                    name="status" onchange="ubahstatus({{ $i->id }})"
                                                    data-article-id="{{ $i->id }}"
                                                    @if ($i->status) checked @endif>
                                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer 
                                                    peer-checked:after:translate-x-full peer-checked:after:border-white 
                                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                                    after:bg-white after:border-gray-300 after:border after:rounded-full 
                                                    after:h-6 after:w-6 after:transition-all after:duration-300
                                                    peer-checked:bg-gradient-to-r peer-checked:from-green-400 peer-checked:to-green-600
                                                    hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                                </div>
                                                <!-- Status indicator dot -->
                                                <div class="absolute top-1 right-1 w-2 h-2 rounded-full {{ $i->status ? 'bg-white' : 'bg-gray-400' }} 
                                                    transition-all duration-300 {{ $i->status ? 'opacity-100' : 'opacity-0' }}">
                                                </div>
                                            </div>
                                        </label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
                    <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-6">
                        <i class="fa-regular fa-newspaper text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada artikel</h3>
                    <p class="text-gray-500 mb-6">Mulai menambahkan artikel pertama Anda untuk website desa.</p>
                    <a href="{{ route('addartikel') }}" 
                        class="inline-flex items-center px-4 py-2 bg-[#F59E0B] text-white rounded-lg font-medium hover:bg-orange-600 transition-colors">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Tambah Artikel Pertama
                    </a>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination if needed -->
            @if(isset($artikel) && method_exists($artikel, 'links') && $artikel->hasPages())
            <div class="mt-6">
                {{ $artikel->links() }}
            </div>
            @endif
        </div>
    </div>
</main>

<!-- Category Modal -->
<div id="kategoriModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Kelola Kategori</h2>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>

        <div id="categoryList" class="mb-6 max-h-60 overflow-y-auto">
            <ul class="divide-y divide-gray-200">
                @foreach ($kategori as $i)
                <li class="flex justify-between items-center py-3">
                    <p class="font-medium text-gray-800">{{ $i->judul }}</p>
                    <form id="delete-form-{{ $i->id }}" action="{{ route('kategori.delete', $i->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="deleteCategory({{ $i->id }},'{{ $i->judul }}')"
                            class="p-2 text-gray-400 hover:text-red-600 rounded-full hover:bg-red-50 transition-colors">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                Tutup
            </button>
            <button type="button" onclick="addModal()" class="px-4 py-2 bg-[#F59E0B] text-white rounded-lg font-medium hover:bg-orange-600 transition-colors">
                Tambah Kategori
            </button>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div id="addkategoriModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Tambah Kategori</h2>
            <button type="button" onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="judul" id="judul" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-[#F59E0B] focus:border-[#F59E0B]" placeholder="Masukkan nama kategori" required>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-[#F59E0B] text-white rounded-lg font-medium hover:bg-orange-600 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Article Form -->
@foreach ($artikel as $i)
<form id="delete-Artikel-{{ $i->id }}" action="{{ route('artikel.delete', $i->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endforeach

@if(session('success'))
<div id="successAlert" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-100 border-l-4 border-green-500 text-green-700 p-6 rounded-lg shadow-2xl z-50">
    <div class="flex items-center justify-center">
        <i class="fa-solid fa-check-circle mr-3 text-lg"></i>
        <span class="font-medium text-center">{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div id="errorAlert" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-100 border-l-4 border-red-500 text-red-700 p-6 rounded-lg shadow-2xl z-50">
    <div class="flex items-center justify-center">
        <i class="fa-solid fa-exclamation-circle mr-3 text-lg"></i>
        <span class="font-medium text-center">{{ session('error') }}</span>
    </div>
</div>
@endif
@endsection

@section('script')
<script>
    // Modal functions
    function openModal() {
        document.getElementById('kategoriModal').classList.remove('hidden');
        document.getElementById('kategoriModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('kategoriModal').classList.add('hidden');
        document.getElementById('kategoriModal').classList.remove('flex');
    }

    function addModal() {
        closeModal();
        document.getElementById('addkategoriModal').classList.remove('hidden');
        document.getElementById('addkategoriModal').classList.add('flex');
    }

    function closeAddModal() {
        document.getElementById('addkategoriModal').classList.add('hidden');
        document.getElementById('addkategoriModal').classList.remove('flex');
        openModal();
    }

    // Update article status dengan animasi yang lebih reliable
    function ubahstatus(id) {
        const form = document.getElementById('ubahstatusform' + id);
        const toggle = form.querySelector('.toggle-status');
        const label = form.querySelector('span');
        const toggleDiv = toggle.nextElementSibling;
        
        // Prevent multiple clicks
        if (toggle.disabled) return;
        
        // Disable toggle temporarily
        toggle.disabled = true;
        
        // Get current state
        const isChecked = toggle.checked;
        
        // Update UI immediately for better responsiveness
        if (isChecked) {
            label.textContent = 'Publikasi';
            label.className = 'mr-3 text-sm font-medium text-green-600';
            toggleDiv.classList.add('peer-checked:bg-gradient-to-r', 'peer-checked:from-green-400', 'peer-checked:to-green-600');
        } else {
            label.textContent = 'Draft';
            label.className = 'mr-3 text-sm font-medium text-gray-500';
            toggleDiv.classList.remove('peer-checked:bg-gradient-to-r', 'peer-checked:from-green-400', 'peer-checked:to-green-600');
        }
        
        // Submit form
        form.submit();
    }

    // Delete article confirmation dengan animasi
    function deleteArtikel(id, judul) {
        if (confirm(`Apakah Anda yakin ingin menghapus artikel "${judul}"?`)) {
            // Tambahkan loading state
            const deleteBtn = event.target.closest('button');
            deleteBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-sm"></i>';
            deleteBtn.disabled = true;
            
            document.getElementById('delete-Artikel-' + id).submit();
        }
    }

    // Delete category confirmation
    function deleteCategory(id, judul) {
        if (confirm(`Apakah Anda yakin ingin menghapus kategori "${judul}"?`)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // Fungsi notifikasi yang sesuai dengan halaman manage content asli
    function notif(id) {
        const button = event.target.closest('.notification-btn');
        const icon = button.querySelector('i');
        
        // Animasi klik
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 150);
        
        // Tampilkan loading state
        const originalIcon = icon.className;
        icon.className = 'fa-solid fa-spinner fa-spin text-sm';
        button.disabled = true;
        
        // Kirim request sesuai dengan format asli manage content
        fetch('{{ route("notif.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: id  // Pakai format yang sama seperti manage content asli
            })
        })
        .then(response => response.json())
        .then(data => {
            // Restore button state
            button.disabled = false;
            icon.className = originalIcon;
            
            if (data.success) {
                // Tampilkan pesan sukses sesuai format asli
                showToast('Berhasil Mengirimkan Notifikasi ke ' + data.success + ' Subscriber', 'success');
                
                // Visual feedback button berhasil
                button.classList.add('text-green-600');
                setTimeout(() => {
                    button.classList.remove('text-green-600');
                    button.classList.add('text-gray-500');
                }, 2000);
            } else {
                showToast('Gagal Mengirimkan Notifikasi', 'error');
                
                // Visual feedback button error
                button.classList.add('text-red-500');
                setTimeout(() => {
                    button.classList.remove('text-red-500');
                    button.classList.add('text-gray-500');
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Restore button state
            button.disabled = false;
            icon.className = originalIcon;
            
            showToast('Gagal Mengirimkan Notifikasi', 'error');
            
            // Visual feedback button error
            button.classList.add('text-red-500');
            setTimeout(() => {
                button.classList.remove('text-red-500');
                button.classList.add('text-gray-500');
            }, 2000);
        });
    }
    
    // Fungsi untuk menampilkan toast notification di tengah
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        
        toast.className = `fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 ${bgColor} text-white px-8 py-4 rounded-lg shadow-2xl z-50 scale-0 opacity-0 transition-all duration-300`;
        toast.innerHTML = `
            <div class="flex items-center justify-center">
                <i class="fa-solid fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation' : 'info'}-circle mr-3 text-lg"></i>
                <span class="font-medium text-center">${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animasi masuk
        setTimeout(() => {
            toast.style.transform = 'translate(-50%, -50%) scale(1)';
            toast.style.opacity = '1';
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            toast.style.transform = 'translate(-50%, -50%) scale(0)';
            toast.style.opacity = '0';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }    // Auto-dismiss alerts after 5 seconds dengan animasi fade untuk posisi tengah
    setTimeout(function() {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        
        if (successAlert) {
            successAlert.style.transform = 'translate(-50%, -50%) scale(0)';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }
        
        if (errorAlert) {
            errorAlert.style.transform = 'translate(-50%, -50%) scale(0)';
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 500);
        }
    }, 5000);
    
    // Initialize pada document ready
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to buttons
        const buttons = document.querySelectorAll('.notification-btn, .tambah-berita-btn');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05) translateY(-1px)';
            });
            
            button.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1) translateY(0)';
                }
            });
        });
        
        // Add ripple effect to buttons
        const allButtons = document.querySelectorAll('button, a[class*="btn"]');
        
        allButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.6)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.pointerEvents = 'none';
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Show welcome message
        setTimeout(() => {
            showToast('Dashboard Content Management siap digunakan!', 'success');
        }, 1000);
    });
    
    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
