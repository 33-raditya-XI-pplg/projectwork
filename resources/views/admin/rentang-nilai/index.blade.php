@extends('layouts.panel.index')
@section('title', 'Rentang Nilai')
@section('content')

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <table id="example" class="table">
        <thead class="fw-normal">
            <th>No</th>
            <th scope="col ">Nama</th>
            <th scope="col">Inisial</th>
            <th scope="col">Rentang Atas</th>
            <th scope="col">Rentang Bawah</th>
            <th scope="col">Aksi</th>
        </thead>
        <tbody class="" style="vertical-align: middle">
            {{-- loop --}}
                
                <tr>
                    {{-- <th scope="row">{{ $loop->index + 1 }}</th> --}}
                    <th scope="row">1</th>
                    <td>ABCD</td>
                    <td>AB</td>
                    <td>75</td>
                    <td>90</td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                        data-bs-target="#edit1"><i
                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                <li><a href="{{ route('rentang-nilai.destroy', 1) }}" class="dropdown-item text-danger"
                                        data-confirm-delete="true"><i class="fa-regular fa-trash-can pe-none"></i>
                                        Delete</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            {{-- endloop --}}
        </tbody>
    </table>
</div>

{{-- insert --}}
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- form --}}
                <div class="container">

                            <form action="{{ route('rentang-nilai.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                <div class="mb-3">
                                    <label for="nama_konversi_nilai" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_konversi_nilai" id="nama_konversi_nilai"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="inisial_rentang_nilai" class="form-label">Inisial</label>
                                    <input type="text" class="form-control" name="inisial_rentang_nilai" id="inisial_rentang_nilai"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="rentang_atas" class="form-label">Rentang Atas</label>
                                    <input type="number" class="form-control" name="rentang_atas" id="rentang_atas" required>
                                </div>
                                <div class="mb-3">
                                    <label for="rentang_bawah" class="form-label">Rentang Atas</label>
                                    <input type="number" class="form-control" name="rentang_bawah" id="rentang_bawah" required>
                                </div>
                </div>
                {{-- end form --}}

            </div>
            <div class="modal-footer justify-end mx-3">
                <div>
                    <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- edit --}}
<div class="modal modal-lg fade" id="edit1" tabindex="-1" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- form --}}
                <div class="container">

                            <form action="{{ route('rentang-nilai.update', 1) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                                <div class="mb-3">
                                    <label for="nama_konversi_nilai" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_konversi_nilai" id="nama_konversi_nilai" value="ABCD"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="inisial_rentang_nilai" class="form-label">Inisial</label>
                                    <input type="text" class="form-control" name="inisial_rentang_nilai" id="inisial_rentang_nilai" value="AB"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="rentang_atas" class="form-label">Rentang Atas</label>
                                    <input type="number" class="form-control" name="rentang_atas" id="rentang_atas" value="75" required>
                                </div>
                                <div class="mb-3">
                                    <label for="rentang_bawah" class="form-label">Rentang Atas</label>
                                    <input type="number" class="form-control" name="rentang_bawah" id="rentang_bawah" value="90" required>
                                </div>
                </div>
                {{-- end form --}}

            </div>
            <div class="modal-footer justify-end mx-3">
                <div>
                    <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection