@extends('layouts.app')

@section('title', 'Cultural Map')

@section('content')
<div class="container-fluid mt-4">
    <div class="map-container p-4 rounded-3 shadow-lg animate__animated animate__fadeIn">
        <h1 class="text-center fw-bold text-primary mb-3">Cultural Map Garut</h1>
        <h5 class="text-center text-light mb-4 animate__animated animate__fadeInUp animate__delay-1s">
            Eksplorasi lokasi wisata budaya khas Garut dalam peta interaktif.
        </h5>
        <div id="map"></div>
    </div>
</div>

{{-- Overlay custom pencarian --}}
<div id="searchOverlay" class="d-none">
    <div class="overlay-backdrop"></div>
    <div class="overlay-box animate__animated animate__zoomIn">
        <h5 class="fw-bold text-primary">Pencarian Tidak Ditemukan</h5>
        <p>Silakan coba kata kunci lain.</p>
        <button class="btn btn-primary fw-bold mt-2" onclick="closeOverlay()">Tutup</button>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Map container */
    .map-container {
        background: rgba(47, 58, 74, 0.95);
        border: 1px solid rgba(255,255,255,0.1);
    }

    #map {
        height: 600px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.4);
    }

    /* Overlay */
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
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(2px);
    }
    .overlay-box {
        position: relative;
        background: rgba(47, 58, 74, 0.95);
        color: #fff;
        padding: 25px 30px;
        border-radius: 15px;
        text-align: center;
        z-index: 10000;
        max-width: 360px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.15);
    }
    .overlay-box h5 {
        color: #42a5f5;
        margin-bottom: 10px;
    }

    /* Tombol biru lebih kontras */
    .btn-primary {
        background: linear-gradient(135deg, #42a5f5, #1e88e5);
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        color: #fff !important;
        font-weight: 600;
        text-shadow: 0px 1px 3px rgba(0,0,0,0.7);
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #64b5f6, #2196f3);
        transform: scale(1.05);
        box-shadow: 0px 0px 12px rgba(66, 165, 245, 0.8);
        color: #fff !important;
        text-shadow: 0px 1px 4px rgba(0,0,0,0.8);
    }

    /* Popup Leaflet */
    .leaflet-popup-content-wrapper {
        border-radius: 12px !important;
        background: #2f3a4a !important;
        color: #fff !important;
        box-shadow: 0px 6px 20px rgba(0,0,0,0.5) !important;
        animation: popupZoom 0.3s ease;
    }
    .leaflet-popup-tip {
        background: #2f3a4a !important;
    }
    .leaflet-popup-content h6 {
        color: #42a5f5;
        font-weight: bold;
    }
    .leaflet-popup-content p {
        color: #dce3ec;
    }

    @keyframes popupZoom {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Custom Marker Pin Style */
    .custom-marker .pin {
    position: relative;
    width: 26px;
    height: 26px;
    background: linear-gradient(135deg, #64b5f6, #1976d2); /* soft gradient */
    border: 3px solid #fff;
    border-radius: 50%;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3); /* lebih lembut */
    }
    .custom-marker .pin::after {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-top: 12px solid #1976d2; /* bagian bawah lebih gelap */
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
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
        var map = L.map('map').setView([-7.2279, 107.9087], 12);

        // Basemap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Parameter URL
        let urlParams = new URLSearchParams(window.location.search);
        let searchQuery = urlParams.get('q') ? urlParams.get('q').toLowerCase() : null;
        let targetId = urlParams.get('cultural_id');

        // Custom Marker Pin
        const customMarker = L.divIcon({
            className: "custom-marker",
            html: `<div class="pin"></div>`,
            iconSize: [30, 42],
            iconAnchor: [15, 42],
            popupAnchor: [0, -35]
        });

        // Load GeoJSON
        fetch("{{ asset('data/cultural_map.geojson') }}")
            .then(res => res.json())
            .then(data => {
                let layerGroup = L.geoJSON(data, {
                    onEachFeature: function (feature, layer) {
                        if (feature.properties) {
                            let name = feature.properties.name ?? "Lokasi Budaya";
                            let description = feature.properties.description ?? "Informasi belum tersedia.";
                            let category = feature.properties.category ?? "Kategori tidak tersedia";
                            let location = feature.properties.location ?? "Lokasi tidak tersedia";
                            let image = feature.properties.image 
                                ? `/storage/${feature.properties.image}` 
                                : "https://via.placeholder.com/240x150?text=No+Image";

                            let coords = feature.geometry.coordinates;
                            let lat = coords[1];
                            let lng = coords[0];

                            let content = `
                                <div style="min-width:240px;">
                                    <h6>${name}</h6>
                                    <img src="${image}" alt="${name}" 
                                         style="width:100%; max-height:150px; object-fit:cover; border-radius:8px; margin-bottom:8px;">
                                    <p style="font-size: 13px;">${description}</p>
                                    <p style="font-size: 12px; margin:0;">
                                        <strong>Kategori:</strong> ${category}<br>
                                        <strong>Lokasi:</strong> ${location}
                                    </p>
                                    <div class="mt-2 d-flex justify-content-between">
                                        <a href="/cultural/${feature.properties.id}" 
                                           class="btn btn-sm btn-primary fw-bold btn-map">
                                           <i class="bi bi-box-arrow-up-right"></i> Lanjut »
                                        </a>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-primary fw-bold btn-map">
                                           <i class="bi bi-geo-alt-fill"></i> Rute »
                                        </a>
                                    </div>
                                </div>
                            `;

                            layer.bindPopup(content);

                            if (targetId && feature.properties.id == targetId) {
                                map.setView(layer.getLatLng(), 15);
                                setTimeout(() => layer.openPopup(), 500);
                            }
                        }
                    },
                    pointToLayer: function(feature, latlng) {
                        return L.marker(latlng, { icon: customMarker });
                    }
                }).addTo(map);

                // 🔍 Fitur Pencarian
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
