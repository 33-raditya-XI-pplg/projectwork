@extends('layouts.panel.index')
@section('title', 'Event')
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

            .deskripsi {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
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
                    <div class="col-md-3 mb-3">
                        <label for="jenis_event_filter">Jenis Event</label>
                        <select id="jenis_event_filter" name="jenis_event_filter" class="chosen-select form-control">
                            <option hidden disabled selected>Pilih Jenis Event</option>
                            @foreach ($data_jenis_event as $row)
                                <option value="{{ $row->id_jenis_event }}">{{ $row->nama_jenis_event }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nama_instansi_filter">Nama Instansi</label>
                        <select id="nama_instansi_filter" name="nama_instansi_filter" class="chosen-select form-control">
                            <option hidden disabled selected>Pilih Jenis Event</option>
                            @foreach ($data_instansi as $row)
                                <option value="{{ $row->id_instansi }}">{{ $row->nama_instansi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 mt-4">
                        <button type="submit" class="btn btn-primary rounded">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($data_event as $row)
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset($row->path_banner) }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>{{ $row->nama_event }}</h5>
                        <p class="deskripsi">{{ $row->deskripsi }}</p>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="{{ route('event-user.show', $row->id_event) }}"
                                class="btn btn-sm btn-warning float-end rounded"><i class="fas fa-tasks"></i> Rincian</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    {!! $data_event->render('pagination::bootstrap-5') !!}
@endsection

@push('script')
    <script>
        $(".chosen-select").chosen()
    </script>
@endpush
