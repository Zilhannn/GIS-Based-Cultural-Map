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
                    <img src="{{ asset('assets/Zilhan2.jpg') }}" alt="Foto Pengembang 1" 
                         class="rounded-circle mb-3 dev-photo" width="120">
                    <h6 class="fw-bold text-soft-strong">M. Zilhan Salman Ramadhan</h6>
                    <p style="text-align: center" class="text-soft mb-1">Fullstack Developer</p>
                    <small class="text-warning">@muhammad_zilhan</small>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <div class="team-card p-3 rounded shadow-sm animate__animated animate__zoomIn animate-delay-2">
                    <img src="{{ asset('assets/Galdiaz.jpg') }}" alt="Foto Pengembang 2" 
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
    /* Logos */
    .ngalalana-logo {
        max-width: 350px;
        height: auto;
        filter: drop-shadow(0 0 8px rgba(var(--darkgray-rgb), 0.4));
        transition: all 0.5s ease;
        cursor: pointer;
    }

    .campus-logo {
        max-width: 120px;
        height: auto;
        transition: all 0.5s ease;
    }

    .ngalalana-logo:hover,
    .campus-logo:hover {
        transform: scale(1.05);
        filter: drop-shadow(0 0 15px rgba(var(--softblue-rgb), 0.5));
    }

    /* Section layout */
    .about-section {
        min-height: 100vh;
        background: url("{{ asset('images/garut-bg.jpg') }}") no-repeat center center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .about-box {
        position: relative;
        z-index: 2;
        background: rgba(var(--darkgray-rgb), 0.95);
        padding: 50px 60px;
        border-radius: 15px;
        max-width: 1000px;
        width: 90%;
        box-shadow: 0 8px 25px rgba(var(--softblue-rgb), 0.2);
    }

    /* Text styles */
    .glow-text {
        text-shadow: 0 0 8px rgba(var(--softblue-rgb), 0.4);
        color: var(--softblue);
    }

    .text-soft {
        color: var(--lightgray) !important;
        line-height: 1.7;
        text-align: justify;
    }

    .text-soft-strong {
        color: rgba(255,255,255,0.9) !important;
    }

    /* Team cards */
    .team-card {
        background: rgba(var(--darkgray-rgb), 0.7);
        border: 1px solid rgba(var(--softblue-rgb), 0.2);
        border-radius: 12px;
        transition: all 0.4s ease;
    }

    .team-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 8px 25px rgba(var(--softblue-rgb), 0.3);
        background: rgba(var(--darkgray-rgb), 0.8);
    }

    .dev-photo {
        transition: all 0.4s ease;
        box-shadow: 0 0 12px rgba(var(--softblue-rgb), 0.2);
    }

    .dev-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(var(--softblue-rgb), 0.4);
    }

    /* Animations */
    .animate__animated {
        animation-duration: 0.8s;
    }

    .animate-delay-1 {
        animation-delay: 0.3s;
    }

    .animate-delay-2 {
        animation-delay: 0.6s;
    }

    /* Modal styles */
    .custom-modal {
        visibility: hidden;
        opacity: 0;
        transition: all 0.4s ease;
        display: flex;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
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
        background: var(--gradient-dark);
        padding: 30px 40px;
        border-radius: 15px;
        max-width: 700px;
        width: 90%;
        text-align: center;
        color: white;
        box-shadow: 0 8px 25px rgba(var(--softblue-rgb), 0.2);
        position: relative;
        animation-duration: 0.5s;
        max-height: 80vh;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

    .modal-content-custom::-webkit-scrollbar {
        width: 8px;
    }

    .modal-content-custom::-webkit-scrollbar-thumb {
        background: rgba(var(--softblue-rgb), 0.3);
        border-radius: 4px;
    }

    .modal-content-custom img {
        margin: 1.5rem 0;
        max-width: 180px;
        filter: drop-shadow(0 4px 12px rgba(var(--softblue-rgb), 0.3));
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        color: var(--lightgray);
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .close-btn:hover {
        color: #ff4444;
        transform: scale(1.1);
    }

    /* Philosophy list */
    .filosofi-list {
        text-align: left;
        padding: 1rem 0;
    }

    .filosofi-list p {
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .filosofi-list strong {
        color: var(--softblue);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .about-box {
            padding: 30px;
            width: 95%;
        }

        .team-card {
            margin-bottom: 1rem;
        }

        .ngalalana-logo {
            max-width: 280px;
        }

        .modal-content-custom {
            padding: 20px;
        }

        .filosofi-list {
            padding: 0.5rem 0;
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
