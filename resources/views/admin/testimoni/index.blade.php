@extends('layouts.panel.index')

@section('title', 'Testimoni')

@section('content')

    <h1>Testimoni</h1>

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
                        <tbody class="" style="vertical-align: middle">
                            @foreach ($testimoni as $row)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                                    <td>{{ $row->nama }}</td>
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
                                            <img src="{{ asset('storage/' . $row->photo) }}" alt="Testimoni Foto"
                                                class="img-thumbnail" style="max-height: 100px;">
                                        @else
                                            <p class="text-muted">No photo available</p>
                                        @endif

                                    </td>
                                    <td>{{ $row->status_publikasi ? 'Published' : 'Unpublished' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton{{ $row->id_testimoni }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $row->id_testimoni }}">
                                                <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#edit{{ $row->id_testimoni }}"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li>
                                                    <form action="{{ route('testimoni.destroy', $row->id_testimoni) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?');">
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

    {{-- Insert Modal --}}
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="addLabel">Tambah Testimoni</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="{{ route('testimoni.store') }}" method="POST"
                        enctype="multipart/form-data">
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
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" name="rating" class="form-control" placeholder="Rating"
                                min="1" max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi_testimoni" class="form-label">Isi Testimoni</label>
                            <textarea class="form-control" style="height:150px" name="isi_testimoni" placeholder="Isi Testimoni" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto</label>
                            <input type="file" class="form-control" name="photo" id="photo">
                        </div>
                        <div class="mb-3">
                            <label for="status_publikasi" class="form-label">Status Publikasi</label>
                            <select name="status_publikasi" class="form-select" required>
                                <option value="1">Published</option>
                                <option value="0">Unpublished</option>
                            </select>
                        </div>
                        <div class="modal-footer justify-content-between mx-3">
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

    <!-- Edit Modals -->
    @foreach ($testimoni as $row)
        <div class="modal modal-lg fade" id="edit{{ $row->id_testimoni }}" tabindex="-1"
            aria-labelledby="edit{{ $row->id_testimoni }}Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="edit{{ $row->id_testimoni }}Label">Edit Testimoni</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('testimoni.update', $row->id_testimoni) }}" method="POST"
                            enctype="multipart/form-data">
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
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama"
                                    value="{{ $row->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ $row->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ $row->tanggal->format('Y-m-d') }}"
                                    class="form-control" placeholder="Tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="number" name="rating" value="{{ $row->rating }}" class="form-control"
                                    placeholder="Rating" min="1" max="5" required>
                            </div>
                            <div class="mb-3">
                                <label for="isi_testimoni" class="form-label">Isi Testimoni</label>
                                <textarea class="form-control" style="height:150px" name="isi_testimoni" placeholder="Isi Testimoni" required>{{ $row->isi_testimoni }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" class="form-control" name="photo" id="photo">
                                @if ($row->photo)
                                    <img src="{{ asset('storage/' . $row->photo) }}" alt="Testimoni Foto"
                                        class="img-thumbnail mt-2" style="max-height: 100px;">
                                @endif

                            </div>
                            <div class="mb-3">
                                <label for="status_publikasi" class="form-label">Status Publikasi</label>
                                <select name="status_publikasi" class="form-select" required>
                                    <option value="1" {{ $row->status_publikasi ? 'selected' : '' }}>Published
                                    </option>
                                    <option value="0" {{ !$row->status_publikasi ? 'selected' : '' }}>Unpublished
                                    </option>
                                </select>
                            </div>
                            <div class="modal-footer justify-content-between mx-3">
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

    <!-- Testimonials Section -->
    <div class="section__container">
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

                    <p class="name">{{ $testimonial->nama }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
    </script>

@endsection
