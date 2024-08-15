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
                                <th scope="col">Tentang Kami</th>
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

<!-- Modal HTML for Adding Profile -->
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
                        <textarea class="form-control ck-editor" id="tentang_kami" name="tentang_kami" rows="3"></textarea>
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
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb
                            </small>
                        </div>
                        <div id="image_error"></div>
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

<!-- Modal HTML for Editing Profile -->
@foreach ($profil as $row)
    <div class="modal modal-lg fade" id="edit{{ $row->id_profil_perusahaan }}" tabindex="-1" aria-labelledby="editLabel{{ $row->id_profil_perusahaan }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="editLabel{{ $row->id_profil_perusahaan }}">Edit Profil</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profil.update', $row->id_profil_perusahaan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">

                        <div class="mb-3">
                            <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                            <select class="form-select" name="page_id" aria-label="Default select example" required>
                                <option value="">Pilih ...</option>
                                @foreach ($page as $pageOption)
                                    <option value="{{ $pageOption->id_page }}" {{ $row->page_id == $pageOption->id_page ? 'selected' : '' }}>
                                        {{ $pageOption->nama_page }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tentang_kami" class="form-label">Tentang Kami <span class="text-danger">*</span></label>
                            <textarea class="form-control ck-editor" id="tentang_kami" name="tentang_kami" rows="3">{{ old('tentang_kami', $row->tentang_kami) }}</textarea>
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

@push('scripts')
<script src="{{ asset('js/ckeditor.js') }}"></script>
<script>
    function initializeCKEditor() {
        const editors = document.querySelectorAll('.ck-editor');
        editors.forEach(editor => {
            if (!editor.dataset.ckeditorInitialized) {
                ClassicEditor
                    .create(editor)
                    .then(editorInstance => {
                        editor.dataset.ckeditorInitialized = true;
                    })
                    .catch(error => {
                        console.error('Error initializing CKEditor:', error);
                    });
            }
        });
    }

    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview_image').src = e.target.result;
            document.getElementById('image_preview').style.display = 'flex';
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function previewImageEdit(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview_image_edit').src = e.target.result;
            document.getElementById('image_preview_edit').style.display = 'flex';
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        initializeCKEditor();
    });

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', () => {
            initializeCKEditor();
        });

        modal.addEventListener('hidden.bs.modal', () => {
            const editors = document.querySelectorAll('.ck-editor');
            editors.forEach(editor => {
                if (editor.dataset.ckeditorInitialized) {
                    editor.dataset.ckeditorInitialized = false;
                    editor.nextSibling.innerHTML = ''; // Clear editor instance
                }
            });
        });
    });
</script>
@endpush

@endsection
