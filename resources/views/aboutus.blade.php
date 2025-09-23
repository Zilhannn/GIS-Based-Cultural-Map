@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="container-fluid about-section d-flex align-items-center justify-content-center">
    <div class="about-box text-center text-white">
        <h2 class="fw-bold mb-3">Tentang Cultural Map Garut</h2>
        <p class="text-muted">
            <strong>Cultural Map Garut</strong> adalah sebuah platform interaktif yang dirancang untuk memperkenalkan
            berbagai destinasi wisata budaya yang ada di Kabupaten Garut. 
            Dengan peta interaktif, pengguna dapat menjelajahi lokasi, melihat informasi singkat, 
            serta mengenal lebih dekat kekayaan tradisi dan kearifan lokal Garut.
        </p>

        <hr class="border-light my-4">

        <!-- LOGO KAMPUS -->
        <div class="mb-4">
            <img src="{{ asset('assets\ITG.png') }}" alt="Logo Kampus" class="campus-logo mb-3">
            <h5 class="fw-bold">Tim Pengembang</h5>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-4 col-12 mb-4">
                <div class="team-card p-3 rounded">
                    <img src="https://via.placeholder.com/120" alt="Foto Pengembang 1" class="rounded-circle mb-3" width="120">
                    <h6 class="fw-bold">M. Zilhan Salman Ramadhan</h6>
                    <p class="text-muted mb-1">Fullstack Developer</p>
                    <small class="text-warning">@muhammad_zilhan</small>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <div class="team-card p-3 rounded">
                    <img src="https://via.placeholder.com/120" alt="Foto Pengembang 2" class="rounded-circle mb-3" width="120">
                    <h6 class="fw-bold">Moch. Galdiaz Nugraha Prawira</h6>
                    <p class="text-muted mb-1">GIS Developer</p>
                    <small class="text-warning">@galdiazngrhaaa_</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .about-section {
        min-height: 100vh;
        background: url("{{ asset('images/garut-bg.jpg') }}") no-repeat center center/cover;
        position: relative;
    }

    .about-section::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 1;
    }

    .about-box {
        position: relative;
        z-index: 2;
        background: rgba(0,0,0,0.8); /* kotak hitam transparan */
        padding: 40px;
        border-radius: 15px;
        max-width: 800px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.7);
    }

    .team-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .campus-logo {
        max-width: 120px;
        height: auto;
    }
</style>
@endsection
