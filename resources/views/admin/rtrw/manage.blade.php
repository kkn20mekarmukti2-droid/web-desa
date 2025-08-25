@extends('layout.admin')
@section('content')
    <main class="bg-gray-100 p-10 w-full">
        <div class="container mx-auto mt-10">
            <div class="flex justify-between mb-6">
                <h1 class="text-2xl font-bold">Manage RT RW</h1>
                <a href="{{ route('rw.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah RW</a>
            </div>

            @if (session('success'))
                <div class="bg-green-500 text-white p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @foreach ($rws as $rw)
                <div class="bg-white shadow-md rounded-lg p-4 mb-6">
                    <div class="flex items-center my-5 justify-center scale-105">
                        <div class="border-b-2 pb-2 px-4 flex items-center border-yellow-400">
                            @if ($rw->foto)
                                <img src="{{ asset($rw->foto) }}" alt="Photo of " class="w-16 h-16 rounded-full mr-4">
                            @else
                                <img src="https://www.its.ac.id/aktuaria/wp-content/uploads/sites/100/2018/03/user.png"
                                    alt="Photo of " class="w-16 h-16 rounded-full mr-4">
                            @endif
                            <div>
                                <h2 class="text-xl font-semibold">{{ $rw->nama }}</h2>
                                <p class="text-gray-600">RW {{ str_pad($rw->rw, 2, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-gray-600">{{ $rw->kontak }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mb-4">
                        <form action="{{ route('rw.delete', $rw->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded"
                                onclick="confirmDelete(event)">Delete RW</button>
                        </form>
                        <a href="{{ route('rt.create', ['rw_id' => $rw->rw]) }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Tambah
                            RT</a>
                    </div>
                    <h3 class="text-lg font-bold mb-2">RT dari RW {{ str_pad($rw->rw, 2, '0', STR_PAD_LEFT) }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($rw->rts as $rt)
                            <div class="bg-gray-50 p-4 rounded-lg shadow">
                                <div class="flex items-center mb-2">
                                    @if ($rt->foto)
                                        <img src="{{ asset($rt->foto) }}" alt="Photo of "
                                            class="w-12 h-12 rounded-full mr-3">
                                    @else
                                        <img src="https://www.its.ac.id/aktuaria/wp-content/uploads/sites/100/2018/03/user.png"
                                            alt="Photo of " class="w-12 h-12 rounded-full mr-3">
                                    @endif
                                    <div class="flex flex-col justify-center">
                                        <h4 class="text-md font-semibold">{{ $rt->nama }}</h4>
                                        <p class="text-gray-600">RT {{ str_pad($rt->rt, 2, '0', STR_PAD_LEFT) }}</p>
                                        @if ($rt->kontak)
                                            <p class="text-gray-600">{{ $rt->kontak }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <form action="{{ route('rt.delete', $rt->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded"
                                            onclick="confirmDelete(event)">Delete
                                            RT</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
@section('script')
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm("Anda yakin mendelete RT atau RW ini?")) {
                event.target.closest('form').submit();
            }
        }
    </script>
@endsection
