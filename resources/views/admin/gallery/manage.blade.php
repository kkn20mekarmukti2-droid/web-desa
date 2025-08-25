@extends('layout.admin')
@section('content')
    <main class="bg-gray-100 w-full">
        <div class="container mx-auto p-4">
            <!-- Header -->
            <header class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Gallery</h1>
                <button onclick="openModal('add')" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                    Tambah +
                </button>
            </header>

            <!-- Gallery List -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($galleries as $gallery)
                    <div class="bg-white shadow rounded-lg p-4">
                        @if ($gallery->type == 'foto')
                            <img src="{{ asset('galeri/' . $gallery->url) }}" alt="{{ $gallery->judul }}"
                                class="w-full h-48 object-cover rounded">
                        @elseif ($gallery->type == 'youtube')
                            <iframe width="100%" height="200" src="{{ $gallery->url }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        @elseif ($gallery->type == 'tiktok')
                        <iframe  height="200" width= "100%" src="https://www.tiktok.com/player/v1/{{$gallery->url}}?description=1&loop=1" allow="fullscreen" title="test"></iframe>
                        @endif
                        <h2 class="text-lg font-semibold mt-2">{{ $gallery->judul }}</h2>
                        <button onclick="deleteItem({{ $gallery->id }})"
                            class="mt-2 bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600">
                            Delete
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <div id="galleryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg w-full max-w-lg">
                <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah Galeri</h2>
                <form id="galleryForm" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="galleryId" name="galleryId">

                    <div class="mb-6">
                        <label class="block text-lg font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" id="judul"
                            class="mt-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100"
                            >
                    </div>

                    <div class="mb-6">
                        <label class="block text-lg font-medium text-gray-700">Tipe<span
                                class="text-red-500">*</span></label>
                        <div class="mt-2 flex items-center space-x-4">
                            <input type="radio" id="uploadImage" name="type" value="foto"
                                class="focus:ring-indigo-500 focus:border-indigo-500">
                            <label for="uploadImage" class="text-gray-700">Foto</label>
                            <input type="radio" id="uploadYoutube" name="type" value="youtube"
                                class="focus:ring-indigo-500 focus:border-indigo-500">
                            <label for="uploadYoutube" class="text-gray-700">YouTube</label>
                            <input type="radio" id="uploadTiktok" name="type" value="tiktok"
                                class="focus:ring-indigo-500 focus:border-indigo-500">
                            <label for="uploadTiktok" class="text-gray-700">TikTok</label>
                        </div>
                    </div>

                    <div id="imageUpload" class="mb-6 hidden">
                        <label for="foto" class="block text-lg font-medium text-gray-700">Foto<span
                                class="text-red-500">*</span></label>
                        <input type="file" id="foto" name="url"
                            class="mt-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="previewImage" src="" alt="Image Preview" class="ring-2 ring-black rounded-lg"
                                style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>

                    <div id="youtubeLink" class="mb-6 hidden">
                        <label for="youtube" class="block text-lg font-medium text-gray-700">YouTube Link<span
                                class="text-red-500">*</span></label>
                        <input type="url" id="youtube" name="youtube"
                            class="mt-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100"
                            placeholder="YouTube Link">
                    </div>

                    <div id="tiktokLink" class="mb-6 hidden">
                        <label for="tiktok" class="block text-lg font-medium text-gray-700">TikTok Video Link<span
                                class="text-red-500">*</span></label>
                        <input type="url" id="tiktok" name="tiktok"
                            class="mt-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100"
                            placeholder="TikTok Video Link">
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 ml-2">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        function openModal(action, itemId = null) {
            document.getElementById('galleryModal').classList.remove('hidden');
            if (action === 'add') {
                document.getElementById('modalTitle').textContent = 'Tambah Galeri';
                document.getElementById('galleryForm').action = '{{ route('gallery.store') }}';
                document.getElementById('galleryId').value = '';
                document.getElementById('galleryForm').reset();
            }
            toggleFormSections();
        }

        function closeModal() {
            document.getElementById('galleryModal').classList.add('hidden');
        }

        function toggleFormSections() {
            const type = document.querySelector('input[name="type"]:checked')?.value;
            document.getElementById('imageUpload').classList.toggle('hidden', type !== 'foto');
            document.getElementById('youtubeLink').classList.toggle('hidden', type !== 'youtube');
            document.getElementById('tiktokLink').classList.toggle('hidden', type !== 'tiktok');
        }

        document.querySelectorAll('input[name="type"]').forEach(radio => {
            radio.addEventListener('change', toggleFormSections);
        });

        document.getElementById('foto').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('previewImage');
                    previewImage.src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        function deleteItem(id) {
            if (confirm('Anda yakin ingin mendelete foto/video ini?')) {
                document.getElementById('galleryForm').action = `{{ route('gallery.delete', '') }}/${id}`;
                document.getElementById('galleryForm').method = 'DELETE';
                document.getElementById('galleryForm').submit();
            }
        }
    </script>
@endsection
