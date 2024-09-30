@extends('layouts.panel.index')
@section('content')
<style>
     .dropzone-wrapperr {
    width: 300px;
    height: 170px;
    border: 2px dashed #ddd;
    background-color: #f9f9f9;
    position: relative;
    cursor: pointer; 
}
     .dropzone-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 240px;
    border: 2px dashed #ddd;
    background-color: #f9f9f9;
    position: relative;
    cursor: pointer; 
}
   #image_preview_ {
       display: flex;
       align-items: center;
       justify-content: center;
       width: 100%; 
       height: auto; 
       max-width: 200px; 
       max-height: 200px; 
       overflow: hidden;
       margin: 0 auto; 
   }
   #preview_image_create, #preview_image_edit_ {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; 
    display: block; 
}

</style>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        @foreach ($bg as $row)
        <div class="col">
            <div class=" border-light shadow">
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#rincian{{ $row->id_background }}">
                        <img src="{{ asset($row->path_bg) }}" height="450" class="card-img-top" alt="..."
                            style="object-fit: scale-down">                    
                    <div class="card-body">
                        {{-- <h6 class="text text-warning text-capitalize">{{ $row->orientasi_bg }}</h6> --}}
                        <div class="d-flex justify-content-between">
                            <div class="fw-bold h5">Background {{ $row->nama_bg }}</div>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-primary rounded text-end mt-2" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_background }}">
                                    <i class="fa-regular fa-pen-to-square  text-white pe-none" style="font-size: 0.7rem;"></i>
                                </a>

                                <a class="btn btn-danger rounded text-end mt-2" href="{{ route('background.destroy', $row) }}"
                                    data-confirm-delete="true" >
                                    <i class="fa-solid fa-trash-can text-white pe-none" style="font-size: 0.7rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </button>
                </div>
            </div>
        @endforeach
    </div>

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
                            <div class="col-md-6">
                                <!-- kiri -->
                                <form action="{{ route('background.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-1">
                                        <label for="formFileSm" class="form-label d-block">Upload Background</label>
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone-desc">
                                                <i class="glyphicon glyphicon-download-alt"></i>
                                                <p>Pilih gambar atau seret ke sini .</p>
                                            </div>
                                            <input type="file" name="path_bg" class="dropzone" id="path_bg" accept="image/*" required>
                                            <div id="image_preview_" class="mt-3">
                                                <img id="preview_image_create" src="" alt="Image preview" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <input class="form-control form-control-sm" id="formFileSm" type="file"
                                        onchange="previewFile()" name="bg" accept=".jpg, .jpeg, .png">
                                    <img src="" class="img-thumbnail mt-3" alt="kosong" id="preview" hidden> --}}
                            </div>
                            <div class="col-md-6">
                                <!-- kanan -->
                                <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                <div class="mb-1">
                                    <label for="nama_bg" class="form-label">Nama Background</label>
                                    <input class="form-control form-control-sm" id="nama_bg" name="nama_bg" type="text"
                                        required>
                                </div>
                                <div class="mb-1">
                                    <label for="rincian_bg" class="form-label">Rincian</label>
                                    <textarea class="form-control" id="rincian_bg" name="rincian_bg" rows="2" required></textarea>
                                    {{-- <input class="form-control form-control-sm" id="rincian_bg" name="rincian_bg"
                                        type="text" required> --}}
                                </div>
                                <div class="mb-1">
                                    <label for="orientasi_bg" class="form-label">Orientation</label>
                                    <select class="form-select" name="orientasi_bg" required>
                                        <option selected>Landscape</option>
                                        <option>Potrait</option>
                                    </select>
                                </div>
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

    @foreach ($bg as $row)
        <div class="modal modal-lg fade" id="edit{{ $row->id_background }}" tabindex="-1" aria-labelledby="edit"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        <div class="container">
                            <form action="{{ route('background.update',  $row->id_background) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="row">
                                
                                <div class="col-md-6">

                                    <div class="form-group mb-2">
                                        <label class="control-label mb-2">Upload Background <span class="text-danger">*</span></label>
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone-desc">
                                                <i class="glyphicon glyphicon-download-alt"></i>
                                                <p>Pilih gambar atau seret ke sini .</p>
                                            </div>
                                            <input type="file" name="path_bg" class="dropzone" id="path_bg_{{ $row->id_background }}" accept="image/*">
                                            <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                                @if($row->path_bg)
                                                    <img id="preview_image_edit_{{ $row->id_background }}" src="{{ asset($row->path_bg) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                @else
                                                    <img id="preview_image_edit_{{ $row->id_background }}" src="" alt="No image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                                        </div>
                                        @error('path_foto')
                                        <div class="text-danger">{{ $message }}</div>
                                       @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- kanan -->
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                    <div class="mb-1">
                                        <label for="nama_bg" class="form-label">Nama Background</label>
                                        <input class="form-control form-control-sm" id="nama_bg" name="nama_bg"
                                            type="text" value="{{ $row->nama_bg }}">
                                    </div>
                                    <div class="mb-1">
                                        <label for="rincian_bg" class="form-label">Rincian</label>
                                        <textarea class="form-control form-control-sm" id="rincian_bg" name="rincian_bg" rows="2" required >{{ $row->rincian_bg }}</textarea>
                                    </div>
                                    <div class="mb-1">
                                        <label for="orientasi_bg" class="form-label">Orientation</label>
                                        <select class="form-select" name="orientasi_bg" required>
                                            <option {{ $row->orientasi_bg == 'landscape' ? 'selected' : '' }}>Landscape
                                            </option>
                                            <option {{ $row->orientasi_bg == 'potrait' ? 'selected' : '' }}>Potrait
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer">
                        <div>
                            <button type="button" class="btn btn-danger rounded-3"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

