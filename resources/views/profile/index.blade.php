@extends('layouts.panel.index')
@section('title', 'Profile')

@push('style')
<style>
    h5, h3, p {
        transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
    }
    h5:hover, h3:hover, p:hover {
        transform: scale(1.05); /* Slight zoom effect */
        color: #007bff; /* Change text color on hover */
    }

    i {
        transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
    }
    i:hover {
        transform: scale(1.2); /* Slightly larger icons on hover */
        color: #007bff; /* Change icon color on hover */
    }

    .profile-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }
    .profile-image:hover {
        transform: scale(1.1); /* Zoom effect on hover */
    }
    
    .hover-expand {
        transition: transform 0.3s ease-in-out;
    }
    .hover-expand:hover {
        transform: scale(1.05); /* Slight zoom effect on hover */
    }
</style>
@endpush




@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 text-center">
                <div class="bg-primary position-relative p-2 shadow rounded-4 w-100 h-50 hover-expand" style="margin-top: 3em; display: flex; justify-content: center; align-items: center;">
                @if ($data->path_foto)
                <img class="profile-image rounded-4" src="{{ $data->path_foto }}" alt="foto_{{ explode(' ', $data->nama_lengkap)[0] }}" style="width: 100px; height: 100px; object-fit: cover;">
    @else
        <img class="profile-image rounded-4" src="{{ asset('assets/img/icon.png') }}" alt="Default Photo" style="width: 100px; height: 100px; object-fit: cover;">
    @endif
                    </div>
                </div>
                <div class="col-sm-8">
                        <div class="row">
                            <div class="col-10 pt-2">
                                <h3 class="mb-3 profile-text">{{ $data->nama_lengkap   }}</h3>
                                <h5><i class="fa-solid fa-id-badge"></i>&emsp;&nbsp;{{ $data->level   }}</h5>
                                <h5><i class="fa-regular fa-envelope"></i>&emsp;{{ $data->email  }}</h5>
                                <h5><i class="fa-solid fa-location-dot"></i>&emsp;&nbsp;{{ $data->alamat ?? 'Tidak tersedia' }} - {{ $data->alamat_kota ?? 'Tidak tersedia' }}</h5>
                                <h5><i class="fa-solid fa-phone"></i>&emsp;{{ $data->no_telp ?? 'Tidak tersedia' }}</h5>
                            </div>
                        <div class="col-2 text-end">
                            @if(Auth::user()->level == 'Admin')
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary rounded-4"><i class="fa-solid fa-pen-to-square"></i></a>
                            @elseif(Auth::user()->level == 'Pengguna')
                                <a href="{{ route('profile.edit-user') }}" class="btn btn-primary rounded-4"><i class="fa-solid fa-pen-to-square"></i></a>                        
                            @elseif(Auth::user()->level == 'Penguji')
                                <a href="{{ route('profile.edit-penguji') }}" class="btn btn-primary rounded-4"><i class="fa-solid fa-pen-to-square"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mt-4">
        <div class="card shadow-sm mb-4 p-4">
            <div class="card-body">
                <h2 class="card-title">Detail Akun - {{ $data->level }}</h2>
                @if(Auth::user()->isLevel('Admin'))
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Nama Lengkap</h5>
                            <h5>Email</h5>
                        </div>
                        <div class="col-sm-8 text-end">
                            <h5>{{ $data->nama_lengkap }}</h5>
                            <h5>{{ $data->email }}</h5>
                        </div>
                    </div>
                    <hr>
                @elseif(Auth::user()->isLevel('Penguji'))
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Nama Lengkap</p>
                            <p>NIK</p>
                            <p>Instansi</p>
                            <p>Jabatan</p>
                            <p>Alamat</p>
                            <p>Nomor HP</p>
                            <p>Email</p>
                        </div>
                        <div class="col-sm-8 text-end">
                            <p>{{ $data->nama_lengkap }}</p>
                            <p>{{ $data->nomor_induk }}</p>
                            <p>{{ $data->userInstansi->nama_instansi }}</p>
                            <p>{{ $data->jabatan_penguji }}</p>
                            <p>{{ $data->alamat }} - {{ $data->alamat_kota }}</p>
                            <p>{{ $data->no_telp }}</p>
                            <p>{{ $data->email }}</p>
                        </div>
                    </div>
                    <h2 class="card-title">Data Penguji</h2>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Jabatan Penguji</p>
                            <p>Tipe Penguji</p>                  
                        </div>
                        <div class="col-sm-8 text-end">
                            <p>{{ $data->jabatan_penguji }}</p>
                            <p>{{ $data->type_penguji }}</p>                      
                        </div>
                    </div>
                    <hr>
                @elseif(Auth::user()->isLevel('Pengguna'))
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Nama Lengkap</p>
                            <p>Tempat Lahir</p>
                            <p>Tanggal Lahir</p>
                            <p>Jenis Kelamin</p>
                            <p>Nomor KTP</p>
                            <p>Alamat</p>
                            <p>Nomor HP</p>
                            <p>Email</p>
                        </div>
                        <div class="col-sm-8 text-end">
                            <p>{{ $data->nama_lengkap }}</p>
                            <p>{{ $data->tempat_lahir }}</p>
                            <p>{{ $data->tgl_lahir }}</p>
                            <p>{{ $data->jenis_kelamin }}</p>
                            <p>{{ $data->nomor_induk }}</p>
                            <p>{{ $data->alamat }} - {{ $data->alamat_kota }}</p>
                            <p>{{ $data->no_telp }}</p>
                            <p>{{ $data->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <h2 class="card-title">Pendidikan Terakhir</h2>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Nama Sekolah</p>
                            <p>Jurusan</p>
                            <p>Jenjang</p>
                            <p>Tahun Lulus</p>
                        </div>
                        <div class="col-sm-8 text-end">
                            <p>{{ $data->nama_sekolah }}</p>
                            <p>{{ $data->jurusan }}</p>
                            <p>{{ $data->jenjang }}</p>
                            <p>{{ $data->tahun_lulus }}</p>
                        </div>
                    </div>
                    <hr>
                    <h2 class="card-title">Pekerjaan Sekarang</h2>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Nama Perusahaan</p>
                            <p>Alamat</p>
                            <p>Jabatan</p>
                            <p>Telepon</p>
                        </div>
                        <div class="col-sm-8 text-end">
                            <p>{{ $data->nama_perusahaan }}</p>
                            <p>{{ $data->alamat_perusahaan }} - {{ $data->alamat_kota_perusahaan }}</p>
                            <p>{{ $data->jabatan_pekerjaan }}</p>
                            <p>{{ $data->no_telp_perusahaan }}</p>
                        </div>
                    </div>
                    <hr>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
