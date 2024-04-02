@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')
@push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
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
                                @foreach ($evt as $row)
                                    <tr>
                                        <td>{{ $row->nama_event }}</td>
                                        <td>{{ \App\Models\Jenis_Event::find($row->jenis_event_id)->nama_jenis_event }}</td>
                                        <td>{{ $row->tgl_mulai }}</td>
                                        <td>{{ $row->tgl_berakhir }}</td>
                                        <td>{{ \App\Models\Instansi::find($row->instansi_id)->nama_instansi }}</td>
                                        <td><button type="button" class="btn @if ($row->status == 'Publish') btn-outline-primary
                                        @elseif ($row->status == 'Draft') btn-outline-warning 
                                        @elseif ($row->status == 'Berlangsung') btn-outline-warning
                                        @elseif ($row->status == 'Selesai') btn-outline-success
                                        @endif 
                                        rounded-3" disabled>{{ $row->status }}</button></td>
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
                                                            data-bs-target="#edit{{ $row->id_event }}"><i
                                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                    <li><a href="{{ route('event.destroy', $row->id_event) }}"
                                                            class="dropdown-item text-danger" data-confirm-delete="true"><i
                                                                class="fa-regular fa-trash-can pe-none"></i>
                                                            Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                                @foreach ($evt_draft as $row )
                                    <tr>
                                        <td>{{ $row->nama_event }}</td>
                                        <td>{{ \App\Models\Jenis_Event::find($row->jenis_event_id)->nama_jenis_event }}</td>
                                        <td>{{ $row->tgl_mulai }}</td>
                                        <td>{{ $row->tgl_berakhir }}</td>
                                        <td>{{ \App\Models\Instansi::find($row->instansi_id)->nama_instansi }}</td>
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
                                                            data-bs-target="#edit{{ $row->id_event }}"><i
                                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                    <li><a href="{{ route('event.destroy', $row->id_event) }}"
                                                            class="dropdown-item text-danger"
                                                            data-confirm-delete="true"><i
                                                                class="fa-regular fa-trash-can pe-none"></i>
                                                            Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                                @foreach ($evt_pub as $row )
                                    <tr>
                                        <td>{{ $row->nama_event }}</td>
                                        <td>{{ \App\Models\Jenis_Event::find($row->jenis_event_id)->nama_jenis_event }}</td>
                                        <td>{{ $row->tgl_mulai }}</td>
                                        <td>{{ $row->tgl_berakhir }}</td>
                                        <td>{{ \App\Models\Instansi::find($row->instansi_id)->nama_instansi }}</td>
                                            <td><button type="button" class="btn btn-outline-primary rounded-3"
                                                disabled>Publish</button></td>
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
                                                            data-bs-target="#edit{{ $row->id_event }}"><i
                                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                    <li><a href="{{ route('event.destroy', $row->id_event) }}"
                                                            class="dropdown-item text-danger"
                                                            data-confirm-delete="true"><i
                                                                class="fa-regular fa-trash-can pe-none"></i>
                                                            Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                                @foreach ($evt_live as $row )
                                    <tr>
                                        <td>{{ $row->nama_event }}</td>
                                        <td>{{ \App\Models\Jenis_Event::find($row->jenis_event_id)->nama_jenis_event }}</td>
                                        <td>{{ $row->tgl_mulai }}</td>
                                        <td>{{ $row->tgl_berakhir }}</td>
                                        <td>{{ \App\Models\Instansi::find($row->instansi_id)->nama_instansi }}</td>
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
                                                            data-bs-target="#edit{{ $row->id_event }}"><i
                                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                    <li><a href="{{ route('event.destroy', $row->id_event) }}"
                                                            class="dropdown-item text-danger"
                                                            data-confirm-delete="true"><i
                                                                class="fa-regular fa-trash-can pe-none"></i>
                                                            Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                                @foreach ($evt_end as $row )
                                    <tr>
                                        <td>{{ $row->nama_event }}</td>
                                        <td>{{ \App\Models\Jenis_Event::find($row->jenis_event_id)->nama_jenis_event }}</td>
                                        <td>{{ $row->tgl_mulai }}</td>
                                        <td>{{ $row->tgl_berakhir }}</td>
                                        <td>{{ \App\Models\Instansi::find($row->instansi_id)->nama_instansi }}</td>
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
                                                            data-bs-target="#edit{{ $row->id_event }}"><i
                                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                    <li><a href="{{ route('event.destroy', $row->id_event) }}"
                                                            class="dropdown-item text-danger"
                                                            data-confirm-delete="true"><i
                                                                class="fa-regular fa-trash-can pe-none"></i>
                                                            Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- insert -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Event</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                {{-- kanan --}}
                                <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                    <div class="mb-3">
                                        <label for="nama_event" class="form-label">Nama Event</label>
                                        <input type="text" class="form-control" name="nama_event" id="nama_event"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Event</label>
                                        <input type="date" class="form-control" name="tgl_mulai"
                                            id="tanggal_mulai" placeholder="DD/MM/YYYY" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_event_id" class="form-label">Jenis Event</label>
                                        <select class="form-select" name="jenis_event_id" aria-label="Default select example"
                                            required>
                                            <option selected>Pilih ...</option>
                                            @foreach ($jenisEvt as $row)
                                            <option value="{{ $row->id_jenis_event }}">{{ $row->nama_jenis_event }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_id" class="form-label">Tempat</label>
                                        <select class="form-select" name="tempat_id" aria-label="Default select example"
                                                required>
                                                <option selected>Pilih ...</option>
                                                @foreach ($tempat as $row)
                                                <option value="{{ $row->id_tempat }}" >{{ $row->nama_tempat }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                            </div>
                            <div class="col">
                                {{-- kiri --}}
                                <div class="mb-3">
                                    <label for="instansi_id" class="form-label">Nama Instansi</label>
                                    <select class="form-select" name="instansi_id" aria-label="Default select example"
                                            required>
                                            <option selected>Pilih ...</option>
                                            @foreach ($instansi as $row)
                                            <option value="{{ $row->id_instansi }}" >{{ $row->nama_instansi }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir"
                                        placeholder="DD/MM/YYYY" required>
                                </div>
                                <label for="biaya_regis" class="form-label">Biaya</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" name="biaya_regis" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="visibilitas" class="form-label">Visibilitas</label>
                                    <select class="form-select text-capitalize" name="visibilitas" aria-label="Default select example"
                                            required>
                                            <option class="text-capitalize" selected>publik</option>
                                            <option class="text-capitalize">privat</option>
                                        </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="logo" class="form-label">Upload Banner</label>
                                <input class="form-control" name="logo" type="file" id="formFile" accept=".png, .jpg, .jpeg" required>
                              </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control ck-editor" id="deskripsi" name="deskripsi" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div class="form-check form-switch">
                        <label for="status" class="me-3">Status </label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Publish" checked>
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit --}}
    @foreach ($evt as $row)
    
    <div class="modal modal-lg fade" id="edit{{ $row->id_event }}" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                {{-- kanan --}}
                                <form action="{{ route('event.update', $row->id_event) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                                    <div class="mb-3">
                                        <label for="nama_event" class="form-label">Nama Event</label>
                                        <input type="text" class="form-control" name="nama_event" id="nama_event" value="{{ $row->nama_event }}"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Event</label>
                                        <input type="date" class="form-control" name="tgl_mulai"
                                            id="tanggal_mulai" placeholder="DD/MM/YYYY" value="{{ $row->tgl_mulai }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_event_id" class="form-label">Jenis Event</label>
                                        <select class="form-select" name="jenis_event_id" aria-label="Default select example"
                                            required>
                                            @foreach ($jenisEvt as $element)
                                            <option value="{{ $element->id_jenis_event }}" {{ $element->id_jenis_event == $row->jenis_event_id ? 'selected' : '' }}>{{ $element->nama_jenis_event }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_id" class="form-label">Tempat</label>
                                        <select class="form-select" name="tempat_id" aria-label="Default select example"
                                                required>
                                                @foreach ($tempat as $set)
                                                <option value="{{ $set->id_tempat }}" {{ $set->id_tempat == $row->tempat_id ? 'selected' : '' }}>{{ $set->nama_tempat }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                            </div>
                            <div class="col">
                                {{-- kiri --}}
                                <div class="mb-3">
                                    <label for="instansi_id" class="form-label">Nama Instansi</label>
                                    <select class="form-select" name="instansi_id" aria-label="Default select example"
                                            required>
                                            @foreach ($instansi as $list)
                                            <option value="{{ $list->id_instansi }}" {{ $list->id_instansi == $row->instansi_id ? 'selected' : '' }}>{{ $list->nama_instansi }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir"
                                        placeholder="DD/MM/YYYY" value="{{ $row->tgl_berakhir }}" required>
                                </div>
                                <label for="biaya_regis" class="form-label">Biaya</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" name="biaya_regis" value="{{ $row->biaya_regis }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="visibilitas" class="form-label">Visibilitas</label>
                                    <select class="form-select text-capitalize" name="visibilitas" aria-label="Default select example"
                                            required>
                                            <option class="text-capitalize" {{ $row->visibilitas == 'publish' ? 'selected' : '' }}>publik</option>
                                            <option class="text-capitalize" {{ $row->visibilitas == 'privat' ? 'selected' : '' }}>privat</option>
                                        </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="logo" class="form-label">Upload Banner</label>
                                <input class="form-control" name="logo" type="file" id="formFile" accept=".png, .jpg, .jpeg">
                              </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control ck-editor" id="deskripsi-edit" name="deskripsi" rows="4">@php
                                    echo $row->deskripsi
                                @endphp</textarea>
                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div class="form-check form-switch">
                        <label for="status" class="me-3">Status </label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Publish" {{ $row->status == 'Publish' ? 'checked' : '' }}>
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach


@endsection


