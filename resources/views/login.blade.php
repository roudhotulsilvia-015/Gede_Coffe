<!DOCTYPE html>
<html>
<head>
    <title>Login GedeCoffee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form action="/login" method="POST" class="card p-4 shadow" style="width: 350px;">
            @csrf
            <h3 class="text-center">GedeCoffee</h3>
            @error('username') <div class="alert alert-danger">{{ $message }}</div> @enderror
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
    </div>
</body>
</html>