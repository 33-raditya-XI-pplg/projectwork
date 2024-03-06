@extends('layouts.panel.index')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0" id="text-tittle-card">Tanda Tangan</h6>
                {{-- <input placeholder="Search" id="btn-search" type="search" class="form-control"/> --}}
                <button type="button" class="btn btn-sm btn-primary rounded" id="btn-sertifikat" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus"></i> Tambah</button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="text-dark">
                            <th id="colom-1" scope="col">Nama TTD</th>
                            <th id="colom-2" scope="col">Jabatan</th>
                            <th id="colom-3" scope="col">NIK</th>
                            <th id="colom-4" scope="col">Instansi</th>
                            <th id="colom-5" scope="col">Status</th>
                        </tr>
                    </thead>
                </table>
                <table class="table mt-3">
                    <tbody>
                        <tr id="line-bottom">
                            <td id="colom-1">Mas Dedi</td>
                            <td id="colom-2">Kepsek</td>
                            <td id="colom-3">9849643784910</td>
                            <td id="colom-4">SMA 6</td>
                            <td id="colom-5">
                                <i class="fas fa-edit" id="icon-status"></i>
                                <i class="fas fa-trash-alt" id="icon-status-trash"></i>
                            </td>
                        </tr>
                        <tr id="line-bottom">
                            <td id="colom-1">Mas Dedi</td>
                            <td id="colom-2">Kepsek</td>
                            <td id="colom-3">9849643784910</td>
                            <td id="colom-4">SMA 6</td>
                            <td id="colom-5">
                                <i class="fas fa-edit" id="icon-status"></i>
                                <i class="fas fa-trash-alt" id="icon-status-trash"></i>
                            </td>
                        </tr>
                        <tr>
                            <td id="colom-1">Mas Dedi</td>
                            <td id="colom-2">Kepsek</td>
                            <td id="colom-3">9849643784910</td>
                            <td id="colom-4">SMA 6</td>
                            <td id="colom-5">
                                <i class="fas fa-edit" id="icon-status"></i>
                                <i class="fas fa-trash-alt" id="icon-status-trash"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tanda Tangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-2">
                            <label for="recipient-name" class="col-form-label">Nama TTD</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-2">
                            <label for="recipient-name" class="col-form-label">Jabatan</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-2">
                            <label for="recipient-name" class="col-form-label">NIK</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-2">
                            <label for="recipient-name" class="col-form-label">Instansi</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger rounded" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success rounded">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
