@extends('layouts.app_admin')

@section('title', 'Edit Kebudayaan - Ngalalana')

@section('content')
<section class="py-5" style="background: url('{{ asset('image/babancong.jpg') }}') no-repeat center center/cover; position: relative;">
    <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.7);"></div>

    <div class="container position-relative text-light">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-softblue">
                <i class="bi bi-pencil-square me-2"></i> Edit Data Kebudayaan
            </h2>
            <a href="{{ route('admin.dashboard_admin') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Form Edit Kebudayaan -->
        <div class="card shadow-lg border-0 bg-dark bg-opacity-75 animate-fadeIn">
            <div class="card-body">
                <form id="culturalForm" action="{{ route('admin.cultural.update', $cultural->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-softblue">Nama Kebudayaan</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $cultural->name) }}" class="form-control bg-dark text-light border-softblue" required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold text-softblue">Kategori</label>
                        <input type="text" name="category" id="category" value="{{ old('category', $cultural->category) }}" class="form-control bg-dark text-light border-softblue" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-softblue">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="form-control bg-dark text-light border-softblue" required>{{ old('description', $cultural->description) }}</textarea>
                    </div>

                    <!-- Sejarah -->
                    <div class="mb-3">
                        <label for="history" class="form-label fw-semibold text-softblue">Sejarah</label>
                        <textarea name="history" id="history" rows="4" class="form-control bg-dark text-light border-softblue">{{ old('history', $cultural->history) }}</textarea>
                    </div>

                    <!-- Kondisi Sekarang -->
                    <div class="mb-3">
                        <label for="nowaday" class="form-label fw-semibold text-softblue">Kondisi Sekarang</label>
                        <textarea name="nowaday" id="nowaday" rows="3" class="form-control bg-dark text-light border-softblue">{{ old('nowaday', $cultural->nowaday) }}</textarea>
                    </div>

                    <!-- Acara Adat -->
                    <div class="mb-3">
                        <label for="cult_now" class="form-label fw-semibold text-softblue">Acara Kebudayaan yang Berlaku</label>
                        <textarea name="cult_now" id="cult_now" rows="3" class="form-control bg-dark text-light border-softblue">{{ old('cult_now', $cultural->cult_now) }}</textarea>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-3">
                        <label for="location" class="form-label fw-semibold text-softblue">Lokasi</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $cultural->location) }}" class="form-control bg-dark text-light border-softblue" required>
                    </div>

                    <!-- Video YouTube -->
                    <div class="mb-3">
                        <label for="video_url" class="form-label fw-semibold text-softblue">
                            <i class="bi bi-youtube me-1 text-danger"></i> URL Video YouTube (Opsional)
                        </label>
                        @if($cultural->video_url)
                            <div class="alert alert-info mb-2">
                                <small><strong>Video saat ini:</strong> <a href="{{ $cultural->video_url }}" target="_blank" class="text-white">{{ $cultural->video_url }}</a></small>
                            </div>
                        @endif
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $cultural->video_url) }}" class="form-control bg-dark text-light border-softblue" 
                               placeholder="Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                        <small class="text-muted d-block mt-2">Kosongkan untuk menghapus video. Masukkan URL YouTube lengkap baru untuk mengubah video.</small>
                    </div>

                    <!-- Checkbox Koordinat -->
                    <input type="hidden" name="has_map" value="0">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="hasMapCheckbox" name="has_map" value="1" {{ old('has_map', $cultural->has_map) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-softblue" for="hasMapCheckbox">
                            Centang jika kebudayaan ini <strong>memiliki titik koordinat</strong>
                        </label>
                    </div>

                    <!-- Peta -->
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
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', optional($cultural->mapdata)->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', optional($cultural->mapdata)->longitude) }}">
                    </div>

                    <!-- Thumbnail -->
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label fw-semibold text-softblue">Gambar Thumbnail</label>
                        <div id="thumbnailPreviewContainer" class="mb-2">
                            @if($cultural->image)
                                <div class="d-flex align-items-center">
                                    <img id="thumbnailPreview" src="{{ asset('storage/' . $cultural->image) }}" alt="Thumbnail" class="rounded me-3" width="150">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="removeThumbnailBtn">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control bg-dark text-light border-softblue" accept=".jpg,.jpeg,.png">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                        <input type="hidden" name="remove_thumbnail" id="removeThumbnailInput" value="0">
                    </div>

                    <!-- Gambar Tambahan -->
                    <div class="mb-4">
                        <label for="images" class="form-label fw-semibold text-softblue">Gambar Lainnya</label>
                        @if($cultural->galleries->count() > 0)
                            <div class="mb-2 d-flex flex-wrap gap-2">
                                @foreach($cultural->galleries as $gallery)
                                    <div class="position-relative text-center" style="width:120px;">
                                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery Image" class="rounded mb-1" style="width:100%; height:auto;">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button type="button" class="btn btn-sm btn-outline-warning replace-gallery-btn" data-id="{{ $gallery->id }}">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger remove-gallery-btn" data-id="{{ $gallery->id }}">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                        <input type="file" name="replace_gallery[{{ $gallery->id }}]" accept=".jpg,.jpeg,.png" class="d-none replace-input" id="replace-input-{{ $gallery->id }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div id="galleryInputs" class="mb-2"></div>
                        <button type="button" id="addImageBtn" class="btn btn-outline-light btn-sm mb-2">Tambah Gambar</button>
                        <small class="text-muted d-block mt-2">Biarkan kosong jika tidak ingin menambah gambar baru. Tambahkan gambar satu-per-satu.</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-softblue fw-semibold" onclick="openConfirmModal()">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
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
                    <i class="bi bi-exclamation-triangle me-2"></i> Konfirmasi Perubahan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="fs-5 mb-3 text-light">Apakah kamu yakin ingin menyimpan perubahan pada data ini?</p>
                <p class="small text-muted mb-0">Pastikan semua data sudah benar sebelum disimpan.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-cancel px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirmSaveBtn" class="btn btn-softblue px-4 fw-semibold">
                    <i class="bi bi-check-circle me-1"></i> Simpan
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
.btn-softblue { background: linear-gradient(135deg, #42a5f5, #1e88e5); border: none; color: #fff; transition: all 0.3s ease; }
.btn-softblue:hover { background: linear-gradient(135deg, #64b5f6, #2196f3); box-shadow: 0 0 10px rgba(66, 165, 245, 0.4); }
.btn-cancel { background: rgba(255,255,255,0.1); color:#ccc; border:1px solid rgba(255,255,255,0.2); }
.btn-cancel:hover { background: rgba(255,255,255,0.2); color:#fff; }
.soft-modal { background: rgba(20,20,20,0.8); backdrop-filter: blur(12px); border:1px solid rgba(66,165,245,0.3); }
.animate-fadeIn { animation: fadeIn 0.6s ease; }
@keyframes fadeIn { from { opacity:0; transform:translateY(10px);} to { opacity:1; transform:translateY(0);} }
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

    const initialLat = parseFloat(latHidden.value) || -7.2206;
    const initialLng = parseFloat(lngHidden.value) || 107.9087;
    const map = L.map(mapDiv).setView([initialLat, initialLng], (latHidden.value && lngHidden.value) ? 15 : 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;
    let mapEnabled = hasMapCheckbox.checked;

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

    // Plus Code support removed. Map uses direct latitude/longitude inputs.

    // Initialize display fields with existing coordinates
    if (latHidden.value && lngHidden.value) {
        updateLatLng(latHidden.value, lngHidden.value);
    }

    // Show/hide disabled message according to initial state
    if (!mapEnabled) {
        mapDisabledMsg.classList.remove('d-none');
    } else {
        mapDisabledMsg.classList.add('d-none');
    }

    // Load existing marker if coordinates exist
    if (latHidden.value && lngHidden.value) {
        const latlng = L.latLng(initialLat, initialLng);
        marker = L.marker(latlng, { draggable: true }).addTo(map);
        marker.on('dragend', (evt) => {
            const pos = evt.target.getLatLng();
            updateLatLng(pos.lat, pos.lng);
        });
        mapEnabled = true;
        hasMapCheckbox.checked = true;
    }

    // Map click handler - only when enabled
    map.on('click', (e) => {
        if (!mapEnabled) return;
        const { lat, lng } = e.latlng;
        
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng, { draggable: true }).addTo(map);
            marker.on('dragend', (evt) => {
                const pos = evt.target.getLatLng();
                updateLatLng(pos.lat, pos.lng);
            });
        }
        updateLatLng(lat, lng);
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

    // Note: Map click and manual coordinate inputs populate latitude and longitude.
    if (latDisplay) {
        latDisplay.addEventListener('change', function() {
            const lat = this.value.trim();
            if (lat) {
                latHidden.value = lat;
                const lng = lngDisplay.value.trim();
                if (lng) {
                    const latlng = L.latLng(Number(lat), Number(lng));
                    if (marker) {
                        marker.setLatLng(latlng);
                    } else {
                        marker = L.marker(latlng, { draggable: true }).addTo(map);
                        marker.on('dragend', (evt) => {
                            const pos = evt.target.getLatLng();
                            updateLatLng(pos.lat, pos.lng);
                        });
                    }
                    map.panTo(latlng);
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
                    const latlng = L.latLng(Number(lat), Number(lng));
                    if (marker) {
                        marker.setLatLng(latlng);
                    } else {
                        marker = L.marker(latlng, { draggable: true }).addTo(map);
                        marker.on('dragend', (evt) => {
                            const pos = evt.target.getLatLng();
                            updateLatLng(pos.lat, pos.lng);
                        });
                    }
                    map.panTo(latlng);
                }
            }
        });
    }

    // Ensure map renders correctly
    setTimeout(() => map.invalidateSize(), 300);

    // Tombol hapus thumbnail
    const removeBtn = document.getElementById('removeThumbnailBtn');
    const removeInput = document.getElementById('removeThumbnailInput');
    if (removeBtn) {
        removeBtn.addEventListener('click', () => {
            removeInput.value = '1';
            const container = removeBtn.parentElement;
            container.style.transition = 'all 0.3s ease-out';
            container.style.opacity = '0';
            container.style.transform = 'scale(0.95)';
            setTimeout(() => container.remove(), 300);
        });
    }

    // Thumbnail preview update when file is selected
    const thumbnailInput = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('thumbnailPreviewContainer');

    if (thumbnailInput) {
        thumbnailInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    let imgElement = document.getElementById('thumbnailPreview');
                    if (!imgElement) {
                        // Create new preview if it doesn't exist
                        const div = document.createElement('div');
                        div.className = 'd-flex align-items-center';
                        imgElement = document.createElement('img');
                        imgElement.id = 'thumbnailPreview';
                        imgElement.className = 'rounded me-3';
                        imgElement.style.width = '150px';
                        div.appendChild(imgElement);
                        previewContainer.innerHTML = '';
                        previewContainer.appendChild(div);
                    }
                    imgElement.src = e.target.result;
                    imgElement.style.outline = '2px solid rgba(66,165,245,0.6)';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Tombol hapus gallery
    document.querySelectorAll('.remove-gallery-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const galleryId = this.dataset.id;
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_galleries[]';
            input.value = galleryId;
            document.getElementById('culturalForm').appendChild(input);
            
            // Fade out and remove the image container smoothly
            const imageContainer = this.closest('.position-relative');
            imageContainer.style.transition = 'all 0.3s ease-out';
            imageContainer.style.opacity = '0';
            imageContainer.style.transform = 'scale(0.95)';
            setTimeout(() => imageContainer.remove(), 300);
        });
    });

    // Replace gallery images: trigger hidden file input and keep file for submission
    document.querySelectorAll('.replace-gallery-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const galleryId = this.dataset.id;
            const hiddenInput = document.getElementById(`replace-input-${galleryId}`);
            if (hiddenInput) {
                hiddenInput.click();
                hiddenInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const fileName = this.files[0].name;
                        console.log(`Ready to replace gallery ${galleryId} with ${fileName}`);
                    }
                });
            }
        });
    });

    // Dynamic gallery inputs: add new image input
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

    if (addImageBtn) {
        addImageBtn.addEventListener('click', createGalleryInput);
    }
});
</script>
@endpush
