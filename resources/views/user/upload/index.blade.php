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
                                <td>{{ $row->nama_event }}</td>
                                <td>{{ $row->tgl_mulai }}</td>
                                <td>{{ $row->tgl_berakhir }}</td>
                                <td>{{ $row->status_pembayaran ?? 'Belum Dibayar' }}</td>
                                <td class="text-center">
                                    @if (($row->status_pembayaran === 'Menunggu' || $row->status_pembayaran === 'Sudah Dibayar') && $row->bukti_pembayaran )
                                    <a href="{{ asset('storage/' . $row->bukti_pembayaran) }}" class="btn btn-secondary btn-sm rounded" target="_blank">
                                        <i class="fa fa-eye"></i> Lihat
                                    </a>
                                    @else
                                    <a href="#" class="btn btn-secondary btn-sm rounded" data-bs-toggle="modal" data-bs-target="#uploadModal" data-id="{{ $row->id_event }}">
                                        <i class="fa fa-money-bill-1-wave"></i> Bayar
                                    </a>                                        
                                    @endif
                                </td>                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>        
    </div>
    {{-- Modal untuk membuka modal --}}
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Pembayaran </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" action="{{ route('uploadPembayaran-user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="event_id" id="event_id" value="">
                    
                    <div class="mb-3">
                        <label for="upload_file" class="form-label">Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control" id="upload_file" name="upload_file" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var uploadModal = document.getElementById('uploadModal');
    uploadModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; 
        var eventId = button.getAttribute('data-id'); 
        // var status = button.getAttribute('data-status');
        // var file = button.getAttribute('data-file');
        
        var eventInput = document.getElementById('event_id');
        var uploadSection = document.getElementById('uploadSection');
        // var viewSection = document.getElementById('viewSection');
        // var buktiPembayaranLink = document.getElementById('bukti_pembayaran')
        var submitButton = document.getElementById('submitButton');
        if (eventInput) {
            eventInput.value = eventId; 
        // } 

        // if(status === 'Menunggu'){
        //     uploadSection.style.display='none';
        //     viewSection.style.display='block';
        //     buktiPembayaranLink.href=file;
        //     buktiPembayaranLink.innerText='Lihat Bukti Pembayaran';
        }else {
            console.error('Hidden input with ID "event_id" not found.');
            // uploadSection.style.display = 'block';
            // viewSection.style.display = 'none';
        }
    });
});
    </script>
    
@endsection