{{-- Rincian  --}}

    @foreach ($bg as $row)
        <div class="modal modal-lg fade" id="rincian{{ $row->id_background }}" tabindex="-1" aria-labelledby="rincian"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Preview Background</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                        
                        <div class="container">                          
                            <div class="row">                                
                                    <div class="col-md-12 mb-2">                                    
                                        <label class="control-label mb-2"> Background <span class="text-danger">*</span></label>                                   
                                        <div class="dropzone-wrapperr mx-auto">                                      
                                                <div id="image_preview_" class="mt-3 d-flex justify-content-center">                                                
                                                    <img  src="{{ asset($row->path_bg) }}" alt="Image preview" class="img-fluid" style="max-width: auto; max-height: auto; object-fit: contain;">                                         
                                                </div>                                                                      
                                             </div>                                                                                                                                                                             
                                    </div>
                                <div class="col-md-10 mx-auto">
                                    <!-- kanan -->
                                    <div class="mb-1">
                                        <label for="nama_bg" class="form-label ">Nama Background</label>
                                        <input class="form-control form-control-sm " id="nama_bg" name="nama_bg"
                                            type="text" value="{{ $row->nama_bg }}" readonly disabled>
                                    </div>
                                    <div class="mb-2">
                                        <label for="rincian_bg" class="form-label">Rincian</label>
                                        <textarea class="form-control form-control-sm" id="rincian_bg" name="rincian_bg" rows="2" required >{{ $row->rincian_bg }}</textarea>
                                        {{-- <input class="form-control form-control-sm" id="rincian_bg" name="rincian_bg"
                                            type="text" value="{{ $row->rincian_bg }}" readonly disabled> --}}
                                    </div>
                                    <div class="mb-2">
                                        <label for="orientasi_bg" class="form-label">Orientation</label>
                                        <select class="form-select" name="orientasi_bg" required disabled readonly >
                                            <option {{ $row->orientasi_bg == 'landscape' ? 'selected' : '' }}>Landscape
                                            </option>
                                            <option {{ $row->orientasi_bg == 'potrait' ? 'selected' : '' }}>Potrait
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>                          
                </div>
            </div>
        </div>
    @endforeach
    
    <script>    
        document.getElementById('path_bg').addEventListener('change', function(event) {
        const preview = document.getElementById('preview_image_create');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Show the image preview
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none'; // Hide the image if no file selected
        }
    });

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
<script>
  document.querySelectorAll('[id^="path_bg"]').forEach(input => {
    input.addEventListener('change', function(event) {
        const id = this.id.split('_')[2]; // Mengambil ID dari input
        const preview = document.getElementById(`preview_image_edit_${id}`); // Mengambil elemen preview yang sesuai
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Tampilkan preview gambar
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none'; // Sembunyikan gambar jika tidak ada file
        }
    });
  });
  </script>
@endsection('content')
