@extends('layouts.app')

@section('title', 'Daftar Kebudayaan')

@section('content')
<div class="container mt-5 p-4 rounded-3 content-box animate__animated animate__fadeIn">
    <h2 class="text-center mb-4 text-softblue fw-bold">Budaya Khas Garut</h2>
    <p class="text-center text-light mb-5">
        Beberapa kekayaan budaya Garut yang patut kamu ketahui, Mari kita Eksplor!
    </p>

    <!-- Filter Alphabet & Sort -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        
        <!-- Tombol toggle untuk filter abjad -->
        <div class="text-center">
            <button class="btn btn-outline-primary btn-sm fw-bold shadow-sm" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#alphabetFilter" 
                    aria-expanded="false" 
                    aria-controls="alphabetFilter">
                ☰ Tampilkan Berdasarkan Abjad
            </button>
        </div>

        <!-- Dropdown Sort -->
        <form method="GET" action="{{ route('cultural.index') }}" class="d-flex">
            @if(request('starts_with'))
                <input type="hidden" name="starts_with" value="{{ request('starts_with') }}">
            @endif
            <select name="sort" class="form-select form-select-sm custom-dropdown" onchange="this.form.submit()">
                <option value="">Urutkan</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A ke Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z ke A</option>
            </select>
        </form>
    </div>

    <!-- Filter by Alphabet (collapse) -->
    <div class="collapse mb-4" id="alphabetFilter">
        <div class="d-flex flex-wrap justify-content-center">
            @foreach(range('A', 'Z') as $letter)
                <a href="{{ route('cultural.index', array_merge(request()->query(), ['starts_with' => $letter])) }}" 
                   class="btn btn-sm m-1 {{ request('starts_with') === $letter ? 'btn-primary fw-bold text-white' : 'btn-outline-primary' }}">
                    {{ $letter }}
                </a>
            @endforeach
            <a href="{{ route('cultural.index') }}" 
               class="btn btn-sm m-1 {{ request('starts_with') ? 'btn-outline-light' : 'btn-light text-dark fw-bold' }}">
                Hapus Filter
            </a>
        </div>
    </div>

    <!-- Daftar Budaya -->
    <div class="row">
        @forelse($culturals as $cultural)
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white border-0 shadow-lg rounded-3 h-100 custom-card animate__animated animate__zoomIn">
                    <!-- Gambar -->
                    @if($cultural->image)
                        <img src="{{ asset('storage/'.$cultural->image) }}" 
                             class="card-img" 
                             alt="{{ $cultural->name }}" 
                             style="height: 250px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x250?text=No+Image" 
                             class="card-img" 
                             alt="No image">
                    @endif

                    <!-- Overlay -->
                    <div class="card-img-overlay d-flex flex-column justify-content-end overlay-gradient">
                        <h5 class="card-title fw-bold text-primary">{{ $cultural->name }}</h5>
                        <small class="text-light">
                            <i class="bi bi-geo-alt-fill"></i> {{ $cultural->location }}
                        </small>
                        <a href="{{ route('cultural.show', $cultural->id) }}" 
                           class="btn btn-primary btn-sm mt-2 align-self-start shadow-sm fw-bold">
                            Lihat Detail »
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-light">
                <p>Tidak ada data untuk filter ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $culturals->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Background hitam transparan untuk konten */
    .content-box {
        background: rgba(0, 0, 0, 0.85);
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }

    /* Soft Blue Custom untuk Judul */
    .text-softblue {
        color: #42a5f5 !important; /* biru soft */
        text-shadow: 0px 0px 6px rgba(66, 165, 245, 0.3); /* glow halus */
    }

    /* Card dengan animasi */
    .custom-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .custom-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 30px rgba(0,0,0,0.6);
    }

    /* Overlay gradasi */
    .overlay-gradient {
        background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
        border-radius: 0 0 10px 10px;
    }

    /* Dropdown style + animasi */
    .custom-dropdown {
        background-color: #111;
        color: #0d6efd;
        border: 1px solid #0d6efd;
        border-radius: 25px;
        padding: 6px 14px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .custom-dropdown:hover {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0px 0px 15px rgba(13,110,253,0.7);
        transform: scale(1.05);
    }
    .custom-dropdown:focus {
        outline: none;
        box-shadow: 0px 0px 12px rgba(13,110,253,0.9);
    }
    .custom-dropdown option {
        background-color: #333;
        color: #fff;
    }

    /* Pagination style */
    .pagination .page-link {
        background-color: #222;
        color: #0d6efd;
        border: 1px solid #0d6efd;
        transition: all 0.3s ease;
    }
    .pagination .page-link:hover {
        background-color: #0d6efd;
        color: #fff;
    }
    .pagination .active .page-link {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #fff !important;
    }

    /* Hover efek tombol */
    .btn-primary {
        background: #0d6efd;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: #2196f3;
        transform: scale(1.05);
        box-shadow: 0px 4px 12px rgba(13, 110, 253, 0.5);
    }
</style>
@endpush
