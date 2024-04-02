@extends('layouts.panel.index')
@section('title', 'Jenis Event')
@section('content')

    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }
        </style>
    @endpush


    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <table id="example" class="table">
            <thead class="fw-normal">
                <th>No</th>
                <th scope="col ">Jenis Event</th>
                <th scope="col" style="width: 60%;">Deskripsi</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </thead>
            <tbody class="" style="vertical-align: middle">
                @foreach ($jenis_event as $row)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $row->nama_jenis_event }}</td>
                        <td>@php 
                            echo $row->deskripsi
                            @endphp
                        </td>
                        <td><button type="button" class="btn rounded-3 {{ $row->status == 'Aktif' ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>{{ $row->status }}</button>
                        </td>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $row->id_jenis_event }}"><i
                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                    <li><a href="{{ route('jenis-event.destroy', $row->id_jenis_event) }}" class="dropdown-item text-danger"
                                            data-confirm-delete="true"><i class="fa-regular fa-trash-can pe-none"></i>
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



    <!-- insert -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Event</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="mb-3">
                            <form action="{{ route('jenis-event.store') }}" method="POST">
                                @csrf
                                <label for="nama_jenis_event" class="form-label">Nama Jenis Event</label>
                                <input type="text" class="form-control" name="nama_jenis_event" id="nama_jenis_event" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label h-100">Deskripsi</label>
                            <textarea class="form-control ck-editor" id="deskripsi" name="deskripsi"></textarea>
                        </div>
                        <div class="form-check">
                            <label for="has_lampiran" class="me-3">Memiliki Lampiran </label>
                            <input class="form-check-input" type="checkbox" value="1" id="has_lampiran" name="has_lampiran" checked>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div class="form-check form-switch mb-3">
                        <label for="status" class="me-3">Status</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Aktif">
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($jenis_event as $row)
        <!-- edit -->
        <div class="modal modal-lg fade" id="edit{{ $row->id_jenis_event }}" tabindex="-1" aria-labelledby="add"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Event</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        <div class="container">
                            <div class="mb-3">
                                <form action="{{ route('jenis-event.update', $row->id_jenis_event) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label for="nama_jenis_event" class="form-label">Nama Jenis Event</label>
                                <input type="text" class="form-control" name="nama_jenis_event" id="nama_jenis_event"
                                    required value="{{ $row->nama_jenis_event }}">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control ck-editor" id="deskripsi-edit" name="deskripsi" rows="10">{{ $row->deskripsi }}</textarea>
                            </div>
                            <div class="form-check">
                                <label for="has_lampiran" class="me-3">Memiliki Lampiran </label>
                                <input class="form-check-input" type="checkbox" role="switch" id="has_lampiran" 
                                    name="has_lampiran" value="1" @if($row->has_lampiran) checked @endif>
                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch mb-3">
                            <label for="status" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                name="status" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}>
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach



@endsection
