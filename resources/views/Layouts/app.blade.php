<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Ngalalana" />
    <meta name="author" content="Ziruuu" />
    <title>@yield('title', 'Ngalalana')</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Ngalalana_icon2.png') }}" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            {{-- Icon - Icon --}}
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <img src="{{ asset('assets/Ngalalana_icon2.png') }}" alt="Cultural Map Logo">
            </a>
            <a class="navbar-brand2" href="{{ url('/dashboard') }}">
                <img src="{{ asset('assets/Ngalalana_icon3.png') }}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <a href="{{ url('/dashboard') }}"></a>
            {{-- Tombol - Tombol navigasi --}}
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <a class="nav-link" href="{{ url('/dashboard') }}">Beranda</a>
                    <a class="nav-link" href="{{ url('/map') }}">Cultural Map</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">Menu Lainnya</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/find') }}">Cari...</a></li>
                            <li><a class="dropdown-item" href="{{ route('cultural.index') }}">Daftar Kebudayaan Di Garut</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('/aboutus') }}">Tentang Kami</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page content -->
    <main class="flex-fill">
        <div class="container mt-5">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-1 fw-bold">Cultural Maps Garut by Ngalalana</p>
            <p class="mb-2 small">Menjelajahi kekayaan budaya Garut dan melestarikannya untuk generasi mendatang.</p>
            <small class="text-muted">© 2025 Cultural Maps Garut by Ngalalana. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    @stack('scripts')
</body>
</html>

<style>
    .navbar-brand img {
        height: 50px;
        width: auto;
    }

    footer {
        margin-top: 40px;
    }
</style>
