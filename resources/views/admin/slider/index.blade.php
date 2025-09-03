@extends('layouts.panel.index')
@section('title', 'Slider')

@section('content')

    @push('style')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.5.2/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
        <style>
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

            #preview_image_create,
            [id^="preview_image_edit_"] {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                display: block;
            }

            .dropzone-wrapper.dragging {
                border-color: #007bff;
            }

            .select2-container {
                width: 100% !important;
            }
            .select2-container--bootstrap-5 .select2-selection--single {
                height: calc(1.5em + 0.75rem + 2px) !important;
                padding: .375rem .75rem !important;
                border-radius: .375rem !important;
                border: 1px solid #ced4da !important;
            }

            .select2-close-mask {
                z-index: 2099 !important;
            }

            .select2-dropdown {
                z-index: 3051 !important;
            }
        </style>
    @endpush

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="table-responsive">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <tr>
                        <th>No</th>
                        <th>Page ID</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody style="vertical-align: middle">
                    @foreach ($slider as $row)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                            <td>{{ $row->title }}</td>
                            <td>{{ $row->position }}</td>
                            <td>
                                <button type="button" class="badge rounded-3 {{ $row->status ? 'bg-success' : 'bg-danger' }}" disabled>
                                    {{ $row->status ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('slider.show', $row->id_slider) }}"
                                        class="btn btn-primary btn-sm rounded text-white d-flex align-items-center gap-1">
                                        <i class="fa-solid fa-code" style="font-size: 0.75rem;"></i>
                                        <span>Rincian</span>
                                    </a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_slider }}"
                                        class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
                                        <i class="fa-regular fa-pen-to-square" style="font-size: 0.75rem;"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form id="deleteForm{{ $row->id_slider }}" action="{{ route('slider.destroy', $row->id_slider) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-danger btn-sm rounded text-white d-flex align-items-center gap-1"
                                            data-confirm-delete="true">
                                            <i class="fa-regular fa-trash-can" style="font-size: 0.75rem;"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="addLabel">Add Slider</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="page_id_create" class="form-label">Page ID <span class="text-danger">*</span></label>
                            <select id="page_id_create" class="form-select js-example-basic-single" name="page_id" data-placeholder="Pilih Page" required>
                                <option value="" disabled selected hidden>Pilih Page</option>
                                @foreach ($page as $p)
                                    <option value="{{ $p->id_page }}">{{ $p->nama_page }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control ck-editor" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label mb-2">Upload Image <span class="text-danger">*</span></label>
                            <div class="dropzone-wrapper">
                                <div class="dropzone-desc">
                                    <p>Pilih gambar atau seret ke sini.</p>
                                </div>
                                <input type="file" name="image_file" id="image_file_create" class="dropzone" accept="image/*" required>
                                <div id="image_preview_" class="mt-3">
                                    <img id="preview_image_create" src="" alt="Image preview" style="display: none;">
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-danger">Format harus berupa: .jpg, .jpeg, .png dan ukuran maksimal 2MB</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                            <select class="form-select" name="position" id="position" required>
                                <option value="" disabled selected>Select Position</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" @if ($slider->pluck('position')->contains($i)) disabled style="background-color: #f8d7da;" @endif>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer justify-content-between mx-3 px-0">
                            <div class="form-check form-switch">
                                <label for="status_create" class="me-3">Status</label>
                                <input class="form-check-input" type="checkbox" id="status_create" name="status" value="1" checked>
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

    @foreach ($slider as $row)
    <div class="modal modal-lg fade" id="edit{{ $row->id_slider }}" tabindex="-1" aria-labelledby="editLabel{{ $row->id_slider }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="editLabel{{ $row->id_slider }}">Edit Slider</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('slider.update', $row->id_slider) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="page_id_edit_{{ $row->id_slider }}" class="form-label">Page ID <span class="text-danger">*</span></label>
                            <select id="page_id_edit_{{ $row->id_slider }}" class="form-select js-example-basic-single" name="page_id" data-placeholder="Pilih Page" required>
                                @foreach ($page as $p)
                                    <option value="{{ $p->id_page }}" {{ $row->page_id == $p->id_page ? 'selected' : '' }}>
                                        {{ $p->nama_page }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="{{ $row->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control ck-editor" name="description" rows="3">{{ old('description', $row->description) }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label mb-2">Upload Image</label>
                            <div class="dropzone-wrapper">
                                <div class="dropzone-desc">
                                    <p>Pilih gambar atau seret ke sini.</p>
                                </div>
                                <input type="file" name="image_file" id="image_file_edit_{{ $row->id_slider }}" class="dropzone" accept="image/*">
                                <div id="image_preview_" class="mt-3">
                                    <img id="preview_image_edit_{{ $row->id_slider }}" src="{{ asset($row->image_url) }}" alt="Image preview">
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-danger">Format harus berupa: .jpg, .jpeg, .png dan ukuran maksimal 2MB</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                            <select class="form-select" name="position" required>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}"
                                        {{ $row->position == $i ? 'selected' : '' }}
                                        @if ($slider->where('position', $i)->isNotEmpty() && $row->position != $i)
                                            disabled style="background-color: #f8d7da;"
                                        @endif
                                    >
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="modal-footer justify-content-between mx-3 px-0">
                            <div class="form-check form-switch">
                                <label for="status_edit_{{ $row->id_slider }}" class="me-3">Status</label>
                                <input class="form-check-input" type="checkbox" id="status_edit_{{ $row->id_slider }}" name="status" value="1" {{ $row->status ? 'checked' : '' }}>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
             <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

        <script>

            $(document).ready(function() {
                // =======================
                // INIT SELECT2
                // =======================
                $('.js-example-basic-single').each(function() {
                    var $el = $(this);
                    var placeholder = $el.data('placeholder') || 'Pilih Opsi';
                    var $parentModal = $el.closest('.modal');
                    var dropdownParent = $parentModal.length ? $parentModal : $(document.body);

                    $el.select2({
                        theme: "bootstrap-5",
                        placeholder: placeholder,
                        allowClear: true,
                        width: '100%',
                        dropdownParent: dropdownParent,
                    });

                    $el.on('select2:open', function() {
                        var $container = $('.select2-container--open');
                        $container.find('.select2-search__field').attr('placeholder', 'Cari...').focus();
                    });
                });

                // =======================
                // IMAGE PREVIEW (CREATE)
                // =======================
                const inputFileCreate = document.querySelector('input#image_file_create');
                const previewCreate = document.getElementById('preview_image_create');
                if (inputFileCreate && previewCreate) {
                    inputFileCreate.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(ev) {
                                previewCreate.src = ev.target.result;
                                previewCreate.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        } else {
                            previewCreate.src = '';
                            previewCreate.style.display = 'none';
                        }
                    });
                }

                // =======================
                // IMAGE PREVIEW (EDIT)
                // =======================
                document.querySelectorAll('input[id^="image_file_edit_"]').forEach(input => {
                    input.addEventListener('change', function(e) {
                        const id = this.id.split('_').pop();
                        const preview = document.getElementById(`preview_image_edit_${id}`);
                        const file = e.target.files[0];

                        if (file && preview) {
                            const reader = new FileReader();
                            reader.onload = function(ev) {
                                preview.src = ev.target.result;
                                preview.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                });

                // =======================
                // DROPZONE CLICK & DRAG
                // =======================
                 $('.dropzone-wrapper').on('click', function() {
                    $(this).find('.dropzone').click();
                });
                $('.dropzone-wrapper').on('dragover', function(e) {
                    e.preventDefault();
                    $(this).addClass('dragging');
                });
                $('.dropzone-wrapper').on('dragleave', function() {
                    $(this).removeClass('dragging');
                });
                $('.dropzone-wrapper').on('drop', function(e) {
                    e.preventDefault();
                    $(this).removeClass('dragging');
                    var files = e.originalEvent.dataTransfer.files;
                    var dropzoneInput = $(this).find('.dropzone')[0];
                    dropzoneInput.files = files;
                    $(dropzoneInput).trigger('change');
                });
            });
        </script>
        
        <script>
             @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    html: `{!! implode('<br>', $errors->all()) !!}`
                });
            @endif
        </script>
    @endpush

@endsection