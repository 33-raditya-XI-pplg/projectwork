@extends('layouts.panel.index')
@section('title', 'Kategori')
@section('content')

<h1>Kategori</h1>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <table id="example" class="table">
        <thead class="fw-normal">
            <tr>
                <th>No</th>
                <th scope="col">Nama Kategori</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="" style="vertical-align: middle">
            @foreach ($kategori as $index => $row)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $row->nama_kategori }}</td>
                    <td>{{ $row->deskripsi }}</td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                       data-bs-target="#edit{{ $row->id_kategori }}">
                                       <i class="fa-regular fa-pen-to-square"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('kategori.destroy', $row->id_kategori) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal modal-lg fade" id="edit{{ $row->id_kategori }}" tabindex="-1" aria-labelledby="editLabel{{ $row->id_kategori }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary-gradient text-white">
                                <h5 class="modal-title" id="editLabel{{ $row->id_kategori }}">Edit Kategori</h5>
                                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Form --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <form action="{{ route('kategori.update', $row->id_kategori) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                                                <div class="mb-3">
                                                    <label for="nama_kategori{{ $row->id_kategori }}" class="form-label">Nama Kategori</label>
                                                    <input type="text" class="form-control" name="nama_kategori"
                                                           id="nama_kategori{{ $row->id_kategori }}" value="{{ $row->nama_kategori }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="deskripsi{{ $row->id_kategori }}" class="form-label">Deskripsi</label>
                                                    <textarea class="form-control" id="deskripsi{{ $row->id_kategori }}" name="deskripsi" rows="2">{{ $row->deskripsi }}</textarea>
                                                </div>

                                                <div class="modal-footer justify-content-between mx-3">
                                                    <div class="form-check form-switch">
                                                        <label for="status{{ $row->id_kategori }}" class="me-3">Status</label>
                                                        <input class="form-check-input" type="checkbox" role="switch" id="status{{ $row->id_kategori }}"
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
                                {{-- End Form --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Edit Modal -->
            @endforeach
        </tbody>
    </table>
</div>

<!-- Insert Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Form --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                <input type="hidden" name="password" value="kategori">
                                <input type="hidden" name="level" value="kategori">
                                <div class="mb-3">
                                    <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                                </div>

                                <div class="modal-footer justify-content-between mx-3">
                                    <div class="form-check form-switch mb-3">
                                        <label for="status" class="me-3">Status </label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="Aktif">
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
                {{-- End Form --}}
            </div>
        </div>
    </div>
</div>
<!-- End of Insert Modal -->

@endsection
