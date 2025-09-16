@extends('layouts.app')

@section('title', 'Cultural Map')

@section('content')
<div class="container-fluid mt-4">
    <div class="map-container p-4 rounded-3 shadow-lg">
        <h1 class="text-center fw-bold text-warning">Cultural Map Garut</h1>
        <h5 class="text-center text-light mb-4">
            Eksplorasi lokasi wisata budaya khas Garut dalam peta interaktif.
        </h5>

        <div id="map"></div>

        {{-- Footer di dalam box --}}
        <hr class="border-light my-4">
        <p class="text-center text-light mb-0">© 2025 Cultural Map Garut.</p>
    </div>
</div>

{{-- Overlay custom pencarian --}}
<div id="searchOverlay" class="d-none">
    <div class="overlay-backdrop"></div>
    <div class="overlay-box">
        <h5 class="fw-bold text-danger">Pencarian Tidak Ditemukan</h5>
        <p>Silakan coba kata kunci lain.</p>
        <button class="btn btn-warning fw-bold mt-2" onclick="closeOverlay()">Tutup</button>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Map box hitam transparan */
    .map-container {
        background: rgba(0, 0, 0, 0.85);
    }

    #map {
        height: 600px;
        border-radius: 15px;
        overflow: hidden;
    }

    #searchOverlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .overlay-backdrop {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
    }

    .overlay-box {
        position: relative;
        background: rgba(0,0,0,0.85);
        color: #fff;
        padding: 20px 30px;
        border-radius: 15px;
        text-align: center;
        z-index: 10000;
        max-width: 350px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.6);
    }
</style>
@endpush

@push('scripts')
    {{-- Leaflet CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        function showOverlay() {
            document.getElementById("searchOverlay").classList.remove("d-none");
        }
        function closeOverlay() {
            document.getElementById("searchOverlay").classList.add("d-none");
        }

        // Inisialisasi Map
        var map = L.map('map').setView([-7.2279, 107.9087], 12); // posisi default Garut

        // Basemap OSM
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Load data GeoJSON dari QGIS export
        fetch("{{ asset('data/cultural_map.geojson') }}")
            .then(res => res.json())
            .then(data => {
                let layerGroup = L.geoJSON(data, {
                    onEachFeature: function (feature, layer) {
                        if (feature.properties) {
                            let content = `
                                <div style="min-width:200px;">
                                    <h6 class="fw-bold text-primary">${feature.properties.name ?? "Lokasi Budaya"}</h6>
                                    <p style="font-size: 14px; color:#555;">
                                        ${feature.properties.description ?? "Informasi singkat tentang lokasi budaya ini."}
                                    </p>
                                    <a href="/cultural/${feature.properties.id}" class="btn btn-sm btn-warning text-dark fw-bold">
                                        Lanjut »
                                    </a>
                                </div>
                            `;
                            layer.bindPopup(content);
                        }
                    },
                    pointToLayer: function(feature, latlng) {
                        return L.marker(latlng, {icon: L.icon({
                            iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
                            iconSize: [30, 30],
                            iconAnchor: [15, 30],
                            popupAnchor: [0, -30]
                        })});
                    }
                }).addTo(map);

                // 🔍 Fitur Pencarian
                let urlParams = new URLSearchParams(window.location.search);
                let searchQuery = urlParams.get('q') ? urlParams.get('q').toLowerCase() : null;

                if (searchQuery) {
                    let found = null;
                    layerGroup.eachLayer(function(layer) {
                        let props = layer.feature.properties;
                        if (
                            (props.name && props.name.toLowerCase().includes(searchQuery)) || 
                            (props.description && props.description.toLowerCase().includes(searchQuery))
                        ) {
                            found = layer;
                        }
                    });

                    if (found) {
                        map.setView(found.getLatLng(), 15);
                        found.openPopup();
                    } else {
                        showOverlay();
                    }
                }
            });
    </script>
@endpush
