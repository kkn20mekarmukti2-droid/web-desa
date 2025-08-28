<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Statistik - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px 15px 0 0;
            color: white;
            padding: 20px 30px;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.statistik.index') }}">
                <i class="fas fa-chart-bar me-2"></i>Kelola Data Statistik
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('admin.statistik.index', ['kategori' => $kategori]) }}">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-dark">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Data Statistik
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.statistik.index') }}" class="text-decoration-none">Data Statistik</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.statistik.index', ['kategori' => $kategori]) }}" class="text-decoration-none">
                                {{ $kategoriOptions[$kategori] }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Data</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="form-header">
                        <h4 class="mb-0">
                            @switch($kategori)
                                @case('jenis_kelamin')
                                    <i class="fas fa-users me-2"></i>
                                    @break
                                @case('agama')
                                    <i class="fas fa-pray me-2"></i>
                                    @break
                                @case('pekerjaan')
                                    <i class="fas fa-briefcase me-2"></i>
                                    @break
                            @endswitch
                            Tambah {{ $kategoriOptions[$kategori] }}
                        </h4>
                        <small class="opacity-75">Isi form di bawah untuk menambah data statistik baru</small>
                    </div>
                    
                    <div class="p-4">
                        <form action="{{ route('admin.statistik.store') }}" method="POST">
                            @csrf
                            
                            <!-- Hidden kategori field -->
                            <input type="hidden" name="kategori" value="{{ $kategori }}">
                            
                            <!-- Kategori Display -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-tag me-2"></i>Kategori
                                </label>
                                <div class="form-control bg-light">
                                    <strong class="text-primary">{{ $kategoriOptions[$kategori] }}</strong>
                                </div>
                            </div>

                            <!-- Label -->
                            <div class="mb-4">
                                <label for="label" class="form-label">
                                    <i class="fas fa-bookmark me-2"></i>Label / Nama Data
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('label') is-invalid @enderror" 
                                       id="label" 
                                       name="label" 
                                       value="{{ old('label') }}"
                                       placeholder="Contoh: {{ 
                                           $kategori === 'jenis_kelamin' ? 'Laki-laki, Perempuan' :
                                           ($kategori === 'agama' ? 'Islam, Kristen, Hindu, Buddha' : 
                                           'Petani, PNS, Wiraswasta, Pelajar')
                                       }}"
                                       required>
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Nama yang akan ditampilkan pada chart statistik
                                </div>
                            </div>

                            <!-- Jumlah -->
                            <div class="mb-4">
                                <label for="jumlah" class="form-label">
                                    <i class="fas fa-calculator me-2"></i>Jumlah Data
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('jumlah') is-invalid @enderror" 
                                       id="jumlah" 
                                       name="jumlah" 
                                       value="{{ old('jumlah') }}"
                                       min="0"
                                       placeholder="Masukkan jumlah dalam angka"
                                       required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Jumlah data dalam angka (contoh: 1250)
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <label for="deskripsi" class="form-label">
                                    <i class="fas fa-sticky-note me-2"></i>Deskripsi
                                    <small class="text-muted">(Opsional)</small>
                                </label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="3"
                                          placeholder="Deskripsi tambahan atau keterangan...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Informasi tambahan untuk dokumentasi internal
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 pt-3 border-top">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-save me-2"></i>Simpan Data
                                </button>
                                <a href="{{ route('admin.statistik.index', ['kategori' => $kategori]) }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-info mt-4" style="border-radius: 10px;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-lightbulb me-3 fs-4"></i>
                        <div>
                            <strong>Tips:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Gunakan nama yang jelas dan mudah dipahami untuk label</li>
                                <li>Pastikan data jumlah akurat dan up-to-date</li>
                                <li>Data akan langsung tampil di chart halaman utama setelah disimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
