@extends('layouts.app')

@section('title', 'Daftar Kebudayaan')

@section('content')
<div class="container mt-5 p-4 rounded-3 content-box animate__animated animate__fadeIn">
    <h2 class="text-center mb-4 text-softblue fw-bold">Budaya Khas Garut</h2>
    <p class="text-center text-light mb-5">
        Beberapa kekayaan budaya Garut yang patut kamu ketahui, Mari kita Eksplor!
    </p>

    <!-- Filter Alphabet & Sort -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3 controls-row">
        
        <!-- Tombol toggle untuk filter abjad -->
        <div class="text-center">
            <button class="btn btn-pill btn-pill-outline fw-bold shadow-sm" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#alphabetFilter" 
                    aria-expanded="false" 
                    aria-controls="alphabetFilter">
                <i class="bi bi-list me-2"></i> Tampilkan Berdasarkan Abjad
            </button>
        </div>

        <!-- Category Filter + Sort -->
        <form method="GET" action="{{ route('cultural.index') }}" class="d-flex gap-2">
            @if(request('starts_with'))
                <input type="hidden" name="starts_with" value="{{ request('starts_with') }}">
            @endif

            <select name="category" aria-label="Filter Kategori" title="{{ request('category') ? request('category') : 'Semua Kategori' }}" class="form-select form-select-sm custom-dropdown me-2" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @if(isset($categories) && $categories->count())
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                @endif
            </select>

            <select name="sort" aria-label="Urutkan daftar" title="{{ request('sort') ? (request('sort') == 'asc' ? 'A ke Z' : 'Z ke A') : 'Urutkan' }}" class="form-select form-select-sm custom-dropdown" onchange="this.form.submit()">
                <option value="">Urutkan</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A ke Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z ke A</option>
            </select>
        </form>

            @php $hasFilters = request()->has('starts_with') || request()->has('category') || request()->has('sort'); @endphp
            <a href="{{ $hasFilters ? route('cultural.index') : '#' }}" class="btn btn-pill btn-clear-filter shadow-sm ms-2 d-none d-md-inline-flex {{ $hasFilters ? '' : 'disabled' }}" {{ $hasFilters ? '' : 'aria-disabled="true" title="Tidak ada filter untuk dihapus"' }}><i class="bi bi-x-lg me-1"></i> Hapus Filter</a>
        </div>

    <!-- Mobile Clear Filter (visible on small screens) -->
    <div class="d-md-none mt-2">
        @php $hasFilters = request()->has('starts_with') || request()->has('category') || request()->has('sort'); @endphp
        <a href="{{ $hasFilters ? route('cultural.index') : '#' }}" class="btn btn-pill btn-clear-filter shadow-sm w-100 {{ $hasFilters ? '' : 'disabled' }}" {{ $hasFilters ? '' : 'aria-disabled="true" title="Tidak ada filter untuk dihapus"' }}><i class="bi bi-x-lg me-1"></i> Hapus Filter</a>
    </div>

    <!-- Filter by Alphabet (collapse) -->
    <div class="collapse mb-4" id="alphabetFilter">
        <div class="d-flex flex-wrap justify-content-center">
            @foreach(range('A', 'Z') as $letter)
                <a href="{{ route('cultural.index', array_merge(request()->query(), ['starts_with' => $letter])) }}"
                   class="btn alpha-btn m-1 {{ request('starts_with') === $letter ? 'alpha-active' : '' }}" aria-pressed="{{ request('starts_with') === $letter ? 'true' : 'false' }}">
                    {{ $letter }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Daftar Budaya -->
    <div class="row cultural-list">
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

                        @if($cultural->category)
                            <div class="mt-1">
                                <a href="{{ route('cultural.index', array_merge(request()->query(), ['category' => $cultural->category])) }}" class="btn btn-pill btn-pill-outline btn-sm fw-bold">
                                    {{ $cultural->category }}
                                </a>
                            </div>
                        @endif

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

    /* Custom dropdown (pill-style with chevron) */
    .custom-dropdown {
        background: rgba(255,255,255,0.03);
        color: var(--softblue);
        border: 1px solid rgba(66,165,245,0.35);
        border-radius: 999px;
        padding: 8px 44px 8px 16px; /* space for the chevron on the right */
        transition: all 0.18s ease;
        cursor: pointer;
        min-height: 40px;
        min-width: 200px; /* avoid truncation */
        max-width: 360px;
        width: auto;
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.95rem;
        line-height: 1.2;
        appearance: none; /* remove native arrow */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2342a5f5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
    }

    @media (max-width: 767.98px) {
        .custom-dropdown {
            width: 100%;
            min-width: 0;
            padding-right: 36px; /* slightly smaller chevron spacing on mobile */
        }
    }

    .custom-dropdown:hover {
        background: rgba(66,165,245,0.12);
        color: #fff;
        box-shadow: 0 6px 18px rgba(66,165,245,0.12);
        border-color: rgba(66,165,245,0.6);
    }

    .custom-dropdown:focus {
        outline: none;
        box-shadow: 0 10px 24px rgba(66,165,245,0.18);
        border-color: rgba(66,165,245,0.9);
    }

    /* Note: styling of native <option> is limited across browsers */
    .custom-dropdown option {
        background: var(--darkgray);
        color: #fff;
        padding: 6px 12px;
    }

    /* Buttons - Pill Theme */
    .btn-pill {
        border-radius: 999px;
        padding: 8px 16px;
        min-height: 40px;
        display:inline-flex;
        align-items:center;
        gap:8px;
        transition: all 0.18s ease;
    }

    .btn-pill-outline {
        background: rgba(255,255,255,0.03);
        color: var(--softblue);
        border: 1px solid rgba(66,165,245,0.25);
    }

    .btn-pill-outline:hover {
        background: rgba(66,165,245,0.12);
        color:#fff;
        transform: translateY(-1px);
        border-color: rgba(66,165,245,0.5);
        box-shadow: 0 6px 18px rgba(66,165,245,0.08);
    }

    .btn-pill-filled {
        background: var(--softblue);
        color:#fff;
        border: none;
        box-shadow: 0 8px 30px rgba(66,165,245,0.12);
    }

    .btn-pill.btn-sm { padding:6px 12px; min-height:32px; }

    /* Circular alphabet button */
    .alpha-btn {
        width:40px;
        height:40px;
        border-radius:50%;
        padding:0;
        border:1px solid rgba(66,165,245,0.25);
        color:var(--softblue);
        background:transparent;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        transition: all 0.12s ease;
    }
    .alpha-btn:hover { background: rgba(66,165,245,0.08); color:#fff; border-color: rgba(66,165,245,0.5); transform: translateY(-2px); }
    .alpha-active { background: var(--softblue); color:#fff; box-shadow: 0 6px 18px rgba(66,165,245,0.12); border-color: var(--softblue); }

    /* Controls right */
    .controls-right { gap: 12px; align-items:center; }
    .controls-row { margin-bottom: 1.25rem; }

    .btn-clear-filter { background: transparent; color: var(--softblue); border: 1px solid rgba(66,165,245,0.25); padding: 8px 14px; border-radius: 999px; display:inline-flex; align-items:center; gap:8px; }
    .btn-clear-filter:hover { background: rgba(230, 240, 255, 0.06); color: #fff; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(66,165,245,0.08); }
    .btn-clear-filter .bi { font-size: 14px; }

    .btn-clear-filter.w-100 { justify-content:center; }

    /* Disabled variant for clear filter when no filters are active */
    .btn-clear-filter.disabled, .btn-clear-filter[aria-disabled="true"] {
        opacity: 0.6;
        pointer-events: none;
        cursor: not-allowed;
        background: rgba(255,255,255,0.02);
        border-color: rgba(255,255,255,0.04);
    }

    @media (max-width: 767px) {
        .controls-right { width:100%; justify-content:flex-end; }
        .btn-pill { font-size: 14px; }
        .alpha-btn { width:36px; height:36px; }
        .controls-row { margin-bottom: 0.75rem; }
    }

    /* Small spacer to ensure controls don't overlap cards on narrow layouts */
    .cultural-list { margin-top: 0.6rem; }

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
