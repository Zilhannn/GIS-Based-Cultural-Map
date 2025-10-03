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
            <a href="{{ url('/map') }}" class="btn btn-softblue btn-lg shadow-lg mt-3 btn-animated">
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
                            <img src="{{ asset('assets/'.$cultural->image) }}" 
                                 class="card-img-top img-fluid" 
                                 style="height:220px; object-fit:cover;" 
                                 alt="{{ $cultural->name }}">
                            <div class="card-body">
                               <h5 class="card-title">
                                    <a href="{{ route('cultural.show', $cultural->id) }}" 
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
        </div>
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
    background-color: rgba(66, 165, 245, 0.95) !important; /* soft blue transparan */
    transition: background-color 0.3s ease;
}

/* Warna soft blue custom */
.text-softblue {
    color: #42a5f5 !important;
}

.btn-softblue {
    background-color: #42a5f5;
    border: none;
    color: #fff;
    transition: all 0.3s ease;
}
.btn-softblue:hover {
    background-color: #1e88e5;
    color: #fff;
}

/* Tombol animasi custom */
.btn-animated {
    animation: pulse-bounce 2s infinite;
}
@keyframes pulse-bounce {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(66,165,245, 0.7);
    }
    50% {
        transform: scale(1.08);
        box-shadow: 0 0 25px rgba(66,165,245, 0.8);
    }
}

/* Link judul card */
.link-blue {
    color: #42a5f5; /* soft blue */
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
}
.link-blue:hover {
    color: #90caf9; /* biru lebih terang saat hover */
}

/* Deskripsi card */
.card-text {
    color: rgba(255,255,255,0.85); /* putih transparan agar jelas */
    font-size: 0.95rem;
    line-height: 1.4;
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
