@extends('layouts.panel.index')
@section('title', 'Profil Perusahaan')
@section('content')

@push('style')

<style>
    .section__container {
        padding: 30px;
    }

    .header p {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .header h1 {
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: #222;
    }

    /* Profile Grid */
    .profile__grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
    }

    /* Profile Item Card */
    .profile-item {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 100%;
        width: 100%;
        max-width: 600px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .profile-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    /* Profile Image */
    .profile-image {
        display: block;
        max-width: 100%;
        height: auto;
        margin: 0 auto;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    /* Profile Details */
    .profile-details {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
    }



    </style>
@endpush

{{-- <h1>Profil Perusahaan</h1> --}}

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="mt-4">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <tr>
                            <th>No</th>
                            <th scope="col">Page Id</th>
                            <th scope="col">Tentang Kami</th>
                            {{-- <th scope="col">Struktur Organisasi</th> --}}
                            <th scope="col">Visi</th>
                            <th scope="col">Misi</th>
                            <th scope="col">Sejarah</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="" style="vertical-align: middle">
                        @foreach ($profil as $row)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                                <td>{!! strip_tags($row->tentang_kami, '<br><strong><em>') !!}</td>
                                {{-- <td>
                                    @if ($row->path_struktur_organisasi)
                                        <img src="{{ asset('storage/' . $row->path_struktur_organisasi) }}" alt="Struktur Organisasi" style="max-width: 150px; height: auto;">
                                    @else
                                        N/A
                                    @endif
                                </td> --}}
                                <td>{!! strip_tags($row->visi, '<br><strong><em>') !!}</td>
                                <td>{!! strip_tags($row->misi, '<br><strong><em>') !!}</td>
                                <td>{!! strip_tags($row->sejarah, '<br><strong><em>') !!}</td>
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
                                            id="dropdownMenuButton{{ $row->id_profil_perusahaan }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_profil_perusahaan }}">
                                            <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit{{ $row->id_profil_perusahaan }}"><i
                                                        class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                            <li><a href="{{ route('profil.destroy', $row->id_profil_perusahaan) }}"
                                                    class="dropdown-item text-danger" data-confirm-delete="true"><i
                                                        class="fa-regular fa-trash-can pe-none"></i>
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
        </div>
    </div>
</div>

<!-- Profile Section -->
<div class="section__container mt-5">
    <div class="header">
        <p>PROFIL PERUSAHAAN</p>
        <h1>STRUKTUR ORGANISASI</h1>
    </div>
    <div class="profile__grid">
        @foreach ($profil as $profile)
            <div class="profile-item">
                @if ($profile->path_struktur_organisasi)
                    <img src="{{ asset('storage/' . $profile->path_struktur_organisasi) }}" alt="Struktur Organisasi" class="profile-image">
                @endif
                <div class="profile-details">
                    <p><strong>Tentang Kami:</strong> {!! preg_replace('/<p>|<\/p>/', '', $profile->tentang_kami) !!}</p>
                    <p><strong>Visi:</strong> {!! preg_replace('/<p>|<\/p>/', '', $profile->visi) !!}</p>
                    <p><strong>Misi:</strong> {!! preg_replace('/<p>|<\/p>/', '', $profile->misi) !!}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>






<!-- Modal HTML -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Tambah Profil</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profil.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">

                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                        <select class="form-select" name="page_id" aria-label="Default select example" required>
                            <option selected value="">Pilih ...</option>
                            @foreach ($page as $row)
                                <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tentang_kami" class="form-label">Tentang Kami <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="tentang_kami" id="tentang_kami" rows="4" required></textarea>
                    </div>

                    <div class="form-group mb-6">
                        <label class="control-label">Upload Struktur Organisasi Image <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Choose an image file or drag it here.</p>
                            </div>
                            <input type="file" name="path_struktur_organisasi" class="dropzone" id="path_struktur_organisasi"
                                accept="image/*" onchange="previewImage(event)">
                            <div id="image_preview" class="mt-3"
                                style="display: flex; align-items: center; justify-content: center; max-width: 300px; max-height: 300px; overflow: hidden; border: 1px solid #ddd; padding: 65px;">
                                <img id="preview_image" src="" alt="Image preview"
                                    style="max-width: 100%; max-height: 100%; object-fit: contain; display: none;">
                            </div>
                        </div>
                        <div class="mt-2">
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp</small>
                        </div>
                        <div id="image_error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="visi" class="form-label">Visi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="visi" id="visi" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="misi" id="misi" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="sejarah" class="form-label">Sejarah <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="sejarah" id="sejarah" rows="4" required></textarea>
                    </div>

                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch">
                            <label for="status" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                                   {{ isset($row) && $row->status ? 'checked' : '' }}>
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




@foreach ($profil as $row)
<div class="modal modal-lg fade" id="edit{{ $row->id_profil_perusahaan }}" tabindex="-1" aria-labelledby="edit{{ $row->id_profil_perusahaan }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="edit{{ $row->id_profil_perusahaan }}Label">Edit Profil</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profil.update', $row->id_profil_perusahaan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">

                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID</label>
                        <select class="form-select" name="page_id" aria-label="Default select example" required>
                            @foreach ($page as $element)
                                <option value="{{ $element->id_page }}"
                                    {{ $element->id_page == $row->page_id ? 'selected' : '' }}>
                                    {{ $element->nama_page }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tentang_kami{{ $row->id_profil_perusahaan }}" class="form-label">Tentang Kami</label>
                        <textarea class="form-control ck-editor" name="tentang_kami" id="tentang_kami{{ $row->id_profil_perusahaan }}" rows="4" required>{{ $row->tentang_kami }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="path_struktur_organisasi" class="form-label">Upload Struktur Organisasi Image</label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Choose an image file or drag it here.</p>
                            </div>
                            <input type="file" name="path_struktur_organisasi" class="dropzone" id="path_struktur_organisasi"
                                accept=".png, .jpg, .jpeg" onchange="previewImage(event)">

                            <!-- Image preview area -->
                            <div id="image_preview" class="mt-3"
                                style="display: flex; align-items: center; justify-content: center; max-width: 300px; max-height: 300px; overflow: hidden; border: 1px solid #ddd; padding: 65px;">
                                <img id="preview_image" src="{{ $row->path_struktur_organisasi ? asset('storage/' . $row->path_struktur_organisasi) : '' }}" alt="Image preview"
                                    style="max-width: 100%; max-height: 100%; object-fit: contain; display: {{ $row->path_struktur_organisasi ? 'block' : 'none' }};">
                            </div>
                        </div>
                        <div class="mt-2">
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp</small>
                        </div>
                        <div id="image_error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="visi{{ $row->id_profil_perusahaan }}" class="form-label">Visi</label>
                        <textarea class="form-control ck-editor" name="visi" id="visi{{ $row->id_profil_perusahaan }}" rows="3" required>{{ $row->visi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="misi{{ $row->id_profil_perusahaan }}" class="form-label">Misi</label>
                        <textarea class="form-control ck-editor" name="misi" id="misi{{ $row->id_profil_perusahaan }}" rows="3" required>{{ $row->misi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sejarah{{ $row->id_profil_perusahaan }}" class="form-label">Sejarah</label>
                        <textarea class="form-control ck-editor" name="sejarah" id="sejarah{{ $row->id_profil_perusahaan }}" rows="4" required>{{ $row->sejarah }}</textarea>
                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch">
                            <label for="edit_status_profil_{{ $row->id_profil_perusahaan }}" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" id="edit_status_profil_{{ $row->id_profil_perusahaan }}" name="status" value="1" {{ $row->status ? 'checked' : '' }}>
                            <!-- Hidden input field for unchecked status -->
                            <input type="hidden" name="status_hidden" value="0">
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


            <!-- JavaScript to handle modal -->

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


                function previewImage(event) {
    const input = event.target;
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('preview_image');
            preview.src = e.target.result;
            preview.style.display = 'block'; // Show the preview image
        };

        reader.readAsDataURL(file);
    } else {
        const preview = document.getElementById('preview_image');
        preview.src = '';
        preview.style.display = 'none'; // Hide the preview image if no file
    }
}

</script>

<script>

// Optional: Handle drag and drop for the file input
const dropzone = document.querySelector('.dropzone-wrapper');

dropzone.addEventListener('dragover', function(event) {
    event.preventDefault();
    dropzone.classList.add('dragging');
});

dropzone.addEventListener('dragleave', function() {
    dropzone.classList.remove('dragging');
});

dropzone.addEventListener('drop', function(event) {
    event.preventDefault();
    dropzone.classList.remove('dragging');

    const files = event.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('path_struktur_organisasi').files = files;
        previewImage({ target: document.getElementById('path_struktur_organisasi') });
    }
});



function previewImage(event) {
    const input = event.target;
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('preview_image');
            preview.src = e.target.result;
            preview.style.display = 'block'; // Show the preview image
        };

        reader.readAsDataURL(file);
    } else {
        const preview = document.getElementById('preview_image');
        preview.src = '';
        preview.style.display = 'none'; // Hide the preview image if no file
    }
}

// Optional: Handle drag and drop for the file input
const dropzone = document.querySelector('.dropzone-wrapper');

dropzone.addEventListener('dragover', function(event) {
    event.preventDefault();
    dropzone.classList.add('dragging');
});

dropzone.addEventListener('dragleave', function() {
    dropzone.classList.remove('dragging');
});

dropzone.addEventListener('drop', function(event) {
    event.preventDefault();
    dropzone.classList.remove('dragging');

    const files = event.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('path_struktur_organisasi').files = files;
        previewImage({ target: document.getElementById('path_struktur_organisasi') });
    }
});







</script>



{{-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> --}}
<script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize CKEditor on modal show
        var addModal = document.getElementById('add');
        addModal.addEventListener('shown.bs.modal', function () {
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('tentang_kami');
                CKEDITOR.replace('visi');
                CKEDITOR.replace('misi');
                CKEDITOR.replace('sejarah');
            }
        });

        // Ensure CKEditor is destroyed when modal is hidden
        addModal.addEventListener('hidden.bs.modal', function () {
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.instances['tentang_kami'].destroy();
                CKEDITOR.instances['visi'].destroy();
                CKEDITOR.instances['misi'].destroy();
                CKEDITOR.instances['sejarah'].destroy();
            }
        });
    });
</script>

@endsection
