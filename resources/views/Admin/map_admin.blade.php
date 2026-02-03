@extends('layouts.app_admin')

@section('title', 'Maps Kebudayaan Admin')

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

{{-- Admin side panel --}}
<div id="sidePanelAdmin" aria-hidden="true">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h5 class="text-softblue fw-bold mb-0" id="sideAdminTitle">Detail Kebudayaan</h5>
        <button class="close-panel" onclick="closeSidePanelAdmin()">Tutup</button>
    </div>

    <img id="sideAdminImage" src="https://via.placeholder.com/400x200?text=No+Image" alt="Image">
    <div class="mb-2">
        <span id="sideAdminCategory" class="category-badge">-</span>
    </div>
    <p id="sideAdminLocation" class="text-muted small mb-2"></p>
    <p id="sideAdminDescription" class="text-light" style="white-space:pre-wrap;"></p>

    <div class="mt-3 d-flex gap-2">
        <a id="sideAdminEdit" href="#" class="btn btn-map flex-grow-1"><i class="bi bi-pencil-square me-1"></i> Edit</a>
        <button id="sideAdminDelete" type="button" class="btn btn-map btn-delete"><i class="bi bi-trash me-1"></i> Hapus</button>
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

    /* Side panel for marker details (admin) */
    #sidePanelAdmin {
        position: fixed;
        top: 0;
        right: 0;
        height: 100vh;
        width: 420px;
        background: linear-gradient(180deg, rgba(var(--darkgray-rgb),0.98), rgba(var(--darkgray-rgb),0.95));
        box-shadow: -6px 0 30px rgba(0,0,0,0.6);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        z-index: 1050;
        overflow-y: auto;
        padding: 24px;
    }

    #sidePanelAdmin.open {
        transform: translateX(0);
    }

    #sidePanelAdmin .close-panel {
        background: transparent;
        border: 1px solid rgba(var(--softblue-rgb),0.15);
        color: var(--softblue);
        padding: 6px 10px;
        border-radius: 6px;
    }

    #sidePanelAdmin img {
        width: 100%;
        height: 220px;
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

    .map-legend .legend-body { display: block; }
    .map-legend .legend-compact { display: none; }
    .map-legend.collapsed { width: auto; padding: 6px 8px; transform: translateY(-50%) scale(0.96); }
    .map-legend.collapsed .legend-body { display: none; }
    .map-legend.collapsed .legend-compact { display: block; }

    /* Draggable affordance */
    .map-legend { cursor: grab; }
    .map-legend:active { cursor: grabbing; }
    .map-legend .legend-header { cursor: move; }
    #legendHideToggleAdmin.active { background: rgba(255,255,255,0.95); color: #222; }

    @media (max-width: 768px) {
        .map-legend {
            top: 12px;
            left: 12px;
            transform: none;
            max-width: calc(100% - 24px);
        }
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

    .map-legend .legend-header {
        display:flex;
        gap:8px;
        align-items:center;
        justify-content:space-between;
        padding-bottom:6px;
    }
    .map-legend .legend-header h6 { margin: 0; font-size:13px; color:var(--softblue); font-weight:700; }
    .map-legend .legend-header .legend-controls { display:flex; gap:6px; align-items:center; }
    .map-legend .legend-header .btn { padding:6px 8px; min-width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; background: rgba(255,255,255,0.06); color:#fff; border:1px solid rgba(255,255,255,0.06); }
    .map-legend .legend-header .btn:hover { background: rgba(255,255,255,0.12); }
    .map-legend .row { display:flex; gap:8px; align-items:center; margin-bottom:6px; }
    .map-legend .swatch { width:14px; height:14px; border-radius:3px; display:inline-block; margin-right:8px; }

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
    /* Edit (yellow) and Delete (red) modifiers */
    .btn-map.btn-edit {
        background: #f6c23e; /* yellow */
        color: #1f1f1f !important;
    }

    .btn-map.btn-edit:hover {
        background: #e0ac2b;
        transform: scale(1.03);
        box-shadow: 0 6px 14px rgba(230, 184, 73, 0.25);
    }

    .btn-map.btn-delete {
        background: #e74a3b; /* red */
        color: #fff !important;
    }

    .btn-map.btn-delete:hover {
        background: #c43a2b;
        transform: scale(1.03);
        box-shadow: 0 6px 14px rgba(231, 74, 59, 0.25);
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
        
        .judul-halaman {
            font-size: 1.8rem;
        }
        
        .subjudul {
            font-size: 1rem;
        }
    }

    /* Fullscreen state for map (applies on toggle) */
    .map-fullscreen #map {
        position: fixed !important;
        inset: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        border-radius: 0 !important;
        border: 0 !important;
        z-index: 2000 !important;
        box-shadow: none !important;
        transition: all 280ms cubic-bezier(.2,.9,.2,1);
    }

    /* Slight map visual expansion when hiding UI for a smoother effect */
    .hide-ui #map {
        transform: scale(1.01);
        transition: transform 220ms ease;
    }

    /* Hide legend and make it animate when entering fullscreen or hide-ui */
    /* When UI is hidden (not fullscreen), hide the legend too */
    .hide-ui:not(.map-fullscreen) .map-legend {
        opacity: 0;
        transform: translateY(-12px) scale(0.98);
        pointer-events: none;
        transition: transform 0.22s ease, opacity 0.22s ease;
    }

    /* In fullscreen make the legend compact but keep it visible and usable */
    .map-fullscreen .map-legend {
        opacity: 1;
        transform: none;
        pointer-events: auto;
        max-width: 260px;
        transition: transform 0.22s ease, opacity 0.22s ease;
        /* ensure legend floats above the fullscreen map */
        position: fixed;
        top: 12px;
        left: 12px;
        z-index: 2200;
    }

    .map-fullscreen .map-legend .legend-body { display: none; }
    .map-fullscreen .map-legend .legend-compact { display: block; }


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

    // Admin: fullscreen controls are handled after map initialization (see below)


    // === Inisialisasi Map ===
    // Koordinat pusat Kabupaten Garut, Jawa Barat, Indonesia
    var map = L.map('map').setView([-7.2206, 107.9087], 12);

    // === Basemap (reverted to default OSM tiles to match public map) ===
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors',
        maxZoom: 19
    }).addTo(map);

    // === Admin fullscreen behavior (feature removed) ===
    let adminFS = false;
    function setAdminFS(enable) {
        // Fullscreen feature removed — keep adminFS state but only refresh map size.
        adminFS = !!enable;
        setTimeout(()=>{ try { map.invalidateSize(); } catch(e){} }, 260);
    }

    // Fullscreen toggle removed (no DOM handlers registered)


    document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && adminFS) setAdminFS(false); });

    // Auto fullscreen removed: map will occupy full viewport on mobile via CSS
    var enableAutoFullscreenAdmin = false; // automatic fullscreen disabled
    // No automatic fullscreen action; CSS enforces full-viewport map on small screens

    // === Data dari Controller ===
    const culturalData = @json($culturalData);

    // === Parameter URL ===
    let urlParams = new URLSearchParams(window.location.search);
    let searchQuery = urlParams.get('q') ? urlParams.get('q').toLowerCase() : null;
    let targetId = urlParams.get('cultural_id');

    // === Category colors (admin) ===
    const categoryColorsAdmin = {
        "Bangunan Bersejarah": "#e74a3b",
        "Wisata Budaya": "#f6c23e",
        "Kesenian": "#1cc88a",
        "Museum": "#36b9cc",
        "Produk Seni dan Budaya": "#6f42c1",
    };
    function getCategoryColorAdmin(cat) {
        if (!cat) return '#42a5f5';
        return categoryColorsAdmin[cat] || '#42a5f5';
    }

    // === Layer Marker ===
    let layerGroup = L.layerGroup().addTo(map);

    culturalData.forEach(item => {
        if (!item.latitude || !item.longitude) return;

        let lat = parseFloat(item.latitude);
        let lng = parseFloat(item.longitude);
        let image = item.image ? `/storage/${item.image}` : "https://via.placeholder.com/240x150?text=No+Image";

        let color = getCategoryColorAdmin(item.category);
        let iconHtml = `<div class="pin" style="background: ${color};"></div>`;
        let icon = L.divIcon({ className: "custom-marker", html: iconHtml, iconSize: [30, 42], iconAnchor: [15, 42], popupAnchor: [0, -35] });

        let marker = L.marker([lat, lng], { icon }).addTo(layerGroup);

        marker.on('click', () => {
            map.setView([lat, lng], 15);
            showSidePanelAdmin(item, color, lat, lng);
        });

        if (targetId && item.id == targetId) {
            map.setView([lat, lng], 15);
            setTimeout(() => showSidePanelAdmin(item, color, lat, lng), 500);
        }
    });

    // === Legend (admin) — collapsible (compact open button removed) ===
    const legendHTMLAdmin = `
        <div class="map-legend" id="mapLegendAdmin">
            <div class="legend-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Legenda</h6>
                <div class="legend-controls">
                    <button id="legendToggleAdmin" class="btn btn-sm btn-light" aria-label="Tutup legenda">−</button>
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
    document.body.insertAdjacentHTML('beforeend', legendHTMLAdmin);
    const legendElAdmin = document.getElementById('mapLegendAdmin');
    document.getElementById('legendToggleAdmin').addEventListener('click', () => {
        legendElAdmin.classList.toggle('collapsed');
    });

    // --- Admin: persistent Hide UI toggle and draggable legend
    const legendHideBtnAdmin = document.createElement('button');
    legendHideBtnAdmin.id = 'legendHideToggleAdmin';
    legendHideBtnAdmin.className = 'btn btn-sm btn-outline-light ms-2';
    legendHideBtnAdmin.title = 'Toggle header/footer visibility';
    legendHideBtnAdmin.innerHTML = '<i class="bi bi-eye-slash"></i>';
    legendElAdmin.querySelector('.legend-controls').appendChild(legendHideBtnAdmin);

    // Fullscreen button removed for admin map (map will occupy full viewport on mobile by default)

    let legendUIHiddenAdmin = localStorage.getItem('legendUIHiddenAdmin') === 'true';
    function setPersistentUIAdmin(hidden) {
        const navbar = document.querySelector('.navbar');
        const footer = document.getElementById('footer');
        if (hidden) {
            if (navbar) navbar.style.display = 'none';
            if (footer) footer.style.display = 'none';
            legendHideBtnAdmin.classList.add('active');
            legendHideBtnAdmin.innerHTML = '<i class="bi bi-eye"></i>';
        } else {
            if (navbar) navbar.style.display = '';
            if (footer) footer.style.display = '';
            legendHideBtnAdmin.classList.remove('active');
            legendHideBtnAdmin.innerHTML = '<i class="bi bi-eye-slash"></i>';
        }
        localStorage.setItem('legendUIHiddenAdmin', hidden);
        legendUIHiddenAdmin = hidden;
    }
    setPersistentUIAdmin(legendUIHiddenAdmin);
    legendHideBtnAdmin.addEventListener('click', () => setPersistentUIAdmin(!legendUIHiddenAdmin));

    // draggable admin legend
    legendElAdmin.style.touchAction = 'none';
    let isDraggingAdmin = false, dragOffsetXAdmin = 0, dragOffsetYAdmin = 0;
    function onDragStartAdmin(e) {
        if (e.target.closest('button')) return;
        isDraggingAdmin = true;
        const rect = legendElAdmin.getBoundingClientRect();
        legendElAdmin.style.left = rect.left + 'px';
        legendElAdmin.style.top = rect.top + 'px';
        legendElAdmin.style.transform = 'none';
        legendElAdmin.style.transition = 'none';
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        dragOffsetXAdmin = clientX - rect.left;
        dragOffsetYAdmin = clientY - rect.top;
        document.body.style.userSelect = 'none';
    }
    function onDragMoveAdmin(e) {
        if (!isDraggingAdmin) return;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        const rect = legendElAdmin.getBoundingClientRect();
        let newLeft = clientX - dragOffsetXAdmin;
        let newTop = clientY - dragOffsetYAdmin;
        newLeft = Math.max(8, Math.min(newLeft, window.innerWidth - rect.width - 8));
        newTop = Math.max(8, Math.min(newTop, window.innerHeight - rect.height - 8));
        legendElAdmin.style.left = newLeft + 'px';
        legendElAdmin.style.top = newTop + 'px';
    }
    function onDragEndAdmin() {
        if (!isDraggingAdmin) return;
        isDraggingAdmin = false;
        legendElAdmin.style.transition = 'transform 0.2s ease';
        document.body.style.userSelect = '';
        try { localStorage.setItem('legendPosAdmin', JSON.stringify({ left: legendElAdmin.style.left, top: legendElAdmin.style.top })); } catch (e) { }
    }
    legendElAdmin.addEventListener('mousedown', onDragStartAdmin);
    legendElAdmin.addEventListener('touchstart', onDragStartAdmin, { passive: true });
    document.addEventListener('mousemove', onDragMoveAdmin);
    document.addEventListener('touchmove', onDragMoveAdmin, { passive: true });
    document.addEventListener('mouseup', onDragEndAdmin);
    document.addEventListener('touchend', onDragEndAdmin);

    // restore admin legend position
    const savedAdmin = localStorage.getItem('legendPosAdmin');
    if (savedAdmin) {
        try {
            const pos = JSON.parse(savedAdmin);
            legendElAdmin.style.left = pos.left;
            legendElAdmin.style.top = pos.top;
            legendElAdmin.style.transform = 'none';
        } catch (e) { }
    }

    // === Hide header/footer on map interactions (admin, robust) ===
    let hideTimerAdmin = null;
    function triggerHideUIAdmin() {
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
            footer.style.display = 'none';
        }

        if (hideTimerAdmin) clearTimeout(hideTimerAdmin);
        hideTimerAdmin = setTimeout(() => {
            document.documentElement.classList.remove('hide-ui');
            if (navbar) navbar.style.transform = '';
            if (footer) {
                footer.style.transform = '';
                footer.style.display = '';
            }
        }, 1200);
    }
    map.on('movestart dragstart zoomstart', triggerHideUIAdmin);
    map.on('moveend dragend zoomend', () => {
        if (hideTimerAdmin) clearTimeout(hideTimerAdmin);
        hideTimerAdmin = setTimeout(() => {
            document.documentElement.classList.remove('hide-ui');
            const navbar = document.querySelector('.navbar');
            const footer = document.getElementById('footer');
            if (navbar) navbar.style.transform = '';
            if (footer) {
                footer.style.transform = '';
                // only restore display if admin legend hasn't set persistent hide
                if (!legendUIHiddenAdmin) footer.style.display = '';
            }
        }, 1000);
    });
    const mapElAdmin = document.getElementById('map');
    if (mapElAdmin) {
        mapElAdmin.addEventListener('wheel', () => triggerHideUIAdmin(), { passive: true });
        mapElAdmin.addEventListener('touchstart', () => triggerHideUIAdmin(), { passive: true });
    }

    // === Pencarian updated to use side panel ===
    if (searchQuery) {
        let found = culturalData.find(item =>
            item.name.toLowerCase().includes(searchQuery) ||
            (item.description && item.description.toLowerCase().includes(searchQuery))
        );

        if (found) {
            map.setView([found.latitude, found.longitude], 15);
            setTimeout(() => showSidePanelAdmin(found, getCategoryColorAdmin(found.category), found.latitude, found.longitude), 400);
        } else {
            showOverlay();
        }
    }


    // === Delete Modal & admin side panel handlers ===
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

    function showSidePanelAdmin(item, color, lat, lng) {
        document.getElementById('sideAdminTitle').textContent = item.name;
        document.getElementById('sideAdminImage').src = item.image ? `/storage/${item.image}` : 'https://via.placeholder.com/400x200?text=No+Image';
        const catEl = document.getElementById('sideAdminCategory');
        catEl.textContent = item.category ?? '-';
        catEl.style.background = color;
        document.getElementById('sideAdminLocation').textContent = item.location ?? '-';
        document.getElementById('sideAdminDescription').textContent = item.description ?? 'Informasi belum tersedia.';
        document.getElementById('sideAdminEdit').href = `/admin/cultural/${item.slug}/edit`;
        document.getElementById('sideAdminDelete').onclick = () => openDeleteModal(item.id, item.slug, item.name);
        document.getElementById('sidePanelAdmin').classList.add('open');
        document.getElementById('sidePanelAdmin').setAttribute('aria-hidden', 'false');
    }

    function closeSidePanelAdmin() {
        document.getElementById('sidePanelAdmin').classList.remove('open');
        document.getElementById('sidePanelAdmin').setAttribute('aria-hidden', 'true');
    }

    @if(session('success_delete') || session('deleted'))
        const successModal = new bootstrap.Modal(document.getElementById('successDeleteModal'));
        @if(session('deleted'))
            // If redirected from map delete, controller sets 'deleted' => ['name' => $name]
            document.getElementById('successDeleteMessage').textContent = `Data "${ @json(session('deleted.name')) }" berhasil dihapus!`;
        @elseif(session('success_delete'))
            // Backwards compatibility: use the previous 'success_delete' flash
            document.getElementById('successDeleteMessage').textContent = @json(session('success_delete.title')) || 'Data Berhasil Dihapus!';
        @endif
        successModal.show();
        setTimeout(() => successModal.hide(), 2500);
    @endif
</script>
@endpush
