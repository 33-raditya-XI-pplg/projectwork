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
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }

        </style>
    @endpush

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <nav>
            <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-all"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">All</button>
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-draft"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Draft</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-publish"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Publish</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-live"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Berlangsung</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-end"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Selesai</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id-nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                    <td><button type="button" class="btn btn-success
                                    rounded-3" disabled>status</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editid_event"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger" data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                                <li><a href="#"
                                                        class="dropdown-item text-warning"><i class="fa-solid fa-code pe-none"></i>
                                                        Rincian</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>

                {{--  --}}
            </div>
            <div class="tab-pane fade" id="nav-draft" role="tabpanel" aria-labelledby="nav-home-tab">
                {{--  --}}

                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id->nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                    <td><button type="button" class="btn btn-outline-warning rounded-3"
                                        disabled>Draft</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger"
                                                        data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>

                {{--  --}}
            </div>
            <div class="tab-pane fade" id="nav-publish" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id->nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                        <td><button type="button" class="btn btn-outline-primary rounded-3"
                                            disabled>Publish</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger"
                                                        data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-live" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id->nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                        <td><button type="button" class="btn btn-outline-warning rounded-3"
                                            disabled>Berlangsung</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger"
                                                        data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-end" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id->nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                        <td><button type="button" class="btn btn-outline-success rounded-3"
                                            disabled>Selesai</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger"
                                                        data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- <div class="filter-training mb-4" id="shadow">
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
    </div> --}}


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
                            <p class="deskripsi">{{ $row->deskripsi }}</p>
                        </div>
                        <div class="d-flex mt-3 mb-3 justify-content-between align-items-center">
                            <span>{{ \Carbon\Carbon::parse($row->tgl_mulai)->format('d, F Y') }}</span>
                            <a href="{{ route('event-user.show', $row->id_event) }}" class="btn btn-sm btn-warning rounded">
                                <i class="fas fa-tasks"></i> Rincian</a>
                        </div>
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
