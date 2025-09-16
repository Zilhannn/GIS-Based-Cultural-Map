@extends('layouts.app')

@section('title', 'Ngalalana Dashboard')

@section('content')
    <!-- Hero Section dengan background -->
    <section class="hero-section d-flex align-items-center justify-content-center text-center text-light"
             style="background: url('{{ asset('image/babancong.jpg') }}') no-repeat center center/cover; height: 100vh; position: relative;">
        
        <div class="overlay"></div>
        <div class="content position-relative">
            <h1 class="display-4 fw-bold animate__animated animate__fadeInDown">
                Eksplorasi Budaya Garut
            </h1>
            <p class="lead animate__animated animate__fadeInUp">
                Temukan keindahan dan kekayaan budaya Garut langsung dalam Cultural Map interaktif.
            </p>
            <a href="{{ url('/map') }}" class="btn btn-warning btn-lg shadow-lg mt-3 animate__animated animate__pulse animate__infinite">
                Jelajahi Cultural Map
            </a>
        </div>
    </section>

    <!-- Informasi tambahan -->
<!-- Informasi tambahan -->
<section class="py-5 position-relative" 
         style="background: url('{{ asset('images/babancong.jpg') }}') no-repeat center center/cover;">

    <!-- Overlay gelap biar teks lebih terbaca -->
    <div class="overlay position-absolute top-0 start-0 w-100 h-100" 
         style="background: rgba(0,0,0,0.6);"></div>

    <div class="container position-relative text-light">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-warning">Budaya Khas Garut</h2>
            <p class="text-light">Beberapa kekayaan budaya Garut yang patut kamu ketahui</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow h-100 bg-dark bg-opacity-75 border-0">
                    <img src="{{ asset('assets/dodolan.jpeg') }}" class="card-img-top img-fluid" style="height:220px; object-fit:cover;" alt="Dodolan Dodol Garut">
                    <div class="card-body text-light">
                        <h5 class="card-title">Dodol Garut</h5>
                        <p class="card-text">Oleh-oleh khas Garut yang sudah melegenda sejak puluhan tahun lalu.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow h-100 bg-dark bg-opacity-75 border-0">
                    <img src="{{ asset('assets/batikgarut.jpg') }}" class="card-img-top img-fluid" style="height:220px; object-fit:cover;" alt="Batik Garut">
                    <div class="card-body text-light">
                        <h5 class="card-title">Batik Garutan</h5>
                        <p class="card-text">Motif batik khas Garut dengan corak elegan dan bernuansa alam Priangan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow h-100 bg-dark bg-opacity-75 border-0">
                    <img src="{{ asset('assets/angklungbuhun.jpg') }}" class="card-img-top img-fluid" style="height:220px; object-fit:cover;" alt="Angklung Buhun Garut">
                    <div class="card-body text-light">
                        <h5 class="card-title">Angklung Buhun</h5>
                        <p class="card-text">Seni musik tradisional Garut yang masih dilestarikan oleh masyarakat lokal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="border-light my-4">
    <p style="color: white" align="center">© 2025 Cultural Map Garut.</p>
</section>

@endsection

@push('styles')
<style>
/* Overlay pada hero */
.hero-section .overlay {
    background: rgba(0,0,0,0.5);
    position: absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
}

/* Scroll smooth */
html {
    scroll-behavior: smooth;
}

/* Sticky navbar */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1030;
    transition: background-color 0.3s ease;
}

/* Efek perubahan saat discroll */
.navbar.scrolled {
    background-color: rgba(0, 0, 0, 0.85) !important;
    transition: background-color 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
// Tambahkan efek perubahan warna navbar saat discroll
document.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});
</script>
@endpush
