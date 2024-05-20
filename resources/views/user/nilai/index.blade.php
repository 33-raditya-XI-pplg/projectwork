@extends('layouts.panel.index')
@section('title', 'Nilai')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }
            .kompeten {
                color: green;
                font-weight: bold;
            }
            .tidak-kompeten {
                color: red;
                font-weight: bold;
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
                        <th scope="col" width="10%" class="text-center">Nilai <span style="color: grey; font-size: 15px;">avg</span></th>
                        <th scope="col" width="50%">Keterangan</th>
                    </thead>
                    <tbody class="" style="vertical-align: middle">
                        @php $num = 1; @endphp
                        @foreach ($data_nilai_peserta as $row)
                            <tr>
                                <td>{{ $num++ }}</td>
                                <td>{{ $row->nama_event }}</td>
                                <td>{{ $row->nama_skema }}</td>
                                <td class="text-center">{{ $row->avg_nilai }}</td>
                                <td class="
                                    @if($row->keterangan_rentang_nilai == 'Sangat Kompeten' || $row->keterangan_rentang_nilai == 'Cukup Kompeten')
                                        kompeten
                                    @else
                                        tidak-kompeten
                                    @endif
                                ">
                                    {{ $row->keterangan_rentang_nilai }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
