@extends('layouts.panel.index')

@section('title', 'Detail Kategori')

@section('content')

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container">  
        <!-- Display Kategori Details -->
        {{-- <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Nama Kategori</th>
                    <td>{{ $kategori->nama_kategori }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{!! $kategori->deskripsi !!}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <button class="btn rounded-3 {{ $kategori->status ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>
                            {{ $kategori->status ? 'Aktif' : 'Non-Aktif' }}
                        </button>
                    </td>
                </tr>
            </tbody>
        </table> --}}
        {{-- <div class="mb-3">
            <label for="page" class="form-label"><h5>Page Id</h5></label>
            <input type="text" class="form-control" value="{{ \App\Models\Page::find($kategori->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
        </div> --}}
            <div class="mb-3">
                    <div class="rating-input">
                        <label for="no" class="form-label"><h5>Nama Kategori</h5></label>
                        <input type="text" class="form-control" value="{{ $kategori->nama_kategori }}" disabled readonly>                  
                    </div> 
                </div> 
            <div class="mb-3 ">
                <label for="pengalaman" class="form-label"><h5>Deskripsi</h5></label>
                <textarea class="form-control"  rows="2" disabled readonly>{{ $kategori->deskripsi }}</textarea>
            </div>              
              <!-- Back Button -->
              <div class="mt-4 text-end">
                <a href="{{ route('kategori.indek') }}" class="btn btn-secondary">Kembali</a>
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