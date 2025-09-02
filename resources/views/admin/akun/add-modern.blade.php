@extends('layout.admin-modern')
@section('title', 'Tambah User')
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">➕ Tambah User Baru</h1>
            <p class="page-subtitle">Buat akun pengguna baru untuk sistem</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('akun.manage') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('akun.new') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Nama -->
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" 
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" 
                               placeholder="Masukkan alamat email"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Masukkan password"
                                   required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   class="form-control" 
                                   placeholder="Ulangi password"
                                   required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Role -->
                    <div class="form-group mb-3">
                        <label for="role" class="form-label">Role Pengguna <span class="text-danger">*</span></label>
                        <select name="role" 
                                id="role" 
                                class="form-select @error('role') is-invalid @enderror"
                                required>
                            <option value="">Pilih Role</option>
                            @php
                                $availableRoles = [];
                                if (Auth::user()->role === 'SuperAdmin') {
                                    $availableRoles = [
                                        'SuperAdmin' => 'Super Administrator',
                                        'Admin' => 'Administrator', 
                                        'Writer' => 'Penulis Konten',
                                        'Editor' => 'Editor Konten'
                                    ];
                                } elseif (Auth::user()->role === 'Admin') {
                                    $availableRoles = [
                                        'Admin' => 'Administrator',
                                        'Writer' => 'Penulis Konten', 
                                        'Editor' => 'Editor Konten'
                                    ];
                                }
                            @endphp
                            
                            @foreach($availableRoles as $roleValue => $roleDisplay)
                                <option value="{{ $roleValue }}" {{ old('role') == $roleValue ? 'selected' : '' }}>
                                    {{ $roleDisplay }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role Description -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Keterangan Role:</h6>
                        <ul class="mb-0 small">
                            <li><strong>SuperAdmin:</strong> Akses penuh sistem</li>
                            <li><strong>Admin:</strong> Manajemen konten & data</li>
                            <li><strong>Writer:</strong> Menulis artikel & berita</li>
                            <li><strong>Editor:</strong> Edit & review konten</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('akun.manage') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Buat User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Styles -->
<style>
.form-label {
    font-weight: 600;
    color: var(--dark-color);
}

.alert ul {
    padding-left: 1.2rem;
}

.input-group .btn {
    border-left: 0;
}

.password-strength {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.strength-weak { color: #dc3545; }
.strength-medium { color: #ffc107; }
.strength-strong { color: #198754; }
</style>

<!-- JavaScript -->
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = checkPasswordStrength(password);
    
    // Remove existing strength indicator
    const existing = document.querySelector('.password-strength');
    if (existing) existing.remove();
    
    if (password.length > 0) {
        const indicator = document.createElement('div');
        indicator.className = `password-strength ${strength.class}`;
        indicator.textContent = `Kekuatan Password: ${strength.text}`;
        this.parentNode.insertAdjacentElement('afterend', indicator);
    }
});

function checkPasswordStrength(password) {
    let score = 0;
    
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    
    if (score < 2) return { class: 'strength-weak', text: 'Lemah' };
    if (score < 4) return { class: 'strength-medium', text: 'Sedang' };
    return { class: 'strength-strong', text: 'Kuat' };
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    
    if (password !== confirmation) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Password Tidak Cocok',
            text: 'Password dan konfirmasi password harus sama',
            confirmButtonText: 'OK'
        });
        return false;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Password Terlalu Pendek',
            text: 'Password minimal 6 karakter',
            confirmButtonText: 'OK'
        });
        return false;
    }
});

// Role description update
document.getElementById('role').addEventListener('change', function() {
    const role = this.value;
    // Could add dynamic role description updates here
});
</script>

@endsection
