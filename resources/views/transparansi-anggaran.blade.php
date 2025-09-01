@extends('layout.app')

@section('title', 'Transparansi Anggaran APBDes - Desa Mekarmukti')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-full mb-6">
                <i class="fas fa-chart-line text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Transparansi Anggaran APBDes
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Dokumen Anggaran Pendapatan dan Belanja Desa (APBDes) Desa Mekarmukti
                untuk keterbukaan informasi publik dan akuntabilitas keuangan desa.
            </p>
        </div>

        @if($apbdesList->count() > 0)
            <!-- APBDes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($apbdesList as $item)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-2">{{ $item->title }}</h3>
                                <div class="flex items-center text-blue-100">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>Tahun {{ $item->tahun }}</span>
                                </div>
                            </div>
                            @if($item->is_active)
                            <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Aktif
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Description -->
                        @if($item->description)
                        <div class="mb-6">
                            <p class="text-gray-600 leading-relaxed">{{ $item->description }}</p>
                        </div>
                        @endif

                        <!-- Image Display - SIMPLE LIKE BERITA & STRUKTUR -->
                        @if($item->image_path && file_exists(public_path($item->image_path)))
                            <img 
                                src="{{ asset($item->image_path) }}" 
                                alt="{{ $item->title }}"
                                class="w-full h-auto rounded-lg shadow-md cursor-pointer hover:shadow-lg transition-shadow duration-300 mb-6"
                                onclick="openImageModal('{{ asset($item->image_path) }}', '{{ $item->title }}')"
                                style="height: 300px; object-fit: cover;"
                                loading="lazy"
                            >
                        @else
                        <!-- No Image Fallback - SIMPLE LIKE BERITA -->
                        <div class="bg-gray-100 rounded-lg p-8 text-center mb-6">
                            <i class="fas fa-file-alt text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-600">Gambar tidak tersedia</p>
                        </div>
                        @endif

                        <!-- Download Button -->
                        @if($item->image_path && file_exists(public_path($item->image_path)))
                        <div class="text-center">
                            <a 
                                href="{{ asset($item->image_path) }}" 
                                download="{{ $item->title }}.jpg"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg"
                                target="_blank"
                            >
                                <i class="fas fa-download mr-2"></i>
                                Download Dokumen
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($apbdesList->hasPages())
            <div class="mt-12">
                {{ $apbdesList->links() }}
            </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="w-32 h-32 mx-auto mb-8 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-inbox text-gray-400 text-6xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    Belum Ada Dokumen APBDes
                </h3>
                <p class="text-gray-600 max-w-md mx-auto">
                    Dokumen APBDes belum tersedia. Silakan periksa kembali nanti atau hubungi 
                    administrasi desa untuk informasi lebih lanjut.
                </p>
            </div>
        @endif

    </div>
</div>

<!-- Image Modal - SIMPLE -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button 
            onclick="closeImageModal()" 
            class="absolute -top-12 right-0 text-white text-xl bg-black bg-opacity-50 w-10 h-10 rounded-full flex items-center justify-center hover:bg-opacity-70 transition-colors"
        >
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-[90vh] object-contain rounded-lg">
        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 text-white p-4 rounded-b-lg">
            <h3 id="modalTitle" class="font-semibold text-lg"></h3>
        </div>
    </div>
</div>

<script>
// SIMPLE APPROACH - EXACTLY LIKE BERITA & STRUKTUR
function openImageModal(src, title) {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.getElementById('modalImage').src = src;
    document.getElementById('modalTitle').textContent = title;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
