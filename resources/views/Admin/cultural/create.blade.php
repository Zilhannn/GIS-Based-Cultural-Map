@extends('layouts.app_admin')

@section('title', 'Tambah Kebudayaan Baru - Ngalalana')

@section('content')
<section class="py-5" style="background: url('{{ asset('image/babancong.jpg') }}') no-repeat center center/cover; position: relative;">
    <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.7);"></div>

    <div class="container position-relative text-light">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-softblue">
                <i class="bi bi-plus-circle me-2"></i> Tambah Kebudayaan Baru
            </h2>
            <a href="{{ route('admin.dashboard_admin') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Form Tambah Kebudayaan -->
        <div class="card shadow-lg border-0 bg-dark bg-opacity-75 animate-fadeIn">
            <div class="card-body">
                <form id="culturalForm" action="{{ route('admin.cultural.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-softblue">Nama Kebudayaan</label>
                        <input type="text" name="name" id="name" class="form-control bg-dark text-light border-softblue" placeholder="Masukkan nama kebudayaan" required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold text-softblue">Kategori</label>
                        <select name="category" id="category" class="form-select bg-dark text-light border-softblue" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Bangunan Bersejarah" {{ old('category') == 'Bangunan Bersejarah' ? 'selected' : '' }}>Bangunan Bersejarah</option>
                            <option value="Wisata Budaya" {{ old('category') == 'Wisata Budaya' ? 'selected' : '' }}>Wisata Budaya</option>
                            <option value="Kesenian" {{ old('category') == 'Kesenian' ? 'selected' : '' }}>Kesenian</option>
                            <option value="Museum" {{ old('category') == 'Museum' ? 'selected' : '' }}>Museum</option>
                            <option value="Produk Seni dan Budaya" {{ old('category') == 'Produk Seni dan Budaya' ? 'selected' : '' }}>Produk Seni dan Budaya</option>
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-softblue">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="form-control bg-dark text-light border-softblue" placeholder="Tuliskan deskripsi singkat..." required></textarea>
                    </div>

                    <!-- Sejarah -->
                    <div class="mb-3">
                        <label for="history" class="form-label fw-semibold text-softblue">Sejarah</label>
                        <textarea name="history" id="history" rows="4" class="form-control bg-dark text-light border-softblue" placeholder="Tuliskan sejarah kebudayaan..."></textarea>
                    </div>

                    <!-- Kondisi Sekarang -->
                    <div class="mb-3">
                        <label for="nowaday" class="form-label fw-semibold text-softblue">Kondisi Sekarang</label>
                        <textarea name="nowaday" id="nowaday" rows="3" class="form-control bg-dark text-light border-softblue" placeholder="Tuliskan kondisi saat ini..."></textarea>
                    </div>

                    <!-- Acara Adat dan Kebudayaan -->
                    <div class="mb-3">
                        <label for="cult_now" class="form-label fw-semibold text-softblue">Acara Kebudayaan yang Berlaku</label>
                        <textarea name="cult_now" id="cult_now" rows="3" class="form-control bg-dark text-light border-softblue" placeholder="Tuliskan adat kebudayaan yang berlaku di tempat tersebut..."></textarea>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-3">
                        <label for="location" class="form-label fw-semibold text-softblue">Lokasi</label>
                        <input type="text" name="location" id="location" class="form-control bg-dark text-light border-softblue" placeholder="Masukkan lokasi kebudayaan..." required>
                    </div>

                    <!-- Video YouTube -->
                    <div class="mb-3">
                        <label for="video_url" class="form-label fw-semibold text-softblue">
                            <i class="bi bi-youtube me-1 text-danger"></i> URL Video YouTube (Opsional)
                        </label>
                        <input type="url" name="video_url" id="video_url" class="form-control bg-dark text-light border-softblue" 
                               placeholder="Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                        <small class="text-muted d-block mt-2">Masukkan URL YouTube lengkap. Video akan ditampilkan di halaman detail kebudayaan.</small>
                    </div>

                    <!-- Checkbox Koordinat (hidden default + checkbox) -->
                    <!-- hidden ensures has_map=0 sent when unchecked -->
                    <input type="hidden" name="has_map" value="0">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="hasMapCheckbox" name="has_map" value="1">
                        <label class="form-check-label fw-semibold text-softblue" for="hasMapCheckbox">
                            Centang jika kebudayaan ini <strong>memiliki titik koordinat</strong> (aktifkan untuk menambahkan titik pada peta)
                        </label>
                    </div>

                    <!-- Peta Lokasi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-softblue">Tentukan Titik di Peta</label>
                        <div id="map" style="height: 400px; border-radius: 10px; border: 1px solid #42a5f5;"></div>
                        <small id="mapDisabledMessage" class="text-warning mt-2 d-none">
                            ⚠️ Peta dinonaktifkan — centang opsi "memiliki titik koordinat" untuk menambahkan titik.
                        </small>
                    </div>

                    <!-- Coordinate Inputs (only latitude & longitude) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-softblue">Koordinat</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-text text-muted small">Latitude</label>
                                <input type="text" id="latitude_display" class="form-control bg-dark text-light border-softblue" placeholder="Latitude (dapat diedit)" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-text text-muted small">Longitude</label>
                                <input type="text" id="longitude_display" class="form-control bg-dark text-light border-softblue" placeholder="Longitude (dapat diedit)" />
                            </div>
                        </div>

                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <small class="text-muted align-self-center">Klik peta untuk isi otomatis, atau masukkan koordinat secara manual.</small>
                        </div>

                        <!-- Hidden Latitude & Longitude (submitted) -->
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    </div>

                    <!-- Thumbnail -->
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label fw-semibold text-softblue">Gambar Thumbnail</label>
                        <div id="thumbnailPreviewContainer" class="mb-2"></div>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control bg-dark text-light border-softblue" accept=".jpg,.jpeg,.png" required>
                        <small class="text-muted">Format: JPG, PNG, JPEG</small>
                    </div>

                    <!-- Gambar Tambahan -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-softblue">Gambar Lainnya</label>
                        <div id="galleryInputs" class="mb-2">
                            <!-- dynamic inputs will be inserted here -->
                        </div>
                        <button type="button" id="addImageBtn" class="btn btn-outline-light btn-sm mb-2">Tambah Gambar</button>
                        <small class="text-muted d-block mt-2">Tambahkan gambar satu-per-satu. Anda dapat menambah beberapa gambar.</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-softblue fw-semibold" onclick="openConfirmModal()">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content soft-modal text-light shadow-lg border-0 rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold text-softblue">
                    <i class="bi bi-exclamation-triangle me-2"></i> Konfirmasi Penambahan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="fs-5 mb-3 text-light">Apakah kamu yakin ingin menambahkan data kebudayaan ini?</p>
                <p class="small text-muted mb-0">Pastikan semua data sudah benar sebelum disimpan.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-cancel px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirmSaveBtn" class="btn btn-softblue px-4 fw-semibold">
                    <i class="bi bi-check-circle me-1"></i> Tambahkan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
