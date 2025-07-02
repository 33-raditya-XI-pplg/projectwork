@extends('layouts.panel.index')
@section('title', 'Skema')
@section('content')


        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th>No</th>
                    <th>Page Id</th>
                    <th scope="col" class="w-75">Nama Skema</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($data as $row)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? '- '}}</td>
                            <td>{{ $row->nama_skema }}</td>
                            <td><button type="button" class="badge rounded-3 {{ $row->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}" disabled>{{ $row->status }}</button>
                            </td>
                           <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ route('skema.show', $row->id_skema) }}"
            class="btn btn-primary btn-sm rounded text-white d-flex align-items-center gap-1">
            <i class="fa-solid fa-code" style="font-size: 0.75rem; color: white;"></i>
            <span class="text-white">Rincian</span>
        </a>

        <a href="{{ route('skema.edit', $row->id_skema) }}"
            class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
            <i class="fa-regular fa-pen-to-square" style="font-size: 0.75rem; color: white;"></i>
            <span class="text-white">Edit</span>
        </a>

        <a href="{{ route('skema.destroy', $row->id_skema) }}" class="btn btn-danger btn-sm rounded text-white d-flex align-items-center gap-1" data-confirm-delete="true">
                                            <i class="fa-regular fa-trash-can pe-none"></i> Delete</a>

        </a>
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
