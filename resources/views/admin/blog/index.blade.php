@extends('layouts.panel.index')
@section('title', 'Blog')
@section('content')
<style>
  .blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.blog-card img {
    width: 100%;
    height: auto;
    border-radius: 0; /* Remove border-radius from the image */
}

.card-body {
    display: flex;
    flex-direction: column;
}


</style>
<h1>Blog</h1>

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="mt-4">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <tr>
                            <th>No</th>
                            <th scope="col">Page Name</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Body</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="vertical-align: middle">
                        @foreach ($blog as $row)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $row->page->nama_page ?? 'N/A' }}</td> <!-- Use eager loaded page relationship -->
                                <td>{{ $row->judul }}</td>
                                <td>{{ $row->slug }}</td>
                                <td>{{ Str::limit(strip_tags($row->body), 100) }}</td>
                                <td>
                                    <!-- Display the photo or a default image if not set -->
                                    <img src="{{ $row->photo ? asset('storage/photos/' . $row->photo) : asset('images/default.jpg') }}" alt="{{ $row->judul }}" style="width: 100px; height: auto;">
                                </td>
                                <td>
                                    {{ $row->kategori->nama_kategori ?? 'N/A' }}
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3" id="dropdownMenuButton{{ $row->id_blog }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_blog }}">
                                            <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_blog }}"><i class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                            <li>
                                                <form action="{{ route('blog.destroy', $row->id_blog) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-regular fa-trash-can pe-none"></i> Delete</button>
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

<div class="container my-5">
    <div class="row">
        @foreach ($blog as $post)
            <div class="col-md-4 mb-4">
                <div class="card blog-card h-100 shadow-sm">
                    <!-- Fallback to default image if photo is not set -->
                    <img src="{{ $post->photo ? asset('storage/photos/' . $post->photo) : asset('images/default.jpg') }}" class="card-img-top" alt="{{ $post->judul }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $post->judul }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags($post->body), 150) }}</p>

                        <a href="{{ route('blog.show', $post->id_blog) }}" class="btn btn-primary mt-auto">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>







<!-- Add Blog Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Tambah Blog</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                        <select class="form-select" name="page_id" aria-label="Default select example" required>
                            <option selected>Pilih ...</option>
                            @foreach ($page as $row)
                                <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" id="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Upload Photo <span class="text-danger">*</span></label>
                        <input class="form-control" name="photo" type="file" id="photo" accept=".png, .jpg, .jpeg">
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Body <span class="text-danger">*</span></label>
                        <textarea class="form-control ck-editor" id="body" name="body" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        {{-- <select class="form-select" name="page_id" aria-label="Default select example" required> --}}
                        <select class="form-select" name="kategori_id" id="kategori_id" aria-label="Default select example" required>
                            <option selected>Pilih ...</option>
                            @foreach ($kategori as $row)
                                <option value="{{ $row->id_kategori }}">{{ $row->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch">
                            <label for="status" class="me-3">Status </label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="Publish" checked>
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



@foreach ($blog as $row)
    <!-- Edit Blog Modal -->
    <div class="modal modal-lg fade" id="edit{{ $row->id_blog }}" tabindex="-1" aria-labelledby="edit{{ $row->id_blog }}Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="edit{{ $row->id_blog }}Label">Edit Blog</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('blog.update', ['id' => $row->id_blog]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                        <div class="mb-3">
                            <label for="page_id" class="form-label">Page ID</label>
                            <select class="form-select" name="page_id" aria-label="Default select example" required>
                                @foreach ($page as $element)
                                    <option value="{{ $element->id_page }}" {{ $element->id_page == $row->page_id ? 'selected' : '' }}>
                                        {{ $element->nama_page }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" id="judul" value="{{ $row->judul }}" required>
                        </div>
                        <!-- Remove slug input as it will be auto-generated -->
                        <!-- <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ $row->slug }}" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="photo" class="form-label">Upload Photo</label>
                            <input class="form-control" name="photo" type="file" id="photo" accept=".png, .jpg, .jpeg">
                            <!-- Display current photo if exists -->
                            @if($row->photo)
                                <img src="{{ asset('storage/photos/' . $row->photo) }}" alt="{{ $row->judul }}" class="img-thumbnail mt-2" style="width: 100px; height: auto;">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea class="form-control ck-editor" id="body" name="body" rows="4">{{ $row->body }}</textarea>
                        </div>
                        <div class="modal-footer justify-content-between mx-3">
                            <div class="form-check form-switch">
                                <label for="status" class="me-3">Status </label>
                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="Publish" {{ $row->status == 'Publish' ? 'checked' : '' }}>
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

@endforeach

@endsection
