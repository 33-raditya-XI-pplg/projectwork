@extends('layouts.panel.index')
@section('title', 'Skema')
@section('content')


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th>No</th>
                    <th scope="col" class="w-75">Nama Skema</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($data as $row)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $row->nama_skema }}</td>
                            <td><button type="button" class="btn rounded-3 {{ $row->status == 'Aktif' ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>{{ $row->status }}</button>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a href="{{ route('skema.edit', $row->id_skema) }}" class="dropdown-item text-info" >
                                            <i class="fa-regular fa-pen-to-square"></i> Edit</a>
                                        </li>
                                        <li><a href="{{ route('skema.destroy', $row->id_skema) }}" class="dropdown-item text-danger" data-confirm-delete="true">
                                            <i class="fa-regular fa-trash-can pe-none"></i> Delete</a>
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
        add.style.display = '';

        add.addEventListener('click', function(event) {

            event.preventDefault();
            window.location.href = "{{ route('skema.create') }}";
        })
    </script>
@endpush
