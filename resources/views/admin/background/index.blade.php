@extends('layouts.panel.index')
@section('content')

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @for ($i = 0; $i < 6; $i++)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('assets/img/country/AE@3x.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="text">Lanscape</h6>
                            <h5 class="card-title">Background Certif</h5>
                            <h6 class="card-text">2 minutes ago
                            <p style="float: right">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#show{{ $i }}"><i class="far fa-edit"></i></a>
                                <a href="{{ route('background.destroy', $i) }}" data-confirm-delete="true"><i class="far fa-trash-alt text-danger pe-none"></i></a>
                            </p>
                            </h6>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

    @for ($i = 0; $i < 9; $i++)
    <div class="modal modal-lg fade" id="show{{ $i }}" tabindex="-1" aria-labelledby="show" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Read Background</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <form class="row g-3">
                                <div class="col-md-6">
                                    <!-- kiri -->
                                    <div class="col-12">
                                        <img src="" alt="kosong" width="100%" height="250px" id="preview">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- kanan -->
                                    <div class="mb-1">
                                        <label for="nama_bg" class="form-label">Nama Background</label>
                                        <input class="form-control form-control-sm" id="nama_bg" type="text" readonly>
                                    </div>
                                    <div class="mb-1">
                                        <label for="lampiran" class="form-label">Lampiran</label>
                                        <input class="form-control form-control-sm" id="lampiran" type="text" readonly>
                                    </div>
                                    <div class="mb-1">
                                        <label for="rincian" class="form-label">Rincian</label>
                                        <input class="form-control form-control-sm" id="rincian" type="text" readonly>
                                    </div>
                                    <div class="mb-1">
                                        <label for="orientation" class="form-label">Orientation</label>
                                        <input class="form-control form-control-sm" id="orientation" type="text" readonly>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end form --}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary rounded-3" data-bs-dismiss="modal">Selesai</button>
                <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $i }}" class="btn btn-info rounded-3 text-white">Edit</a>
            </div>
            </form>
        </div>
    </div>
    </div>
    @endfor

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
                            <form class="row g-3">
                                <div class="col-md-6">
                                    <!-- kiri -->
                                    <div class="col-12">
                                        <img src="" alt="kosong" width="100%" height="250px" id="preview">
                                    </div>
                                    <div class="mb-1">
                                        <label for="formFileSm" class="form-label">Upload File</label>
                                        <input class="form-control form-control-sm" id="formFileSm" type="file"
                                            onchange="previewFile()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- kanan -->
                                    <div class="mb-1">
                                        <label for="nama_bg" class="form-label">Nama Background</label>
                                        <input class="form-control form-control-sm" id="nama_bg" type="text">
                                    </div>
                                    <div class="mb-1">
                                        <label for="lampiran" class="form-label">Lampiran</label>
                                        <input class="form-control form-control-sm" id="lampiran" type="text">
                                    </div>
                                    <div class="mb-1">
                                        <label for="rincian" class="form-label">Rincian</label>
                                        <input class="form-control form-control-sm" id="rincian" type="text">
                                    </div>
                                    <div class="mb-1">
                                        <label for="orientation" class="form-label">Orientation</label>
                                        <input class="form-control form-control-sm" id="orientation" type="text">
                                    </div>
                            </form>
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

    <!-- edit -->
    @for ($i = 0; $i < 9; $i++)
        <div class="modal modal-lg fade" id="edit{{ $i }}" tabindex="-1" aria-labelledby="edit"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Background</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <form class="row g-3">
                                        <div class="col-md-6">
                                            <!-- kiri -->
                                            <div class="col-12">
                                                <img src="" alt="kosong" width="100%" height="250px"
                                                    id="preview">
                                            </div>
                                            <div class="mb-1">
                                                <label for="formFileSm" class="form-label">Upload File</label>
                                                <input class="form-control form-control-sm" id="formFileSm"
                                                    type="file" onchange="previewFile()">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- kanan -->
                                            <div class="mb-1">
                                                <label for="nama_bg" class="form-label">Nama Background</label>
                                                <input class="form-control form-control-sm" id="nama_bg"
                                                    type="text">
                                            </div>
                                            <div class="mb-1">
                                                <label for="lampiran" class="form-label">Lampiran</label>
                                                <input class="form-control form-control-sm" id="lampiran"
                                                    type="text">
                                            </div>
                                            <div class="mb-1">
                                                <label for="rincian" class="form-label">Rincian</label>
                                                <input class="form-control form-control-sm" id="rincian"
                                                    type="text">
                                            </div>
                                            <div class="mb-1">
                                                <label for="orientation" class="form-label">Orientation</label>
                                                <input class="form-control form-control-sm" id="orientation"
                                                    type="text">
                                            </div>
                                    </form>

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
@endsection('content')
