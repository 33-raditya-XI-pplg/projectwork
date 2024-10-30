@extends('layouts.panel.index')

@section('title', 'Detail Blog')

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

        <!-- Display Blog Details -->
        {{-- <table class="table table-striped">
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
                        <img src="{{ asset($blog->photo) }}" alt="Blog Image" class="blog-img">
                        @else
                        <span class="text-muted">Tidak ada foto tersedia</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table> --}}
        <div class="row">  
            <div class="mb-3">
                <label for="page" class="form-label"><h5>Page Id</h5></label>
                <input type="text" class="form-control" value="{{ \App\Models\Page::find($blog->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
            </div>                                                                                                                                                           
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label"><h5>Judul Blog</h5></label>
                    <input type="text" class="form-control" value="{{  $blog->judul }}" disabled readonly >
                </div>  
                <div class="mb-3">
                    <label for="no" class="form-label"><h5>Slug</h5></label>
                    <input type="text" class="form-control" value="{{ $blog->slug }}"disabled readonly >
                </div>                                   
            <div class="mb-3">
                <div class="rating-input">
                    <label for="no" class="form-label"><h5>Kategori</h5></label>
                    <input type="text" class="form-control" value="{{ $blog->kategori->nama_kategori }}" disabled readonly>              
                </div> 
            </div> 
            <div class="mb-3 ">
                <label for="pengalaman" class="form-label"><h5>Body</h5></label>
                <textarea class="form-control"  rows="2" disabled readonly>{{  $blog->body }}</textarea>
            </div>   
            <div class="text-center">
                <div>
                    <h2>Foto Testimoni</h2>
                </div>
                <div class="dropzone-wrapper" style="max-width:400px; margin:auto;">                                       
                    <div class="mt-3 d-flex justify-content-center" disabled readonly>                                                  
                            {{-- <img  src="{{ asset($testimoni->photo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                              --}}
                        @if ($blog->photo)
                            <img src="{{ asset($blog->photo) }}"  class="profile-image img-fluid rounded-3 color: #343a40" style="width: 250px; height: auto;" alt="user" />
                        @endif
                    </div>
                </div>                                       
            </div>
                  <!-- Back Button -->
            <div class="mt-4 text-end">
                <a href="{{ route('blog.indek') }}" class="btn btn-secondary">Kembali</a>
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
