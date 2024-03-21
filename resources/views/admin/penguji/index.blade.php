@extends('layouts.panel.index')
@section('title', 'Penguji')
@section('content')


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th scope="col">Nama Penguji</th>
                    <th scope="col">Instansi</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($penguji as $row)
                        <tr>
                            <td>{{ $row->nama_lengkap }}</td>
                            <td>{{ $row->userInstansi->nama_instansi }}</td>
                            <td>{{ $row->nomor_induk }}</td>
                            <td>{{ $row->jabatan_penguji }}</td>
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
                                                data-bs-target="#edit{{ $row->id_user }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                        <li><a href="{{ route('penguji.destroy', $row->id_user) }}" class="dropdown-item text-danger"
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Penguji</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                {{-- kanan --}}
                                <form action="{{ route('penguji.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                    <input type="hidden" name="password" value="Penguji">
                                    <input type="hidden" name="level" value="Penguji">
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Penguji</label>
                                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Instansi</label>
                                        <select name="instansi_id" id="instansi_id" class="form-select">
                                            <option selected>Pilih...</option>
                                            @foreach($instansi as $row)
                                                <option value="{{ $row->id_instansi }}">{{ $row->nama_instansi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" name="alamat" id="alamat" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="no_telp" class="form-label">No. telp</label>
                                        <input type="text" class="form-control" name="no_telp" id="no_telp" required>
                                    </div>
                                    <div>
                                        <input class="form-control" name="foto" type="file" id="formFile" accept=".png" required>
                                    </div>

                            </div>
                            <div class="col">
                                {{-- kiri --}}
                                <div class="mb-3">
                                    <label for="nomor_induk" class="form-label">NIK</label>
                                    <input type="text" class="form-control" name="nomor_induk"
                                        id="nomor_induk" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan_penguji" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan_penguji" id="jabatan_penguji" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat_kota" class="form-label">Kota</label>
                                    <input type="text" class="form-control" name="alamat_kota" id="alamat_kota"
                                        required>
                                </div>
                                <div class="mb-5">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" required>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div>
                        <label for="status" class="me-3">Status </label>
                        <input class="form-check-input"  type="checkbox" data-toggle="switchbutton" checked data-onlabel="Aktif" data-offlabel="Nonaktif" data-onstyle="primary" data-offstyle="danger" data-size="xs" data-width="75" value="Aktif">
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

    @foreach ($penguji as $row)
        <!-- edit -->
        <div class="modal modal-lg fade" id="edit{{ $row->id_user }}" tabindex="-1" aria-labelledby="add"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Penguji</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    {{-- kanan --}}
                                    <form action="{{ route('penguji.update', $row->id_user) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label">Nama instansi</label>
                                            <input type="text" class="form-control" name="nama_lengkap"
                                                id="nama_lengkap" value="{{ $row->nama_lengkap }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="instansi" class="form-label">Instansi</label>
                                            <select class="form-select" id="instansi_id" name="instansi_id">
                                                <option selected disabled>Pilih...</option>
                                                @foreach($instansi as $a)
                                                    <option value="{{ $a->id_instansi }}" {{ $row->instansi_id == $a->id_instansi ? 'selected' : '' }}>
                                                    {{ $a->nama_instansi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat" value="{{ $row->alamat }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="no" class="form-label">No. telp</label>
                                            <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ $row->no_telp }}" required>
                                        </div>
                                        <div>
                                            <input class="form-control" name="logo" type="file" id="formFile" accept=".png">
                                        </div>

                                </div>
                                <div class="col">
                                    {{-- kiri --}}
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nomor_induk"
                                            id="nomor_induk" value="{{ $row->nomor_induk }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan_penguji" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan_penguji"
                                            id="jabatan_penguji" value="{{ $row->jabatan_penguji }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat_kota" class="form-label">Kota</label>
                                        <input type="text" class="form-control" name="alamat_kota" id="alamat_kota" value="{{ $row->alamat_kota }}" required>
                                    </div>
                                    <div>
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" id="email" value="{{ $row->email }}" required>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div>
                            <label for="status" class="me-3">Status</label>
                            <input class="form-check-input"  type="checkbox" data-toggle="switchbutton" data-onlabel="Aktif" data-offlabel="Nonaktif" data-onstyle="primary" data-offstyle="danger" data-size="xs" data-width="75" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}>
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
