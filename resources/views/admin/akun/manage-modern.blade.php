@extends('layout.admin-modern')
@section('title', 'Manage Users')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👥 Manage Users</h1>
            <p class="page-subtitle">Kelola akun pengguna dan permission sistem</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('akun.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Tambah User
            </a>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success') || session('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') ?? session('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Users Table Card -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-users me-2"></i>
            Daftar User Sistem
        </h5>
    </div>
    <div class="card-body p-0">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">
                            <i class="fas fa-user me-1"></i>
                            Nama & Email
                        </th>
                        <th class="px-4 py-3">
                            <i class="fas fa-shield-alt me-1"></i>
                            Role
                        </th>
                        <th class="px-4 py-3">
                            <i class="fas fa-key me-1"></i>
                            Reset Password
                        </th>
                        <th class="px-4 py-3 text-center">
                            <i class="fas fa-cogs me-1"></i>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td class="px-4 py-3">
                            <span class="badge bg-secondary">{{ $index + 1 }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('akun.roleupdate', $user) }}" method="POST" class="role-form">
                                @csrf
                                <div class="input-group input-group-sm" style="max-width: 200px;">
                                    <select name="role" class="form-select form-select-sm role-select" onchange="this.form.submit()">
                                        <option value="SuperAdmin" {{ $user->role == 'SuperAdmin' ? 'selected' : '' }}>SuperAdmin</option>
                                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Writer" {{ $user->role == 'Writer' ? 'selected' : '' }}>Writer</option>
                                        <option value="Editor" {{ $user->role == 'Editor' ? 'selected' : '' }}>Editor</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('akun.resetpass', $user) }}" method="POST" class="password-form">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <input type="password" 
                                           name="password" 
                                           class="form-control form-control-sm" 
                                           placeholder="New password"
                                           style="max-width: 120px;"
                                           required>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           class="form-control form-control-sm" 
                                           placeholder="Confirm"
                                           style="max-width: 100px;"
                                           required>
                                    <button type="submit" class="btn btn-outline-warning btn-sm" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-info" title="View Details" onclick="showUserDetails('{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->created_at->format('d/m/Y H:i') }}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                <button type="button" class="btn btn-outline-danger" title="Delete User" onclick="deleteUser('{{ $user->id }}', '{{ $user->name }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted">Belum Ada User</h4>
            <p class="text-muted mb-4">Mulai dengan menambahkan user pertama</p>
            <a href="{{ route('akun.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Tambah User Pertama
            </a>
        </div>
        @endif
    </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user me-2"></i>
                    Detail User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <div class="p-2 bg-light rounded" id="userName"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="p-2 bg-light rounded" id="userEmail"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Role</label>
                        <div class="p-2 bg-light rounded" id="userRole"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Bergabung Sejak</label>
                        <div class="p-2 bg-light rounded" id="userCreated"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Form -->
<form id="deleteUserForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Custom Styles -->
<style>
.role-form {
    margin: 0;
}

.password-form {
    margin: 0;
}

.user-avatar {
    flex-shrink: 0;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
}

.table td {
    vertical-align: middle;
}

.role-select {
    cursor: pointer;
}

.input-group-sm .form-control,
.input-group-sm .form-select {
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .input-group {
        flex-direction: column;
    }
    
    .input-group .form-control,
    .input-group .form-select {
        margin-bottom: 0.25rem;
        max-width: 100% !important;
    }
}
</style>

<!-- JavaScript -->
<script>
function showUserDetails(name, email, role, created) {
    document.getElementById('userName').textContent = name;
    document.getElementById('userEmail').textContent = email;
    document.getElementById('userRole').textContent = role;
    document.getElementById('userCreated').textContent = created;
    
    const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
    modal.show();
}

function deleteUser(userId, userName) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus user "${userName}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteUserForm');
            form.action = `{{ url('admin/users') }}/${userId}`;
            form.submit();
        }
    });
}

// Auto-submit role change with confirmation
document.querySelectorAll('.role-select').forEach(select => {
    select.addEventListener('change', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const newRole = this.value;
        const userName = this.closest('tr').querySelector('.fw-semibold').textContent;
        
        Swal.fire({
            title: 'Konfirmasi Ubah Role',
            text: `Ubah role "${userName}" menjadi "${newRole}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else {
                // Reset select to original value
                this.selectedIndex = 0;
            }
        });
    });
});

// Password form confirmation
document.querySelectorAll('.password-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const userName = this.closest('tr').querySelector('.fw-semibold').textContent;
        
        Swal.fire({
            title: 'Konfirmasi Reset Password',
            text: `Reset password untuk user "${userName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>

@endsection
