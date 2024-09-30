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
            <div class="card mb-2">
                <h4 class="card-title ">{{ $data_skema->nama_skema }}</h4>
                <div class="card-body">

                    <div class="row">
                        <div class="col">
                            <h4 class="card-title mb-3">Daftar Penguji</h4>
                            <table class="table">
                                <thead class="fw-normal">
                                    <th scope="col" width="5%">No</th>
                                    <th scope="col" width="20%">Nama</th>
                                    <th scope="col" width="8%">Tipe Penguji</th>
                                </thead>

                                <tbody class="table-responsive" style="vertical-align: middle">
                                    @php $num = 1 @endphp
                                    @foreach ($data_penguji as $row)
                                        <tr>
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $row->nama_lengkap }}</td>
                                            <td>{{ $row->type_penguji }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col">
                            <table class="table">
                                <h4 class="card-title mb-3">Daftar Sub Skema</h4>
                                <thead class="fw-normal">
                                    <th scope="col" width="5%">No</th>
                                    <th scope="col" width="20%">Nama Sub-Skema</th>
                                </thead>

                                <tbody class="table-responsive" style="vertical-align: middle">
                                    @php $num = 1 @endphp
                                    @foreach ($data_sub_skema as $row)
                                        <tr>
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $row->judul_sub }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="back mt-4 mb-3">
                            <a class="btn btn-primary rounded" href="{{ strpos($previousUrl, 'sertifikat-user') !== false ? 
                                    route('sertifikat-user.show', $data_skema->id_event) : 
                                    route('event-user.show', $data_skema->id_event) }}" >
                            Kembali</a>
                        </div>

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