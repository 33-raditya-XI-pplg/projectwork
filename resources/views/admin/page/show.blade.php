@extends('layouts.panel.index')

@section('title', 'Rincian Page')

@section('content')

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container">
    <div class="bg-white rounded-4 px-4 py-3 mb-5 shadow-lg">
        <h4 class="mb-4">{{ $page->nama_page }}</h4>

        <!-- Display Page Details -->
        <table class="table table-striped">
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
        </table>

        <!-- Back Button -->
        <div class="mt-4">
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