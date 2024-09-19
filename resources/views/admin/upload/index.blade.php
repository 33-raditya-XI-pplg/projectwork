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
                        <th scope="col" width="20%">Nama</th>
                        <th scope="col" width="20%">Event</th>
                        <th scope="col" width="15%">Tanggal Mulai</th>
                        <th scope="col" width="15%">Tanggal Berakhir</th>
                        <th scope="col" width="8%">Status</th>
                        <th scope="col" width="8%" class="text-center">Aksi</th>
                    </thead>
 
                    <tbody class="table-responsive" style="vertical-align: middle">
                        @php $num = 1 @endphp
                        @foreach ($upload as $row)
                            <tr>
                                <td>{{ $num++ }}</td>
                                <td>{{ $row->nama_lengkap }}</td>                          
                                <td>{{ $row->nama_event }}</td>                          
                                <td>{{ $row->tgl_mulai }}</td>
                                <td>{{ $row->tgl_berakhir }}</td>
                                <td>{{ $row->status_pembayaran ?? 'Belum Dibayar' }}</td>
                                <td class="text-center">                                                               
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $row->id_upload_pembayaran }}" data-bs-toggle="dropdown" aria-expanded="false">                                            
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_upload_pembayaran }}">
                                            <li>
                                                <a href="{{ asset('storage/' . $row->bukti_pembayaran) }}" class="dropdown-item" target="_blank">
                                                    <i class="fa fa-eye"></i> Lihat
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('upload.updateStatus', $row->id_upload_pembayaran) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item" name="status" value="Sudah Dibayar">
                                                        <i class="fa fa-check"></i> Selesaikan
                                                    </button>
                                                </form>
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
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var uploadModal = document.getElementById('uploadModal');
    uploadModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; 
        var eventId = button.getAttribute('data-id'); 
        
        var eventInput = document.getElementById('event_id');
        var uploadSection = document.getElementById('uploadSection');      
        var submitButton = document.getElementById('submitButton');
        if (eventInput) {
            eventInput.value = eventId;      
        }else {
            console.error('Hidden input with ID "event_id" not found.');
        }
    });
});
    </script>
    
@endsection

