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
    padding-top: 10%;
    padding-bottom: 10%;
    }

    .img-container img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
        margin: 0 auto;
    }
    .deskripsi {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .rincian-btn{
        padding: 2px 1px 1px 1px;
        font-size: 14px;
        border-radius:5px;
    }
    .rincian-btn i{
        font-size: 17px;
        margin-right: 5px;
    }

        </style>
    @endpush

    @if($route == 'user/event-user')
    <div class="filter-training mb-4" id="shadow">
        <div class="card border-0">
            <div class="card-header bg-primary text-white">
                <label for=""><b> Filter</b></label>
                <a href="{{ route('event-user.index') }}" class="btn btn-light rounded btn-sm float-end">Clear Filter</a>
            </div>
            <div class="card-body">

                <form action="{{ route('event-user.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="tgl_mulai">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="tgl_berakhir">Tanggal Berakhir</label>
                            <input type="date" name="tgl_berakhir" class="form-control" value="{{ request('tgl_berakhir') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nama_tuk">Nama Tempat Uji Kompetensi (TUK)</label>
                            <select name="nama_tuk" class="chosen-select form-control">
                                <option hidden disabled selected>-- Pilih Nama TUK --</option>
                                @foreach($data_tempat as $row)
                                    <option value="{{ $row->id_tempat }}" {{ request('nama_tuk') == $row->id_tempat ? 'selected' : '' }}>
                                        {{ $row->nama_tempat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="nama_jenis_event">Jenis Event</label>
                            <select name="nama_jenis_event" class="chosen-select form-control">
                                <option hidden disabled selected>-- Pilih Jenis Event --</option>
                                @foreach($data_jenis_event as $row)
                                    <option value="{{ $row->id_jenis_event }}" {{ request('nama_jenis_event') == $row->id_jenis_event ? 'selected' : '' }}>
                                        {{ $row->nama_jenis_event }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 mb-3 mt-4">
                            <button type="submit" class="btn btn-primary rounded">Filter</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
    @endif


    <div class="row row-cols-1 row-cols-md-3 g-4">
        @if($data_event->count())
            @foreach ($data_event as $row)
            <div class="col">

                <div class="card h-100">
                    <div class="img-container" id="shadow">
                        <img src="{{ asset($row->path_banner) }}" alt="">
                    </div>
                    <div class="container">
                        <div class="text-left mt-3">
                            <h5>{{ $row->nama_event }}</h5>
                            <p class="deskripsi">{!! strip_tags($row->deskripsi) !!}</p>
                        </div>
                       <div class="d-flex mt-3 mb-3 justify-content-between align-items-center">
                        <span>{{ \Carbon\Carbon::parse($row->tgl_mulai)->format('d, F Y') }}</span>

                        @if($route == 'user/event-user')
                            <a href="{{ route('event-user.show', $row->id_event) }}"
                        @elseif($route == 'user/follow-event')
                            <a href="{{ route('follow-show-event', $row->id_event) }}"
                        @endif

                        class="btn rincian-btn px-4 py-2 rounded-3 shadow-sm"
                        style="background-color: #ffc107; color: #212529; font-weight: 500; transition: 0.3s;">
                            Rincian
                        </a>
                    </div>

                    <style>
                        .rincian-btn:hover {
                            background-color: #e0a800 !important;
                            color: #fff !important;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
                        }
                    </style>
                    </div>
                        </div>
                    </div>
                    @endforeach
            {!! $data_event->render('pagination::bootstrap-5') !!}

        @else
            <p>Tidak ada event yang ditemukan.</p>
        @endif

    </div>
@endsection

@push('script')
    <script>
        $(".chosen-select").chosen()
    </script>
@endpush
