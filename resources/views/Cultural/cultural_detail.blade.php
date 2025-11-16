@extends('layouts.app')

@section('title', $cultural->name)

@section('content')

<!-- Hero Header with Featured Image -->
<div class="cultural-hero animate__animated animate__fadeIn" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('{{ $cultural->image ? asset('storage/'.$cultural->image) : asset('image/babancong.jpg') }}') center/cover no-repeat; min-height: 350px; display: flex; align-items: flex-end; position: relative;">
    <div class="container w-100 pb-5">
        <h1 class="text-white fw-bold mb-2 animate__animated animate__fadeInUp" style="font-size: 2.5rem; text-shadow: 0 2px 8px rgba(0,0,0,0.7);">{{ $cultural->name }}</h1>
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <span class="badge bg-softblue text-dark fw-bold px-3 py-2">
                <i class="bi bi-tag me-2"></i>{{ $cultural->category }}
            </span>
            <span class="badge bg-secondary text-white px-3 py-2">
                <i class="bi bi-geo-alt me-2"></i>{{ $cultural->location }}
            </span>
        </div>
    </div>
</div>

<!-- Quick Actions Bar -->
<div class="bg-dark sticky-actions-bar">
    <div class="container py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="{{ route('cultural.index') }}" class="btn btn-sm btn-outline-light">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        @if($cultural->has_map)
            <a href="{{ url('/map') }}?cultural_id={{ $cultural->id }}" class="btn btn-sm btn-map-action fw-bold">
                <i class="bi bi-map-fill me-1"></i> Lihat di Map
            </a>
        @endif
    </div>
</div>

