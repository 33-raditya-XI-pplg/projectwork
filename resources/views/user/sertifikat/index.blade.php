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
                        <th scope="col" width="5%">No</th>
                        <th scope="col" width="30%">Event</th>
                        <th scope="col" width="30%">Skema</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </thead>

                    <tbody class="table-responsive" style="vertical-align: middle">
                        @php $num = 1 @endphp
                        @foreach ($data_sertifikat_peserta as $row)
                            <tr>
                                <td>{{ $num++ }}</td>
                                <td>{{ $row->nama_event }}</td>
                                <td>{{ $row->nama_skema }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a href="{{ route('cetak-sertifikat.cetak', $row->id_event_skema) }}" class="dropdown-item text-primary">
                                                <i class="fa fa-print"></i> Cetak</a>
                                            </li>
                                            <li><a href="{{ route('rincian-sertifikat.show', $row->id_event_skema) }}" class="dropdown-item text-secondary">
                                                <i class="fa fa-info"></i> Rincian</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
