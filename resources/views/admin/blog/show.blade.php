@extends('layouts.panel.index')

@section('title', 'Rincian Blog')

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

    /* Image hover effect */
    .blog-img {
        transition: transform 0.3s ease-in-out;
        width: 350px;
        height: auto;
        border: 2px solid #007bff;
        border-radius: 10px;
    }

    .blog-img:hover {
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
        <h3 class="mb-4 pt-4 pb-4 text-center" style="font-weight: 700; color: #007bff;">RINCIAN BLOG</h3>

        <!-- Display Blog Details -->
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Page Id</th>
                    <td>{{ $blog->page->nama_page }}</td>
                </tr>
                <tr>
                    <th>Judul Blog</th>
                    <td>{{ $blog->judul }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $blog->slug }}</td>
                </tr>
                <tr>
                    <th>Body</th>
                    <td>{{ $blog->body }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $blog->kategori->nama_kategori }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <button class="btn rounded-3 {{ $blog->status ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>
                            {{ $blog->status ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </td>
                </tr>
                <tr>
                    <th>Foto Blog</th>
                
               
                    <td class=" pt-4 pb-4">
                        @if ($blog->photo)
                        <img src="{{ asset('storage/photos/' . $blog->photo) }}" alt="Blog Image" class="blog-img">
                        @else
                        <span class="text-muted">Tidak ada foto tersedia</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Back Button -->
        <div class="mt-4 text-center">
            <a href="{{ route('blog.index') }}" class="btn btn-secondary">Kembali</a>
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
