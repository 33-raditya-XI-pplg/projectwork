@extends('layouts.panel.index')
@section('title', 'Pengguna')
@section('content')


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
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
                            <td>{{ $row->nama_lengkap }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->nomor_induk }}</td>
                            <td>{{ $row->jenis_kelamin }}</td>
                            <td><button type="button" class="btn rounded-3 {{ $row->status == 'Aktif' ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>{{ $row->status }}</button>                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item text-info" href="{{ route('user.edit', $row->id_user) }}"
                                            data-bs-target="#edit{{ $row->id_user }}"><i
                                                class="fa-regular fa-pen-to-square"></i> Edit</a>
                                        </li>
                                        
                                        
                                        <li><a href="{{ route('user.destroy', $row->id_user) }}" class="dropdown-item text-danger"
                                                data-confirm-delete="true"><i class="fa-regular fa-trash-can pe-none"></i>
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

@endsection

@push('script')
    <script>
        var add = document.getElementById('add');

        add.addEventListener('click', function(event) {

            event.preventDefault();
            window.location.href = "{{ route('user.create') }}";
        })
    </script>
@endpush
