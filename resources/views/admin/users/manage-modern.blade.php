@extends('layout.admin-modern')

@section('title', 'Kelola User')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">👥 Kelola User</h1>
            <p class="page-subtitle">Kelola akses pengguna, role, dan permission dengan sistem keamanan yang modern</p>
        </div>
        <div class="page-actions">
            <button onclick="exportUsers()" class="btn btn-outline-success">
                <i class="fas fa-file-export"></i>
                Export Data
            </button>
            <button onclick="openAddUserModal()" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Tambah User
            </button>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="stats-grid mb-4">
    <div class="stats-card">
        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-users"></i>
        </div>
        <div class="stats-value">{{ $users->count() }}</div>
        <div class="stats-label">Total Users</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-success bg-opacity-10 text-success">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stats-value">{{ $users->where('status', 1)->count() }}</div>
        <div class="stats-label">Active Users</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
            <i class="fas fa-user-clock"></i>
        </div>
        <div class="stats-value">{{ $users->where('status', 0)->count() }}</div>
        <div class="stats-label">Inactive Users</div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon bg-info bg-opacity-10 text-info">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="stats-value">{{ $users->where('role', 'admin')->count() }}</div>
        <div class="stats-label">Administrators</div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari user..." id="searchInput">
                </div>
            </div>
            
            <div class="col-md-2 mb-3 mb-md-0">
                <select class="form-select" id="roleFilter">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="editor">Editor</option>
                    <option value="user">User</option>
                </select>
            </div>
            
            <div class="col-md-2 mb-3 mb-md-0">
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            
            <div class="col-md-2 mb-3 mb-md-0">
                <select class="form-select" id="sortBy">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="name">Nama A-Z</option>
                    <option value="email">Email A-Z</option>
                </select>
            </div>
            
            <div class="col-md-2 text-end">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog"></i> Actions
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="bulkActivate()">Activate Selected</a></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkDeactivate()">Deactivate Selected</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="bulkDelete()">Delete Selected</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users List -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            User Management
        </h5>
        <div class="d-flex align-items-center gap-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">
                    Select All
                </label>
            </div>
            <span class="text-muted" id="userCount">{{ $users->count() }} users</span>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="40"><input type="checkbox" id="headerCheckbox" class="form-check-input"></th>
                        <th>User Info</th>
                        <th>Contact</th>
                        <th>Role & Status</th>
                        <th>Last Activity</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @forelse ($users as $user)
                    <tr class="user-row fade-in-up" 
                        data-user-id="{{ $user->id }}"
                        data-name="{{ strtolower($user->name) }}"
                        data-email="{{ strtolower($user->email) }}"
                        data-role="{{ $user->role }}"
                        data-status="{{ $user->status }}"
                        data-date="{{ $user->created_at }}">
                        
                        <!-- Selection -->
                        <td>
                            <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                        </td>
                        
                        <!-- User Info -->
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    @if($user->avatar)
                                        <img src="{{ asset('avatars/' . $user->avatar) }}" 
                                             alt="{{ $user->name }}" 
                                             class="avatar-img">
                                    @else
                                        <div class="avatar-placeholder">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    @if($user->status)
                                        <div class="status-indicator online"></div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $user->name }}</h6>
                                    <small class="text-muted">ID: #{{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Contact -->
                        <td>
                            <div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    <span>{{ $user->email }}</span>
                                </div>
                                @if($user->phone)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone text-muted me-2"></i>
                                    <span class="text-muted">{{ $user->phone }}</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Role & Status -->
                        <td>
                            <div class="mb-2">
                                <span class="badge badge-{{ $user->role === 'admin' ? 'primary' : ($user->role === 'editor' ? 'info' : 'secondary') }}">
                                    <i class="fas fa-{{ $user->role === 'admin' ? 'crown' : ($user->role === 'editor' ? 'edit' : 'user') }} me-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <div>
                                <span class="badge badge-{{ $user->status ? 'success' : 'warning' }}">
                                    <i class="fas fa-{{ $user->status ? 'check-circle' : 'clock' }} me-1"></i>
                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </td>
                        
                        <!-- Last Activity -->
                        <td>
                            <div class="text-muted">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-calendar-plus me-2"></i>
                                    <small>Joined: {{ $user->created_at->format('d M Y') }}</small>
                                </div>
                                @if($user->last_login_at)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock me-2"></i>
                                    <small>Last: {{ $user->last_login_at->diffForHumans() }}</small>
                                </div>
                                @else
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-question-circle me-2"></i>
                                    <small>Never logged in</small>
                                </div>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Actions -->
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button onclick="viewUser({{ $user->id }})" 
                                    class="btn btn-outline-info" 
                                    title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <button onclick="editUser({{ $user->id }})" 
                                    class="btn btn-outline-warning"
                                    title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <button onclick="toggleUserStatus({{ $user->id }}, {{ $user->status ? 0 : 1 }})"
                                    class="btn btn-outline-{{ $user->status ? 'warning' : 'success' }}"
                                    title="{{ $user->status ? 'Deactivate' : 'Activate' }} User">
                                    <i class="fas fa-{{ $user->status ? 'user-slash' : 'user-check' }}"></i>
                                </button>
                                
                                <button onclick="resetPassword({{ $user->id }})"
                                    class="btn btn-outline-secondary"
                                    title="Reset Password">
                                    <i class="fas fa-key"></i>
                                </button>
                                
                                @if($user->id != auth()->id())
                                <button onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="btn btn-outline-danger"
                                    title="Delete User">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-users fa-4x text-muted opacity-50"></i>
                            </div>
                            <h4 class="text-muted mb-2">Belum ada user</h4>
                            <p class="text-muted mb-4">Mulai tambahkan user pertama untuk sistem</p>
                            <button onclick="openAddUserModal()" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>
                                Tambah User Pertama
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- No Results -->
        <div id="noResults" class="text-center py-5" style="display: none;">
            <div class="mb-4">
                <i class="fas fa-search fa-4x text-muted opacity-50"></i>
            </div>
            <h4 class="text-muted mb-2">Tidak ada user yang cocok</h4>
            <p class="text-muted">Coba gunakan filter atau kata kunci yang berbeda</p>
        </div>
    </div>
    
    @if($users->count() > 0)
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">
                Menampilkan <span id="visibleCount">{{ $users->count() }}</span> dari {{ $users->count() }} users
            </span>
            <div class="d-flex align-items-center gap-3">
                <small class="text-muted">Security Level: High</small>
                <span class="badge bg-success">System Secure</span>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fas fa-user-plus me-2"></i>
                    Tambah User Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addUserForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Info -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="addName" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="addName" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="addEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="addEmail" name="email" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="addPhone" class="form-label">No. Telepon (Opsional)</label>
                                    <input type="text" class="form-control" id="addPhone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="addRole" class="form-label">Role</label>
                                    <select class="form-select" id="addRole" name="role" required>
                                        <option value="user">User</option>
                                        <option value="editor">Editor</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Password -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="addPassword" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="addPassword" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('addPassword')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Minimal 8 karakter</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="addPasswordConfirm" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="addPasswordConfirm" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Avatar Upload -->
                            <div class="mb-3">
                                <label class="form-label">Avatar (Opsional)</label>
                                <div class="avatar-upload-area text-center p-3 border rounded">
                                    <div id="avatarPreview" class="avatar-preview mb-2">
                                        <i class="fas fa-user fa-3x text-muted"></i>
                                    </div>
                                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('avatarInput').click()">
                                        Upload Avatar
                                    </button>
                                    <div class="form-text">Max: 2MB (JPG, PNG)</div>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="addStatus" name="status" value="1" checked>
                                    <label class="form-check-label" for="addStatus">
                                        Aktifkan user setelah dibuat
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sendWelcomeEmail" name="send_welcome_email" checked>
                                    <label class="form-check-label" for="sendWelcomeEmail">
                                        Kirim email selamat datang
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>
                        Tambah User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- User Detail Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">
                    <i class="fas fa-user me-2"></i>
                    Detail User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="userDetailContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Hidden Forms for Actions -->
