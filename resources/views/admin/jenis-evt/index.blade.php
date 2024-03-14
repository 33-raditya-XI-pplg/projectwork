@extends('layouts.panel.index')
@section('title', 'Jenis Event')
@section('content')

    <div class="container mt-4">
        <div class="d-flex justify-content-end mb-3">
            <div>
                <button class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#add">+ Tambah</button>
            </div>
        </div>


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th scope="col ">Nama Event</th>
                    <th scope="col" style="width: 60%;">Deskripsi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>Seminar {{ $i }}</td>
                            <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Maiores odio accusamus incidunt iusto officiis mollitia quia ut voluptas reprehenderit laboriosam!</td>
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
                                        <li><a href="{{ route('jenis-event.destroy', $i) }}" class="dropdown-item text-danger"
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
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
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
                            <label for="jenis_event" class="form-label">Nama Event</label>
                            <input type="text" class="form-control" name="jenis_event" id="jenis_event"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="10"></textarea>
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
    <div class="modal modal-lg fade" id="edit{{ $i }}" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Event</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="mb-3">
                            <form action="{{ route('jenis-event.update', $i) }}" method="POST">
                                @csrf
                                @method('PUT')
                            <label for="jenis_event" class="form-label">Nama Event</label>
                            <input type="text" class="form-control" name="jenis_event" id="jenis_event"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="10"></textarea>
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
