@extends('layouts.panel.index')
@section('title', 'Profil Perusahaan')
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
            #preview_image_edit_ {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                display: block;
            }

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

            /* Ensure Select2 full width and bootstrap-5 appearance */
            .select2-container {
                width: 100% !important;
            }
            .select2-container--bootstrap-5 .select2-selection--single {
                height: calc(1.5em + 0.75rem + 2px) !important;
                padding: .375rem .75rem !important;
                border-radius: .375rem !important;
                border: 1px solid #ced4da !important;
            }
            .select2-selection__rendered {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                line-height: 1.5;
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
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="mt-4">
                    <div class="table-responsive">
                        <table id="example" class="table">
                            <thead class="fw-normal">
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Page Id</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="" style="vertical-align: middle">
                                @foreach ($profil as $row)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                                        <td>
                                            <button type="button"
                                                class="badge rounded-3
                                                {{ $row->status ? 'bg-success' : 'bg-danger' }}"
                                                disabled>
                                                {{ $row->status ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('profil.rincian', $row->id_profil_perusahaan) }}"
                                                    class="btn btn-primary btn-sm rounded text-white d-flex align-items-center gap-1">
                                                    <i class="fa-solid fa-code"
                                                        style="font-size: 0.75rem; color: white;"></i>
                                                    <span>Rincian</span>
                                                </a>

                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit{{ $row->id_profil_perusahaan }}"
                                                    class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
                                                    <i class="fa-regular fa-pen-to-square"
                                                        style="font-size: 0.75rem; color: white;"></i>
                                                    <span>Edit</span>
                                                </a>

                                                <form id="deleteForm{{ $row->id_profil_perusahaan }}"
                                                    action="{{ route('profil.destroy', $row->id_profil_perusahaan) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm rounded text-white d-flex align-items-center gap-1"
                                                        data-confirm-delete="true">
                                                        <i class="fa-regular fa-trash-can"
                                                            style="font-size: 0.75rem; color: white;"></i>
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
            </div>
        </div>
    </div>

    <!-- Modal HTML for Adding Profile -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="addLabel">Tambah Profil</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profil.store') }}" method="POST" enctype="multipart/form-data" id="profilForm">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">

                        <div class="mb-3 ">
                            <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                            <!-- Placeholder option supaya placeholder terlihat -->
                            <select id="page_id" class="form-select js-example-basic-single" name="page_id" data-placeholder="Pilih Page"
                                required>
                                <option value="" disabled selected hidden>Pilih Page</option>
                                @foreach ($page as $row)
                                    <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tentang_kami" class="form-label">Tentang Kami <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control ck-editor" id="tentang_kami" name="tentang_kami" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label mb-2">Upload Struktur Organisasi <span
                                    class="text-danger">*</span></label>
                            <div class="dropzone-wrapper">
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    <p>Pilih gambar atau seret ke sini .</p>
                                </div>
                                <input type="file" name="path_struktur_organisasi" id="path_struktur_organisasi_create" class="dropzone" accept="image/*"
                                    required>
                                <div id="image_preview_" class="mt-3">
                                    <img id="preview_image_create" src="" alt="Image preview"
                                        style="display: none;">
                                </div>
                            </div>
                            <div class="mt-2">
                                <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal
                                    2mb</small>
                            </div>
                            @error('foto')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="visi" class="form-label">Visi</label>
                            <textarea class="form-control ck-editor" id="visi" name="visi" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="misi" class="form-label">Misi</label>
                            <textarea class="form-control ck-editor" id="misi" name="misi" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="sejarah" class="form-label">Sejarah</label>
                            <textarea class="form-control ck-editor" id="sejarah" name="sejarah" rows="3"></textarea>
                        </div>

                        <div class="modal-footer justify-content-between mx-3">
                            <div class="form-check form-switch">
                                <label for="status" class="me-3">Status</label>
                                <input class="form-check-input" type="checkbox" id="status" name="status"
                                    value="1" {{ isset($row) && $row->status ? 'checked' : '' }}>
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger rounded-3"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML for Editing Profile -->
    @foreach ($profil as $row)
        <div class="modal modal-lg fade" id="edit{{ $row->id_profil_perusahaan }}" tabindex="-1"
            aria-labelledby="editLabel{{ $row->id_profil_perusahaan }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="editLabel{{ $row->id_profil_perusahaan }}">Edit Profil</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('profil.update', $row->id_profil_perusahaan) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">

                            <div class="mb-3">
                                <label for="page_id" class="form-label">Page ID <span
                                        class="text-danger">*</span></label>
                                <select id="edit_page_id_{{ $row->id_profil_perusahaan }}" class="form-select js-example-basic-single" name="page_id"
                                    aria-label="Default select example" data-placeholder="Pilih Page" required>
                                    <option value="" disabled hidden>Pilih Page</option>
                                    @foreach ($page as $pageOption)
                                        <option value="{{ $pageOption->id_page }}"
                                            {{ $row->page_id == $pageOption->id_page ? 'selected' : '' }}>
                                            {{ $pageOption->nama_page }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tentang_kami" class="form-label">Tentang Kami <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control ck-editor" id="tentang_kami" name="tentang_kami" rows="3">{{ old('tentang_kami', $row->tentang_kami) }}</textarea>
                            </div>
                            {{-- dropzone --}}
                            <div class="form-group mb-3">
                                <label class="control-label mb-2">Upload Struktur Organisasi <span
                                        class="text-danger">*</span></label>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Pilih gambar atau seret ke sini.</p>
                                    </div>
                                    <input type="file" name="path_struktur_organisasi" class="dropzone"
                                        id="path_struktur_organisasi_{{ $row->id_profil_perusahaan }}" accept="image/*">
                                    <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                        @if ($row->path_struktur_organisasi)
                                            <img id="preview_image_edit_{{ $row->id_profil_perusahaan }}"
                                                src="{{ asset($row->path_struktur_organisasi) }}" alt="Image preview"
                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <img id="preview_image_edit_{{ $row->id_profil_perusahaan }}" src=""
                                                alt="No image uploaded"
                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran
                                        maksimal 2mb</small>
                                </div>
                                @error('path_struktur_perusahaan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="visi" class="form-label">Visi</label>
                                <textarea class="form-control ck-editor" id="visi" name="visi" rows="3">{{ old('visi', $row->visi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="misi" class="form-label">Misi</label>
                                <textarea class="form-control ck-editor" id="misi" name="misi" rows="3">{{ old('misi', $row->misi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="sejarah" class="form-label">Sejarah</label>
                                <textarea class="form-control ck-editor" id="sejarah" name="sejarah" rows="3">{{ old('sejarah', $row->sejarah) }}</textarea>
                            </div>

                            <div class="modal-footer justify-content-between mx-3">
                                <div class="form-check form-switch">
                                    <label for="edit_status_profil_{{ $row->id_profil_perusahaan }}"
                                        class="me-3">Status</label>
                                    <input class="form-check-input" type="checkbox"
                                        id="edit_status_profil_{{ $row->id_profil_perusahaan }}" name="status"
                                        value="1" {{ $row->status ? 'checked' : '' }}>
                                    <!-- Hidden input field for unchecked status -->
                                    <input type="hidden" name="status_hidden" value="0">
                                </div>
                                <div>
                                    <button type="button" class="btn btn-danger rounded-3"
                                        data-bs-dismiss="modal">Batal</button>
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
    <!-- jQuery & Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


    <script>



    $(document).ready(function() {
        // =======================
        // INIT SELECT2 (only once)
        // =======================
        $('.js-example-basic-single').each(function() {
            var $el = $(this);
            var placeholder = $el.data('placeholder') || 'Pilih Page';
            var $parentModal = $el.closest('.modal');
            var dropdownParent = $parentModal.length ? $parentModal : $(document.body);

            $el.select2({
                theme: "bootstrap-5",  // pake tema bootstrap
                placeholder: placeholder,
                allowClear: true,
                width: '100%',
                dropdownParent: dropdownParent,
                minimumResultsForSearch: 0,
                language: {
                    noResults: function() { return 'Tidak ditemukan'; },
                    searching: function() { return 'Mencari...'; }
                }
            });

            $el.on('select2:open', function() {
                if ($parentModal.length) $parentModal.removeAttr('tabindex');
                var $container = $('.select2-container--open');
                $container.find('.select2-search__field').attr('placeholder', 'Cari Page...').focus();
            });

            $el.on('select2:close', function() {
                if ($parentModal.length) $parentModal.attr('tabindex', '-1');
            });
        });

        // =======================
        // IMAGE PREVIEW (CREATE)
        // =======================
        const inputFileCreate = document.querySelector('input#path_struktur_organisasi_create');
        const previewCreate = document.getElementById('preview_image_create');
        if (inputFileCreate && previewCreate) {
            previewCreate.style.display = 'none';
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
        document.querySelectorAll('[id^="path_struktur_organisasi_"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const parts = this.id.split('_');
                const id = parts[3] || parts[parts.length - 1];
                const preview = document.getElementById(`preview_image_edit_${id}`);
                const file = e.target.files[0];
                if (!preview) return;

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        preview.src = ev.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    });
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@endsection
