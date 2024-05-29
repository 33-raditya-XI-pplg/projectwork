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

        <div class="mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <label><b> Event yang Sedang Berlangsung</b></label>
                </div>

                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        @php $num=1; @endphp
                        @foreach ($data_event as $row)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $row->id_event }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $row->id_event }}" aria-expanded="true" aria-controls="collapse{{ $row->id_event }}">
                                        <strong>{{ $num++ }}. {{ $row->nama_event }}</strong>
                                        <span>{{ \Carbon\Carbon::parse($row->tgl_mulai)->format('d, F Y') }} - {{ \Carbon\Carbon::parse($row->tgl_berakhir)->format('d, F Y') }}</span>
                                    </button>
                                </h2>
                                <div id="collapse{{ $row->id_event }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $row->id_event }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>{{ $row->deskripsi }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
