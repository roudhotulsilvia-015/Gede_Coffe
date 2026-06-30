<!DOCTYPE html>
<html>
<head>
    <title>Register GedeCoffee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    // Menampilkan halaman register dengan form untuk nama, username, password, dan konfirmasi password
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form action="{{ route('register') }}" method="POST" class="card p-4 shadow" style="width: 350px;">
            @csrf
            // Menampilkan judul halaman register
            <h3 class="text-center">Daftar GedeCoffee</h3>
            @if(session('success'))// Menampilkan pesan sukses jika registrasi berhasil
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            // Menampilkan pesan error jika registrasi gagal
            @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
            @error('username') <div class="alert alert-danger">{{ $message }}</div> @enderror
            @error('password') <div class="alert alert-danger">{{ $message }}</div> @enderror
            <div class="mb-3">
                // Input untuk nama lengkap
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
            </div>
            // Input untuk username
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>
            </div>
            // Input untuk password
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            // Input untuk konfirmasi password
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
            </div>
            // Tombol untuk submit form register
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <div class="text-center mt-3">
                // Menampilkan link untuk login jika sudah memiliki akun
                <small>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
            </div>
        </form>
    </div>
</body>
</html>
