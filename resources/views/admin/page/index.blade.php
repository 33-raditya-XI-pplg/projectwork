@extends('layouts.panel.index')

@section('title', 'Page')

@section('content')
    <!-- Modal for Adding Page -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="addPageModalLabel">Tambah Page</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPageForm" method="POST" action="{{ route('page.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="pageName" class="form-label">Nama Page <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pageName" name="nama_page" required>
                        </div>
                        <div class="mb-3">
                            <label for="pageDescription" class="form-label">Deskripsi Page <span class="text-danger">*</span></label>
                            <textarea class="form-control ck-editor" id="pageDescription" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="pindah_halaman" class="form-label">Link Halaman <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" id="pindah_halaman" name="pindah_halaman" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="Aktif" checked>
                                <label class="form-check-label" for="status">
                                    Aktif
                                </label>
                            </div>

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




    <div id="pageList" class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <table class="table">
            <thead class="fw-normal">
                <tr>
                    <th>No</th>
                    <th>Nama Page</th>
                    <th>Deskripsi</th>
                    <th>Pindah Halaman</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $index => $page)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $page->nama_page }}</td>
                    <td>{{ $page->deskripsi }}</td>
                    <td>
                        @if($page->pindah_halaman)
                            <a href="{{ $page->pindah_halaman }}" class="btn btn-primary btn-sm" target="_blank">
                                Pindah Halaman
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn rounded-3
                            {{ $page->status == 'Aktif' ? 'btn-outline-success' : 'btn-outline-danger' }}"
                            disabled>
                            {{ $page->status == 'Aktif' ? 'Aktif' : 'Non-Aktif' }}
                        </button>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3" id="dropdownMenuButton{{ $page->id_page }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $page->id_page }}">
                                <li>
                                    <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#edit{{ $page->id_page }}">
                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('page.destroy', $page->id_page) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" data-confirm-delete="true">
                                            <i class="fa-regular fa-trash-can pe-none"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="edit{{ $page->id_page }}" tabindex="-1" aria-labelledby="editModalLabel{{ $page->id_page }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #007bff; color: white;">
                                <h5 class="modal-title" id="editModalLabel{{ $page->id_page }}">Edit Page</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('page.update', $page->id_page) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="nama_page_{{ $page->id_page }}" class="form-label">Nama Page</label>
                                        <input type="text" class="form-control" id="nama_page_{{ $page->id_page }}" name="nama_page" value="{{ $page->nama_page }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_{{ $page->id_page }}" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="deskripsi_{{ $page->id_page }}" name="deskripsi" required>{{ $page->deskripsi }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pindah_halaman_{{ $page->id_page }}" class="form-label">Link Halaman</label>
                                        <input type="url" class="form-control" id="pindah_halaman_{{ $page->id_page }}" name="pindah_halaman" value="{{ $page->pindah_halaman }}" required>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <label for="status_{{ $page->id_page }}" class="form-label me-3">Status</label>
                                        <input class="form-check-input" type="checkbox" id="status_{{ $page->id_page }}" name="status" value="Aktif" {{ $page->status == 'Aktif' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_{{ $page->id_page }}">
                                            {{ $page->status == 'Aktif' ? 'Aktif' : 'Non-Aktif' }}
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('pageDescription');
            @foreach($pages as $page)
                CKEDITOR.replace('deskripsi_{{ $page->id_page }}');
            @endforeach
        }

        $('#addPageForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "{{ route('page.index') }}";
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.error || 'Terjadi kesalahan.',
                    });
                }
            });
        });

        // Handle delete button confirmation
        $('button[data-confirm-delete]').on('click', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

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
@endpush
