@extends('layouts.panel.index')

@section('title', 'Rincian Slider')

@section('content')

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Additional Custom Styling -->
<style>
    th {
        font-weight: bold;
        font-size: 1rem;
        color: #343a40;
        text-transform: uppercase;
    }
    td {
        font-size: 1rem;
        color: #6c757d;
    }
    .profile-image {
        transition: transform 0.3s ease-in-out;
    }
    .profile-image:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    .btn-outline-success, .btn-outline-danger {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
</style>

<div class="container">
    <div class="bg-white rounded-4 px-4 py-3 mb-5 shadow-lg">
        <h3 class="mb-4 pt-4 pb-4 text-center" style="font-weight: 700; color: #007bff;">RINCIAN SLIDER</h3>

        <!-- Display Slider Details -->
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Page</th>
                    <td>{{ \App\Models\Page::find($slider->page_id)->nama_page ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $slider->title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $slider->description }}</td>
                </tr>
                <tr>
                    <th>Position</th>
                    <td>{{ $slider->position }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <button class="btn rounded-3 {{ $slider->status ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>
                            {{ $slider->status ? 'Aktif' : 'Non-Aktif' }}
                        </button>
                    </td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td class="pt-5 pb-5">
                        @if ($slider->image_url)
                            <img src="{{ $slider->image_url ? asset($slider->image_url) : asset('images/default.png') }}" alt="Slider Image" class="profile-image img-fluid rounded-3" style="width: 300px; height: auto; border: 2px solid #007bff;">
                        @else
                            <span class="text-muted">No image available</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Back Button -->
        <div class="mt-4 text-center">
            <a href="{{ route('slider.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        document.addEventListener('DOMContentLoaded', function () {
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
