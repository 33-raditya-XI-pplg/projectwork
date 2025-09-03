@extends('layouts.panel.index')
@section('title', 'Faq')

@section('content')

    @push('style')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.5.2/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />
        <style>
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
                        <th>Page</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody style="vertical-align: middle">
                    @foreach ($faq as $row)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                            <td>{!! \Illuminate\Support\Str::limit(strip_tags($row->pertanyaan), 50) !!}</td>
                            <td>{!! \Illuminate\Support\Str::limit(strip_tags($row->jawaban), 50) !!}</td>
                            <td>
                                <button type="button"
                                    class="badge rounded-3 {{ $row->status ? 'bg-success' : 'bg-danger' }}" disabled>
                                    {{ $row->status ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('faq.show', $row->id_faq) }}"
                                        class="btn btn-primary btn-sm rounded text-white d-flex align-items-center gap-1">
                                        <i class="fa-solid fa-code" style="font-size: 0.75rem;"></i>
                                        <span>Rincian</span>
                                    </a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $row->id_faq }}"
                                        class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
                                        <i class="fa-regular fa-pen-to-square" style="font-size: 0.75rem;"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form id="deleteForm{{ $row->id_faq }}"
                                        action="{{ route('faq.destroy', $row->id_faq) }}" method="POST"
                                        style="display: inline;">
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
                    <h5 class="modal-title" id="addLabel">Add FAQ</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('faq.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                        <div class="mb-3">
                            <label for="page_id_create" class="form-label">Page ID <span
                                    class="text-danger">*</span></label>
                            <select id="page_id_create" class="form-select js-example-basic-single" name="page_id"
                                data-placeholder="Pilih Page" required>
                                <option value="" disabled selected hidden>Pilih Page</option>
                                @foreach ($page as $p)
                                    <option value="{{ $p->id_page }}">{{ $p->nama_page }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pertanyaan_create" class="form-label">Pertanyaan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control ck-editor" id="pertanyaan_create" name="pertanyaan" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="jawaban_create" class="form-label">Jawaban <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control ck-editor" id="jawaban_create" name="jawaban" rows="3"></textarea>
                        </div>
                        <div class="modal-footer justify-content-between mx-3 px-0">
                            <div class="form-check form-switch">
                                <label for="status_create" class="me-3">Status</label>
                                <input class="form-check-input" type="checkbox" id="status_create" name="status"
                                    value="1" checked>
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

    @foreach ($faq as $row)
        <div class="modal modal-lg fade" id="edit{{ $row->id_faq }}" tabindex="-1"
            aria-labelledby="editLabel{{ $row->id_faq }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="editLabel{{ $row->id_faq }}">Edit FAQ</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('faq.update', $row->id_faq) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                            <div class="mb-3">
                                <label for="page_id_edit_{{ $row->id_faq }}" class="form-label">Page ID <span
                                        class="text-danger">*</span></label>
                                <select id="page_id_edit_{{ $row->id_faq }}" class="form-select js-example-basic-single"
                                    name="page_id" data-placeholder="Pilih Page" required>
                                    @foreach ($page as $p)
                                        <option value="{{ $p->id_page }}"
                                            {{ $row->page_id == $p->id_page ? 'selected' : '' }}>
                                            {{ $p->nama_page }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pertanyaan_edit_{{ $row->id_faq }}" class="form-label">Pertanyaan <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control ck-editor" id="pertanyaan_edit_{{ $row->id_faq }}" name="pertanyaan" rows="3">{{ $row->pertanyaan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="jawaban_edit_{{ $row->id_faq }}" class="form-label">Jawaban <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control ck-editor" id="jawaban_edit_{{ $row->id_faq }}" name="jawaban" rows="3">{{ $row->jawaban }}</textarea>
                            </div>
                            <div class="modal-footer justify-content-between mx-3 px-0">
                                <div class="form-check form-switch">
                                    <label for="status_edit_{{ $row->id_faq }}" class="me-3">Status</label>
                                    <input class="form-check-input" type="checkbox" id="status_edit_{{ $row->id_faq }}"
                                        name="status" value="1" {{ $row->status ? 'checked' : '' }}>
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
                        $container.find('.select2-search__field').attr('placeholder', 'Cari...')
                    .focus();
                    });
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
