@extends('layouts.panel.index')
@section('title', 'Nilai')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }
        </style>
    @endpush

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg text-center">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="image">
                                <img src="{{ asset('assets/img/logonya.png') }}" width="200" height="130" alt="">
                            </div>
                            <h5 class="card-title">Lorem ipsum dolor</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="image">
                                <img src="{{ asset('assets/img/logonya.png') }}" width="200" height="130" alt="">
                            </div>
                            <h5 class="card-title">Lorem ipsum dolor</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="image">
                                <img src="{{ asset('assets/img/logonya.png') }}" width="200" height="130" alt="">
                            </div>
                            <h5 class="card-title">Lorem ipsum dolor</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="image">
                                <img src="{{ asset('assets/img/logonya.png') }}" width="200" height="130" alt="">
                            </div>
                            <h5 class="card-title">Lorem ipsum dolor</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="image">
                                <img src="{{ asset('assets/img/logonya.png') }}" width="200" height="130" alt="">
                            </div>
                            <h5 class="card-title">Lorem ipsum dolor</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="image">
                                <img src="{{ asset('assets/img/logonya.png') }}" width="200" height="130" alt="">
                            </div>
                            <h5 class="card-title">Lorem ipsum dolor</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <a href="#" class="btn btn-sm btn-outline-primary">Daftar</a>
        </div>
    </div>
@endsection
