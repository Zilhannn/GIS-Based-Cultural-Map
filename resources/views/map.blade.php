@extends('layouts.app')

@section('title', 'Cultural Map')

@section('content')
<div id="map"></div>

{{-- Overlay pencarian --}}
<div id="searchOverlay" class="d-none">
    <div class="overlay-backdrop"></div>
    <div class="overlay-box">
        <h5>Pencarian Tidak Ditemukan</h5>
        <p>Silakan coba kata kunci lain.</p>
        <button class="btn btn-primary fw-bold mt-2" onclick="closeOverlay()">Tutup</button>
    </div>
</div>

{{-- Side panel for details (appears when a marker is clicked) --}}
<div id="sidePanel" aria-hidden="true">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h5 class="text-softblue fw-bold mb-0" id="sideTitle">Detail Kebudayaan</h5>
        <button class="close-panel" onclick="closeSidePanel()">Tutup</button>
    </div>

    <img id="sideImage" src="https://via.placeholder.com/400x200?text=No+Image" alt="Image">
    <div class="mb-2">
        <span id="sideCategory" class="category-badge">-</span>
    </div>
    <p id="sideLocation" class="text-muted small mb-2"></p>
    <p id="sideDescription" class="text-light" style="white-space:pre-wrap;"></p>

    <div class="mt-3 d-flex gap-2">
        <a id="sideDetailLink" href="#" class="btn btn-map flex-grow-1"><i class="bi bi-box-arrow-up-right me-1"></i> Lihat</a>
        <a id="sideRouteLink" href="#" target="_blank" class="btn btn-map"><i class="bi bi-geo-alt-fill me-1"></i> Rute</a>
    </div>
