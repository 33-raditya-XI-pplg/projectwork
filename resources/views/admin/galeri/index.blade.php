@extends('layouts.panel.index')

@section('title', 'Dashboard')

@section('content')
    <h1>Galeri</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>
                </div>

                <!-- Button to trigger the modal -->
                <a href="#addImageModal" data-bs-toggle="modal" class="btn btn-primary btn-block mt-3">Upload Gambar</a>

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

                <!-- Table to display images -->
                <div class="card-body mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($galeri as $item)
                                        @if (!strpos($item->path_file, 'youtube.com') && !strpos($item->path_file, 'youtu.be'))
                                            <tr>
                                                <td>
                                                    <img src="{{ asset($item->path_file) }}" alt="{{ $item->deskripsi }}"
                                                        style="width: 500px; height: auto;">
                                                </td>
                                                <td>{{ $item->deskripsi }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle btn-sm"
                                                            type="button" id="dropdownMenuButton{{ $item->id_galeri }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton{{ $item->id_galeri }}">
                                                            <li>
                                                                <!-- Trigger Modal -->
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editGaleriModal{{ $item->id_galeri }}">
                                                                    Edit
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('galeri.destroy', $item->id_galeri) }}"
                                                                    method="POST" class="d-inline"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">Delete</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade" id="editGaleriModal{{ $item->id_galeri }}"
                                                tabindex="-1" aria-labelledby="editGaleriModalLabel{{ $item->id_galeri }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title"
                                                                id="editGaleriModalLabel{{ $item->id_galeri }}">Edit Galeri
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('galeri.update', $item->id_galeri) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="form-group">
                                                                    <label for="image">Upload New Image
                                                                        (Optional)</label>
                                                                    <input type="file" name="image"
                                                                        class="form-control" id="image">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" name="name"
                                                                        class="form-control" id="name"
                                                                        value="{{ $item->nama }}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="description">Description</label>
                                                                    <textarea name="description" class="form-control" id="description" required>{{ $item->deskripsi }}</textarea>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="kategori">Pilih Kategori:</label>
                                                                    <select class="form-control" id="kategori"
                                                                        name="kategori" required>
                                                                        <option value="">Select category</option>
                                                                        <option value="partner"
                                                                            {{ $item->kategori == 'partner' ? 'selected' : '' }}>
                                                                            Partner</option>
                                                                        <option value="klien"
                                                                            {{ $item->kategori == 'klien' ? 'selected' : '' }}>
                                                                            Klien</option>
                                                                        <option value="gambar"
                                                                            {{ $item->kategori == 'gambar' ? 'selected' : '' }}>
                                                                            Gambar</option>
                                                                        <option value="video"
                                                                            {{ $item->kategori == 'video' ? 'selected' : '' }}>
                                                                            Video</option>
                                                                    </select>
                                                                </div>

                                                                <button type="submit"
                                                                    class="btn btn-primary btn-block">Update</button>
                                                            </form>
                                                        </div>
                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer bg-light">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada gambar ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Image Modal -->
    <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
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
                            <label for="page_id">Page ID:</label>
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
                            <label for="nama">Judul :</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan judul"
                                id="nama">
                        </div>

                        <!-- Category Selection -->
                        <div class="form-group mb-3">
                            <label for="kategori">Pilih Kategori:</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">Select category</option>
                                <option value="partner">Partner</option>
                                <option value="klien">Klien</option>
                                <option value="gambar">Gambar</option>
                                <option value="video">Video</option>
                            </select>
                        </div>

                        <div class="form-group mb-6">
                            <label class="control-label">Upload Image or Video</label>
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
                            <div id="image_error"></div>
                        </div>


                        <!-- Description (optional) -->
                        <div class="form-group mb-4">
                            <label for="deskripsi">Deskripsi (optional):</label>
                            <textarea name="deskripsi" class="form-control" placeholder="Tambahkan deskripsi (opsional)" id="deskripsi"></textarea>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                    <!-- End Single Form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

@endsection
