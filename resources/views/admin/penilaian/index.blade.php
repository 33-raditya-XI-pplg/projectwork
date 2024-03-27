@extends('layouts.panel.index')
@section('title', 'Penilaian')
@section('content')


<div class="container mt-4">
    <div class="bg-white rounded-4 px-3 py-4 mb-3 shadow-lg">
        <div class="card-title mb-3 fw-semibold"style="font-size:18px">Pilih Event & Skema</div>
        <div class="d-flex flex-row mx-2">
        <div class="card-header me-2 w-100 mx-1">
                <form action="">
                    <select class="form-select w-100 btn btn-secondary py-2 w-100 rounded-3 text-white" aria-label="Default select example">
                        <option disabled selected>Pilih Event</option>
                        <option value="1">Event 1</option>
                        <option value="2">Event 2</option>
                        <option value="3">Event 3</option>
                        <option value="4">Event 4</option>
                        <option value="5">Event 5</option>
                        <option value="6">Event 6</option>
                        <option value="7">Event 7</option>
                    </select>
                </form>
            </div>
            <div class="card-header me-2 w-100 mx-1 ">
                <form action="">
                    <select class="form-select w-100 btn btn-secondary text-white py-2 w-100 rounded-3" aria-label="Default select example">
                        <option disabled selected>Pilih Skema</option>
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
            <button class="btn btn-secondary rounded-3 w-25 mx-1">Submit</button>
        </div>
    </div>
</div>
<div class="container mt-2"> 
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                    <div class="card-title mb-4 fw-semibold" style="font-size:18px">Detail Event</div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                {{-- kanan --}}
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nama_ttd" class="form-label">Nama Event</label>
                                                <input type="text" class="form-control" name="nama_ttd" id="nama_ttd" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jabatan" class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" name="jabatan" id="jabatan" required>
                                            </div>
                                            <div class="form-check form-switch mb-3">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="instansi" class="form-label">Jenis Event</label>
                                                <input type="text" class="form-control" name="instansi" id="instansi" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nik" class="form-label">Tanggal Event</label>
                                                <input type="date" class="form-control" name="nik" id="nik" required>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <th scope="col">Nama Perserta</th>
                        <th scope="col">Nilai Peserta</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </thead>
                    <tbody class="" style="vertical-align: middle">
                        @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td>Dedi {{ $i }}</td>
                                <td>90</td>
                                <td>14-02-2024</td>
                                <td class="text-center">
                                    <a href="{{route('penilaian.create')}}" class="btn btn-sm btn-secondary rounded">+  Input Nilai</a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
            
@endsection
