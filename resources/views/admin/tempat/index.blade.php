@extends('layouts.panel.index')
@section('title', 'Tempat')
@section('content')


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th>No</th>
                    <th scope="col">Nama Tempat</th>
                    <th scope="col">No. Telp</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Kota</th>
                    <th scope="col">Maps</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($tempat as $row)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $row->nama_tempat }}</td>
                            <td>{{ $row->no_telp }}</td>
                            <td>{{ $row->alamat }}</td>
                            <td>{{ $row->alamat_kota }}</td>
                            <td><a class="btn btn-outline-success btn-sm rounded" href="{{ $row->link_maps }}" target="blank">
                                Link <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $row->id_tempat }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                        <li><a href="{{ route('tempat.destroy', $row->id_tempat) }}" class="dropdown-item text-danger"
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah tempat</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                {{-- kanan --}}
                                <form action="{{ route('tempat.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_tempat }}">
                                    <div class="mb-3">
                                        <label for="nama_tempat" class="form-label">Nama tempat</label>
                                        <input type="text" class="form-control" name="nama_tempat" id="nama_tempat"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" name="alamat" id="alamat" required>
                                    </div>
                            </div>
                            <div class="col">
                                {{-- kiri --}}
                                <div class="mb-3">
                                        <label for="no_telp" class="form-label">No. telp</label>
                                        <input type="text" class="form-control" name="no_telp" id="no_telp" required>
                                    </div>
                                <div class="mb-3">
                                    <label for="alamat_kota" class="form-label">Kota</label>
                                    <input type="text" class="form-control" name="alamat_kota" id="alamat_kota"
                                        required>
                                </div>
                            </div>
                            <div class="form-group mb-5">
                                <label for="link_maps">Link Maps</label>
                                <textarea class="form-control" id="link_maps" name="link_maps" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div class="form-check form-switch mb-3" display="none">
                        <!-- <label for="status" class="me-3">Status</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Aktif"> -->
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

    @foreach ($tempat as $row)
        <!-- edit -->
        <div class="modal modal-lg fade" id="edit{{ $row->id_tempat }}" tabindex="-1" aria-labelledby="add"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="edit_tempat">Edit Tempat</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    {{-- kanan --}}
                                    <form action="{{ route('tempat.update', $row->id_tempat) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_tempat }}">
                                        <div class="mb-3">
                                            <label for="nama_tempat" class="form-label">Nama tempat</label>
                                            <input type="text" class="form-control" name="nama_tempat" id="nama_tempat"
                                                required value="{{ $row->nama_tempat }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat" required
                                            value="{{ $row->alamat }}">
                                        </div>
                                </div>
                                <div class="col">
                                    {{-- kiri --}}
                                    <div class="mb-3">
                                            <label for="no_telp" class="form-label">No. telp</label>
                                            <input type="text" class="form-control" name="no_telp" id="no_telp" required
                                            value="{{ $row->no_telp }}">
                                        </div>
                                    <div class="mb-3">
                                        <label for="alamat_kota" class="form-label">Kota</label>
                                        <input type="text" class="form-control" name="alamat_kota" id="alamat_kota"
                                            required value="{{ $row->alamat_kota }}">
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label for="link_maps">Link Maps</label>
                                    <textarea class="form-control" id="link_maps" name="link_maps" rows="3">{{ $row->link_maps }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch mb-3" display="none">
                            <!-- <label for="status" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                name="status" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}> -->
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

