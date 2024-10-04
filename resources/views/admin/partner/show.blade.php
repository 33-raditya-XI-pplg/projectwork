@extends('layouts.panel.index')
@section('title', 'Detail Partner')

@section('content')

<!-- Include Custom CSS -->
<style>
    .partner-detail-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .logo-img {
        max-width: 500px; /* Increased max width for logo */
        height: auto;
        border-radius: 10px; /* Optional: Rounded corners for the logo */
        transition: transform 0.3s; /* Smooth zoom effect on hover */
    }
    .logo-img:hover {
        transform: scale(1.1); /* Slight zoom on hover */
    }
</style>

<div class="container partner-detail-container">
    <h1 class="mb-4">Detail Partner</h1>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $partner->nama_partner }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> <span class="text-muted">{{ $partner->email_partner }}</span></p>
            <p><strong>Nomor Telepon:</strong> <span class="text-muted">{{ $partner->telepon_partner }}</span></p>
            <p><strong>Alamat:</strong> <span class="text-muted">{{ $partner->alamat_partner }}</span></p>
            <p><strong>Jenis Partner:</strong> <span class="text-muted">{{ $partner->jenis_partner }}</span></p>
            <p><strong>Tanggal Bergabung:</strong> <span class="text-muted">{{ $partner->tanggal_bergabung->format('d-m-Y') }}</span></p>
            <p><strong>Website:</strong> <a href="{{ $partner->website_partner }}" target="_blank" class="text-primary">{{ $partner->website_partner }}</a></p>
            <p><strong>Status:</strong> <span class="text-muted">{{ $partner->status_partner ? 'Aktif' : 'Nonaktif' }}</span></p>

            @if ($partner->logo)
                <div class="my-3">
                    <strong>Logo:</strong><br>
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="Logo" class="img-fluid logo-img">
                </div>
            @endif
            <a href="#" class="btn btn-secondary" id="back-button">Kembali</a>
        </div>
    </div>
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include Custom JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // SweetAlert on button click
        document.getElementById('back-button').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default anchor behavior
            Swal.fire({
                title: 'Kembali ke daftar partner?',
                text: 'Apakah Anda yakin ingin kembali?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('partner.index') }}"; // Redirect to partner index
                }
            });
        });
    });
</script>

@endsection
