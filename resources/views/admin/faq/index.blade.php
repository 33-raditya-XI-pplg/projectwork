@extends('layouts.panel.index')
@section('title', 'Faq')
@section('content')


<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- FAQ Management Table -->
{{-- <h3 class="mb-0">FAQ</h3> --}}
<div class="bg-white rounded-4 px-3 py-4 mb-5 shadow-lg">
    <div class="d-flex justify-content-between align-items-center mb-3">

        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">
            <i class="fa-solid fa-plus"></i> Add FAQ
        </button> --}}
    </div>
    <div class="table-responsive">
    <table id="example" class="table">
        <thead class="fw-normal">
            <tr>
                <th>No</th>
                <th>Page Id</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($faq as $row)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ \App\Models\Page::find($row->page_id)->nama_page }}</td>
                    <td>{{ $row->pertanyaan }}</td>
                    <td>{{ $row->jawaban }}</td>
                    <td>
                        <button type="button" class="btn rounded-3
                            {{ $row->status === 'true' ? 'btn-outline-success' : 'btn-outline-danger' }}"
                            disabled>
                            {{ $row->status === 'true' ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                id="dropdownMenuButton{{ $row->id_faq }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_faq }}">
                                <li>
                                    <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_faq }}">
                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <form id="deleteForm{{ $row->id_faq }}" action="{{ route('faq.destroy', $row->id_faq) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('{{ $row->id_faq }}')">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                        <script>
                            function confirmDelete(faqId) {
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
                                        document.getElementById('deleteForm' + faqId).submit();
                                    }
                                });
                            }
                        </script>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal modal-lg fade" id="edit{{ $row->id_faq }}" tabindex="-1"
                    aria-labelledby="edit{{ $row->id_faq }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="editLabel{{ $row->id_faq }}">Edit FAQ</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('faq.update', $row->id_faq) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                                    <div class="mb-3">
                                        <label for="page_id" class="form-label">Page Id</label>
                                        <select class="form-select" id="page_id" name="page_id" required>
                                            @foreach($page as $a)
                                                <option value="{{ $a->id_page }}" {{ $row->page_id == $a->id_page ? 'selected' : '' }}>
                                                    {{ $a->nama_page }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pertanyaan" class="form-label">Pertanyaan</label>
                                        <textarea class="form-control ck-editor" name="pertanyaan" id="pertanyaan" rows="4" required>{{ $row->pertanyaan }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jawaban" class="form-label">Jawaban</label>
                                        <textarea class="form-control ck-editor" id="jawaban" name="jawaban" rows="4" required>{{ $row->jawaban }}</textarea>
                                    </div>
                                    <div class="modal-footer justify-content-between mx-3">
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status{{ $row->id_faq }}" name="status" value="true" {{ $row->status === 'true' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status{{ $row->id_faq }}">Status</label>
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
                <!-- End of Edit Modal -->
            @endforeach
        </tbody>
    </table>
</div>
</div>

<!-- Insert Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addLabel">Add FAQ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('faq.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">

                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                        <select class="form-select" name="page_id" id="page_id" required>
                            <option value="" disabled selected>Select Page...</option>
                            @foreach ($page as $row)
                                <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pertanyaan" class="form-label">Pertanyaan<span class="text-danger">*</span></label>
                        <textarea class="form-control ck-editor" id="pertanyaan" name="pertanyaan" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="jawaban" class="form-label">Jawaban<span class="text-danger">*</span></label>
                        <textarea class="form-control ck-editor" id="jawaban" name="jawaban" rows="3"></textarea>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="true">
                        <label class="form-check-label" for="status">Active</label>
                    </div>

                    <div class="modal-footer justify-content-end mx-3">
                        <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End of Insert Modal -->

<!-- FAQ Accordion -->
<div class="bg-light rounded-4 px-4 py-4 mb-5 shadow-lg">
    <div class="container">
        <div class="row">
            @foreach ($faq as $item)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 rounded-3 overflow-hidden shadow-lg">
                        <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                            <div class="card-front bg-primary text-white rounded-3 p-4 d-flex align-items-center justify-content-center">
                                <h5 class="mb-0">{{ $item->pertanyaan }}</h5>
                            </div>
                            <div class="card-back d-flex align-items-center justify-content-center p-4 text-dark bg-light rounded-3 position-absolute w-100 h-100">
                                <p class="mb-0">{{ $item->jawaban }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .card {
        perspective: 1000px;
        position: relative;
        overflow: hidden;
        height: 300px;
    }
    .card-body {
        position: relative;
        z-index: 1;
    }
    .card-front, .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        transition: transform 0.6s;
    }
    .card-front {
        background: linear-gradient(135deg, #007bff, #00d2ff);
    }
    .card-back {
        transform: rotateY(180deg);
    }
    .card:hover .card-front {
        transform: rotateY(180deg);
    }
    .card:hover .card-back {
        transform: rotateY(0deg);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    </script>
@endif


@endsection
