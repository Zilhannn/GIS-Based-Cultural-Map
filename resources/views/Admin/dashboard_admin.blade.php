@extends('layouts.app_admin')

@section('title', 'Dashboard Admin - Ngalalana')

@section('content')
<section class="py-5" style="background: url('{{ asset('image/babancong.jpg') }}') no-repeat center center/cover; position: relative;">
    <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.6);"></div>

    <div class="container position-relative text-light">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="fw-bold text-softblue mb-0">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
            </h2>
        </div>

        <!-- Statistik -->
        <div class="row g-4 mb-5">
            <!-- Admin Profile Card -->
            <div class="col-md-4">
                <div class="card stat-card text-center admin-profile-card shadow-lg">
                    <div class="card-body">
                        <div class="profile-avatar mb-3">
                            <i class="bi bi-person-circle fs-1 text-softblue"></i>
                        </div>
                        <h5 class="fw-semibold text-light mb-2">Admin Saat Ini</h5>
                        @if($adminUser)
                            <div class="profile-info">
                                <p class="fw-bold text-softblue mb-1 fs-6">{{ $adminUser->name }}</p>
                                <p class="text-muted small mb-0">{{ $adminUser->email }}</p>
                            </div>
                        @else
                            <p class="text-muted">—</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <i class="bi bi-bank2 fs-1 text-softblue"></i>
                        <h5 class="mt-3 fw-semibold">Total Kebudayaan</h5>
                        <p class="display-6 fw-bold text-softblue">{{ $totalCultural ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <i class="bi bi-image fs-1 text-softblue"></i>
                        <h5 class="mt-3 fw-semibold">Gambar Terunggah</h5>
                        <p class="display-6 fw-bold text-softblue">{{ $totalImages ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <i class="bi bi-clock-history fs-1 text-softblue"></i>
                        <h5 class="mt-3 fw-semibold">Aktivitas Terakhir</h5>
                        <p class="fw-bold text-light">{{ $latestActivity ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Kebudayaan -->
        <div class="card shadow-lg border-0 bg-dark bg-opacity-75 animate-fadeIn">
            <div class="card-header border-0 bg-softblue text-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-bank me-2"></i> Data Kebudayaan</h5>
                <a href="{{ url('/admin/cultural/create') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Baru
                </a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-dark table-hover align-middle mb-0 rounded-3 overflow-hidden">
                    <thead class="text-softblue">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($culturals as $index => $cultural)
                            <tr class="animate-row">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $cultural->name }}</td>
                                <td>{{ Str::limit($cultural->description, 80) }}</td>
                                <td style="width: 150px;">
                                    @if($cultural->image)
                                        <img src="{{ asset('storage/'.$cultural->image) }}" 
                                             alt="{{ $cultural->name }}" 
                                             class="img-fluid rounded shadow-sm" 
                                             style="height:80px; object-fit:cover;">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" 
                                             alt="Tidak ada gambar" 
                                             class="img-fluid rounded shadow-sm" 
                                             style="height:80px; object-fit:cover; opacity:0.6;">
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('/admin/cultural/'.$cultural->slug.'/edit') }}" 
                                       class="btn btn-sm btn-warning me-1">
                                       <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <button type="button" class="btn btn-sm btn-danger btn-softdelete"
                                            onclick="openDeleteModal('{{ $cultural->slug }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <!-- Form Delete -->
                                    <form id="delete-form-{{ $cultural->slug }}" 
                                          action="{{ route('admin.cultural.destroy', $cultural->slug) }}" 
                                          method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-exclamation-circle"></i> Belum ada data kebudayaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content soft-modal text-light shadow-lg border-0 rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold text-softblue">
                    <i class="bi bi-exclamation-triangle me-2"></i> Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="fs-5 mb-3 text-light">Apakah kamu yakin ingin menghapus data ini beserta semua gambarnya?</p>
                <p class="small text-muted mb-0">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-cancel px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-softblue px-4 fw-semibold">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Notifikasi -->
@if(session('success_create') || session('success_delete') || session('success_update') || session('success_login'))
@php
    // Prefer create, then update, then login, then delete for message source
    $notif = session('success_create') ?? session('success_update') ?? session('success_login') ?? session('success_delete');
    $isDelete = session('success_delete') ? true : false;
    $isUpdate = session('success_update') ? true : false;
    $isLogin = session('success_login') ? true : false;
@endphp
<div class="modal fade show" id="notifModal" tabindex="-1" aria-hidden="true" style="display:block;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content soft-modal text-light shadow-lg border-0 rounded-4 text-center py-4">
            <i class="bi {{ $isDelete ? 'bi-trash-fill text-danger' : ($isUpdate ? 'bi-check-circle-fill text-success' : ($isLogin ? 'bi-person-check-fill text-success' : 'bi-check-circle-fill text-softblue')) }} fs-1 mb-3"></i>
            <h5 class="fw-semibold mb-2">{!! $notif['title'] !!}</h5>
            <p class="text-muted small mb-0">{!! $notif['message'] !!}</p>
        </div>
    </div>
</div>
<script>
    setTimeout(() => {
        const modal = document.getElementById('notifModal');
        if(modal){ modal.remove(); }
    }, 2500);
</script>
@endif
@endsection

@push('styles')
<style>
/* Kartu Statistik - Spesifik untuk dashboard */
.stat-card {
    background: rgba(20, 20, 20, 0.7);
    border: 1px solid rgba(66, 165, 245, 0.25);
    border-radius: 1rem;
    transition: transform 0.3s ease, box-shadow 0.4s ease;
}
.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 0 20px rgba(66, 165, 245, 0.25);
}

/* Admin Profile Card - Spesifik */
.admin-profile-card {
    background: linear-gradient(135deg, rgba(66, 165, 245, 0.15) 0%, rgba(66, 165, 245, 0.05) 100%) !important;
    border: 2px solid rgba(66, 165, 245, 0.4) !important;
}
.admin-profile-card:hover {
    background: linear-gradient(135deg, rgba(66, 165, 245, 0.25) 0%, rgba(66, 165, 245, 0.1) 100%) !important;
    box-shadow: 0 0 30px rgba(66, 165, 245, 0.35) !important;
}
.admin-profile-card .profile-avatar {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60px;
    background: rgba(66, 165, 245, 0.1);
    border-radius: 50%;
    margin-left: auto;
    margin-right: auto;
}
.admin-profile-card .profile-info {
    padding-top: 0.5rem;
}

/* Animasi baris tabel */
.animate-row {
    animation: fadeRow 0.4s ease;
}
@keyframes fadeRow {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@push('scripts')
<script>
let deleteFormId = null;

function openDeleteModal(id) {
    deleteFormId = id;
    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    modal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteFormId) {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menghapus...';
        setTimeout(() => {
            document.getElementById(`delete-form-${deleteFormId}`).submit();
        }, 500);
    }
});
</script>
@endpush
