<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Ngalalana Admin" />
    <meta name="author" content="Ziruuu" />
    <title>@yield('title', 'Admin Ngalalana')</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Ngalalana_icon2.png') }}" />
    <!-- Core theme CSS (Bootstrap + custom) -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            {{-- Logo Admin --}}
            <a class="navbar-brand" href="{{ route('admin.dashboard_admin') }}">
                <img src="{{ asset('assets/Ngalalana_icon2.png') }}" alt="Admin Logo">
            </a>
            <a class="navbar-brand2" href="{{ route('admin.dashboard_admin') }}">
                <img src="{{ asset('assets/Ngalalana_icon3.png') }}" alt="Admin Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarAdminContent" aria-controls="navbarAdminContent" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Tombol navigasi admin --}}
            <div class="collapse navbar-collapse" id="navbarAdminContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard_admin') }}">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.map_admin') }}">
                            <i class="bi bi-journal-bookmark me-1"></i> Maps Kebudayaan
                        </a>
                    </li>
                    <li class="nav-item">
                        <!-- Logout button opens confirmation modal -->
                        <button type="button" class="nav-link btn btn-link text-danger" id="adminLogoutBtn" style="text-decoration:none;">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>

                        <!-- Hidden logout form -->
                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content soft-modal text-light shadow-lg border-0 rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold text-softblue"><i class="bi bi-box-arrow-right me-2 text-danger"></i> Konfirmasi Logout</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="fs-6 mb-2">Apakah Anda yakin ingin keluar dari akun administrator?</p>
                    <p class="small text-muted mb-0">Anda harus login kembali untuk mengakses panel admin.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-cancel px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmLogoutBtn" class="btn btn-softblue px-4 fw-semibold">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <main class="flex-fill" style="margin-top: 80px;">
        <div class="container mt-5">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-disparbud py-4 mt-5 animate__animated" id="footer">
        <div class="container text-center">
            <p class="mb-1 fw-bold">Admin Panel Cultural Maps Garut</p>
            <p class="mb-2 small">Kelola konten kebudayaan Garut dengan mudah dan efisien.</p>
            <small>© 2025 Cultural Maps Garut by Ngalalana. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
                        observer.unobserve(footer);
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
                    navbar.style.top = `-${navbarHeight}px`;
                } else {
                    navbar.style.top = "0";
                }
                lastScrollTop = scrollTop;
            });
        });
    </script>
    <script>
        // Prevent admin users from navigating back to cached public pages.
        // This pushes a history state and forces the browser to stay on the admin page
        // when the user hits the back button.
        (function () {
            try {
                history.pushState(null, '', location.href);
                window.addEventListener('popstate', function () {
                    history.pushState(null, '', location.href);
                });
            } catch (e) {
                // Some browsers or older engines may throw; ignore silently.
                console.debug('back-button protection unavailable', e);
            }
        })();
    </script>
    <script>
        // Logout modal handling
        document.addEventListener('DOMContentLoaded', function () {
            const logoutBtn = document.getElementById('adminLogoutBtn');
            const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
            const logoutModalEl = document.getElementById('confirmLogoutModal');
            if (logoutBtn && logoutModalEl) {
                logoutBtn.addEventListener('click', () => {
                    new bootstrap.Modal(logoutModalEl).show();
                });
            }
            if (confirmLogoutBtn) {
                confirmLogoutBtn.addEventListener('click', () => {
                    document.getElementById('admin-logout-form').submit();
                });
            }
        });
    </script>
</body>
</html>

<style>
    .navbar-brand img {
        height: 50px;
        width: auto;
    }

    /* Navbar Admin */
    .navbar {
        transition: top 0.4s ease;
        background-color: #2f3a4a !important;
    }

    .navbar-dark .nav-link {
        color: #fff !important;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .navbar-dark .nav-link:hover,
    .navbar-dark .nav-link:focus,
    .navbar-dark .nav-link:active {
        color: #42a5f5 !important;
        text-shadow: 0 0 8px rgba(66, 165, 245, 0.6);
        transform: scale(1.05);
    }

    /* Footer Admin */
    .footer-disparbud {
        background-color: #2f3a4a;
        color: #fff;
        opacity: 0;
    }

    .footer-disparbud.animate__fadeInUp {
        opacity: 1 !important;
    }

    .footer-disparbud a {
        color: #b0bec5;
        text-decoration: none;
    }

    .footer-disparbud a:hover {
        color: #42a5f5;
        text-shadow: 0 0 8px rgba(66, 165, 245, 0.6);
    }

    .footer-disparbud small {
        display: block;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid rgba(255,255,255,0.1);
        color: #b0bec5;
    }

    /* Dropdown custom admin */
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
    
    /* Modal "soft" appearance + entrance animation (shared across admin views) */
    .soft-modal {
        background: rgba(20, 20, 20, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(66, 165, 245, 0.3);
        animation: modalFade 0.35s ease-out;
    }

    @keyframes modalFade {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Utility fade-in used by card-like elements */
    .animate-fadeIn {
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
