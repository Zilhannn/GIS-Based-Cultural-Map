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
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
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
                        <ul class="dropdown-menu dropdown-menu-end animate__animated" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/find') }}">Cari di Map...</a></li>
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
    <main class="flex-fill" style="margin-top: 80px;">
        <div class="container mt-5">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-disparbud py-4 mt-5 animate__animated" id="footer">
        <div class="container text-center">
            <p class="mb-1 fw-bold">Cultural Maps Garut by Ngalalana</p>
            <p class="mb-2 small">Menjelajahi kekayaan budaya Garut dan melestarikannya untuk generasi mendatang.</p>
            <small>© 2025 Cultural Maps Garut by Ngalalana. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    @stack('scripts')

    <!-- Animasi Footer, Dropdown & Navbar -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const footer = document.getElementById("footer");
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        footer.classList.add("animate__fadeInUp");
                        observer.unobserve(footer); // hanya animasi sekali
                    }
                });
            }, { threshold: 0.3 });
            observer.observe(footer);

            // Animasi dropdown
            const dropdowns = document.querySelectorAll('.dropdown-menu');
            dropdowns.forEach(menu => {
                menu.addEventListener('show.bs.dropdown', function () {
                    menu.classList.remove('animate__fadeOut');
                    menu.classList.add('animate__fadeInDown');
                });
                menu.addEventListener('hide.bs.dropdown', function () {
                    menu.classList.remove('animate__fadeInDown');
                    menu.classList.add('animate__fadeOut');
                });
            });

            // Navbar hide/show saat scroll
            const navbar = document.querySelector('.navbar');
            let lastScrollTop = 0;
            const delta = 5;
            const navbarHeight = navbar.offsetHeight;

            window.addEventListener("scroll", function () {
                let scrollTop = window.scrollY;

                if (Math.abs(lastScrollTop - scrollTop) <= delta) return;

                if (scrollTop > lastScrollTop && scrollTop > navbarHeight) {
                    // Scroll ke bawah → sembunyikan
                    navbar.style.top = `-${navbarHeight}px`;
                } else {
                    // Scroll ke atas → tampilkan
                    navbar.style.top = "0";
                }

                lastScrollTop = scrollTop;
            });
        });
    </script>
</body>
</html>

<style>
    .navbar-brand img {
        height: 50px;
        width: auto;
    }

    /* ============================= */
    /* OVERRIDE NAVBAR */
    /* ============================= */

    .navbar {
        transition: top 0.4s ease; /* supaya smooth saat hilang/muncul */
    }

    /* Default navbar */
    .navbar.navbar-dark {
        background-color: #2f3a4a !important;  /* abu gelap */
        transition: all 0.3s ease;
    }

    /* Saat discroll */
    .navbar.navbar-dark.navbar-scrolled {
        background-color: rgba(47, 58, 74, 0.95) !important;
        box-shadow: 0px 2px 10px rgba(0,0,0,0.3) !important;
    }

    /* Link navbar */
    .navbar-dark .nav-link {
        color: #fff !important;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .navbar-dark .nav-link:hover,
    .navbar-dark .nav-link:focus,
    .navbar-dark .nav-link:active {
        color: #42a5f5 !important; /* biru soft */
        text-shadow: 0px 0px 8px rgba(66, 165, 245, 0.6) !important;
        transform: scale(1.05);
    }

    /* Footer dengan palet Disparbud */
    .footer-disparbud {
        background-color: #2f3a4a; /* biru abu gelap */
        color: #fff;
        opacity: 0;
    }

    .footer-disparbud.animate__fadeInUp {
        opacity: 1 !important;
    }

    .footer-disparbud a {
        color: #b0bec5; /* abu terang */
        text-decoration: none;
    }

    .footer-disparbud a:hover {
        color: #42a5f5; /* soft blue */
        text-shadow: 0px 0px 8px rgba(66, 165, 245, 0.6);
    }

    .footer-disparbud small {
        display: block;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid rgba(255,255,255,0.1);
        color: #b0bec5;
    }

    /* Dropdown custom */
    .dropdown-menu {
        background: linear-gradient(135deg, #42a5f5, #1e88e5);
        border: none;
        border-radius: 10px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.25);
        padding: 8px 0;
    }

    .dropdown-menu .dropdown-item {
        color: #fff;
        transition: all 0.3s ease;
        border-radius: 6px;
        margin: 2px 8px;
        padding: 8px 12px;
    }

    .dropdown-menu .dropdown-item:hover {
        background: rgba(255,255,255,0.2);
        color: #fff;
        padding-left: 20px;
        transform: scale(1.05);
    }

    .dropdown-divider {
        border-color: rgba(255,255,255,0.3);
        margin: 6px 0;
    }

    /* Efek highlight pada semua link dan tombol */
    a.nav-link, 
    .dropdown-item, 
    .btn, 
    a {
        position: relative;
        transition: all 0.3s ease;
    }

    a.nav-link:hover,
    .dropdown-item:hover,
    .btn:hover,
    a:hover {
        color: #fff !important;
        text-shadow: 0px 0px 8px rgba(66, 165, 245, 0.8);
        transform: scale(1.05);
    }
</style>
