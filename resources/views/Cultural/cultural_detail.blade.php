@extends('layouts.app')

@section('title', $cultural->name)

@section('content')
<div class="container mt-5 p-4 rounded-3 content-box">
    <div class="row g-4">
        <!-- Kolom Gambar -->
        <div class="col-md-6">
            <div class="main-image mb-3">
                @if($cultural->image)
                    <img src="{{ asset('storage/'.$cultural->image) }}" 
                         alt="{{ $cultural->name }}" 
                         class="img-fluid rounded-3 shadow-lg w-100" 
                         style="max-height: 400px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/600x400?text=No+Image" 
                         class="img-fluid rounded-3 shadow-lg w-100" 
                         alt="No image">
                @endif
            </div>

            <!-- Kolase tambahan (jika ada galeri) -->
            @if($cultural->gallery ?? false)
                <div class="row g-2">
                    @foreach($cultural->gallery as $galleryImage)
                        <div class="col-4">
                            <img src="{{ asset('storage/'.$galleryImage) }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 alt="Gallery Image" 
                                 style="height: 100px; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Kolom Detail -->
        <div class="col-md-6 text-light">
            <h2 class="fw-bold text-warning">{{ $cultural->name }}</h2>
            <hr class="border-light my-3">
            <p><strong class="text-warning">Kategori:</strong> {{ $cultural->category }}</p>
            <p><strong class="text-warning">Lokasi:</strong> {{ $cultural->location }}</p>
            <p class="mt-3">{{ $cultural->description }}</p>

            <!-- Tombol navigasi -->
            <div class="mt-4 d-flex flex-wrap gap-2">
                <a href="{{ route('cultural.index') }}" class="btn btn-outline-light">
                    ← Kembali
                </a>
                <a href="{{ url('/map') }}" class="btn btn-warning text-dark fw-bold">
                    <i class="bi bi-map-fill"></i> Lihat di Map
                </a>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <hr class="border-warning my-5">

    <!-- Section Tambahan: Info Budaya -->
    <div class="text-center">
        <h4 class="fw-bold text-warning">Eksplor Lebih Banyak Budaya</h4>
        <p class="text-light">Temukan keindahan budaya Garut lainnya di peta interaktif.</p>
        <a href="{{ url('/map') }}" class="btn btn-outline-warning mt-2">
            🌏 Jelajahi Peta Budaya
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .content-box {
        background: rgba(0, 0, 0, 0.9);
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }
    .main-image img {
        transition: transform 0.3s ease;
    }
    .main-image img:hover {
        transform: scale(1.02);
    }
    .gallery img {
        transition: 0.3s;
    }
    .gallery img:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.5);
    }
</style>
@endpush
