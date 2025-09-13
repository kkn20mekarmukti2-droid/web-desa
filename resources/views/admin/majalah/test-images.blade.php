@extends('layout.admin-modern')

@section('title', 'Test Majalah Images')

@section('content')
<div class="main-content">
    <div class="page-header">
        <h1>Test Majalah Images</h1>
    </div>

    <div class="content-wrapper">
        @foreach($majalah as $item)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $item->judul }}</h5>
                        <p>Cover path in DB: <code>{{ $item->cover_image }}</code></p>
                        
                        <div class="row">
                            <!-- Test 1: Direct path -->
                            <div class="col-md-3">
                                <h6>Test 1: asset($item->cover_image)</h6>
                                <p>Path: <code>{{ $item->cover_image }}</code></p>
                                <p>Exists: {{ file_exists(public_path($item->cover_image)) ? 'YES' : 'NO' }}</p>
                                @if(file_exists(public_path($item->cover_image)))
                                    <img src="{{ asset($item->cover_image) }}" style="width: 100px; height: 120px; object-fit: cover;" class="border">
                                @else
                                    <div style="width: 100px; height: 120px;" class="border d-flex align-items-center justify-content-center bg-light">
                                        NO IMAGE
                                    </div>
                                @endif
                            </div>

                            <!-- Test 2: Storage path -->
                            <div class="col-md-3">
                                <h6>Test 2: storage path</h6>
                                <p>Path: <code>storage/{{ $item->cover_image }}</code></p>
                                <p>Exists: {{ file_exists(public_path('storage/' . $item->cover_image)) ? 'YES' : 'NO' }}</p>
                                @if(file_exists(public_path('storage/' . $item->cover_image)))
                                    <img src="{{ asset('storage/' . $item->cover_image) }}" style="width: 100px; height: 120px; object-fit: cover;" class="border">
                                @else
                                    <div style="width: 100px; height: 120px;" class="border d-flex align-items-center justify-content-center bg-light">
                                        NO IMAGE
                                    </div>
                                @endif
                            </div>

                            <!-- Test 3: Direct file -->
                            <div class="col-md-3">
                                <h6>Test 3: direct majalah folder</h6>
                                @php $filename = str_replace('majalah/', '', $item->cover_image); @endphp
                                <p>Path: <code>majalah/{{ $filename }}</code></p>
                                <p>Exists: {{ file_exists(public_path('majalah/' . $filename)) ? 'YES' : 'NO' }}</p>
                                @if(file_exists(public_path('majalah/' . $filename)))
                                    <img src="{{ asset('majalah/' . $filename) }}" style="width: 100px; height: 120px; object-fit: cover;" class="border">
                                @else
                                    <div style="width: 100px; height: 120px;" class="border d-flex align-items-center justify-content-center bg-light">
                                        NO IMAGE
                                    </div>
                                @endif
                            </div>

                            <!-- Test 4: Force display -->
                            <div class="col-md-3">
                                <h6>Test 4: Force display</h6>
                                <img src="{{ asset($item->cover_image) }}" style="width: 100px; height: 120px; object-fit: cover;" class="border" onerror="this.style.border='2px solid red';">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
