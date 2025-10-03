@extends('layouts.app')

@section('title', 'Cari Pada Map')

@section('content')
<style>
    .search-hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: none; /* Hapus background hitam */
    }

    /* opsional: tambahkan overlay gradasi tipis supaya teks tetap jelas */
    .search-hero::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 1;
        background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.1));
    }

    .search-box {
        position: relative;
        z-index: 2; /* pastikan di atas overlay */
        background: rgba(47,58,74,0.95); /* dark elegan */
        padding: 40px 30px;
        border-radius: 15px;
        max-width: 700px;
        width: 90%;
        box-shadow: 0 6px 20px rgba(0,0,0,0.5);
        animation: fadeInDown 0.8s ease;
    }

    .search-box h2 {
        color: #42a5f5;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .search-box input {
        border-radius: 50px;
        padding: 14px 20px;
        font-size: 16px;
        border: 1px solid rgba(255,255,255,0.2);
        outline: none;
        width: 100%;
        background: #1c2531;
        color: #fff;
    }
    .search-box input::placeholder {
        color: #aaa;
    }

    .search-box button {
        margin-top: 20px;
        border-radius: 50px;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: bold;
    }

    .search-box p {
        margin-top: 15px;
        color: #ccc;
        font-size: 14px;
    }

    /* suggestion dropdown dark */
    .autocomplete-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #2f3a4a;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
    }
    .autocomplete-suggestion {
        padding: 10px 15px;
        cursor: pointer;
        text-align: left;
        color: #fff;
    }
    .autocomplete-suggestion:hover {
        background: #42a5f5;
        color: #000;
    }

    /* Tombol biru konsisten */
    .btn-primary {
        background: linear-gradient(135deg, #42a5f5, #1e88e5);
        border: none;
        border-radius: 50px;
        transition: all 0.3s ease;
        color: #fff !important;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #64b5f6, #2196f3);
        transform: scale(1.05);
        box-shadow: 0px 4px 12px rgba(66, 165, 245, 0.5);
    }
</style>

<div class="search-hero">
    <div class="search-box animate__animated animate__fadeInDown">
        <h2>Cari Budaya & Lokasi di Garut pada Peta</h2>
        <form action="{{ url('/map') }}" method="GET" autocomplete="off">
            <div style="position: relative;">
                <input type="text" id="searchInput" name="q" placeholder="Masukkan nama budaya atau lokasi...">
                <div id="suggestions" class="autocomplete-suggestions d-none"></div>
            </div>
            <button type="submit" class="btn btn-primary fw-bold mt-3">Cari Sekarang!</button>
        </form>
        <p>Contoh: <em>Candi Cangkuang, Kampung Pulo</em></p>
    </div>
</div>
@endsection
