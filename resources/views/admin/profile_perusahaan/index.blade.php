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
}

.header h1 {
    font-size: 2.5rem;
    margin-bottom: 30px;
} */

/* .profile__grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.profile-item {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    padding: 20px;
    max-width: 100%;
    max-height: 80vh;
    text-align: center;
    width: 100%;
    max-width: 600px;
}

/* .profile-image {
    display: block;
    max-width: 100%;
    max-height: 60vh;
    margin: 0 auto;
    object-fit: contain;
    margin-bottom: 20px;
} */

/* .profile-details {
    text-align: left;
    font-size: 1rem;
    line-height: 1.5;
} */


</style>
@endpush

<h1>Profil Perusahaan</h1>

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
                            <th scope="col">Struktur Organisasi</th>
                            <th scope="col">Visi</th>
                            <th scope="col">Misi</th>
                            <th scope="col">Sejarah</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="" style="vertical-align: middle">
                        @foreach ($profil as $row)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                                <td>{{ $row->tentang_kami }}</td>
                                <td>
                                    @if ($row->path_struktur_organisasi)
                                        <img src="{{ asset('storage/' . $row->path_struktur_organisasi) }}" alt="Struktur Organisasi" style="max-width: 150px; height: auto;">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $row->visi }}</td>
                                <td>{{ $row->misi }}</td>
                                <td>{{ $row->sejarah }}</td>
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
                    <p><strong>Tentang Kami:</strong> {{ $profile->tentang_kami }}</p>
                    <p><strong>Visi:</strong> {{ $profile->visi }}</p>
                    <p><strong>Misi:</strong> {{ $profile->misi }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>






<!-- Insert Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Tambah Profil</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profil.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">

                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID</label>
                        <select class="form-select" name="page_id" aria-label="Default select example" required>
                            <option selected>Pilih ...</option>
                            @foreach ($page as $row)
                                <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tentang_kami" class="form-label">Tentang Kami</label>
                        <input type="text" class="form-control" name="tentang_kami" id="tentang_kami" required>
                    </div>
                    <div class="mb-3">
                        <label for="path_struktur_organisasi" class="form-label">Upload Struktur Organisasi Image</label>
                        <input class="form-control" name="path_struktur_organisasi" type="file" id="path_struktur_organisasi" accept=".png, .jpg, .jpeg">
                    </div>

                    <div class="mb-3">
                        <label for="visi" class="form-label">Visi</label>
                        <input type="text" class="form-control" name="visi" id="visi" required>
                    </div>
                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi</label>
                        <input type="text" class="form-control" name="misi" id="misi" required>
                    </div>
                    <div class="mb-3">
                        <label for="sejarah" class="form-label">Sejarah</label>
                        <input type="text" class="form-control" name="sejarah" id="sejarah" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="logo" class="form-label">Upload Banner</label>
                        <input class="form-control" name="logo" type="file" id="formFile"
                            accept=".png, .jpg, .jpeg" required>
                    </div> --}}
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch">
                            <label for="status" class="me-3">Status </label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status"
                                value="Publish" checked>
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
                        <label for="tentang_kami" class="form-label">Tentang Kami</label>
                        <input type="text" class="form-control" name="tentang_kami" id="tentang_kami"
                            value="{{ $row->tentang_kami }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="path_struktur_organisasi" class="form-label">Upload Struktur Organisasi Image</label>
                        <input class="form-control" name="path_struktur_organisasi" type="file" id="path_struktur_organisasi" accept=".png, .jpg, .jpeg">
                        @if ($row->path_struktur_organisasi)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $row->path_struktur_organisasi) }}" alt="Struktur Organisasi" class="img-fluid" style="max-width: 100px;">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="visi" class="form-label">Visi</label>
                        <input type="text" class="form-control" name="visi" id="visi" value="{{ $row->visi }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi</label>
                        <input type="text" class="form-control" name="misi" id="misi" value="{{ $row->misi }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="sejarah" class="form-label">Sejarah</label>
                        <input type="text" class="form-control" name="sejarah" id="sejarah" value="{{ $row->sejarah }}" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="logo" class="form-label">Upload Banner</label>
                        <input class="form-control" name="logo" type="file" id="formFile" accept=".png, .jpg, .jpeg">
                        @if($row->path_logo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $row->path_logo) }}" alt="Current Logo" class="img-fluid">
                            </div>
                        @endif
                    </div> --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input class="form-check-input" type="checkbox" id="status" name="status"
                            value="Publish" {{ $row->status == 'Publish' ? 'checked' : '' }}>
                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch">
                            <label for="status" class="me-3">Status </label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status"
                                value="Publish" {{ $row->status == 'Publish' ? 'checked' : '' }}>
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

@endsection
