<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - MyShopList</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Style utama -->
    <link rel="stylesheet" href="{{ asset('Frontsite/style/auth.css') }}">

   <!-- Load SweetAlert2 dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('error'))
        <script>
            window.LOGIN_ERROR_MESSAGE = @json(session('error'));
        </script>
    @endif

    @if(session('success'))
        <script>
            window.LOGIN_SUCCESS_MESSAGE = @json(session('success'));
        </script>
    @endif

    <!-- Custom SweetAlert logic -->
    <script src="{{ asset('Frontsite/js/sweetalert.js') }}"></script>
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
                    <p class="text-muted mb-0">Masuk untuk mengelola daftar belanja kamu!</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus>
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

                    <!-- Remember me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    <!-- Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">🔐 Masuk</button>
                    </div>

                    <!-- Register link -->
                    <div class="mt-3 text-center">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>