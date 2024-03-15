@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')

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
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td>Pematik {{ $i }}</td>
                                        <td>Seminar</td>
                                        <td>18-10-2024</td>
                                        <td>22-10-2024</td>
                                        <td>Mascitra.com</td>
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
                                                            data-bs-target="#edit{{ $i }}"><i
                                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                    <li><a href="{{ route('event.destroy', $i) }}"
                                                            class="dropdown-item text-danger" data-confirm-delete="true"><i
                                                                class="fa-regular fa-trash-can pe-none"></i>
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
                                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-bars"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item text-info" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit{{ $i }}"><i
                                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                    <li><a href="{{ route('event.destroy', $i) }}"
                                                            class="dropdown-item text-danger"
                                                            data-confirm-delete="true"><i
                                                                class="fa-regular fa-trash-can pe-none"></i>
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

                    {{--  --}}
                </div>
                <div class="tab-pane fade" id="nav-publish" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="mt-4 text-center">
                        No data available!
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-live" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="mt-4 text-center">
                        No data available!
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-end" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="mt-4 text-center">
                        No data available!
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- insert -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
                                        <input type="date" class="form-control" name="tanggal_event"
                                            id="tanggal_event" placeholder="DD/MM/YYYY" required>
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
                                    <input type="text" class="form-control" name="id_instansi" id="id_instansi"
                                        required>
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
                                <label for="status" class="form-label mt-3">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked" name="status" checked>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
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
        <div class="modal modal-lg fade" id="edit{{ $i }}" tabindex="-1" aria-labelledby="edit"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
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
                                    <label for="status" class="form-label mt-3">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked" name="status" checked>
                                </div>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
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
