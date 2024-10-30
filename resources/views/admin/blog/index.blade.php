@extends('layouts.panel.index')
@section('title', 'Blog')
@section('content')
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    
    .select2-close-mask{
        z-index: 2099 !important;
    }
    .select2-dropdown{
        z-index: 3051 !important;
    }
    .blog-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

    .blog-card img {
        width: 100%;
        height: auto;
        border-radius: 0;
        /* Remove border-radius from the image */
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }
</style>

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="mt-4">
                <div class="table-responsive">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <tr>
                                <th>No</th>
                                <th scope="col">Page Name</th>
                                <th scope="col">Judul</th>
                                {{-- <th scope="col">Slug</th> --}}
                                <!-- <th scope="col">Body</th> -->
                                {{-- <th scope="col">Photo</th> --}}
                                <th scope="col">Kategori</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle">
                            @foreach ($blog as $row)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $row->page->nama_page ?? 'N/A' }}</td> <!-- Use eager loaded page relationship -->
                                <td>{{ $row->judul }}</td>
                                {{-- <td>{{ $row->slug }}</td> --}}
                                <!-- <td>{{ Str::limit(strip_tags($row->body), 100) }}</td> -->
                                {{-- <td>
                                    <!-- Display the photo or a default image if not set -->
                                    <img src="{{ $row->photo ? asset('storage/photos/' . $row->photo) : asset('images/default.jpg') }}" alt="{{ $row->judul }}" style="width: 100px; height: auto;">
                                </td> --}}
                                <td>
                                    {{ $row->kategori->nama_kategori ?? 'N/A' }}
                                </td>
                                <td>
                                    <button type="button" class="badge rounded-3
                                        {{ $row->status ? 'bg-success' : 'bg-danger' }}"
                                        disabled>
                                        {{ $row->status ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3" id="dropdownMenuButton{{ $row->id_blog }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_blog }}">
                                            <li>
                                                <a class="dropdown-item text-black" href="{{ route('blog.show', $row->id_blog) }}">
                                                    <i class="fa-solid fa-code pe-none"></i> Rincian
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_blog }}">
                                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                                </a>
                                            </li>                                      
                                            <li>
                                                <form id="deleteForm{{ $row->id_blog }}" action="{{ route('blog.destroy', $row->id_blog) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('{{ $row->id_blog }}')">
                                                        <i class="fa-regular fa-trash-can pe-none"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                    <script>
                                        function confirmDelete(blogId) {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You won't be able to revert this!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, delete it!',
                                                cancelButtonText: 'Cancel'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('deleteForm' + blogId).submit();
                                                }
                                            });
                                        }
                                    </script>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Blog Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Tambah Blog</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_blog }}">

                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                        <select class="form-select js-example-basic-single" name="page_id" id="page_id" aria-label="Default select example" data-placeholder="Pilih Page" required>
                            <option value="" disabled selected>Pilih ...</option>
                            @foreach ($page as $row)
                            <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                        @error('page_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select js-example-basic-single" name="kategori_id" id="Addkategori_id" aria-label="Default select example"  data-placeholder="Pilih Kategori" required>
                            <option value="" disabled selected>Pilih ...</option>
                            @foreach ($kategori as $row)
                            <option value="{{ $row->id_kategori }}">{{ $row->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" id="judul" required>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="photo" class="form-label">Upload Photo <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Drag and drop an image file here or click to choose one.</p>
                            </div>
                            <input type="file" name="photo" class="dropzone" id="photo" accept=".png, .jpg, .jpeg, .bmp" onchange="previewImage(event)" style="display: none;height: 300px;">

                            <!-- Image preview area -->
                            <div id="image_preview" class="image_preview" style="display: none;">
                                <img id="preview_image" class="preview_image" src="" alt="Image preview">
                            </div>
                        </div>
                        <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                    </div> --}}

                    <div class="form-group mb-2">
                        <label class="control-label mb-2">Upload Foto <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Pilih gambar atau seret ke sini.</p>
                            </div>
                            <input type="file" name="photo" class="dropzone"  accept="image/*" required>
                            <div id="image_preview_" class="mt-3">
                                <img id="preview_image_create" src="" alt="Image preview" style="display: none;">
                            </div>
                        </div>
                        <div class="mt-2">
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2MB</small>
                        </div>
                        @error('path_ttd')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="body" class="form-label">Body <span class="text-danger">*</span></label>
                        <textarea class="form-control ck-editor" id="body" name="body" rows="4"></textarea>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1">
                        <label class="form-check-label" for="status">Status Aktif</label>
                    </div>

                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-danger rounded-3 me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Blog Modal -->
@foreach ($blog as $row)
<div class="modal modal-lg fade" id="edit{{ $row->id_blog }}" tabindex="-1" aria-labelledby="edit{{ $row->id_blog }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="edit{{ $row->id_blog }}Label">Edit Blog</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('blog.update', ['id' => $row->id_blog]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id_blog }}">

                    <!-- Page ID -->
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID</label>
                        <select class="form-select js-example-basic-single" name="page_id" aria-label="Default select example"  data-placeholder="Pilih Page" required>
                            @foreach ($page as $element)
                            <option value="{{ $element->id_page }}" {{ $element->id_page == $row->page_id ? 'selected' : '' }}>
                                {{ $element->nama_page }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select class="form-select  js-example-basic-single" name="kategori_id" id="kategori_id" aria-label="Default select example"  data-placeholder="Pilih Kategori" required>
                            @foreach ($kategori as $element)
                            <option value="{{ $element->id_kategori }}" {{ $element->id_kategori == $row->kategori_id ? 'selected' : '' }}>
                                {{ $element->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul" value="{{ $row->judul }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-label mb-2">Upload Foto Mentor <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Pilih gambar atau seret ke sini .</p>
                            </div>
                            <input type="file" name="photo" class="dropzone" id="photo_{{ $row->id_blog }}" accept="image/*">
                            <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                @if($row->photo)
                                    <img id="preview_image_edit_{{ $row->id_blog }}" src="{{ asset($row->photo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                @else
                                    <img id="preview_image_edit_{{ $row->id_blog }}" src="" alt="No image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                @endif
                            </div>
                        </div>
                        <div class="mt-2">
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                        </div>
                        @error('path_foto')
                        <div class="text-danger">{{ $message }}</div>
                       @enderror
                    </div>


                    <!-- Body -->
                    <div class="mb-3">
                        <label for="body" class="form-label">Body</label>
                        <textarea class="form-control ck-editor" id="body" name="body" rows="4">{{ $row->body }}</textarea>
                    </div>

                    <!-- Status & Buttons -->
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" {{ $row->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Aktif</label>
                        </div>

                        <div>
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- Include CSS Select2 -->
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
    <script>
  $(document).ready(function() {
        $('.js-example-basic-single').each(function() {
            var placeholder = $(this).data('placeholder'); 
            
            $(this).select2({
                placeholder: placeholder, 
                allowClear: true,
                minimumResultsForSearch: Infinity 
            });
        });
    });
    </script>
    
    <script>
                        document.getElementById('edit_photo_{{ $row->id_blog }}').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file && file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const previewImage = document.getElementById('edit_photo_image_preview_{{ $row->id_blog }}');
                                    previewImage.src = e.target.result;
                                    previewImage.style.display = 'block';
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>
<script>    
    document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi preview image
    const inputFile = document.querySelector('input[name="photo"]');
    const preview = document.getElementById('preview_image_create');


    if (preview) {
    preview.style.display = 'none';

    inputFile.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            if (preview) { // Cek apakah preview tidak null
                preview.src = e.target.result;
                preview.style.display = 'block';
            } else {
                console.error('Preview element not found');
            }
        }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                if (preview) {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            }
        });
    } else {
        console.error('Preview image element not found');
    }


    // Inisialisasi Dropzone
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone-wrapper", {
        url: "/blog", // URL server untuk unggahan
        maxFilesize: 2, 
        acceptedFiles: "image/*",
        init: function() {
            this.on("success", function(file, response) {                    
                // Tangani response sukses
                console.log("Upload successful");
            });
            this.on("error", function(file, response) {
                const errorElement = document.getElementById('image_error');
                if (errorElement) {
                    errorElement.innerHTML = response.message || 'Upload failed';
                }
            });
        }
    });   
});   
</script> 
<script>
    document.querySelectorAll('[id^="photo"]').forEach(input => {
      input.addEventListener('change', function(event) {
          const id = this.id.split('_')[1]; // Mengambil ID dari input
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

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Menghapus',
        text: "{{ session('error') }}",
        showConfirmButton: true
    });
</script>
@endif

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        showConfirmButton: true
    });
</script>
@endif

@endsection