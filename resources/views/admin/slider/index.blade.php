@extends('layouts.panel.index')
@section('title', 'Slider')
@section('content')


<style>
 .select2-close-mask{
        z-index: 2099 !important;
    }
    .select2-dropdown{
        z-index: 3051 !important;
    }
.carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: blue;
        border-radius: 50%;
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

.dropzone-wrapper.dragging {
    border-color: #000;
}

</style>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Include CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            placeholder: $(this).data('placeholder'),
            allowClear: true,
            minimumResultsForSearch: Infinity // Optional: hides the search bar
        });
    });
</script>
<!-- Slider Management Table -->
{{-- <h3 class="mb-0">Slider</h3> --}}
<div class="bg-white rounded-4 px-3 py-4 mb-5 shadow-lg">
    <div class="d-flex justify-content-between align-items-center mb-3">

        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">
            <i class="fa-solid fa-plus"></i> Add Slider
        </button> --}}
    </div>

    <div class="table-responsive">
        <table id="example" class="table">
            <thead class="fw-normal">
                <tr>
                    <th>No</th>
                    <th>Page ID</th>
                    <th>Title</th>
                    <!-- <th>Description</th> -->
                    {{-- <th>Image URL</th> --}}
                    <th>Position</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($slider as $row)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                        <td>{{ $row->title }}</td>
                        <!-- <td>{{ $row->description }}</td> -->
                        {{-- <td><a href="{{ $row->image_url }}" target="_blank">{{ $row->image_url }}</a></td> --}}
                        <td>{{ $row->position }}</td>
                        <td>
                            <button type="button" class="btn rounded-3
                                {{ $row->status ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                disabled>
                                {{ $row->status ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </td>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                    id="dropdownMenuButton{{ $row->id_slider }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_slider }}">
                                   
                                        <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_slider }}">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                                <a class="dropdown-item text-success" href="{{ route('slider.show', $row->id_slider) }}">
                                                    <i class="fa-regular fa-eye"></i> Rincian
                                                </a>
                                            </li>
                                    <li>
                                    <li>
                                        <form id="deleteForm{{ $row->id_slider }}" action="{{ route('slider.destroy', $row->id_slider) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('{{ $row->id_slider }}')">
                                                <i class="fa-regular fa-trash-can"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <script>
                                function confirmDelete(sliderId) {
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
                                            document.getElementById('deleteForm' + sliderId).submit();
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

<!-- Slider Carousel with Swipe Support
<div id="sliderCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($slider as $index => $slide)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="d-flex justify-content-center">
                    <img src="{{ $slide->image_url }}" class="d-block" alt="{{ $slide->title }}" style="max-height: 500px; max-width: 80%;">
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $slide->title }}</h5>
                    <p>{{ $slide->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#sliderCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#sliderCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

 Add Swiper.js or Bootstrap Swipe Handling -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var carousel = document.querySelector('#sliderCarousel');
        var touchStartX = 0;
        var touchEndX = 0;

        carousel.addEventListener('touchstart', function(event) {
            touchStartX = event.changedTouches[0].screenX;
        });

        carousel.addEventListener('touchend', function(event) {
            touchEndX = event.changedTouches[0].screenX;
            handleSwipeGesture();
        });

        function handleSwipeGesture() {
            if (touchEndX < touchStartX) {
                carousel.querySelector('.carousel-control-next').click();
            }
            if (touchEndX > touchStartX) {
                carousel.querySelector('.carousel-control-prev').click();
            }
        }
    });
</script>
 

<!-- Insert Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addLabel">Add Slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                        <select class="form-select  js-example-basic-single" name="page_id" aria-label="Select Page" data-placeholder="Pilih Page" required>
                        <option value="">Select Page ID</option>
                        @foreach ($page as $row)
                                <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                        <textarea class="form-control ck-editor" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
    <label for="image_file" class="form-label">Upload Image <span class="text-danger">*</span></label>
    <div class="dropzone-wrapper">
        <div class="dropzone-desc">
            <i class="glyphicon glyphicon-download-alt"></i>
            <p>Drag and drop an image file here or click to choose one.</p>
        </div>
        <input type="file" name="image_file" class="dropzone" id="image_file" accept=".jpg, .jpeg, .png" style="display: none;">
        <div id="image_preview" style="display: none;">
            <img id="image_preview_img" alt="Image Preview" class="preview_image" style="max-width: 200px; max-height: 200px;">
        </div>
    </div>
    <small style="color: red;">Format must be: .jpg, .jpeg, .png and max size 2MB</small>
    @error('image_file')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                        <select class="form-select" name="position" id="position" required>
                            <option value="" disabled selected>Select Position</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    @if ($slider->pluck('position')->contains($i))
                                        disabled
                                        style="background-color: #f8d7da; color: #721c24;"
                                    @endif>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                            <label class="form-check-label" for="status"></label>
                        </div>
                        <small class="form-text text-muted"></small>
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
</div>


<!-- Edit Modals -->
@foreach ($slider as $row)
<div class="modal modal-lg fade" id="edit{{ $row->id_slider }}" tabindex="-1"
    aria-labelledby="edit{{ $row->id_slider }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="edit{{ $row->id_slider }}Label">Edit Slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('slider.update', $row->id_slider) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID</label>
                        <select class="form-select js-example-basic-single" name="page_id" aria-label="Select Page"  data-placeholder="Pilih Page" required>
                            @foreach ($page as $element)
                                <option value="{{ $element->id_page }}" {{ $element->id_page == $row->page_id ? 'selected' : '' }}>
                                    {{ $element->nama_page }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control ck-editor" id="description" name="description" rows="3">{{ old('description', $row->description) }}</textarea>
                    </div> 
                    
                    
                    
                    <div class="mb-3">
    <label for="edit_image_{{ $row->id_slider }}" class="form-label">Upload Image</label>
    
    <!-- Dropzone Container -->
    <div class="dropzone-wrapper" style="height: 300px;">
        <div class="dropzone-desc">
            <i class="glyphicon glyphicon-download-alt"></i>
            <p>Choose an image file or drag it here.</p>
        </div>
        <input type="file" name="image_file_edit" class="dropzone" id="edit_image_{{ $row->id_slider }}" accept=".png, .jpg, .jpeg" style="display:none;">

        <!-- Image Preview Area -->
        <div id="edit_logo_preview_{{ $row->id_slider }}" class="mt-3" style="display: flex; align-items: center; justify-content: center; max-width: 200px; max-height: 200px;">
            @if($row->image_url) <!-- Use 'image_url' from the database -->
                <img src="{{ asset($row->image_url) }}" id="edit_logo_image_preview_{{ $row->id_slider }}" alt="Logo Preview" style="max-width: 100%;">
            @else
                <img src="" id="edit_logo_image_preview_{{ $row->id_slider }}" alt="Logo Preview" style="max-width: 100%; display: none;">
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropzoneEdit = document.getElementById('edit_image_{{ $row->id_slider }}');
        const previewImageEdit = document.getElementById('edit_logo_image_preview_{{ $row->id_slider }}');

        // Click event to trigger file input when dropzone is clicked
        dropzoneEdit.closest('.dropzone-wrapper').addEventListener('click', function() {
            dropzoneEdit.click();
        });

        // Handle file input change event
        dropzoneEdit.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImageEdit.src = e.target.result;
                    previewImageEdit.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <select class="form-select" name="position" id="position" required>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    @if ($slider->pluck('position')->contains($i) && $i != $row->position)
                                        disabled
                                        style="background-color: #f8d7da; color: #721c24;"
                                    @endif
                                    {{ $i == $row->position ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <label for="edit_status_profil_{{ $row->id_slider }}" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" id="edit_status_profil_{{ $row->id_slider }}" name="status" value="1" {{ $row->status ? 'checked' : '' }}>
                            <!-- Hidden input field for unchecked status -->
                            <input type="hidden" name="status_hidden" value="0">
                        </div>
                        <small class="form-text text-muted">Check to set status as active. Uncheck for inactive.</small>
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

@push('script')
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('image_file');
    const previewImage = document.getElementById('image_preview_img');
    const imagePreviewContainer = document.getElementById('image_preview');

    // Handle file input change event to show preview
    fileInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                imagePreviewContainer.style.display = 'block'; // Show the preview image
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '';
            imagePreviewContainer.style.display = 'none'; // Hide the preview image if no file
        }
    });

    // Optional: Handle drag and drop for the file input
    const dropzone = document.querySelector('.dropzone-wrapper');

    dropzone.addEventListener('dragover', function (event) {
        event.preventDefault();
        dropzone.classList.add('dragging');
    });

    dropzone.addEventListener('dragleave', function () {
        dropzone.classList.remove('dragging');
    });

    dropzone.addEventListener('drop', function (event) {
        event.preventDefault();
        dropzone.classList.remove('dragging');
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            const changeEvent = new Event('change');
            fileInput.dispatchEvent(changeEvent);
        }
    });

    // Show the dropzone on clicking the desc
    dropzone.addEventListener('click', function () {
        fileInput.click();
    });
});

    </script>

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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
@endpush



@endsection
