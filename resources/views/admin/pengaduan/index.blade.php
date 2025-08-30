@extends('layout.admin-modern')

@section('title', 'Kelola Pengaduan')

@section('content')
<div class="main-content">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">📝 Kelola Pengaduan Masyarakat</h1>
            <p class="page-subtitle">Daftar pengaduan yang masuk dari masyarakat melalui website desa</p>
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Success Alert -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $pengaduan->count() }}</h3>
                            <p>Total Pengaduan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $pengaduan->where('created_at', '>=', now()->subDays(7))->count() }}</h3>
                            <p>Minggu Ini</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $pengaduan->where('created_at', '>=', now()->startOfDay())->count() }}</h3>
                            <p>Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaduan Table -->
        <div class="data-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-list me-2"></i>Daftar Pengaduan Masyarakat
                </h2>
                <p class="card-subtitle">Kelola dan pantau pengaduan yang masuk dari masyarakat</p>
            </div>

            <div class="card-body">
                @if($pengaduan->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-inbox empty-icon"></i>
                    <h3>Belum Ada Pengaduan</h3>
                    <p>Belum ada pengaduan yang masuk dari masyarakat. Pengaduan akan muncul di sini ketika masyarakat mengirim melalui form di website.</p>
                    
                    <div class="empty-tips">
                        <h5>💡 Tips:</h5>
                        <ul>
                            <li>Pastikan form pengaduan di website dapat diakses</li>
                            <li>Sosialisasikan ke masyarakat tentang adanya layanan pengaduan online</li>
                            <li>Responsif dalam menanggapi pengaduan yang masuk</li>
                        </ul>
                    </div>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-header">
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Nama</th>
                                <th width="12%">No. HP</th>
                                <th width="20%">Alamat</th>
                                <th width="35%">Isi Pengaduan</th>
                                <th width="13%">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduan as $index => $item)
                            <tr>
                                <td><span class="badge bg-primary">{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="user-info">
                                        <strong>{{ $item->nama }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $item->no_hp }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $item->alamat_lengkap }}</span>
                                </td>
                                <td>
                                    <div class="pengaduan-content">
                                        {{ Str::limit($item->isi, 100) }}
                                        @if(strlen($item->isi) > 100)
                                            <br><a href="#" class="text-primary text-sm" onclick="showFullContent('{{ $item->id }}')">Lihat selengkapnya...</a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $item->created_at->format('d M Y') }}</span>
                                    <br><small>{{ $item->created_at->format('H:i') }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for Full Content -->
<div class="modal fade" id="contentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
const pengaduanData = @json($pengaduan->keyBy('id'));

function showFullContent(id) {
    const pengaduan = pengaduanData[id];
    const content = `
        <div class="row">
            <div class="col-md-6">
                <strong>Nama:</strong><br>
                ${pengaduan.nama}<br><br>
                <strong>No. HP:</strong><br>
                ${pengaduan.no_hp}<br><br>
                <strong>Tanggal:</strong><br>
                ${new Date(pengaduan.created_at).toLocaleString('id-ID')}
            </div>
            <div class="col-md-6">
                <strong>Alamat Lengkap:</strong><br>
                ${pengaduan.alamat_lengkap}
            </div>
        </div>
        <hr>
        <strong>Isi Pengaduan:</strong><br>
        ${pengaduan.isi.replace(/\n/g, '<br>')}
    `;
    document.getElementById('modalContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('contentModal')).show();
}
</script>
@endsection
