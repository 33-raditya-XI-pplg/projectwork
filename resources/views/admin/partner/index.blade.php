@extends('layouts.panel.index')
@section('title', 'Partner')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

{{-- @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

{{-- <h1>Daftar Partner</h1> --}}

<!-- Button to open modal -->
{{-- <div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPartnerModal">
        Tambah Partner
    </button>
</div> --}}
<style>
.text-right {
    text-align: right;
}

</style>

<table id="example" class="table table-striped">
    <thead class="fw-normal">
        <tr>
            <th>No</th>
            <th>Page Id</th>
            <th>Nama Partner</th>
            <th>Email Partner</th>
            <th>Nomor Telepon Partner</th>
            <th>Alamat Partner</th>
            <th>Jenis Partner</th>
            <th>Tanggal Bergabung</th>
            <th>Website</th>
            <th>Status Partner</th>
            <th>Logo</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody style="vertical-align: middle">
        @foreach ($partners as $partner)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $partner->page->nama_page ?? 'N/A' }}</td>
                <td>{{ $partner->nama_partner }}</td>
                <td>{{ $partner->email_partner }}</td>
                <td>{{ $partner->telepon_partner ?? '-' }}</td>
                <td>{{ $partner->alamat_partner ?? '-' }}</td>
                <td>{{ $partner->jenis_partner ?? '-' }}</td>
                <td>{{ $partner->tanggal_bergabung ? $partner->tanggal_bergabung->format('d-m-Y') : '-' }}</td>
                <td>
                    @if($partner->website_partner)
                        <a href="{{ $partner->website_partner }}" target="_blank" rel="noopener noreferrer">Link Website</a>
                    @else
                        <span>-</span>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn rounded-3
                        {{ $partner->status_partner == 'Aktif' ? 'btn-outline-success' : 'btn-outline-danger' }}"
                        disabled>
                        {{ $partner->status_partner == 'Aktif' ? 'Aktif' : 'Nonaktif' }}
                    </button>
                </td>



                <td>
                    @if($partner->logo)
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="Logo" width="50">
                    @else
                        <span>-</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                            id="dropdownMenuButton{{ $partner->id_partner }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $partner->id_partner }}">
                            <li>
                                <a class="dropdown-item text-info" href="#" data-bs-toggle="modal" data-bs-target="#editPartnerModal{{ $partner->id_partner }}">
                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('partner.destroy', $partner->id_partner) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this partner?');">
                                        <i class="fa-regular fa-trash-can"></i> Delete
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



{{-- logo Partner  --}}

<h2>Logo Partner</h2>
<div class="row">
    @foreach ($partners as $partner)
        <div class="col-md-4 text-center mb-4">
            @if($partner->logo)
                @if($partner->website_partner)
                    <a href="{{ $partner->website_partner }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama_partner }} Logo" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                    </a>
                @else
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama_partner }} Logo" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                @endif
            @else
                <p class="text-muted">No logo available</p>
            @endif
        </div>
    @endforeach
</div>





