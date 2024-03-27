@extends('layouts.panel.index')
@section('title', 'Tanda Tangan')
@section('content')


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th>No</th>
                    <th scope="col ">Nama TTD</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Instansi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($tanda_tangan as $row)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $row->nama_ttd }}</td>
                            <td>{{ $row->jabatan }}</td>
                            <td>{{ $row->nomor_induk }}</td>
                            <td>{{ $row->ttdInstansi->nama_instansi }}</td>
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
                                                data-bs-target="#edit{{ $row->id_ttd }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                        <li><a href="{{ route('tandatangan.destroy', $row->id_ttd) }}" class="dropdown-item text-danger"
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
                                <form action="{{ route('tandatangan.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
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
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nomor_induk" id="nomor_induk"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Instansi</label>
                                        <select name="instansi_id" id="instansi_id" class="form-select" required>
                                            <option selected disabled>Pilih...</option>
                                            @foreach($instansi as $row)
                                                <option value="{{ $row->id_instansi }}">{{ $row->nama_instansi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="tanda_tangan">Tanda Tangan</label>
                                        <input class="form-control mt-2" name="foto_ttd" type="file" id="formFile" accept=".png" required>
                                    </div>
                            </div>
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
                        <button type="button" class="btn btn-danger rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($tanda_tangan as $row)
    <!-- edit -->
        <div class="modal modal-lg fade" id="edit{{ $row->id_ttd }}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
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
                                    <form action="{{ route('tandatangan.update', $row->id_ttd) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                                        <div class="mb-3">
                                        <label for="nama_ttd" class="form-label">Nama TTD</label>
                                        <input type="text" class="form-control" name="nama_ttd" id="nama_ttd"
                                            required value="{{ $row->nama_ttd }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan"
                                            required value="{{ $row->jabatan }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nomor_induk" id="nomor_induk"
                                            required value="{{ $row->nomor_induk }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Instansi</label>
                                        <select name="instansi_id" id="instansi_id" class="form-select" required>
                                            <option selected disabled>Pilih...</option>
                                            @foreach($instansi as $a)
                                                    <option value="{{ $a->id_instansi }}" {{ $row->instansi_id == $a->id_instansi ? 'selected' : '' }}>
                                                    {{ $a->nama_instansi }}
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="tanda_tangan">Tanda Tangan</label>
                                        <input class="form-control" name="gambar_tanda_tangan" type="file" id="formFile" accept=".png">
                                    </div>
                                </div>

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
                            <button type="button" class="btn btn-danger rounded-3"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
