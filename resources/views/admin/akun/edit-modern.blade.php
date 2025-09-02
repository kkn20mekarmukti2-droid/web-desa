@extends('layouts.admin-modern')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="text-dark mb-0">Edit User</h6>
                            <p class="text-sm mb-0">Update informasi pengguna</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('akun.manage') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body px-4 pb-4">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label text-dark font-weight-bold">
                                        <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name', $user->name) }}" 
                                        placeholder="Masukkan nama lengkap"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label text-dark font-weight-bold">
                                        <i class="fas fa-envelope me-2 text-info"></i>Email
                                    </label>
                                    <input 
                                        type="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}" 
                                        placeholder="Masukkan email"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="role" class="form-label text-dark font-weight-bold">
                                        <i class="fas fa-user-tag me-2 text-warning"></i>Role
                                    </label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="SuperAdmin" {{ old('role', $user->role) == 'SuperAdmin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Writer" {{ old('role', $user->role) == 'Writer' ? 'selected' : '' }}>Writer</option>
                                        <option value="Editor" {{ old('role', $user->role) == 'Editor' ? 'selected' : '' }}>Editor</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-dark font-weight-bold">
                                        <i class="fas fa-info-circle me-2 text-secondary"></i>Status
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-sm bg-gradient-success me-2">Aktif</span>
                                        <small class="text-muted">User terdaftar sejak {{ $user->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-light border border-light rounded-3 mb-3">
                                    <h6 class="text-dark mb-2">
                                        <i class="fas fa-key me-2 text-danger"></i>Update Password (Opsional)
                                    </h6>
                                    <p class="text-sm text-muted mb-3">Kosongkan jika tidak ingin mengubah password</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password" class="form-label text-dark">Password Baru</label>
                                                <input 
                                                    type="password" 
                                                    class="form-control @error('password') is-invalid @enderror" 
                                                    id="password" 
                                                    name="password" 
                                                    placeholder="Masukkan password baru (min. 6 karakter)"
                                                >
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password_confirmation" class="form-label text-dark">Konfirmasi Password</label>
                                                <input 
                                                    type="password" 
                                                    class="form-control" 
                                                    id="password_confirmation" 
                                                    name="password_confirmation" 
                                                    placeholder="Ulangi password baru"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('akun.manage') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: none;
}

.form-control {
    border-radius: 0.5rem;
    border: 1px solid #d1d5db;
    transition: all 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
}

.alert {
    background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection
