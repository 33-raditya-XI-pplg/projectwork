@extends('layouts.panel.index')
@section('title', 'Nilai')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }

            #shadow {
                box-shadow: 0 6px 6px rgba(0, 0, 0, 0.1);
            }

            .img-container {
                position: relative;
                padding-top: 56.25%;
                /* This sets the aspect ratio to 16:9 */
            }

            .img-container img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>
    @endpush

    <div class="filter-training mb-4" id="shadow">
        <div class="card border-0">
            <div class="card-header bg-primary text-white">
                <label for=""><b> Filter</b></label>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label for="">Kategori Program Pelatihan</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Semua</option>
                            <option value="Diselenggarakan Pemerintah">Diselenggarakan Pemerintah</option>
                            <option value="Kampus UKM">Kampus UKM</option>
                            <option value="Kategori Lainnya">Kategori Lainnya</option>
                            <option value="Pendampingan UKM">Pendampingan UKM</option>
                            <option value="Sertifikasi">Sertifikasi</option>
                            <option value="Vokasional">Vokasional</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="">Tanggal</label>
                        <input type="date" class="form-control" id="date">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="">Jenis Event</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">Semua</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="#" class="btn btn-sm btn-outline-danger float-end rounded">btn kiri</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded">btn kanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="#" class="btn btn-sm btn-outline-danger float-end rounded">btn kiri</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded">btn kanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="#" class="btn btn-sm btn-outline-danger float-end rounded">btn kiri</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded">btn kanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="#" class="btn btn-sm btn-outline-danger float-end rounded">btn kiri</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded">btn kanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="#" class="btn btn-sm btn-outline-danger float-end rounded">btn kiri</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded">btn kanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="#" class="btn btn-sm btn-outline-danger float-end rounded">btn kiri</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded">btn kanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="register text-center mt-4 mb-4">
        <a href="#" class="btn btn-lg btn-outline-primary rounded">Daftar</a>
    </div>
@endsection
