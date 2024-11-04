@extends('layouts.panel.index')

@section('title', 'Detail Page')

@section('content')

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
     .form-control {
        background-color: #e5e8ec;
        border: 1px solid #ced4da;       
    }
</style>

<div class="container"> 

        <!-- Display Page Details -->
        {{-- <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Nama Page</th>
                    <td>{{ $page->nama_page }}</td>
                </tr>
                <tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{!! $page->deskripsi !!}</td>
                </tr>
                <th>Pindah Halaman</th>
                <td>
                    @if($page->pindah_halaman)
                    <a href="{{ $page->pindah_halaman }}" class="btn btn-primary btn-sm" target="_blank">Pindah Halaman</a>
                    @else
                    -
                    @endif
                </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <button class="btn rounded-3 {{ $page->status ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>
                            {{ $page->status ? 'Aktif' : 'Non-Aktif' }}
                        </button>
                    </td>
                </tr>
            </tbody>
        </table> --}}
    <div class="row">
        <div class="mb-3">
            <div class="rating-input">
                <label for="no" class="form-label"><h5>Nama Page</h5></label>
                <input type="text" class="form-control" value="{{ $page->nama_page }}" disabled readonly>                  
            </div> 
        </div> 
        <div class="mb-3 ">
            <label for="pengalaman" class="form-label"><h5>Deskripsi</h5></label>
            <textarea class="form-control"  rows="2" disabled readonly>{{ $page->deskripsi }}</textarea>
        </div>  
        {{-- <div class="mb-3">
            <div class="rating-input">
                <label for="no" class="form-label"><h5>Pindah Halaman</h5></label>
                @if($page->pindah_halaman)
                <a href="{{ $page->pindah_halaman }}" class="btn btn-primary btn-sm" target="_blank">Pindah Halaman</a>
                @else
                -
                @endif                 
            </div> 
        </div>                  --}}

        <div class="mb-3">
            <div class="rating-input">
                <label for="no" class="form-label"><h5>Pindah Halaman</h5></label>
                <input type="text" class="form-control text-primary" 
                    value="{{ $page->pindah_halaman }}" 
                    onclick="window.open('{{ $page->pindah_halaman }}', '_blank')"
                    readonly>               
            </div> 
        </div> 
      <!-- Back Button -->
        <div class="mt-4 text-end">
        <a href="{{ route('page.index') }}" class="btn btn-secondary">Kembali</a>
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