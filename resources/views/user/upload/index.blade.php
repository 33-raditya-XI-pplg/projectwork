@extends('layouts.panel.index')
@section('title', 'Sertifikat')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }       
            .dropzone-wrapper {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 200px; 
                border: 2px dashed #ddd;
                background-color: #f9f9f9;
                position: relative;
                cursor: pointer;
            }
            #image_preview {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%; 
                height: auto; 
                max-width: 180px; 
                max-height: 180px; 
                overflow: hidden;
                margin: 0 auto; 
            }
            #preview_image {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain; 
                display: block; 
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
                        <th scope="col" width="8%">Status Pembayaran </th>
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
                    
                    <div class="form-group mb-6">
                        <label class="control-label mb-2">Upload Foto Pengguna <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Pilih gambar atau seret ke sini .</p>
                            </div>
                            <input type="file" name="upload_file" class="dropzone" id="upload_file" accept="image/*"
                                {{ isset($pengguna) && $pengguna->path_foto ? '' : ' required' }}>
                            <div id="image_preview" class="mt-3">
                                <img id="preview_image" src="{{ isset($pengguna) ? asset($pengguna->path_foto) : '' }}" alt="Image preview"
                                    style="max-width: 100%; max-height: 100%; object-fit: contain; display: {{ isset($pengguna) ? 'block' : 'none' }};">
                            </div>
                        </div>
                        <div class="mt-4">
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                        </div>
                        @error('path_foto')
                        <div class="text-danger">{{ $message }}</div>
                       @enderror
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
        document.getElementById('upload_file').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview_image');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Show the image preview
        }
        reader.readAsDataURL(file);
    }
        });
    });  
});

    </script>
      {{-- upload gambar  --}}
    <script>
      Dropzone.options.path_file = {
          maxFilesize: 2,
          acceptedFiles: "image/*",
          init: function() {
              this.on("success", function(file, response) {                    
              });
              this.on("error", function(file, response) {                    
                  document.getElementById('image_error').innerHTML = response.message;
              });
          }
      };
  </script>
    
@endsection

