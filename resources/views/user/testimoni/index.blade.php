@extends('layouts.panel.index')
@section('title','Testimoni')

@section('content')
<style>
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
                            <th scope="col">Isi Testimoni</th>
                            <th scope="col">Foto</th>
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
                                <td>{{ $row->isi_testimoni }}</td>
                                <td>
                                    @if ($row->photo)
                                        <img src="{{ asset( $row->photo) }}" alt="Testimoni Foto"
                                            class="img-thumbnail" style="max-height: 100px;">
                                    @else
                                        <p class="text-muted">No photo available</p>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="badge rounded-3
                                        {{ $row->status ? 'bg-success' : 'bg-danger' }}"
                                        disabled>
                                        {{ $row->status ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </td>
                                <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ route('testimoni-user.show', $row->id_testimoni) }}"
            class="btn btn-primary btn-sm rounded text-white d-flex align-items-center gap-1">
            <i class="fa-solid fa-code" style="font-size: 0.75rem; color: white;"></i>
            <span>Rincian</span>
        </a>

        <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_testimoni }}"
            class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
            <i class="fa-regular fa-pen-to-square" style="font-size: 0.75rem; color: white;"></i>
            <span>Edit</span>
        </a>

        <form id="deleteForm-user{{ $row->id_testimoni }}" action="{{ route('testimoni-user.destroy', $row->id_testimoni) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete('{{ $row->id_testimoni }}')"
                class="btn btn-danger btn-sm rounded text-white d-flex align-items-center gap-1">
                <i class="fa-regular fa-trash-can" style="font-size: 0.75rem; color: white;"></i>
                <span>Delete</span>
            </button>
        </form>
    </div>

    <script>
        function confirmDelete(id) {
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
                    document.getElementById('deleteForm-user' + id).submit();
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

{{-- modal create --}}
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Tambah Testimoni</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="{{ route('testimoni-user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">

                    <div class="form-group mb-3">
                        <label for="page_id">Page ID <span class="text-danger">*</span></label>
                        <select name="page_id" class="form-control js-example-basic-single" id="page_id" data-placeholder="Select Page ID" required>
                        <option value=""></option>
                            @foreach ($page as $row)
                                <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                        @error('page_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <!-- Menampilkan nama lengkap pengguna yang sedang login -->
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}" readonly>
                        <!-- Menyimpan id_user sebagai nilai tersembunyi -->
                        <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id_user }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <!-- Menampilkan email pengguna yang sedang login -->
                        <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" required>
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                        <select class="form-control" name="rating" id="rating" data-placeholder="Pilih Rating" required>
                            <option value="" disabled selected></option>
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
{{-- modal edit --}}
@foreach ($testimoni as $row)
 <div class="modal modal-lg fade" id="edit{{ $row->id_testimoni }}" tabindex="-1" aria-labelledby="edit{{ $row->id_testimoni }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Edit Testimoni</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('testimoni-user.update', $row->id_testimoni) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">

                    <div class="form-group mb-3">
                        <label for="page_id">Page ID <span class="text-danger">*</span></label>
                        <select name="page_id" class="form-control js-example" id="page_id" data-placeholder="Pilih Page ID" required>
                        <option ></option>
                        @foreach ($page as $p)
                        <option value="{{ $p->id_page }}" {{ $row->page_id == $p->id_page ? 'selected' : '' }}>
                            {{ $p->nama_page }}
                        </option>
                            @endforeach
                        </select>
                        @error('page_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}" readonly>
                        <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id_user }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" value="{{ $row->tanggal->format('Y-m-d') }}" class="form-control" placeholder="Tanggal" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                        <select class="form-control js-example" name="rating" id="rating_edit" data-placeholder="Select Rating" required>
                            <option value="" disabled selected>Pilih Rating</option>
                            <option value="1"{{ $row->rating == 1  ? 'selected' : ''}}>1 Stars</option>
                            <option value="2" {{ $row->rating == 2 ? 'selected' : '' }}>2 Stars</option>
                            <option value="3" {{ $row->rating == 3 ? 'selected' : '' }}>3 Stars</option>
                            <option value="4" {{ $row->rating == 4 ? 'selected' : '' }}>4 Stars</option>
                            <option value="5" {{ $row->rating == 5 ? 'selected' : '' }}>5 Stars</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="isi_testimoni" class="form-label">Isi Testimoni <span class="text-danger">*</span></label>
                        <textarea class="form-control ck-editor" id="isi_testimoni" name="isi_testimoni" rows="3">{{ $row->isi_testimoni}}</textarea>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="photo" class="form-label">Foto </label>
                        <input type="file" class="form-control" name="photo" id="photo">
                    </div> --}}
                    {{-- dropzone --}}
                    <div class="form-group mb-3">
                        <label class="control-label mb-2">Upload Foto Mentor <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Pilih gambar atau seret ke sini .</p>
                            </div>
                            <input type="file" name="photo" class="dropzone" id="photo_{{ $row->id_testimoni }}" accept="image/*">
                            <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                @if($row->photo)
                                    <img id="preview_image_edit_{{ $row->id_testimoni }}" src="{{ asset($row->photo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                @else
                                    <img id="preview_image_edit_{{ $row->id_testimoni }}" src="" alt="No image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
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

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Publikasi</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $row->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">
                                {{ $row->status ? 'Published' : 'Unpublished' }}
                            </label>
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
@endforeach

