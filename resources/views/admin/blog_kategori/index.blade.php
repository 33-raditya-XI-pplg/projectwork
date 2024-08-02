@extends('layouts.panel.index')
@section('title', 'Blog')
@section('content')

<h1>Blog Kategori</h1>

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="mt-4">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <tr>
                            <th>No</th>
                            <th scope="col">Blog Title</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="vertical-align: middle">
                        @foreach ($blogkategori as $row)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ \App\Models\Blog::find($row->blog_id)->judul ?? 'N/A' }}</td>
                                <td>{{ \App\Models\Kategori::find($row->kategori_id)->nama_kategori ?? 'N/A' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                           id="dropdownMenuButton{{ $row->id_blog_kategori }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_blog_kategori }}">
                                            <li>
                                                <a class="dropdown-item text-info" href="#edit" data-bs-toggle="modal"
                                                   data-bs-target="#edit{{ $row->id_blogkategori }}">
                                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('blogkategori.destroy', $row->id_blog_kategori) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa-regular fa-trash-can pe-none"></i> Delete
                                                    </button>
                                                </form>

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

<!-- Insert Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Tambah Blog Kategori</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('blogkategori.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">

                    <div class="mb-3">
                        <label for="blog_id" class="form-label">Blog ID</label>
                        <select class="form-select" name="blog_id" aria-label="Default select example" required>
                            <option selected>Pilih ...</option>
                            @foreach ($blog as $row)
                                <option value="{{ $row->id_blog }}">{{ $row->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori ID</label>
                        <select class="form-select" name="kategori_id" aria-label="Default select example" required>
                            <option selected>Pilih ...</option>
                            @foreach ($kategori as $row)
                                <option value="{{ $row->id_kategori }}">{{ $row->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer justify-content-between mx-3">
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
@foreach ($blogkategori as $row)
<div class="modal modal-lg fade" id="edit{{ $row->id_blogkategori }}" tabindex="-1" aria-labelledby="edit{{ $row->id_blogkategori }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="edit{{ $row->id_blogkategori }}Label">Edit Blog Kategori</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('blogkategori.update', ['id' => $row->id_blog_kategori]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">

                    <div class="mb-3">
                        <label for="blog_id" class="form-label">Blog ID</label>
                        <select class="form-select" name="blog_id" aria-label="Default select example" required>
                            @foreach ($blog as $element)
                                <option value="{{ $element->id_blog }}"
                                    {{ $element->id_blog == $row->blog_id ? 'selected' : '' }}>
                                    {{ $element->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori ID</label>
                        <select class="form-select" name="kategori_id" aria-label="Default select example" required>
                            @foreach ($kategori as $element)
                                <option value="{{ $element->id_kategori }}"
                                    {{ $element->id_kategori == $row->kategori_id ? 'selected' : '' }}>
                                    {{ $element->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer justify-content-between mx-3">
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
@endforeach


@endsection
