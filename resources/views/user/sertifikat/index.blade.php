@extends('layouts.panel.index')
@section('title', 'Sertifikat')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }
        </style>
    @endpush

    <div class="container mt-2">
        <div class="tab-content" id="pills-tabContent">
            <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <th scope="col" width="10%">No</th>
                        <th scope="col" width="30%">Event</th>
                        <th scope="col" width="30%">Skema</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </thead>
                    <tbody class="table-responsive" style="vertical-align: middle">
                        @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td>No {{ $i }}</td>
                                <td>Senin Aktif</td>
                                <td>Selasa Aktif</td>
                                <td class="text-center">
                                    <a href="{{route('cetak-sertifikat.cetak')}}" class="btn btn-sm btn-primary rounded"><i class="fas fa-print"></i> Cetak</a>
                                    <a href="{{route('rincian-sertifikat.index')}}" class="btn btn-sm btn-secondary rounded">Rincian</a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
