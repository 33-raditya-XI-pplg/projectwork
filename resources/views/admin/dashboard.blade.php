@extends('layouts.panel.index')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="card bg-primary-gradient text-white rounded-3 shadow-lg" style="height: 7rem;">
            <div class="card-body d-flex align-items-center justify-content-between mx-3">
                <div>
                    <h5 class="card-title">Hi, <strong>{{ Auth::user()->nama_lengkap }}</strong></h5>
                    <p class="card-text">Selamat datang dan selamat bekerja!</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card mt-4 bg-primary-gradient text-white rounded-3 shadow-sm"
                    style="width: 15rem; height: 8rem">
                    <div class="card-body">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <h1 class="card-title fw-bold">{{ $banyak_pengguna }}</h1>
                        <p class="card-text fw-bold">Banyak pengguna</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-4 bg-primary-gradient text-white rounded-3 shadow-sm"
                    style="width: 15rem; height: 8rem">
                    <div class="card-body">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <h1 class="card-title fw-bold">{{ $banyak_penguji }}</h1>
                        <p class="card-text fw-bold">Banyak penguji</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-4 bg-primary-gradient text-white rounded-3 shadow-sm"
                    style="width: 15rem; height: 8rem">
                    <div class="card-body">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <h1 class="card-title fw-bold">{{ $banyak_event }}</h1>
                        <p class="card-text fw-bold">Banyak event</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-4 bg-primary-gradient text-white rounded-3 shadow-sm"
                    style="width: 15rem; height: 8rem">
                    <div class="card-body">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <h1 class="card-title fw-bold">{{ $banyak_skema }}</h1>
                        <p class="card-text fw-bold">Banyak skema</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-8 bg-white">
                <div class="card shadow-md justify-content-center text-center rounded-3" style="height: 12rem;">
                        <div class="spinner-border text-primary text-center mx-auto" role="status">
                            <span class="visually-hidden">************</span>
                        </div>
                </div>
            </div>
            <div class="col-4 bg-white text-center">
                <div class="card shadow-md rounded-3" style="height: 12rem;">
                    <div class="card shadow-md justify-content-center text-center rounded-3" style="height: 12rem;">
                        <div class="spinner-border text-primary text-center mx-auto" role="status">
                            <span class="visually-hidden">************</span>
                        </div>
                </div>
                </div>
            </div>
        </div>

    </div>
@endsection
