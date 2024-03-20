@extends('layouts.panel.index')
@section('title', 'Penguji')
@section('content')

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <table id="example" class="table">
            <thead class="fw-normal">
                <th scope="col ">Nama Penguji</th>
                <th scope="col">Instansi</th>
                <th scope="col">NIK</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </thead>
            <tbody class="" style="vertical-align: middle">
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td>Bambang Suryadi {{ $i }}</td>
                        <td>PT. Solusi Kreatif Digital</td>
                        <td>35076801144007890</td>
                        <td>Direktur Utama</td>
                        <td><button type="button" class="btn btn-outline-success rounded-3" disabled>Aktif</button></td>
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
                                    <li><a href="{{ route('penguji.destroy', $i) }}" class="dropdown-item text-danger"
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
                                <form action="{{ route('penguji.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_penguji" class="form-label">Nama Penguji</label>
                                        <input type="text" class="form-control" name="nama_penguji" id="nama_penguji"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi_penguji" class="form-label">Instansi</label>
                                        <input type="text" class="form-control" name="instansi_penguji"
                                            id="instansi_penguji" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" name="alamat" id="alamat" required>
                                    </div>
                                    <div>
                                        <label for="no" class="form-label">No. telp</label>
                                        <input type="text" class="form-control" name="no" id="no" required>
                                    </div>

                            </div>
                            <div class="col">
                                {{-- kiri --}}
                                <div class="mb-3">
                                    <label for="nomor_induk" class="form-label">NIK</label>
                                    <input type="text" class="form-control" name="nomor_indux" id="nomor_indux" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan_penguji" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan_penguji" id="jabatan_penguji"
                                        required>
                                </div>
                                <div class="mb-5">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" required>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary rounded-3 text-start" type="button">Upload Foto <i
                                            class="fa-solid fa-upload"></i></button>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div class="form-check form-switch">
                        <label for="status" class="">Status</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                            name="status" checked>
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

    @for ($i = 0; $i < 10; $i++)
        <!-- edit -->
        <div class="modal modal-lg fade" id="edit{{ $i }}" tabindex="-1" aria-labelledby="add"
            aria-hidden="true">
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
                                    <form action="{{ route('penguji.update', $i) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="nama_penguji" class="form-label">Nama Penguji</label>
                                            <input type="text" class="form-control" name="nama_penguji"
                                                id="nama_penguji" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="instansi_penguji" class="form-label">Instansi</label>
                                            <input type="text" class="form-control" name="instansi_penguji"
                                                id="instansi_penguji" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat"
                                                required>
                                        </div>
                                        <div>
                                            <label for="no" class="form-label">No. telp</label>
                                            <input type="text" class="form-control" name="no" id="no"
                                                required>
                                        </div>

                                </div>
                                <div class="col">
                                    {{-- kiri --}}
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nomor_indux" id="nomor_indux"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan_penguji" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan_penguji"
                                            id="jabatan_penguji" required>
                                    </div>
                                    <div class="mb-5">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" id="email"
                                            required>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary rounded-3 text-start" type="button">Upload Foto <i
                                                class="fa-solid fa-upload"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch">
                            <label for="status" class="">Status</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                                name="status" checked>
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
    @endfor



@endsection
