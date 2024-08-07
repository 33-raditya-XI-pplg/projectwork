@extends('layouts.panel.index')
@section('title', 'Faq')
@section('content')

<h1>Faq</h1>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>



<!-- Tabel FAQ -->
<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <table id="example" class="table">
        <thead class="fw-normal">
            <tr>
                <th>No</th>
                <th scope="col ">Page Id</th>
                <th scope="col">Pertanyaan</th>
                <th scope="col">Jawaban</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="" style="vertical-align: middle">
            @foreach ($faq as $row)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ \App\Models\Page::find($row->page_id)->nama_page }}</td>
                    <td>{{ $row->pertanyaan }}</td>
                    <td>{{ $row->jawaban }}</td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                       data-bs-target="#edit{{ $row->id_faq }}">
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
                <div class="modal modal-lg fade" id="edit{{ $row->id_faq }}" tabindex="-1" aria-labelledby="editLabel{{ $row->id_faq }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary-gradient text-white">
                                <h5 class="modal-title" id="editLabel{{ $row->id_faq }}">Edit Faq</h5>
                                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Form --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <form action="{{ route('faq.update', $row->id_faq) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                                                <div class="mb-4">
                                                    <label for="page" class="form-label">Page Id</label>
                                                    <select class="form-select" id="page_id" name="page_id">
                                                        <option selected disabled>Pilih...</option>
                                                        @foreach($page as $a)
                                                        <option value="{{ $a->id_page }}" {{ $row->page_id == $a->id_page ? 'selected' : '' }}>
                                                        {{ $a->nama_page }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pertanyaan" class="form-label">Pertanyaan</label>
                                                    <input type="text" class="form-control" name="pertanyaan"
                                                        id="pertanyaan" value="{{ $row->pertanyaan }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="jawaban{{ $row->id_faq }}" class="form-label">Jawaban</label>
                                                    <textarea class="form-control" id="jawaban{{ $row->id_faq }}" name="jawaban" rows="2">{{ $row->jawaban }}</textarea>
                                                </div>

                                                <div class="modal-footer justify-content-between mx-3">
                                                    <div class="form-check form-switch">
                                                        <label for="status{{ $row->id_faq }}" class="me-3">Status</label>
                                                        <input class="form-check-input" type="checkbox" role="switch" id="status{{ $row->id_faq }}"
                                                               name="status" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}>
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
                                {{-- End Form --}}
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
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Tambah Faq</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Form --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('faq.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                                <input type="hidden" name="password" value="faq">
                                <input type="hidden" name="level" value="faq">
                                <div class="mb-3">
                                    <label for="page_id" class="form-label">Page ID</label>
                                    <select class="form-select" name="page_id" aria-label="Default select example"
                                        required>
                                        <option selected>Pilih ...</option>
                                        @foreach ($page as $row)
                                        <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="pertanyaan" class="form-label">Pertanyaan</label>
                                    <input type="text" class="form-control" name="pertanyaan" id="pertanyaan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jawaban" class="form-label">Jawaban</label>
                                    <textarea class="form-control" id="jawaban" name="jawaban" required></textarea>
                                </div>

                                <div class="modal-footer justify-content-between mx-3">
                                    <div class="form-check form-switch mb-3">
                                        <label for="status" class="me-3">Status</label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="Aktif">
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
                {{-- End Form --}}
            </div>
        </div>
    </div>
</div>
<!-- End of Insert Modal -->

<!-- Daftar FAQ -->
<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="accordion" id="faqAccordion">
        @foreach ($faq as $index => $item)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button @if($index !== 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
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
