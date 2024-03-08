@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h1>Event</h1>
            </div>
            <div>
                <button class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#add">+ Tambah</button>
            </div>
        </div>


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th scope="col ">Nama Event</th>
                    <th scope="col">Jenis Event</th>
                    <th scope="col">Tanggal Event</th>
                    <th scope="col">Tanggal Berakhir</th>
                    <th scope="col">Nama Instansi</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>Pematik {{ $i }}</td>
                            <td>Seminar</td>
                            <td>18-10-2024</td>
                            <td>22-10-2024</td>
                            <td>Mascitra.com</td>
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
                        <div class="row">
                            <div class="col">
                                {{-- kanan --}}
                                <form action="{{ route('user.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_event" class="form-label">Nama Event</label>
                                        <input type="text" class="form-control" name="nama_event" id="nama_event"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_event" class="form-label">Tanggal Event</label>
                                        <input type="date" class="form-control" name="tanggal_event" id="tanggal_event"
                                            placeholder="DD/MM/YYYY" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Tanggal Berakhir</label>
                                        <input type="date" class="form-control" id="exampleFormControlInput1"
                                            placeholder="DD/MM/YYYY" required>
                                    </div>
                            </div>
                            <div class="col">
                                {{-- kiri --}}
                                <div class="mb-3">
                                    <label for="id_instansi" class="form-label">Nama Instansi</label>
                                    <input type="text" class="form-control" name="id_instansi" id="id_instansi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Jenis Event</label>
                                    <select class="form-select" name="jenis_event" aria-label="Default select example"
                                        required>
                                        <option selected>Open this ...</option>
                                        <option value="1">Seminar</option>
                                        <option value="2">Seminar</option>
                                        <option value="3">Seminar</option>
                                    </select>
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
    @for ($i = 0; $i < 5; $i++)
        <div class="modal fade" id="edit{{ $i }}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
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
                                    <form action="{{ route('user.update', $i) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="nama_event" class="form-label">Nama Event</label>
                                            <input type="text" class="form-control" name="nama_event" id="nama_event"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_event" class="form-label">Tanggal Event</label>
                                            <input type="date" class="form-control" name="tanggal_event"
                                                id="tanggal_event" placeholder="DD/MM/YYYY" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Tanggal
                                                Berakhir</label>
                                            <input type="date" class="form-control" id="exampleFormControlInput1"
                                                placeholder="DD/MM/YYYY" required>
                                        </div>
                                </div>
                                <div class="col">
                                    {{-- kiri --}}
                                    <div class="mb-3">
                                        <label for="id_instansi" class="form-label">Nama Instansi</label>
                                        <input type="text" class="form-control" name="id_instansi" id="id_instansi"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Jenis Event</label>
                                        <select class="form-select" name="jenis_event"
                                            aria-label="Default select example" required>
                                            <option selected>Open this ...</option>
                                            <option value="1">Seminar</option>
                                            <option value="2">Seminar</option>
                                            <option value="3">Seminar</option>
                                        </select>
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
