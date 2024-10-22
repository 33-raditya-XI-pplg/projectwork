@extends('layouts.panel.index')

@section('title', 'Dashboard')

@section('content')
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <h1>Galeri</h1> --}}
@push('style')

<!-- Include CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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

.image_preview {
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

.preview_image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: block;
}

.dropzone-desc {
    text-align: center;
    padding: 20px;
    color: #888;
}

    .gallery-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 10px;
    }


    .gallery {
        position: relative;
        width: 220px;
        border: 2px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
    }


    .gallery:hover {
        border-color: #777;
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }


    .gallery img {
        width: 100%;
        height: auto;
        display: block;
    }


    .desc {
        padding: 10px;
        text-align: center;
        background: rgba(255, 255, 255, 0.9);
        border-top: 1px solid #ddd;
        margin-bottom: 50px;
    }


    .button-container {
        display: flex;
        gap: 5px;
        justify-content: center;
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
    }

    .button-container button,
    .button-container form {
        margin: 0;
    }

    .btn-group button {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-group button:hover {
        background-color: #0056b3;
    }

    /* Modal styling */
    .modal-content {
        border-radius: 8px;
        overflow: hidden;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-body {
        padding: 20px;
    }
</style>

@endpush



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
            </div>

            <!-- Button to trigger the modal -->
            {{-- <a href="#addImageModal" data-bs-toggle="modal" class="btn btn-primary btn-block mt-3">Upload Gambar</a> --}}

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3 position-relative" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: absolute; top: -15px; right: 10px;"></button>
</div>


            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger mt-3">
                        {{ $error }}
                        <strong>Failed</strong>
                    </div>
                @endforeach
            @endif

            <!-- Gallery Section -->
            <div class="card-body mt-4">
                <div class="gallery-container">
                    @forelse($galeri as $item)
                        @if (!strpos($item->path_file, 'youtube.com') && !strpos($item->path_file, 'youtu.be'))
                            <div class="gallery">
                                <!-- Change anchor tag to open modal instead of new tab -->
                                <a href="#" class="gallery-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset($item->path_file) }}" data-description="{{ $item->deskripsi }}">
                                    <img src="{{ asset($item->path_file) }}" alt="{{ $item->deskripsi }}">
                                </a>
                                <div class="desc">{{ $item->deskripsi }}</div>
                                <div class="button-container">
                                    <a href="#editGaleriModal{{ $item->id_galeri }}" data-bs-toggle="modal" class="btn btn-primary btn-sm">Edit</a>
                                    <form id="deleteForm{{ $item->id_galeri }}" action="{{ route('galeri.destroy', $item->id_galeri) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-primary btn-sm" onclick="confirmDelete('{{ $item->id_galeri }}')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                <script>
                                    function confirmDelete(galeriId) {
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
                                                document.getElementById('deleteForm' + galeriId).submit();
                                            }
                                        });
                                    }
                                </script>
                            </div>

                            <!-- Edit Image Modal -->
                            <div class="modal fade" id="editGaleriModal{{ $item->id_galeri }}" tabindex="-1" aria-labelledby="editGaleriModalLabel{{ $item->id_galeri }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="editGaleriModalLabel{{ $item->id_galeri }}">Edit Galeri</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('galeri.update', $item->id_galeri) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                    
                                                <div class="mb-3">
    <label for="edit_photo_{{ $item->id_galeri }}" class="form-label">Upload Photo</label>
    <div class="dropzone-wrapper">
        <div class="dropzone-desc">
            <i class="glyphicon glyphicon-download-alt"></i>
            <p>Choose a photo file or drag it here.</p>
        </div>
        <input type="file" name="path_file" class="dropzone" id="edit_photo_{{ $item->id_galeri }}" accept=".png, .jpg, .jpeg" style="opacity: 0; position: absolute; width: 100%; height: 100%;">
        
        <!-- Image preview area -->
        <div id="edit_photo_preview_{{ $item->id_galeri }}" class="image_preview mt-3">
            @if($item->path_file)
                <img src="{{ asset($item->path_file) }}" id="edit_photo_image_preview_{{ $item->id_galeri }}" alt="Photo Preview" class="preview_image">
            @else
                <img src="" id="edit_photo_image_preview_{{ $item->id_galeri }}" alt="Photo Preview" class="preview_image" style="display: none;">
            @endif
        </div>
    </div>
</div>

                    <script>
    document.getElementById('edit_photo_{{ $item->id_galeri }}').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('edit_photo_image_preview_{{ $item->id_galeri }}');
                previewImage.src = e.target.result;
                previewImage.style.display = 'block'; // Show the new image
            };
            reader.readAsDataURL(file);
        } else {
            // Reset the preview if no file is selected
            const previewImage = document.getElementById('edit_photo_image_preview_{{ $item->id_galeri }}');
            previewImage.src = '';
            previewImage.style.display = 'none'; // Hide the preview if no valid image
        }
    });
</script>


                                                <div class="form-group mb-4">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" class="form-control  mt-2" id="name" value="{{ $item->nama }}" required>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" class="form-control  mt-2" id="description" required>{{ $item->deskripsi }}</textarea>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="kategori">Pilih Kategori:</label>
                                                    <select class="form-control  js-example-basic-single  mt-2" id="edit_kategori" name="kategori"  data-placeholder="Pilih kategori" required>
                                                        <option value=""></option>
                                                        <option value="partner" {{ $item->kategori == 'partner' ? 'selected' : '' }}>Partner</option>
                                                        <option value="klien" {{ $item->kategori == 'klien' ? 'selected' : '' }}>Klien</option>
                                                        <option value="gambar" {{ $item->kategori == 'gambar' ? 'selected' : '' }}>Gambar</option>
                                                        <option value="video" {{ $item->kategori == 'video' ? 'selected' : '' }}>Video</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex justify-content-end w-100 mt-3">
                                                    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>


                                            </form>
                                        </div>
                                        <!-- Modal Footer -->
                                        <div class="modal-footer bg-light">

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Edit Image Modal -->
                        @endif
                    @empty
                        <p class="text-center">Tidak ada gambar ditemukan</p>
                    @endforelse
                </div>
            </div>

            <!-- Image Preview Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id="modalImage" src="" alt="" class="img-fluid">
                            <p id="modalDescription" class="mt-3"></p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>





    <!-- Add Image Modal -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="addImageModalLabel">Tambah Gambar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Begin Single Form -->
                    <form action="{{ route('galeri.store') }}" method="post" id="image_upload_form"
                        enctype="multipart/form-data">
                        @csrf

        <div class="form-group mb-3">
        <label for="page_id">Page ID <span class="text-danger">*</span></label>
        <select name="page_id" class="form-control js-example-basic-single" id="page_id" data-placeholder="Select Page ID" required>
        <option value="">Select Page ID</option>
        @foreach ($pages as $page)
            <option value="{{ $page->id_page }}">{{ $page->id_page }} - {{ $page->nama_page }}</option>
        @endforeach
    </select>
</div>




                        <!-- Title input -->
                        <div class="form-group mb-3">
                            <label for="nama">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan judul"
                                id="nama" required>
                        </div>

                       
<!-- Category Selection with Select2 -->
<div class="form-group mb-3">
    <label for="kategori">Pilih Kategori <span class="text-danger">*</span></label>
    <select class="form-control js-example-basic-single" id="create_kategori" name="kategori" data-placeholder="Select Category" required>
        <option value="">Select category</option>
        <option value="partner">Partner</option>
        <option value="klien">Klien</option>
        <option value="gambar">Gambar</option>
        <option value="video">Video</option>
    </select>
</div>

                        <div class="form-group mb-6">
    <label class="control-label">Upload Image <span class="text-danger">*</span></label>
    <div class="dropzone-wrapper">
        <div class="dropzone-desc">
            <i class="glyphicon glyphicon-download-alt"></i>
            <p>Choose an image file or drag it here.</p>
        </div>
        <input type="file" name="path_file" class="dropzone" id="path_file" accept="image/*,video/*" required>
        
        <div id="image_preview" class="image_preview mt-3">
            <img id="preview_image" src="" alt="Image preview" class="preview_image" style="display: none;">
        </div>
    </div>
    <div class="mt-2">
        <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
    </div>
    <div id="image_error"></div>
</div>



                        <!-- Description (optional) -->
                        <div class="form-group mb-4">
                            <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" placeholder="Tambahkan deskripsi (opsional)" id="deskripsi"></textarea>
                        </div>

                        <!-- Submit button -->
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-danger me-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>


                    </form>
                    <!-- End Single Form -->
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
@push('script')

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
        
        $(document).ready(function() {
            // Handle file input change event to show preview
            $('#path_file').on('change', function(event) {
                var input = event.target;
                var file = input.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview_image').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#preview_image').hide();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fileInput = document.getElementById('path_file');
            var previewImage = document.getElementById('preview_image');
            var imagePreviewContainer = document.getElementById('image_preview');

            fileInput.addEventListener('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        // Set the src of the preview image
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block'; // Show the preview image
                    }

                    reader.readAsDataURL(file);
                } else {
                    // Hide the preview image if no file is selected
                    previewImage.style.display = 'none';
                }
            });
        });
    </script>

            <!-- JavaScript to handle modal -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const galleryLinks = document.querySelectorAll('.gallery-link');
                    const modalImage = document.getElementById('modalImage');
                    const modalDescription = document.getElementById('modalDescription');

                    galleryLinks.forEach(link => {
                        link.addEventListener('click', function () {
                            const imageSrc = this.getAttribute('data-image');
                            const imageDescription = this.getAttribute('data-description');
                            modalImage.src = imageSrc;
                            modalDescription.textContent = imageDescription;
                        });
                    });
                });
            </script>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif


    @endpush

@endsection
