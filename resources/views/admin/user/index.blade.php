@extends('layouts.panel.index')
@section('title', 'Pengguna')
@section('content')

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h1>Pengguna</h1>
            </div>
            <div>
                <button class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#add">+ Tambah</button>
            </div>
        </div>


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th scope="col ">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>Mahmud Efendi</td>
                            <td>Mahmud@gmail.com</td>
                            <td>350918102909{{ $i }}</td>
                            <td>Laki-laki</td>
                            <td><button type="button" class="btn btn-outline-success rounded-3" disabled>Aktif</button></td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $i }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                        <li><a href="{{ route('user.destroy', $i) }}" class="dropdown-item text-danger"
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
    </div>


    <!-- insert -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Event</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="mb-3">
                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select mb-3" aria-label="form-select example">
                                <option selected>Laki-laki</option>
                                <option value="1">Perempuan</option>
                              </select>
                        </div>
                        <label for="status" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="status" checked>
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

    @for ($i = 0; $i < 9; $i++ )
        
    <!-- edit -->
    <div class="modal fade" id="edit{{ $i }}" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pengguna</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="mb-3">
                            <form action="{{ route('user.update', $i) }}" method="POST">
                                @csrf
                                @method('PUT')
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select mb-3" aria-label="form-select example">
                                <option selected>Laki-laki</option>
                                <option value="1">Perempuan</option>
                              </select>
                        </div>
                        <label for="status" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="status" checked>
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
