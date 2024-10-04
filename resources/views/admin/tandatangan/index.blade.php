@extends('layouts.panel.index')
@section('title', 'Tanda Tangan')
@section('content')
<style>
    
.select2-close-mask{
    z-index: 2099 !important;
}
.select2-dropdown{
    z-index: 3051 !important;
}
.btn-kembali{
    background-color: #3498db;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}
.btn-kembali:hover{
    background-color: #2980b9;
    transform: scale(1.05); 
}
.btn-kembali:active{
    transform: scale(0.95); 
    background-color: #1f5e83;
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


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th>No</th>
                    <th>Page Id</th>
                    <th scope="col ">Nama TTD</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Instansi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($tanda_tangan as $row)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? '- '}}</td>
                            <td>{{ $row->nama_ttd }}</td>
                            <td>{{ $row->jabatan }}</td>
                            <td>{{ $row->nomor_induk }}</td>
                            <td>{{ $row->ttdInstansi->nama_instansi }}</td>
                            <td><button type="button" class="btn rounded-3 {{ $row->status == 'Aktif' ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>{{ $row->status }}</button>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $row->id_ttd }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                        <li><a href="{{ route('tandatangan.destroy', $row->id_ttd) }}" class="dropdown-item text-danger"
                                                data-confirm-delete="true"><i class="fa-regular fa-trash-can pe-none"></i>
                                                Delete</a>
                                        </li>
                                        <li><a class="dropdown-item text-warning" href="#" data-bs-toggle="modal"
                                            data-bs-target="#rincian{{ $row->id_ttd }}"><i class="fa-solid fa-code pe-none"></i>
                                            Rincian</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    <!-- insert -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tanda Tangan</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tandatangan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="mb-3">
                                <label name="page_id" for="form-label">Page Id</label>
                                <select class="form-select js-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page" required>
                                <option disabled selected></option>
                                @foreach ($page as $row)
                                <option value="{{ $row->id_page }}" >{{ $row->nama_page }}</option>
                                @endforeach
                                 </select>
                            </div>
                            <div class="col">
                                {{-- kanan --}}                          
                                    <div class="mb-3">
                                        <label for="nama_ttd" class="form-label">Nama TTD</label>
                                        <input type="text" class="form-control" name="nama_ttd" id="nama_ttd"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="number" class="form-control" name="nomor_induk" id="nomor_induk"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Instansi</label>
                                        <select class="form-select js-single" name="instansi_id" id="instansi_id" data-placeholder="Pilih Instansi"   required>                                                  
                                            <option value="" disabled selected></option> 
                                            @foreach ($institutions as $id_instansi => $name)
                                            <option value="{{ $id_instansi }}" {{old('instansi_id', (isset($pengguji) ? $pengguji->instansi_id : '') == $id_instansi) ? 'selected' : '' }}>{{ $name }}</option>                         
                                            @endforeach
                                        </select>
                                    </div>                                 
                                    <div class="form-group mb-6">
                                        <label class="control-label mb-2">Upload Tanda Tangan <span class="text-danger">*</span></label>
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone-desc">
                                                <i class="glyphicon glyphicon-download-alt"></i>
                                                <p>Pilih gambar atau seret ke sini.</p>
                                            </div>
                                            <input type="file" name="path_ttd" class="dropzone" id="path_ttd" accept="image/*" required>
                                            <div id="image_preview_" class="mt-3">
                                                <img id="preview_image_create" src="" alt="Image preview" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2MB</small>
                                        </div>
                                        @error('path_ttd')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div class="form-check form-switch mb-3">
                        <label for="status" class="me-3">Status</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Aktif">
                    </div>
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

    @foreach ($tanda_tangan as $row)
    <!-- edit -->
        <div class="modal modal-lg fade" id="edit{{ $row->id_ttd }}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                    
                        <form action="{{ route('tandatangan.update', $row->id_ttd) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                        {{-- form --}}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    {{-- kanan --}}                                                                         
                                        <div class="mb-3">
                                            <label for="page_id" class="form-label">Page Id</label>
                                            <select class="form-select js-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page id"
                                                    required>
                                                    @foreach ($page as $set)
                                                    <option value="{{ $set->id_page }}" {{ $set->id_page == $row->page_id ? 'selected' : '' }}>{{ $set->nama_page }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="mb-3">
                                        <label for="nama_ttd" class="form-label">Nama TTD</label>
                                        <input type="text" class="form-control" name="nama_ttd" id="nama_ttd"
                                            required value="{{ $row->nama_ttd }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan"
                                            required value="{{ $row->jabatan }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nomor_induk" id="nomor_induk"
                                            required value="{{ $row->nomor_induk }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Instansi</label>
                                        <select class="form-select js-example-basic-single" name="instansi_id" id="instansi_id_{{ $row->id_ttd }}" data-placeholder="Pilih Instansi" required>                             
                                            <option value="" disabled selected></option> 
                                            @foreach ($institutions as $id_instansi => $name)
                                            <option value="{{ $id_instansi }}" {{ old('instansi_id', $row->instansi_id) == $id_instansi ? 'selected' : '' }}>{{ $name }}</option>                        
                                            @endforeach
                                        </select>
                                    </div>                                
                                    <div class="form-group mb-6">
                                        <label class="control-label mb-2">Upload Foto Tandatangan  <span class="text-danger">*</span></label>
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone-desc">
                                                <i class="glyphicon glyphicon-download-alt"></i>
                                                <p>Pilih gambar atau seret ke sini .</p>
                                            </div>
                                            <input type="file" name="path_ttd" class="dropzone" id="path_ttd_{{ $row->id_ttd }}" accept="image/*">
                                            <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                                @if($row->path_ttd)
                                                    <img id="preview_image_edit_{{ $row->id_ttd }}" src="{{ asset($row->path_ttd) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                @else
                                                    <img id="preview_image_edit_{{ $row->id_ttd }}" src="" alt="No image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
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

                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch mb-3">
                            <label for="status" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                name="status" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}>
                        </div>
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

    {{-- Rincian --}}
    @foreach ($tanda_tangan as $row)    
        <div class="modal modal-lg fade" id="rincian{{ $row->id_ttd }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Rincian Penandatangan</h5>    
                        <button type="button" class="btn-kembali rounded-3" data-bs-dismiss="modal">Kembali</button>          
                    </div>
                    <div class="modal-body">                                        
                        <div class="container">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="page" class="form-label">Page Id</label>
                                    <input type="text" class="form-control" name="page" id="page" value="{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
                                </div>
                                <div class="col">
                                        <div class="mb-3">
                                        <label for="nama_ttd" class="form-label">Nama TTD</label>
                                        <input type="text" class="form-control" name="nama_ttd" id="nama_ttd" disabled readonly required value="{{ $row->nama_ttd }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nomor_induk" id="nomor_induk" disabled readonly value="{{ $row->nomor_induk }}">
                                    </div>
                                    </div>
                                    <div class="col">
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan" disabled readonly value="{{ $row->jabatan }}">
                                    </div>                                 
                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Instansi</label>                                        
                                        <input type="text" class="form-control"  name="instansi" id="instansi_{{ $row->id_user }}" value="{{ $institutions[$row->instansi_id] ?? ''}}" disabled readonly>
                                    </div>
                                </div>                            
                                <div class="form-group mb-6">
                                    <label class="control-label mb-2">Upload Foto Tandatangan  <span class="text-danger">*</span></label>
                                    <div class="dropzone-wrapper">                                            
                                        <div id="image_preview_" class="mt-3 d-flex justify-content-center" disabled readonly>                                       
                                                <img  src="{{ asset($row->path_ttd) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                       
                                        </div>                                            
                                    </div>                                   
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    @endforeach
<!-- Include CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
        $('.js-single').each(function() {
            var placeholder = $(this).data('placeholder');
            
            $(this).select2({
                placeholder: placeholder, 
                allowClear: true,
                minimumResultsForSearch: Infinity 
            });
        });    
    
    @foreach($tanda_tangan as $row)
        $('#instansi_id_{{ $row->id_ttd }}').select2({
            allowClear: true
        });
    @endforeach
});
</script>

<script>    
        document.getElementById('path_ttd').addEventListener('change', function(event) {
        const preview = document.getElementById('preview_image_create');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; 
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none'; 
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
    document.querySelectorAll('[id^="path_ttd_"]').forEach(input => {
        input.addEventListener('change', function(event) {
            const id = this.id.split('_')[2]; 
            const preview = document.getElementById(`preview_image_edit_${id}`);
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; 
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none'; 
            }
        });
    });
</script>

@endsection