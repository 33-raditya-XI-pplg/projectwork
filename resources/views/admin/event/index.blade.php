@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')
@push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }
            .select2-close-mask{
                z-index: 2099 !important;
            }
            .select2-dropdown{
                z-index: 3051 !important;
            }
            .dropzone-wrapper{
                display:flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 240px;
                border: 2px dashed #ddd;
                background-color: #f9f9f9;
                position: relative;
                cursor: pointer;
            }
            #image_preview_{
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: auto;
                max-width: 200px;
                max-height: 200px;
                overflow: hidden;
                margin: 0 auto;
            }
            #preview_image_create,#preview_image_edit_{
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                display: block;
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
                                        <td><button type="button" class="badge
                                        @if ($row->status == 'Publish') bg-primary
                                        @elseif ($row->status == 'Draft') bg-info
                                        @elseif ($row->status == 'Berlangsung') bg-secondary
                                        @elseif ($row->status == 'Selesai') bg-success
                                        @endif
                                        rounded-3" disabled>{{ $row->status }}</button></td>
                                       <td class="text-center">
                                            {{-- Tombol Rincian --}}
                                            <a href="{{ route('event.rincian', $row->id_event) }}"
                                                class="btn btn-primary btn-sm rounded text-white mb-3">
                                                <i class="fa-solid fa-code" style="font-size: 0.75rem; color: white;"></i>
                                                <span class="text-white">Rincian</span>
                                            </a>

                                            {{-- Tombol Edit (modal) --}}
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_event }}"
                                                class="btn btn-info btn-sm rounded text-white mb-3">
                                                <i class="fa-regular fa-pen-to-square" style="font-size: 0.75rem; color: white;"></i>
                                                <span class="text-white">Edit</span>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <a href="{{ route('event.destroy', $row->id_event) }}" data-confirm-delete="true" class="btn btn-danger btn-sm rounded text-white mb-3"><i class="fa-regular fa-trash-can" style="font-size: 0.75rem; color: white;"></i><span class="text-white">Delete</span>
                                            </a>

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
                                        <td><button type="button" class="badge bg-warning rounded-3"
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
                                            <td><button type="button" class="badge bg-primary rounded-3"
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
                                            <td><button type="button" class="badge bg-secondary rounded-3"
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
                                            <td><button type="button" class="badge bg-success rounded-3"
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
                    <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="mb-3">
                                <label for="page_id" class="form-label">Page Id</label>
                                <select class="form-select js-example-basic-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page id"
                                        required>
                                        <option selected></option>
                                        @foreach ($page as $row)
                                        <option value="{{ $row->id_page }}" >{{ $row->nama_page }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col">
                                {{-- kanan --}}
                                    <div class="mb-3">
                                        <label for="nama_event" class="form-label ">Nama Event</label>
                                        <input type="text" class="form-control" name="nama_event" id="nama_event"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Event</label>
                                        <input type="date" class="form-control" name="tgl_mulai"
                                            id="tgl_mulai" placeholder="DD/MM/YYYY" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_event_id" class="form-label">Jenis Event</label>
                                        <select class="form-select js-example-basic-single" name="jenis_event_id" aria-label="Default select example" data-placeholder="Pilih Jenis event"
                                            required>
                                            <option selected></option>
                                            @foreach ($jenisEvt as $row)
                                            <option value="{{ $row->id_jenis_event }}">{{ $row->nama_jenis_event }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_id" class="form-label">Tempat</label>
                                        <select class="form-select js-example-basic-single" name="tempat_id" aria-label="Default select example" data-placeholder="Pilih Kota"
                                                required>
                                                <option selected></option>
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
                                    <select class="form-select js-example-basic-single" name="instansi_id" aria-label="Default select example" data-placeholder="Pilih Instansi"
                                            required>
                                            <option disabled selected></option>
                                            @foreach ($instansi as $row)
                                            <option value="{{ $row->id_instansi }}" >{{ $row->nama_instansi }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label for="tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir"
                                        placeholder="DD/MM/YYYY" required>
                                </div>
                                <div class="mt-3">
                                    <label for="biaya_regis" class="form-label">Biaya</label>
                                    <div class="input-group mb-3 ">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control currency" aria-label="Dollar amount (with dot and two decimal places)" name="biaya_regis" required>
                                    </div>
                                </div>
                                  <div class="mb-3">
                                    <label for="visibilitas" class="form-label">Visibilitas</label>
                                    <select class="form-select text-capitalize js-example-basic-single" name="visibilitas" aria-label="Default select example" data-placeholder="Pilih Visibilitas"
                                            required>
                                            <option class="text-capitalize" selected>publik</option>
                                            <option class="text-capitalize">privat</option>
                                        </select>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="control-label mb-2">Upload Banner <span class="text-danger">*</span></label>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Pilih gambar atau seret ke sini .</p>
                                    </div>
                                    <input type="file" name="path_banner" class="dropzone" accept="image/*" required>
                                    <div id="image_preview_" class="mt-3">
                                        <img id="preview_image_create" src="" alt="Image preview" style="display: none;">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                                </div>
                                @error('foto')
                                <div class="text-danger">{{ $message }}</div>
                               @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="logo" class="form-label">Upload Banner</label>
                                <input class="form-control" name="logo" type="file" id="formFile" accept=".png, .jpg, .jpeg" required>
                              </div> --}}
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
                            name="status" value="Publish" >
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
                    <form action="{{ route('event.update', $row->id_event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                    <div class="container">
                        <div class="row">
                            <div class="mb-3">
                                <label for="page_id" class="form-label">Page Id</label>
                                <select class="form-select js-example-basic-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page id"
                                        required>
                                        @foreach ($page as $set)
                                        <option value="{{ $set->id_page }}" {{ $set->id_page == $row->page_id ? 'selected' : '' }}>{{ $set->nama_page }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col">
                                {{-- kanan --}}
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
                                        <select class="form-select js-example-basic-single" name="jenis_event_id" aria-label="Default select example" data-placeholder="Pilih jenis event"
                                            required>
                                            @foreach ($jenisEvt as $element)
                                            <option value="{{ $element->id_jenis_event }}" {{ $element->id_jenis_event == $row->jenis_event_id ? 'selected' : '' }}>{{ $element->nama_jenis_event }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_id" class="form-label">Tempat</label>
                                        <select class="form-select js-example-basic-single" name="tempat_id" aria-label="Default select example" data-placeholder="Pilih Kota"
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
                                    <select class="form-select js-example-basic-single" name="instansi_id" aria-label="Default select example" data-placeholder=""
                                            required>
                                            @foreach ($instansi as $list)
                                            <option value="{{ $list->id_instansi }}" {{ $list->id_instansi == $row->instansi_id ? 'selected' : '' }}>{{ $list->nama_instansi }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label for="tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir"
                                        placeholder="DD/MM/YYYY" value="{{ $row->tgl_berakhir }}" required>
                                </div>
                                <div class="mt-3">
                                    <label for="biaya_regis" class="form-label">Biaya</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control currency" aria-label="Dollar amount (with dot and two decimal places)" name="biaya_regis" value="{{ $row->biaya_regis }}" required>
                                    </div>
                                </div>
                                  <div class="mb-3">
                                    <label for="visibilitas" class="form-label">Visibilitas</label>
                                    <select class="form-select text-capitalize js-example-basic-single" name="visibilitas" aria-label="Default select example" data-placeholder="Pilih Visibilitas"
                                            required>
                                            <option class="text-capitalize"  {{ $row->visibilitas == 'publish' ? 'selected' : '' }}>publik</option>
                                            <option class="text-capitalize"  {{ $row->visibilitas == 'privat' ? 'selected' : '' }}>privat</option>
                                        </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label  class="control-label mb-2">Upload Banner <span class="text-danger">*</span></label>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Pilih gambar atau seret ke sini</p>
                                    </div>
                                    <input type="file" class="dropzone" name="path_banner" id="path_banner_{{ $row->id_event }}" accept="image/*">
                                    <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                        @if ($row->path_banner)
                                            <img id="preview_image_edit_{{$row->id_event}}" src="{{ asset($row->path_banner) }}" alt="image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <img id="preview_image_edit_{{ $row->id_event }}" src="" alt="no image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                                </div>
                                @error('path_foto')
                                <div class="text-danger">{{ $message }}</div>
                               @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="logo" class="form-label">Upload Banner</label>
                                <input class="form-control" name="logo" type="file" id="formFile" accept=".png, .jpg, .jpeg">
                              </div> --}}
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
                               name="status_checkbox" {{ in_array($row->status, ['Selesai', 'Berlangsung', 'Publish']) ? 'checked' : '' }}>
                        <input type="hidden" name="status" value="Draft">
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
<!-- Include JS Select2 -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    {{-- <script>
  $(document).ready(function() {
        $('.js-example-basic-single').each(function() {
            var placeholder = $(this).data('placeholder');

            $(this).select2({
                placeholder: placeholder,
                allowClear: true,
                minimumResultsForSearch: Infinity
            });
        });
    });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusCheckbox = document.getElementById('status');
            const hiddenInput = document.querySelector('input[name="status"]');

                hiddenInput.value = statusCheckbox.checked ? 'Publish' : 'Draft';

                statusCheckbox.addEventListener('change', function() {
                    hiddenInput.value = this.checked ? 'Publish' : 'Draft';
            });
        });
        </script>
    {{-- dropzone create --}}
    <script>
     document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi preview image
        const inputFile = document.querySelector('input[name="path_banner"]');
        const preview = document.getElementById('preview_image_create');


        if (preview) {
        preview.style.display = 'none';

        inputFile.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                if (preview) { // Cek apakah preview tidak null
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                } else {
                    console.error('Preview element not found');
                }
            }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    if (preview) {
                        preview.src = '';
                        preview.style.display = 'none';
                    }
                }
            });
        } else {
            console.error('Preview image element not found');
        }


        // Inisialisasi Dropzone
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone-wrapper", {
            url: "/event", // URL server untuk unggahan
            maxFilesize: 2,
            acceptedFiles: "image/*",
            init: function() {
                this.on("success", function(file, response) {
                    // Tangani response sukses
                    console.log("Upload successful");
                });
                this.on("error", function(file, response) {
                    const errorElement = document.getElementById('image_error');
                    if (errorElement) {
                        errorElement.innerHTML = response.message || 'Upload failed';
                    }
                });
            }
        });
    });
</script>
{{-- dropzone edit --}}
<script>
  document.querySelectorAll('[id^="path_banner"]').forEach(input => {
    input.addEventListener('change', function(event) {
        const id = this.id.split('_')[2]; // Mengambil ID dari input
        const preview = document.getElementById(`preview_image_edit_${id}`); // Mengambil elemen preview yang sesuai
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Tampilkan preview gambar
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none'; // Sembunyikan gambar jika tidak ada file
        }
    });
  });
</script>

<script src="
https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js
"></script>
<script>
    var cleave = document.getElementsByClassName('currency');
    for (let index = 0; index < cleave.length; index++) {
        const element = cleave[index];
        new Cleave(element, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    }
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script>
    var myNumeral = numeral(1000);

    var value = myNumeral.value();
</script>
@endsection

