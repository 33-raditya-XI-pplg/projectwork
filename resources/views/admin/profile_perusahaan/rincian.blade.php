@extends('layouts.panel.index')

@section('title', 'Detail Profil Perusahaan')

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
    .profile-image {
        transition: transform 0.3s ease-in-out;
    }
    .profile-image:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    /* Button styling */
    .btn-outline-success, .btn-outline-danger {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
    .form-control {
    background-color: #e5e8ec;
    border: 1px solid #ced4da;
    padding: 10px;
    border-radius: 4px;
}
</style>

<div class="container">
    <div class="bg-white rounded-4 px-4 py-3 mb-5 shadow-lg">
        {{-- <h3 class="mb-4 pt-4 pb-4 text-center" style="font-weight: 700; color: #007bff;">PROFIL PERUSAHAAN</h3> --}}

        <!-- Display Profile Details -->
        {{-- <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Nama Page</th>
                    <td>{{ \App\Models\Page::find($profil->page_id)->nama_page ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Tentang Kami</th>
                    <td>{!! preg_replace('/<p>|<\/p>/', '', $profil->tentang_kami) !!}</td>
                </tr>
                <tr>
                    <th>Visi</th>
                    <td>{!! preg_replace('/<p>|<\/p>/', '', $profil->visi) !!}</td>
                </tr>
                <tr>
                    <th>Misi</th>
                    <td>{!! preg_replace('/<p>|<\/p>/', '', $profil->misi) !!}</td>
                </tr>
                <tr>
                    <th>Sejarah</th>
                    <td>{!! preg_replace('/<p>|<\/p>/', '', $profil->sejarah) !!}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <button class="btn rounded-3 {{ $profil->status ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>
                            {{ $profil->status ? 'Aktif' : 'Non-Aktif' }}
                        </button>
                    </td>
                </tr>
                <tr>
                    <th>Struktur Organisasi</th>
               
                <td class=" pt-5 pb-5">
                        @if ($profil->path_struktur_organisasi)
                            <img src="{{ asset('storage/' . $profil->path_struktur_organisasi) }}" alt="Struktur Organisasi" class="profile-image img-fluid rounded-3 color: #343a40" style="width: 300px; height: auto;">
                        @else
                            <span class="text-muted">Tidak ada gambar tersedia</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table> --}}

        <div class="row">
            <div class="mb-3">
                <label for="page" class="form-label"><h5>Page Id</h5></label>
                <input type="text" class="form-control rounded" value="{{ \App\Models\Page::find($profil->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
            </div>

            <div class="mb-3 ">
                <label for="pengalaman" class="form-label"><h5>Tentang Kami</h5></label>
                <div class="form-control rounded"  rows="2" disabled readonly>{!! $profil->tentang_kami !!}</div>
            </div>   
            
            <div class="mb-3 ">
                <label for="pengalaman" class="form-label"><h5>Visi</h5></label>
                <div class="form-control rounded"  rows="2" disabled readonly>{!! $profil->visi !!}</div>
            </div>  
             
            <div class="mb-3 ">
                <label for="pengalaman" class="form-label"><h5>Misi</h5></label>
                <div class="form-control rounded"  rows="2" disabled readonly>{!! $profil->misi !!}</div>
            </div>   

            <div class="mb-3 ">
                <label for="pengalaman" class="form-label"><h5>Sejarah</h5></label>
                <div class="form-control rounded"  rows="2" disabled readonly>{!! $profil->sejarah !!}</div>
            </div>   
            <div class="text-center">
                <div>
                    <h3>Gambar</h3>
                </div>
                <div class="dropzone-wrapper" style="max-width:400px; margin:auto;">                                       
                    <div class="mt-3 d-flex justify-content-center" disabled readonly>                                                  
                            {{-- <img  src="{{ asset($testimoni->photo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                              --}}
                        @if ($profil->path_struktur_organisasi)
                            <img src="{{ asset( $profil->path_struktur_organisasi)  }}"  class="profile-image img-fluid rounded-3 color: #343a40" style="width: 250px; height: auto;" alt="user" />
                        @endif
                    </div>
                </div>                                       
            </div>
                    <!-- Back Button -->
                <div class="mt-4 text-end">
                    <a href="{{ route('profil.index') }}" class="btn btn-secondary">Kembali</a>
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
