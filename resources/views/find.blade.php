@extends('layouts.app')

@section('title', 'Cari Budaya Garut')

@section('content')
<style>
    .search-hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .search-hero::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 1;
    }

    .search-box {
        position: relative;
        z-index: 2;
        background: rgba(0,0,0,0.8); /* kotak hitam */
        padding: 40px 30px;
        border-radius: 15px;
        max-width: 700px;
        width: 90%;
        box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }

    .search-box h2 {
        color: #fff;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .search-box input {
        border-radius: 50px;
        padding: 14px 20px;
        font-size: 16px;
        border: none;
        outline: none;
        width: 100%;
    }

    .search-box button {
        margin-top: 20px;
        border-radius: 50px;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: bold;
    }

    .search-box p {
        margin-top: 15px;
        color: #ccc;
        font-size: 14px;
    }

    /* suggestion dropdown */
    .autocomplete-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
    }
    .autocomplete-suggestion {
        padding: 10px 15px;
        cursor: pointer;
        text-align: left;
    }
    .autocomplete-suggestion:hover {
        background: #f1c40f;
        color: #000;
    }
</style>

<div class="search-hero">
    <div class="search-box">
        <h2>Cari Budaya & Lokasi di Garut</h2>
        <form action="{{ url('/map') }}" method="GET" autocomplete="off">
            <div style="position: relative;">
                <input type="text" id="searchInput" name="q" placeholder="Masukkan nama budaya atau lokasi...">
                <div id="suggestions" class="autocomplete-suggestions d-none"></div>
            </div>
            <button type="submit" class="btn btn-warning text-dark fw-bold mt-3">Cari Sekarang!</button>
        </form>
        <p>Contoh: <em>Candi Cangkuang, Kampung Pulo, Dodol</em></p>
        <hr class="border-light my-4">
        <p style="color: white" align="center">© 2025 Cultural Map Garut.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let dataList = [];

    // Ambil daftar lokasi dari cultural_map.geojson
    fetch("{{ asset('data/cultural_map.geojson') }}")
        .then(res => res.json())
        .then(data => {
            data.features.forEach(f => {
                if (f.properties && f.properties.name) {
                    dataList.push(f.properties.name);
                }
            });
        });

    const input = document.getElementById("searchInput");
    const suggestionsBox = document.getElementById("suggestions");

    input.addEventListener("input", function() {
        let query = this.value.toLowerCase();
        suggestionsBox.innerHTML = "";

        if (query.length === 0) {
            suggestionsBox.classList.add("d-none");
            return;
        }

        let filtered = dataList.filter(item => item.toLowerCase().includes(query));

        if (filtered.length > 0) {
            suggestionsBox.classList.remove("d-none");
            filtered.forEach(item => {
                let div = document.createElement("div");
                div.classList.add("autocomplete-suggestion");
                div.textContent = item;
                div.onclick = function() {
                    input.value = item;
                    suggestionsBox.classList.add("d-none");
                };
                suggestionsBox.appendChild(div);
            });
        } else {
            suggestionsBox.classList.add("d-none");
        }
    });

    // Tutup suggestion kalau klik di luar
    document.addEventListener("click", function(e) {
        if (!e.target.closest("#searchInput")) {
            suggestionsBox.classList.add("d-none");
        }
    });
</script>
@endpush
