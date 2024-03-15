@extends('layouts.panel.index')
@section('title', 'Tanda Tangan')
@section('content')


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th scope="col ">Nama TTD</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Instansi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <td>Pematik {{ $i }}</td>
                            <td>Seminar</td>
                            <td>8650295</td>
                            <td>Mascitra.COM</td>
                            <td><a class="btn btn-sm btn-outline-success rounded disabled">Aktif</a></td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $i }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                        <li><a href="{{ route('event.destroy', $i) }}" class="dropdown-item text-danger"
                                                data-confirm-delete="true"><i class="fa-regular fa-trash-can pe-none"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>



    <!-- insert -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tanda Tangan</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                {{-- kanan --}}
                                <form action="{{ route('event.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_ttd" class="form-label">Nama TTD</label>
                                        <input type="text" class="form-control" name="nama_ttd" id="nama_ttd"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nik" id="nik"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Instansi</label>
                                        <input type="text" class="form-control" name="instansi" id="instansi"
                                            required>
                                    </div>
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                      </div>
                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit -->
    @for ($i = 0; $i < 9; $i++)
        <div class="modal modal-lg fade" id="edit{{ $i }}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
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
                                    <form action="{{ route('event.update', $i) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="nama_ttd" class="form-label">Nama TTD</label>
                                            <input type="text" class="form-control" name="nama_ttd" id="nama_ttd"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jabatan" class="form-label">Jabatan</label>
                                            <input type="text" class="form-control" name="jabatan" id="jabatan"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nik" class="form-label">NIK</label>
                                            <input type="text" class="form-control" name="nik" id="nik"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="instansi" class="form-label">Instansi</label>
                                            <input type="text" class="form-control" name="instansi" id="instansi"
                                                required>
                                        </div>
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                          </div>
                                </div>

                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endfor
@endsection
