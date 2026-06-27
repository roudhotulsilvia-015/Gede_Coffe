<!DOCTYPE html>
<html>
<head>
    <title>Login GedeCoffee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form action="{{ route('login') }}" method="POST" class="card p-4 shadow" style="width: 350px;">
            @csrf
            <h3 class="text-center">GedeCoffee</h3>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @error('username') <div class="alert alert-danger">{{ $message }}</div> @enderror
            @error('password') <div class="alert alert-danger">{{ $message }}</div> @enderror
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
            <div class="text-center mt-3">
                <small>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></small>
            </div>
        </form>
    </div>
</body>
</html>