</div>

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

    /* Full-screen map */
    /* Full-viewport map (edge-to-edge) */
    #map {
        position: fixed;
        inset: 0;
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
        border: 0;
        border-radius: 0;
        z-index: 0;
    }

    /* Side panel for marker details */
    #sidePanel {
        position: fixed;
        top: 0;
        right: 0;
        height: 100vh;
        width: 380px;
        background: linear-gradient(180deg, rgba(var(--darkgray-rgb),0.98), rgba(var(--darkgray-rgb),0.95));
        box-shadow: -6px 0 30px rgba(0,0,0,0.6);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        z-index: 1050;
        overflow-y: auto;
        padding: 24px;
    }

    #sidePanel.open {
        transform: translateX(0);
    }

    #sidePanel .close-panel {
        background: transparent;
        border: 1px solid rgba(var(--softblue-rgb),0.15);
        color: var(--softblue);
        padding: 6px 10px;
        border-radius: 6px;
    }

    /* Hide header/footer while interacting with the map */
    .hide-ui .navbar {
        transform: translateY(-100%);
        transition: transform 0.25s ease;
    }

    .hide-ui #footer {
        transform: translateY(100%);
        transition: transform 0.25s ease;
    }

    /* Legend */
    .map-legend {
        position: absolute;
        /* vertically centered at left side to avoid overlapping zoom controls */
        top: 50%;
        left: 74px;
        transform: translateY(-50%);
        background: rgba(var(--darkgray-rgb),0.95);
        color: #fff;
        padding: 10px 12px;
        border-radius: 8px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.4);
        z-index: 1100;
        font-size: 13px;
        max-width: 260px;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    /* Hidden state during map drag/idle transitions */
    .map-legend.legend-hidden {
        opacity: 0;
        /* nudge slightly upward while maintaining the centered transform */
        transform: translateY(-50%) translateY(-6px) !important;
        pointer-events: none;
    }

    .map-legend .legend-header {
        display:flex;
        gap:8px;
        align-items:center;
        justify-content:space-between;
        padding-bottom: 6px;
    }
    .map-legend .legend-header h6 {
        margin: 0;
        font-size: 13px;
        color: var(--softblue);
        font-weight: 700;
    }
    .map-legend .legend-header .legend-controls {
        display:flex;
        gap:6px;
        align-items:center;
    }
    .map-legend .legend-header .btn {
        padding: 6px 8px;
        min-width:34px;
        height:34px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border-radius:8px;
        background: rgba(255,255,255,0.06);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.06);
        line-height: 1;
    }
    .map-legend .legend-header .btn:hover {
        background: rgba(255,255,255,0.12);
    }
    .map-legend .legend-header .btn i { font-size:14px; }

    .map-legend .row { display:flex; gap:8px; align-items:center; margin-bottom:6px; }
    .map-legend .swatch { width:14px; height:14px; border-radius:3px; display:inline-block; margin-right:8px; }

    /* Legend collapsed state */
    .map-legend .legend-body { display: block; }
    .map-legend .legend-compact { display: none; }

    .map-legend.collapsed {
        width: auto;
        padding: 6px 8px;
        transform: translateY(-50%) scale(0.96);
    }
    .map-legend.collapsed .legend-body { display: none; }
    .map-legend.collapsed .legend-compact { display: block; }

    /* Draggable affordance */
    .map-legend { cursor: grab; }
    .map-legend:active { cursor: grabbing; }
    .map-legend .legend-header { cursor: move; }
    #legendHideToggle.active, #legendHideToggleAdmin.active { background: rgba(255,255,255,0.95); color: #222; }

    /* Responsive: move legend to top-left for small screens */
    @media (max-width: 768px) {
        .map-legend {
            top: 12px;
            left: 12px;
            transform: none;
            max-width: calc(100% - 24px);
        }
    }

    /* Hide header/footer while interacting with the map (explicit classes) */
    .hide-ui .navbar {
        transform: translateY(-100%);
        transition: transform 0.25s ease;
    }

    .hide-ui #footer {
        transform: translateY(100%);
        transition: transform 0.25s ease;
    }

    /* Fallback: direct hide class on elements */
    .navbar.hide {
        transform: translateY(-100%);
        transition: transform 0.25s ease;
    }

    #footer.hide {
        transform: translateY(100%);
        transition: transform 0.25s ease;
    }

    #sidePanel img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .category-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
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

    // === Basemap (reverted to default OSM tiles) ===
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors',
        maxZoom: 19
    }).addTo(map);

    // === Data dari Controller ===
    const culturalData = @json($culturalData);

    // === Parameter URL ===
    let urlParams = new URLSearchParams(window.location.search);
    let searchQuery = urlParams.get('q') ? urlParams.get('q').toLowerCase() : null;
    let targetId = urlParams.get('cultural_id');

    // === Category colors ===
    const categoryColors = {
        "Bangunan Bersejarah": "#e74a3b",
        "Wisata Budaya": "#f6c23e",
        "Kesenian": "#1cc88a",
        "Museum": "#36b9cc",
        "Produk Seni dan Budaya": "#6f42c1",
    };
    function getCategoryColor(cat) {
        if (!cat) return '#42a5f5';
        return categoryColors[cat] || '#42a5f5';
    }

    // === Layer Marker ===
    let layerGroup = L.layerGroup().addTo(map);

    culturalData.forEach(item => {
        if (!item.latitude || !item.longitude) return;

        let lat = parseFloat(item.latitude);
        let lng = parseFloat(item.longitude);
        let image = item.image ? `/storage/${item.image}` : "https://via.placeholder.com/240x150?text=No+Image";

        let color = getCategoryColor(item.category);
        let iconHtml = `<div class="pin" style="background: ${color}; box-shadow: 0 2px 10px rgba(0,0,0,0.25);"></div>`;
        let icon = L.divIcon({ className: "custom-marker", html: iconHtml, iconSize: [30, 42], iconAnchor: [15, 42], popupAnchor: [0, -35] });

        let marker = L.marker([lat, lng], { icon }).addTo(layerGroup);

        marker.on('click', () => {
            map.setView([lat, lng], 15);
            showSidePanel(item, color, lat, lng);
        });

        if (targetId && item.id == targetId) {
            map.setView([lat, lng], 15);
            setTimeout(() => showSidePanel(item, color, lat, lng), 500);
        }
    });

    // === Add Legend DOM (collapsible but always toggle-able) ===
    const legendHTML = `
        <div class="map-legend" id="mapLegend">
            <div class="legend-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Legenda</h6>
                <div class="legend-controls">
                    <button id="legendToggle" class="btn btn-sm btn-light" aria-label="Tutup legenda">−</button>
                </div>
            </div>
            <div class="legend-body">
                <div class="row"><span class="swatch" style="background:#e74a3b"></span> Bangunan Bersejarah</div>
                <div class="row"><span class="swatch" style="background:#f6c23e"></span> Wisata Budaya</div>
                <div class="row"><span class="swatch" style="background:#1cc88a"></span> Kesenian</div>
                <div class="row"><span class="swatch" style="background:#36b9cc"></span> Museum</div>
                <div class="row"><span class="swatch" style="background:#6f42c1"></span> Produk Seni dan Budaya</div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', legendHTML);
    const legendEl = document.getElementById('mapLegend');
    const legendToggleBtn = document.getElementById('legendToggle');
    legendToggleBtn.addEventListener('click', () => {
        // collapse but keep a compact header visible (no separate open button)
        legendEl.classList.toggle('collapsed');
    });

    // --- Add persistent "Hide UI" toggle to legend header (stores state in localStorage)
    const legendHideBtn = document.createElement('button');
    legendHideBtn.id = 'legendHideToggle';
    legendHideBtn.className = 'btn btn-sm btn-outline-light ms-2';
    legendHideBtn.title = 'Toggle header/footer visibility';
    legendHideBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
    legendEl.querySelector('.legend-controls').appendChild(legendHideBtn);

    // persistent state
    let legendUIHidden = localStorage.getItem('legendUIHidden') === 'true';
    function setPersistentUI(hidden) {
        const navbar = document.querySelector('.navbar');
        const footer = document.getElementById('footer');
        if (hidden) {
            if (navbar) navbar.style.display = 'none';
            if (footer) footer.style.display = 'none';
            legendHideBtn.classList.add('active');
            legendHideBtn.innerHTML = '<i class="bi bi-eye"></i>';
        } else {
            if (navbar) navbar.style.display = '';
            if (footer) footer.style.display = '';
            legendHideBtn.classList.remove('active');
            legendHideBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
        }
        localStorage.setItem('legendUIHidden', hidden);
        legendUIHidden = hidden;
    }
    setPersistentUI(legendUIHidden);
    legendHideBtn.addEventListener('click', () => setPersistentUI(!legendUIHidden));

    // --- Make legend draggable (mouse + touch) and remember position
    legendEl.style.touchAction = 'none'; // prevent touch gestures interfering
    let isDragging = false, dragOffsetX = 0, dragOffsetY = 0;
    function onDragStart(e) {
        // don't start drag when clicking a button inside the legend
        if (e.target.closest('button')) return;
        isDragging = true;
        const rect = legendEl.getBoundingClientRect();
        // switch to pixel positioning
        legendEl.style.left = rect.left + 'px';
        legendEl.style.top = rect.top + 'px';
        legendEl.style.transform = 'none';
        legendEl.style.transition = 'none';
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        dragOffsetX = clientX - rect.left;
        dragOffsetY = clientY - rect.top;
        document.body.style.userSelect = 'none';
    }
    function onDragMove(e) {
        if (!isDragging) return;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        const rect = legendEl.getBoundingClientRect();
        let newLeft = clientX - dragOffsetX;
        let newTop = clientY - dragOffsetY;
        // clamp within viewport
        newLeft = Math.max(8, Math.min(newLeft, window.innerWidth - rect.width - 8));
        newTop = Math.max(8, Math.min(newTop, window.innerHeight - rect.height - 8));
        legendEl.style.left = newLeft + 'px';
        legendEl.style.top = newTop + 'px';
    }
    function onDragEnd() {
        if (!isDragging) return;
        isDragging = false;
        legendEl.style.transition = 'transform 0.2s ease';
        document.body.style.userSelect = '';
        try { localStorage.setItem('legendPos', JSON.stringify({ left: legendEl.style.left, top: legendEl.style.top })); } catch (e) { /* ignore */ }
    }
    legendEl.addEventListener('mousedown', onDragStart);
    legendEl.addEventListener('touchstart', onDragStart, { passive: true });
    document.addEventListener('mousemove', onDragMove);
    document.addEventListener('touchmove', onDragMove, { passive: true });
    document.addEventListener('mouseup', onDragEnd);
    document.addEventListener('touchend', onDragEnd);

    // restore saved position
    const saved = localStorage.getItem('legendPos');
    if (saved) {
        try {
            const pos = JSON.parse(saved);
            legendEl.style.left = pos.left;
            legendEl.style.top = pos.top;
            legendEl.style.transform = 'none';
        } catch (e) { /* ignore */ }
    }

    // === Hide header/footer on map interactions (robust) ===
    let hideTimer = null;
    function triggerHideUI() {
        document.documentElement.classList.add('hide-ui');
        const navbar = document.querySelector('.navbar');
        const footer = document.getElementById('footer');
        if (navbar) {
            navbar.style.transition = navbar.style.transition || 'transform 0.25s ease';
            navbar.style.transform = 'translateY(-100%)';
        }
        if (footer) {
            footer.style.transition = footer.style.transition || 'transform 0.25s ease';
            footer.style.transform = 'translateY(100%)';
            // hide it fully (remove from layout stack while interacting with map)
            footer.style.display = 'none';
        }

        if (hideTimer) clearTimeout(hideTimer);
        hideTimer = setTimeout(() => {
            document.documentElement.classList.remove('hide-ui');
            if (navbar) navbar.style.transform = '';
            if (footer) {
                footer.style.transform = '';
                footer.style.display = '';
            }
        }, 1200);
    }

    map.on('movestart dragstart zoomstart', triggerHideUI);

    // Hide legend while the user drags the map; restore when drag ends or map becomes idle
    map.on('dragstart', () => {
        // don't hide if the user is dragging the legend itself
        if (!isDragging) {
            legendEl.classList.add('legend-hidden');
        }
    });

    map.on('dragend', () => {
        // restore legend right after drag ends
        legendEl.classList.remove('legend-hidden');
    });

    map.on('moveend dragend zoomend', () => {
        // keep hidden briefly for smooth experience
        if (hideTimer) clearTimeout(hideTimer);
        hideTimer = setTimeout(() => {
            document.documentElement.classList.remove('hide-ui');
            const navbar = document.querySelector('.navbar');
            const footer = document.getElementById('footer');
            if (navbar) navbar.style.transform = '';
            if (footer) {
                footer.style.transform = '';
                // only restore display if the legend hasn't set persistent hide
                if (!legendUIHidden) footer.style.display = '';
            }
        }, 1000);

        // Map is now idle — make sure the legend is visible
        legendEl.classList.remove('legend-hidden');
    });

    // also hide on user wheel/touch on map
    const mapEl = document.getElementById('map');
    if (mapEl) {
        mapEl.addEventListener('wheel', () => triggerHideUI(), { passive: true });
        mapEl.addEventListener('touchstart', () => triggerHideUI(), { passive: true });
    }

    // === Pencarian ===
    if (searchQuery) {
        let found = culturalData.find(item =>
            item.name.toLowerCase().includes(searchQuery) ||
            (item.description && item.description.toLowerCase().includes(searchQuery))
        );

        if (found) {
            map.setView([found.latitude, found.longitude], 15);
            // open side panel for the found item
            setTimeout(() => showSidePanel(found, getCategoryColor(found.category), found.latitude, found.longitude), 400);
        } else {
            showOverlay();
        }
    }

    // === Side panel functions ===
    function showSidePanel(item, color, lat, lng) {
        document.getElementById('sideTitle').textContent = item.name;
        document.getElementById('sideImage').src = item.image ? `/storage/${item.image}` : 'https://via.placeholder.com/400x200?text=No+Image';
        const catEl = document.getElementById('sideCategory');
        catEl.textContent = item.category ?? '-';
        catEl.style.background = color;
        document.getElementById('sideLocation').textContent = item.location ?? '-';
        document.getElementById('sideDescription').textContent = item.description ?? 'Informasi belum tersedia.';
        document.getElementById('sideDetailLink').href = `/cultural/${item.slug}`;
        document.getElementById('sideRouteLink').href = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
        document.getElementById('sidePanel').classList.add('open');
        document.getElementById('sidePanel').setAttribute('aria-hidden', 'false');
    }

    function closeSidePanel() {
        document.getElementById('sidePanel').classList.remove('open');
        document.getElementById('sidePanel').setAttribute('aria-hidden', 'true');
    }
</script>
@endpush
@endsection