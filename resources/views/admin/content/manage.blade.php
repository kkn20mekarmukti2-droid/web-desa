@extends('layout.admin')
@section('content')
    <main class=" w-full">

        <div class=" w-full max-sm:w-full">
            <div class="  border-b-2 border-gray-300 relative  rounded-md shadow-2xl m-10 p-5 max-sm:pt-14">
                <div class="flex justify-between">
                    <a href="{{ route('addartikel') }}"
                        class="col-span-2  p-2 rounded-md text-white font-bold bg-blue-700 hover:bg-blue-900 transition-all">Tambah
                        Berita +</a>
                    <button onclick="openModal()"
                        class="col-span-2  p-2 rounded-md text-white font-bold bg-yellow-600 hover:bg-yellow-900 transition-all">Manage
                        Kategori</button>

                </div>
                <div class=" grid grid-cols-2 max-sm:grid-cols-1 gap-4">

                    @foreach ($artikel as $i)
                        <div class="w-full">
                            <div
                                class="group border-b-2 relative shadow-sm hover:shadow-xl transition-all hover:border-blue-600 mt-5 mr-5 w-full">
                                <div class="flex w-full">
                                    @if (strpos($i->sampul, 'youtube'))
                                        <iframe class="h-44 w-1/2 max-sm:h-28" src="{{ $i->sampul }}"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    @else
                                        <img src="{{ asset('img/' . $i->sampul) }}" alt=""
                                            class="lg:h-44  max-w-80 max-sm:h-28 lg:w-72 w-1/2 hover:ring-1 transition-all ease-in-out rounded-md hover:z-50">
                                    @endif
                                    <div class="lg:ml-4 w-full max-sm:ml-1">
                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('preview', ['id' => $i->id]) }}" class="flex">
                                                <h2 class="text-xl group-hover:text-primary mt-2 max-sm:text-sm">
                                                    {{ $i->judul }}</h2>
                                            </a>
                                            <div class="flex gap-5 max-sm:gap-1">
                                                <i class="fa-regular fa-bell cursor-pointer"
                                                    onclick="notif({{ $i->id }})"></i>
                                                    <a href="{{ route('artikel.edit', ['id'=>$i->id]) }}">
                                                <i class="fa-regular fa-pen-to-square cursor-pointer"
                                                    ></i></a>
                                                <form id="delete-Artikel-{{ $i->id }}"
                                                    action="{{ route('artikel.delete', $i->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="deleteArtikel({{ $i->id }},'{{ $i->judul }}')"
                                                        class="text-red-600 hover:cursor-pointer">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('ubahstatus') }}" method="POST" class="z-40"
                                                    id="ubahstatusform{{ $i->id }}"> <label
                                                        class="inline-flex items-center cursor-pointer">
                                                        @csrf
                                                        <input type="hidden" value="{{ $i->id }}" name="id">
                                                        <input type="checkbox" value="1" class="sr-only peer"
                                                            name="status" onchange="ubahstatus({{ $i->id }})"
                                                            @if ($i->status) checked @endif>
                                                        <div
                                                            class="relative w-11 h-6 max-sm:scale-75 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                        </div>
                                                    </label>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="flex items-center ">

                                            <span class="text-sm text-gray-500 lg:mr-5 mr-2 max-sm:text-xs"><i
                                                    class="fa-regular fa-clock mr-1"></i>{{ date('d/m/Y', strtotime($i->created_at)) }}</span>
                                            @if ($i->kategori != '')
                                                <span class="text-sm text-gray-500 lg:mr-5 mr-2 max-sm:text-xs"><i
                                                        class="fa-solid fa-tag"></i>
                                                    {{ $i->getKategori->judul }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="overflow-y-auto mt-3 max-sm:text-xs">
                                            <p class="w-full text-justify max-h-24 max-sm:pr-4">
                                                {{ $i->header }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div id="kategoriModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-lg">
                <h2 class="text-xl font-bold mb-4">Manage Kategori</h2>

                <div id="categoryList" class="mb-6">
                    <ul>
                        @foreach ($kategori as $i)
                            <li class="flex justify-between items-center p-2">
                                <p>{{ $i->judul }}</p>
                                <form id="delete-form-{{ $i->id }}" action="{{ route('kategori.delete', $i->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="deleteCategory({{ $i->id }},'{{ $i->judul }}')"
                                        class="text-red-600 hover:cursor-pointer">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="addModal()"
                        class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                        Tambah Kategori
                    </button>
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
        <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-[60]">
            <div class="bg-white p-6 rounded-lg w-full max-w-lg">
                <h2 class="text-xl font-bold mb-4">Tambah Kategori</h2>

                <form id="categoryForm" class="mb-4" action="{{ route('kategori.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="judul" class="block text-lg font-medium text-gray-700">Judul Kategori <span
                                class="text-red-600">*</span></label>
                        <input type="text" id="judul" name="judul" required
                            class="mt-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 transition-colors duration-300 ease-in-out hover:bg-gray-100">
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">Simpan</button>
                        <button type="button" onclick="closeModaladd()"
                            class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">
                            Cancel
                        </button>

                    </div>
                </form>

            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        function deleteCategory(id, judul) {
            if (confirm('Anda yakin mendelete kategori ' + judul + ' ?')) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        }
        function deleteArtikel(id, judul) {
            if (confirm('Anda yakin mendelete Berita ' + judul + ' ?')) {
                document.getElementById(`delete-Artikel-${id}`).submit();
            }
        }

        function openModal() {
            document.getElementById('kategoriModal').classList.remove('hidden');
        }

        function addModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('kategoriModal').classList.add('hidden');
        }

        function closeModaladd() {
            document.getElementById('addModal').classList.add('hidden');
        }
        document.getElementById('toggleButton').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('-translate-x-full') || sidebar.classList.contains('max-sm:hidden')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.remove('hidden');
                sidebar.classList.remove('max-sm:hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.add('hidden');
            }
        });

        function uploadImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);

                document.getElementById("imageUploadForm").submit();
            }
        }

        function ubahstatus(id) {
            var idform = "ubahstatusform" + id;
            document.getElementById(idform).submit();
        }

        function notif(id) {
            document.getElementById('loading').classList.remove('hidden');

            fetch('{{ route('notif.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    toastr.success('Berhasil Mengirimkan Notifikasi ke ' + data.success + ' Subscriber')
                })
                .catch(error => {
                    toastr.error('Gagal Mengirimkan Notifikasi');
                })
                .finally(() => {
                    document.getElementById('loading').classList.add('hidden');
                });

        }


    </script>
@endsection
