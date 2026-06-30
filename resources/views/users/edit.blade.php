@extends('adminlte::page')

@section('title', 'Edit User')

@section('content')
<div class="card">
    // Menampilkan header untuk mengedit user
    <div class="card-body">
        // Form untuk mengedit user dengan validasi input
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            // Input untuk nama user
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            // Input untuk username user
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            // Input untuk password user (opsional, hanya diisi jika ingin mengubah password)
            <div class="form-group">
                <label>Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            // Input untuk konfirmasi password user (opsional, hanya diisi jika ingin mengubah password)
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            // Input untuk memilih role user (admin atau kasir)
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
                // Menampilkan pesan error jika ada kesalahan pada input role
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            // Tombol untuk menyimpan perubahan user
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    // Menambahkan validasi form untuk memastikan semua input telah diisi dengan benar sebelum disubmit
    document.addEventListener('DOMContentLoaded', function() {
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@stop