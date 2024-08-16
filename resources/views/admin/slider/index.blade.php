@extends('layouts.panel.index')
@section('title', 'Slider')
@section('content')

<h1>Slider</h1>

<style>
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: blue;
        border-radius: 50%;
    }
</style>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

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
                    <th>Description</th>
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
                        <td>{{ $row->description }}</td>
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
                                    <li>
                                        <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_slider }}">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </a>
                                    </li>
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

<!-- Slider Carousel with Swipe Support -->
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

<!-- Add Swiper.js or Bootstrap Swipe Handling -->
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
                        <select class="form-select" name="page_id" aria-label="Select Page" required>
                            <option selected>Select Page... <span class="text-danger">*</span></option>
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
                        <label class="form-label">Upload Image <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Choose an image file or drag it here.</p>
                            </div>
                            <input type="file" name="image_file" class="dropzone" id="image_file" accept="image/*" required>

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
                        <select class="form-select" name="page_id" aria-label="Select Page" required>
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
                        <label for="image_file_edit" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image_file_edit" id="image_file_edit_{{ $row->id_slider }}" accept="image/*">

                        <div id="image_preview_edit_{{ $row->id_slider }}" class="mt-3"
                            style="display: flex; align-items: center; justify-content: center; max-width: 300px; max-height: 300px; overflow: hidden; border: 1px solid #ddd; padding: 65px;">
                            <img id="preview_image_edit_{{ $row->id_slider }}" src="{{ $row->image_url }}" alt="Image preview"
                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                    </div>

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
            document.getElementById('image_file').addEventListener('change', function(event) {
                const input = event.target;
                const preview = document.getElementById('preview_image');
                const imagePreviewDiv = document.getElementById('image_preview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        imagePreviewDiv.style.padding = '0';  // Remove padding when the image is displayed
                        imagePreviewDiv.style.border = 'none'; // Remove border when the image is displayed
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                    imagePreviewDiv.style.padding = '65px'; // Restore padding if no image
                    imagePreviewDiv.style.border = '1px solid #ddd'; // Restore border if no image
                }
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


        document.addEventListener('DOMContentLoaded', function () {
    @foreach ($slider as $row)
        document.getElementById('image_file_edit_{{ $row->id_slider }}').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('preview_image_edit_{{ $row->id_slider }}');
            const imagePreviewDiv = document.getElementById('image_preview_edit_{{ $row->id_slider }}');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreviewDiv.style.padding = '0';  // Remove padding when the image is displayed
                    imagePreviewDiv.style.border = 'none'; // Remove border when the image is displayed
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '{{ $row->image_url }}';
                imagePreviewDiv.style.padding = '65px'; // Restore padding if no image
                imagePreviewDiv.style.border = '1px solid #ddd'; // Restore border if no image
            }
        });
    @endforeach
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