@endsection
@push('script')

<script>
    $(document).ready(function() {
        // Initialize Select2 for elements with class js-example-basic
        $('.js-example-basic').select2({
            placeholder: "Select an option", // Replace with your actual placeholder text
            allowClear: true,
            minimumResultsForSearch: Infinity
        });

        // Handle the modal showing event
        $('[id^=edit]').on('shown.bs.modal', function() {
            // Initialize Select2 for the elements inside the opened modal
            $(this).find('.js-example').select2({
                placeholder: "Select an option", // Replace with your actual placeholder text
                allowClear: true,
                minimumResultsForSearch: Infinity
            });
            $(this).find('#rating_edit').select2({
                placeholder: "Select an option", // Replace with your actual placeholder text
                allowClear: true,
                templateResult: formatState,
                templateSelection: formatState,
                minimumResultsForSearch: Infinity
            });
        });
        function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $(
            '<span><i class="fa fa-star text-warning"></i> ' + state.text + '</span>'
        );
        return $state;
    }
    });
  </script>




{{-- form --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#addForm');

        // Initialize CKEditor
        CKEDITOR.replace('isi_testimoni');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Update CKEditor data before sending
            if (CKEDITOR.instances['isi_testimoni']) {
                CKEDITOR.instances['isi_testimoni'].updateElement();
            }

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Optionally, you can redirect to a different page or refresh
                        window.location.reload(); // Reload the page
                    });
                } else {
                    console.error('Kesalahan Validasi dari Server:', data.errors);
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Ada yang salah.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Ada yang salah.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
</script> --}}


{{-- alert success --}}
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
{{-- alert eror --}}
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
{{-- dropzone craete --}}
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
        url: "/testimoni-user", // URL server untuk unggahan
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
{{-- get nama --}}
<script>
    document.getElementById('id_user').addEventListener('change', function() {
        var userId = this.value;

        if (userId) {
            fetch(`{{ route('getEmail', '') }}/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.email) {
                        document.getElementById('email').value = data.email;
                    } else {
                        document.getElementById('email').value = '';
                    }
                })
                .catch(() => {
                    document.getElementById('email').value = '';
                });
        } else {
            document.getElementById('email').value = '';
        }
    });
</script>
{{-- alert delete --}}
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
                document.getElementById('deleteForm-user' + testimoniId).submit();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        // Menargetkan semua dropdown di modal Tambah, baik yang punya kelas khusus maupun tidak
        const addModalSelects = $('#add .js-example-basic-single, #add select[name="rating"]');

        // [Workaround] Perbaikan HTML untuk placeholder
        addModalSelects.each(function() {
            $(this).find('option[disabled][selected]').remove();
            if ($(this).find('option[value=""]').length === 0) {
                 $(this).prepend('<option value=""></option>');
            }
            $(this).val('').trigger('change');
        });
        
        // Inisialisasi Select2 untuk semua elemen yang kita targetkan
        addModalSelects.each(function() {
            var placeholder = $(this).data('placeholder');
            var parentModal = $(this).closest('.modal');
            var selectName = $(this).attr('name');

            var selectOptions = {
                placeholder: placeholder,
                allowClear: true,
                theme: "bootstrap-5",
                dropdownParent: parentModal 
            };

            // Menyembunyikan kotak pencarian untuk dropdown 'rating'
            if (selectName === 'rating') {
                selectOptions.minimumResultsForSearch = Infinity;
            }

            $(this).select2(selectOptions);
        });

        // Mengatur placeholder dinamis untuk KOTAK PENCARIAN
        addModalSelects.on('select2:open', function(e) {
            var name = $(this).attr('name');
            var placeholderText = 'Cari...';

            if (name === 'page_id') {
                placeholderText = 'Cari Page...';
            }
            
            var searchField = document.querySelector('.select2-search__field');
            if (searchField) {
                searchField.placeholder = placeholderText;
            }
        });
        
        // Note: Skrip untuk Edit modal tidak diperlukan karena field-nya disabled (read-only)
    });
</script>
@endpush

