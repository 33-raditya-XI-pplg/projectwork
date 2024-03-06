@extends('layouts.panel.index')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0" id="text-tittle-card">Tanda Tangan</h6>
                {{-- <input placeholder="Search" id="btn-search" type="search" class="form-control"/> --}}
                <a href="" class="btn btn-sm btn-warning" id="btn-sertifikat"><i class="fas fa-plus"></i> Tambah</a>
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
@endsection
