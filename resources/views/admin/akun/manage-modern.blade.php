@extends('layout.admin-modern')
@section('title', 'Manage Users')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👥 Manage Users</h1>
   function showUserDetails(userId) {
    // Show loading state
    document.getElementById('userDetailName').textContent = 'Loading...';
    document.getElementById('userDetailEmail').textContent = 'Loading...';
    document.getElementById('userDetailRole').textContent = 'Loading...';
    document.getElementById('userDetailCreated').textContent = 'Loading...';
    document.getElementById('userDetailUpdated').textContent = 'Loading...';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
    modal.show();
    
    // Fetch user details
    fetch(`/admin/users/${userId}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('userDetailName').textContent = data.user.name;
            document.getElementById('userDetailEmail').textContent = data.user.email;
            document.getElementById('userDetailRole').textContent = data.user.role;
            document.getElementById('userDetailCreated').textContent = data.user.created_at;
            document.getElementById('userDetailUpdated').textContent = data.user.updated_at;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Gagal memuat detail user',
            });
            modal.hide();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Gagal memuat detail user',
        });
        modal.hide();
    });
}<p class="page-subtitle">Kelola akun pengguna dan permission sistem</p>
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
                                    <select name="role" class="form-select form-select-sm role-select" 
                                            @if(Auth::user()->role === 'Admin' && $user->role === 'SuperAdmin') disabled @endif
                                            onchange="this.form.submit()">
                                        @php
                                            $availableRoles = [];
                                            if (Auth::user()->role === 'SuperAdmin') {
                                                $availableRoles = [
                                                    'SuperAdmin' => 'SuperAdmin',
                                                    'Admin' => 'Admin', 
                                                    'Writer' => 'Writer',
                                                    'Editor' => 'Editor'
                                                ];
                                            } elseif (Auth::user()->role === 'Admin') {
                                                $availableRoles = [
                                                    'Admin' => 'Admin',
                                                    'Writer' => 'Writer', 
                                                    'Editor' => 'Editor'
                                                ];
                                            }
                                            
                                            // If current user is Admin and target is SuperAdmin, show current role only
                                            if (Auth::user()->role === 'Admin' && $user->role === 'SuperAdmin') {
                                                $availableRoles = ['SuperAdmin' => 'SuperAdmin'];
                                            }
                                        @endphp
                                        
                                        @foreach($availableRoles as $roleValue => $roleDisplay)
                                            <option value="{{ $roleValue }}" {{ $user->role == $roleValue ? 'selected' : '' }}>
                                                {{ $roleDisplay }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if(!(Auth::user()->role === 'Admin' && $user->role === 'SuperAdmin'))
                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-outline-secondary btn-sm" disabled title="Tidak dapat mengubah SuperAdmin">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                    @endif
                                </div>
                            </form>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $canResetPassword = false;
                                
                                // SuperAdmin can reset anyone's password except their own
                                if (Auth::user()->role === 'SuperAdmin') {
                                    $canResetPassword = ($user->id !== Auth::id());
                                }
                                // Admin can reset Writer and Editor passwords only
                                elseif (Auth::user()->role === 'Admin') {
                                    $canResetPassword = in_array($user->role, ['Writer', 'Editor']);
                                }
                            @endphp
                            
                            @if($canResetPassword)
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
                            @else
                            <div class="text-muted small">
                                @if($user->id === Auth::id())
                                    <i class="fas fa-lock me-1"></i>Tidak dapat reset password sendiri
                                @else
                                    <i class="fas fa-ban me-1"></i>Tidak dapat reset password {{ $user->role }}
                                @endif
                            </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-info" title="View Details" onclick="showUserDetails({{ $user->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                @php
                                    $canEdit = false;
                                    $canDelete = false;
                                    
                                    // SuperAdmin can edit/delete anyone except themselves for delete
                                    if (Auth::user()->role === 'SuperAdmin') {
                                        $canEdit = true;
                                        $canDelete = ($user->id !== Auth::id()); // Can't delete themselves
                                    }
                                    // Admin can edit/delete Writer and Editor only
                                    elseif (Auth::user()->role === 'Admin') {
                                        $canEdit = in_array($user->role, ['Writer', 'Editor']);
                                        $canDelete = in_array($user->role, ['Writer', 'Editor']);
                                    }
                                @endphp
                                
                                @if($user->id !== auth()->id())
                                    <!-- Edit Button -->
                                    @if($canEdit)
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @else
                                    <button type="button" class="btn btn-outline-secondary" disabled 
                                            title="@if(Auth::user()->role === 'Admin' && in_array($user->role, ['SuperAdmin', 'Admin']))Tidak dapat mengedit {{ $user->role }}@else Aksi tidak diizinkan @endif">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endif
                                    
                                    <!-- Delete Button -->
                                    @if($canDelete)
                                    <button type="button" class="btn btn-outline-danger" title="Delete User" onclick="deleteUser('{{ $user->id }}', '{{ $user->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-outline-secondary" disabled 
                                            title="@if(Auth::user()->role === 'Admin' && in_array($user->role, ['SuperAdmin', 'Admin']))Tidak dapat menghapus {{ $user->role }}@else Aksi tidak diizinkan @endif">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
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
                        <div class="p-2 bg-light rounded" id="userDetailName"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="p-2 bg-light rounded" id="userDetailEmail"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Role</label>
                        <div class="p-2 bg-light rounded" id="userDetailRole"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Bergabung Sejak</label>
                        <div class="p-2 bg-light rounded" id="userDetailCreated"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Terakhir Diupdate</label>
                        <div class="p-2 bg-light rounded" id="userDetailUpdated"></div>
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