@foreach ($users as $user)
<form id="statusForm{{ $user->id }}" action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="d-none">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="">
</form>

<form id="deleteForm{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endforeach

@endsection

@push('styles')
<style>
    /* User Avatar Styles */
    .user-avatar {
        position: relative;
        width: 50px;
        height: 50px;
    }
    
    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #eee;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        font-size: 0.875rem;
    }
    
    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }
    
    .status-indicator.online {
        background-color: #10b981;
    }
    
    .status-indicator.offline {
        background-color: #6b7280;
    }
    
    /* Table Styles */
    .table th {
        border-top: none;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
    }
    
    .table td {
        vertical-align: middle;
        border-color: #f3f4f6;
    }
    
    .user-row:hover {
        background-color: rgba(102, 126, 234, 0.02);
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 1px;
    }
    
    /* Avatar Upload */
    .avatar-upload-area {
        transition: all 0.3s ease;
    }
    
    .avatar-upload-area:hover {
        border-color: var(--primary-color);
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .avatar-preview {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
    }
    
    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Role Badges */
    .badge.badge-primary {
        background-color: var(--primary-color);
    }
    
    .badge.badge-info {
        background-color: var(--info-color);
    }
    
    .badge.badge-secondary {
        background-color: #6c757d;
    }
    
    .badge.badge-success {
        background-color: var(--success-color);
    }
    
    .badge.badge-warning {
        background-color: var(--warning-color);
        color: #000;
    }
    
    /* Form Styles */
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .form-switch .form-check-input:checked {
        background-color: var(--success-color);
        border-color: var(--success-color);
    }
    
    /* Animation */
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Search and Filter Functions
    document.getElementById('searchInput').addEventListener('input', filterUsers);
    document.getElementById('roleFilter').addEventListener('change', filterUsers);
    document.getElementById('statusFilter').addEventListener('change', filterUsers);
    document.getElementById('sortBy').addEventListener('change', sortUsers);

    function filterUsers() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const roleFilter = document.getElementById('roleFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('.user-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const role = row.dataset.role;
            const status = row.dataset.status;
            
            const matchesSearch = !searchTerm || name.includes(searchTerm) || email.includes(searchTerm);
            const matchesRole = !roleFilter || role === roleFilter;
            const matchesStatus = !statusFilter || status === statusFilter;

            if (matchesSearch && matchesRole && matchesStatus) {
                row.style.display = 'table-row';
                row.classList.add('fade-in-up');
                visibleCount++;
            } else {
                row.style.display = 'none';
                row.classList.remove('fade-in-up');
            }
        });

        document.getElementById('visibleCount').textContent = visibleCount;
        document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
    }

    function sortUsers() {
        const sortBy = document.getElementById('sortBy').value;
        const tbody = document.getElementById('userTableBody');
        const rows = Array.from(tbody.querySelectorAll('.user-row'));

        rows.sort((a, b) => {
            switch (sortBy) {
                case 'newest':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'oldest':
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'email':
                    return a.dataset.email.localeCompare(b.dataset.email);
                default:
                    return 0;
            }
        });

        rows.forEach(row => tbody.appendChild(row));
    }

    // Selection Functions
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelectionCount();
    });

    document.getElementById('headerCheckbox').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelectionCount();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('user-checkbox')) {
            updateSelectionCount();
            
            // Update select all checkbox
            const allCheckboxes = document.querySelectorAll('.user-checkbox');
            const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
            document.getElementById('selectAll').checked = allCheckboxes.length === checkedCheckboxes.length;
            document.getElementById('headerCheckbox').checked = allCheckboxes.length === checkedCheckboxes.length;
        }
    });

    function updateSelectionCount() {
        const selected = document.querySelectorAll('.user-checkbox:checked').length;
        // Update UI to show selection count if needed
    }

    // User Management Functions
    function openAddUserModal() {
        const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
        modal.show();
    }

    function viewUser(id) {
        // Load user details via AJAX
        fetch(`/admin/users/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('userDetailContent').innerHTML = `
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                ${data.avatar 
                                    ? `<img src="/avatars/${data.avatar}" class="rounded-circle" width="120" height="120">`
                                    : `<div class="avatar-placeholder mx-auto" style="width:120px;height:120px;font-size:2rem;">${data.name.substring(0,2).toUpperCase()}</div>`
                                }
                            </div>
                            <h4>${data.name}</h4>
                            <span class="badge badge-${data.role === 'admin' ? 'primary' : (data.role === 'editor' ? 'info' : 'secondary')}">${data.role.toUpperCase()}</span>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Email:</strong><br>
                                    <span class="text-muted">${data.email}</span>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Phone:</strong><br>
                                    <span class="text-muted">${data.phone || 'Not provided'}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Status:</strong><br>
                                    <span class="badge badge-${data.status ? 'success' : 'warning'}">${data.status ? 'Active' : 'Inactive'}</span>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Joined:</strong><br>
                                    <span class="text-muted">${new Date(data.created_at).toLocaleDateString()}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Last Login:</strong><br>
                                    <span class="text-muted">${data.last_login_at ? new Date(data.last_login_at).toLocaleString() : 'Never'}</span>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Login Count:</strong><br>
                                    <span class="text-muted">${data.login_count || 0} times</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('userDetailModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error loading user details:', error);
                showToast('Gagal memuat detail user', 'error');
            });
    }

    function editUser(id) {
        // Redirect to edit page or open edit modal
        window.location.href = `/admin/users/${id}/edit`;
    }

    function toggleUserStatus(id, newStatus) {
        const form = document.getElementById('statusForm' + id);
        form.querySelector('input[name="status"]').value = newStatus;
        
        if (confirm(`Apakah Anda yakin ingin ${newStatus ? 'mengaktifkan' : 'menonaktifkan'} user ini?`)) {
            showLoading();
            form.submit();
        }
    }

    function resetPassword(id) {
        if (confirm('Apakah Anda yakin ingin reset password user ini?\n\nPassword baru akan dikirim melalui email.')) {
            showLoading();
            
            fetch(`/admin/users/${id}/reset-password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    showToast('Password berhasil direset dan dikirim ke email user', 'success');
                } else {
                    showToast('Gagal reset password', 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat reset password', 'error');
            });
        }
    }

    function deleteUser(id, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus user "${name}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            showLoading();
            document.getElementById('deleteForm' + id).submit();
        }
    }

    // Bulk Actions
    function bulkActivate() {
        const selected = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            showToast('Pilih user yang ingin diaktifkan', 'warning');
            return;
        }
        
        if (confirm(`Aktifkan ${selected.length} user yang dipilih?`)) {
            bulkAction('activate', selected);
        }
    }

    function bulkDeactivate() {
        const selected = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            showToast('Pilih user yang ingin dinonaktifkan', 'warning');
            return;
        }
        
        if (confirm(`Nonaktifkan ${selected.length} user yang dipilih?`)) {
            bulkAction('deactivate', selected);
        }
    }

    function bulkDelete() {
        const selected = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            showToast('Pilih user yang ingin dihapus', 'warning');
            return;
        }
        
        if (confirm(`Hapus ${selected.length} user yang dipilih?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            bulkAction('delete', selected);
        }
    }

    function bulkAction(action, userIds) {
        showLoading();
        
        fetch(`/admin/users/bulk-${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: userIds })
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast(`Berhasil ${action} ${data.count} user`, 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast(`Gagal ${action} user`, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showToast(`Terjadi kesalahan saat ${action} user`, 'error');
        });
    }

    function exportUsers() {
        window.open('/admin/users/export', '_blank');
    }

    // Form Functions
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling;
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }

    // Avatar Upload Preview
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').innerHTML = 
                    `<img src="${e.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Form Validation
    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        const password = document.getElementById('addPassword').value;
        const confirmPassword = document.getElementById('addPasswordConfirm').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            showToast('Password dan konfirmasi password tidak cocok', 'error');
            return;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            showToast('Password minimal 8 karakter', 'error');
            return;
        }
        
        showLoading();
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            tooltipTriggerEl.setAttribute('data-bs-toggle', 'tooltip');
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey) {
                switch (e.key) {
                    case 'f':
                        e.preventDefault();
                        document.getElementById('searchInput').focus();
                        break;
                    case 'n':
                        e.preventDefault();
                        openAddUserModal();
                        break;
                    case 'a':
                        e.preventDefault();
                        document.getElementById('selectAll').click();
                        break;
                }
            }
        });
    });
</script>
@endpush
