@extends('layouts.panel.index')
@section('content')
    <div class="container mt-4">
        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                        type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pilih Event</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                        type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Pilih Skema</button>
                </li>
                <li>
                    <button class="btn btn-primary rounded" type="submit">Submit</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                    tabindex="0">
                    <div class="bg-white rounded-4 px-3 py-3 mb-5">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    {{-- kanan --}}
                                    <form action="#" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="nama_ttd" class="form-label">Nama Peserta</label>
                                                    <input type="text" class="form-control" name="nama_ttd" id="nama_ttd" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jabatan" class="form-label">Nomor Sertifikat</label>
                                                    <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
                                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="instansi" class="form-label">Tanggal Terbit</label>
                                                    <input type="text" class="form-control" name="instansi" id="instansi" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nik" class="form-label">Masa Berlaku</label>
                                                    <input type="text" class="form-control" name="nik" id="nik" required>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-4 px-3 py-3 mt-5">
                        <table id="example" class="table">
                            <thead class="fw-normal">
                                <th scope="col">Nama Perserta</th>
                                <th scope="col">Nomor Sertifikat</th>
                                <th scope="col">Tanggal Terbit</th>
                                <th scope="col">Masa Berlaku</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </thead>
                            <tbody class="" style="vertical-align: middle">
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td>Dedi {{ $i }}</td>
                                        <td>9240</td>
                                        <td>14-02-2024</td>
                                        <td>14-052024</td>
                                        <td><button type="button" class="btn btn-outline-success rounded-3"
                                                disabled>Aktif</button></td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-bars"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item text-info" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="sertifikat"><i
                                                                class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                    <li><a href="{{ route('sertifikat.destroy', $i) }}"
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
                </div>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    <div class="bg-white rounded-4 px-3 py-3 mt-3">
                <form action="">
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">Skema 1</option>
                        <option value="2">Skema 2</option>
                        <option value="3">Skema 3</option>
                        <option value="4">Skema 4</option>
                        <option value="5">Skema 5</option>
                        <option value="6">Skema 6</option>
                        <option value="7">Skema 7</option>
                      </select>
                </form>
                </div>
                </div>
                {{-- <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
                    tabindex="0">...</div> --}}
            </div>
        </div>
    </div>
@endsection
