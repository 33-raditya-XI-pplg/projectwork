@extends('layouts.panel.index')
@section('content')
    <div class="container mt-4">
        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <div class="card-title mb-3">Pilih Even & Skema</div>
            <nav>
                <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pilih Event</button>
                  <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-draft" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pilih Skema</button>
                  <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-publish" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Submit</button>
                </div>
              </nav>
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
                        <div class="card-title mb-3">Detail Event</div>
                        <table id="example" class="table">
                            <thead class="fw-normal">
                                <th scope="col">Nama Perserta</th>
                                <th scope="col">Nilai Peserta</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Aksi</th>
                            </thead>
                            <tbody class="" style="vertical-align: middle">
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td>Dedi {{ $i }}</td>
                                        <td>90</td>
                                        <td>14-02-2024</td>
                                        <td>
                                            <a href="{{route('penilaian.create')}}" class="btn btn-sm btn-primary rounded">+ Input Nilai</a>
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
