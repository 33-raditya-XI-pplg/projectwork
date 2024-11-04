@extends('layouts.panel.index')
@section('title', 'Partner')
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
    height: 220px;
    border: 2px dashed #ddd;
    background-color: #f9f9f9;
    position: relative;
    cursor: pointer; 
    overflow: hidden;
}

.image_preview {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%; 
    height: 100%;  
    max-width: 200px; 
    max-height: 200px; 
    overflow: hidden;
    margin: 0 auto; 
}

#preview_image_create, #preview_image_edit_ {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover; 
    display: block; 
    max-width: 200px; 
    max-height: 200px; 
}


</style>
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> --}}
<!-- Include SweetAlert2 CSS -->
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css"> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script> --}}

<!-- Include SweetAlert2 JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="mt-4">
                <div class="table-responsive">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <tr>
                                <th>No</th>
                                <th>Page Id</th>
                                <th>Nama Partner</th>
                                <th>Jenis Partner</th>
                                <th>Tanggal Bergabung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle">
                            @foreach ($partners as $partner)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $partner->page->nama_page ?? 'N/A' }}</td>
                                <td>{{ $partner->nama_partner }}</td>
                                <td>{{ $partner->jenis_partner ?? '-' }}</td>
                                <td>{{ $partner->tanggal_bergabung ? $partner->tanggal_bergabung->format('d-m-Y') : '-' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                            id="dropdownMenuButton{{ $partner->id_partner }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $partner->id_partner }}">
                                            <li>
                                                <a class="dropdown-item text-black" href="{{ route('partner.rincian', $partner->id_partner) }}">
                                                    <i class="fa-solid fa-code pe-none"></i> Rincian
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#editPartnerModal{{ $partner->id_partner }}">
                                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                                </a>
                                            </li>                                          
                                            <li>
                                                <form id="deleteForm{{ $partner->id_partner }}" action="{{ route('partner.destroy', $partner->id_partner) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('{{ $partner->id_partner }}')">
                                                        <i class="fa-regular fa-trash-can"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                    <script>
                                        function confirmDelete(partnerId) {
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
                                                    document.getElementById('deleteForm' + partnerId).submit();
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

<!-- Insert Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addPartnerLabel">Tambah Partner</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('partner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                        <select class="form-select js-example-basic-single @error('page_id') is-invalid @enderror" name="page_id" id="page_id" data-placeholder="Pilih Page" required>
                            <option disabled selected></option>
                            @foreach ($pages as $page)
                                <option value="{{ $page->id_page }}">{{ $page->nama_page }}</option>
                            @endforeach
                        </select>
                        @error('page_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_partner" class="form-label">Nama Partner <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_partner') is-invalid @enderror" name="nama_partner" id="nama_partner" value="{{ old('nama_partner') }}" required>
                        @error('nama_partner')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email_partner" class="form-label">Email Partner <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email_partner') is-invalid @enderror" name="email_partner" id="email_partner" value="{{ old('email_partner') }}" required>
                        @error('email_partner')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="telepon_partner" class="form-label">Nomor Telepon Partner <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('telepon_partner') is-invalid @enderror" name="telepon_partner" id="telepon_partner" value="{{ old('telepon_partner') }}" required>
                        @error('telepon_partner')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat_partner" class="form-label">Alamat Partner <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat_partner') is-invalid @enderror" id="alamat_partner" name="alamat_partner" rows="2" required>{{ old('alamat_partner') }}</textarea>
                        @error('alamat_partner')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_partner" class="form-label">Jenis Partner <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jenis_partner') is-invalid @enderror" name="jenis_partner" id="jenis_partner" value="{{ old('jenis_partner') }}" required>
                        @error('jenis_partner')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror" name="tanggal_bergabung" id="tanggal_bergabung" required>
                        @error('tanggal_bergabung')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label for="edit_logo_{{ $partner->id_partner }}" class="form-label">Upload Logo</label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Drag and drop a logo file here or click to choose one.</p>
                            </div>
                            <input type="file" name="logo" class="dropzone" id="edit_logo_{{ $partner->id_partner }}" accept=".png, .jpg, .jpeg" style="display: none;">
                            <div class="image_preview" id="edit_logo_preview_{{ $partner->id_partner }}" style="display: none;">
                                <img src="{{ asset('path/to/logo/' . $partner->logo) }}" id="edit_logo_image_preview_{{ $partner->id_partner }}" alt="Logo Preview" class="preview_image">
                            </div>
                        </div>
                        <small style="color: red;">Format must be: .jpg, .jpeg, .png and max size 2MB</small>
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror                   
                    </div> --}}
                    {{-- dropzone --}}
                    <div class="form-group mb-2">
                        <label class="control-label mb-2">Upload Logo <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Pilih gambar atau seret ke sini.</p>
                            </div>
                            <input type="file" name="logo" class="dropzone"  accept="image/*" required>
                            <div id="image_preview" class=" image_previe mt-3">
                                <img id="preview_image_create" src="" alt="Image preview" style="display: none;">
                            </div>
                        </div>
                        <div class="mt-2">
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2MB</small>
                        </div>
                        @error('logo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="website_partner" class="form-label">Website Partner <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('website_partner') is-invalid @enderror" name="website_partner" id="website_partner" placeholder="https://example.com" value="{{ old('website_partner') }}" required>
                        @error('website_partner')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="form-check form-switch">
                            <label for="status_partner" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" id="status_partner" name="status_partner" value="1" checked>
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


<!-- Edit Modal for each partner -->
@foreach ($partners as $partner)
        <div class="modal modal-lg fade" id="editPartnerModal{{ $partner->id_partner }}" tabindex="-1" aria-labelledby="editPartnerLabel{{ $partner->id_partner }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="editPartnerLabel{{ $partner->id_partner }}">Edit Partner</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('partner.update', $partner->id_partner) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit_page_id_{{ $partner->id_partner }}" class="form-label">Page ID</label>
                                <select class="form-select js-example-basic-single @error('page_id') is-invalid @enderror" name="page_id" id="edit_page_id_{{ $partner->id_partner }}" data-placeholder="Pilih Page" required>
                                    <option disabled selected></option>
                                    @foreach ($pages as $page)
                                    <option value="{{ $page->id_page }}" {{ old('page_id', $partner->page_id) == $page->id_page ? 'selected' : '' }}>
                                        {{ $page->nama_page }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_nama_partner_{{ $partner->id_partner }}" class="form-label">Nama Partner</label>
                                <input type="text" class="form-control @error('nama_partner') is-invalid @enderror" name="nama_partner" id="edit_nama_partner_{{ $partner->id_partner }}" value="{{ old('nama_partner', $partner->nama_partner) }}" required>
                                @error('nama_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_email_partner_{{ $partner->id_partner }}" class="form-label">Email Partner</label>
                                <input type="email" class="form-control @error('email_partner') is-invalid @enderror" name="email_partner" id="edit_email_partner_{{ $partner->id_partner }}" value="{{ old('email_partner', $partner->email_partner) }}" required>
                                @error('email_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_telepon_partner_{{ $partner->id_partner }}" class="form-label">Nomor Telepon Partner</label>
                                <input type="text" class="form-control @error('telepon_partner') is-invalid @enderror" name="telepon_partner" id="edit_telepon_partner_{{ $partner->id_partner }}" value="{{ old('telepon_partner', $partner->telepon_partner) }}">
                                @error('telepon_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_alamat_partner_{{ $partner->id_partner }}" class="form-label">Alamat Partner</label>
                                <textarea class="form-control @error('alamat_partner') is-invalid @enderror" id="edit_alamat_partner_{{ $partner->id_partner }}" name="alamat_partner" rows="2">{{ old('alamat_partner', $partner->alamat_partner) }}</textarea>
                                @error('alamat_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_jenis_partner_{{ $partner->id_partner }}" class="form-label">Jenis Partner</label>
                                <input type="text" class="form-control @error('jenis_partner') is-invalid @enderror" name="jenis_partner" id="edit_jenis_partner_{{ $partner->id_partner }}" value="{{ old('jenis_partner', $partner->jenis_partner) }}">
                                @error('jenis_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_tanggal_bergabung_{{ $partner->id_partner }}" class="form-label">Tanggal Bergabung</label>
                                <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror" name="tanggal_bergabung" id="edit_tanggal_bergabung_{{ $partner->id_partner }}" value="{{ old('tanggal_bergabung', $partner->tanggal_bergabung ? $partner->tanggal_bergabung->format('Y-m-d') : '') }}">
                                @error('tanggal_bergabung')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="edit_logo_{{ $partner->id_partner }}" class="form-label">Upload Logo</label>
                                <div class="dropzone-wrapper" style="height: 300px;">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Choose a logo file or drag it here.</p>
                                    </div>
                                    <input type="file" name="logo" class="dropzone" id="edit_logo_{{ $partner->id_partner }}" accept=".png, .jpg, .jpeg">
                                    <!-- Image preview area -->
                                    <div id="edit_logo_preview_{{ $partner->id_partner }}" class="mt-3" style="display: flex; align-items: center; justify-content: center; max-width: 300px;">
                                        @if($partner->logo)
                                        <img src="{{ asset('storage/' . $partner->logo) }}" id="edit_logo_image_preview_{{ $partner->id_partner }}" alt="Logo Preview" style="max-width: 100%;">
                                        @else
                                        <img src="" id="edit_logo_image_preview_{{ $partner->id_partner }}" alt="Logo Preview" style="max-width: 100%; display: none;">
                                        @endif
                                    </div>
                                </div>
                                @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                                {{-- dropzone --}}
                                <div class="form-group mb-2">
                                    <label class="control-label mb-2">Upload Logo  <span class="text-danger">*</span></label>
                                    <div class="dropzone-wrapper">
                                        <div class="dropzone-desc">
                                            <i class="glyphicon glyphicon-download-alt"></i>
                                            <p>Pilih gambar atau seret ke sini .</p>
                                        </div>
                                        <input type="file" name="logo" class="dropzone" id="logo_{{ $partner->id_partner }}" accept="image/*">
                                        <div id="image_preview_{{ $partner->id_partner }}" class=" image_preview mt-3 d-flex justify-content-center">
                                            @if($partner->logo)
                                                <img id="preview_image_edit_{{ $partner->id_partner }}" src="{{ asset($partner->logo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                            @else
                                                <img id="preview_image_edit_{{ $partner->id_partner }}" src="" alt="No image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
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
                                    <label for="edit_website_partner_{{ $partner->id_partner }}" class="form-label">Website Partner</label>
                                    <input type="url" class="form-control @error('website_partner') is-invalid @enderror" name="website_partner" id="edit_website_partner_{{ $partner->id_partner }}" value="{{ old('website_partner', $partner->website_partner) }}" placeholder="https://example.com">
                                    @error('website_partner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            <div class="modal-footer justify-content-between">
                                <div class="form-check form-switch">
                                    <label for="edit_status_partner_{{ $partner->id_partner }}" class="me-3">Status </label>
                                    <input class="form-check-input" type="checkbox" id="edit_status_partner_{{ $partner->id_partner }}" name="status_partner" {{ old('status_partner', $partner->status_partner) ? 'checked' : '' }}>
                                    </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger rounded-3 me-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success rounded-3">Simpan</button>
                            </div>
                        </form>                                 
            </div>
        </div>
    </div>
</div>
@endforeach

@push('script')

<!-- Include CSS Select2 -->
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            placeholder: $(this).data('placeholder'),
            allowClear: true,
            minimumResultsForSearch: Infinity // Optional: hides the search bar
        });
    });
</script>

<script>    
    document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi preview image
    const inputFile = document.querySelector('input[name="logo"]');
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
        url: "/partner", // URL server untuk unggahan
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
document.querySelectorAll('[id^="logo_"]').forEach(input => {
    input.addEventListener('change', function(event) {
        const id = this.id.split('_')[1]; 
        const preview = document.getElementById(`preview_image_edit_${id}`);
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; 
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none'; 
        }
    });
});
</script>

{{-- <!-- {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> --}}
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
    window.addEventListener('DOMContentLoaded', (event) => {
        var addModal = new bootstrap.Modal(document.getElementById('add'));
        addModal.show();
    });
</script>
@endif
@endpush

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
    document.addEventListener('DOMContentLoaded', () => {
        // Select all delete buttons inside dropdown menus
        document.querySelectorAll('.dropdown-item.text-danger').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default behavior of the button

                const form = this.closest('form'); // Find the closest form element

                if (form) {
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                } else {
                    console.error('No form found for the delete button');
                }
            });
        });
    });
</script>
@endif

@endsection