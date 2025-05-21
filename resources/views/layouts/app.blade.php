<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Shopping List')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('Frontsite/style/style.css') }}">

    {{-- Inject variabel JS dari halaman --}}
    @yield('head')
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm custom-navbar">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Logo Kiri -->
            <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-3" href="{{ route('items.index') }}"
                style="font-size: 1.4rem;">
                <i class="fas fa-shopping-cart"></i>
                <span>Shopping List</span>
            </a>

            <!-- User Dropdown Kanan -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white fw-semibold" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-semibold" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2 fw-semibold"
                                href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item" id="logout-btn">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div id="successCard" class="alert alert-success animate__animated animate__fadeInDown d-none"></div>
        @yield('content')
    </div>

    <!-- SweetAlert Custom -->
    <script src="{{ asset('Frontsite/js/sweetalert.js') }}"></script>
    @stack('scripts')
</body>

</html>
