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
                        <a href="{{ route('cultural.show', $cultural->slug) }}" 
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
    /* Content box */
    .content-box {
        background: rgba(var(--darkgray-rgb), 0.95);
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }

    /* Cards */
    .custom-card {
        background: var(--darkgray) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 30px rgba(66,165,245,0.2);
    }

    /* Card overlay */
    .overlay-gradient {
        background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
        border-radius: 0 0 10px 10px;
    }

    .card-title {
        color: var(--softblue) !important;
    }

    /* Custom dropdown */
    .custom-dropdown {
        background: var(--darkgray);
        color: var(--softblue);
        border: 1px solid var(--softblue);
        border-radius: 25px;
        padding: 6px 14px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .custom-dropdown:hover {
        background: var(--softblue);
        color: #fff;
        box-shadow: 0 0 15px rgba(66,165,245,0.4);
    }

    .custom-dropdown:focus {
        outline: none;
        box-shadow: 0 0 12px rgba(66,165,245,0.5);
    }

    .custom-dropdown option {
        background: var(--darkgray);
        color: #fff;
    }

    /* Pagination */
    .pagination .page-link {
        background: var(--darkgray);
        color: var(--softblue);
        border: 1px solid var(--softblue);
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: var(--softblue);
        color: #fff;
    }

    .pagination .active .page-link {
        background: var(--softblue) !important;
        border-color: var(--softblue) !important;
        color: #fff !important;
    }

    /* Buttons */
    .btn-outline-primary {
        color: var(--softblue);
        border-color: var(--softblue);
    }

    .btn-outline-primary:hover {
        background: var(--softblue);
        border-color: var(--softblue);
        color: #fff;
    }

    .btn-primary {
        background: var(--softblue);
        border: none;
        color: #fff;
    }

    .btn-primary:hover {
        background: var(--darkblue);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(66,165,245,0.5);
    }
</style>
@endpush
