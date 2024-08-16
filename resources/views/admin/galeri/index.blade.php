@extends('layouts.panel.index')

@section('title', 'Dashboard')

@section('content')
{{-- <h1>Galeri</h1> --}}
@push('style')


<style>

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
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                    <form action="{{ route('galeri.destroy', $item->id_galeri) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                    </form>
                                </div>
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

                                                <div class="form-group">
                                                    <label for="image">Upload New Image (Optional)</label>
                                                    <input type="file" name="image" class="form-control" id="image">
                                                </div>

                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" class="form-control" id="name" value="{{ $item->nama }}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" class="form-control" id="description" required>{{ $item->deskripsi }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="kategori">Pilih Kategori:</label>
                                                    <select class="form-control" id="kategori" name="kategori" required>
                                                        <option value="">Select category</option>
                                                        <option value="partner" {{ $item->kategori == 'partner' ? 'selected' : '' }}>Partner</option>
                                                        <option value="klien" {{ $item->kategori == 'klien' ? 'selected' : '' }}>Klien</option>
                                                        <option value="gambar" {{ $item->kategori == 'gambar' ? 'selected' : '' }}>Gambar</option>
                                                        <option value="video" {{ $item->kategori == 'video' ? 'selected' : '' }}>Video</option>
                                                    </select>
                                                </div>


                                            </form>
                                        </div>
                                        <!-- Modal Footer -->
                                        <div class="modal-footer bg-light">
                                            <div class="d-flex justify-content-end w-100">
                                                <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
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
                            <select name="page_id" class="form-control" id="page_id" required>
                                <option value="">Select Page ID</option>
                                @foreach ($pages as $page)
                                    <option value="{{ $page->id_page }}">{{ $page->id_page }} - {{ $page->nama_page }}
                                    </option>
                                @endforeach
                            </select>
                        </div>




                        <!-- Title input -->
                        <div class="form-group mb-3">
                            <label for="nama">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan judul"
                                id="nama" required>
                        </div>

                        <!-- Category Selection -->
                        <div class="form-group mb-3">
                            <label for="kategori">Pilih Kategori <span class="text-danger">*</span></label>
                            <select class="form-control" id="kategori" name="kategori" required>
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
                                <input type="file" name="path_file" class="dropzone" id="path_file"
                                    accept="image/*,video/*" required>


                                <div id="image_preview" class="mt-3"
                                    style="display: flex; align-items: center; justify-content: center; max-width: 300px; max-height: 300px; overflow: hidden; border: 1px solid #ddd; padding: 65px;">
                                    <img id="preview_image" src="" alt="Image preview"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain; display: none;">
                                </div>
                            </div>
                            <div class="mt-2">
                                <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb
                                </small>
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
                    xx
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
                text: '{{ session('success') }}',
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
