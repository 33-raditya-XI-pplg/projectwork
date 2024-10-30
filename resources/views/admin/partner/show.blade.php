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
    .form-control {
        background-color: #e5e8ec;
        border: 1px solid #ced4da;       
    }
</style>

<div class="container">
        <!-- Display Partner Details -->
        {{-- <table class="table table-striped">
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
                        <img src="{{ asset($partner->logo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @else
                        <span class="text-muted">Tidak ada logo tersedia</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table> --}}
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="page" class="form-label"><h5>Page Id</h5></label>
                    <input type="text" class="form-control" value="{{ \App\Models\Page::find($partner->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
                </div>
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label"><h5>Email</h5></label>
                        <input type="text" class="form-control" value="{{ $partner->email_partner }}" disabled readonly >
                    </div>                                                                                                                                                               
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label"><h5>Jenis Partner</h5></label>
                        <input type="text" class="form-control" value="{{ $partner->jenis_partner }}" disabled readonly >
                    </div>                                                                                                                                                                                                                                                                                                                                       
            </div>
            <div class="col">
                {{-- kiri --}}                                                                                                                                                               
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label"><h5>Nama Partner</h5></label>
                    <input type="text" class="form-control" value="{{ $partner->nama_partner }}" disabled readonly >
                </div>  
                <div class="mb-3">
                    <label for="no" class="form-label"><h5>Nomor Telepon</h5></label>
                    <input type="text" class="form-control" value="{{ $partner->telepon_partner }}"disabled readonly >
                </div>                           
                <div class="mb-3">
                    <label for="no" class="form-label"><h5>Tanggal Bergabung</h5></label>
                    <input type="text" class="form-control" value="{{ $partner->tanggal_bergabung->format('d-m-Y') }}"disabled readonly >
                </div>                           
            </div>
            <div class="mb-3">
                <div class="rating-input">
                    <label for="no" class="form-label"><h5>Website Partner</h5></label>
                    <input type="text" class="form-control text-primary" 
                        value="{{ $partner->website_partner }}" 
                        onclick="window.open('{{ $partner->website_partner }}', '_blank')"
                        readonly>               
                </div> 
            </div> 
            <div class="mb-3 ">
                <label for="pengalaman" class="form-label"><h5>Alamat Partner</h5></label>
                <textarea class="form-control"  rows="2" disabled readonly>{{ $partner->alamat_partner }}</textarea>
            </div>   
            <div class="text-center">
                <div>
                    <h2>Logo Partner</h2>
                </div>
                <div class="dropzone-wrapper" style="max-width:400px; margin:auto;">                                       
                    <div class="mt-3 d-flex justify-content-center" disabled readonly>                                                  
                            {{-- <img  src="{{ asset($testimoni->photo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                              --}}
                        @if ($partner->logo)
                            <img src="{{ asset($partner->logo) }}"  class="profile-image img-fluid rounded-3 color: #343a40" style="width: 250px; height: auto;" alt="user" />
                        @endif
                    </div>
                </div>                                       
            </div>
                 <!-- Back Button -->
            <div class="mt-2 text-end">
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