@extends('layouts.app')

@section('title', $cultural->name)

@section('content')
<div class="container mt-5 p-4 rounded-3 content-box">
    <div class="row g-4">
        <!-- Kolom Gambar -->
        <div class="col-md-6">
            <!-- Carousel -->
            <div id="culturalCarousel" class="carousel slide shadow-lg rounded-3" data-bs-ride="carousel">
                <div class="carousel-inner">
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
                            <a href="{{ asset('storage/'.$img) }}" data-lightbox="cultural-gallery" data-title="{{ $cultural->name }}">
                                <img src="{{ asset('storage/'.$img) }}" 
                                     class="d-block w-100 rounded-3" 
                                     alt="{{ $cultural->name }}" 
                                     style="max-height: 400px; object-fit: cover;">
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Control -->
                @if(count($images) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#culturalCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#culturalCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif

                <!-- Thumbnail indicator -->
                @if(count($images) > 1)
                    <div class="carousel-indicators mt-3 position-static">
                        @foreach($images as $index => $img)
                            <img src="{{ asset('storage/'.$img) }}" 
                                 data-bs-target="#culturalCarousel" 
                                 data-bs-slide-to="{{ $index }}" 
                                 class="img-thumbnail {{ $index == 0 ? 'active' : '' }}" 
                                 style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Kolom Detail -->
        <div class="col-md-6 text-light">
            <h2 class="fw-bold text-warning">{{ $cultural->name }}</h2>
            <hr class="border-light my-3">
            <p><strong class="text-warning">Kategori:</strong> {{ $cultural->category }}</p>
            <p><strong class="text-warning">Lokasi:</strong> {{ $cultural->location }}</p>

            <!-- Deskripsi Dibagi Bagian -->
            <div class="mt-4">
                @if($cultural->description)
                    <h5 class="text-warning fw-bold">Deskripsi</h5>
                    <p>{{ $cultural->description }}</p>
                @endif

                @if($cultural->history)
                    <h5 class="text-warning fw-bold">Sejarah Singkat</h5>
                    <p>{{ $cultural->history }}</p>
                @endif

                @if($cultural->nowaday)
                    <h5 class="text-warning fw-bold">Keadaan Sekarang</h5>
                    <p>{{ $cultural->nowaday }}</p>
                @endif

                @if($cultural->cult_now)
                    <h5 class="text-warning fw-bold">Adat & Kebudayaan</h5>
                    <p>{{ $cultural->cult_now }}</p>
                @endif
            </div>

            <!-- Tombol navigasi -->
            <div class="mt-5 d-flex flex-wrap justify-content-between align-items-center gap-3 nav-buttons">
                {{-- Previous --}}
                @if($prev = \App\Models\Cultural::where('id', '<', $cultural->id)->orderBy('id','desc')->first())
                    <a href="{{ route('cultural.show', $prev->id) }}" 
                       class="btn btn-outline-warning fw-bold px-3">
                        ← {{ Str::limit($prev->name, 15) }}
                    </a>
                @else
                    <span></span>
                @endif

                {{-- Kembali & Map --}}
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('cultural.index') }}" class="btn btn-outline-light px-4">
                        <i class="bi bi-list"></i> Kembali
                    </a>
                    @if($cultural->has_map)
                        <a href="{{ url('/map') }}?cultural_id={{ $cultural->id }}" class="btn btn-warning ...">
                            <i class="bi bi-map-fill"></i> Lihat di Map
                        </a>
                    @endif
                </div>
                {{-- Next --}}
                @if($next = \App\Models\Cultural::where('id', '>', $cultural->id)->orderBy('id','asc')->first())
                    <a href="{{ route('cultural.show', $next->id) }}" 
                       class="btn btn-outline-warning fw-bold px-3">
                        {{ Str::limit($next->name, 15) }} →
                    </a>
                @else
                    <span></span>
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
    .content-box {
        background: rgba(0, 0, 0, 0.9);
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }
    .carousel img {
        transition: transform 0.3s ease;
    }
    .carousel img:hover {
        transform: scale(1.02);
    }
    .carousel-indicators {
        justify-content: center;
        gap: 8px;
    }
    .carousel-indicators img.active {
        border: 2px solid #ffc107;
    }
    .btn-outline-warning {
        border-width: 2px;
    }

    /* Tambahan spacing tombol */
    .nav-buttons .btn {
        min-width: 130px;
    }
    .nav-buttons {
        gap: 1rem !important;
    }

    /* Responsive: tombol stack di layar kecil */
    @media (max-width: 768px) {
        .nav-buttons {
            flex-direction: column;
            align-items: stretch !important;
        }
        .nav-buttons .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Lightbox2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endpush
