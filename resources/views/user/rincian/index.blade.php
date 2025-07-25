
@extends('layouts.panel.index')
@section('title', 'Rincian')


@section('title', 'Rincian')
@push('style')
    <style>
        h5 {
            font-weight: 300;
        }
        #img-rincian{
            width: 400px;
            height: 300px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Rincian</h4>
                    {{-- <img src="{{ asset('assets/img/wa.jpg') }}" width="100%" height="300" alt="kosong"> --}}
                    <img id="img-rincian" src="{{ asset('assets/img/wa.jpg') }}" class="img-fluid mx-auto d-block" alt="kosong">
                    <hr>
                    <br>
                    <p class="mt-2 mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Inventore enim esse, et repellendus suscipit eligendi itaque? Provident voluptatem, cum, rerum numquam fugit laborum quibusdam quas iure repudiandae nam eius ipsum iusto aperiam delectus velit perspiciatis nihil a temporibus. Itaque, dolore!</p>
                    <div class="row">
                        <div class="mb-4 col-12">
                            <h6 class="text-uppercase fs-5 ls-2">Position</h6>
                            <p class="mb-0">Theme designer at Bootstrap.</p>
                        </div>
                        <div class="mb-4 col-6">
                            <h6 class="text-uppercase fs-5 ls-2">Phone </h6>
                            <p class="mb-0">+08100001</p>
                        </div>
                        <div class="mb-4 col-6">
                            <h6 class="text-uppercase fs-5 ls-2">Date</h6>
                            <p class="mb-0">01.10.2000</p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-uppercase fs-5 ls-2">Email </h6>
                            <p class="mb-0">Mascitra.com</p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-uppercase fs-5 ls-2">Location</h6>
                            <p class="mb-0">Jember</p>
                        </div>
                    </div>
                    <div class="back mt-4 mb-3">
                        <a href="{{ URL::previous() }}" class="btn btn-primary rounded">Kembali</a>
                        <a href="#" class="btn btn-outline-secondary rounded">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
