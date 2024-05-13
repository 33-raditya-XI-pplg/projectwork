@extends('layouts.panel.index')
@section('title', 'Pengguna')
@section('content')

    <div class="d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item h5">Master Data</li>
                <li class="breadcrumb-item active h5"><a href="#">User</a></li>
            </ol>
        </nav>
        <div>
            <button type="button" class="btn btn-success rounded text-white" data-bs-toggle="modal" data-bs-target="#excel">
                Impor <i class="fa-solid fa-download"></i>
            </button>
            <a class="btn btn-primary rounded" href="{{ route('user.create') }}">Tambah <i class="fa-solid fa-user-plus"></i></a>
        </div>
    </div>


    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <table id="example" class="table">
            <thead class="fw-normal">
                <th>No</th>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Email</th>
                <th scope="col">NIK</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </thead>
            <tbody class="" style="vertical-align: middle">
                @foreach ($pengguna as $row)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $row->nama_lengkap }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->nomor_induk }}</td>
                        <td>{{ $row->jenis_kelamin }}</td>
                        <td><button type="button"
                                class="btn rounded-3 {{ $row->status == 'Aktif' ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                disabled>{{ $row->status }}</button>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item text-info" href="{{ route('user.edit', $row->id_user) }}"
                                            data-bs-target="#edit{{ $row->id_user }}"><i
                                                class="fa-regular fa-pen-to-square"></i> Edit</a>
                                    </li>


                                    <li><a href="{{ route('user.destroy', $row->id_user) }}"
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

    <!-- Modal -->
    <div class="modal fade" id="excel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Masukkan Data Peserta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control form-control-sm" name="data-peserta" type="file" accept=".xlsx">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Impor</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

{{-- @push('script')
    <script>
        var add = document.getElementById('add');
        add.style.display = '';

        add.addEventListener('click', function(event) {

            event.preventDefault();
            window.location.href = "{{ route('user.create') }}";
        })
    </script>
@endpush --}}
