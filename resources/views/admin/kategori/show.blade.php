@extends('layouts.panel.index')

@section('title', 'Rincian Kategori')

@section('content')

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container">
    <div class="bg-white rounded-4 px-4 py-3 mb-5 shadow-lg">
        <h4 class="mb-4">{{ $kategori->nama_kategori }}</h4>

        <!-- Display Kategori Details -->
        <table class="table table-striped">
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
        </table>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
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