.text-softblue { color: #42a5f5 !important; }
.border-softblue { border-color: #42a5f5 !important; }
.btn-softblue {
    background: linear-gradient(135deg, #42a5f5, #1e88e5);
    border: none;
    color: #fff;
    transition: all 0.3s ease;
}
.btn-softblue:hover {
    background: linear-gradient(135deg, #64b5f6, #2196f3);
    box-shadow: 0 0 10px rgba(66, 165, 245, 0.4);
}
.btn-cancel {
    background: rgba(255, 255, 255, 0.1);
    color: #ccc;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}
.btn-cancel:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
}
.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(66, 165, 245, 0.25);
}
.soft-modal {
    background: rgba(20, 20, 20, 0.8);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(66, 165, 245, 0.3);
    animation: modalFade 0.35s ease-out;
}
@keyframes modalFade {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.6s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// === Modal ===
function openConfirmModal() {
    const modal = new bootstrap.Modal(document.getElementById('confirmSaveModal'));
    modal.show();
}

document.getElementById('confirmSaveBtn').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
    setTimeout(() => {
        document.getElementById('culturalForm').submit();
    }, 600);
});

// === Leaflet Map & Plus Code Logic ===
document.addEventListener('DOMContentLoaded', () => {
    const mapDiv = document.getElementById('map');
    const hasMapCheckbox = document.getElementById('hasMapCheckbox');
    const mapDisabledMsg = document.getElementById('mapDisabledMessage');
    const latHidden = document.getElementById('latitude');
    const lngHidden = document.getElementById('longitude');
    const latDisplay = document.getElementById('latitude_display');
    const lngDisplay = document.getElementById('longitude_display');

    // Initialize map - Koordinat pusat Kabupaten Garut, Jawa Barat, Indonesia
    const defaultCenter = [-7.2206, 107.9087];
    const map = L.map(mapDiv, { zoomControl: true }).setView(defaultCenter, 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;
    let mapEnabled = hasMapCheckbox.checked === true;

    // Show/hide disabled message according to initial state
    if (!mapEnabled) {
        mapDisabledMsg.classList.remove('d-none');
    } else {
        mapDisabledMsg.classList.add('d-none');
    }

    /**
     * Update display and hidden coordinate fields
     */
    function updateLatLng(lat, lng) {
        const latNum = Number(lat);
        const lngNum = Number(lng);
        
        if (latHidden) latHidden.value = latNum;
        if (lngHidden) lngHidden.value = lngNum;
        if (latDisplay) latDisplay.value = latNum.toFixed(6);
        if (lngDisplay) lngDisplay.value = lngNum.toFixed(6);
    }

    /**
     * Set marker and update coordinates
     */
    function setMarkerAt(lat, lng, pan = true) {
        const latNum = Number(lat);
        const lngNum = Number(lng);
        
        if (Number.isNaN(latNum) || Number.isNaN(lngNum)) {
            alert('Koordinat tidak valid. Gunakan angka desimal.');
            return;
        }

        const latlng = L.latLng(latNum, lngNum);
        
        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng, { draggable: true }).addTo(map);
            marker.on('dragend', (evt) => {
                const pos = evt.target.getLatLng();
                updateLatLng(pos.lat, pos.lng);
            });
        }

        if (pan) map.panTo(latlng);
        updateLatLng(latNum, lngNum);
    }



    // Map click handler - only when enabled
    map.on('click', (e) => {
        if (!mapEnabled) return;
        const { lat, lng } = e.latlng;
        setMarkerAt(lat, lng);
    });

    // Checkbox toggle
    hasMapCheckbox.addEventListener('change', function() {
        mapEnabled = this.checked;
        
        if (mapEnabled) {
            // Enable map
            mapDisabledMsg.classList.add('d-none');
        } else {
            // Disable map - clear coordinates
            if (latHidden) latHidden.value = '';
            if (lngHidden) lngHidden.value = '';
            if (latDisplay) latDisplay.value = '';
            if (lngDisplay) lngDisplay.value = '';
            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
            mapDisabledMsg.classList.remove('d-none');
        }
    });

    // Note: Plus Code UI removed. Map click and manual coordinate inputs populate latitude and longitude.

    // Allow manual editing of latitude/longitude fields and sync to hidden inputs
    if (latDisplay) {
        latDisplay.addEventListener('change', function() {
            const lat = this.value.trim();
            if (lat) {
                latHidden.value = lat;
                const lng = lngDisplay.value.trim();
                if (lng) {
                    setMarkerAt(lat, lng, true);
                }
            }
        });
    }

    if (lngDisplay) {
        lngDisplay.addEventListener('change', function() {
            const lng = this.value.trim();
            if (lng) {
                lngHidden.value = lng;
                const lat = latDisplay.value.trim();
                if (lat) {
                    setMarkerAt(lat, lng, true);
                }
            }
        });
    }

    // Ensure map renders correctly
    setTimeout(() => map.invalidateSize(), 300);

    // === Dynamic gallery inputs ===
    const galleryContainer = document.getElementById('galleryInputs');
    const addImageBtn = document.getElementById('addImageBtn');
    let galleryCounter = 0;

    function createGalleryInput() {
        galleryCounter++;
        const wrapper = document.createElement('div');
        wrapper.className = 'd-flex align-items-center gap-2 mb-2';
        wrapper.innerHTML = `
            <input type="file" name="images[]" accept=".jpg,.jpeg,.png" class="form-control bg-dark text-light border-softblue" />
            <button type="button" class="btn btn-sm btn-outline-danger remove-new-image">Hapus</button>
        `;
        galleryContainer.appendChild(wrapper);

        wrapper.querySelector('.remove-new-image').addEventListener('click', () => wrapper.remove());
    }

    addImageBtn.addEventListener('click', createGalleryInput);

    // Initialize with one gallery input
    if (galleryContainer.children.length === 0) createGalleryInput();

    // === Thumbnail preview ===
    const thumbnailInput = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('thumbnailPreviewContainer');

    if (thumbnailInput) {
        thumbnailInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded';
                    img.style.maxWidth = '150px';
                    img.style.marginBottom = '10px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>
@endpush
