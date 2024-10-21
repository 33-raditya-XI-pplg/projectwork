@extends('layouts.panel.index')

@section('title', 'Rincian Partner')

@section('content')

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Additional Custom Styling -->
<style>
    /* Table header text styling */
    th {
        font-weight: bold;
        font-size: 1rem;
        color: #343a40;
        text-transform: uppercase;
    }

    /* Table data text styling */
    td {
        font-size: 1rem;
        color: #6c757d;
    }

    /* Image hover effect */
    .logo-img {
        transition: transform 0.3s ease-in-out;
        width: 350px;
        height: auto;
        border: 2px solid #007bff;
        border-radius: 10px;
    }

    .logo-img:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Button styling */
    .btn-outline-success,
    .btn-outline-danger {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
</style>

<div class="container">
    <div class="bg-white rounded-4 px-4 py-3 mb-5 shadow-lg">
        <h3 class="mb-4 pt-4 pb-4 text-center" style="font-weight: 700; color: #007bff;">RINCIAN PARTNER</h3>

        <!-- Display Partner Details -->
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Page Id</th>
                    <td>{{ $partner->page->nama_page  }}</td>
                </tr>
                <tr>
                    <th>Nama Partner</th>
                    <td>{{ $partner->nama_partner }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $partner->email_partner }}</td>
                </tr>
                <tr>
                    <th>Nomor Telepon</th>
                    <td>{{ $partner->telepon_partner }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $partner->alamat_partner }}</td>
                </tr>
                <tr>
                    <th>Jenis Partner</th>
                    <td>{{ $partner->jenis_partner }}</td>
                </tr>
                <tr>
                    <th>Tanggal Bergabung</th>
                    <td>{{ $partner->tanggal_bergabung->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Website</th>
                    <td>
                        <a href="{{ $partner->website_partner }}" target="_blank" class="text-primary">{{ $partner->website_partner }}</a>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <button class="btn rounded-3 {{ $partner->status_partner ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>
                            {{ $partner->status_partner ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </td>
                </tr>
                <tr>
                    <th>Logo Partner</th>
                
                    <td class="pt-5 pb-5">
                        @if ($partner->logo)
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="Logo" class="logo-img">
                        @else
                        <span class="text-muted">Tidak ada logo tersedia</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Back Button -->
        <div class="mt-4 text-center">
            <a href="{{ route('partner.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            text: '{{ $errors->first() }}',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif
@endpush