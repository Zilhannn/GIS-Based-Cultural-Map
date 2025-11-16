@extends('layouts.app')

@section('title', 'Ngalalana - Dashboard')

@section('content')
    <!-- Hero Section dengan background -->
    <section class="hero-section d-flex align-items-center justify-content-center text-center text-light"
             style="background: url('{{ asset('image/babancong.jpg') }}') no-repeat center center/cover; height: 100vh; position: relative;">
        
        <div class="overlay"></div>
        <div class="content position-relative">
            <h1 class="display-4 fw-bold animate__animated animate__fadeInDown text-softblue">
                Eksplorasi Budaya Garut
            </h1>
            <p class="lead animate__animated animate__fadeInUp text-light">
                Temukan keindahan dan kekayaan budaya Garut langsung dalam Cultural Map interaktif.
            </p>
            <!-- Tambahkan animasi custom untuk tombol -->
            <a href="{{ route('map') }}" class="btn btn-softblue btn-lg shadow-lg mt-3 btn-animated">
                Jelajahi Cultural Map
            </a>
        </div>
    </section>

    <!-- Informasi tambahan -->
    <section class="py-5 position-relative" 
             style="background: url('{{ asset('images/babancong.jpg') }}') no-repeat center center/cover;">

        <!-- Overlay gelap biar teks lebih terbaca -->
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" 
             style="background: rgba(0,0,0,0.6);"></div>

        <div class="container position-relative text-light">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-softblue">Budaya Khas Garut</h2>
                <p class="text-light">Beberapa kekayaan budaya Garut yang patut kamu ketahui</p>
            </div>
            
            <div class="row g-4">
                @foreach($culturals as $cultural)
                    <div class="col-md-4">
                        <div class="card shadow h-100 bg-dark bg-opacity-75 border-0">
                            <img src="{{ asset('storage/'.$cultural->image) }}" 
                                 class="card-img-top img-fluid" 
                                 style="height:220px; object-fit:cover;" 
                                 alt="{{ $cultural->name }}">
                            <div class="card-body">
                                         <h5 class="card-title">
                                                <a href="{{ route('cultural.show', $cultural->slug) }}" 
                                                    class="link-blue">
                                                    {{ $cultural->name }}
                                                </a>
                                          </h5>
                                <p class="card-text">
                                    {{ Str::limit($cultural->description, 120) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('cultural.index') }}" class="btn btn-softblue btn-lg shadow-lg btn-animated">
                    Jelajahi Kebudayaan Lainnya =>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
/* Dashboard-specific styles */
.hero-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
}

.hero-section .overlay {
    background: rgba(0,0,0,0.6);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.hero-section .content {
    z-index: 2;
}

/* Custom animations for hero content */
.hero-section .display-4 {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    animation-delay: 0.2s;
}

.hero-section .lead {
    animation-delay: 0.4s;
}

.hero-section .btn-animated {
    animation-delay: 0.6s;
}

/* Featured cards section */
.featured-section {
    background: rgba(var(--darkgray-rgb), 0.97);
    padding: 4rem 0;
}

.featured-card {
    border: 1px solid rgba(var(--softblue-rgb), 0.1);
    background: rgba(0,0,0,0.3);
}

.featured-card img {
    transition: transform 0.5s ease;
}

.featured-card:hover img {
    transform: scale(1.05);
}

/* Custom section spacing */
section {
    position: relative;
    overflow: hidden;
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 80vh;
    }
    
    .hero-section .display-4 {
        font-size: 2.5rem;
    }
    
    .featured-section {
        padding: 2rem 0;
    }
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
