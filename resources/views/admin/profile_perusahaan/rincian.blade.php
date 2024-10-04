@extends('layouts.panel.index')

@section('content')

@push('style')
<style>
    .section__container {
        padding: 30px;
    }

    .header p {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .header h1 {
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: #222;
    }

    /* Profile Grid */
    .profile__grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
    }

    /* Profile Item Card */
    .profile-item {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 100%;
        width: 100%;
        max-width: 600px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .profile-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    /* Profile Image */
    .profile-image {
        display: block;
        max-width: 100%;
        height: auto;
        margin: 0 auto;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    /* Profile Details */
    .profile-details {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
    }

    /* Back Button */
    .back-button {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
        display: flex;
        align-items: center;
    }

    .back-button i {
        margin-right: 8px; /* Space between icon and text */
    }

    .back-button:hover {
        background-color: #0056b3;
    }
</style>
@endpush
   <!-- Back Button with Icon -->
   <div class="text-center">
        <button class="back-button" onclick="window.history.back();">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
    </div>
</div>
<div class="section__container mt-5">
    <div class="header">
        <p>PROFIL PERUSAHAAN</p>
        <h1>STRUKTUR ORGANISASI</h1>
    </div>

    <div class="profile__grid">
        <div class="profile-item">
            @if ($profil->path_struktur_organisasi)
                <img src="{{ asset('storage/' . $profil->path_struktur_organisasi) }}" alt="Struktur Organisasi" class="profile-image">
            @endif

            <div class="profile-details">
                <p><strong>Tentang Kami:</strong> {!! preg_replace('/<p>|<\/p>/', '', $profil->tentang_kami) !!}</p>
                <p><strong>Visi:</strong> {!! preg_replace('/<p>|<\/p>/', '', $profil->visi) !!}</p>
                <p><strong>Misi:</strong> {!! preg_replace('/<p>|<\/p>/', '', $profil->misi) !!}</p>
            </div>
        </div>
    </div>

 

@endsection
