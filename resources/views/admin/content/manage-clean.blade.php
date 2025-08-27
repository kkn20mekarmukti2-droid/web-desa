@extends('layout.admin')

@section('content')
<main class="flex-1 bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="px-6 py-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Kelola Konten</h1>
                        <p class="text-gray-600">Tambah, edit, dan kelola semua artikel website desa</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('addartikel') }}" 
                            class="inline-flex items-center justify-center px-4 py-2.5 bg-[#F59E0B] text-white rounded-lg font-medium hover:bg-orange-600 transition-colors shadow-sm">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Tambah Artikel
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

    <!-- Content Section -->
    <div class="px-6 py-6">
        <div class="max-w-7xl mx-auto">
            <div class="space-y-5">
                @forelse ($artikel as $i)
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-all overflow-hidden">
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
                                            class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-colors"
                                            title="Kirim Notifikasi">
                                            <i class="fa-regular fa-bell"></i>
                                        </button>
                                        
                                        <a href="{{ route('artikel.edit', ['id'=>$i->id]) }}" 
                                            class="p-2 text-gray-500 hover:text-[#F59E0B] hover:bg-orange-50 rounded-full transition-colors"
                                            title="Edit Artikel">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        
                                        <button type="button"
                                            onclick="deleteArtikel({{ $i->id }},'{{ $i->judul }}')" 
                                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors"
                                            title="Hapus Artikel">
                                            <i class="fa-solid fa-trash"></i>
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
                                            <span class="mr-3 text-sm text-gray-600">{{ $i->status ? 'Publikasi' : 'Draft' }}</span>
                                            <div class="relative">
                                                <input type="checkbox" value="1" class="sr-only peer"
                                                    name="status" onchange="ubahstatus({{ $i->id }})"
                                                    @if ($i->status) checked @endif>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#F59E0B] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#F59E0B]"></div>
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
<div id="successAlert" class="fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md z-50">
    <div class="flex items-center">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div id="errorAlert" class="fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md z-50">
    <div class="flex items-center">
        <i class="fa-solid fa-exclamation-circle mr-2"></i>
        <span>{{ session('error') }}</span>
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

    // Update article status
    function ubahstatus(id) {
        document.getElementById('ubahstatusform' + id).submit();
    }

    // Delete article confirmation
    function deleteArtikel(id, judul) {
        if (confirm(`Apakah Anda yakin ingin menghapus artikel "${judul}"?`)) {
            document.getElementById('delete-Artikel-' + id).submit();
        }
    }

    // Delete category confirmation
    function deleteCategory(id, judul) {
        if (confirm(`Apakah Anda yakin ingin menghapus kategori "${judul}"?`)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // Send notification
    function notif(id) {
        // Your existing notification code or add new implementation
        alert('Fitur notifikasi akan segera tersedia!');
    }

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        
        if (successAlert) {
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }
        
        if (errorAlert) {
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 500);
        }
    }, 5000);
</script>
@endsection
