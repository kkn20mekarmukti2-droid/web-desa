<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Statistik - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .category-tabs {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 30px;
        }
        .category-tab {
            background: white;
            border: 1px solid #ddd;
            color: #666;
            padding: 12px 20px;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-right: 10px;
            display: inline-block;
        }
        .category-tab:hover {
            background: #e9ecef;
            color: #495057;
            text-decoration: none;
        }
        .category-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .alert-custom {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-chart-bar me-2"></i>Kelola Data Statistik
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                </a>
                <a class="nav-link" href="{{ route('content.manage') }}">
                    <i class="fas fa-newspaper me-1"></i>Kelola Konten
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-dark mb-1">
                            <i class="fas fa-chart-pie me-2 text-primary"></i>Data Statistik Penduduk
                        </h2>
                        <p class="text-muted mb-0">Kelola data statistik untuk chart di halaman utama</p>
                    </div>
                    <a href="{{ route('admin.statistik.create', ['kategori' => $kategori]) }}" 
                       class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Tambah Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <h6 class="mb-3 text-dark">
                <i class="fas fa-filter me-2"></i>Pilih Kategori Data:
            </h6>
            <div class="d-flex flex-wrap">
                @foreach($kategoriOptions as $key => $label)
                    <a href="{{ route('admin.statistik.index', ['kategori' => $key]) }}" 
                       class="category-tab {{ $kategori == $key ? 'active' : '' }}">
                        @switch($key)
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
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Current Category Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="stats-card p-4">
                    <h4 class="text-primary mb-3">
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
                        {{ $kategoriOptions[$kategori] }}
                    </h4>
                    <p class="text-muted mb-3">
                        Data ini akan ditampilkan pada chart statistik di halaman utama website desa.
                        Total {{ $statistik->count() }} data tersedia.
                    </p>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="stats-card">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center" 
                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h6 class="mb-0">
                            <i class="fas fa-table me-2"></i>Daftar Data {{ $kategoriOptions[$kategori] }}
                        </h6>
                        <span class="badge bg-light text-dark">{{ $statistik->count() }} data</span>
                    </div>
                    <div class="card-body">
                        @if($statistik->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="30%">
                                                <i class="fas fa-tag me-1"></i>Label
                                            </th>
                                            <th width="20%">
                                                <i class="fas fa-calculator me-1"></i>Jumlah
                                            </th>
                                            <th width="30%">
                                                <i class="fas fa-sticky-note me-1"></i>Deskripsi
                                            </th>
                                            <th width="15%" class="text-center">
                                                <i class="fas fa-cogs me-1"></i>Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($statistik as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong class="text-primary">{{ $item->label }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success fs-6">
                                                        {{ number_format($item->jumlah) }} orang
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $item->deskripsi ? Str::limit($item->deskripsi, 50) : '-' }}
                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.statistik.edit', $item->id) }}" 
                                                           class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.statistik.destroy', $item->id) }}" 
                                                              method="POST" class="d-inline" 
                                                              onsubmit="return confirm('Yakin ingin menghapus data {{ $item->label }}?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th>
                                                <span class="badge bg-primary fs-6">
                                                    {{ number_format($statistik->sum('jumlah')) }} orang
                                                </span>
                                            </th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-chart-pie text-muted" style="font-size: 4rem;"></i>
                                <h4 class="text-muted mt-3">Belum Ada Data</h4>
                                <p class="text-muted">Mulai tambahkan data statistik untuk kategori {{ $kategoriOptions[$kategori] }}.</p>
                                <a href="{{ route('admin.statistik.create', ['kategori' => $kategori]) }}" 
                                   class="btn btn-primary-custom mt-3">
                                    <i class="fas fa-plus me-2"></i>Tambah Data Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-info alert-custom">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-3 fs-4"></i>
                        <div>
                            <strong>Informasi:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Data ini akan otomatis ditampilkan pada chart statistik di halaman utama</li>
                                <li>Pastikan data selalu update dan akurat</li>
                                <li>Gunakan deskripsi untuk memberikan informasi tambahan</li>
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
