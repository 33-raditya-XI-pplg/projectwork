@extends('layouts.panel.index')

@section('title', 'Testimoni')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('style')


<style>

.select2-close-mask{
        z-index: 2099 !important;
    }
    .select2-dropdown{
        z-index: 3051 !important;
    }
.card {
    text-align: center;
}

.rating {
    display: inline-flex;
    justify-content: center;
    margin-top: 0.5rem;
}

.rating .fa {
    font-size: 1.5rem;
    color: #ccc;
    margin-right: 0.2rem;
}

.rating .fa.filled {
    color: #ffcc00;
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
@endpush


    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <tr>
                                <th>No</th>
                                <th scope="col">Page Id</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Rating</th>
                                {{-- <th scope="col">Isi Testimoni</th> --}}
                                {{-- <th scope="col">Foto</th> --}}
                                <th scope="col">Status Publikasi</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle">
                            @foreach ($testimoni as $row)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                                    <td>{{ $row->user->nama_lengkap }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->tanggal->format('Y-m-d') }}</td>
                                    <td>
                                        @for ($i = 0; $i < $row->rating; $i++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor
                                        @for ($i = $row->rating; $i < 5; $i++)
                                            <i class="fa fa-star-o text-muted"></i>
                                        @endfor
                                    </td>
                                    {{-- <td>{{ $row->isi_testimoni }}</td> --}}
                                    {{-- <td>
                                        @if ($row->photo)
                                            <img src="{{ asset('storage/' . $row->photo) }}" alt="Testimoni Foto"
                                                class="img-thumbnail" style="max-height: 100px;">
                                        @else
                                            <p class="text-muted">No photo available</p>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <button type="button" class="badge rounded-3
                                            {{ $row->status ? 'bg-success' : 'bg-danger' }}"
                                            disabled>
                                            {{ $row->status ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton{{ $row->id_testimoni }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_testimoni }}">
                                                <li>
                                                    <a class="dropdown-item text-black" href="{{ route('testimoni.show', $row->id_testimoni) }}">
                                                        <i class="fa-solid fa-code pe-none"></i> Rincian
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_testimoni }}">
                                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form id="deleteForm{{ $row->id_testimoni }}" action="{{ route('testimoni.destroy', $row->id_testimoni) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('{{ $row->id_testimoni }}')">
                                                            <i class="fa-regular fa-trash-can pe-none"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                        <script>
                                            function confirmDelete(testimoniId) {
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
                                                        document.getElementById('deleteForm' + testimoniId).submit();
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

     {{-- Insert Modal --}}
     <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="addLabel">Tambah Testimoni</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="{{ route('testimoni.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                        {{-- <input type="hidden" name="user_id"  id="user_id"> --}}

                        <div class="form-group mb-3">
                            <label for="page_id">Page ID <span class="text-danger">*</span></label>
                            <select name="page_id" class="form-control js-example-basic-single" id="page_id" data-placeholder="Select Page ID" required>
                            <option value="">Select Page ID</option>
                                @foreach ($page as $row)
                                    <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                                @endforeach
                            </select>
                            @error('page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama <span class="text-danger">*</span></label>
                            {{-- <input type="text" class="form-control" name="nama" id="nama" required> --}}
                            <select class="form-control js-example-basic-single" name="id_user" id="id_user" data-placeholder="Pilih Pengguna" required >
                                <option value=""></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id_user }}">{{ $user->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" required readonly>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" required>
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" name="rating" id="rating" data-placeholder="Select Rating" required>
                                <option value="" disabled selected>Pilih Rating</option>
                                <option value="1">1 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="isi_testimoni" class="form-label">Isi Testimoni <span class="text-danger">*</span></label>
                            <textarea class="form-control ck-editor" id="isi_testimoni" name="isi_testimoni" rows="3"></textarea>
                            <span class="form-text text-danger">Harap masukkan minimal 3 kalimat.</span>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="photo" class="form-label">Foto </label>
                            <input type="file" class="form-control" name="photo" id="photo">
                        </div> --}}
                        {{-- dropzone --}}
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
                            <label for="status_publikasi" class="form-label">Status Publikasi</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="status_publikasi" value="1">
                                <label class="form-check-label" for="status">Published</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-danger rounded-3 me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach ($testimoni as $row)
    <div class="modal modal-lg fade" id="edit{{ $row->id_testimoni }}" tabindex="-1" aria-labelledby="edit{{ $row->id_testimoni }}Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="edit{{ $row->id_testimoni }}Label">Edit Testimoni</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('testimoni.update', $row->id_testimoni) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">

                        <div class="mb-3">
                            <p class="text-danger">Field ini tidak dapat diedit oleh admin.</p>
                            <label for="page_id_display" class="form-label">Page ID</label>
                            <select class="form-control " name="page_id_display" aria-label="Default select example" disabled>
                                @foreach ($page as $element)
                                    <option value="{{ $element->id_page }}"
                                        {{ $element->id_page == $row->page_id ? 'selected' : '' }}>
                                        {{ $element->nama_page }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <p class="text-danger">Field ini tidak dapat diedit oleh admin.</p>
                            <label for="nama" class="form-label">Nama</label>               
                            <input type="text" class="form-control" name="nama" id="nama" value="{{ $row->user->nama_lengkap }}" readonly disabled>
                        
                        </div>

                        <div class="mb-3">
                            <p class="text-danger">Field ini tidak dapat diedit oleh admin.</p>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <p class="text-danger">Field ini tidak dapat diedit oleh admin.</p>
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ $row->tanggal->format('Y-m-d') }}" class="form-control" placeholder="Tanggal" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <p class="text-danger">Field ini tidak dapat diedit oleh admin.</p>
                            <label for="rating" class="form-label">Rating</label>
                            <div class="mb-3">
                                <p class="text-danger">Field ini tidak dapat diedit oleh admin.</p>
                                <label for="rating" class="form-label">Rating</label>
                                <div class="d-flex align-items-center position-relative">
                                    <input type="text" class="form-control" disabled readonly style="padding-right: 30px;">                           
                                    <div class="position-absolute" style="top: 50%; right: 640px; transform: translateY(-50%);">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star {{ $i <= $row->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                                                                              
                        </div>

                        <div class="mb-3">
                            <p class="text-danger">Field ini tidak dapat diedit oleh admin.</p>
                            <label for="isi_testimoni" class="form-label">Isi Testimoni</label>
                            <textarea class="form-control ck-editor" style="height:150px" name="isi_testimoni" id="isi_testimoni" placeholder="Isi Testimoni" disabled readonly>{{ $row->isi_testimoni }}</textarea>
                        </div>

                        <div class="mb-3">
                            <p class="text-danger">Field ini tidak dapat diedit oleh admin.</p>
                            <label for="photo" class="form-label">Foto</label>
                            <div class="dropzone-wrapper">                             
                                <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                        @if ($row->photo)
                                            <img  src="{{ asset( $row->photo) }}" alt="Testimoni Foto" class="img-thumbnail mt-2" style="max-height: 100px max-widht:100px;">
                                        @else
                                            <p>Tidak ada foto yang diunggah.</p>
                                        @endif
                                        <input type="hidden" name="photo" value="{{ $row->photo }}">
                                </div>                                
                            </div>                       
                        </div>                 

                        <div class="mb-3">
                            <p class="text-primary">Field ini dapat diedit oleh admin.</p>
                            <label for="status" class="form-label">Status Publikasi</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $row->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    {{ $row->status ? 'Published' : 'Unpublished' }}
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-end mx-3">
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
    
    <!-- Testimonials Section -->
    {{-- <div class="section__container">
        <div class="header">
            <p>TESTIMONIALS</p>
            <h1>Ini Testimoni dari clients.</h1>
        </div>
        <div class="testimonials__grid">
            @foreach ($testimonials as $testimonial)
                <div class="card">
                    <span><i class="ri-double-quotes-l"></i></span>
                    <p>
                        {{ $testimonial->isi_testimoni }}
                    </p>
                    <hr />
                    @if ($testimonial->photo)
                        <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="user" />
                    @endif
    
                    <!-- Rating Stars -->
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa {{ $i <= $testimonial->rating ? 'fa-star filled' : 'fa-star' }}"></i>
                        @endfor
                    </div>
    
                    <p class="name">{{ $testimonial->nama }}</p>
                </div>
            @endforeach
        </div>
    </div> --}}

@push('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
 {{-- <!-- Include CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
</script> --}}

<!-- Add this script in your Blade view, preferably at the bottom -->
<script>
    $(document).ready(function() {
        // Event listener for the 'nama' dropdown change
        $('#id_user').on('change', function() {
            var userId = $(this).val();

            // Check if a name is selected
            if (userId) {
                // Perform an AJAX request to fetch the email
                $.ajax({
                    url: "{{ route('getEmail', '') }}/" + userId, // Fetch the email using the route
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        // Fill the email field with the fetched email
                        if (response.email) {
                            $('#email').val(response.email);
                        } else {
                            $('#email').val('');
                        }
                    },
                    error: function() {
                        // In case of an error, clear the email field
                        $('#email').val('');
                    }
                });
            } else {
                // Clear the email field if no name is selected
                $('#email').val('');
            }
        });
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
        url: "/testimoni", // URL server untuk unggahan
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#addForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Something went wrong.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error('Error:', error);
                });
        });
    });
</script> --}}

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
