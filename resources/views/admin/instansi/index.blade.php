@extends('layouts.panel.index')
@section('title', 'Instansi')
@section('content')
<style>
    .select2-close-mask{
    z-index: 2099 !important;
}
.select2-dropdown{
    z-index: 3051 !important;
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


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th>No</th>
                    <th scope="col ">Nama Instansi</th>
                    <th scope="col">Nomor Instansi</th>
                    <th scope="col">Kepala Instansi</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($instansi as $row)
                        
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $row->nama_instansi }}</td>
                            <td>{{ $row->nomor_instansi }}</td>
                            <td>{{ $row->nama_kepala_instansi }}</td>
                            <td>{{ $row->jabatan_kepala }}</td>
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
                                                data-bs-target="#edit{{ $row->id_instansi }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                        <li><a href="{{ route('instansi.destroy', $row->id_instansi) }}" class="dropdown-item text-danger"
                                                data-confirm-delete="true"><i class="fa-regular fa-trash-can pe-none"></i>
                                                Delete</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Instansi</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                {{-- kanan --}}
                                <form action="{{ route('instansi.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                    <div class="mb-3">
                                        <label for="nama_instansi" class="form-label">Nama Instansi</label>
                                        <input type="text" class="form-control" name="nama_instansi" id="nama_instansi"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_instansi" class="form-label">Nomor Instansi</label>
                                        <input type="number" class="form-control" name="nomor_instansi" id="nomor_instansi"
                                            required>
                                    </div>
                                    <div class="mb-1">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_telp" class="form-label">No. telp</label>
                                        <input type="number" class="form-control" name="no_telp" id="no_telp" required>
                                    </div>
                                    <div class="form-group mb-6">
                                        <label class="control-label mb-2">Upload Logo Instansi <span class="text-danger">*</span></label>
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone-desc">
                                                <i class="glyphicon glyphicon-download-alt"></i>
                                                <p>Pilih gambar atau seret ke sini .</p>
                                            </div>
                                            <input type="file" name="path_logo" class="dropzone" id="path_logo" accept="image/*" required>
                                            <div id="image_preview_" class="mt-3">
                                                <img id="preview_image_create" src="" alt="Image preview" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                                        </div>
                                        @error('foto')
                                        <div class="text-danger">{{ $message }}</div>
                                       @enderror
                                    </div>

                            </div>
                            <div class="col">
                                {{-- kiri --}}
                                <div class="mb-3">
                                    <label for="nama_kepala_instansi" class="form-label">Kepala Instansi</label>
                                    <input type="text" class="form-control" name="nama_kepala_instansi"
                                        id="nama_kepala_instansi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan_kepala" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan_kepala" id="jabatan_kepala"
                                        required>
                                </div>
                                <div class="mb-5">
                                    <label for="alamat_kota_{{ $row->id_instansi }}" class="form-label">Kota</label>
                                    <select class="form-select js-single" name="alamat_kota" id="alamat_kota_{{ $row->id_instansi }}" data-placeholder="Pilih Kota" required>
                                        <option value="" disabled selected></option> 
                                        @foreach ($regencies as $id => $name)
                                            <option value="{{ $name }}" {{ old('alamat_kota', $row->alamat_kota) == $name ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('alamat_kota')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 mt-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                   @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div class="form-check form-switch">
                        <label for="status" class="me-3">Status </label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Aktif" checked>
                        {{-- <input class="form-check-input"  type="checkbox" data-toggle="switchbutton" checked data-onlabel="Aktif" data-offlabel="Nonaktif" data-onstyle="primary" data-offstyle="danger" data-size="xs" data-width="75" value="Aktif"> --}}
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($instansi as $row)
        <!-- edit -->
        <div class="modal modal-lg fade" id="edit{{ $row->id_instansi }}" tabindex="-1" aria-labelledby="add"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Instansi</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    {{-- kanan --}}
                                    <form action="{{ route('instansi.update', $row->id_instansi) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                                        <div class="mb-3">
                                            <label for="nama_instansi" class="form-label">Nama Instansi</label>
                                            <input type="text" class="form-control" name="nama_instansi"
                                                id="nama_instansi" value="{{ $row->nama_instansi }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor_instansi" class="form-label">Nomor Instansi</label>
                                            <input type="number" class="form-control" name="nomor_instansi"
                                                id="nomor_instansi" value="{{ $row->nomor_instansi }}" required>
                                        </div>
                                        <div class="mb-1">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $row->alamat }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="no" class="form-label">No. telp</label>
                                            <input type="number" class="form-control" name="no_telp" id="no_telp" value="{{ $row->no_telp }}" required>
                                        </div>                            
                                        <div class="form-group mb-6">
                                            <label class="control-label mb-2">Upload Foto Pengguji <span class="text-danger">*</span></label>
                                            <div class="dropzone-wrapper">
                                                <div class="dropzone-desc">
                                                    <i class="glyphicon glyphicon-download-alt"></i>
                                                    <p>Pilih gambar atau seret ke sini .</p>
                                                </div>
                                                <input type="file" name="path_logo" class="dropzone" id="path_logo_{{ $row->id_instansi }}" accept="image/*">
                                                <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                                    @if($row->path_logo)
                                                        <img id="preview_image_edit_{{ $row->id_instansi }}" src="{{ asset($row->path_logo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                    @else
                                                        <img id="preview_image_edit_{{ $row->id_instansi }}" src="" alt="No image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
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
                                <div class="col">
                                    {{-- kiri --}}
                                    <div class="mb-3">
                                        <label for="nama_kepala_instansi" class="form-label">Kepala Instansi</label>
                                        <input type="text" class="form-control" name="nama_kepala_instansi"
                                            id="nama_kepala_instansi" value="{{ $row->nama_kepala_instansi }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan_kepala" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan_kepala"
                                            id="jabatan_kepala" value="{{ $row->jabatan_kepala }}" required>
                                    </div>
                                    <div class="mb-5">
                                        <label for="alamat_kota_{{ $row->id_instansi }}" class="form-label">Kota</label>
                                        <select class="form-select js-example-basic-single" name="alamat_kota" id="alamat_kota_{{ $row->id_instansi }}" data-placeholder="Pilih Kota" required>
                                            <option value="" disabled selected></option> 
                                            @foreach ($regencies as $id => $name)
                                                <option value="{{ $name }}" {{ old('alamat_kota', $row->alamat_kota) == $name ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('alamat_kota')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" required>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch">
                            <label for="status" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                name="status" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}>
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                        </div>
                    </div>
                    </form>
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
    $('.js-single').select2({
        
        allowClear: true
    });
    
    @foreach($instansi as $row)
        $('#instansi_id_{{ $row->id_instansi }}').select2({
            allowClear: true
        });
    @endforeach
});
</script>

<script>    
        document.getElementById('path_logo').addEventListener('change', function(event) {
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
    document.querySelectorAll('[id^="path_logo_"]').forEach(input => {
        input.addEventListener('change', function(event) {
            const id = this.id.split('_')[2]; // Extract ID from the input's ID
            const preview = document.getElementById(`preview_image_edit_${id}`);
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
    });
</script>

@endsection
