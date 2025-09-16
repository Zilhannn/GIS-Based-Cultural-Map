@extends('layouts.app')

@section('title', 'Daftar Kebudayaan')

@section('content')
<div class="container mt-5 p-4 rounded-3 content-box">
    <h2 class="text-center mb-4 text-warning fw-bold">Budaya Khas Garut</h2>
    <p class="text-center text-light mb-5">
        Beberapa kekayaan budaya Garut yang patut kamu ketahui, Mari kita Eksplor!
    </p>

    <!-- Filter Alphabet & Sort -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        
        <!-- Tombol toggle untuk filter abjad -->
        <div class="text-center">
            <button class="btn btn-outline-warning btn-sm fw-bold" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#alphabetFilter" 
                    aria-expanded="false" 
                    aria-controls="alphabetFilter">
                ☰ Urut Berdasarkan Abjad
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
                   class="btn btn-sm m-1 {{ request('starts_with') === $letter ? 'btn-warning text-dark fw-bold' : 'btn-outline-warning' }}">
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
                <div class="card bg-dark text-white border-0 shadow-lg rounded-3 h-100 custom-card">
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
                    <div class="card-img-overlay d-flex flex-column justify-content-end" 
                         style="background: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0));">
                        <h5 class="card-title fw-bold text-warning">{{ $cultural->name }}</h5>
                        <p class="card-text text-light mb-2">
                            {{ Str::limit($cultural->description, 80) }}
                        </p>
                        <small class="text-light">
                            <i class="bi bi-geo-alt-fill"></i> {{ $cultural->location }}
                        </small>
                        <a href="{{ route('cultural.show', $cultural->id) }}" 
                           class="btn btn-warning btn-sm mt-2 align-self-start">
                            Lihat Detail
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

    <hr class="border-light my-4">
    <p style="color: white" align="center">© 2025 Cultural Map Garut.</p>
</div>
@endsection

@push('styles')
<style>
    /* Background hitam transparan untuk konten */
    .content-box {
        background: rgba(0, 0, 0, 0.85);
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }

    .custom-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    }

    .custom-dropdown {
        background-color: #222;
        color: #ffc107;
        border: 1px solid #ffc107;
        border-radius: 8px;
        padding: 5px 10px;
    }
    .custom-dropdown:focus {
        box-shadow: 0 0 5px #ffc107;
    }
    .custom-dropdown option {
        background-color: #333;
        color: #fff;
    }
</style>
@endpush
