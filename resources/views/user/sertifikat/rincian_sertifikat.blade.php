@extends('layouts.panel.index')
@section('title', 'Rincian Sertifikat')


@section('title', 'Rincian Sertifikat')
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
                    <img id="img-rincian" src="{{ $banner }}" class="img-fluid mx-auto d-block" alt="Banner Event">
                    <hr>
                    <br>
                    <p class="mt-2 mb-4">{{ $data_skema->deskripsi }}</p>
                    <div class="row">
                        <div class="mb-4 col-12">
                            <h6 class="fs-5 ls-2">Skema</h6>
                            <p class="mb-0">{{ $data_skema->nama_skema }}</p>
                        </div>
                        <div class="mb-4 col-6">
                            <h6 class="fs-5 ls-2">Event</h6>
                            <p class="mb-0">{{ $data_skema->nama_event }}</p>
                        </div>
                        <div class="mb-4 col-6">
                            <h6 class="fs-5 ls-2">TUK</h6>
                            <p class="mb-0">{{ $data_skema->nama_tempat }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="fs-5 ls-2">Tanggal Mulai</h6>
                            <p class="mb-0">{{ $data_skema->tgl_mulai }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="fs-5 ls-2">Tanggal Berakhir</h6>
                            <p class="mb-0">{{ $data_skema->tgl_berakhir }}</p>
                        </div>
                    </div>
                    <div class="back mt-4 mb-3">
                        <a href="{{ route('sertifikat-user.index') }}" class="btn btn-primary rounded">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var button = document.getElementById('tambahBtn');
            button.style.display = 'none';
        });
    </script>
@endpush