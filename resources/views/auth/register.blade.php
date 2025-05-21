<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - MyShopList</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Gunakan style login -->
    <link rel="stylesheet" href="{{ asset('Frontsite/style/auth.css') }}">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center login-wrapper">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

                <!-- Judul & Deskripsi -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success d-flex justify-content-center align-items-center gap-2">
                        <i class="bi bi-cart3"></i> MyShopList
                    </h2>
                    <p class="text-muted mb-0">Buat akun untuk mulai mengelola daftar belanja!</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" required>
                    </div>

                    <!-- Tombol Daftar -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">📝 Daftar</button>
                    </div>

                    <!-- Link login -->
                    <div class="mt-3 text-center">
                        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>