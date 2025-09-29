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

    .btn-map {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .btn-map img {
        width: 16px;
        height: 16px;
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

        // Ambil parameter dari URL
        let urlParams = new URLSearchParams(window.location.search);
        let searchQuery = urlParams.get('q') ? urlParams.get('q').toLowerCase() : null;
        let targetId = urlParams.get('cultural_id'); // parameter untuk popup marker

        // Load data GeoJSON
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

                            // Ambil koordinat untuk Google Maps
                            let coords = feature.geometry.coordinates;
                            let lat = coords[1];
                            let lng = coords[0];

                            let content = `
                                <div style="min-width:240px;">
                                    <h6 class="fw-bold text-primary mb-2">${name}</h6>
                                    <img src="${image}" alt="${name}" 
                                         style="width:100%; max-height:150px; object-fit:cover; border-radius:8px; margin-bottom:8px;">
                                    <p style="font-size: 13px; color:#555;">${description}</p>
                                    <p style="font-size: 12px; margin:0;">
                                        <strong>Kategori:</strong> ${category}<br>
                                        <strong>Lokasi:</strong> ${location}
                                    </p>
                                    <div class="mt-2 d-flex justify-content-between">
                                        <a href="/cultural/${feature.properties.id}" 
                                           class="btn btn-sm btn-warning text-dark fw-bold btn-map">
                                           <img src="https://cdn-icons-png.flaticon.com/512/271/271228.png" alt="Detail">
                                           Lanjut »
                                        </a>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-warning text-dark fw-bold btn-map">
                                           <img src="https://cdn-icons-png.flaticon.com/512/2875/2875433.png" alt="GMaps">
                                           Rute »
                                        </a>
                                    </div>
                                </div>
                            `;

                            layer.bindPopup(content);

                            // ✅ Buka popup otomatis jika cultural_id cocok
                            if (targetId && feature.properties.id == targetId) {
                                map.setView(layer.getLatLng(), 15);
                                setTimeout(() => layer.openPopup(), 500);
                            }
                        }
                    },
                    pointToLayer: function(feature, latlng) {
                        return L.marker(latlng, {
                            icon: L.icon({
                                iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
                                iconSize: [30, 30],
                                iconAnchor: [15, 30],
                                popupAnchor: [0, -30]
                            })
                        });
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
