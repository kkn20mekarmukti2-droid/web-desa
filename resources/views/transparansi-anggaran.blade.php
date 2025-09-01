@extends('layout.app')

@section('judul', 'Transparansi Anggaran APBDes')

@section('konten')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mb-6">
                <i class="fas fa-chart-pie text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                💰 Transparansi Anggaran
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Keterbukaan informasi mengenai Anggaran Pendapatan dan Belanja Desa (APBDes) 
                sebagai wujud akuntabilitas pengelolaan keuangan desa
            </p>
        </div>

        @if($apbdes->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">
                    Belum Ada Dokumen APBDes
                </h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Dokumen APBDes akan segera dipublikasikan untuk memastikan transparansi pengelolaan keuangan desa.
                </p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 max-w-lg mx-auto">
                    <h4 class="font-semibold text-blue-900 mb-2">📋 Informasi</h4>
                    <p class="text-blue-700 text-sm">
                        APBDes adalah dokumen perencanaan keuangan tahunan desa yang berisi rincian penerimaan dan pengeluaran untuk pembangunan dan pelayanan kepada masyarakat.
                    </p>
                </div>
            </div>
        @else
            <!-- APBDes Gallery -->
            <div class="space-y-8">
                @foreach($apbdes as $item)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-green-600 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-2">{{ $item->title }}</h2>
                                <div class="flex items-center space-x-4 text-blue-100">
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Tahun {{ $item->tahun }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-2"></i>
                                        {{ $item->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                                    <i class="fas fa-eye mr-2"></i>
                                    Publik
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        @if($item->description)
                            <div class="mb-6">
                                <p class="text-gray-700 leading-relaxed">{{ $item->description }}</p>
                            </div>
                        @endif

                        <!-- Image Display -->
                        <div class="relative group">
                            <img 
                                src="{{ asset('storage/' . $item->image_path) }}" 
                                alt="{{ $item->title }}"
                                class="w-full h-auto rounded-lg shadow-md cursor-pointer hover:shadow-lg transition-shadow duration-300"
                                onclick="openImageModal('{{ asset('storage/' . $item->image_path) }}', '{{ $item->title }}')"
                            >
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-lg transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button 
                                        onclick="openImageModal('{{ asset('storage/' . $item->image_path) }}', '{{ $item->title }}')"
                                        class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium shadow-lg hover:bg-gray-100 transition-colors"
                                    >
                                        <i class="fas fa-search-plus mr-2"></i>
                                        Perbesar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Download Button -->
                        <div class="mt-6 text-center">
                            <a 
                                href="{{ asset('storage/' . $item->image_path) }}" 
                                download="{{ $item->title }}.jpg"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg"
                            >
                                <i class="fas fa-download mr-2"></i>
                                Download Gambar
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Info Section -->
            <div class="mt-12 bg-gradient-to-r from-green-500 to-blue-600 rounded-2xl shadow-lg text-white p-8">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-2xl font-bold mb-4">
                            <i class="fas fa-info-circle mr-3"></i>
                            Tentang APBDes
                        </h3>
                        <ul class="space-y-2 text-green-100">
                            <li>• Anggaran Pendapatan dan Belanja Desa</li>
                            <li>• Dokumen perencanaan keuangan tahunan</li>
                            <li>• Berisi rincian penerimaan dan pengeluaran desa</li>
                            <li>• Dasar pelaksanaan program pembangunan</li>
                        </ul>
                    </div>
                    <div class="text-center md:text-right">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-4">
                            <i class="fas fa-balance-scale text-3xl"></i>
                        </div>
                        <p class="text-green-100 font-medium">
                            Transparansi adalah kunci kepercayaan masyarakat dalam pengelolaan keuangan desa
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 p-4" style="display: none; align-items: center; justify-content: center;">
    <div class="relative max-w-full max-h-full">
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
function openImageModal(imageSrc, title) {
    const modal = document.getElementById('imageModal');
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
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

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
