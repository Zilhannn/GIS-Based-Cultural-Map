@extends('layouts.app')

@section('title', 'Cari Pada Map')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow-sm animate__animated animate__fadeIn bg-dark bg-opacity-75 text-light">
            <div class="card-body">
                <h2 class="card-title text-center text-softblue fw-bold mb-3">Cari Budaya & Lokasi di Garut</h2>
                <form id="searchForm" action="{{ url('/find') }}" method="GET" autocomplete="off">
                    <div class="input-group">
                        <input type="text" id="searchInput" name="q" class="form-control form-control-lg bg-dark text-white border-secondary" placeholder="Masukkan nama budaya atau lokasi..." value="{{ request('q') }}">
                        <button class="btn btn-primary btn-lg" type="submit">Cari</button>
                    </div>
                </form>
                <p class="text-center text-muted small mt-3 mb-0">Contoh: <em>Candi Cangkuang, Kampung Pulo</em></p>
            </div>
        </div>
    </div>
</div>
 
@if(request('q'))
<div class="container mt-5 mb-5">
    <div class="mb-3">
        <div class="alert bg-dark text-light border-0">
            Menemukan <strong>{{ $results->count() }}</strong> hasil untuk: <em>{{ $query }}</em>
        </div>
    </div>
    {{-- Debug output removed to keep UI clean --}}
    <div class="row">
        @forelse($results as $cultural)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-lg border-0 h-100 animate__animated animate__fadeIn bg-dark bg-opacity-75 text-light" style="cursor: pointer; transition: all 0.3s ease;">
                    @if($cultural->image)
                        <img src="{{ asset('storage/'.$cultural->image) }}" class="card-img-top" alt="{{ $cultural->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-secondary" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title text-softblue fw-bold">{{ $cultural->name }}</h5>
                        <p class="card-text text-light small">{{ Str::limit($cultural->description, 60) }}</p>
                        <p class="text-light small mb-2">
                            <i class="bi bi-tag"></i> {{ $cultural->category }}
                        </p>
                        <p class="text-light small mb-3">
                            <i class="bi bi-geo-alt"></i> {{ $cultural->location }}
                        </p>
                        <a href="{{ route('cultural.show', $cultural->slug) }}" class="btn btn-sm btn-outline-info fw-bold w-100">
                            <i class="bi bi-eye me-1"></i> Lihat Detail
                        </a>
                        @if($cultural->has_map)
                            <a href="{{ url('/map') }}?cultural_id={{ $cultural->id }}" class="btn btn-sm btn-info text-dark fw-bold w-100 mt-2">
                                <i class="bi bi-map-fill me-1"></i> Lihat di Map
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center mt-5 bg-dark text-light border-0">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong>Tidak ada hasil pencarian</strong>
                    <p class="mt-2">Budaya dengan nama "<strong>{{ request('q') }}</strong>" tidak ditemukan. Silakan coba kata kunci lain.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endif
@endsection
