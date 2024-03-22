@extends('layouts.panel.index')
@section('content')
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        @foreach ($bg as $row)
            <div class="col">
                <div class="card border-light shadow">
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_background }}">
                        <img src="{{ asset($row->path_bg) }}" height="250" class="card-img-top" alt="..."
                            style="object-fit: scale-down">
                    </button>
                    <div class="card-body">
                        <h6 class="text text-warning text-capitalize">{{ $row->orientasi_bg }}</h6>
                        <div class="d-flex justify-content-between">
                            <div class="fw-bold h5">Background {{ $row->nama_bg }}</div>
                            <div class="">
                                <a class="btn btn-danger rounded text-end" href="{{ route('background.destroy', $row) }}"
                                    data-confirm-delete="true"><i class="far fa-trash-alt text-white pe-none"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- insert -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Background</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- kiri -->
                                <form action="{{ route('background.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-1">
                                        <label for="formFileSm" class="form-label d-block">Upload File</label>
                                        <input class="form-control form-control-sm" id="formFileSm" type="file"
                                            onchange="previewFile()" name="bg" accept=".jpg, .jpeg, .png">
                                        <img src="" class="img-thumbnail mt-3" alt="kosong" id="preview" hidden>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <!-- kanan -->
                                <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                <div class="mb-1">
                                    <label for="nama_bg" class="form-label">Nama Background</label>
                                    <input class="form-control form-control-sm" id="nama_bg" name="nama_bg" type="text"
                                        required>
                                </div>
                                <div class="mb-1">
                                    <label for="rincian_bg" class="form-label">Rincian</label>
                                    <input class="form-control form-control-sm" id="rincian_bg" name="rincian_bg"
                                        type="text" required>
                                </div>
                                <div class="mb-1">
                                    <label for="orientasi_bg" class="form-label">Orientation</label>
                                    <select class="form-select" name="orientasi_bg" required>
                                        <option selected>Landscape</option>
                                        <option>Potrait</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- js --}}
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($bg as $row)
        <div class="modal modal-lg fade" id="edit{{ $row->id_background }}" tabindex="-1" aria-labelledby="edit"
            aria-hidden="true">
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
                            <form action="{{ route('background.update',  $row->id_background) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="row">
                                
                                <div class="col-md-6">

                                    <div class="mb-1">
                                        <label for="formFileSm" class="form-label d-block">Upload File</label>
                                        <input class="form-control form-control-sm" id="formFileSm" type="file"
                                            onchange="previewFile()" name="bg" accept=".jpg, .jpeg, .png">
                                        <img src="" class="img-thumbnail mt-3" alt="kosong" id="preview"
                                            hidden>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- kanan -->
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                    <div class="mb-1">
                                        <label for="nama_bg" class="form-label">Nama Background</label>
                                        <input class="form-control form-control-sm" id="nama_bg" name="nama_bg"
                                            type="text" value="{{ $row->nama_bg }}">
                                    </div>
                                    <div class="mb-1">
                                        <label for="rincian_bg" class="form-label">Rincian</label>
                                        <input class="form-control form-control-sm" id="rincian_bg" name="rincian_bg"
                                            type="text" value="{{ $row->rincian_bg }}">
                                    </div>
                                    <div class="mb-1">
                                        <label for="orientasi_bg" class="form-label">Orientation</label>
                                        <select class="form-select" name="orientasi_bg" required>
                                            <option {{ $row->orientasi_bg == 'landscape' ? 'selected' : '' }}>Landscape
                                            </option>
                                            <option {{ $row->orientasi_bg == 'potrait' ? 'selected' : '' }}>Potrait
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer">
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
@endsection('content')
