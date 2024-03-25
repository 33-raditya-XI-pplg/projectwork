@extends('layouts.panel.index')


@section('title', 'Profile')
@push('style')
<style>
    h5{
        font-weight: 300;
    }
    </style>
@endpush
@section('content')
    <div class="container-fluid mt-6">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                        <div class="col-sm-4">
                            <div class="bg-primary position-relative p-2 shadow rounded-4 w-75 mx-auto" style="margin-top: -5em;">
                                <img class="card-img-top rounded-4" src="https://static.vecteezy.com/system/resources/previews/005/544/718/non_2x/profile-icon-design-free-vector.jpg" alt="">
                            </div>
                        </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-10 pt-2">
                                <h3 class="mb-3">ini nama</h3>
                                <h5><i class="fa-regular fa-envelope"></i>&emsp;email</h5>
                                <h5><i class="fa-solid fa-location-dot"></i>&emsp;&nbsp;alamat</h5>
                                <h5><i class="fa-solid fa-phone"></i>&emsp;Nomor Telpon</h5>
                            </div>
                            <div class="col-2">
                                <div class="card-tittle text-end">
                                    <a href="#" class="btn btn-primary rounded-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <div id="segitiga">
                                    <span class="triangle d-block"></span>
                                    <span class="triangles d-block"></span>
                                </div>
                            </div>
                            {{-- /col-2 --}}
                        </div>
                        {{-- /row --}}
                    </div>
                    {{-- /col-sm-8 --}}
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="card shadow-sm mb-4 p-4">
            <div class="card-body">
                <h2>Detail Akun</h2>
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
                        <p>Nama Lengkap</p>
                        <p>Tempat Lahir</p>
                        <p>Tanggal Lahir</p>
                        <p>Jenis Kelamin</p>
                        <p>Nomor KTP</p>
                        <p>Alamat</p>
                        <p>Nomor HP</p>
                        <p>Email</p>
                    </div>
                </div>
                <hr>
                <h2>Pendidikan Terakhir</h2>
                <div class="row">
                    <div class="col-sm-4">
                        <p>Nama Sekolah/Universitas</p>
                        <p>Jurusan</p>
                        <p>Jenjang</p>
                        <p>Tahun Lulus</p>
                    </div>
                    <div class="col-sm-8 text-end">
                        <p>Nama Sekolah/Universitas</p>
                        <p>Jurusan</p>
                        <p>Jenjang</p>
                        <p>Tahun Lulus</p>
                    </div>
                </div>
                <hr>
                <h2>Pekerjaan Sekarang</h2>
                <div class="row">
                    <div class="col-sm-4">
                        <p>Nama Perusahaan</p>
                        <p>Alamat</p>
                        <p>Jabatan</p>
                        <p>Telepon</p>
                    </div>
                    <div class="col-sm-8 text-end">
                        <p>Nama Perusahaan</p>
                        <p>Alamat</p>
                        <p>Jabatan</p>
                        <p>Telepon</p>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>


@endsection

@push('script')
    <script>
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
@endpush
