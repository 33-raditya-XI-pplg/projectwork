@extends('layouts.panel.index')
@section('title', 'Faq')
@section('content')

<h1>FAQ</h1>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- FAQ Management Table -->
<div class="bg-white rounded-4 px-3 py-4 mb-5 shadow-lg">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">FAQ Management</h3>
        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">
            <i class="fa-solid fa-plus"></i> Add FAQ
        </button> --}}
    </div>
    <table id="example" class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Page Id</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
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
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3" id="dropdownMenuButton{{ $row->id_faq }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_faq }}">
                                <li>
                                    <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_faq }}">
                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('faq.destroy', $row->id_faq) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus faq ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="edit{{ $row->id_faq }}" tabindex="-1" aria-labelledby="editLabel{{ $row->id_faq }}" aria-hidden="true">
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
                                        <input type="text" class="form-control" name="pertanyaan" id="pertanyaan" value="{{ $row->pertanyaan }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jawaban" class="form-label">Jawaban</label>
                                        <textarea class="form-control" id="jawaban" name="jawaban" rows="4" required>{{ $row->jawaban }}</textarea>
                                    </div>
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status{{ $row->id_faq }}" name="status" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status{{ $row->id_faq }}">Status</label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
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

<!-- Insert Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
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
                        <label for="page_id" class="form-label">Page ID</label>
                        <select class="form-select" name="page_id" id="page_id" required>
                            <option selected disabled>Select Page...</option>
                            @foreach ($page as $row)
                                <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pertanyaan" class="form-label">Question</label>
                        <input type="text" class="form-control" name="pertanyaan" id="pertanyaan" required>
                    </div>
                    <div class="mb-3">
                        <label for="jawaban" class="form-label">Answer</label>
                        <textarea class="form-control" id="jawaban" name="jawaban" rows="4" required></textarea>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="Aktif">
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Insert Modal -->

<!-- FAQ Accordion -->
<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="accordion" id="faqAccordion">
        @foreach ($faq as $index => $item)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button @if($index !== 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                        {{ $item->pertanyaan }}
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse @if($index === 0) show @endif" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ $item->jawaban }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
