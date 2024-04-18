@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')
    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        {{-- kanan --}}
                        
                        <div class="mb-3">
                            <label for="nama_event" class="form-label">Nama Event</label>
                            <input type="hidden" name="event_id" value="{{ request()->route('event') }}">
                            <input type="text" class="form-control" name="nama_event" id="nama_event"
                                value="{{ $evt->nama_event }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Event</label>
                            <input type="date" class="form-control" name="tgl_mulai" id="tanggal_mulai"
                                placeholder="DD/MM/YYYY" value="{{ $evt->tgl_mulai }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_event_id" class="form-label">Jenis Event</label>
                            <select class="form-select" name="jenis_event_id" aria-label="Default select example" readonly>
                                <option selected>{{ \App\Models\Jenis_Event::find($evt->jenis_event_id)->nama_jenis_event }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tempat_id" class="form-label">Tempat</label>
                            <select class="form-select" name="tempat_id" aria-label="Default select example" readonly>
                                <option selected>{{ \App\Models\Tempat::find($evt->tempat_id)->nama_tempat }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        {{-- kiri --}}
                        <div class="mb-3">
                            <label for="instansi_id" class="form-label">Nama Instansi</label>
                            <select class="form-select" name="instansi_id" aria-label="Default select example" readonly>
                                <option selected>{{ \App\Models\Instansi::find($evt->instansi_id)->nama_instansi }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir"
                                placeholder="DD/MM/YYYY" value="{{ $evt->tgl_berakhir }}" readonly>
                        </div>
                        <label for="biaya_regis" class="form-label">Biaya</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control"
                                aria-label="Dollar amount (with dot and two decimal places)" name="biaya_regis"
                                value="{{ $evt->biaya_regis }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="visibilitas" class="form-label">Visibilitas</label>
                            <select class="form-select text-capitalize" name="visibilitas"
                                aria-label="Default select example" readonly>
                                <option class="text-capitalize" selected>{{ $evt->visibilitas }}</option>
                            </select>
                        </div>
                    </div>
                    <span for="logo" class="form-label">Banner</span>
                    <div class="mb-3 text-center">
                        <img src="{{ $evt->path_banner }}" height="200" alt="logo">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control ck-editor" id="deskripsi-edit" name="deskripsi" rows="4" readonly>@php
                            echo $evt->deskripsi;
                        @endphp</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="d-flex mb-2 me-3 justify-content-end">
            <a class="btn btn-primary rounded" href="{{ route('event-skema.create', $evt->id_event)}}">Tambah [+]</a>
        </div>
        <table id="example" class="table">
            <thead>
                <th>No</th>
                <th class="w-75" scope="col">Skema</th>
                <th scope="col">Aksi</th>
            </thead>
            <tbody>
                @foreach ($skema as $no)
                    
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ \App\Models\Skema::find($no)->nama_skema }}</td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item text-info" href="{{ route('event-skema.create', 1) }}"><i
                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                <li><a href="{{ route('event-skema.delete', $no) }}"
                                        class="dropdown-item text-danger" data-confirm-delete="true"><i
                                            class="fa-regular fa-trash-can pe-none"></i>
                                        Delete</a>
                                </li>
                                <li><a href="{{ route('event-skema.show', $no) }}"
                                        class="dropdown-item text-warning"><i class="fa-solid fa-code pe-none"></i>
                                        Rincian</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