<div class="container mt-5 mb-5">

    <div class="row g-4">
        <!-- Gallery Section -->
        <div class="col-12">
            <div class="card shadow-lg border-0 bg-dark bg-opacity-75 animate__animated animate__fadeInUp">
                <div class="card-body p-0">
                    <!-- Main Carousel -->
                    <div id="culturalCarousel" class="carousel slide rounded-top" data-bs-ride="carousel">
                        <div class="carousel-inner rounded-top">
                            @php
                                $images = [];
                                if ($cultural->image) {
                                    $images[] = $cultural->image;
                                }
                                foreach ($cultural->galleries as $gallery) {
                                    $images[] = $gallery->image_path;
                                }
                            @endphp

                            @foreach($images as $index => $img)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <a href="{{ asset('storage/'.$img) }}" data-lightbox="cultural-gallery" data-title="{{ $cultural->name }}" class="d-block">
                                        <img src="{{ asset('storage/'.$img) }}" 
                                             class="d-block w-100" 
                                             alt="{{ $cultural->name }}" 
                                             style="height: 500px; object-fit: cover;">
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Controls -->
                        @if(count($images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#culturalCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#culturalCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    @if(count($images) > 1)
                        <div class="p-3 border-top border-secondary">
                            <div class="d-flex gap-2 overflow-auto">
                                @foreach($images as $index => $img)
                                    <img src="{{ asset('storage/'.$img) }}" 
                                         data-bs-target="#culturalCarousel" 
                                         data-bs-slide-to="{{ $index }}" 
                                         class="gallery-thumbnail {{ $index == 0 ? 'active' : '' }}" 
                                         alt="Thumbnail {{ $index + 1 }}"
                                         style="width: 100px; height: 75px; object-fit: cover; cursor: pointer; border-radius: 8px; opacity: 0.7; border: 2px solid transparent; transition: all 0.3s ease;">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Cards -->
        <div class="col-lg-8">
            <!-- Description Card -->
            @if($cultural->description)
                <div class="card shadow-sm border-0 bg-dark bg-opacity-75 mb-3 animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title text-softblue fw-bold mb-3">
                            <i class="bi bi-file-text me-2"></i>Deskripsi
                        </h5>
                        <p class="text-light opacity-85 lh-lg">{{ $cultural->description }}</p>
                    </div>
                </div>
            @endif

            <!-- History Card -->
            @if($cultural->history)
                <div class="card shadow-sm border-0 bg-dark bg-opacity-75 mb-3 animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title text-softblue fw-bold mb-3">
                            <i class="bi bi-clock-history me-2"></i>Sejarah
                        </h5>
                        <p class="text-light opacity-85 lh-lg">{{ $cultural->history }}</p>
                    </div>
                </div>
            @endif

            <!-- Current Condition Card -->
            @if($cultural->nowaday)
                <div class="card shadow-sm border-0 bg-dark bg-opacity-75 mb-3 animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title text-softblue fw-bold mb-3">
                            <i class="bi bi-eye me-2"></i>Keadaan Saat Ini
                        </h5>
                        <p class="text-light opacity-85 lh-lg">{{ $cultural->nowaday }}</p>
                    </div>
                </div>
            @endif

            <!-- Culture & Tradition Card -->
            @if($cultural->cult_now)
                <div class="card shadow-sm border-0 bg-dark bg-opacity-75 mb-3 animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title text-softblue fw-bold mb-3">
                            <i class="bi bi-heart me-2"></i>Adat & Kebudayaan
                        </h5>
                        <p class="text-light opacity-85 lh-lg">{{ $cultural->cult_now }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card shadow-sm border-0 bg-dark bg-opacity-75 mb-3 animate__animated animate__fadeInRight sticky-info">
                <div class="card-body">
                    <h5 class="card-title text-softblue fw-bold mb-3">
                        <i class="bi bi-info-circle me-2"></i>Informasi
                    </h5>
                    <div class="info-items">
                        <div class="info-item mb-3">
                            <small class="text-muted d-block mb-1">Kategori</small>
                            <p class="text-light fw-semibold mb-0">{{ $cultural->category }}</p>
                        </div>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block mb-1">Lokasi</small>
                            <p class="text-light fw-semibold mb-0">{{ $cultural->location }}</p>
                        </div>
                        @if($cultural->has_map)
                            <div class="info-item">
                                <small class="text-muted d-block mb-1">Status Peta</small>
                                <span class="badge bg-success text-white">
                                    <i class="bi bi-geo-alt-fill me-1"></i>Tersedia di Map
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Video Card -->
            @if($cultural->video_url)
                <div class="card shadow-sm border-0 bg-dark bg-opacity-75 mb-3 animate__animated animate__fadeInRight">
                    <div class="card-body">
                        <h5 class="card-title text-softblue fw-bold mb-3">
                            <i class="bi bi-youtube me-2 text-danger"></i>Video
                        </h5>
                        <div class="ratio ratio-16x9 rounded overflow-hidden">
                            @php
                                $videoId = null;
                                $url = $cultural->video_url;
                                if (preg_match('/youtu\.be\/([^?&\/]+)/', $url, $matches)) {
                                    $videoId = $matches[1];
                                } elseif (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $url, $matches)) {
                                    $videoId = $matches[1];
                                } elseif (preg_match('/youtube\.com\/embed\/([^?&\/]+)/', $url, $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp

                            @if($videoId)
                                <iframe 
                                    src="https://www.youtube.com/embed/{{ $videoId }}?rel=0" 
                                    title="Video: {{ $cultural->name }}"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen>
                                </iframe>
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-secondary">
                                    <a href="{{ $cultural->video_url }}" target="_blank" class="btn btn-sm btn-danger">
                                        <i class="bi bi-youtube me-1"></i> Tonton
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation -->
    <div class="row mt-5 mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                @if($prev = \App\Models\Cultural::where('id', '<', $cultural->id)->orderBy('id','desc')->first())
                    <a href="{{ route('cultural.show', $prev->slug) }}" class="btn btn-outline-info fw-bold">
                        <i class="bi bi-chevron-left me-2"></i>{{ Str::limit($prev->name, 20) }}
                    </a>
                @else
                    <div></div>
                @endif

                <h6 class="text-light mb-0">
                    <i class="bi bi-arrow-left-right"></i> Navigasi
                </h6>

                @if($next = \App\Models\Cultural::where('id', '>', $cultural->id)->orderBy('id','asc')->first())
                    <a href="{{ route('cultural.show', $next->slug) }}" class="btn btn-outline-info fw-bold">
                        {{ Str::limit($next->name, 20) }}<i class="bi bi-chevron-right ms-2"></i>
                    </a>
                @else
                    <div></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

<style>
    /* Hero Section */
    .cultural-hero {
        background-size: cover;
        background-position: center;
        position: relative;
        z-index: 1;
    }

    .cultural-hero h1 {
        font-size: 2.5rem;
        letter-spacing: 0.5px;
    }

    /* Sticky Actions Bar */
    .sticky-actions-bar {
        position: relative;
        z-index: 100;
        box-shadow: 0 2px 10px rgba(66, 165, 245, 0.1);
    }

    /* Info Sidebar */
    .sticky-info {
        position: relative;
    }

    .info-item {
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-item small {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Card Styling */
    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(66, 165, 245, 0.15) !important;
    }

    .card-title {
        font-size: 1.1rem;
        border-bottom: 2px solid var(--softblue);
        padding-bottom: 10px;
        margin-bottom: 15px !important;
    }

    /* Gallery Thumbnails */
    .gallery-thumbnail {
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .gallery-thumbnail:hover {
        opacity: 1 !important;
        transform: scale(1.08);
        border-color: var(--softblue) !important;
    }

    .gallery-thumbnail.active {
        opacity: 1 !important;
        border-color: var(--softblue) !important;
        box-shadow: 0 0 12px rgba(66, 165, 245, 0.4);
    }

    /* Carousel */
    .carousel {
        background: #000;
    }

    .carousel-item img {
        display: block;
        transition: all 0.4s ease;
    }

    .carousel-item img:hover {
        filter: brightness(1.05);
    }

    /* Buttons */
    .btn-softblue {
        background: linear-gradient(135deg, var(--softblue), var(--darkblue));
        border: none;
        color: #fff !important;
        transition: all 0.3s ease;
    }

    .btn-softblue:hover {
        background: linear-gradient(135deg, #64b5f6, #2196f3);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(66, 165, 245, 0.3);
    }

    .btn-outline-info {
        color: var(--softblue);
        border: 2px solid var(--softblue);
        transition: all 0.3s ease;
    }

    .btn-outline-info:hover {
        background: var(--softblue);
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(66, 165, 245, 0.3);
    }

    /* Map Action Button */
    .btn-map-action {
        background: linear-gradient(135deg, #4fc3f7, #29b6f6);
        color: #fff !important;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(47, 195, 247, 0.3);
    }

    .btn-map-action:hover {
        background: linear-gradient(135deg, #29b6f6, #0288d1);
        color: #fff !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(47, 195, 247, 0.5);
    }

    .btn-map-action:active {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(47, 195, 247, 0.3);
    }

    /* Text & Typography */
    .lh-lg {
        line-height: 1.8;
    }

    .text-light.opacity-85 {
        opacity: 0.85 !important;
        color: #e0e0e0;
    }

    .badge {
        font-size: 0.9rem;
        border-radius: 8px;
    }

    .bg-softblue {
        background: var(--softblue) !important;
    }

    /* Animations */
    .animate__fadeInRight {
        animation-delay: 0.6s;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .cultural-hero h1 {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .cultural-hero {
            min-height: 250px;
        }

        .cultural-hero h1 {
            font-size: 1.75rem;
        }

        .container {
            margin-top: 1.5rem !important;
        }

        .gallery-thumbnail {
            width: 70px !important;
            height: 55px !important;
        }
    }

    /* Lightbox customization */
    .lb-data .lb-details {
        background: rgba(0, 0, 0, 0.9);
    }

    .lb-outerContainer {
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<!-- Lightbox2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lightbox2
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'disableScrolling': false,
            'albumLabel': 'Gambar %1 dari %2'
        });

        // Gallery thumbnail click handler
        const carousel = document.querySelector('#galleryCarousel');
        if (carousel) {
            const thumbnails = document.querySelectorAll('.gallery-thumbnail');
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', function(e) {
                    e.preventDefault();
                    const carouselInstance = new bootstrap.Carousel(carousel);
                    carouselInstance.to(index);
                    
                    // Update active thumbnail
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Update thumbnail on carousel slide
            carousel.addEventListener('slid.bs.carousel', function(event) {
                const activeIndex = event.to;
                thumbnails.forEach((thumb, index) => {
                    thumb.classList.toggle('active', index === activeIndex);
                });
            });
        }

        // Smooth scroll for back button
        const backBtn = document.querySelector('[data-bs-dismiss="modal"]');
        if (backBtn) {
            backBtn.addEventListener('click', function(e) {
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.href = '/';
                }
            });
        }

        // Make sure video embeds are responsive
        const videoFrame = document.querySelector('iframe[src*="youtube"]');
        if (videoFrame) {
            videoFrame.addEventListener('load', function() {
                this.style.width = '100%';
                this.style.height = 'auto';
            });
        }
    });
</script>
@endpush