<!-- Insert Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addPartnerLabel">Tambah Partner</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('partner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID <span class="text-danger">*</span></label>
                        <select class="form-select @error('page_id') is-invalid @enderror" name="page_id" id="page_id" required>
                            <option value="" disabled selected>Pilih ...</option>
                            @foreach ($pages as $page)
                                <option value="{{ $page->id_page }}">{{ $page->nama_page }}</option>
                            @endforeach
                        </select>
                        @error('page_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_partner" class="form-label">Nama Partner <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_partner') is-invalid @enderror" name="nama_partner" id="nama_partner" required>
                        @error('nama_partner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email_partner" class="form-label">Email Partner <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email_partner') is-invalid @enderror" name="email_partner" id="email_partner" required>
                        @error('email_partner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="telepon_partner" class="form-label">Nomor Telepon Partner <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('telepon_partner') is-invalid @enderror" name="telepon_partner" id="telepon_partner" required>
                        @error('telepon_partner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat_partner" class="form-label">Alamat Partner <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat_partner') is-invalid @enderror" id="alamat_partner" name="alamat_partner" rows="2" required></textarea>
                        @error('alamat_partner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_partner" class="form-label">Jenis Partner <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jenis_partner') is-invalid @enderror" name="jenis_partner" id="jenis_partner" required>
                        @error('jenis_partner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror" name="tanggal_bergabung" id="tanggal_bergabung" required>
                        @error('tanggal_bergabung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Upload Logo <span class="text-danger">*</span></label>
                        <input class="form-control @error('logo') is-invalid @enderror" name="logo" type="file" id="logo" accept=".png, .jpg, .jpeg" required>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="website_partner" class="form-label">Website Partner <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('website_partner') is-invalid @enderror" name="website_partner" id="website_partner" placeholder="https://example.com" required>
                        @error('website_partner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer justify-content-between">
                        <div class="form-check form-switch">
                            <label for="status_partner" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" id="status_partner" name="status_partner" value="1" checked>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal for each partner -->
@foreach ($partners as $partner)
    <div class="modal modal-lg fade" id="editPartnerModal{{ $partner->id_partner }}" tabindex="-1" aria-labelledby="editPartnerLabel{{ $partner->id_partner }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="editPartnerLabel{{ $partner->id_partner }}">Edit Partner</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('partner.update', $partner->id_partner) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="edit_page_id_{{ $partner->id_partner }}" class="form-label">Page ID</label>
                            <select class="form-select @error('page_id') is-invalid @enderror" name="page_id" id="edit_page_id_{{ $partner->id_partner }}" required>
                                @foreach ($pages as $page)
                                    <option value="{{ $page->id_page }}" {{ $partner->page_id == $page->id_page ? 'selected' : '' }}>
                                        {{ $page->nama_page }}
                                    </option>
                                @endforeach
                            </select>
                            @error('page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_nama_partner_{{ $partner->id_partner }}" class="form-label">Nama Partner</label>
                            <input type="text" class="form-control @error('nama_partner') is-invalid @enderror" name="nama_partner" id="edit_nama_partner_{{ $partner->id_partner }}" value="{{ $partner->nama_partner }}" required>
                            @error('nama_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_email_partner_{{ $partner->id_partner }}" class="form-label">Email Partner</label>
                            <input type="email" class="form-control @error('email_partner') is-invalid @enderror" name="email_partner" id="edit_email_partner_{{ $partner->id_partner }}" value="{{ $partner->email_partner }}" required>
                            @error('email_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_telepon_partner_{{ $partner->id_partner }}" class="form-label">Nomor Telepon Partner</label>
                            <input type="text" class="form-control @error('telepon_partner') is-invalid @enderror" name="telepon_partner" id="edit_telepon_partner_{{ $partner->id_partner }}" value="{{ $partner->telepon_partner }}">
                            @error('telepon_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_alamat_partner_{{ $partner->id_partner }}" class="form-label">Alamat Partner</label>
                            <textarea class="form-control @error('alamat_partner') is-invalid @enderror" id="edit_alamat_partner_{{ $partner->id_partner }}" name="alamat_partner" rows="2">{{ $partner->alamat_partner }}</textarea>
                            @error('alamat_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_jenis_partner_{{ $partner->id_partner }}" class="form-label">Jenis Partner</label>
                            <input type="text" class="form-control @error('jenis_partner') is-invalid @enderror" name="jenis_partner" id="edit_jenis_partner_{{ $partner->id_partner }}" value="{{ $partner->jenis_partner }}">
                            @error('jenis_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_tanggal_bergabung_{{ $partner->id_partner }}" class="form-label">Tanggal Bergabung</label>
                            <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror" name="tanggal_bergabung" id="edit_tanggal_bergabung_{{ $partner->id_partner }}" value="{{ $partner->tanggal_bergabung ? $partner->tanggal_bergabung->format('Y-m-d') : '' }}">
                            @error('tanggal_bergabung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_logo_{{ $partner->id_partner }}" class="form-label">Upload Logo</label>
                            <input class="form-control @error('logo') is-invalid @enderror" name="logo" type="file" id="edit_logo_{{ $partner->id_partner }}" accept=".png, .jpg, .jpeg">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($partner->logo)
                                <div id="edit_logo_preview_{{ $partner->id_partner }}">
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="Logo" width="100">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="edit_website_partner_{{ $partner->id_partner }}" class="form-label">Website Partner</label>
                            <input type="url" class="form-control @error('website_partner') is-invalid @enderror" name="website_partner" id="edit_website_partner_{{ $partner->id_partner }}" value="{{ $partner->website_partner }}" placeholder="https://example.com">
                            @error('website_partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="modal-footer justify-content-between">
                            <div class="form-check form-switch">
                                <label for="edit_status_partner_{{ $partner->id_partner }}" class="me-3">Status </label>
                                <input class="form-check-input" type="checkbox" id="edit_status_partner_{{ $partner->id_partner }}" name="status_partner" {{ $partner->status_partner ? 'checked' : '' }}>
                            </div>


                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

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
@endpush


@endforeach

@endsection
