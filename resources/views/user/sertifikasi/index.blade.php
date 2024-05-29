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
                        <th scope="col" width="20%">Event</th>
                        <th scope="col" width="8%">Status</th>
                        <th scope="col" width="15%">Tanggal Mulai</th>
                        <th scope="col" width="15%">Tanggal Berakhir</th>
                        <th scope="col" width="8%" class="text-center">Aksi</th>
                    </thead>

                    <tbody class="table-responsive" style="vertical-align: middle">
                        @php $num = 1 @endphp
                        @foreach ($data_sertifikat_peserta as $row)
                            <tr>
                                <td>{{ $num++ }}</td>
                                <td>{{ $row->nama_event }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->tgl_mulai }}</td>
                                <td>{{ $row->tgl_berakhir }}</td>
                                <td class="text-center">
                                    <a href="{{ route('sertifikat-user.show', $row->id_event) }}" class="btn btn-secondary btn-sm rounded">
                                        <i class="fa fa-info"></i> Rincian
                                    </a>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        
    </div>

@endsection
