@extends('layouts.app_admin')

@section('title', 'Maps Kebudayaan Admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="map-container">
        <h1 class="text-softblue text-center mb-3 fw-bold">Cultural Map Garut (Admin)</h1>
        <h5 class="text-light text-center mb-4 opacity-75">Kelola dan eksplorasi lokasi wisata budaya khas Garut melalui peta interaktif.</h5>
        <div id="map"></div>
    </div>
</div>

{{-- Overlay pencarian --}}
<div id="searchOverlay" class="d-none">
    <div class="overlay-backdrop"></div>
    <div class="overlay-box">
        <h5>Pencarian Tidak Ditemukan</h5>
        <p>Silakan coba kata kunci lain.</p>
        <button class="btn btn-primary fw-bold mt-2" onclick="closeOverlay()">Tutup</button>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content soft-modal text-light shadow-lg border-0 rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold text-softblue"><i class="bi bi-exclamation-triangle me-2 text-danger"></i> Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="fs-6 mb-2">Apakah Anda yakin ingin menghapus data "<strong id="deleteItemName">item</strong>" beserta semua gambarnya?</p>
                <p class="small text-muted mb-0">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-cancel px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnConfirmDelete" class="btn btn-softblue px-4 fw-semibold">Hapus</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Sukses Hapus --}}
<div class="modal fade" id="successDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content soft-modal text-light shadow-lg border-0 rounded-4 text-center py-4">
            <i class="bi bi-trash-fill text-danger fs-1 mb-3"></i>
            <h5 class="fw-semibold mb-2" id="successDeleteMessage">Data Berhasil Dihapus!</h5>
            <p class="small text-muted mb-0">Item telah dihapus dari sistem.</p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
    /* Map container */
    .map-container {
        background: rgba(var(--darkgray-rgb), 0.95);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 25px rgba(var(--softblue-rgb), 0.2);
    }

    #map {
        height: 80vh;
        width: 100%;
        border-radius: 12px;
        border: 2px solid var(--softblue);
        box-shadow: 0 0 20px rgba(var(--darkgray-rgb), 0.3);
    }

    /* Page headers */
    .judul-halaman {
        font-weight: 700;
        color: var(--softblue);
        text-shadow: 0 0 10px rgba(var(--softblue-rgb), 0.6);
    }

    .subjudul {
        color: var(--lightgray);
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    /* Map Marker */
    .custom-marker .pin {
        width: 24px;
        height: 24px;
        background: var(--softblue);
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -12px 0 0 -12px;
        box-shadow: 0 0 10px rgba(var(--softblue-rgb), 0.7);
    }
    
    .custom-marker .pin::after {
        content: '';
        width: 10px;
        height: 10px;
        background: #fff;
        border-radius: 50%;
        position: absolute;
        left: 7px;
        top: 7px;
    }

    /* Map Popup */
    .leaflet-popup-content-wrapper {
        background: var(--gradient-dark);
        color: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(var(--darkgray-rgb), 0.5);
    }

    .leaflet-popup-content {
        margin: 15px;
    }

    .leaflet-popup-content h6 {
        color: var(--softblue);
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 0 0 8px rgba(var(--softblue-rgb), 0.4);
    }

    .leaflet-popup-content p {
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 10px;
    }

    .leaflet-popup-content img {
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        transition: transform 0.3s ease;
    }

    .leaflet-popup-content img:hover {
        transform: scale(1.02);
    }

    /* Map Controls */
    .btn-map {
        background: var(--softblue);
        border: none;
        color: white !important;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-map:hover {
        background: var(--darkblue);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(var(--softblue-rgb), 0.3);
    }

    .btn-map i {
        font-size: 14px;
    }

    /* Search Overlay */
    #searchOverlay .overlay-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.7);
        backdrop-filter: blur(4px);
        z-index: 1040;
    }

    #searchOverlay .overlay-box {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: var(--gradient-dark);
        padding: 30px 40px;
        border-radius: 15px;
        color: #fff;
        text-align: center;
        z-index: 1050;
        box-shadow: 0 8px 25px rgba(var(--softblue-rgb), 0.2);
    }

    #searchOverlay button {
        background: var(--softblue);
        border: none;
        color: white;
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    #searchOverlay button:hover {
        background: var(--darkblue);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(var(--softblue-rgb), 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .map-container {
            padding: 15px;
        }
        
        #map {
            height: 70vh;
        }
        
        .judul-halaman {
            font-size: 1.8rem;
        }
        
        .subjudul {
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    function showOverlay() {
        document.getElementById("searchOverlay").classList.remove("d-none");
    }
    function closeOverlay() {
        document.getElementById("searchOverlay").classList.add("d-none");
    }

    // === Inisialisasi Map ===
    // Koordinat pusat Kabupaten Garut, Jawa Barat, Indonesia
    var map = L.map('map').setView([-7.2206, 107.9087], 12);

    // === Basemap ===
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors'
    }).addTo(map);

    // === Data dari Controller ===
    const culturalData = @json($culturalData);

    // === Parameter URL ===
    let urlParams = new URLSearchParams(window.location.search);
    let searchQuery = urlParams.get('q') ? urlParams.get('q').toLowerCase() : null;
    let targetId = urlParams.get('cultural_id');

    // === Custom Marker ===
    const customMarker = L.divIcon({
        className: "custom-marker",
        html: `<div class="pin"></div>`,
        iconSize: [30, 42],
        iconAnchor: [15, 42],
        popupAnchor: [0, -35]
    });

    // === Layer Marker ===
    let layerGroup = L.layerGroup().addTo(map);

    culturalData.forEach(item => {
        if (!item.latitude || !item.longitude) return;

        let lat = parseFloat(item.latitude);
        let lng = parseFloat(item.longitude);
        let image = item.image ? `/storage/${item.image}` : "https://via.placeholder.com/240x150?text=No+Image";

        let content = `
            <div style="min-width:240px;">
                <h6 class="text-softblue fw-bold">${item.name}</h6>
                <img src="${image}" alt="${item.name}"
                     style="width:100%; max-height:150px; object-fit:cover; border-radius:8px; margin-bottom:8px;">
                <p class="text-light opacity-75">${item.description ?? "Informasi belum tersedia."}</p>
                <p style="font-size: 12px; margin:0;" class="text-light opacity-75">
                    <span class="text-softblue">Kategori:</span> ${item.category ?? "-"}<br>
                    <span class="text-softblue">Lokasi:</span> ${item.location ?? "-"}
                </p>
                <div class="mt-2 d-flex justify-content-between gap-2">
                    <a href="/admin/cultural/${item.slug}/edit" class="btn btn-sm btn-map fw-bold flex-grow-1">
                       <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <button type="button" class="btn btn-sm btn-map fw-bold" onclick="openDeleteModal(${item.id}, '${item.slug}', '${item.name}')">
                       <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </div>
        `;

        let marker = L.marker([lat, lng], { icon: customMarker }).bindPopup(content);
        marker.addTo(layerGroup);

        if (targetId && item.id == targetId) {
            map.setView([lat, lng], 15);
            setTimeout(() => marker.openPopup(), 500);
        }
    });

    // === Pencarian ===
    if (searchQuery) {
        let found = culturalData.find(item =>
            item.name.toLowerCase().includes(searchQuery) ||
            (item.description && item.description.toLowerCase().includes(searchQuery))
        );

        if (found) {
            map.setView([found.latitude, found.longitude], 15);
            layerGroup.eachLayer(layer => {
                let latlng = layer.getLatLng();
                if (latlng.lat === found.latitude && latlng.lng === found.longitude) {
                    layer.openPopup();
                }
            });
        } else {
            showOverlay();
        }
    }

    // === Delete Modal ===
    let deleteSlug = null;
    let deleteName = null;

    function openDeleteModal(id, slug, name) {
        deleteSlug = slug;
        deleteName = name;
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        document.getElementById('deleteItemName').textContent = name;
        modal.show();
    }

    document.getElementById('btnConfirmDelete').addEventListener('click', function() {
        if (!deleteSlug) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/cultural/${deleteSlug}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    });

    @if(session('success_delete'))
        const successModal = new bootstrap.Modal(document.getElementById('successDeleteModal'));
        successModal.show();
        setTimeout(() => successModal.hide(), 2500);
    @endif
</script>
@endpush
