@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="container-fluid about-section d-flex align-items-center justify-content-center">
    <div class="about-box text-center text-white animate__animated animate__fadeIn">
       <!-- Logo Ngalalana (klik untuk buka modal custom) -->
        <img src="{{ asset('assets/Ngalalana_icon5.png') }}" 
            alt="Logo Ngalalana" 
            class="ngalalana-logo mb-4 animate__animated animate__zoomIn animate-delay-1"
            onclick="openModal()">

        <!-- Custom Modal Filosofi Logo -->
        <div id="logoModal" class="custom-modal">
            <div class="modal-content-custom animate__animated" id="modalContent">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h5 class="fw-bold text-primary mb-3">Filosofi Logo Ngalalana</h5>
                <img src="{{ asset('assets/Ngalalana_icon2.png') }}" 
                    alt="Logo Besar" class="mb-3" style="max-width:180px;">
                <div class="text-soft text-start filosofi-list">
                <p>
                    Logo <strong>Ngalalana</strong> dirancang sebagai representasi dari kekayaan alam, budaya, dan kearifan lokal Garut.  
                    Setiap elemen di dalamnya memiliki makna mendalam:
                </p>
                <p><strong>Warna utama</strong> melambangkan keragaman tradisi, mulai dari seni, musik, hingga kuliner khas Garut.</p>
                <p><strong>Bentuk rumah</strong> mencerminkan kehangatan, kebersamaan, serta filosofi “ngariung” atau berkumpul dalam masyarakat.</p>
                <p><strong>Lengkung dan garis</strong> menggambarkan pegunungan dan sungai, simbol harmoni antara manusia dengan alam.</p>
                <p><strong>Simbol lingkaran</strong> menjadi tanda kesinambungan, bahwa warisan budaya akan terus dijaga lintas generasi.</p>
                <p>
                    Secara keseluruhan, logo ini bukan hanya identitas visual, melainkan juga cerminan jati diri Garut yang ramah, berbudaya, dan senantiasa menyatu dengan alamnya.  
                </p>
            </div>
            </div>
        </div>

        <p class="text-soft">
            <strong>N G A L A L A N A</strong> adalah sebuah platform interaktif yang bertujuan untuk memperkenalkan 
            sekaligus melestarikan kekayaan budaya Kabupaten Garut. Melalui peta digital yang interaktif, pengguna dapat 
            dengan mudah menelusuri beragam destinasi budaya, mulai dari situs sejarah, seni tradisional, kuliner khas, 
            hingga kearifan lokal masyarakat Garut.
        </p>
        <p class="text-soft">
            <strong>N G A L A L A N A</strong> juga menghadirkan deskripsi mendalam, 
            galeri foto, serta kisah di balik setiap budaya dan tradisi. Dengan pendekatan ini, platform ini diharapkan dapat 
            menjadi media edukasi, sarana promosi pariwisata, sekaligus upaya nyata dalam melestarikan identitas budaya Garut 
            bagi generasi sekarang dan yang akan datang.
        </p>

        <hr class="border-light my-4">

        <!-- LOGO KAMPUS -->
        <div class="mb-4">
            <img src="{{ asset('assets/ITG.png') }}" 
                 alt="Logo Kampus" 
                 class="campus-logo mb-3 shadow-sm animate__animated animate__zoomIn animate-delay-2">
            <h5 class="fw-bold text-primary glow-text">Tim Pengembang</h5>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-4 col-12 mb-4">
                <div class="team-card p-3 rounded shadow-sm animate__animated animate__zoomIn animate-delay-1">
                    <img src="https://via.placeholder.com/120" alt="Foto Pengembang 1" 
                         class="rounded-circle mb-3 dev-photo" width="120">
                    <h6 class="fw-bold text-soft-strong">M. Zilhan Salman Ramadhan</h6>
                    <p style="text-align: center" class="text-soft mb-1">Fullstack Developer</p>
                    <small class="text-warning">@muhammad_zilhan</small>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <div class="team-card p-3 rounded shadow-sm animate__animated animate__zoomIn animate-delay-2">
                    <img src="https://via.placeholder.com/120" alt="Foto Pengembang 2" 
                         class="rounded-circle mb-3 dev-photo" width="120">
                    <h6 class="fw-bold text-soft-strong">Moch. Galdiaz Nugraha Prawira</h6>
                    <p style="text-align: center" class="text-soft mb-1">GIS Developer</p>
                    <small class="text-warning">@galdiazngrhaaa_</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ngalalana-logo {
        max-width: 350px;
        height: auto;
        filter: drop-shadow(0 0 8px rgba(0,0,0,0.4));
        transition: transform 0.5s ease, filter 0.5s ease;
        cursor: pointer;
    }

    .campus-logo {
        max-width: 120px;
        height: auto;
        transition: transform 0.5s ease, filter 0.5s ease;
    }

    .ngalalana-logo:hover,
    .campus-logo:hover {
        transform: scale(1.05);
        filter: drop-shadow(0 0 12px rgba(13,110,253,0.5));
    }

    .about-section {
        min-height: 100vh;
        background: url("{{ asset('images/garut-bg.jpg') }}") no-repeat center center/cover;
        position: relative;
    }

    .about-box {
        position: relative;
        z-index: 2;
        background: rgba(0,0,0,0.75);
        padding: 50px 60px;
        border-radius: 15px;
        max-width: 1000px;
        width: 90%;
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }

    .glow-text {
        text-shadow: 0px 0px 6px rgba(13,110,253,0.6);
    }

    .text-soft {
        color: rgba(255,255,255,0.75) !important;
        line-height: 1.7;
        text-align: justify;
    }
    .text-soft-strong {
        color: rgba(255,255,255,0.9) !important;
    }

    .team-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.4s ease;
    }
    .team-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 0 15px rgba(13,110,253,0.4);
    }

    .dev-photo {
        transition: all 0.4s ease;
        box-shadow: 0 0 8px rgba(255,255,255,0.15);
    }
    .dev-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(13,110,253,0.5);
    }

    .animate__animated {
        animation-duration: 1s;
    }
    .animate-delay-1 {
        animation-delay: 0.3s;
    }
    .animate-delay-2 {
        animation-delay: 0.6s;
    }

    /* ===== Custom Modal ===== */
    .custom-modal {
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.4s ease, visibility 0.4s ease;
        display: flex;
        position: fixed;
        z-index: 9999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.65);
        backdrop-filter: blur(6px);
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .custom-modal.show {
        visibility: visible;
        opacity: 1;
    }

    .modal-content-custom {
        background: rgba(0,0,0,0.85);
        padding: 30px 40px;
        border-radius: 15px;
        max-width: 700px;   /* ukuran popup kembali normal */
        width: 90%;
        text-align: center;
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.6);
        position: relative;
        animation-duration: 0.5s;

        /* scrollable */
        max-height: 80vh;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

    /* scrollbar style */
    .modal-content-custom::-webkit-scrollbar {
        width: 8px;
    }
    .modal-content-custom::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 4px;
    }

    .modal-content-custom img {
        margin-top: 15px;
        margin-bottom: 25px;
    }

    .close-btn {
        position: absolute;
        top: 10px; right: 15px;
        color: #fff;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }
    .close-btn:hover {
        color: #ff4444;
    }

    .filosofi-list ul {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        list-style: none;
        padding-left: 0;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .filosofi-list ul li {
        flex: 1 1 45%;   /* jadi 2 kolom */
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.6;
        font-size: 0.95rem;
    }
    .filosofi-list ul li .icon {
        font-size: 1.2rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* Mobile fallback: 1 kolom */
    @media(max-width: 768px){
        .filosofi-list ul li {
            flex: 1 1 100%;
        }
    }
</style>

<script>
function openModal() {
    let modal = document.getElementById("logoModal");
    let content = document.getElementById("modalContent");
    modal.classList.add("show");               
    content.classList.remove("animate__zoomOut");
    content.classList.add("animate__zoomIn");
}

function closeModal() {
    let modal = document.getElementById("logoModal");
    let content = document.getElementById("modalContent");
    content.classList.remove("animate__zoomIn");
    content.classList.add("animate__zoomOut");
    setTimeout(() => { 
        modal.classList.remove("show");        
    }, 400);
}

window.onclick = function(event) {
    let modal = document.getElementById("logoModal");
    if (event.target === modal) {
        closeModal();
    }
}
</script>
@endsection
